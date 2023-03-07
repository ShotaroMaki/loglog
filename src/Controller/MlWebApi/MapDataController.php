<?php
    /**
     * @file      .loglogメッセージ情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      未読メッセージ数を取得
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;
    
    class MapDataController extends AppController {
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

            // urlからユーザーコードを取得する
            $user_cd = $this->request->getQuery('user_cd');

                $aryAddRow =  array(
                    'map_data'   => 'get',       
                );
                $json_array[] = $aryAddRow;
            $this->set(compact('json_array'));
            
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
?>
