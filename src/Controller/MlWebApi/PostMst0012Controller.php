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
    use Laminas\Diactoros\Response;


    class PostMst0012Controller extends AppController {
        
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
        public static function prGetCouponData($table=NULL,$user_cd=NULL,$shop_cd=NULL,$coupon_cd=NULL){

            $connection = ConnectionManager::get('default');
            // 条件
        
            $sql   = "";
            $sql   .= "update";
            $sql   .= " mst0012 set used = '1' "; 
            $sql   .= " where user_cd = '".$user_cd."'";    
            $sql   .= " and shop_cd = '".$shop_cd."'";    
            $sql   .= " and coupon_cd = '".$coupon_cd."'";     
            
            // SQLの実行
            $query = $connection->query($sql)->fetchAll('assoc');
            return $query;
        }

        public static function cheakData ($table=NULL,$user_cd=NULL,$shop_cd=NULL,$coupon_cd=NULL){

            $connection = ConnectionManager::get('default');
            // 条件
        
            $sql   = "";
            $sql   .= " select used from mst0012 ";
            $sql   .= " where user_cd = '".$user_cd."'";    
            $sql   .= " and shop_cd = '".$shop_cd."'";    
            $sql   .= " and coupon_cd = '".$coupon_cd."'";     

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
            $result =  $this -> prGetCouponData('mst0012',$user_cd,$shop_cd,$coupon_cd);
            $result =  $this -> cheakData('mst0012',$user_cd,$shop_cd,$coupon_cd);
            
            //$common->prSavedata('mst0011',$searchParam);
            
            $this->set(compact('result'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'result');
        }
    }
?>
