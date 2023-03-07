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
    
    class Mst0013Controller extends AppController {
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
            
            // メッセージマスタを読込み(未読のデータ数取得）
            $where  = "";
            $where .= " mst0013.shop_cd     = mst0010.shop_cd ";
            $where .= " and mst0013.user_cd = '".$user_cd."' ";
            $where .= " and mst0013.connect_kbn = '0' ";
            
            $msg_data = $common->prGetDatajoin("mst0010 , mst0013 ",$where);
            $this->set(compact('msg_data'));
            $count   = count($msg_data);
           
                $aryAddRow =  array(
                    'msg_count'   => $count,       // 未読カウント
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
