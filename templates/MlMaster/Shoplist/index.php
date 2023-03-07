<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('Mlshoplist'); ?>
<form method="post">

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
        <?php echo $this->Form->input('shop_cd',[
                                        'type'      => 'text',
                                        'id'        => 'shop_cd',
                                        'name'      => 'shop_cd',
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
    <div class="div_his1"  style="text-align: center">
        <table class="search_table" >
            <tr class="caption">
                <td width=20%>店舗コード</td>
                <td><input style="width:98%;" name="shop_cd1" value="<?= h($shop_cd1); ?>"></td>
            </tr>
            <tr class="caption">
                <td width=20%>店舗名</td>
                <td><input style="width:98%;" name="rank_cd1" value="<?= h($shop_nm1); ?>"></td>
            </tr>
            <tr class="caption">
                <td width=20%>店舗名カナ</td>
                <td><input style="width:98%;" name="shop_kn1" value="<?= h($shop_kn); ?>"></td>
            </tr>
            <tr class="caption">
                <td width=20%>電話番号</td>
                <td><input style="width:98%;" name="tel1" value="<?= h($tel); ?>"></td>
            </tr>            
        </table>    
    </div>
    <br />
    <div class="div_his1" style="text-align: center">
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
    </div>
    <div class="div_his1"  style="text-align: center">
        <table class="table_id">
            <tr>
                <td>
                    <!-- 水平ヘッダ -->
                    <div id="header_h" onScroll="OnScrollH()">
                        <table id='table_header'>
                            <tr class="caption">
                                <td width=10%>店舗コード</td>
                                <td width=20%>店舗名</td>
                                <td width=30%>URL</td>
                                <td width=10%>電話番号</td>
                                <td width=10%>パスワード</td>
                                <td width=10%></td>
                                <td width=10%></td>
                            </tr>
                        </table>
                    </div>
                    <div id="data" onScroll="OnScrollD()">
                        <table id='table_body'>
                            <?php
                            foreach ($shop_data1 as $rows ) { ?>
                                <tr class="table_tr">
                                    <td align=left width=10%><?= h($rows['shop_cd']); ?></td>
                                    <td align=left width=20%><?= h($rows['shop_nm']); ?></td>
                                    <td align=left width=30%>http://153.126.145.215/loglog/MlLogin/Login?shop_cd=<?= h($rows['shop_cd']) ?></td>
                                    <td align=left width=10%><?= h($rows['shop_phone']); ?></td>
                                    <td align=left width=10%><?= h($rows['shop_pw']) ?></td>   
                                    <td width=10%>
                                    <?php 
                                    if($rows['shop_cd']=='0001'){$true='true';}else{$true='false';}
                                    echo $this->Form->input('delete',[
                                                                    'type'      => 'submit',
                                                                    'class'     => 'shop_delete',
                                                                    'onclick'   => 'btn_click("'.CON_DELETE.'")',
                                                                    'value'     => CON_DELETE,
                                                                    'style'     => 'width: 100',
                                                                    'label'     => false,
                                                                    'disabled'  => $true,
                                                                    'onsubmit'  => 'return check()'
                                                                    ]); ?>
                                    </td>
                                    <td width=10%>
                                    <?php  echo $this->Form->input('edit',[
                                                                    'type'      => 'submit',
                                                                    'class'     => 'shop_edit',
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
    
    $(".shop_delete").on("click", function(){
        var agree=confirm("店舗を削除します。よろしいですか？");
        if (agree){
            var shop_cd = $(this).closest('tr').children("td")[0].innerText;
            document.getElementById("shop_cd").value = shop_cd;        
        }else{
            return false ;
        }
    });
    
    $(".shop_edit").on("click", function(){
       // 
       var shop_cd = $(this).closest('tr').children("td")[0].innerText;
       document.getElementById("shop_cd").value = shop_cd;
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
