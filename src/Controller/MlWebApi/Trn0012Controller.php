<?php
    /**
     * @file      .loglog店舗情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      来店履歴を送信
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class Trn0012Controller extends AppController {
        
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
            
            // ユーザーマスタ取得
            $whereG  = " user_cd  = '".$user_cd."'";
            $orderG  = " raiten_time ";
         //   $whereG  = " user_cd  = '".$user_cd."' and connect_kbn = '0' ";
            $trn0012 = $common->prGetData('Trn0012',$whereG,$orderG);
            $this->set(compact('trn0012'));
            
            // 未取得のデータがあった場合
            if($trn0012){
                 
                // 顧客マスタ更新
                $table = 'trn0012';
              //  $where = " user_cd  = '".$user_cd."' and connect_kbn = '0' ";
                $where = " user_cd  = '".$user_cd."' ";
                $connect_kbn = '1';
            //    $common->prUpdSend($table,$where,$connect_kbn);
                
                
                foreach($trn0012 as $data){
                    $aryAddRow =  array(
                        'user_cd'        => $data['user_cd'],
                        'shop_cd'        => $data['shop_cd'],    
                        'shop_nm'        => $data['shop_nm'], 
                        'raiten_time'    => $data['raiten_time'],  
                        'nikki_title'    => $data['nikki_title'], 
                        'nikki_text'     => $data['nikki_text'], 
                        'thumbnail1'     => $data['thumbnail1'],   
                        'thumbnail2'     => $data['thumbnail2'],   
                        'thumbnail3'     => $data['thumbnail3'],   
                    );
                    $json_array[] = $aryAddRow;
                }
            }  else {
                $json_array[] = "";
            }
            $this->set(compact('json_array'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
?>
