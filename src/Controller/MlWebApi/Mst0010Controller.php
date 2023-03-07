<?php
    /**
     * @file      .loglog店舗情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      店舗情報を取得
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class Mst0010Controller extends AppController {
        
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
            
            // urlからメッセージコードを取得する
            $user_cd = $this->request->getQuery('user_cd');
            
            // ユーザーマスタ取得
            $whereG  = " user_cd  = '".$user_cd."' and connect_kbn = '0' ";
            $mst0011 = $common->prGetData('Mst0011',$whereG);
            $this->set(compact('mst0011'));
            
            // 未取得のデータがあった場合
            if($mst0011){
                
                // 店舗データ取得
                $where   = "";
                $order   = " shop_cd ";
                $mst0010 = $common->prGetData('Mst0010',$where,$order);
                $this->set(compact('mst0010'));
                
                // 顧客マスタ更新
                $table = 'mst0011';
                $where = " user_cd  = '".$user_cd."' and connect_kbn = '0' ";
                $connect_kbn = '0';
               // $common->prUpdSend($table,$where,$connect_kbn);
                
                
                foreach($mst0010 as $data){
                    $aryAddRow =  array(
                        'shop_cd'        => $data['shop_cd'],     // 店舗コード
                        'shop_nm'        => $data['shop_nm'],     // 店舗名
                        'shop_kn'        => $data['shop_kn'],     // 店舗名カナ
                        'shop_phone'     => $data['shop_phone'],  // 電話番号
                        'shop_postcd'    => $data['shop_postcd'], // 郵便番号
                        'shop_add1'      => $data['shop_add1'],   // 住所1
                        'shop_add2'      => $data['shop_add2'],   // 住所2
                        'shop_add3'      => $data['shop_add3'],   // 住所3
                        'opentime1'      => $data['opentime1'],   // 開店時間1
                        'closetime1'     => $data['closetime1'],  // 閉店時間1
                        'opentime2'      => $data['opentime2'],   // 開店時間2
                        'closetime2'     => $data['closetime2'],  // 閉店時間2
                        'holiday1'       => $data['holiday1'],    // 定休日1
                        'holiday2'       => $data['holiday2'],    // 定休日2
                        'holiday3'       => $data['holiday3'],    // 定休日3
                        'url_hp'         => $data['url_hp'],      // HP
                        'url_sns1'       => $data['url_sns1'],    // SNS1
                        'url_sns2'       => $data['url_sns2'],    // SNS2
                        'url_sns3'       => $data['url_sns3'],    // SNS3
                        'category_cd'    => $data['category_cd'], // カテゴリコード
                        'goods'          => $data['goods'],       // 取扱商品
                        'thumbnail1'     => $data['thumbnail1'],  // サムネイル写真1
                        'thumbnail2'     => $data['thumbnail2'],  // サムネイル写真2
                        'thumbnail3'     => $data['thumbnail3'],  // サムネイル写真3
                        'paidmember'     => $data['paidmember'],  // 有料契約
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
