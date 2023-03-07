<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>

<script src="/loglog/webroot/js/jquery/jquery-3.3.1.slim.min.js"></script>
<script src="/loglog/webroot/js/jquery/jquery.autoKana.js" language="javascript" type="text/javascript"></script>

<script src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" 
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />


<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">



    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

</head>

<!-- -------------------------------------------------------------------------------------------------------------BOOTSTRAPTEST----------------------------------------------------------------- -->
<!-- <body>
<div id="sb-site1" style="text-align:left">
        <div class="title">
            登録内容変更 &#x270e;
        </div>
<main class="my-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">登録内容変更 &#x270e;</div>
                        <div class="card-body">
                            <form name="my-form" onsubmit="return validform()" action="success.php" method="">
                                <div class="form-group row">
                                    <label for="full_name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="full_name" class="form-control" name="full-name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email-address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="user_name" class="col-md-4 col-form-label text-md-right">User Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="user_name" class="form-control" name="username">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="phone_number" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="present_address" class="col-md-4 col-form-label text-md-right">Present Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="present_address" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="permanent_address" class="col-md-4 col-form-label text-md-right">Permanent Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="permanent_address" class="form-control" name="permanent-address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_number" class="col-md-4 col-form-label text-md-right"><abbr
                                                title="National Id Card">NID</abbr> Number</label>
                                    <div class="col-md-6">
                                        <input type="text" id="nid_number" class="form-control" name="nid-number">
                                    </div>
                                </div>


                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                        更新する
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</main> -->

<!-- -------------------------------------------------------------------------------------------------------------BOOTSTRAPTEST----------------------------------------------------------------- -->

<?php echo $this->Form->create(null, ['id' => 'EditForm', 'name' => 'EditForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>

<form method="post">

  <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
<div style="text-align:center;width: 60%;margin-left: 25%">
    <div id="sb-site1" style="text-align:left">
        <div class="title">
            登録内容変更 &#x270e;
        </div>
        
        <p style="text-align:center"><font color="red" size="5"><?= h($ERR_PHONE) ?></font></p>

        <label class="fieldbox">
            店舗名<font color="red">（必須）</font><br />
            <input id         = "shop_nm"
                   class      = "input_box form-control"
                   name       = "shop_nm" 
                   type       = "text"
                   value      = "<?= h($shop_data[0]['shop_nm']) ?>"
                   required 
                   maxlength  = "60">
        </label><br />
        
        <label class="fieldbox">
            店舗名カナ<br />
            <input id        = "shop_kn"
                   name      = "shop_kn"
                   class      = "input_box form-control"
                   type      = "text"
                   value     = "<?= h($shop_data[0]['shop_kn']) ?>"
                   maxlength = "60" >
        </label><br />

       <!-- ------------------- SHOP GROUP CD ---------------- --> 
        <label class="fieldbox">
            店舗グループコード
            <br />
            <input id         = "shop_group_cd"  
                   name       = "shop_group_cd"
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['shop_group_cd']) ?>"
                   maxlength  = "15">
        </label><br />

        

        <!-- ------------------- SPECIAL POINT CD ---------------- -->
        <label class="fieldbox">
            特別ポイントカード<font color="#FF9933">（5桁入力べき）</font>
            <input type="checkbox" id="pointCheck" name="pointCheck" onclick="check(this.id)" value="1">追加しますか？
            <!-- <button class="btn btn-primary" type="button" id="checkButton">チェック</button> -->
            <br />
            <input id         = "special_point_cd"  
                   name       = "special_point_cd"
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h(substr($shop_data[0]['special_point_cd'],0,5)) ?>"
                   maxlength  = "5"
                   disabled>
        </label><br />





        <label class="fieldbox">
            電話番号<font color="red">（必須）</font><br />
            <input id         = "shop_phone"  
                   name       = "shop_phone"
                   class      = "form-control w-25 p-3"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['shop_phone']) ?>"
                   required 
                   maxlength  = "15"
                   placeholder= "ハイフン無し半角数字で入力してください">
        </label><br />
        
        <label class="fieldbox">
            FAX番号<br />
            <input id         = "shop_fax" 
                   name       = "shop_fax" 
                   class      = "form-control w-25 p-3"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['shop_fax']) ?>"
                   maxlength  = "15"
                   placeholder= "ハイフン無し半角数字で入力してください">
        </label><br />
        
        <label class="fieldbox">
            郵便番号<font color="red">（必須）</font><br />
            <input id         = "shop_postcd" 
                   name       = "shop_postcd" 
                   class      = "form-control w-25 p-3"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['shop_postcd']) ?>"
                   required
                   maxlength  = "8"
                   placeholder= "ハイフン無し半角数字で入力してください">
        </label><br />
         
        <label class="fieldbox">
            都道府県<font color="red">（必須）</font><br />
            <select name="shop_add1">
                <option></option>
                <?php
                    foreach($area as $data){
                        $selected = '';
                        if ($data['area_nm'] == $shop_data[0]['shop_add1']) {
                            $selected = 'selected';
                        }else{
                             $selected = '""';
                        }
                ?>
                    <option value="<?= h($data['area_nm']) ?>"<?= h($selected); ?>><?= h($data['area_nm']) ?></option>
                <?php } ?>
            </select>
        </label><br />

        <label class="fieldbox">
            市区町村<font color="red">（必須）</font><br />
            <input id         = "shop_add2"
                   name       = "shop_add2" 
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['shop_add2']) ?>"
                   required
                   maxlength  = "60"
                   placeholder= "市区町村を入力してください">
        </label><br />
          
        <label class="fieldbox">
            番地以降の住所<font color="red">（必須）</font><br />
            <input id         = "shop_add3" 
                   name       = "shop_add3" 
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['shop_add3']) ?>"
                   required
                   maxlength  = "60"  
                   placeholder= "番地以降の住所を入力してください">   
        </label><br />

        <script>
            $(function() {
            $("#resetButton").click(function() {
                $('#opentime1').val("");
                $('#closetime1').val("");
            });
            });
            $(function() {
            $("#resetButton2").click(function() {
                $('#opentime2').val("");
                $('#closetime2').val("");
            });
            });
            </script>
    
        <label class="fieldbox">
            営業時間1:
            <input id  ="opentime1"
                   name= "opentime1"
                   type= "time"
                   value= "<?= h($shop_data[0]['opentime1']) ?>">～
            <input id  = "closetime1" 
                   name= "closetime1"
                   type= "time"
                   value= "<?= h($shop_data[0]['closetime1']) ?>">
                   <button class="btn btn-primary" type="button" id="resetButton">リセットする</button>
        </label><br />
        
        <label  class="fieldbox">
            営業時間2:
            <input id  = "opentime2" 
                   name= "opentime2"
                   type= "time" 
                   value      = "<?= h($shop_data[0]['opentime2']) ?>">～
            <input id  = "closetime2"  
                   name= "closetime2"
                   type= "time"
                   value      = "<?= h($shop_data[0]['closetime2']) ?>">
                   <button class="btn btn-primary" type="button" id="resetButton2">リセットする</button>
        </label>
                
        <br />
        
        
        <label class="fieldbox">                                                      
            定休日1　:                                                  
            <select name="holiday1">
                <option></option>
                <?php
                    foreach($holiday as $data){
                        $selected = '';
                        if ($data['name'] == $shop_data[0]['holiday1']) {
                            $selected = 'selected';
                        }else{
                             $selected = '""';
                        }
                ?>
                    <option value="<?= h($data['name']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
            </select>
        </label><br />
        
        <label class="fieldbox">
            定休日2　:                                     
            <select name="holiday2">
                <option></option>
                <?php
                    foreach($holiday as $data){
                        $selected = '';
                        if ($data['name'] == $shop_data[0]['holiday2']) {
                            $selected = 'selected';
                        }else{
                             $selected = '""';
                        }
                ?>
                    <option value="<?= h($data['name']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
            </select>
        </label><br />
        
        <label class="fieldbox">   
            定休日3　:                                                    
            <select name="holiday3">
                <option></option>
                <?php
                    foreach($holiday as $data){
                        $selected = '';
                        if ($data['name'] == $shop_data[0]['holiday3']) {
                            $selected = 'selected';
                        }else{
                             $selected = '""';
                        }
                ?>
                    <option value="<?= h($data['name']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
            </select>
        </label><br />
        
        <label class="fieldbox">
            パスワード<font color="red">（必須）</font><br />
            <input id         = "shop_pw"
                   name       = "shop_pw"
                   type       = "password" 
                   value      = "<?= h($shop_data[0]['shop_pw']) ?>"           
                   required
                   maxlength  = "60"   
                   placeholder= "半角英数字8字以内で入力してください">
            <span class="errormsg" 
                  id   ="passError">           
            </span>
        </label><br />
        
        <label class="fieldbox">
            確認用パスワード<font color="red">（必須）</font><br />
            <input id        = "pass_confirm" 
                   name      = "pass_confirm"
                   type      = "password"
                   value     = "<?= h($shop_data[0]['shop_pw']) ?>"
                   required
                   maxlength = "60"   >
            <span class="errormsg" 
                id="confirmError">
            </span>
            <span class="errormsg" 
                id="matchError">
            </span>
        </label><br />
        
        <label>各種SNSのURLを入力してください。</label><br />
        <label class="fieldbox">
            <input id        = "url_hp"
                   name      = "url_hp"
                   class      = "input_box form-control"
                   type      = "text"
                   value     = "<?= h($shop_data[0]['url_hp']) ?>"
                   maxlength = "500"
                   placeholder= "ホームページのURL">
        </label><br />
        <label class="fieldbox">
            <input id         = "url_sns1"
                   name       = "url_sns1"
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['url_sns1']) ?>"
                   maxlength  = "500"
                   placeholder= "LINEのURL">
        </label><br />
        <label class="fieldbox">
            <input id         = "url_sns2"
                   name       = "url_sns2"
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['url_sns2']) ?>"
                   maxlength  = "500"
                   placeholder= "InstagramのURL">
        </label>
        <label class="fieldbox">
            <input id         = "url_sns3"
                   name       = "url_sns3"
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['url_sns3']) ?>"
                   maxlength  = "500"
                   placeholder= "TwitterのURL">
        </label> <br />
        <label class="fieldbox">
            <input id         = "url_sns4"
                   name       = "url_sns4"
                   class      = "input_box form-control"
                   type       = "text"
                   value      = "<?= h($shop_data[0]['url_sns4']) ?>"
                   maxlength  = "500"
                   placeholder= "GoogleMapのURL">
        </label> <br />
        <label>&#x1f4f7;サムネイル写真(３枚掲載できます)（※画像アップロードの容量上限：5MB）</label> <br />
            <input id         = "myImage"
                   name       = "my_file[]"
                   type       = "file" 
                   accept     = "image/*" multiple >
        <br /><br />        
        
        <label class="fieldbox">
            取扱商品<br />
            <input id         = "goods"
                   name       = "goods"
                   class      = "input_box form-control" 
                   type       = "text"
                   value      = "<?= h($shop_data[0]['goods']) ?>"
                   maxlength  = "60" 
                   placeholder= "主な取扱商品やメニューを入力してください"
                   style      = "width:70%;">
        </label><br />
        
        <label class="fieldbox1" style=" height: 30%; width  : 50%; resize : none;">
            店舗紹介<br />
            <input id         = "free_text"
                   name       = "free_text"
                   class      = "input_box form-control" 
                   type       = "text"
                   value      = "<?= h($shop_data[0]['free_text']) ?>"
                   maxlength  = "100" 
                   placeholder= "おすすめ商品やメニューがあればご自由に入力ください。(200字以内)"
                   style      = " width:80%; resize : none;">
        </label><br /><br />
        
        <?php echo $this->Form->input('save',
                    [
                    'type'      => 'submit',
                    'id'        => 'save',
                    'class'     => 'submits',
                    'onclick'   => 'btn_click("'.CON_SAVE_IN.'")',
                    'value'     => CON_SAVE_IN2,
                    'style'     => 'width: 100',
                    'label'     => false,
                    ]); ?>
<br /><br />
    </div>
</div>
</form>
<?php echo $this->Form->end() ?>
<script>

    /**
     * 押下ボタンが「検索」か「CSV出力」かを保持するHiddenテキストボックスに値を詰める
     */
    function btn_click(btn_name)
    {
        document.getElementById("btn_click_name").value = btn_name;
    }

    /**
     * 確認メッセージ
     */
    function searchCheck(){
        var agree=confirm("この内容に変更します。よろしいですか？");
        if (agree)
            return true ;
        else
            return false ;
    }
    /*
     * 
     */
    $(document).ready(
        function() {               
            $.fn.autoKana('#shop_nm', '#shop_kn', {
                katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
        });
    });

    // checkbox SHOP_GROUP_CD
    // KARL 2023/01
    document.getElementById('pointCheck').onchange = function() {
    document.getElementById('special_point_cd').disabled = !this.checked;
    };
</script>

