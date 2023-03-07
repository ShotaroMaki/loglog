<?php
    /**
     * @file      message and shop Info API 
     * @author    KARL
     * @date      2023/02
     * @version   69
     * @note      
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;
    
    class GetMessageShopInfoController extends AppController {
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
         *
         */
        public function index($user_cd = null) {
            
            // 共通のComponentを呼び出す
            $common = new CommonComponent();
            
            // urlからユーザーコードを取得する
            $user_cd = $this->request->getQuery('user_cd');
            $msg_shopInfo = $common->getMessageShopInfo($user_cd);  //make query here, check Commonshit file
            // $json_array[] = $msg_shopInfo;
           

            foreach($msg_shopInfo as $data){
                
                $aryAddRow =  array(
                    'room_cd'		    =>strval($data['room_id']),
                    'datesent'		    =>$data['datesent'],  // messages テーブルから
                    'upduser_cd'		=>$data['upduser_cd'],
                    'updatetime'        =>$data['updatetime'],
                    'shop_cd'	        =>$data['shop_cd'],
                    'shop_nm'	        =>$data['shop_nm'],
                    'msg_cd'			=>$data['msg_cd'],
                    'msg_text'			=>$data['msg_text'],
                    'connect_kbn'		=>$data['connect_kbn'],
                    'user_cd'			=>$data['user_cd'],	
                    'shop_postcd'		=>$data['shop_postcd'],	
                    'shop_add1'			=>$data['shop_add1'],
                    'shop_add2'			=>$data['shop_add2'],	
                    'shop_add3'			=>$data['shop_add3'],	
                    'shop_phone'		=>$data['shop_phone'],	
                    'opentime1'		    =>$data['opentime1'],
                    'closetime1'		=>$data['closetime1'],	
                    'opentime2'			=>$data['opentime2'],
                    'closetime2'		=>$data['closetime2'],	
                    'url_hp'			=>$data['url_hp'],
                    'url_sns1'			=>$data['url_sns1'],			
                    'url_sns2'			=>$data['url_sns2'],			
                    'url_sns3'			=>$data['url_sns3'],		
                    'url_sns4'			=>$data['url_sns4'],		
                    'thumbnail1'		=>$data['thumbnail1'],		
                    'thumbnail2'		=>$data['thumbnail2'],		
                    'thumbnail3'		=>$data['thumbnail3'],		
                    'goods'				=>$data['goods'],		
                    'paidmember'		=>$data['paidmember'],		
                    'holiday1'			=>$data['holiday1'],	
                    'holiday2'			=>$data['holiday2'],	
                    'holiday3'			=>$data['holiday3'],	
                    'free_text'			=>$data['free_text'],
                    
                );


                $json_array[] = $aryAddRow;
            }


            //index.php に投げる
            $this->set(compact('json_array','msg_shopInfo'));
            
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
