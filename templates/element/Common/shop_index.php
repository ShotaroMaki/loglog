<?php echo $this->Html->css('mobileparts'); ?>   
<div class="block_header">
    <div class="parts_shopnm"><h1 style="overflow-wrap: normal"><?= h($shop_data[0]['shop_nm']) ?></h1></div>
</div>
<hr size="5" width="100%" color="#e72923">
<div class="block_img">
        <div class="tabs">
            <?php if($shop_data[0]['thumbnail1'] != "" and $shop_data[0]['thumbnail2'] == ""){?>
                <input id="all" type="radio" name="tab_item" checked style="display: none;">
            <?php }else{ ?>
                <?php if($shop_data[0]['thumbnail1'] != ""){?>
                    <input id="all" type="radio" name="tab_item" checked>
                <?php } ?>
            <?php } ?>    
            <?php if($shop_data[0]['thumbnail2'] != ""){?>  
                <input id="programming" type="radio" name="tab_item">
            <?php } ?>
            <?php if($shop_data[0]['thumbnail3'] != ""){?>
                <input id="design" type="radio" name="tab_item">
            <?php } ?>

            <div class="tab_content" id="all_content">
                <?php if($shop_data[0]['thumbnail1'] != ""){?>
                <img  class="home_image" src="../webroot/img/Home/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($shop_data[0]['thumbnail1']) ?>"/>
                <?php } ?>
            </div>
            <div class="tab_content" id="programming_content">
                <?php if($shop_data[0]['thumbnail2'] != ""){?>   
                <img  class="home_image" src="../webroot/img/Home/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($shop_data[0]['thumbnail2']) ?>"/>
                <?php } ?>
            </div>
            <div class="tab_content" id="design_content">
                <?php if($shop_data[0]['thumbnail3'] != ""){?>
                <img  class="home_image" src="../webroot/img/Home/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($shop_data[0]['thumbnail3']) ?>"/>
                <?php } ?>
            </div>
                
                
                
        </div>    
    </div>
    <div class="block_info">
        <div class="block_add" >
                <p ></p>
                <p >〒<?= h($shop_data[0]['shop_postcd']) ?> <br /> 
                  <?= h($shop_data[0]['shop_add1']) ?><?= h($shop_data[0]['shop_add2']) ?><?= h($shop_data[0]['shop_add3']) ?><br />
                TEL　<?= h($shop_data[0]['shop_phone']) ?><br />
                <?php
                 $opentime1 ='';
                 $opentime2 ='';
                if($shop_data[0]['opentime1']){
                    $opentime1 = $shop_data[0]['opentime1'].'～'.$shop_data[0]['closetime1'];
                }
                if($shop_data[0]['opentime2']){
                    $opentime2 = $shop_data[0]['opentime2'].'～'.$shop_data[0]['closetime2'];
                } 
                ?>    
                営業時間 ：<?= h($opentime1) ?>　<?= h($opentime2) ?><br />
                定休日：<?= h($shop_data[0]['holiday1']) ?>　<?= h($shop_data[0]['holiday2']) ?>　<?= h($shop_data[0]['holiday3']) ?><br /><br />
                <?php
                if($shop_data[0]['free_text']){ ?>
                <?= h($shop_data[0]['free_text']) ?>
                <?php } ?>
                <?php
                if($shop_data[0]['url_sns4']){ ?>
                <br />
                <a href="<?= h($shop_data[0]['url_sns4']) ?>" target="_blank" rel="norefferrer">Google Mapで表示</a>
                <?php } ?> 
<!--                <br />
                <a href="http://www.facebook.com/share.php?u=http://153.126.145.215/loglog/MlMobile/Mapshop?shop_cd=<?= h($shop_data[0]['shop_cd']) ?>" target="_blank" class="sns-btn -fb">Facebookでシェアする</a>
                <br />
                <a href="https://twitter.com/intent/tweet?url=http://153.126.145.215/loglog/MlMobile/Mapshop?shop_cd=<?= h($shop_data[0]['shop_cd']) ?>" target="_blank" class="sns-btn -tw">Twitterでシェアする</a>-->
                </p>
        </div>
        <div class="block_sns">
             <ul class="list">
                <?php if($shop_data[0]['url_hp'] == ''){ ?>
                    <li><img style="opacity: 0.5;" class = "icon" src="../webroot/img/home.png"/></li>
                <?php }else{ ?>
                    <li><a href="<?= h($shop_data[0]['url_hp']) ?>"  target="_blank" rel="norefferrer"><img class = "icon" src="../webroot/img/home.png"/> </a></li>
                <?php } ?>
                <?php if($shop_data[0]['url_sns1'] == ''){ ?>
                    <li><img style="opacity: 0.5;" class = "icon" src="../webroot/img/line.png"/></li>
                <?php }else{ ?>
                    <li><a href="<?= h($shop_data[0]['url_sns1']) ?>"  target="_blank" rel="norefferrer"><img class = "icon" src="../webroot/img/line.png"/> </a></li>
                <?php } ?>                   
                <?php if($shop_data[0]['url_sns2'] == ''){ ?>
                    <li><img style="opacity: 0.5;" class = "icon" src="../webroot/img/instagram.png"/></li>
                <?php }else{ ?>
                   <li><a href="<?= h($shop_data[0]['url_sns2']) ?>"  target="_blank" rel="norefferrer"><img class = "icon" src="../webroot/img/instagram.png"/> </a></li>
                <?php } ?> 
                <?php if($shop_data[0]['url_sns3'] == ''){ ?>
                    <li><img style="opacity: 0.5;" class = "icon" src="../webroot/img/twitter.jpg"/></li>
                <?php }else{ ?>
                    <li><a href="<?= h($shop_data[0]['url_sns3']) ?>"  target="_blank" rel="norefferrer"><img class = "icon" src="../webroot/img/twitter.jpg"/> </a></li>
                <?php } ?> 
                    
            </ul>

        </div>
    </div>



