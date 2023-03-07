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


    class GetMst0013Controller extends AppController {
        
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
            $sql   .= " mst0013.shop_cd, "; 
            $sql   .= " mst0013.msg_cd, ";    
            $sql   .= " mst0013.msg_text, ";    
            $sql   .= " mst0013.thumbnail1, ";    
            $sql   .= " mst0013.thumbnail2, ";    
            $sql   .= " mst0013.thumbnail3, ";    
            $sql   .= " mst0013.connect_kbn ";    

            $sql   .= " from ".$table;
            $sql   .= " where user_cd = "."'".$user_cd."'";
            
            // SQLの実行
            $query = $connection->query($sql)->fetchAll('assoc');
           
            return $query;
        }

        public function index($user_cd = null) {
            
            // 共通のComponentを呼び出す
            $common = new CommonComponent();
            $user_cd = $this->request->getQuery('user_cd');
            
            // Couponデータ
            $result =  $this -> prGetCouponData('mst0013',$user_cd);
           
            //$common->prSavedata('mst0011',$searchParam);
            
            $this->set(compact('result'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'result');
        }
    }
?>
