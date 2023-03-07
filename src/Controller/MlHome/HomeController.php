<?php

namespace App\Controller\MlHome;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use App\Controller\Component\MlCommon\CommonComponent;
use Cake\Datasource\ConnectionManager;

class HomeController extends AppController {
    
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
    
    public function index($shop_cd = null) {
        
        $this->set('title', 'ホーム');
        
        // 共通のComponentを呼び出す
        $common = new CommonComponent();
        
        // urlから店舗コードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');
        
        // DBより店舗の情報を取得する
        $shop_dataW = "shop_cd = '".$shop_cd."'";
        $shop_data0 = "updatetime desc ";
        $shop_data = $common->prGetData("mst0010",$shop_dataW,$shop_data0);
        $this->set(compact('shop_data'));
        if(!$shop_data){
            echo '【店舗情報が見つかりません。URLに間違いないか確認してください。】';
            exit();
        }        //　メッセージ情報を取得
        $msg_dataW = "shop_cd = '".$shop_cd."'";
        $msg_dataO = "updatetime desc ";
        $limit     = " 5 ";
        $distinctM  = " msg_cd ";
        $msg_data = $common->prGetDataDistinct("mst0013",$msg_dataW,$msg_dataO,$limit,$distinctM);
        $this->set(compact('msg_data'));
       
        //　クーポン情報を取得
        $cpn_dataW = "shop_cd = '".$shop_cd."'";
        $cpn_dataO = "updatetime desc";
        $distinctC  = " coupon_cd ";
        $cpn_data = $common->prGetDataDistinct("mst0012",$cpn_dataW,$cpn_dataO,$limit,$distinctC);
        $this->set(compact('cpn_data'));        
        //　顧客情報を取得
        $user_dataO = "updatetime desc";
        $user_data = $common->prGetData("mst0011",NULL,$user_dataO,$limit);
        $this->set(compact('user_data'));        
        // お店の名前
        $shop_nm = $shop_data[0]['shop_nm'];
        $this->set(compact('shop_nm'));

        if($shop_data[0]['shop_cd'] == '0001'){
        
            $connection = ConnectionManager::get('default');

            // 
            $this_year  = date('Y');
            $priv_month = date('n', strtotime('-1 month'));
            $this_month = date('n');


            $sql  = "";
            $sql .= "select
                        count(user_cd) as count
                        from mst0011
                    where date_part('year' , date(insdatetime)) >=  ".$this_year."
                    and date_part('month' , date(insdatetime)) = ".$this_month;

            $this_data = $connection->query($sql)->fetchAll('assoc');
            foreach($this_data as $val1){
                $Tuser_cnt = $val1['count'];
            }
            $sql1  = "";
            $sql1 .= "select
                        count(user_cd) as count
                        from mst0011
                    where date_part('year' , date(insdatetime)) >=  ".$this_year."
                    and date_part('month' , date(insdatetime)) = ".$priv_month;

            $priv_data = $connection->query($sql1)->fetchAll('assoc');
            foreach($priv_data as $val2){
                $Puser_cnt = $val2['count'];
            }
            $sql2  = "";
            $sql2 .= "select
                        count(shop_cd) as count
                        from mst0010
                    where date_part('year' , date(insdatetime)) >=  ".$this_year."
                    and date_part('month' , date(insdatetime)) = ".$this_month;

            $this_dataS = $connection->query($sql2)->fetchAll('assoc');
            foreach($this_dataS as $val3){
                $Tshop_cnt = $val3['count'];
            }
            $sql3  = "";
            $sql3 .= "select
                        count(shop_cd) as count
                        from mst0010
                    where date_part('year' , date(insdatetime)) >=  ".$this_year."
                    and date_part('month' , date(insdatetime)) = ".$priv_month;

            $priv_dataS = $connection->query($sql3)->fetchAll('assoc');
            foreach($priv_dataS as $val4){
                $Pshop_cnt = $val4['count'];
            }

            $sql4  = "";
            $sql4 .= "select
                        count(shop_cd) as count
                        from mst0010 ";

            $total_dataS = $connection->query($sql4)->fetchAll('assoc');
            foreach($total_dataS as $val5){
                $shop_cnt = $val5['count'];
            }

            $sql5  = "";
            $sql5 .= "select
                        count(user_cd) as count
                        from mst0011 ";

            $total_dataY = $connection->query($sql5)->fetchAll('assoc');
            foreach($total_dataY as $val5){
                $user_cnt = $val5['count'];
            }

            $this->set(compact('this_month')); 
            $this->set(compact('priv_month')); 
            $this->set(compact('Tuser_cnt')); 
            $this->set(compact('Puser_cnt'));
            $this->set(compact('Tshop_cnt')); 
            $this->set(compact('Pshop_cnt'));
            $this->set(compact('shop_cnt'));
            $this->set(compact('user_cnt'));
        }
    }
    
}

?>    