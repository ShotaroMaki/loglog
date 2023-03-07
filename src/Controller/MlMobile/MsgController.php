<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class MsgController extends AppController
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
    public function index($shop_cd=NULL) 
    {

        // 共通のComponentを呼び出す
        $common      = new CommonComponent();
        
        $message_Cd  = $this->request->getQuery('msg_cd');
        $shop_cd     = $this->request->getQuery('shop_cd');
        $user_cd     = $this->request->getQuery('user_cd');
        
        // 受信済み更新
        $where  = " shop_cd='".$shop_cd."' and msg_cd='".$message_Cd."'" ;
        $where .= " and user_cd = '".$user_cd."' ";
        $common->prUpdSend("mst0013",$where,'1');
        
        
        $shop_dataW  = "shop_cd = '".$shop_cd."'";
        $shop_data   = $common->prGetData("mst0010",$shop_dataW);
        $this->set(compact('shop_data'));
     
        $where  = "";
        $where .= " mst0013.shop_cd     = '".$shop_cd."' ";
        $where .= " and mst0013.msg_cd  = '".$message_Cd."' ";
        $where .= " and mst0013.user_cd = '".$user_cd."' ";
        
        $msg_data = $common->prGetData("mst0013",$where);
        $this->set(compact('msg_data'));   
        
    }

}
?>