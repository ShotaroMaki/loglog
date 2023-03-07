<?php

namespace App\Controller\MlCoupon;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Cache\Cache; 
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Datasource\ConnectionManager;
use App\Controller\Component\MlCommon\CommonComponent;

class CouponController extends AppController {
    
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
    public function index() {

        $this->set('title', 'クーポン作成');
        
        // 共通のComponentを呼び出す
        $common = new CommonComponent();
       
        // urlから店舗コードを取得する
        $shop_cd = $this->request->getQuery('shop_cd');
        // urlからクーポンコードを取得する
        $coupon_cd = $this->request->getQuery('coupon_cd'); 
        
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
        
        // DBより顧客ランク情報を取得
        $whereR = "shop_cd = '".$shop_cd."'";
        $rank   = $common->prGetData("mst0016",$whereR);
        $this->set(compact('rank'));
        
        // 
        $months = $common->prGetmonths();
        $this->set(compact('months'));
        
        $genders = $common->prGetgender();
        $this->set(compact('genders'));
        
        $ages = $common->prGetages();
        $this->set(compact('ages'));

        if($coupon_cd){
            
            $cpn_data[0]['coupon_cd'] = $coupon_cd;
           
            // DBよりクーポン情報を取得
            $cpn_dataW  = " shop_cd = '".$shop_cd."'";
            $cpn_dataW .= " and coupon_cd = '".$coupon_cd."'";
            $distinctM  = " coupon_cd ";
            $cpn_data = $common->prGetDataDistinct("mst0012",$cpn_dataW,NULL,NULL,$distinctM);

            $str1        =  substr($cpn_data[0]['effect_srt'], 0, 4);
            $str2        =  substr($cpn_data[0]['effect_srt'], 4, 2);
            $str3        =  substr($cpn_data[0]['effect_srt'], 6, 2);
            $effect_srt  = $str1."-".$str2."-".$str3;
            
            $str4        =  substr($cpn_data[0]['effect_end'], 0, 4);
            $str5        =  substr($cpn_data[0]['effect_end'], 4, 2);
            $str6        =  substr($cpn_data[0]['effect_end'], 6, 2);
            $effect_end  =  $str4."-".$str5."-".$str6;
            $prefecture  =  $cpn_data[0]['prefecture'];
            $age         =  $cpn_data[0]['age'];
            $genderB     =  $cpn_data[0]['gender'];
            $birthday    =  $cpn_data[0]['birthday'];
            $rankB       =  $cpn_data[0]['rank'];
            
            if( $cpn_data[0]['background'] == NULL){
                $background  = "#ffffff";
                $color       = "#696969";   
            }else{
                $background  = $cpn_data[0]['background'];
                $color       = $cpn_data[0]['color'];
            }
        }else{

            // クーポンコードを取得する
            (int)$coupon_cd = $this->prGetcouponData($shop_cd);
            
            $cpn_data[0]['coupon_cd']       = (float)$coupon_cd[0]['coupon_cd']+1;
            $cpn_data[0]['coupon_goods']    = "";
            $cpn_data[0]['coupon_discount'] = "";
            $cpn_data[0]['thumbnail1']      = "";
            $cpn_data[0]['thumbnail2']      = "";
            $cpn_data[0]['thumbnail3']      = "";
            $effect_srt                     = "";
            $effect_end                     = "";
            $background                     = "#ffffff";
            $color                          = "#696969";
            $prefecture                     = "";
            $age                            = "";
            $genderB                        = "";
            $birthday                       = "";
            $rankB                          = "";
        }
        $this->set(compact('cpn_data'));
        $this->set(compact('effect_srt'));
        $this->set(compact('effect_end'));
        $this->set(compact('background'));
        $this->set(compact('color'));
        $this->set(compact('prefecture'));
        $this->set(compact('age'));
        $this->set(compact('genderB'));
        $this->set(compact('birthday'));
        $this->set(compact('rankB'));
        
        if ($this->getRequest()->is('post')) {
            
            // 画面パラメータ
            $searchParam =  $this->getRequest()->getData();
            $this->set(compact('searchParam'));
        
            // 写真保存用のパスを設定する
            $path    = CON_CPN_IMAGE.$shop_cd;
            $myFiles = $this->request->getData('my_file');
            $pic_nm  = $common->prSavePic($path,$myFiles);
            
            if($shop_data[0]['paidmember'] == 0){
                $searchParam['user_add']    = "";
                $searchParam['age']         = "";
                $searchParam['birth_month'] = "";
                $searchParam['gender']      = "";
                $searchParam['background']  = "";
                $searchParam['color']       = "";  
            }

            $searchParam['thumbnail1'] = "";
            $searchParam['thumbnail2'] = "";
            $searchParam['thumbnail3'] = "";
            if(!$searchParam['background']){$searchParam['background'] = "#ffffff";}
            if(!$searchParam['color']){$searchParam['color'] = "696969";}
            
            if($pic_nm[0] != ""){
                $j=1;
                foreach($pic_nm as $val){
                    $searchParam['thumbnail'.$j] = $val;
                    $j++;
                }
            }else{
                if($cpn_data[0]['thumbnail1']){$file1 = $path.'/'.$cpn_data[0]['thumbnail1'];unlink($file1);}
                if($cpn_data[0]['thumbnail2']){$file2 = $path.'/'.$cpn_data[0]['thumbnail2'];unlink($file2);}
                if($cpn_data[0]['thumbnail3']){$file3 = $path.'/'.$cpn_data[0]['thumbnail3'];unlink($file3);}
            }
            
            if($searchParam['btn_click_name'] == CON_SAVE_IN){
                
                $whereU = " 1 = 1";
                if($searchParam['user_add']){
                    $whereU .= " and add1 like '%".$searchParam['user_add']."%' ";
                }
                
                if($searchParam['age']){
                    
                    // 年を取得 
                    $year = date('Y');
                    // 年代 
                    $age = $searchParam['age'];
                    $yearlist2 = "(";
                    for ($i = 0; $i < $age; $i++) {
                        
                        $year_list = ((int)$year-(int)$i-(int)$age);
                        
                        $yearlist2 .= "'".$year_list."',";
                        
                    }
                    $year_list1 = substr($yearlist2, 0, -1);

                    $year_list1 .= ")";

                    $whereU    .= " and substr(birthday,0,5) in ".$year_list1;
                    
                }
                if($searchParam['birth_month']){
                    $whereU .= " and substr(birthday,5,2 )  = '".$searchParam['birth_month']."'";
                }
                if($searchParam['gender']){
                    $whereU .= " and gender = '".$searchParam['gender']."' ";
                }
                
                // 対象のユーザーを取得する
                $user_data = $common->prGetData("mst0011",$whereU,NULL,NULL);
                $this->set(compact('user_data'));                

                $cpn_cd_1 = sprintf("%06d",$cpn_data[0]['coupon_cd']);
                

                foreach($user_data as $val){
                    // 削除条件
                    $where = " shop_cd = '".$shop_cd."' and coupon_cd ='".$cpn_cd_1."'";
                    // 削除
                    $common->prDeletedata("mst0012",$where);
                    
                }
                foreach($user_data as $val){                   
                    
                    if($shop_data[0]['paidmember'] == 0){
                        $searchParam['insuser_cd']   = $shop_cd;
                        $searchParam['insdatetime']  = "now()";
                        $searchParam['upduser_cd']   = $shop_cd;
                        $searchParam['updatetime']   = "now()";
                        $searchParam['shop_cd']      = $shop_cd;
                        $searchParam['coupon_cd']    = $cpn_cd_1;
                        $searchParam['effect_srt']   = str_replace("-","",$searchParam['effect_srt']);
                        $searchParam['effect_end']   = str_replace("-","",$searchParam['effect_end']);
                        $searchParam['user_cd']      = $val['user_cd'];
                        $searchParam['connect_kbn']  = '0';
                        $searchParam['used']         = '0';
                        $searchParam['prefecture']   = NULL;
                        $searchParam['age']          = NULL;
                        $searchParam['gender']       = NULL;
                        $searchParam['birthday']     = NULL;
                        $searchParam['rank']         = NULL;
                        $searchParam['background']   = "#ffffff";
                        $searchParam['color']        = "696969"; 
                        
                    }else{
                        $searchParam['insuser_cd']   = $shop_cd;
                        $searchParam['insdatetime']  = "now()";
                        $searchParam['upduser_cd']   = $shop_cd;
                        $searchParam['updatetime']   = "now()";
                        $searchParam['shop_cd']      = $shop_cd;
                        $searchParam['coupon_cd']    = $cpn_cd_1;
                        $searchParam['effect_srt']   = str_replace("-","",$searchParam['effect_srt']);
                        $searchParam['effect_end']   = str_replace("-","",$searchParam['effect_end']);
                        $searchParam['user_cd']      = $val['user_cd'];
                        $searchParam['connect_kbn']  = '0';
                        $searchParam['used']         = '0';
                        $searchParam['prefecture']   = $searchParam['user_add'];
                        $searchParam['age ']         = $searchParam['age'];
                        $searchParam['gender']       = $searchParam['gender'];
                        $searchParam['birthday']     = $searchParam['birth_month'];
                        $searchParam['rank']         = $searchParam['rank'];
                    }  
                //　登録する
                    $common->prSavedata("mst0012",$searchParam);
                }
                return $this->redirect(
                     ['controller'  => '../MlRCpn/RCpn'
                         , 'action' => 'index'
                         , '?'      => [
                         'shop_cd'  => $shop_cd]
                     ]);
            }
        }
    }
                
        private function prGetcouponData($shop_cd)
        {
            $connection = ConnectionManager::get('default');

            $sql   = "";
            $sql   .= "select ";
            $sql   .= " max(coupon_cd) as coupon_cd ";
            $sql   .= "from ";
            $sql   .= "mst0012 ";
            $sql   .= "where ";  
            $sql   .= "shop_cd = '".$shop_cd."'";

            // SQLの実行
            $query = $connection->query($sql)->fetchAll('assoc');
            $this->set(compact('query'));

            return $query;
        }
        
    }
    ?>
