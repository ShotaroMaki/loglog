<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class ScheduleController extends AppController
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
    public function index($raiten_time=NULL) 
    {

        // 共通のComponentを呼び出す
        $common      = new CommonComponent();
        
        // $raiten_timeと$user_cdを取得
        $raiten_time = $this->request->getQuery('raiten_time');
        $user_cd     = $this->request->getQuery('user_cd');
        
        //　$raiten_timeを扱いやすい形に変える
        $str1        =  substr("$raiten_time", 0, 10);
        $str2        =  substr("$raiten_time", -8, 5);
        $raiten_time2 = $str1."T".$str2;
        $this->set(compact('raiten_time2'));
        
        if ($this->getRequest()->is('post')) {

            // 画面パラメータ
            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
            
            // 写真保存用のパスを設定する
            $path = CON_MEMO_IMAGE.$user_cd;
                // 画面上にないパラメータを準備する

                $searchParam['insuser_cd']   = $user_cd;
                $searchParam['insdatetime']  = "now()";
                $searchParam['upduser_cd']   = $user_cd;
                $searchParam['updatetime']   = "now()";
                $searchParam['shop_cd']      = "";
                $searchParam['shop_nm']      = "";
                $searchParam['user_cd']      = $user_cd;
                $searchParam['thumbnail1']   = "";
                $searchParam['thumbnail2']   = "";
                $searchParam['thumbnail3']   = "";
                $searchParam['connect_kbn']  = '0';

                                // 削除条件
                $where = " raiten_time = '".$raiten_time."' and user_cd ='".$user_cd."'";
                // データの有無を確認
                $trn0012 = $common->prGetData('trn0012',$where);
                
                // 削除
                if($trn0012){
                    if ($trn0012[0]['shop_cd'] != '' ) {
                       echo "<script>alert('同時刻で既に来店履歴が登録されています');</script>";
                    }else{
                        $common->prDeletedata("trn0012",$where);
                        $common->prSavedata("trn0012",$searchParam);
                        echo '<p style="text-align:center;color:green; padding-top:50px;">登録しました。</p>';
                        // 更新情報のある画面をロード      
                    return $this->redirect(
                    ['controller'      => '../MlMobile/Schedule'
                        , 'action'     => 'index'
                        , '?'          => [
                        'raiten_time'  => $searchParam['raiten_time']
                        ,'user_cd'     => $user_cd]
                    ]);
                    }
                }else{
                    $common->prSavedata("trn0012",$searchParam); 
                    echo '<p style="text-align:center;color:green; padding-top:50px;">登録しました。</p>';
                    // 更新情報のある画面をロード      
                    return $this->redirect(
                    ['controller'      => '../MlMobile/Schedule'
                        , 'action'     => 'index'
                        , '?'          => [
                        'raiten_time'  => $searchParam['raiten_time']
                        ,'user_cd'     => $user_cd]
                    ]);
                }
        }
        
        $where     = "";
        $where    .= " user_cd ='".$user_cd."'";
        $where    .= " and raiten_time ='".$raiten_time."'";
        $data   = $common->prGetData('trn0012',$where);

        if(!$data){
            $data[0]['nikki_title'] = "";
            $data[0]['nikki_text']  = "";
        }
        $this->set(compact('data'));

        
    }

}
?>