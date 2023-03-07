<?php

namespace App\Controller\MlMobile;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class TestcpnController extends AppController
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
        $user_cd = $this->request->getQuery('user_cd');
        $shop_cd = $this->request->getQuery('shop_cd');
        $shop_add1 = $this->request->getQuery('shop_add1');
        $shop_add2 = $this->request->getQuery('shop_add2');
        $shop_search = '';
        // 日付を取得
        $today = $common->prGetToday();
        $where  = " mst0012.user_cd='".$user_cd."'";
        $where_all  = " mst0012.user_cd='".$user_cd."' and mst0012.shop_cd = mst0010.shop_cd ";
        $where_all .= " and mst0012.effect_srt <= '".$today."' and mst0012.effect_end >= '".$today."'";
        $order  = "used";
        
        
        // 画面からpostされたときのみ処理する
        if ($this->getRequest()->is('post')) {
            $searchParam =  $this->getRequest()->getData();
                // エリア検索
                $where .= " and mst0012.shop_cd = mst0010.shop_cd ";
                $where .= " and (mst0010.shop_add1 || mst0010.shop_add2 || mst0010.shop_add3) ilike '%".$searchParam['search_add']."%'";
                $where .= " and mst0012.effect_srt <= '".$today."' and mst0012.effect_end >= '".$today."'";
                $coupon_data = $common->prGetDatajoin("mst0010 , mst0012 ",$where,$order);
                
                if (!$coupon_data){// クーポン取得失敗→全件取得
                    $shop_search = 'null_search_address';
                    $coupon_data = $common->prGetDatajoin("mst0010 , mst0012 ", $where_all,$order);
                }
            
        }else{
            if($shop_cd){ // mapからクーポンページに遷移shop_cdのクーポンを取得

                $where .= " and mst0010.shop_cd ='".$shop_cd."'";
                $where .= " and mst0012.shop_cd = mst0010.shop_cd ";
                $where .= " and mst0012.effect_srt <= '".$today."' and mst0012.effect_end >= '".$today."'";
;
                $coupon_data = $common->prGetDatajoin("mst0010 , mst0012 ",$where,$order);
            }else{ // 現在地のクーポン取得

                $where .= " and mst0010.shop_add2 ilike '%".$shop_add2."%'";
                $where .= " and mst0012.shop_cd = mst0010.shop_cd ";
                $where .= " and mst0012.effect_srt <= '".$today."' and mst0012.effect_end >= '".$today."'";

                $coupon_data = $common->prGetDatajoin("mst0010, mst0012 ",$where,$order);
                
                if(!$coupon_data){
                    $where1  = "";
                    $where1 .= " mst0012.user_cd='".$user_cd."'";
                    $where1 .= " and mst0010.shop_add1 ilike '%".$shop_add1."%'";
                    $where1 .= " and mst0012.shop_cd = mst0010.shop_cd ";
                    $where1 .= " and mst0012.effect_srt <= '".$today."' and mst0012.effect_end >= '".$today."'";
                    $coupon_data = $common->prGetDatajoin("mst0010, mst0012 ",$where1,$order);
                } 
            }
            if(!$coupon_data){ // 全件取得
                $coupon_data = $common->prGetDatajoin("mst0010 , mst0012 ",$where_all,$order);   
            }
            if (!$coupon_data){ // 新規会員用クーポン発行

                $cpn_dataW    = " mst0012.effect_end >= '".$today."'";
                $distinctM    = " shop_cd,coupon_cd";
                $coupon_data2 = $common->prGetDataDistinct("mst0012",$cpn_dataW,NULL,NULL,$distinctM);

                foreach($coupon_data2 as $val){

                $searchParam1['insuser_cd']      = $val['shop_cd'];
                $searchParam1['insdatetime']     = "now()";
                $searchParam1['upduser_cd']      = $val['shop_cd'];
                $searchParam1['updatetime']      = "now()";
                $searchParam1['shop_cd']         = $val['shop_cd'];
                $searchParam1['coupon_cd']       = $val['coupon_cd'];
                $searchParam1['coupon_goods']    = $val['coupon_goods'];
                $searchParam1['effect_srt']      = $val['effect_srt'];
                $searchParam1['effect_end']      = $val['effect_end'];
                $searchParam1['coupon_discount'] = $val['coupon_discount'];
                $searchParam1['thumbnail1']      = $val['thumbnail1'];
                $searchParam1['thumbnail2']      = $val['thumbnail2'];
                $searchParam1['thumbnail3']      = $val['thumbnail3'];
                $searchParam1['user_cd']         = $user_cd;
                $searchParam1['connect_kbn']     = '0';
                $searchParam1['used']            = '0';
                $searchParam1['background']      = $val['background'];
                $searchParam1['color']           = $val['color'];
                $searchParam1['prefecture']      = $val['prefecture'];
                $searchParam1['age']             = $val['age'];
                $searchParam1['gender']          = $val['gender'];
                $searchParam1['birthday']        = $val['birthday'];
                $searchParam1['rank']            = $val['rank'];

                //　登録する
                $common->prSavedata("mst0012",$searchParam1);  
                }
                return $this->redirect(
                ['controller'      => '../MlMobile/Testcpn'
                    , 'action'     => 'index'
                    , '?'          => [
                    'user_cd'     => $user_cd]
                ]);
            }
            
            

        }
        $this->set(compact('user_cd'));
        $this->set(compact('coupon_data'));
        $this->set(compact('shop_search'));  
        $this->set(compact('shop_add1'));   
        $this->set(compact('shop_add2'));   
    }
    

}
?>