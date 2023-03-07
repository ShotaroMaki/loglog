<style>
    label {
  white-space: pre-wrap;
    }
    .naiyou{
        height        : 270px;
        width         : 43%;
        display       : inline-block; 
        vertical-align: top;
        border        : 1px solid black;
        margin        : 2%;
        text-align    : center;
    }
    .preview {
        max-width     : 100%;
        max-height    : 100%;
    }
    .img{
        max-width     : 100%;
        height        : 125px;
        margin        : 1px;
    }
    body{
        margin-left   : 3%;
        margin-right  : 0%;
        margin-top    : 0%;
        width         : 97%;
    }
    .line2{
	position      : relative;
	border-top    : 1px dashed #3D3939;
    }
    
    .line2:before{
 	content       : "";
	display       : block;
	width         : 5px;
	height        : 10px;
	border-radius : 0 5px 5px 0;
        border        : 1px solid black;
        border-left   : 1px solid #ffffff;
	background    : #ffffff;
	position      : absolute;
	top           : -6px;       
    }
    .line2:after{
	content       : "";
	display       : block;
	width         : 5px;
	height        : 10px;
	border-radius : 5px 0 0 5px;
        border        : 1px solid black;
        border-right  : 1px solid #ffffff;
	background    : #ffffff;
	position      : absolute;
	top           : -6px;
    }

.line2:before{left:-1px;}
.line2:after{right:-1px;}




    @media only screen and (max-width: 350px) {
        .shop_nm , .coupon_good , .effect_str , .coupon_disc, .effect_end{
            font-size: 10px;
        }
    }
</style>
<meta name    = "viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
<?php echo $this->Form->create(null, ['id' => 'CpnForm', 'name' => 'CpnForm','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<body>
<form method="post">
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">   
    <?php 
        $i=0;
        foreach ($coupon_data as $val) { 
        //　有効期限をyyyy/mm/ddの形にする
        $str1 = substr($val['effect_srt'], 0, 4);
        $str2 = substr($val['effect_srt'], 4, 2);
        $str3 = substr($val['effect_srt'], -2, 2);
        $str4 = substr($val['effect_end'], 0, 4);
        $str5 = substr($val['effect_end'], 4, 2);
        $str6 = substr($val['effect_end'], -2, 2);

        $val['effect_srt'] = $str1."/".$str2."/".$str3;
        $val['effect_end'] = $str4."/".$str5."/".$str6; 
        
        if($val['used'] == 0){?>
          <div 
            id="naiyou_<?= h($i) ?>" 
            class="naiyou" 
            onclick="confirm_preview('<?= h($coupon_data[$i]['shop_cd']) ?>','<?= h($coupon_data[$i]['coupon_cd']) ?>','<?= h($coupon_data[$i]['coupon_goods']) ?>','<?= h($coupon_data[$i]['shop_nm']) ?>')"
            style="background-color:<?= h($val['background']) ?>"> 
        <?php } else { ?>
            <div 
            id="naiyou_<?= h($i) ?>" 
            class="naiyou" 
            style="background-color:<?= h($val['background']) ?>; filter: opacity(30%);"> 
        <?php }?>    
            
            <div   class="img">
                <?php if($val['thumbnail1'] == ""){?>   
                    <img  class="preview" src="../webroot/img/noimage.png"/>
                <?php }else{ ?>
                    <img class="preview" src="../webroot/img/Coupon/<?= h($val['shop_cd']) ?>/<?= h($val['thumbnail1']) ?>">
                <?php } ?>
            <br></div>

            <div   class="line2" ></div>
            <label class="shop_nm" style="color:<?= h($val['color']) ?>"><?= h($val['shop_nm']) ?></label><br>
            <label class="coupon_good" style="font-size:15px; color:<?= h($val['color']) ?>"><b><?= h($val['coupon_goods']) ?></b></label><br>
            <label class="coupon_disc" style="color:<?= h($val['color']) ?>"><?= h($val['coupon_discount']) ?></label><br>
            <label class="effect_str" style="color:<?= h($val['color']) ?>"><?= h($val['effect_srt']) ?></label>～
            <label class="effect_end" style="color:<?= h($val['color']) ?>"><?= h($val['effect_end']) ?></label><br>

        </div>
    <?php 
       $i++;
     } ?>
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

   
</form>
</body>
<?php echo $this->Form->end() ?>
