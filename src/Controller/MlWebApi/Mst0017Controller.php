<?php
    /**
     * @file      .loglogポイントカード情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      ポイントカードを送信
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class Mst0017Controller extends AppController {
        
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
                 
            $whereG  = " user_cd  = '".$user_cd."'";
            $mst0017 = $common->prGetData('Mst0017',$whereG);
            
            if($mst0017){

                foreach($mst0017 as $data){
                    $aryAddRow =  array(
                        'user_cd'        => $data['user_cd'],
                        'jan_no'         => $data['jan_no'],    
                        'card_nm'        => $data['card_nm']  
                    );
                    $json_array[] = $aryAddRow;
                }
            }else{
                $json_array[] =  "";
            }
            
            $this->set(compact('json_array'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
?>
