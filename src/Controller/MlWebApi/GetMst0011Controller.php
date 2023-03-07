<?php
    /**
     * @file      .loglog顧客情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      店舗顧客を取得
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class GetMst0011Controller extends AppController {
        
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

                //電話番号に重複がないか調べる
                $where  = "";
                $where .= " mst0011.user_phone     = '". $json[0]['user_phone']."' ";

                $user_data = $common->prGetData("mst0011",$where);
                $this->set(compact('user_data'));   
                
                //電話番号に重複があった時          
                if($user_data){
                    // メッセージ表示テスト用
                    $json_array[] =  array(
                        'check_phone'       => 0,
                    );
                }else{
                    
                    // 最大の顧客コードを読込み
                    $result = $common->prGetMaxValue('user_cd','mst0011');

                    //　結果に+1する
                    $maxValue = sprintf("%08d", $result[0]['max']+1);
                
                    foreach($json as $val){

                        $searchParam = [];
                        $searchParam['insuser_cd']  = $maxValue;
                        $searchParam['insdatetime'] = 'now() ';
                        $searchParam['upduser_cd']  = $maxValue;
                        $searchParam['updatetime']  = 'now() '; 
                        $searchParam['user_cd']     = $maxValue;
                        $searchParam['user_nm']     = $val['user_nm']; 
                        $searchParam['user_kn']     = $val['user_kn']; 
                        $searchParam['birthday']    = $val['birthday'];
                        $searchParam['gender']      = $val['gender']; 
                        $searchParam['user_mail']   = $val['user_mall']; 
                        $searchParam['user_pw']     = $val['user_pw']; 
                        $searchParam['user_phone']  = $val['user_phone'];
                        $searchParam['connect_kbn'] = '0'; 
                        $searchParam['add1']        = $val['add1']; 
                        $searchParam['add2']        = $val['add2']; 
                        $searchParam['rank']        = $val['rank']; 

                        //　データをテーブルに書き込む
                        $common->prSavedata('mst0011',$searchParam);
                    }
                    
                    // メッセージ表示テスト用
                    $json_array[] =  array(
                        'user_cd'       => $maxValue,
                    );

                }
            }else{
                // メッセージ表示テスト用
                    $json_array[] =  array(
                        'user_data'       => 0,
                    );
            }

            $this->set(compact('json_array'));
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
    
    
?>
