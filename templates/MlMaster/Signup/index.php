<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<script src="/loglog/webroot/js/jquery/jquery-3.3.1.slim.min.js"></script>
<script src="/loglog/webroot/js/jquery/jquery.autoKana.js" language="javascript" type="text/javascript"></script>
<?php echo $this->Form->create(null, ['id' => 'signupForm', 'name' => 'signupForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<form method="post">

  <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
    <div style="text-align:center;width: 60%;margin-left: 25%">   
    <div id="sb-site1" style="text-align:left">
            <div class="title">
                店舗登録 &#x270e;
            </div>

            <p style="text-align:center"><font color="red" size="5"><?php $ERR_PHONE ?></font></p>

            <label class="fieldbox">
                店舗名<font color="red">（必須）</font><br />
                <input id         = "shop_nm"
                       class      = "input_box"
                       name       = "shop_nm" 
                       type       = "text"
                       onchange   = "btn_click('<?= h($shop_data[0]['shop_nm']) ?>')"
                       value      = "<?= h($shop_data[0]['shop_nm']) ?>"
                       required 
                       maxlength  = "60">
            </label>
            <br />
            <label class="fieldbox">
                店舗名カナ<br />
                <input id        = "shop_kn"
                       name      = "shop_kn"
                       class      = "input_box"
                       type      = "text"
                       value     = "<?= h($shop_data[0]['shop_kn']) ?>"
                       maxlength = "60" >
            </label>
            <br />
            <label class="fieldbox">
                電話番号<font color="red">（必須）</font><br />
                <input id         = "shop_phone"  
                       name       = "shop_phone"
                       type       = "text"
                       value      = "<?= h($shop_data[0]['shop_phone']) ?>"

                       maxlength  = "15"
                       placeholder= "ハイフン無し半角数字で入力してください">
            </label>
            <br />
            <label class="fieldbox">
                FAX番号<br />
                <input id         = "shop_fax" 
                       name       = "shop_fax" 
                       type       = "text"
                       value      = "<?= h($shop_data[0]['shop_fax']) ?>"
                       maxlength  = "15"
                       placeholder= "ハイフン無し半角数字で入力してください">
            </label>
            <br />
            <label class="fieldbox">
                郵便番号<font color="red">（必須）</font><br />
                <input id         = "shop_postcd" 
                       name       = "shop_postcd" 
                       type       = "text"
                       value      = "<?= h($shop_data[0]['shop_postcd']) ?>"

                       maxlength  = "8"
                       placeholder= "ハイフン無し半角数字で入力してください">
             </label>
             <br />
            <label class="fieldbox">
                都道府県<font color="red">（必須）</font><br />
                <select name="shop_add1" required>
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
                <br />
            </label>

            <label class="fieldbox">
                市区町村<font color="red">（必須）</font><br />
                <input id         = "shop_add2"
                       name       = "shop_add2" 
                       class      = "input_box"
                       type       = "text"
                       value      = "<?= h($shop_data[0]['shop_add2']) ?>"

                       maxlength  = "60"
                       placeholder= "市区町村を入力してください">
            </label>
             <br />
            <label class="fieldbox">
                番地以降の住所<font color="red">（必須）</font><br />
                <input id         = "shop_add3" 
                       name       = "shop_add3" 
                       class      = "input_box"
                       type       = "text"
                       value      = "<?= h($shop_data[0]['shop_add3']) ?>"

                       maxlength  = "60"  
                       placeholder= "番地以降の住所を入力してください">   
            </label><br>

            <label class="fieldbox">
                営業時間1:
                <input id  ="opentime1"
                       name= "opentime1"
                       type= "time"
                       value= "<?= h($shop_data[0]['opentime1']) ?>"
                       >～
                <input id  = "closetime1" 
                       name= "closetime1"
                       type= "time"
                       value= "<?= h($shop_data[0]['closetime1']) ?>">
            </label><br>

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
            </label><br>

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
            </label><br>

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
            </label><br>

            <label class="fieldbox">
                パスワード<font color="red">（必須）</font><br />
                <input id         = "shop_pw"
                       name       = "shop_pw"
                       type       = "password"
                       value      = "<?= h($shop_data[0]['shop_pw']) ?>"

                       maxlength  = "8"   
                       placeholder= "半角英数字8字以内で入力してください">
                <span class="errormsg" 
                      id   ="passError">           
                </span>
            </label><br>

            <label class="fieldbox">
                確認用パスワード<font color="red">（必須）</font><br />
                <input id        = "pass_confirm" 
                       name      = "pass_confirm"
                       type      = "password"
                       value     = "<?= h($shop_data[0]['shop_pw']) ?>"

                       maxlength = "8"   >
                <span class="errormsg" 
                    id="confirmError">
                </span>
                <span class="errormsg" 
                    id="matchError">
                </span>
            </label>
            <br />
           <label>各種SNSのURLを入力してください。</label><br />
            <label class="fieldbox">
                <input id        = "url_hp"
                       name      = "url_hp"
                       class      = "input_box"
                       type      = "text"
                       value     = "<?= h($shop_data[0]['url_hp']) ?>"
                       maxlength = "500"
                       placeholder= "ホームページのURL">
            </label><br />
            <label class="fieldbox">
                <input id         = "url_sns1"
                       name       = "url_sns1"
                       class      = "input_box"
                       type       = "text"
                       value      = "<?= h($shop_data[0]['url_sns1']) ?>"
                       maxlength  = "500"
                       placeholder= "LINEのURL">
            </label><br />
            <label class="fieldbox">
                <input id         = "url_sns2"
                       name       = "url_sns2"
                       class      = "input_box"
                       type       = "text"
                       value      = "<?= h($shop_data[0]['url_sns2']) ?>"
                       maxlength  = "500"
                       placeholder= "InstagramのURL">
            </label>
            <label class="fieldbox">
                <input id         = "url_sns3"
                       name       = "url_sns3"
                       class      = "input_box"
                       type       = "text"
                       value      = "<?= h($shop_data[0]['url_sns3']) ?>"
                       maxlength  = "500"
                       placeholder= "TwitterのURL">
            </label> <br />
            <label class="fieldbox">
                <input id         = "url_sns4"
                       name       = "url_sns4"
                       class      = "input_box"
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
            カテゴリー                                                   
            <select name="category_cd">
                <option></option>
                <?php 
                    foreach($ctgy as $data){
                        $selected = '';
                        if ($shop_data[0]['category_cd'] == $data['category_cd']) {
                            $selected = 'selected=""';
                        }
                ?>        
                    <option value="<?= h($data['category_cd']) ?>"<?= h($selected); ?>><?= h($data['category_nm']) ?></option>
                <?php } ?>
            </select>
            <br />
            <br />
            <label class="fieldbox">
                取扱商品:
                <input id         = "goods"
                       name       = "goods" 
                       type       = "text"
                       maxlength  = "60" 
                       value      = "<?= h($shop_data[0]['goods']) ?>"
                       placeholder= "主な取扱商品やメニューを入力してください">
            </label>
            <br />
            <label class="fieldbox1" style=" height: 30%; width  : 50%; resize : none;">
                店舗紹介<br />
                <input id         = "free_text"
                       name       = "free_text" 
                       type       = "text"
                       value      = "<?= h($shop_data[0]['free_text']) ?>"
                       maxlength  = "100" 
                       placeholder= "おすすめ商品やメニューがあればご自由に入力ください。(200字以内)"
                       style      = " width:80%; resize : none;">
            </label>
            <br />
            <label>                                                      
               有料会員<br>                                                    
               <select name="paidmember">
                <option></option>
                <?php 
                    foreach($paidmembers as $data){
                        $selected = '';
                        if ($shop_data[0]['paidmember'] == $data['cd']) {
                            $selected = 'selected=""';
                        }
                ?>        
                    <option value="<?= h($data['cd']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
               </select>
            </label>
            <br />
            <label>                                                      
               ポイントカード<br>                                                    
               <select name="point">
                <option></option>
                <?php 
                    foreach($point as $data){
                        $selected = '';
                        if ($shop_data[0]['point'] == $data['cd']) {
                            $selected = 'selected=""';
                        }
                ?>        
                    <option value="<?= h($data['cd']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
               </select>
            </label>
            <br /><br />
            <?php echo $this->Form->input('btn_click_name',[
                                            'type'      => 'text',
                                            'id'        => 'btn_click_name',
                                            'value'     => '',
                                            'hidden',
                                            'label' => false,
                                            ]); ?>
            <?php echo $this->Form->input('save',
                        [
                        'type'      => 'submit',
                        'id'        => 'save',
                        'onclick'   => 'btn_click("'.CON_SAVE_IN2.'")',
                        'value'     => CON_SAVE_IN,
                        'style'   => 'width: 200',
                        'label' => false,
                        ]); ?>
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
        console.log(btn_name);
        
        document.getElementById("btn_click_name").value = btn_name;

    }

    /**
     * 確認メッセージ
     */
    function searchCheck(){
        var agree=confirm("この内容で登録します。よろしいですか？");
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
</script>

