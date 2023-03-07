<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('Mlshoplist'); ?>
<?php echo $this->Form->create(null, ['id' => 'RmsgForm', 'name' => 'RmsgForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
    <div id="sb-site" style="overflow: hidden;padding-top: 5px;padding-bottom: 5px;">

        <div class="title"><?= h($title); ?></div>
        <?php echo $this->Form->create(null, [
                                      'id'       => 'CustrankForm', 
                                      'name'     => 'CustrankForm',
                                      'method'   => 'post', 
                                      'enctype'  => 'multipart/form-data',
                                      'onsubmit' => 'return check()'
                                    ]) ?>
        <div >
            <?php echo $this->Form->input('msg_cd',[
                                            'type'      => 'text',
                                            'id'        => 'msg_cd',
                                            'name'      => 'msg_cd',
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
            <p>※メッセージを編集すると編集前の画像が削除されますので、再度画像の登録をお願いします。</p>
            <p>※メッセージの編集後処理に時間がかかることがあります。</p>
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
                                    <td width=60%>メッセージ内容</td>
                                    <td width=10%></td>
                                    <td width=10%></td>
                                </tr>
                            </table>
                        </div>
                        <div id="data" onScroll="OnScrollD()">
                            <table id='table_body'>
                            <?php

                            foreach ($msg_data as $rows ) { ?>
                                <tr class="table_tr">
                                    <td hidden><?= h($rows['shop_cd']); ?></td>
                                    <td hidden><?= h($rows['msg_cd']); ?></td>
                                    <td align=left width=30%><?= h(substr($rows['updatetime'],0,16)); ?></td>
                                    <td align=left width=50%><?= h($rows['msg_text']); ?></td>   
                                    <td width=10%>
                                    <?php 
    //                                if($rows['shop_cd']=='0001'){$true='true';}else{$true='false';}
                                    echo $this->Form->input('delete',[
                                                                    'type'      => 'submit',
                                                                    'class'     => 'msg_delete',
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
                                                                    'class'     => 'msg_edit',
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
<?php echo $this->Form->end() ?>
<script>
    
    $(".msg_delete").on("click", function(){
        var result = window.confirm('本当に削除しますか？');
        if( result ) {
           var msg_cd = $(this).closest('tr').children("td")[1].innerText;
           document.getElementById("msg_cd").value = msg_cd;
        }
    });
    
    $(".msg_edit").on("click", function(){
        var msg_cd = $(this).closest('tr').children("td")[1].innerText;
       document.getElementById("msg_cd").value = msg_cd;
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
