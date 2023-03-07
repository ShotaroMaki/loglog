
<?php echo $this->Html->css('mobilecpn'); ?>
<meta name = "viewport" charset="utf-8" content="width=device-width,initial-scale=1.0,user-scalable=no" />

<?php echo $this->Form->create(null, ['id'      => 'CpnForm',
                                       'name'    => 'CpnForm',
                                       'method'  => 'post', 
                                       'enctype' =>'multipart/form-data']) ?>
<body>
<form method="post">
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>"> 
<?php echo $this->element('Common/confirm_cpn'); ?>
<div class="search_container">
<input id  = "search_add" class = "search_shop" name = "search_add" type = "text" placeholder = "エリアを入力してください"/>
<?php echo $this->Form->input('search',[
                               'type'     => 'submit',
                               'class'    => 'search_button' ,
                               'id '      => 'rank_search',
                               'value'    => CON_SEARCH,
                               'label'    => false, 
                               'onsubmit' => 'return check()']);?>
</div>
<ul class="scroll_content">  
    <?php
    // mst0017の分だけ回す
    $category =['洋食','和食','中華','焼肉','カフェ','スイーツ','居酒屋'];
    foreach ($category as $ca) {
        echo $this->Form->input('search',[
                                'type'      => 'submit',
                                'onclick'   => 'btn_click('.$ca.')',
                                'value'     => $ca,
                                'class'     => 'scroll_button',
                                'label'     => false,
                                ]); 
    }?>
</ul> 
    
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
        id      = "naiyou_<?= h($i) ?>" 
        class   = "naiyou" 
        onclick = "frameClick('<?= h($user_cd)?>','<?= h($coupon_data[$i]['shop_cd']) ?>','<?= h($coupon_data[$i]['coupon_cd']) ?>','<?= h($shop_add1) ?>','<?= h($shop_add2) ?>')"
        style   = "background-color:<?= h($val['background']) ?>"> 
        <?php } else { ?>
        <div 
            id    = "naiyou_<?= h($i) ?>" 
            class = "naiyou" 
            style = "background-color:<?= h($val['background']) ?>; filter: opacity(30%);"> 
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
              
</body>
<script type="text/javascript">
    var btn = "<?= h($shop_search) ?>";
    if(btn!==''){
        confirm_preview();
    }
    
    function frameClick(a,b,c,d,e) {
    document.location.href = "https://loglog.biz/loglog/ml-mobile/CpnPop?user_cd="+a+"&shop_cd="+b+"&coupon_cd="+c+"&shop_add1="+d+"&shop_add2="+e;
    }
</script>


