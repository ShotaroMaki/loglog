<?php echo $this->Html->css('mobileedit'); ?>

<script src="/loglog/webroot/js/jquery/jquery-3.3.1.slim.min.js"></script>
<script src="/loglog/webroot/js/jquery/jquery.autoKana.js" language="javascript" type="text/javascript"></script>
<meta name    = "viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
<?php echo $this->Form->create(null, ['id' => 'EdituserForm', 'name' => 'EdituserForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<form method="post">
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
    
<div style="text-align:center;width: 100%">
    <div class="editform" style="text-align:left">
        <br /><br />
        <div class="fieldbox">
            氏名<font color="red">（必須）</font><br />
            <input id         = "user_nm"
                   class      = "input_box"
                   name       = "user_nm" 
                   type       = "text"
                   value      = "<?= h($user_data[0]['user_nm']) ?>"
                   required 
                   maxlength  = "60">
        </div><br />
        <div class="fieldbox">
            氏名カナ<br />
            <input id        = "user_kn"
                   name      = "user_kn"
                   class      = "input_box"
                   type      = "text"
                   value     = "<?= h($user_data[0]['user_kn']) ?>"
                   maxlength = "60" >
         </div><br />
        <div class="fieldbox">
            電話番号<font color = "red">（必須）</font><br />
            <input id          = "user_phone" 
                   name        = "user_phone" 
                   class       = "input_box"
                   type        = "tel"
                   value       = "<?= h($user_data[0]['user_phone']) ?>"
                   required
                   maxlength   = "15"
                   placeholder = "ハイフン無し半角数字で入力してください">
        </div><br />
        <div class="fieldbox">
            パスワード<font color = "red">（必須）</font><br />
            <input id          = "user_pw"
                   name        = "user_pw"
                   class       = "input_box"
                   type        = "password" 
                   value       = "<?= h($user_data[0]['user_pw']) ?>"           
                   required
                   minlength   = "8"
                   maxlength   = "20"
                   placeholder = "半角英数字8～20文字で入力してください">
            <span class = "errormsg" 
                  id    = "passError">           
            </span>
         </div><br />
        
        <div class="fieldbox">
            確認用パスワード<font color = "red">（必須）</font><br />
            <input id          = "pass_confirm" 
                   name        = "pass_confirm"
                   class       = "input_box"
                   type        = "password"
                   value       = "<?= h($user_data[0]['user_pw']) ?>"
                   required
                   minlength   = "8"
                   maxlength   = "20"
                   placeholder = "半角英数字8～20文字で入力してください">
            
            <span class="errormsg" 
                id="confirmError">
            </span>
            <span class="errormsg" 
                id="matchError">
            </span>
            
        </div><br /><br />
        <div class="fieldbox">
            生年月日<br />
            <div class="form-select-wrap">
                
                <?php 
                    $year  = substr($user_data[0]['birthday'],0,4);
                    $month = substr($user_data[0]['birthday'],4,2);
                    $day   = substr($user_data[0]['birthday'],6,2);
                ?>
                
                <select id ="year" name="year">
                    <option></option>
                    <?php
                        foreach($years as $data){
                            $selected = '';
                            if ($data == $year) {
                                $selected = 'selected';
                            }else{
                                 $selected = '""';
                            }
                    ?>
                        <option value="<?= h($data) ?>"<?= h($selected); ?>><?= h($data) ?></option>
                    <?php
                    } ?>
                </select>年
                <select id ="month" name="month">
                    <option></option>
                    <?php
                        for ($i=1;$i<count($months); $i++){
                            $selected = '';
                            if ($months[$i] == $month) {
                                $selected = 'selected';
                            }else{
                                 $selected = '""';
                            }
                    ?>
                        <option value="<?= h(sprintf('%02d', $months[$i])) ?>"<?= h($selected); ?>><?= h(sprintf('%02d', $months[$i])) ?></option>
                    <?php
                    } ?>
                </select>月
                <select id ="day" name="day">
                    <option></option>
                    <?php
                        for ($i=1;$i<count($days); $i++){
                            $selected = '';
                            if ($days[$i] == $day) {
                                $selected = 'selected';
                            }else{
                                 $selected = '""';
                            }
                    ?>
                        <option value="<?= h(sprintf('%02d', $days[$i])) ?>"<?= h($selected); ?>><?= h(sprintf('%02d', $days[$i])) ?></option>
                    <?php
                    } ?>
                </select>日

            </div>

        </div><br />
                                                 
         <div class="fieldbox">
            性別<br />
            <div class="form-select-wrap">
                <select id ="gender"
                        name="gender" >
                   <option></option>
                   <option value ="01" <?php if ( h($user_data[0]['gender']) == 01){ ?>selected<?php } ?>>男性</option>
                   <option value ="02" <?php if ( h($user_data[0]['gender']) == 02){ ?>selected<?php } ?>>女性</option>
                   <option value ="03" <?php if ( h($user_data[0]['gender']) == 03){ ?>selected<?php } ?>>その他</option>
                </select>
            </div>
         </div><br />


        <div class="fieldbox">
            メールアドレス<br />
            <input id          = "user_mail"
                   name        = "user_mail" 
                   class       = "input_box"
                   type        = "email"
                   value       = "<?= h($user_data[0]['user_mail']) ?>"
                   maxlength   = "60"
                   placeholder = "メールアドレスを入力してください">
        </div><br />
        
        <div class="fieldbox">
            都道府県<br />
            <div class="form-select-wrap">
                <select id = "add1" name = "add1">
                    <option></option>
                    <?php
                        foreach($area as $data){
                            $selected = '';
                            if ($data['area_nm'] == $user_data[0]['add1']) {
                                $selected = 'selected';
                            }else{
                                 $selected = '""';
                            }
                    ?>
                        <option value="<?= h($data['area_nm']) ?>"<?= h($selected); ?>><?= h($data['area_nm']) ?></option>
                    <?php } ?>
                </select>
            </div>
         </div><br />
        
        <div class="fieldbox">
            都道府県以降の住所<br />
            <input id          = "add2" 
                   name        = "add2" 
                   class       = "input_box"
                   type        = "text"
                   value       = "<?= h($user_data[0]['add2']) ?>"
                   maxlength   = "120"  
                   placeholder = "都道府県以降の住所を入力してください">   
         </div><br />
               
        <div class="popupbox">
            <button id="cancel" onclick="return func_edit(); " class="input_box">更新</button>
        </div>
        
            <input id         = "rank" 
                   name       = "rank" 
                   hidden
                   value      = "<?= h($user_data[0]['rank']) ?>">
            
            <input id         = "connect_kbn" 
                   name       = "connect_kbn" 
                   hidden
                   value      = "<?= h($user_data[0]['connect_kbn']) ?>">   
    </div>
</div>
<?php echo $this->element('Common/confirm_edit'); ?>

</form>
<?php echo $this->Form->end() ?>
<script>

    /*
     * 更新押下
     */
    function func_edit() {
        var input1 = user_pw.value;
        var input2 = pass_confirm.value;

        
        if(input1.length < 8){
             user_pw.setCustomValidity("パスワードは8文字以上20文字以下で入力してください");
             return ;
        }else{
            user_pw.setCustomValidity('');
            
        }
        if(input2.length < 8 ){
             pass_confirm.setCustomValidity("パスワードは8文字以上20文字以下で入力してください");
             return ;   
        }else{
            pass_confirm.setCustomValidity('');
        }
        if (input1 != input2){
            pass_confirm.setCustomValidity("パスワードが一致しません");
             return true;
        
        } else {
            pass_confirm.setCustomValidity('');
            document.getElementById('popup').style.display = 'block';
            return false;
        }
    }
    /*
     * 
     */
    $(document).ready(
        function() {               
            $.fn.autoKana('#user_nm', '#user_kn', {
                katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
        });
    });
    
</script>

