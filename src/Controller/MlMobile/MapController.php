<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class MapController extends AppController 
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
        $shop_nm ='';
        $shop_add ='';
        $btn_click_name ='';
         //画面からpostされたときのみ処理する 
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));             

            $shop_nm   = $searchParam['search_shop'];
            $shop_add  = $searchParam['search_add'];
            $btn_click_name = $searchParam['search'];
 
            $whereR  = "";
            if($shop_nm & $shop_add){
                $whereR .= "  shop_nm ilike '%".$shop_nm."%'";
                $whereR .= " and (shop_add1 || shop_add2 || shop_add3) ilike '%".$shop_add."%'";
            }else if($shop_nm){
                $whereR .= "  shop_nm ilike '%".$shop_nm."%'";
            }else if($shop_add){
                $whereR .= "  (shop_add1 || shop_add2 || shop_add3) ilike '%".$shop_add."%'";
            }
            
            // 登録されてる店舗情報を取得
            $shop_data1 = $common->prGetData("mst0010",$whereR);

        }else{
            // 登録されてる店舗情報を取得
            $shop_data1 = $common->prGetData("mst0010");
        }
        $this->set(compact('shop_nm'));
        $this->set(compact('shop_data1'));
        $this->set(compact('btn_click_name'));
        
        // urlからメッセージコードを取得する
        $user_cd = $this->request->getQuery('user_cd');
        $this->set(compact('user_cd'));
        
        $shop_data = [];
        // 
        $i = 0;
        foreach ($shop_data1 as $val){
            
            $shop_data[$i]['count']    = 0;
            $shop_data[$i]['shop_cd']  = '';
            $shop_data[$i]['shop_nm']  = '';
            $shop_data[$i]['shop_add'] = '';
            $shop_cd = $val['shop_cd'];
            
            $rireki_data = $common->prGetrirekiData($val['shop_cd'],$user_cd);
            
            if($rireki_data){

                foreach($rireki_data as $val1){
                    
                    $shop_cdb = $val1['shop_cd'];
                    
                    if($shop_cd === $shop_cdb){
                        
                        $shop_data[$i]['count']    = $val1['count'];
                    }
                }
            }
            $shop_data[$i]['shop_cd']  = $val['shop_cd'];
            $shop_data[$i]['shop_nm']  = $val['shop_nm'];
            $shop_data[$i]['shop_add'] = $val['shop_add2'].$val['shop_add3'];
            $i++;
        }
        $this->set(compact('shop_data'));
        
    }
}
?>
