<?php

namespace App\Controller\MlHome;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use App\Controller\Component\MlCommon\CommonComponent;
use Cake\Datasource\ConnectionManager;

class DashboardController extends AppController {
    
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
    
    public function index() {
        
        $this->set('title', 'ダッシュボード');
        
        // 共通のComponentを呼び出す
        $common = new CommonComponent();
        $connection = ConnectionManager::get('default');
        
        // 
        $this_year  = date('Y');
        $priv_month = date('n', strtotime('-1 month'));
        $this_month = date('n');
       
        echo date(DATE_ISO8601);
        exit;
        
        
        $sql  = "";
        $sql .= "select
                    date_part('day' , date(insdatetime)) As proc_date
                    ,count(user_cd) as count
                    from mst0011
                where date_part('year' , date(insdatetime)) >=  ".$this_year."
                and date_part('month' , date(insdatetime)) = ".$this_month."
                group by date_part('day' , date(insdatetime))
                order by date_part('day' , date(insdatetime)) ";
        
        $this_data = $connection->query($sql)->fetchAll('assoc');
        
        $sql1  = "";
        $sql1 .= "select
                    date_part('day' , date(insdatetime)) As proc_date
                    ,count(user_cd) as count
                    from mst0011
                where date_part('year' , date(insdatetime)) >=  ".$this_year."
                and date_part('month' , date(insdatetime)) = ".$priv_month."
                group by date_part('day' , date(insdatetime))
                order by date_part('day' , date(insdatetime)) ";
        
        $priv_data = $connection->query($sql1)->fetchAll('assoc');
        
        $user_datas = [];
        $priv_user  = 0;
        $this_user  = 0;
        
        for($i=0;$i<32;$i++){
            // 
            for($j=0;$j<count($priv_data);$j++){
                if($priv_data[$j]['proc_date'] = $i){
                    $user_datas[$j]['priv'] = $priv_data[$j]['count'];
                }else{
                    $user_datas[$j]['priv'] = 0;
                }
            }
            if($this_data[$i]['proc_date'] = $i){
                $user_datas[$i]['this'] = $this_data[$i]['count'];
            }else{
                $user_datas[$i]['this'] = 0;
            }
            
            
            $priv_user += $user_datas[$i]['priv'];
            $this_user += $user_datas[$i]['this'];
        }
        //print_r($shop_datas);
        $this->set(compact('this_user')); 
        $this->set(compact('priv_user')); 
        $this->set(compact('user_datas'));
        
        $sql2  = "";
        $sql2 .= "select
                    date_part('day' , date(insdatetime)) As proc_date
                    ,count(shop_cd) as count
                    from mst0010
                where date_part('year' , date(insdatetime)) >=  ".$this_year."
                and date_part('month' , date(insdatetime)) = ".$this_month."
                group by date_part('day' , date(insdatetime))
                order by date_part('day' , date(insdatetime)) ";
        
        $this_dataS = $connection->query($sql2)->fetchAll('assoc');
        
        $sql3  = "";
        $sql3 .= "select
                    date_part('day' , date(insdatetime)) As proc_date
                    ,count(shop_cd) as count
                    from mst0010
                where date_part('year' , date(insdatetime)) >=  ".$this_year."
                and date_part('month' , date(insdatetime)) = ".$priv_month."
                group by date_part('day' , date(insdatetime))
                order by date_part('day' , date(insdatetime)) ";
        
        $priv_dataS = $connection->query($sql3)->fetchAll('assoc');
        
        $shop_datas = [];
        $priv_shop  = 0;
        $this_shop  = 0;
        
        for($i=0;$i<32;$i++){
            // 
            if($priv_dataS[$i]['proc_date'] != $i){
                $priv_dataS[$i]['a'] = 0;
            }
            if($this_dataS[$i]['proc_date'] != $i){
                $this_dataS[$i]['a'] = 0;
            }
            
            
            if($priv_dataS[$i]['proc_date'] = $i){
                $shop_datas[$i]['this'] = $this_dataS[$i]['count'];
            }else{
                $shop_datas[$i]['this'] = 0;
            }
            if($priv_dataS[$i]['proc_date'] = $i){
                $shop_datas[$i]['priv'] = $priv_dataS[$i]['count'];
            }else{
                $shop_datas[$i]['priv'] = 0;
            }
            $priv_shop += $shop_datas[$i]['priv'];
            $this_shop += $shop_datas[$i]['this'];
        }
        
        $this->set(compact('this_shop')); 
        $this->set(compact('priv_shop')); 
        $this->set(compact('shop_datas'));
    }
    
}

?>    