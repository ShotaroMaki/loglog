<?php
    /**
     * @file      .loglogCouponAPI   
     * @author    SANGGI
     * @date      2023/01/13
     * @version   1.00
     * @note      Coupon Info get
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;


    class GetMst0012Controller extends AppController {
        
        /*
        * 
        *
        */
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
        
        /*
         *
         */
        public static function prGetCouponData($table=NULL,$user_cd=NULL){

            $connection = ConnectionManager::get('default');
            // 条件
        
            $sql   = "";
            $sql   .= "select";
            $sql   .= " mst0012.shop_cd, "; 
            $sql   .= " mst0010.shop_add1, "; 
            $sql   .= " mst0010.shop_add2, "; 
            $sql   .= " mst0012.coupon_cd, ";    
            $sql   .= " mst0010.shop_nm, ";    
            $sql   .= " mst0010.category_cd, ";    
            $sql   .= " mst0012.coupon_goods, ";    
            $sql   .= " mst0012.effect_srt, ";    
            $sql   .= " mst0012.effect_end, ";    
            $sql   .= " mst0012.coupon_discount, ";    
            $sql   .= " mst0012.thumbnail1, ";    
            $sql   .= " mst0012.thumbnail2, ";    
            $sql   .= " mst0012.thumbnail3, ";    
            $sql   .= " mst0012.connect_kbn, ";    
            $sql   .= " mst0012.used, ";  
            $sql   .= " mst0012.color ";               
            $sql   .= "from ".$table;
            $sql   .= " left join mst0010 on mst0012.shop_cd = mst0010.shop_cd ";
            $sql   .= " where user_cd = "."'".$user_cd."'";
            $sql   .= " and effect_end >= to_char(Now(),'YYYYMMDD') ";
            $sql   .= " order by used ASC, ";  
            $sql   .= " effect_srt DESC ";  
            
            // SQLの実行
            $query = $connection->query($sql)->fetchAll('assoc');
           
            return $query;
        }

        public function index($user_cd = null) {
            
            // 共通のComponentを呼び出す
            $common = new CommonComponent();

            $user_cd = $this->request->getQuery('user_cd');
            $shop_cd = $this->request->getQuery('shop_cd');
            $coupon_cd = $this->request->getQuery('coupon_cd');
            
            
            // Couponデータ
            $result =  $this -> prGetCouponData('mst0012',$user_cd);
           

            
            //$common->prSavedata('mst0011',$searchParam);
            
            $this->set(compact('result'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'result');
        }
    }
?>
