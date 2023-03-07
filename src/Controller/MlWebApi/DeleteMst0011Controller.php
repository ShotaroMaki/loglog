<?php
    /**
     * @file      .loglog店舗情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      顧客情報を削除
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class DeleteMst0011Controller extends AppController {
        
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

            
            // パラメータにuser_phoneがあるときuser_pwと一致していればデータを返す
 
                // ユーザーマスタ取得
                $whereG  = " user_phone  = '".$user_phone."'";
                $whereG .= " and user_pw  = '".$user_pw."'";
                $mst0011 = $common->prGetData('Mst0011',$whereG);
                $this->set(compact('mst0011'));

                if($mst0011){
                   $common->prDeletedata("mst0011",$whereG);
                    $json_array[] = "Deleted!";
                }else{
                 $json_array[] = "No Data";
                }

            $this->set(compact('json_array'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
?>
