<?php $this->assign('title', '.loglog'.$title); ?>
<div align=center> 

    <?php echo $this->Form->create(null, ['id' => 'loginForm', 'name' => 'loginForm', 'onsubmit' => 'return searchCheck()']) ?>
    <form method="post">

    <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
    <table style="width:30%;align:center;">
            <tr>
                <h4 style="text-align:center;" >.loglogへようこそ</h4>
                <p id="err_Msg" align=center width=500 height=200 style="color:red"><?= h($ErrMsg) ?></p>
                
            </tr>
            <tr height=30>
                <br />
                <br />
                <td width=50%>ID(電話番号)：</td>
                <td>
                    <?php echo $this->Form->text('login_id', [
                        'id' => 'login_id', 
                        'maxlength' => '15', 
                        'class' => 'Em', 
                        'label' => false, 
                        'pattern'=>'^[a-zA-Z0-9]+$']);?>
                    
                </td>
            </tr>
            <tr height=30>
                <td>PASSWORD：</td>
                <td>
                    <?php echo $this->Form->password('password', [
                        'id' => 'password',  
                        'maxlength' => '8', 
                        'class' => 'Em', 
                        'label' => false, 
                        'pattern'=>'^[a-zA-Z0-9]+$']); ?>
                </td>
            </tr>
        </table>
</div>
<div align="center">
                    <?php echo $this->Form->input('btn_click_name',
                                    [
                                    'type'      => 'text',
                                    'id'        => 'btn_click_name',
                                    'value'     => '',
                                    'hidden',
                                    'label' => false,
                                    
                                    ]); ?>
    
             </br>                   
                    <?php echo $this->Form->input('login',
                                [
                                'type'      => 'submit',
                                'id'        => 'login',
                                'onclick'   => 'btn_click("'.CON_LOG_IN.'")',
                                'value'     => CON_LOG_IN,
                                'style'   => 'width: 100',
                                'label' => false,
                                ]); ?>                              
               </div>
            </br>
            
            </form>       
    <?php echo $this->Form->end() ?> 

</div>
<script>
    /**
     * 押下ボタンが「検索」か「CSV出力」かを保持するHiddenテキストボックスに値を詰める
     */
    function btn_click(btn_name)
    {
        document.getElementById("btn_click_name").value = btn_name;

    }  
</script>    