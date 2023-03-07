<?php
    /**
     * @file      .loglogポイントカード情報API   
     * @author    crmbhattarai
     * @date      2022/07/23
     * @version   1.00
     * @note      ポイントカードを送信
     */

    namespace App\Controller\MlWebApi;

    use App\Controller\AppController;
    use Cake\Event\EventInterface;
    use Cake\Cache\Cache; 
    use Cake\Datasource\ConnectionManager;
    use App\Controller\Component\MlCommon\CommonComponent;

    class NewMst0017Controller extends AppController {
        
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
            
            // urlからuser_cdとshop_cdを取得する
            $shop_cd = $this->request->getQuery('shop_cd');
            $user_cd = $this->request->getQuery('user_cd');
            $SPointHeader = "";
            
            $whereSN   = "shop_cd = '".$shop_cd."'";
            $shop_data = $common->prGetData("mst0010",$whereSN);      //get data mst0010


            if($shop_data){
                $shop_nm = $shop_data[0]['shop_nm'];
                // $shop_nm15文字以上の時は14文字..にする
                if(mb_strlen($shop_nm) >14){
                    $str = substr($shop_nm, 0, 14);
                    $shop_nm = $str."..";
                }
            }
            
            // shop_cdより店舗がポイント対応しているか調べる
            $whereS  = " shop_cd = '".$shop_cd."'";
            $whereS .= " and point = '1'";
            $mst0010 = $common->prGetData('Mst0010',$whereS);
            $SPointHeader = $shop_data[0]['special_point_cd']; //MST0010から GET special_point_cd 

            //Special POINT コードチェック
           if(!$mst0010){
                $SPointHeader ="";
           }
       
            
            // user_cdよりユーザーがshop_cdのポイントカード持っているか調べる
            $str1 = substr($shop_cd, 2, 4);            
            $whereG  = " user_cd  = '".$user_cd."'";
            $whereG .= " and jan_no LIKE '".$SPointHeader."%'";
            $mst0017 = $common->prGetData('mst0017',$whereG);

            if(!$mst0010){ //check if POINT != 1
                $json_array[] = "not_support";
                
            }else{
                if($mst0017){
                    $json_array[] = "already_have";

                }else{

                    // -----------------------------------------------------------------------SPECIAL POINT 有る
                    if($SPointHeader !== NULL && $SPointHeader !== ""){ 

                        //make JAN_NO with SPointHeader

                        $pointHeader  = intval($SPointHeader); // string to INT

    
                        $janCDFULL = $pointHeader.$user_cd;
                        $janCDFULL = intval($janCDFULL); // string to INT

                        //----CHECK DIGIT
                        $j=0;
                        $evens = 0;
                        $odds  = 0;
                        for ($j = 0; $j <= 12; $j++){
                        
                            if($j % 2 == 0){
                                $odd  = substr($pointHeader, $j, 1);
                                $odd =  intval($odd);
                                $odds = $odd + $odds;
                            } else {
                                $even  = substr($pointHeader, $j, 1); 
                                $even =  intval($even);
                                $evens = $even + $evens;
                            }
                        }
                        $str2 = $evens * 3 + $odds;
                        $str3 = substr($str2, -1, 1);

                        if($str3 == 0){
                            $check_digit = 0;
                        }else{
                            $check_digit = 10 - $str3;
                        }

                        $janCDFULL = $janCDFULL.$check_digit; // FINAL JAN コード
                        $json_array[] = $janCDFULL;

                    }else{ // -------------------------------------------------------------SPECIAL POINT 無し

                        //If no special point do this:
                        //shop_group_cd + user_cd ----------------------NEW  追加日23/03
                        $shop_group = $shop_data[0]['shop_group_cd'];
                        $shop_group = substr($shop_group, 1, 5);
                        $janCDFULL = $shop_group.$user_cd;
                        $janCDFULL = intval($janCDFULL); // string to INT

                        //----CHECK DIGIT
                        $j=0;
                        $evens = 0;
                        $odds  = 0;
                        for ($j = 0; $j < 12; $j++){

                            if($j % 2 == 0){
                                $odd  = substr($janCDFULL, $j, 1); 
                                $odds = $odd + $odds;
                            } else {
                                $even  = substr($janCDFULL, $j, 1); 
                                $evens = $even + $evens;
                            }
                        }
                        $str2 = $evens * 3 + $odds;
                        $str3 = substr($str2, -1, 1);
                        if($str3 == 0){
                            $check_digit = 0;
                        }else{
                            $check_digit = 10 - $str3;
                        }

                        $janCDFULL = $janCDFULL.$check_digit; // FINAL JAN コード
                        $json_array[] = $janCDFULL;

                    } 


                    //　ポイントカードを登録する                
                    $searchParam['insuser_cd']   = $user_cd;
                    $searchParam['insdatetime']  = "now()";
                    $searchParam['upduser_cd']   = $user_cd;
                    $searchParam['updatetime']   = "now()";
                    $searchParam['user_cd']      = $user_cd;
                    $searchParam['jan_no']       = $janCDFULL;    //change this to custom or random shit digit
                    $searchParam['card_nm']      = $shop_nm;

                    $searchParam['shop_group_cd']      = $mst0010[0]['shop_group_cd'];

                    //var_dump($searchParam);exit;
                    $common->prSavedata("mst0017",$searchParam);  //--------------------------------UNCOMMENT THIS FOR FINAL

                    //add shop_group_cd
                }
            }



            
            $this->set(compact('json_array'));
            // JSON で出力
            $this->viewBuilder()
                ->setClassName('Json')
                ->setOption('serialize', 'json_array');
        }
    }
?>
