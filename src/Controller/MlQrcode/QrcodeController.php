<?php

namespace App\Controller\MlQrcode;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Datasource\ConnectionManager;
use App\Controller\Component\MlCommon\CommonComponent;

class QrcodeController extends AppController {
    
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

            $this->set('title', 'QR作成');

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
            // お店の名前
            $shop_nm = $shop_data[0]['shop_nm'];
            $this->set(compact('shop_nm'));

            // DBよりエリア情報を取得
            $area = $common->prGetData("mst0015");
            $this->set(compact('area'));
            
        }   
    }
    ?>
