<?php
    /**
     * @file      .loglogポイントカードAPI   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      ポイントカード情報
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class GetMST0017Controller extends AppController {
        
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
        public function index() 
        {
            // 共通のComponentを呼び出す
            $common = new CommonComponent();

            // パラメータを取得
            $body = $this->request->getQuery('param');
            
            //　パラメータなしの時はエラー
            if (is_null($body)) {
                # error データが無い
                http_response_code(500);
                echo "no data (JSON)";
                exit();
            }
            
            //　jsonに変換
            $json = json_decode($body, true);
            // jsonじゃなかったらエラー
            if (is_null($json)) {
                # error JSONをデコードできない
                http_response_code(500); 
                echo "JSON error";
                exit();
            }
            
            // データがある時
            if($json){
                
                foreach($json as $val){

                    $searchParam = [];
                    $searchParam['insuser_cd']  = $val['user_cd'];
                    $searchParam['insdatetime'] = 'now() ';
                    $searchParam['upduser_cd']  = $val['user_cd']; 
                    $searchParam['updatetime']  = 'now() '; 
                    $searchParam['user_cd']     = $val['user_cd']; 
                    $searchParam['jan_no']      = $val['jan_no']; 
                    $searchParam['card_nm']     = $val['card_nm'];
                    
                    //　データをテーブルに書き込む
                   $common->prSavedata('mst0017',$searchParam);
                   // メッセージ表示テスト用
                   $response = 'api success. This message from API.';
                   echo ($response);
                        
                }
                http_response_code(200);
                exit();
            } 
        }
    }
?>
