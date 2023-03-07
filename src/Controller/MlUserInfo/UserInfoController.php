<?php

namespace App\Controller\MlUserInfo;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;

class UserInfoController extends AppController {
    
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

    public function initialize(): void{
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
    public function index($shop_cd = null) {
        
        $this->set('title', '顧客情報');
       // urlから店舗コードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');
        
        //　顧客情報を取得
        $user_data = $this->prGetUserData($shop_cd);  //shopに来店した顧客のデータを表示
        $this->set(compact('user_data'));
               }

    /**
     * prGetData method.【 顧客情報 】
     *
     * @return void
     */
    private function prGetUserData($shop_cd){
        
        $connection = ConnectionManager::get('default');
        
        // $shop_cdに画面からの検索条件をセット
        $this->set(compact('shop_cd'));
        
        $where = "";
        
        if ($shop_cd !== null){
            $where .= " where shop_cd ='".$shop_cd."'"; 
        }

        $sql   = "";
        $sql   .= "select ";
        $sql   .= " * ";
        $sql   .= "from ";
        $sql   .= "trn0012 ";
        $sql   .= $where;
        $sql   .= "order by updatetime desc ";
        
// SQLの実行
        $query = $connection->query($sql)->fetchAll('assoc');
        $this->set(compact('query'));
        
        return $query;
    }
    
}

?>    