<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('MlCategory'); ?>

<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
<div id="sb-site" style="overflow: auto;padding-top: 5px;padding-bottom: 5px;">
    <div class="title"><?= h($title); ?></div>
    
<?php echo $this->Form->create(null, ['id' => 'CategoryForm', 'name' => 'CategoryForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>    <div >
        <p style="text-align:center"><font  size="5">カテゴリ名</font></p>
        <input type  = "text" 
               id    = "category_nm"
               name  = "category_nm" 
               value = ""/>
       <br /><br />

        <?php echo $this->Form->input('btn_click_name',[
                                        'type'      => 'text',
                                        'id'        => 'btn_click_name',
                                        'value'     => '',
                                        'hidden',
                                        'label' => false,
                                        ]); ?>

        <?php echo $this->Form->input('save',[
                                        'type'      => 'submit',
                                        'id'        => 'ctgy_save',
                                        'onclick'   => 'btn_click("'.CON_SAVE_IN3.'")',
                                        'value'     => CON_SAVE_IN3,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                        ]); ?>

    </div>
    <br />
    <div class="div_his1">
        <table class="table_his">
            <tr>
                <td>
                    <table class="topic">
                        <tr class="caption"><th text-align="left">カテゴリー一覧</th></tr>
                    </table>
                    <table class="topic">
                        <tr class="caption">
                            <td width=10%>コード</td>
                            <td width=60%>カテゴリー名</td>
                            <td width=20%></td>
                        </tr>
                    </table>
                    <table class="tables">
                        <?php foreach ($category_data as $rows ) { ?>
                            <tr class="table_tr">
                                <td align=left width=10%><?= h($rows['category_cd']); ?></td>
                                <td align=left width=60%><?= h($rows['category_nm']) ?></td>                                <td width=20%>
                                <?php echo $this->Form->input('delete',[
                                                                'type'      => 'submit',
                                                                'id'        => 'ctgy_delete',
                                                                'onclick'   => 'btn_click("'.$rows['category_cd'].'")',
                                                                'value'     => CON_DELETE,
                                                                'style'     => 'width: 100',
                                                                'label'     => false,
                                                                'onsubmit'  => 'return check()'
                                                                ]); ?>
                                </td>    
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
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
    /**
     * 確認メッセージ
     */
   
    function searchCheck(){
        var msg = "";
        var btn_name = document.getElementById("btn_click_name").value;
        if( btn_name === '追加'){
            msg = 'カテゴリーを登録します。よろしいですか？';
        }else{
            msg = 'カテゴリーを削除します。よろしいですか？';
        }
        var agree = window.confirm(msg);
        if (agree)
            return true ;
        else
            return false ;
    }
</script>