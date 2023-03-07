<?php
    
namespace App\Controller\MlMaster;
    
use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\Component\MlCommon\CommonComponent;

class CustrankeditController extends AppController {
    
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

        $this->set('title', '顧客ランク登録');

        // 共通のComponentを呼び出す
        $common = new CommonComponent();
        
        // urlから店舗コードを取得する
        $shop_cdP = $this->request->getQuery('shop_cd');
        $rank_cdP = $this->request->getQuery('rank_cd');

        if ($shop_cdP){
            // DBより顧客ランク情報を取得
            $whereD      = " shop_cd = '".$shop_cdP."' and rank_cd = '".$rank_cdP."'";
            $rank_data   = $common->prGetData("mst0016",$whereD);
        }else{
            $rank_data[0]['shop_cd'] = "";
            $rank_data[0]['rank_cd'] = "";
            $rank_data[0]['rank_nm'] = "";
        }

        //画面からpostされたときのみ処理する 
        if ($this->getRequest()->is('post')) {

            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
            
            if($searchParam['btn_click_name'] == CON_SAVE_IN3){
                
                if($searchParam['rank_cd'] == ""){
                    // NOP
                    $alert = "<script type='text/javascript'>alert('ランクコード入力してください。');</script>";
                    echo $alert;
                    $this->set(compact('rank_data'));
                    return;
                    
                }else if($searchParam['shop_cd'] == ""){
                    // NOP
                    $alert = "<script type='text/javascript'>alert('ランクコード入力してください。');</script>";
                    echo $alert;
                    $this->set(compact('rank_data'));
                    return;
                }else{
                    
                    // 削除
                    $delshopcd = $searchParam['shop_cd'];
                    $delrankcd = $searchParam['rank_cd'];
                    $whereD = " shop_cd = '".$delshopcd."' and rank_cd = '".$delrankcd."'";
                    $common->prDeletedata("mst0016",$whereD);
                    //　登録
                    $common->prSavedata("mst0016",$searchParam);
                    
                }
                return $this->redirect(
                 ['controller'  => './Custrank'
                     , 'action' => 'index'
                     , '?'      => [
                      'shop_cd' => "0001"]
                 ]);
            }else if($searchParam['btn_click_name'] == CON_CANCEL){
                return $this->redirect(
                 ['controller'  => './Custrank'
                     , 'action' => 'index'
                     , '?'      => [
                      'shop_cd' => "0001"]
                 ]);
            }
       }
       $this->set(compact('rank_data'));
    }
}