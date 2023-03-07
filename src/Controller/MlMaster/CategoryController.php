<?php
    
namespace App\Controller\MlMaster;
    
use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class CategoryController extends AppController {
    
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

        $this->set('title', 'カテゴリ登録');

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
        
        //画面からpostされたときのみ処理する 
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));  

            if($searchParam['btn_click_name'] == CON_SAVE_IN3){

                $ctgy_cd_bef = $this-> prGetctgyData();

                // 新カテゴリコードを作成する
                $ctgy_cd = sprintf("%02d",$ctgy_cd_bef[0]['category_cd']+1);
                $searchParam['category_cd']    = $ctgy_cd;

                //　登録する
                $common->prSavedata("mst0014",$searchParam);
            }else{
                $ctgy_cd = $searchParam['btn_click_name'];
                
                $where   = " category_cd = '".$ctgy_cd."'";
                //　登録する
                $common->prDeletedata("mst0014",$where);
            }
       }
        $category_data = $common->prGetData("mst0014");
        $this->set(compact('category_data'));       

    } 
        /**
        * prGetData method.【 カテゴリコード取得 】
        *
        * @return void
        */
       private function prGetctgyData()
       {
           $connection = ConnectionManager::get('default');

           $sql   = "";
           $sql   .= " select ";
           $sql   .= " max(category_cd) as category_cd ";
           $sql   .= " from ";
           $sql   .= " mst0014 ";
           // SQLの実行
           $query = $connection->query($sql)->fetchAll('assoc');
           $this->set(compact('query'));

           return $query;
       }
}