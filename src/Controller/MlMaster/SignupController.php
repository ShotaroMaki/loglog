<?php
    
namespace App\Controller\MlMaster;
    
use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class SignupController extends AppController {
    
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
        public function index($shop_cd = NULL) {
            
            $this->set('title', '店舗登録');
                
            // 共通のComponentを呼び出す
            $common = new CommonComponent();
            
            $path        = "";
            $pic_nm      = [];
            
            // urlから店舗コードを取得する
            $shop_cd  = '0001';
            $shop_cd1 = $this->request->getQuery('shop_cd1');
            
            if($shop_cd1){
                // DBより店舗情報を取得
                $shop_dataW = "shop_cd = '".$shop_cd1."'";
                $shop_dataO = "shop_cd ";
                $shop_data  = $common->prGetData("mst0010",$shop_dataW,$shop_dataO);
                
            }else{
                
                $where  = "";
                $where .= " shop_cd != '0001';";
                // DBよりMAX店舗コードを取得
                $result = $common->prGetMaxValue('shop_cd','mst0010',$where);

                 
                //　結果に+1し、新店舗コード作成。
                //  $shop_cd1 = $result[0]['max']+1;
                $shop_cd1 = sprintf("%06d", $result[0]['max']+1);

                
                // 初期化する
                $shop_data = [];
                $shop_data[0]['insdatetime'] = "now()";
                $shop_data[0]['shop_nm']     = "";
                $shop_data[0]['shop_kn']     = "";
                $shop_data[0]['shop_phone']  = "";
                $shop_data[0]['shop_fax']    = "";
                $shop_data[0]['shop_postcd'] = "";
                $shop_data[0]['shop_add1']   = "";
                $shop_data[0]['shop_add2']   = "";
                $shop_data[0]['shop_add3']   = "";
                $shop_data[0]['opentime1']   = "";
                $shop_data[0]['closetime1']  = "";
                $shop_data[0]['opentime2']   = "";
                $shop_data[0]['closetime2']  = "";
                $shop_data[0]['shop_pw']     = "";
                $shop_data[0]['url_hp']      = "";
                $shop_data[0]['url_sns1']    = "";
                $shop_data[0]['url_sns2']    = "";
                $shop_data[0]['url_sns3']    = "";
                $shop_data[0]['url_sns4']    = "";
                $shop_data[0]['thumbnail1']  = "";
                $shop_data[0]['thumbnail2']  = "";
                $shop_data[0]['thumbnail3']  = "";
                $shop_data[0]['goods']       = "";
                $shop_data[0]['free_text']   = "";
                $shop_data[0]['paidmember']  = "";
                $shop_data[0]['point']  = "";
            }
            
            $this->set(compact('shop_data'));
           
            // お店の名前
            $shop_nm = $shop_data[0]['shop_nm'];
            $this->set(compact('shop_nm'));
            
            //  DBよりカテゴリマスタを取得する
            $ctgy = $common->prGetData('mst0014');
            $this->set(compact('ctgy'));
            
            //  DBよりエリアマスタを取得する
            $area = $common->prGetData("mst0015");
            $this->set(compact('area'));
            
            // 定休日を取得する
            $holiday = $common->prGetholidays();
            $this->set(compact('holiday'));

            // 会員を取得する
            $paidmembers = $common->prGetpaidmembers();
            $this->set(compact('paidmembers'));
            
            // 会員を取得する
            $point = $common->prGetpoint();
            $this->set(compact('point'));

            //画面からpostされたときのみ処理する 
            if ($this->getRequest()->is('post')) {
                
                $searchParam =  $this->getRequest()->getData();
                $this->set(compact('searchParam'));

                // 削除
                $where = " shop_cd = '".$shop_cd1."'";
                $common->prDeletedata("mst0010",$where);
                
                // 
                $phone= $this->prGetphoneData($searchParam);
                
                if(!$phone){    
                    
                    // 写真保存用のパスを設定する
                    $path = CON_IMAGE.$shop_cd1;

                    $myFiles = $this->request->getData('my_file');
                    $pic_nm  = $common->prSavePic($path,$myFiles);

                    $searchParam['thumbnail1'] = '';
                    $searchParam['thumbnail2'] = '';
                    $searchParam['thumbnail3'] = '';

                    if($pic_nm[0] != ""){
                        $j=1;
                        foreach($pic_nm as $val){
                            $searchParam['thumbnail'.$j] = $val;
                            $j++;
                        }
                    }else{
                        if($shop_data[0]['thumbnail1']){$file1 = $path.'/'.$shop_data[0]['thumbnail1'];unlink($file1);}
                        if($shop_data[0]['thumbnail2']){$file2 = $path.'/'.$shop_data[0]['thumbnail2'];unlink($file2);}
                        if($shop_data[0]['thumbnail3']){$file3 = $path.'/'.$shop_data[0]['thumbnail3'];unlink($file3);}
                    }
                    $searchParam['insuser_cd']   = $shop_cd1;
                    $searchParam['insdatetime']  = $shop_data[0]['insdatetime'];
                    $searchParam['upduser_cd']   = $shop_cd1;
                    $searchParam['updatetime']   = "now()";
                    $searchParam['shop_cd']      = $shop_cd1;
                    
                    //　登録する
                    $common->prSavedata("mst0010",$searchParam);

                    //home 画面へパラメータを持って移動する                    
                    return $this->redirect(
                     ['controller'  => '/Shoplist'
                         , 'action' => 'index'
                         , '?'      => [
                         'shop_cd'  => $shop_cd]
                     ]);
                    
                }else{
                    // NOP
                    $alert = "<script type='text/javascript'>alert('この電話番号は既に登録済みです。');</script>";
                    echo $alert;
                }
            }

        }
    // private開始
    /**
     * prGetData method.【 データ検索 】
     *
     * @return void
     */
    private function prGetshopData()
    {

        $connection = ConnectionManager::get('default');

        $sql   = "";
        $sql   .= "select ";
        $sql   .= " max(shop_cd) as shop_cd ";
        $sql   .= "from ";
        $sql   .= "mst0010 ";

        // SQLの実行
        $query = $connection->query($sql)->fetchAll('assoc');
        $this->set(compact('query'));

        return $query;
    }

    /**
     * prGetData method.【 電話番号検索 】
     *
     * @return void
     */
    private function prGetphoneData($searchParam)
    {

        $connection = ConnectionManager::get('default');

        $sql    = "";
        $sql   .= " select ";
        $sql   .= " shop_phone as shop_phone ";
        $sql   .= " from ";
        $sql   .= " mst0010 ";
        $sql   .= " where shop_phone = '".$searchParam['shop_phone']."'";

        // SQLの実行
        $query = $connection->query($sql)->fetchAll('assoc');
        $this->set(compact('query'));

        return $query;
    }
        
    }
    ?>