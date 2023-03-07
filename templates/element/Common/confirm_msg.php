<style>
    
    .comfilm{
        
        width           : 100%;
        text-align      : center;
    }
    .button1{
        width           : 40%;
        text-align      : center;
        font-size       : 14px;
        border-radius   : 20px 20px 20px 20px;
        background      : #3D3939;
        color           : #ffffff;
        border          : 1px solid #3D3939;
        height          : 40px;
        margin-top      : 5%;
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
        margin-top      : 5%;
    }
    #preview {
        margin-top      : 5px;
        margin-left     : 5px;
        margin-right    : 5px;
        margin-bottom   : 5px;
        border-radius   : 3px;
        max-width       : 50%;
        height          : 50%;
    }
    #preview::after {
        content          : '';
        background-color : rgba(0,0,0,.5);
    }
    .msg_window {
        position         : fixed;
        top              : 50%;
        left             : 50%;
        width            : 80vw;
        height           : 100vw;
        background-color : white;
        border-radius    : 4px;
        align-items      : center;
        transform        : translate(-50%, -50%);
    }
    .header{
        font-size        : 17px;
        text-align       : center;
        margin           : 5%;
        color            : #3D3939;
        pointer-events   : none;
        background-color : transparent;
        border           : 0;
    }
    .text{
        font-size        : 17px;
        text-align: center;
        margin           : 0%;
        color            : #3D3939;
        pointer-events   : none;
        background-color : transparent;
        border           : 0;
    }
    .msg_window_text{
        height           : 80vw;
    }
    
    textarea{
        background-color : transparent;
        color            : #3D3939; 
        border           : 0;
        font-size        : 17px;
        white-space      : pre-wrap;
        overflow         : hidden;
        resize           : none;
        height           : 13vw;
        width: 80%;
        line-height: 1.4;
    }
    
    input{
        background-color : transparent;
        color            : #3D3939; 
        border           : 0;
        font-size        : 17px;
        height           : 13vw;
        line-height: 1.4;  
    }
    
    /*携帯対応*/
@media screen and (max-width: 480px) {
     .msg_window {
        position         : fixed;
        top              : 50%;
        left             : 50%;
        width            : 80vw;
        height           : 100vw;
        background-color : white;
        border-radius    : 4px;
        align-items      : center;
        transform        : translate(-50%, -50%);
    }
    .msg_window_text{
        height           : 80vw;
    }
}
/*    :disabled {
        background-color : #ffffff;
        color            : inherit ;
        cursor           : not-allowed;
    }*/
    
</style>
<div id="popup">
   <div class="msg_window">
        <div class="msg_window_text">
            <div class="header">確認</div>
            <div class="line"></div>
            <div class="text"><textarea readonly id="shop_n" style=" text-align: center;"></textarea></div>
            <div class="text"><textarea readonly id="coupon_gd" style=" text-align: center;"></textarea></div>
            <div class="text"><input type="text" readonly style=" text-align: center;" value="を使用しますか？"></div >
        
            <div class="comfilm">
                <?php echo $this->Form->input('save',
                        [
                            'type'      => 'submit',   
                            'class'     => 'button1',
                            'id'        => 'save',
                            'onclick'   => 'btn_click("'.CON_USE.'")',
                            'value'     => CON_USE,
                            'label'     => false,
                        ]); ?>
            <button class="button2" id="cancel"  onclick="return func_cancel()">キャンセル</button>
            </div>
        </div>
    </div>
</div>
<script>
    /*
     * プレビュー押下
     */
    function confirm_preview(shop,coupon,coupon_goods,shop_nm) {
        document.getElementById('shop_cd').value = shop;
        document.getElementById('coupon_cd').value = coupon;
        document.getElementById('shop_n').value = shop_nm+'の';
        document.getElementById('coupon_gd').value = '「'+coupon_goods+'」';
        document.getElementById('popup').style.display = 'block';
        return false;
    }

    /*
     * キャンセル押下
     */
    function func_cancel() {
        document.getElementById('popup').style.display = 'none';
        return false;
    }
</script>