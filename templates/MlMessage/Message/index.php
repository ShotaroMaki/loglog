<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('MlMessage'); ?>

<?php echo $this->Form->create(null, ['id' => 'MessageForm', 'name' => 'MessageForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<form method="post">

  <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
   <div id="sb-site">    
        <div class="title">
            Message &#x2709;
        </div>
        <span>
            ※.loglogを登録されているお客様にメッセージ届きます
        </span>
        <br /><br />
        
        <br />
        <?php echo $this->element('Common/Conditions'); ?>
        <br />
        <label> &#x1f4f7;サムネイル写真(３枚掲載できます)（※画像アップロードの容量上限：5MB） </label> <br /><br />
            <input id         = "myImage"
                   name       = "my_file[]"
                   type       = "file" 
                   accept     = "image/*" multiple >
        <br /><br />
        本文<font color="red">（必須）</font><br>
         <textarea id          = "msg_text" 
                   name        = "msg_text" 
                   class       = "msg_text"
                   style       = "height:100px;
                                  width: 50%;"
                   maxlength   = "200"
                   required
                   placeholder = "200文字以内でメッセージを入力してください"><?= h($msg_data[0]['msg_text']) ?></textarea>
        <br /><br />

            <?php echo $this->Form->input('btn_click_name',
                        [
                        'type'      => 'text',
                        'id'        => 'btn_click_name',
                        'value'     => '',
                        'hidden',
                        'label'     => false,
                        ]); ?>

            <?php echo $this->Form->input('save',
                        [
                        'type'      => 'submit',    
                        'id'        => 'save',
                        'onclick'   => 'btn_click("'.CON_SAVE_IN.'")',
                        'value'     => CON_SAVE_IN,
                        'style'     => 'width: 200',
                        'label'     => false,
                        ]); ?>
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
        var agree=confirm("この内容で登録してホーム画面に戻ります。よろしいですか？");
        if (agree)
            return true ;
        else
            return false ;
    }

</script>
                

