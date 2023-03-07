<?php echo $this->Html->css('MlCustrank'); ?>
<form method="post">

  <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
<div id="sb-site" style="overflow: auto;padding-top: 5px;padding-bottom: 5px;">
    <div class="title"><?= h($title); ?></div>
    
    <?php echo $this->Form->create(null, [
                                      'id'       => 'CustrankForm', 
                                      'name'     => 'CustrankForm',
                                      'method'   => 'post', 
                                      'enctype'  => 'multipart/form-data',
                                      'onsubmit' => 'return check()'
                                    ]) ?>
    <?php echo $this->Form->input('shop_cd',[
                                    'type'      => 'text',
                                    'id'        => 'shop_cd',
                                    'name'      => 'shop_cd',
                                    'value'     => '',
                                    'hidden',
                                    'label' => false,
                                    ]); ?>
    <?php echo $this->Form->input('rank_cd',[
                                    'type'      => 'text',
                                    'id'        => 'rank_cd',
                                    'name'      => 'rank_cd',
                                    'value'     => '',
                                    'hidden',
                                    'label' => false,
                                    ]); ?>
    <?php echo $this->Form->input('btn_click_name',[
                                    'type'      => 'text',
                                    'id'        => 'btn_click_name',
                                    'value'     => '',
                                    'hidden',
                                    'label' => false,
                                    ]); ?>
    <br />
    <div class="div_his1">
        <table class="">
            <tr class="caption">
                <td width=20%>店舗コード</td>
                <td><input style="width:98%;"  name="shop_cd" maxlength="6" value="<?= h($rank_data[0]['shop_cd']); ?>"></td>
            </tr>
            <tr class="caption">
                <td width=20%>ランクコード</td>
                <td><input style="width:98%;"  name="rank_cd" maxlength="6" value="<?= h($rank_data[0]['rank_cd']); ?>"></td>
            </tr>
            <tr class="caption">
                <td width=20%>ランクー名</td>
                <td><input style="width:98%;" name="rank_nm" maxlength="60" value="<?= h($rank_data[0]['rank_nm']); ?>"></td>
            </tr>
        </table>
    </div>
    <br />
    <?php echo $this->Form->input('search',[
                                    'type'      => 'submit',
                                    'id'        => 'rank_add',
                                    'onclick'   => 'btn_click("'.CON_SAVE_IN3.'")',
                                    'value'     => CON_SAVE_IN3,
                                    'style'     => 'width: 100',
                                    'label'     => false,
                                    'onsubmit'  => 'return check()'
                                    ]); ?>
    <?php echo $this->Form->input('search',[
                                    'type'      => 'submit',
                                    'id'        => 'modoru',
                                    'onclick'   => 'btn_click("'.CON_CANCEL.'")',
                                    'value'     => CON_CANCEL,
                                    'style'     => 'width: 100',
                                    'label'     => false,
                                    'onsubmit'  => 'return check()'
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

</script>