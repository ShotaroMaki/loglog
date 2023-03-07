<?php $this->assign('title', '.loglog'.$title); ?>
<?php  echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('MlHome'); ?>

<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<?php echo $this->Form->create(null, ['id' => 'HomeForm', 'name' => 'HomeForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<form method="post">

 <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
        <div id="div_img">
            <div class="div_img2" >
                <?php if($shop_data[0]['thumbnail1'] != ""){?>
                <img  class="home_image" src="../webroot/img/Home/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($shop_data[0]['thumbnail1']) ?>"/>
                <?php } ?>
                 <?php if($shop_data[0]['thumbnail2'] != ""){?>   
                <img  class="home_image" src="../webroot/img/Home/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($shop_data[0]['thumbnail2']) ?>"/>
                <?php } ?>
                <?php if($shop_data[0]['thumbnail3'] != ""){?>
                <img  class="home_image" src="../webroot/img/Home/<?= h($shop_data[0]['shop_cd']) ?>/<?= h($shop_data[0]['thumbnail3']) ?>"/>
                <?php } ?>
            </div> 
            <p align="center" >
                <a href="<?= h($shop_data[0]['url_hp']) ?>" style="color:black" ><font size='4'><u><?= h($shop_data[0]['shop_nm']) ?></u></font></a> 
            </p>
        </div>
        <div class="block">
            <p ></p>
            <p >〒<?= h($shop_data[0]['shop_postcd']) ?>　<?= h($shop_data[0]['shop_add1']) ?><?= h($shop_data[0]['shop_add2']) ?><?= h($shop_data[0]['shop_add3']) ?></p> 
            <p >TEL　<?= h($shop_data[0]['shop_phone']) ?>
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
            <p >営業時間 ：<?= h($opentime1) ?>　<?= h($opentime2) ?></p>
            <p >定休日：<?= h($shop_data[0]['holiday1']) ?>　<?= h($shop_data[0]['holiday2']) ?>　<?= h($shop_data[0]['holiday3']) ?>
        </div>
        <div class="div_his">
            <div class="div_his1">
                <table class="table_his">
                    <tr>
                        <td>
                            <table class="topic">
                                <tr class="caption"><th text-align="left">クーポン送信履歴</th></tr>
                            </table>
                            <table class="topic">
                                <tr class="caption">
                                    <td width=30%>年月日</td>
                                    <td width=70%>商品・メニュー名</td>
                                </tr>
                            </table>
                            <table class="tables">
                                <?php foreach ($cpn_data as $rows ) { ?>
                                    <tr class="table_tr">
                                        <td width=30%><?= h(substr($rows['updatetime'],0,10)); ?></td>
                                        <td width=70%><?= h($rows['coupon_goods']) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="div_his1">
                <table class="table_his">
                    <tr>
                        <td>
                            <table class="topic">
                                <tr class="caption"><th >メッセージ履歴</th></tr>
                            </table>
                            <table class="topic">
                                <tr class="caption">
                                    <td width=30% align=left>年月日</td>
                                    <td width=70% align=left>内容</td>
                                </tr>
                            </table>
                            <table  id="table_id" align="center" class="tables">
                                <?php foreach ($msg_data as $rows ) { ?> 
                                <tr class="table_tr">
                                    <td align=left width=30%><?= h(substr($rows['updatetime'],0,10)); ?></td>
                                    <td align=left width=70%><?= h($rows['msg_text']) ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="div_his1">
                <table class="table_his">
                    <tr>
                        <td>
                            <table class="topic">
                                <tr class="caption"><th >新規登録者情報</th></tr>
                            </table>
                            <table class="topic">
                                <tr class="caption">
                                    <td width=30%  align=left>年月日</td>
                                    <td width=70%  align=left>ユーザー名</td>
                                </tr>
                            </table>
                            <table  id="table_id" align="center" class="tables">
                                <tbody id="prod_body" >
                                    <?php foreach ($user_data as $rows ) { ?>
                                    <tr class="table_tr">
                                        <td align=left width=30%><?= h(substr($rows['updatetime'],0,10)); ?></td>
                                        <td align=left width=70%><?= h($rows['user_nm']) ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php if($shop_data[0]['shop_cd'] == '0001'){ ?>
                <table  class="tables">
                    <tr>
                        <th class="thd"><?= h($priv_month); ?>月登録加盟店合計</th>
                        <td><?= h($Pshop_cnt); ?>店</td>
                    </tr>
                    <tr>
                        <th class="thd"><?= h($this_month); ?>月登録加盟店合計</th>
                        <td><?= h($Tshop_cnt); ?>店</td>
                    </tr>
                    <tr>
                        <th class="thd">加盟店総合計</th>
                        <td><?= h($shop_cnt); ?>店</td>
                    </tr>
                    <tr>
                        <th class="thd"><?= h($priv_month); ?>月登録ユーザー合計</th>
                        <td><?= h($Puser_cnt); ?>人</td>
                    </tr>
                    <tr>
                        <th class="thd"><?= h($this_month); ?>今月登録ユーザー合計</th>
                        <td><?= h($Tuser_cnt); ?>人</td>
                    </tr>
                    <tr>
                        <th class="thd">ユーザー総合計</th>
                        <td><?= h($user_cnt); ?>人</td>
                    </tr>
                </table>
                <?php } ?>
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
        document.getElementById("btn_click_name").value = btn_name;
    }
</script>

