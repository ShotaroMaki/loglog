<?php echo $this->Html->css('mobileschedule'); ?>
<meta name    = "viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
<?php echo $this->Form->create(null, ['id' => 'ScheduleForm', 'name' => 'ScheduleForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<style>
body{
        margin-left   : 3%;
        margin-right  : 3%;
        margin-top    : 0%;
        width         : 97%;
    }
</style>

<body>
<form method="post">
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
    <div class="schedule_size">
        
        <div class="s_header1">予定登録</div>
        <div class="s_header2">カレンダーに予定を追加することができます。</div>
        
        <input type      = "datetime-local"
               name      = "raiten_time"
               class     = "nikki_titlebox"
               
               value     = "<?php  echo $raiten_time2; ?>">
        
        <input id        = "nikki_title"
               name      = "nikki_title"
               class     = "nikki_titlebox"
               type      = "text"
               value     = "<?= h($data[0]['nikki_title']) ?>"
               maxlength = "40"
               required 
               placeholder= "タイトル">
        
        <input id        = "nikki_text"
               name      = "nikki_text"
               class     = "nikki_textbox"
               type      = "text"
               value     = "<?= h($data[0]['nikki_text']) ?>"
               maxlength = "400"
               placeholder= "メモ">
         
        <div class="schedule_button">
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
                        'value'     => CON_SAVE_IN2,
                        'style'     => 'width: 200',
                        'label'     => false,
                        ]); ?>
        </div>
    </div>
</form>
<?php echo $this->Form->end() ?>
</body>