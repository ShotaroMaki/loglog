<?php
    
namespace App\Controller\MlMaster;
    
use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class CustrankController extends AppController {
    
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
    
    public function index($shop_cd = NULL) {

        $this->set('title', '顧客ランク登録');

        // 共通のComponentを呼び出す
        $common = new CommonComponent();
        
        // urlから店舗コードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');

        // DBより店舗情報を取得
        $shop_dataW = "shop_cd = '".$shop_cd."'";
        $shop_dataO = "shop_cd ";
        $shop_data  = $common->prGetData("mst0010",$shop_dataW,$shop_dataO);
        $this->set(compact('shop_data'));
        if(!$shop_data){
            echo '【店舗情報が見つかりません。URLに間違いないか確認してください。】';
            exit();
        }
        // お店の名前
        $shop_nm = $shop_data[0]['shop_nm'];
        $this->set(compact('shop_nm'));
        
        $shop_cd1  = "";
        $rank_cd1  = "";
        $rank_nm1  = "";
        $rank_data = [];
        $whereR    = "";
        $order = " shop_cd";
        
        //画面からpostされたときのみ処理する 
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));

            $shop_cd1 = $searchParam['shop_cd1'];
            $rank_cd1 = $searchParam['rank_cd1'];
            $rank_nm1 = $searchParam['rank_nm1'];
            
            $whereR .= " 1 = 1 ";
            if($shop_cd1){
                $whereR .= " and shop_cd = '".$shop_cd1."'";
            }

            if($rank_cd1){
                $whereR .= " and rank_cd = '".$rank_cd1."'";
            }

            if($rank_nm1){
                $whereR .= " and rank_nm like '%".$rank_nm1."%'";
            }

            if($searchParam['btn_click_name'] == CON_SEARCH){

                // DBより顧客ランク情報を取得
                $rank_data   = $common->prGetData("mst0016",$whereR,$order);

            }else if($searchParam['btn_click_name'] == CON_CREATE){

                return $this->redirect(
                 ['controller'  => './Custrankedit'
                     , 'action' => 'index'
                 ]);

            }else if($searchParam['btn_click_name'] == CON_DELETE){

                $delshopcd = $searchParam['shop_cd'];
                $delrankcd = $searchParam['rank_cd'];
                $whereD = " shop_cd = '".$delshopcd."' and rank_cd = '".$delrankcd."'";
                $common->prDeletedata("mst0016",$whereD);

            }else if($searchParam['btn_click_name'] == CON_UPDATE){

                $delshopcd = $searchParam['shop_cd'];
                $delrankcd = $searchParam['rank_cd'];

                return $this->redirect(
                 ['controller'  => './Custrankedit'
                     , 'action' => 'index'
                     , '?'      => [
                     'shop_cd' => $delshopcd,'rank_cd'=>$delrankcd]
                 ]);

            }

       }
       
        // DBより顧客ランク情報を取得
        $rank_data   = $common->prGetData("mst0016",$whereR,$order);
        
       $this->set(compact('rank_data'));
       $this->set(compact('shop_cd1'));
       $this->set(compact('rank_cd1'));
       $this->set(compact('rank_nm1'));
       
    }
}