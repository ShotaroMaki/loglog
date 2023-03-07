<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
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
    <div >
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
    </div>
    <br />
    <div class="div_his1">
        <table class="">
            <tr class="caption">
                <td width=20%>店舗コード</td>
                <td><input style="width:98%;" name="shop_cd1" value="<?= h($shop_cd1); ?>"></td>
            </tr>
            <tr class="caption">
                <td width=20%>ランクコード</td>
                <td><input style="width:98%;" name="rank_cd1" value="<?= h($rank_cd1); ?>"></td>
            </tr>
            <tr class="caption">
                <td width=20%>ランクー名</td>
                <td><input style="width:98%;" name="rank_nm1" value="<?= h($rank_nm1); ?>"></td>
            </tr>            
        </table>    
    </div>
    <br />

    <?php echo $this->Form->input('search',[
                                    'type'      => 'submit',
                                    'id'        => 'rank_search',
                                    'onclick'   => 'btn_click("'.CON_SEARCH.'")',
                                    'value'     => CON_SEARCH,
                                    'style'     => 'width: 100',
                                    'label'     => false,
                                    'onsubmit'  => 'return check()'
                                    ]); ?>
    <?php echo $this->Form->input('search',[
                                    'type'      => 'submit',
                                    'id'        => 'rank_search',
                                    'onclick'   => 'btn_click("'.CON_CREATE.'")',
                                    'value'     => CON_CREATE,
                                    'style'     => 'width: 100',
                                    'label'     => false,
                                    'onsubmit'  => 'return check()'
                                    ]); ?>
    <div class="div_his1">
        <table class="table_his">
            <tr>
                <td>
                    <table class="topic">
                        <tr class="caption">
                            <td width=10%>店舗コード</td>
                            <td width=10%>ランクコード</td>
                            <td width=60%>ランクー名</td>
                            <td width=20%></td>
                        </tr>
                    </table>
                    <table class="tables" id="tables">
                        <?php
                        
                        foreach ($rank_data as $rows ) { ?>
                            <tr class="table_tr">
                                <td align=left width=10%><?= h($rows['shop_cd']); ?></td>
                                <td align=left width=10%><?= h($rows['rank_cd']); ?></td>
                                <td align=left width=40%><?= h($rows['rank_nm']) ?></td>   
                                <td width=20%>
                                <?php echo $this->Form->input('delete',[
                                                                'type'      => 'submit',
                                                                'class'     => 'rank_delete',
                                                                'onclick'   => 'btn_click("'.CON_DELETE.'")',
                                                                'value'     => CON_DELETE,
                                                                'style'     => 'width: 100',
                                                                'label'     => false,
                                                                'onsubmit'  => 'return check()'
                                                                ]); ?>
                                <?php echo $this->Form->input('edit',[
                                                                'type'      => 'submit',
                                                                'class'     => 'rank_edit',
                                                                'onclick'   => 'btn_click("'.CON_UPDATE.'")',
                                                                'value'     => CON_UPDATE,
                                                                'style'     => 'width: 100',
                                                                'label'     => false,
                                                                'onsubmit'  => 'return check()'
                                                                ]); ?>
                                </td>
                            </tr>
                        <?php 
                        } ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
</div>    
</form>
<?php echo $this->Form->end() ?>
<script>
    $(".rank_delete").on("click", function(){
       //
       var shop_cd = $(this).closest('tr').children("td")[0].innerText;
       document.getElementById("shop_cd").value = shop_cd;
       //  
       var rank_cd = $(this).closest('tr').children("td")[1].innerText;
       document.getElementById("rank_cd").value = rank_cd;
    });
    
    $(".rank_edit").on("click", function(){
       // 
       var shop_cd = $(this).closest('tr').children("td")[0].innerText;
       document.getElementById("shop_cd").value = shop_cd;
       // 
       var rank_cd = $(this).closest('tr').children("td")[1].innerText;
       document.getElementById("rank_cd").value = rank_cd;
    });
    /**
     * 押下ボタンが「検索」か「CSV出力」かを保持するHiddenテキストボックスに値を詰める
     */
    function btn_click(btn_name)
    {
        document.getElementById("btn_click_name").value = btn_name;
    }

</script>