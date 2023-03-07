<?php

namespace App\Controller\MlMHome;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;

class MHomeController extends AppController {
    
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
        
      
        
        $this->set('title', 'ホーム');
        // urlから店舗コードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');
        
        // DBより店舗情報を取得
        $MHome_data = $this-> prGetData($shop_cd); 
        $this->set(compact('MHome_data'));
        
        //　メッセージ情報を取得
        $msg_data = $this->prGetMsgData($shop_cd);
        $this->set(compact('msg_data'));
       
        
        //　クーポン情報を取得
        $cpn_data = $this->prGetCpnData($shop_cd);
        $this->set(compact('cpn_data'));
        
        
        
        
        $searchParam['signup'] ="";
        // 画面からpostされたときのみ処理する
        if ($this->getRequest()->is('post')) {
            
            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
            
            // 登録内容変更押したとき
            if($searchParam['btn_click_name'] == CON_SEND_SET){
                // 編集画面へパラメータを持って移動する              
                return $this->redirect(
                 ['controller'  => '../MlEdit/Edit'
                     , 'action' => 'index'
                     , '?'      => [
                     'shop_cd' => $shop_cd]
                 ]);
               
            }elseif($searchParam['btn_click_name'] == CON_SEND_CPN){
                        // クーポン作成画面に遷移する
                       return $this->redirect(
                        ['controller' => '../MlCoupon/Coupon'
                            ,'action' => 'index'
                            , '?'     => [
                            'shop_cd' => $shop_cd]    
                ]);
            }elseif($searchParam['btn_click_name'] == CON_SEND_MSG){
                        // メッセージ作成画面に遷移する
                       return $this->redirect(
                        ['controller' => 
                            '../MlMessage/Message'
                            ,'action' => 'index'
                            , '?'     => [
                            'shop_cd' => $shop_cd]    
                ]);
            }
        }
    }
    // private開始
    
    /**
     * prGetData method.【 データ検索 】
     *
     * @return void
     */
    private function prGetData($shop_cd)
    {
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
        $sql   .= "mst0010 ";
        $sql   .= $where;
            
        // SQLの実行
        $query = $connection->query($sql)->fetchAll('assoc');
        $this->set(compact('query'));
        
        return $query;
    }
    /**
     * prGetData method.【 メッセージ情報 】
     *
     * @return void
     */
    private function prGetMsgData($shop_cd){
        
        $connection = ConnectionManager::get('default');
        
        // $shop_cdに画面からの検索条件をセット
        $this->set(compact('shop_cd'));
        
        $where = "";
        
        if ($shop_cd !== null){
            $where .= " where shop_cd ='".shop_cd."'"; 
        }

        $sql   = "";
        $sql   .= " select ";
        $sql   .= "  * ";
        $sql   .= " from ";
        $sql   .= " mst0013 ";
        $sql   .= " order by updatetime desc ";
        $sql   .= " limit 5 ";    
            
        // SQLの実行
        $query = $connection->query($sql)->fetchAll('assoc');
        $this->set(compact('query'));
        
        return $query;
    }
     /**
     * prGetData method.【 クーポン情報 】
     *
     * @return void
     */
    private function prGetCpnData($shop_cd){
        
        $connection = ConnectionManager::get('default');
        
        // $comp_cdに画面からの検索条件をセット
        $this->set(compact('shop_cd'));
        
        $where = "";
        
        if ($shop_cd !== null){
            $where .= " where shop_cd ='".$shop_cd."'"; 
        }

        $sql   = "";
        $sql   .= "select ";
        $sql   .= " * ";
        $sql   .= "from ";
        $sql   .= "mst0012 ";
        $sql   .= "order by updatetime desc ";
        $sql   .= "limit 5";    
        
// SQLの実行
        $query = $connection->query($sql)->fetchAll('assoc');
        $this->set(compact('query'));
        
        return $query;
    }
    
}

?>    