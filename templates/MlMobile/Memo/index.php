<?php echo $this->Html->css('mobilememo'); ?>
<meta name    = "viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
<?php echo $this->Form->create(null, ['id' => 'MemoForm', 'name' => 'MemoForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<style>
body{
        margin-left   : 1%;
        margin-right  : 1%;
        padding-left  : 1%;
        margin-top    : 0%;
        width         : 98%;
    }
</style>

<body style="overflow-x: hidden;overflow-y: auto;">
<form method="post">
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
    <div>
        <?php  echo $this->element('Common/shop_index'); ?>
    </div>
    
    <div class="memo_size">
        <br />
        <div style="color:white; text-align: center"><?= h(substr($memo_data[0]['raiten_time'], 0, 16)) ?></div>
        <input id        = "nikki_text"
               name      = "nikki_text"
               class     = "nikki_textbox"
               type      = "text"
               value     = "<?= h($memo_data[0]['nikki_text']) ?>"
               maxlength = "400"
               placeholder= "記録がありません。">
        
        <div class="memo_inputbox">
            <input class="memo_file" name="my_file[]" type="file" id="myImage" accept="image/*" multiple >
        </div>
        <?php if($memo_data[0]['thumbnail1'] == ""){ ?>
        <div hidden></div>
        <?php }else{ ?>
            <div class="msg_tabs">
                   <?php if($memo_data[0]['thumbnail1'] != ""){?>
                       <input id="all" type="radio" name="msg_tab_item" checked>

                   <?php } ?>
                   <?php if($memo_data[0]['thumbnail2'] != ""){?>  
                       <input id="programming" type="radio" name="msg_tab_item">

                   <?php } ?>
                   <?php if($memo_data[0]['thumbnail3'] != ""){?>
                       <input id="design" type="radio" name="msg_tab_item">

                   <?php } ?>

                   <div class="msg_tab_content" id="all_content">
                       <?php if($memo_data[0]['thumbnail1'] != ""){?>
                        <img  name= "thumbnail1" class="memo_image" src="../webroot/img/Memo/<?= h($memo_data[0]['user_cd']) ?>/<?= h($memo_data[0]['thumbnail1']) ?>"/>
                       <?php  } ?>
                   </div>
                   <div class="msg_tab_content" id="programming_content">
                       <?php  if($memo_data[0]['thumbnail2'] != ""){?>   
                        <img  name= "thumbnail2" class="memo_image" src="../webroot/img/Memo/<?= h($memo_data[0]['user_cd']) ?>/<?= h($memo_data[0]['thumbnail2']) ?>"/>
                       <?php  } ?>
                   </div>
                   <div class="msg_tab_content" id="design_content">
                       <?php  if($memo_data[0]['thumbnail3'] != ""){?>
                        <img  name= "thumbnail3" class="memo_image" src="../webroot/img/Memo/<?= h($memo_data[0]['user_cd']) ?>/<?= h($memo_data[0]['thumbnail3']) ?>"/>
                       <?php } ?>
                   </div> 
               </div>
        <?php } ?>
        <div class="memo_button">
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
                        'value'     => CON_SAVE_IN4,
                        'style'     => 'width: 200',
                        'label'     => false,
                        ]); ?>
        </div>
    </div>
    
    <script>
    var fileList = inputElement.files;
 
    // ファイルの数を取得
    var fileCount = fileList.length;
 
    // HTML文字列の生成
    var fileListBody = "選択されたファイルの数 = " + fileCount + "<br/><br/>¥r¥n";
 
     </script>
</form>
<?php echo $this->Form->end() ?>
</body>