<?php
    
namespace App\Controller\MlMaster;
    
use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class ReportController extends AppController {
    
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
    
    public function initialize(): void
    {
        parent::initialize();

            $this->loadComponent('RequestHandler');

            $uri = $_SERVER['REQUEST_URI'];
            $this->set(compact('uri'));

            // Load the paginator component with the simple paginator strategy.
            $this->loadComponent('Paginator', [
                'paginator' => new \Cake\Datasource\SimplePaginator(),
            ]);

            $this->session = $this->getRequest()->getSession();
            
    }
    
    public function index($shop_cd = NULL) {

        $this->set('title', '実績レポート');

        // 共通のComponentを呼び出す
        $common = new CommonComponent();
        
        // urlから店舗コードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');

        // DBより店舗情報を取得
        $shop_dataW = "shop_cd = '".$shop_cd."'";
        $shop_dataO = "shop_cd ";
        $shop_data  = $common->prGetData("mst0010",$shop_dataW,$shop_dataO);
        $this->set(compact('shop_data'));
        
        if(!$shop_data){
            echo '【店舗情報が見つかりません。URLに間違いないか確認してください。】';
            exit();
        }
        
        $shop_list  = $common->prGetData("mst0010");
        $this->set(compact('shop_list'));
        
        // お店の名前
        $shop_nm = $shop_data[0]['shop_nm'];
        $this->set(compact('shop_nm'));
        
        $this_month = date('Y-m');
        $this->set(compact('this_month'));

        //画面からpostされたときのみ処理する 
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
            
            $this_month = $searchParam['this_month'];
            $this->set(compact('this_month'));
            
            $endDate  = date("Y-m-t", strtotime($this_month));
           
            $where       = " raiten_time between '".$this_month."-01' and '".$endDate."'";
            if($searchParam['tenpo_select'] != ''){
                $where      .= " and shop_cd = '".$searchParam['tenpo_select']."'";
            }
            $raiten_tot  = $common->prGetCount("trn0012","*",$where);
            $this->set(compact('raiten_tot'));
            
            $whereC      = " updatetime between '".$this_month."-01' and '".$endDate."'";
            $whereC     .= " and used = '1' ";
            if($searchParam['tenpo_select'] != ''){
                $whereC      .= " and shop_cd = '".$searchParam['tenpo_select']."'";
            }
            $Coupon_tot  = $common->prGetCount("mst0012","*",$whereC);
            $this->set(compact('Coupon_tot'));
            
            // 
            $shop_sentaku = $searchParam['tenpo_select'];
            $this->set(compact('shop_sentaku'));

            /*
             *  日別来店者数
             */
            if($searchParam['btn_click_name'] == CON_A){
                
                $whereR  = " where shop_cd <> '0000' ";
                $whereR .= " and raiten_time between '".$this_month."-01' and '".$endDate."' ";
                if($searchParam['tenpo_select'] !== ''){
                    $whereR .= " and shop_cd = '".$searchParam['tenpo_select']."'";
                }
                $raiten_data  = $common->prGetraitenData($whereR);
                
		// CSVに出力するヘッダ行
		$export_csv_title = [];
                $filename = CON_A;
		// 先頭固定ヘッダ追加
		array_push($export_csv_title, "来店日");
		array_push($export_csv_title, "ユーザーコード");
                array_push($export_csv_title, "ユーザー名");
		array_push($export_csv_title, "来店数");

		// タイトル行のエンコードをSJIS-winに変換（一部環境依存文字に対応用）
		foreach( $export_csv_title as $key => $val ){
                    $export_header[] = mb_convert_encoding($val, 'SJIS-win', 'UTF-8');
		}
                
                $common->prCsvOutput($export_header,$raiten_data,$filename);
            }
            
            /*
             *  クーポン利用者数
             */
            if($searchParam['btn_click_name'] == CON_B){

                $whereR  = " where updatetime between '".$this_month."-01' and '".$endDate."' ";
                $whereR .= " and used = '1'";
                if($searchParam['tenpo_select'] !== ''){
                    $whereR .= " and shop_cd = '".$searchParam['tenpo_select']."'";
                }
                $coupon_data  = $common->prGetcouponUsedData($whereR);

		// CSVに出力するヘッダ行
		$export_csv_title = [];
                $filename = CON_B;

		// 先頭固定ヘッダ追加
		array_push($export_csv_title, "来店日");
		array_push($export_csv_title, "クーポン利用者数");

		// タイトル行のエンコードをSJIS-winに変換（一部環境依存文字に対応用）
		foreach( $export_csv_title as $key => $val ){
                    $export_header[] = mb_convert_encoding($val, 'SJIS-win', 'UTF-8');
		}

                $common->prCsvOutput($export_header,$coupon_data,$filename);
            }

            /*
             *  回遊率
             */
            if($searchParam['btn_click_name'] == CON_C){

                $whereR  = " where raiten_time between '".$this_month."-01' and '".$endDate."' ";
                $whereR .= " and shop_cd <> '0000'";
                $raitenTypeData  = $common->prGetMigrationRateData($whereR);

		// CSVに出力するヘッダ行
		$export_csv_title = [];
                $filename         = CON_C;

		// 先頭固定ヘッダ追加
		array_push($export_csv_title, "店舗数");
                array_push($export_csv_title, "顧客数");

		// タイトル行のエンコードをSJIS-winに変換（一部環境依存文字に対応用）
		foreach( $export_csv_title as $key => $val ){
                    $export_header[] = mb_convert_encoding($val, 'SJIS-win', 'UTF-8');
		}

                $common->prCsvOutput($export_header,$raitenTypeData,$filename);
            }

            /*
             *  時間帯別来店者数
             */
            if($searchParam['btn_click_name'] == CON_D){

                $whereR  = " where shop_cd <> '0000' ";
                $whereR .= " and raiten_time between '".$this_month."-01' and '".$endDate."' ";
                if($searchParam['tenpo_select'] !== ''){
                    $whereR .= " and shop_cd = '".$searchParam['tenpo_select']."'";
                }
                $raiten_data  = $common->prGetraitenData($whereR);

		// CSVに出力するヘッダ行
		$export_csv_title = [];
                $filename         = CON_D;

		// 先頭固定ヘッダ追加
		array_push($export_csv_title, "来店日");
                
		array_push($export_csv_title, "ユーザーコード");
                array_push($export_csv_title, "ユーザー名");
		array_push($export_csv_title, "来店数");

		// タイトル行のエンコードをSJIS-winに変換（一部環境依存文字に対応用）
		foreach( $export_csv_title as $key => $val ){
                    $export_header[] = mb_convert_encoding($val, 'SJIS-win', 'UTF-8');
		}

                $common->prCsvOutput($export_header,$raiten_data,$filename);
            }

           /*
            *  来店者属性
            */
            if($searchParam['btn_click_name'] == CON_E){

                $whereR  = " where raiten_time between '".$this_month."-01' and '".$endDate."' ";
                if($searchParam['tenpo_select'] !== ''){
                    $whereR .= " and shop_cd = '".$searchParam['tenpo_select']."'";
                }
                $whereR .= " and shop_cd <> '0000'";
                $raitenTypeData  = $common->prGetraitenTypeData($whereR);

		// CSVに出力するヘッダ行
		$export_csv_title = [];
                $filename         = CON_E;

		// 先頭固定ヘッダ追加
                array_push($export_csv_title, "都道府県");
		array_push($export_csv_title, "年代");
                array_push($export_csv_title, "性別");
                array_push($export_csv_title, "人数");

		// タイトル行のエンコードをSJIS-winに変換（一部環境依存文字に対応用）
		foreach( $export_csv_title as $key => $val ){
                    $export_header[] = mb_convert_encoding($val, 'SJIS-win', 'UTF-8');
		}

                $common->prCsvOutput($export_header,$raitenTypeData,$filename);
            }
        }
    }
}
