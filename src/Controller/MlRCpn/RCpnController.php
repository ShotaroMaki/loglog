<?php

namespace App\Controller\MlRCpn;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;

class RCpnController extends AppController {
    
    public function beforeFilter(EventInterface $event)
    {

        parent::beforeFilter($event);
        // '_cake_core_' のキャッシュを削除
        Cache::clear('_cake_core_');

        // 'default' のキャッシュを削除
        Cache::clear();

        // ajaxでPOSTするFunctionのみ許可
        $this->Security->setConfig('unlockedActions', ['ajaxShow','index']);
        
        ini_set('memory_limit', '700M');

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
  
    /*
     * 
     */
    public function index($shop_cd = null) {
        
        $this->set('title', 'クーポン送信履歴');
        
        // 共通のComponentを呼び出す
        $common = new \App\Controller\Component\MlCommon\CommonComponent();
        
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
        
        // DBよりクーポンデータを取得
        $cpn_dataW = "shop_cd = '".$shop_cd."'";
        $cpn_dataO = "updatetime desc ";
        $distinctM  = " coupon_cd ";
        $cpn_data = $common->prGetDataDistinct("mst0012",$cpn_dataW,$cpn_dataO,NULL,$distinctM);
        $this->set(compact('cpn_data'));
        
        //画面からpostされたときのみ処理する 
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $searchParam['btn_click_name'] == "";
            $this->set(compact('searchParam'));
            if(isset($searchParam['btn_click_name'])){
                if($searchParam['btn_click_name'] == CON_CREATE){

                    return $this->redirect(
                     ['controller'  => '../MlCoupon/Coupon'
                         , 'action' => 'index'
                         , '?'      => [
                         'shop_cd'  => $shop_cd]
                     ]);

                } else if($searchParam['btn_click_name'] == CON_DELETE){
                    $delshopcd = $shop_cd;
                    $delcpncd  = $searchParam['coupon_cd'];

                    $whereD  = " shop_cd = '".$delshopcd."'";
                    $whereD .= " and coupon_cd = '".$delcpncd."'";
                    $common->prDeletedata("mst0012",$whereD);
    
                    return $this->redirect(
                     ['controller'  => '../MlRCpn/RCpn'
                         , 'action' => 'index'
                         , '?'      => [
                         'shop_cd'  => $shop_cd]
                     ]);

                } else if($searchParam['btn_click_name'] == CON_UPDATE){

                    $upshopcd = $shop_cd;
                    $upcpncd  = $searchParam['coupon_cd'];

                    return $this->redirect(
                      ['controller'      => '../MlCoupon/Coupon'
                            , 'action'   => 'index'
                            , '?'        => [
                            'shop_cd'    => $upshopcd
                            ,'coupon_cd'    => $upcpncd]
                     ]);
                }
            }
        }
    }
}
  
?>    