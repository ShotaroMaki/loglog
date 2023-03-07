<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class CpnPopController extends AppController
{

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
    public function index($user_cd=NULL) {
        
        // 共通のComponentを呼び出す
        $common = new CommonComponent();
        
        // urlからクーポンコードを取得する
        $user_cd   = $this->request->getQuery('user_cd');
        $coupon_cd = $this->request->getQuery('coupon_cd');
        $shop_cd   = $this->request->getQuery('shop_cd');
        $shop_add1   = $this->request->getQuery('shop_add1');
        $shop_add2   = $this->request->getQuery('shop_add2');
        
        // 日付を取得
        $today = $common->prGetToday();
        
        // 画面からpostされたときのみ処理する
        if ($this->getRequest()->is('post')) {
            
            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
            
            // 使用済み更新
                $where = " shop_cd='".$searchParam['shop_cd']."' and coupon_cd='".$searchParam['coupon_cd']."' and user_cd='".$user_cd."'";
                $common->prUpdSend("mst0012",$where,NULL,'1');

                return $this->redirect(
                    ['controller'      => '../MlMobile/Testcpn'
                        , 'action'     => 'index'
                        , '?'          => [
                        'user_cd'     => $user_cd,
                        'shop_add1'     => $shop_add1,
                        'shop_add2'     => $shop_add2,]
                ]);


            
        }
        $where  = "";
        $where .= " mst0010.shop_cd = '".$shop_cd."'";
        $where .= " and mst0012.shop_cd = mst0010.shop_cd";
        $where .= " and mst0012.user_cd='".$user_cd."'";
        $where .= " and mst0012.coupon_cd='".$coupon_cd."'";
        $coupon_data = $common->prGetDatajoin("mst0010 , mst0012 ",$where);

        $this->set(compact('coupon_data'));

    }
    

}
?>