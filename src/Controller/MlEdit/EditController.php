<?php
    
namespace App\Controller\MlEdit;
    
use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class EditController extends AppController {
    
    public function beforeFilter(EventInterface $event)
    {
        
        parent::beforeFilter($event);
            
        // '_cake_core_' のキャッシュを削除
        Cache::clear('_cake_core_');
            
        // 'default' のキャッシュを削除
        Cache::clear();
            
        // ajaxでPOSTするFunctionのみ許可
        $this->Security->setConfig('unlockedActions', ['ajaxShow','index']);
            
    }  
    
    public function initialize(): void
    {
        parent::initialize();

            $this->loadComponent('RequestHandler');

            $uri = $_SERVER['REQUEST_URI'];
            $this->set(compact('uri'));

            // Load the paginator component with the simple paginator strategy.
            $this->loadComponent('Paginator', [
                'paginator' => new \Cake\Datasource\SimplePaginator(),
            ]);

            $this->session = $this->getRequest()->getSession();
    }
    
    /*
     * 
     *      
     */
        public function index() {
            
            // タイトル用意
            $this->set('title', '登録内容変更');
            
            // 共通のComponentを呼び出す
            $common = new CommonComponent();
            
            $path        = "";
            $pic_nm      = [];
            $pointChecker = "";
            //$pic_nm_Pro  = [];
            
            $ERR_PHONE   = "";
            $this->set(compact('ERR_PHONE'));
            
            // urlから店舗コードを取得する
            $shop_cd = $this->request->getQuery('shop_cd');
            
            //  DBよりエリアマスタを取得する
            $area = $common->prGetData("mst0015");
            $this->set(compact('area'));
            
            // 定休日を取得する
            $holiday = $common->prGetholidays();
            $this->set(compact('holiday'));

            // DBより店舗の情報を取得する
            $shop_dataW = "shop_cd = '".$shop_cd."'";
            $shop_dataO = "shop_cd";
            $shop_data  = $common->prGetData("mst0010",$shop_dataW,$shop_dataO);
            $this->set(compact('shop_data'));
            if(!$shop_data){
                echo '【店舗情報が見つかりません。URLに間違いないか確認してください。】';
                exit();
            }
            // お店の名前
            $shop_nm = $shop_data[0]['shop_nm'];
            $this->set(compact('shop_nm'));

            if ($this->getRequest()->is('post')) {
                
                $searchParam =  $this->getRequest()->getData();
                $this->set(compact('searchParam')); 


                    
                // 写真保存用のパスを設定する           
                $path = CON_IMAGE.$shop_cd;
                //$path_Pro = CON_IMAGE_Profile.$shop_cd; //pp

                $myFiles = $this->request->getData('my_file');
                //$myFiles_Pro = $this->request->getData('my_file_Pro'); //pp

                $pic_nm  = $common->prSavePic($path,$myFiles);
                //$pic_nm_Pro  = $common->prSavePic($path_Pro,$myFiles_Pro); //pp

                $searchParam['thumbnail1'] = "";
                $searchParam['thumbnail2'] = "";
                $searchParam['thumbnail3'] = "";

                //$searchParam['profile_img'] = ""; //pp
                
                if($pic_nm[0] !== ""){
                    $j=1;
                    foreach($pic_nm as $val){
                        if($val !== "" &&  $shop_data[0]['thumbnail'.$j] !== ""){
                            $searchParam['thumbnail'.$j] = $val;
                            unlink($path.'/'.$shop_data[0]['thumbnail'.$j]);
                        }else{
                            $searchParam['thumbnail'.$j] = $val;
                        }
                        $j++;
                    }
                }
            
                // 画面上にないパラメータを準備する
                $searchParam['insuser_cd']   = $shop_cd;
                $searchParam['insdatetime']  = "now()";
                $searchParam['upduser_cd']   = $shop_cd;
                $searchParam['updatetime']   = "now()";
                $searchParam['shop_cd']      = $shop_cd;
                $searchParam['category_cd']  = $shop_data[0]['category_cd'];
                $searchParam['paidmember']   = $shop_data[0]['paidmember'];
                $searchParam['point']   = $shop_data[0]['point'];

                $searchParam['shop_group_cd']   = $shop_data[0]['shop_group_cd'];  //  from Edit 画面


                //-----------SPECIALPOINT あれば------------------------------------------
                $special_pointCD = $this->request->getData('special_point_cd');
                $pointChecker = $common->prSpecialPointCheck("mst0010",$searchParam);
                $dbPointChecker = $shop_data[0]['special_point_cd'];


               
                if($special_pointCD !== NULL){  //BOX checked
                    if($dbPointChecker == $special_pointCD){

                        //if POINTCHECKER == Special POINT そのまま
                        $searchParam['special_point_cd']   = $shop_data[0]['special_point_cd'];
                        
                    }else{
                        //if POINTCHECKER !== Special POINT 
                        //do this
                        $searchParam['special_point_cd']  = $special_pointCD;
                    }
                }else{ //BOX unchecked
                    
                    //if blank/unchecked そのまま
                    $searchParam['special_point_cd']   = $shop_data[0]['special_point_cd']; 

                }
               

                // 削除条件
                $where = " shop_cd = '".$shop_cd."'";
                // 削除
                //$common->prDeletedata("mst0010",$where);
                
                //KARL UPDATE
                $common->prUpdateEditdata("mst0010",$searchParam, $where);

                //　登録する
                //$common->prSavedata("mst0010",$searchParam);
                //　$common->prUpdSend();
                
                //home 画面へパラメータを持って移動する
                return $this->redirect(
                 ['controller'  => '../MlHome/Home'
                     , 'action' => 'index'
                     , '?'      => [
                     'shop_cd' => $shop_cd]
                 ]);
            }
        }
    }
    ?>
