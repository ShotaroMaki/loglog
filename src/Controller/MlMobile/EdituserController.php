<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class EdituserController extends AppController
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
    public function index($user_cd=NULL) 
    {

        // 共通のComponentを呼び出す
        $common      = new CommonComponent();

        $user_cd     = $this->request->getQuery('user_cd');

        $msg = '';
        $this->set(compact('msg'));
        
        $years  = range(date('Y'), 1920);  
        $months = range(date('M'), 12);
        $days   = range(date('D'), 31);
        
        $this->set(compact('years'));
        $this->set(compact('months'));
        $this->set(compact('days'));
        
        // エリアマスタを取得する
        $area   = $common->prGetData("mst0015");
        $this->set(compact('area'));

        if ($this->getRequest()->is('post')) {

            // 画面パラメータ
            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
            
                // 画面上にないパラメータを準備する
                $insertParam['insuser_cd']   = $user_cd;
                $insertParam['insdatetime']  = "now()";
                $insertParam['upduser_cd']   = $user_cd;
                $insertParam['updatetime']   = "now()";
                $insertParam['user_cd']      = $user_cd;
                $insertParam['user_nm']      = $searchParam['user_nm'];
                $insertParam['user_kn']      = $searchParam['user_kn'];
                $insertParam['birthday']     = $searchParam['year'].$searchParam['month'].$searchParam['day'];
                $insertParam['gender']       = $searchParam['gender'];
                $insertParam['user_mail']    = $searchParam['user_mail'];
                $insertParam['user_pw']      = $searchParam['user_pw'];
                $insertParam['user_phone']   = $searchParam['user_phone'];
                $insertParam['connect_kbn']  = '0';
                $insertParam['add1']         = $searchParam['add1'];
                $insertParam['add2']         = $searchParam['add2'];
                $insertParam['rank']         = $searchParam['rank'];

     
                
                // 削除条件
                $where = " user_cd = '".$user_cd."'";
                // 削除
                $common->prDeletedata("mst0011",$where);
                //　登録する
                $common->prSavedata("mst0011",$insertParam);
                echo '<p style="text-align:center;color:green; padding-top:50px;">登録内容を更新しました。</p>';
        }
        $where  = "";
        $where .= " mst0011.user_cd = '".$user_cd."' ";
        
        $user_data = $common->prGetData("mst0011",$where);
        $this->set(compact('user_data'));
        
    }

}
?>