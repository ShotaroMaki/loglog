<?php echo $this->Html->css('mobilemsg'); ?>
<meta name    = "viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
<?php echo $this->Form->create(null, ['id' => 'MsgForm', 'name' => 'MsgForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<style>
body{
        margin-left   : 1%;
        margin-right  : 1%;
        padding-left  : 1%;
        margin-top    : 0%;
        width         : 98%;
    }
</style>
<body class="msg_body" style="height:100vh;">
<form method="post">
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
    <div class="parts_size">
        <?php  echo $this->element('Common/shop_index'); ?>
    </div>
    <div  class="msg_size" style="background:<?= h($msg_data[0]['background']) ?>;">
        <div class="msg_image">
            <div class="msg_tabs">
                <?php if($msg_data[0]['thumbnail1'] != ""){?>
                    <input id="all" type="radio" name="msg_tab_item" checked>

                <?php } ?>
                <?php if($msg_data[0]['thumbnail2'] != ""){?>  
                    <input id="programming" type="radio" name="msg_tab_item">

                <?php } ?>
                <?php if($msg_data[0]['thumbnail3'] != ""){?>
                    <input id="design" type="radio" name="msg_tab_item">

                <?php } ?>

                <div class="msg_tab_content" id="all_content">
                    <?php if($msg_data[0]['thumbnail1'] != ""){?>
                     <img  class="msg_image" src="../webroot/img/Message/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($msg_data[0]['thumbnail1']) ?>"/>
                    <?php } ?>
                </div>
                <div class="msg_tab_content" id="programming_content">
                    <?php if($msg_data[0]['thumbnail2'] != ""){?>   
                     <img  class="msg_image" src="../webroot/img/Message/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($msg_data[0]['thumbnail2']) ?>"/>
                    <?php } ?>
                </div>
                <div class="msg_tab_content" id="design_content">
                    <?php if($msg_data[0]['thumbnail3'] != ""){?>
                     <img  class="msg_image" src="../webroot/img/Message/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($msg_data[0]['thumbnail3']) ?>"/>
                    <?php } ?>
                </div> 
            </div>    
        </div>
        <div class="block_msg">
            <label style="color:<?= h($msg_data[0]['color']) ?>"><?= h(substr($msg_data[0]['updatetime'], 0, 16)) ?></label>
        </div>
        <div class="block_msg">
            <label style="color:<?= h($msg_data[0]['color']) ?>"><?= h($msg_data[0]['msg_text']) ?></label>
        </div>       
    </div>
</form>
<?php echo $this->Form->end() ?>
</body>