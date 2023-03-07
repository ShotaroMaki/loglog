<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class MemoController extends AppController
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
        
        $raiten_time = $this->request->getQuery('raiten_time');
        
        $this->set(compact('raiten_time'));
        $shop_cd     = $this->request->getQuery('shop_cd');
        $shop_nm     = "";
        $user_cd     = $this->request->getQuery('user_cd');
        
        $shop_dataW  = "shop_cd = '".$shop_cd."'";
        $shop_data   = $common->prGetData("mst0010",$shop_dataW);
        $this->set(compact('shop_data'));
        if(!$shop_data){
            echo '【店舗情報が見つかりません。URLに間違いないか確認してください。】';
            exit();
        }
        $shop_nm     = $shop_data[0]['shop_nm'];
        $this->set(compact('shop_nm'));
        
        $where  = "";
        $where .= " trn0012.raiten_time = '".$raiten_time."' ";
        $where .= " and trn0012.user_cd = '".$user_cd."' ";
        
        $memo_data = $common->prGetData("trn0012",$where);
        $this->set(compact('memo_data'));     

        // データがなかった時にエラーメッセージが出ないようにする
        if(!$memo_data){
            $memo_data[0]['raiten_time'] = "";
            $memo_data[0]['nikki_text']  = "";
            $memo_data[0]['thumbnail1']  = "";
            $memo_data[0]['thumbnail2']  = "";
            $memo_data[0]['thumbnail3']  = "";
            $memo_data[0]['shop_nm']     = "";  
        }
        
        if ($this->getRequest()->is('post')) {
            // 画面パラメータ
            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
            
            if(!$searchParam){
                echo '【選択された画像は保存できません。別の内容で登録してください。】';
                exit();  
            }
            
            // 写真保存用のパスを設定する
            $path    = CON_MEMO_IMAGE.$user_cd;
            $myFiles = $this->request->getData('my_file');
            $pic_nm  = $common->prSavePic($path,$myFiles);
            
            $searchParam['thumbnail1'] = "";
            $searchParam['thumbnail2'] = "";
            $searchParam['thumbnail3'] = "";
            
            if($pic_nm[0] != ""){
                $j=1;
                foreach($pic_nm as $val){
                    $searchParam['thumbnail'.$j] = $val;
                    $j++;
                }
            }else{
                if($memo_data[0]['thumbnail1']){$file1 = $path.'/'.$memo_data[0]['thumbnail1'];unlink($file1);}
                if($memo_data[0]['thumbnail2']){$file2 = $path.'/'.$memo_data[0]['thumbnail2'];unlink($file2);}
                if($memo_data[0]['thumbnail3']){$file3 = $path.'/'.$memo_data[0]['thumbnail3'];unlink($file3);}
            }
            
                // 画面上にないパラメータを準備する
                $searchParam['insuser_cd']   = $user_cd;
                $searchParam['insdatetime']  = "now()";
                $searchParam['upduser_cd']   = $user_cd;
                $searchParam['updatetime']   = "now()";
                $searchParam['raiten_time']  = $raiten_time;
                $searchParam['shop_cd']      = $shop_cd;
                $searchParam['shop_nm']      = $shop_nm;
                $searchParam['user_cd']      = $user_cd;
                $searchParam['nikki_title']  = "";
                $searchParam['connect_kbn']  = '0';
                // 削除条件
                $where = " raiten_time = '".$raiten_time."' and user_cd ='".$user_cd."'";
                // 削除
                $common->prDeletedata("trn0012",$where);
                //　登録する
                $common->prSavedata("trn0012",$searchParam);
                 echo '<p style="text-align:center;color:green;">登録しました。</p>';
                return $this->redirect(
                ['controller'      => '../MlMobile/memo'
                    , 'action'     => 'index'
                    , '?'          => [
                    'raiten_time'  => $raiten_time
                    ,'shop_cd'     => $shop_cd
                    ,'user_cd'     => $user_cd]
                ]); 
                 
        }


    }

}
?>