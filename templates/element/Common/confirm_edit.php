<style>
    .button{
        justify-content: center;
        text-align: center;
    }
    #preview {
        margin-top    : 5px;
        margin-left   : 5px;
        margin-right  : 5px;
        margin-bottom : 5px;
        border-radius : 3px;
        max-width     : 50%;
        height        : 50%;
    }
    #preview::after {
      content: '';
      background-color: rgba(0,0,0,.5);
    }
    .msg_window {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 80vw;
            height: 50vw;
            background-color: #ffffff;
            border-radius: 4px;
            align-items: center;
            transform: translate(-50%, -50%);
    }
    .header ,.text{
        text-align: center;
        margin: 5%;
        color: #3D3939;
    }
    .submits{
        width           : 40%;
        text-align      : center;
        font-size       : 14px;
        border-radius   : 20px 20px 20px 20px;
        background      : #3D3939;
        color           : #ffffff;
        border          : 1px solid #3D3939;
        height          : 40px; 
    }
    .button2{
        width           : 40%;
        text-align      : center;
        font-size       : 14px;
        border-radius   : 20px 20px 20px 20px;
        background      : #ffffff;
        color           : #3D3939;
        border          : 1px solid #3D3939;
        height          : 40px; 
    }
    
</style>
<div id="popup">
    <div class="msg_window">
        <div class="header">確認</div>
        <div class="line"></div>
        <div class="text">登録内容を変更します。</div >
        <div class="text">よろしいですか？</div >
        <div class="button">
                   <?php echo $this->Form->input('save',
                    [
                    'type'      => 'submit',
                    'id'        => 'save',
                    'class'     => 'submits',
                    'onclick'   => 'btn_click("'.CON_SAVE_IN2.'")',
                    'value'     => CON_SAVE_IN2,
                    'style'     => 'width: 30%',
                    'label'     => false,
                    ]); ?>

            <button id="cancel" class="button2" onclick="return func_cancel()" style="width: 30%">いいえ</button>
        </div>
    </div>
</div>
<script>
    /*
     * プレビュー押下
     */
    function confirm_preview() {
        document.getElementById('popup').style.display = 'block';
        return false;
    }
    /*
     * 更新押下
     */
    function btn_click(btn_name) {
        pass_confirm.setCustomValidity('');
        document.getElementById("btn_click_name").value = btn_name;
    }
    /*
     * キャンセル押下
     */
    function func_cancel() {
        document.getElementById('popup').style.display = 'none';
        return false;
    }
</script>