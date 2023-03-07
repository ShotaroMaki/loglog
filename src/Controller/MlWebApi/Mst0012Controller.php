<?php
    /**
     * @file      .loglog顧客情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      未使用クーポン数を取得
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class Mst0012Controller extends AppController {
        
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
        public function index($user_cd = null) {
        
            // 共通のComponentを呼び出す
            $common = new CommonComponent();
            
            // urlからユーザーコードコードを取得する
            $user_cd = $this->request->getQuery('user_cd');
            
            // 日付を取得
            $today = $common->prGetToday();
            
            // クーポンマスタを読込み(未使用のデータのみ取得）
            
            $where = "";
            $where .= " mst0012.shop_cd = mst0010.shop_cd ";
            $where .= " and mst0012.used = '0' and mst0012.user_cd='".$user_cd."'";
            $where .= " and mst0012.effect_srt <= '".$today."' and mst0012.effect_end >= '".$today."'";

            $coupon_data = $common->prGetDatajoin("mst0010 , mst0012 ",$where);
            $this->set(compact('coupon_data'));

            $count   = count($coupon_data);

                $aryAddRow =  array(
                    'cpn_count'          => $count,          // 未使用カウント
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
