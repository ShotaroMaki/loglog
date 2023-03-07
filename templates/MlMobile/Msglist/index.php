<?php echo $this->Html->css('mobilemsglist'); ?>
<meta name    = "viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
<?php echo $this->Form->create(null, ['id' => 'MsglistForm', 'name' => 'MsglistForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>

    <body>
        <form method="post">
        <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
        <table id="msg_list_table">
        <?php echo $this->Form->input('shop_cd',
                        [
                        'type'      => 'text',
                        'id'        => 'shop_cd',
                        'value'     => '',
                        'hidden',
                        'label' => false,

                        ]); ?>
        <?php echo $this->Form->input('msg_cd',
                        [
                        'type'      => 'text',
                        'id'        => 'msg_cd',
                        'value'     => '',
                        'hidden',
                        'label' => false,

                        ]); ?>
            
            <tbody style="width: 100%">
                <?php foreach ($msg_data as $rows ) { ?>
                    <tr style="width: 100%">
                        <?php if ($rows['connect_kbn'] == 0) { ?>
                            <td class="table_td" style="border-bottom:1px solid #dedede;">
                                <font style="color:#e72923;font-weight: 900">NEW</font>
                                <a href="https://loglog.biz/loglog/MlMobile/msg?
                                   shop_cd=<?= h($rows['shop_cd']) ?>&
                                   msg_cd=<?= h($rows['msg_cd']) ?>&
                                   user_cd=<?= h($rows['user_cd']) ?>">
                                   <font style="font-weight: 800;font-size: initial;"><?= substr(h($rows['updatetime']), 0, 10); ?>&nbsp;<?= h($rows['shop_nm']) ?>からのメッセージ</font>                                </a>
                            </td>
                        <?php }else{ ?>
                            <td class="table_td1" style="border-bottom:1px solid #dedede;">
                                <font style="color:#fff;font-weight: 900">NEW</font>
                                <a href="https://loglog.biz/loglog/MlMobile/msg?
                                   shop_cd=<?= h($rows['shop_cd']) ?>&
                                   msg_cd=<?= h($rows['msg_cd']) ?>&
                                   user_cd=<?= h($rows['user_cd']) ?>">
                                   <font style="font-weight: 800;font-size: initial;"><?= substr(h($rows['updatetime']), 0, 10); ?>&nbsp;<?= h($rows['shop_nm']) ?>からのメッセージ</font>
                                </a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </form>
    </body>
<?php echo $this->Form->end() ?>

    