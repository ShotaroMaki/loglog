<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class Mapshop_1Controller extends AppController 
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

    public function index($shop_cd=NULL) {

        // 共通のComponentを呼び出す
        $common = new CommonComponent();
        
        // urlからクーポンコードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');
        $user_cd = $this->request->getQuery('user_cd');
        
        $this->set(compact('user_cd'));
        
        // 登録されてる店舗情報を取得
        $where = "";
        $where .= "shop_cd = '".$shop_cd."'";
        
        $shop_data = $common->prGetData("mst0010",$where);
        $coupon_data = $common->prGetData("mst0012",$where);
        
        $this->set(compact('shop_data'));
        $this->set(compact('coupon_data'));

        // 最終来店履歴を取得
        $whereR  = "shop_cd = '".$shop_cd."'";
        $whereR .= "and user_cd = '".$user_cd."'";
        $orderR  = "raiten_time desc";
        $limitR  = " 1 ";

        $raiten = $common->prGetDataDistinct("trn0012",$whereR,$orderR,$limitR);
        $this->set(compact('raiten'));
        
    
    }
}
?>