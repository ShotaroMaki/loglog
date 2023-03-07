<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class MsglistController extends AppController
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

        $user_cd     = $this->request->getQuery('user_cd');
        $message_Cd  = "";
        $shop_cd     = "";

         // 画面からpostされたときのみ処理する
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));

            $message_Cd = sprintf("%06d",$searchParam['message_cd']);
            $shop_cd    = sprintf("%06d",$searchParam['shop_cd']);     

            // 受信済み更新
            $where = " shop_cd='".$shop_cd."' and message_cd='".$message_Cd."' and user_cd='".$user_cd."'";
            $common->prUpdSend("mst0013",$where,'','1');

        }

        $where  = "";
        $where .= " mst0013.shop_cd     = mst0010.shop_cd ";
        $where .= " and mst0013.user_cd = '".$user_cd."' ";
        $order  = "";
        $order .= " mst0013.updatetime desc";
        $msg_data = $common->prGetDatajoin("mst0010 , mst0013 ",$where,$order);
        $this->set(compact('msg_data'));

        if(!$msg_data){
            $distinctM    = " shop_cd,msg_cd";
            $msg_data2 = $common->prGetDataDistinct("mst0013",NULL,NULL,NULL,$distinctM);

            foreach($msg_data2 as $val){
                $searchParam1['insuser_cd']      = $val['shop_cd'];
                $searchParam1['insdatetime']     = "now()";
                $searchParam1['upduser_cd']      = $val['shop_cd'];
                $searchParam1['updatetime']      = "now()";
                $searchParam1['shop_cd']         = $val['shop_cd'];
                $searchParam1['msg_cd']          = $val['msg_cd'];
                $searchParam1['msg_text']        = $val['msg_text'];
                $searchParam1['thumbnail1']      = $val['thumbnail1'];
                $searchParam1['thumbnail2']      = $val['thumbnail2'];
                $searchParam1['thumbnail3']      = $val['thumbnail3'];
                $searchParam1['user_cd']         = $user_cd;
                $searchParam1['connect_kbn']     = '0';
                $searchParam1['background']      = $val['background'];
                $searchParam1['color']           = $val['color'];
                $searchParam1['prefecture']      = $val['prefecture'];
                $searchParam1['age']             = $val['age'];
                $searchParam1['gender']          = $val['gender'];
                $searchParam1['birthday']        = $val['birthday'];
                $searchParam1['rank']            = $val['rank'];
                
                //　登録する
                $common->prSavedata("mst0013",$searchParam1); 
            }
            return $this->redirect(
            ['controller'      => '../MlMobile/Msglist'
                , 'action'     => 'index'
                , '?'          => [
                'user_cd'     => $user_cd]
            ]);            
        }
    }

}
?>
