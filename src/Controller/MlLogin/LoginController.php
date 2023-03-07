<?php

namespace App\Controller\MlLogin;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;

class LoginController extends AppController {
    
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
    
    public function index() {
        
        $this->set('title', 'ログイン');
        // urlから店舗コードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');
        // 初期値
        $searchParam = null;
        $ErrMsg     = "";
        $searchParam['signup'] ="";
        // 画面からpostされたときのみ処理する
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));

            if ($searchParam['login'] == CON_LOG_IN) {
                $searchParam['shop_cd'] = $shop_cd;
                // データ検索処理
                $login_data = $this-> prGetData($searchParam);
                $this->set(compact('login_data'));

                if($login_data === []){
                    $ErrMsg = $ErrMsg.CON_ERR_MSG;
                    $this->set(compact('ErrMsg'));
                }else{
                    //home 画面へパラメータを持って移動する                    
                    return $this->redirect(
                     ['controller'  => '../MlHome/Home'
                         , 'action' => 'index'
                         , '?'      => [
                         'shop_cd' => $shop_cd]
                     ]);
                }
            }
        } else {
            // NOP
        }
        $this->set(compact('ErrMsg'));
    }
    
    // private開始
    
    /**
     * prGetData method.【 データ検索 】
     *
     * @return void
     */
    private function prGetData($searchParam)
    {
        $connection = ConnectionManager::get('default');
        
        // searchParamに画面からの検索条件をセット
        $this->set(compact('searchParam'));
        
        $where = "";
        
        if ($searchParam !== null){
            $where .= " where shop_phone ='".$searchParam['login_id']."' and shop_pw ='".$searchParam['password']."' and shop_cd='".$searchParam['shop_cd']."'"; 
        }

        $sql   = "";
        $sql   .= "select ";
        $sql   .= " * ";
        $sql   .= "from ";
        $sql   .= "mst0010 ";
        $sql   .= $where;
        
        // SQLの実行
        $query = $connection->query($sql)->fetchAll('assoc');
        $this->set(compact('query'));
        
        return $query;
    }
    
}
?>