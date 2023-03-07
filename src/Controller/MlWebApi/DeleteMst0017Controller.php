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

    class DeleteMst0017Controller extends AppController {
        
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
        public function index($jan_no = NULL,$user_cd = NULL) {

            // 共通のComponentを呼び出す
            $common = new CommonComponent();

            // urlからパスワードを取得する
            $jan_no = $this->request->getQuery('jan_no');

            // urlからユーザーコードを取得する
            $user_cd = $this->request->getQuery('user_cd');

            // ユーザーマスタ取得
            $whereG  = " user_cd  = '".$user_cd."'";
            $whereG .= " and jan_no  = '".$jan_no."'";
            $mst0017 = $common->prGetData('Mst0017',$whereG);

            if($mst0017){
                
                $common->prDeletedata("mst0017",$whereG);
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
