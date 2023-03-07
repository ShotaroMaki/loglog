<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('Mlshoplist'); ?>
<?php echo $this->Form->create(null, ['id' => 'RmsgForm', 'name' => 'RmsgForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
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
            <?php echo $this->Form->input('coupon_cd',[
                                            'type'      => 'text',
                                            'id'        => 'coupon_cd',
                                            'name'      => 'coupon_cd',
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
         <div class="div_his1" style="text-align: center">
            <?php echo $this->Form->input('create',[
                                        'type'      => 'submit',
                                        'class'     => 'msg_create',
                                        'onclick'   => 'btn_click("'.CON_CREATE.'")',
                                        'value'     => CON_CREATE,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                                ]); ?>

        </div><br />
        <div class="div_his1"  style="text-align: center; color:black;">
            <p>※クーポンを編集すると編集前の画像が削除されますので、再度登録をお願いします。</p>
            <p>※クーポンを編集すると使用済みのお客様にも再配布されます。</p>
            <p>※クーポン編集後処理に時間がかかることがあります。</p>
        </div>
        <div class="div_his1"  style="text-align: center">
            <table class="table_id">
                <tr>
                    <td>
                    <!-- 水平ヘッダ -->
                    <div id="header_h" onScroll="OnScrollH()">
                        <table id='table_header'>
                            <tr class="caption">
                                <td hidden></td>
                                <td hidden></td>
                                <td width=20%>更新日時</td>
                                <td width=20%>クーポン名</td>
                                <td width=20%>クーポン内容</td>
                                <td width=20%>有効期限</td>
                                <td width=10%></td>
                                <td width=10%></td>
                            </tr>
                        </table>
                    </div>    
                    <div id="data" onScroll="OnScrollD()">
                        <table id='table_body'>
                            <?php
                            foreach ($cpn_data as $rows ) { ?>
                                <tr class="table_tr">
                                    <td hidden><?= h($rows['shop_cd']); ?></td>
                                    <td hidden><?= h($rows['coupon_cd']); ?></td>
                                    <td align=left width=20%><?= h(substr($rows['updatetime'],0,16)); ?></td>
                                    <td align=left width=20%><?= h($rows['coupon_goods']); ?></td>   
                                    <td align=left width=20%><?= h($rows['coupon_discount']); ?></td> 
                                    <td align=left width=20%><?= h(date('Y-m-d',strtotime($rows['effect_srt']))); ?>～<?= h(date('Y-m-d',strtotime($rows['effect_end']))); ?></td>
                                    <td width=10%>
                                    <?php 
    //                                if($rows['shop_cd']=='0001'){$true='true';}else{$true='false';}
                                    echo $this->Form->input('delete',[
                                                                    'type'      => 'submit',
                                                                    'class'     => 'cpn_delete',
                                                                    'onclick'   => 'btn_click("'.CON_DELETE.'")',
                                                                    'value'     => CON_DELETE,
                                                                    'style'     => 'width: 100',
                                                                    'label'     => false,
    //                                                                'disabled'  => $true,
                                                                    'onsubmit'  => 'return check()'
                                                                    ]); ?>
                                    </td>
                                    <td width=10%>
                                    <?php  echo $this->Form->input('edit',[
                                                                    'type'      => 'submit',
                                                                    'class'     => 'cpn_edit',
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
                    </div>
                </td>
            </tr>
            </table>
        </div>
    </div>
</form>
<?php echo $this->Form->end() ?>
<script>
    
    $(".cpn_delete").on("click", function(){
        var result = window.confirm('本当に削除しますか？');
        if( result ) {
            var coupon_cd = $(this).closest('tr').children("td")[1].innerText;
            document.getElementById("coupon_cd").value = coupon_cd;
        }
    });
    
    $(".cpn_edit").on("click", function(){
        var coupon_cd = $(this).closest('tr').children("td")[1].innerText;
       document.getElementById("coupon_cd").value = coupon_cd;
    });
    
    /**
     * 押下ボタンが「検索」か「CSV出力」かを保持するHiddenテキストボックスに値を詰める
     */
    function btn_click(btn_name)
    {
        document.getElementById("btn_click_name").value = btn_name;
    }
    // スクロール連動
    function OnScrollD() {
        // データ部
        window.header_h.scrollLeft = window.data.scrollLeft;
    }
    function OnScrollH() {
        // ヘッダー部
        window.data.scrollLeft = window.header_h.scrollLeft;
    }
</script>
