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

    class DeleteTrn0012Controller extends AppController {
        
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
            $user_cd     = $this->request->getQuery('user_cd');
            $raiten_time = $this->request->getQuery('raiten_time');
            
                // 削除条件
                $where = " raiten_time = '".$raiten_time."' and user_cd ='".$user_cd."'";
                // データの有無を確認
                $trn0012 = $common->prGetData('trn0012',$where);
                
                // 削除
                if($trn0012){
                    $common->prDeletedata("trn0012",$where);
                    $json_array[] = "Deleted!";
                
                } else {
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
