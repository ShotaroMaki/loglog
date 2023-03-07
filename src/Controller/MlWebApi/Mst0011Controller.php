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

    class Mst0011Controller extends AppController {
        
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
        public function index() {
            
            // 共通のComponentを呼び出す
            $common = new CommonComponent();
            
            // 最大の顧客コードを読込み
            $result = $common->prGetMaxValue('user_cd','mst0011');
           
            //　結果に+1する
            $maxValue = sprintf("%08d", $result[0]['max']+1);

            $json_array[] =  array(
                'user_cd'       => $maxValue,
            );
            // 新規の顧客コード作成しとく。
            // パラメータの準備
            $searchParam = [];
            $searchParam['insuser_cd']  = $maxValue;
            $searchParam['insdatetime'] = 'now() ';
            $searchParam['upduser_cd']  = $maxValue; 
            $searchParam['updatetime']  = 'now() '; 
            $searchParam['user_cd']     = $maxValue; 
            $searchParam['user_nm']     = ''; 
            $searchParam['user_kn']     = ''; 
            $searchParam['birthday']    = '';
            $searchParam['gender']      = ''; 
            $searchParam['user_mail']   = ''; 
            $searchParam['user_pw']     = ''; 
            $searchParam['user_phone']  = ''; 
            $searchParam['connect_kbn'] = '0'; 
            $searchParam['add1']        = ''; 
            $searchParam['add2']        = ''; 
            $searchParam['rank']        = ''; 

            
            $common->prSavedata('mst0011',$searchParam);
            
            $this->set(compact('json_array'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
?>
