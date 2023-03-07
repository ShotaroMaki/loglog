<?php
    /**
     * @file      .loglog店舗情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      顧客情報を送信
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class LoginMst0011Controller extends AppController {
        
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
        public function index($user_phone = null) {
            
            // 共通のComponentを呼び出す
            $common = new CommonComponent();
            
            // urlから電話番号を取得する
            $user_phone = $this->request->getQuery('user_phone');
            // urlからパスワードを取得する
            $user_pw = $this->request->getQuery('user_pw');
            // urlからユーザーコードを取得する
            $user_cd = $this->request->getQuery('user_cd');
            
            
            // パラメータにuser_cdがあるときconnect_kbnが0のデータを返す
            if($user_cd){
                 // ユーザーマスタ取得
                $whereG  = " user_cd  = '".$user_cd."'";
                $whereG .= " and connect_kbn  = '0'";
                $mst0011 = $common->prGetData('Mst0011',$whereG);
                $this->set(compact('mst0011')); 

                if($mst0011){
                    if($mst0011[0]['connect_kbn'] == '0'){
                    // パラメータの準備
                    $aryAddRow =  array(
                        'user_cd'     => $mst0011[0]['user_cd'],
                        'user_nm'     => $mst0011[0]['user_nm'],
                        'user_kn'     => $mst0011[0]['user_kn'],
                        'birthday'    => $mst0011[0]['birthday'],
                        'gender'      => $mst0011[0]['gender'],
                        'user_mail'   => $mst0011[0]['user_mail'],
                        'user_pw'     => $mst0011[0]['user_pw'],
                        'user_phone'  => $mst0011[0]['user_phone'],
                        'add1'        => $mst0011[0]['add1'],
                        'add2'        => $mst0011[0]['add2'],
                        'rank'        => $mst0011[0]['rank'],
                    );
                    $json_array[] = $aryAddRow;
                    // connect_kbnを1にする
                    //$common->prUpdSend('Mst0011',$whereG,$connect_kbn='1');
                    }
                }else{
                 $json_array[] = "";
                }
            
            // パラメータにuser_phoneがあるときuser_pwと一致していればデータを返す
            }else{
                // ユーザーマスタ取得
                $whereG  = " user_phone  = '".$user_phone."'";
                $whereG .= " and user_pw  = '".$user_pw."'";
                $mst0011 = $common->prGetData('Mst0011',$whereG);
                $this->set(compact('mst0011'));

                if($mst0011){
                    // パラメータの準備
                    $aryAddRow =  array(
                        'user_cd'     => $mst0011[0]['user_cd'],
                        'user_nm'     => $mst0011[0]['user_nm'],
                        'user_kn'     => $mst0011[0]['user_kn'],
                        'birthday'    => $mst0011[0]['birthday'],
                        'gender'      => $mst0011[0]['gender'],
                        'user_mail'   => $mst0011[0]['user_mail'],
                        'user_pw'     => $mst0011[0]['user_pw'],
                        'user_phone'  => $mst0011[0]['user_phone'],
                        'add1'        => $mst0011[0]['add1'],
                        'add2'        => $mst0011[0]['add2'],
                        'rank'        => $mst0011[0]['rank'],
                    );
                    $json_array[] = $aryAddRow;
                    // connect_kbnを1にする
                    $common->prUpdSend('Mst0011',$whereG,$connect_kbn='1');
                }else{
                 $json_array[] = "";
                }
        }
            $this->set(compact('json_array'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
?>
