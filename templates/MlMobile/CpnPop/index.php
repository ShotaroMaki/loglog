
<?php echo $this->Html->css('mobilecpnpop'); ?>
<meta name = "viewport" charset="utf-8" content="width=device-width,initial-scale=1.0,user-scalable=no" />

<?php echo $this->Form->create(null, ['id'      => 'CpnPopForm',
                                       'name'    => 'CpnPopForm',
                                       'method'  => 'post', 
                                       'enctype' =>'multipart/form-data']) ?>
<body>
<form method="post">
    <input class="backbutton"type="button" onclick="history.back()" value="×">
    <?php 
        //　有効期限をyyyy/mm/ddの形にする
        $str1 = substr($coupon_data[0]['effect_srt'], 0, 4);
        $str2 = substr($coupon_data[0]['effect_srt'], 4, 2);
        $str3 = substr($coupon_data[0]['effect_srt'], -2, 2);
        $str4 = substr($coupon_data[0]['effect_end'], 0, 4);
        $str5 = substr($coupon_data[0]['effect_end'], 4, 2);
        $str6 = substr($coupon_data[0]['effect_end'], -2, 2);

        $coupon_data[0]['effect_srt'] = $str1."/".$str2."/".$str3;
        $coupon_data[0]['effect_end'] = $str4."/".$str5."/".$str6;?>
        
    <div id = "naiyou_0" 
         class ="naiyou" 
         accesskey=""style="background-color:<?= h($coupon_data[0]['background']) ?>" > 
 
            
            <div   class="img">
                <?php if($coupon_data[0]['thumbnail1'] == ""){?>   
                <img  class="preview" src="../webroot/img/noimage.png"/>
                <?php }else{ ?>
                <img class="preview" src="../webroot/img/Coupon/<?= h($coupon_data[0]['shop_cd']) ?>/<?= h($coupon_data[0]['thumbnail1']) ?>">
                <?php } ?>
                <br></div>
            
            <div   class="line2" ></div>
            <div   class="text" ></div>
            <label class="shop_nm" style="color:<?= h($coupon_data[0]['color']) ?>"><?= h($coupon_data[0]['shop_nm']) ?></label><br>
                <label class="coupon_good" style="color:<?= h($coupon_data[0]['color']) ?>"><b><?= h($coupon_data[0]['coupon_goods']) ?></b></label><br>
                <label class="coupon_disc" style="color:<?= h($coupon_data[0]['color']) ?>"><?= h($coupon_data[0]['coupon_discount']) ?></label><br>
                <label class="effect_str" style="color:<?= h($coupon_data[0]['color']) ?>"><?= h($coupon_data[0]['effect_srt']) ?></label>～
                <label class="effect_end" style="color:<?= h($coupon_data[0]['color']) ?>"><?= h($coupon_data[0]['effect_end']) ?></label><br>
                <button class="button2" type="button" onclick="confirm_preview('<?= h($coupon_data[0]['shop_cd']) ?>','<?= h($coupon_data[0]['coupon_cd']) ?>','<?= h($coupon_data[0]['coupon_goods']) ?>','<?= h($coupon_data[0]['shop_nm']) ?>')">使用する</button>
            </div>
        </div>
        
    <?php echo $this->Form->input('shop_cd',
                    [
                    'type'      => 'text',
                    'id'        => 'shop_cd',
                    'value'     => '',
                    'hidden',
                    'label' => false,

                    ]); ?>
    <?php echo $this->Form->input('coupon_cd',
                    [
                    'type'      => 'text',
                    'id'        => 'coupon_cd',
                    'value'     => '',
                    'hidden',
                    'label' => false,

                    ]); ?>
    <?php echo $this->element('Common/confirm_msg'); ?>
              
</body>



