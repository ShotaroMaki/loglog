<style>
    #naiyou{
        justify-content: center;
        margin-top   : auto;
        margin-left  : auto;
        margin-right : auto;
        width        : 90%;
        border-left  : 1px solid black;
        border-right : 1px solid black;
        border-top   : 1px solid black;
        border-bottom: 1px solid black;
        height: 80%;
    }
    #button{
        justify-content: center;
        width : 90%;
        margin-left  : auto;
        margin-right : auto;
        margin-top   : 45px;
        margin-bottom: 5px;
    }
    #preview {
        border-radius : 3px;
        max-width: 100%;
        max-height: 80%;
    }
    .img{
      max-width: 100%;
      height: 230px;
      margin: 1px;
      justify-content: center;
    }
    .line{
	position      : relative;
	border-top    : 1px dashed #3D3939;
    }
    
    .line:before{
 	content       : "";
	display       : block;
	width         : 5px;
	height        : 10px;
	border-radius : 0 5px 5px 0;
        border        : 1px solid black;
        border-left   : 1px solid #ffffff;
	background    : #ffffff;
	position      : absolute;
	top           : -6px;       
    }
    .line:after{
	content       : "";
	display       : block;
	width         : 5px;
	height        : 10px;
	border-radius : 5px 0 0 5px;
        border        : 1px solid black;
        border-right  : 1px solid #ffffff;
	background    : #ffffff;
	position      : absolute;
	top           : -6px;
    }
.line:before{left:-1px;}
.line:after{right:-1px;}
</style>
<div id="popup">
    <div class="window">
        <span　background="#2693FF" >プレビュー</span>
        <div id="naiyou" >
            <div class="img">
                <img id="preview"><br />
            </div>
            <div   class="line"></div>
            <label id="coupon_shop_nm"><?= h($shop_nm) ?></label><br />
            <label id="coupon_goods_prev" style = "white-space: pre-wrap;"></label><br />
            <label id="coupon_discount_prev" style = "white-space: pre-wrap;"></label><br />
            <label id="effect_srt_prev"></label>
            <font  id="from">～</font>
            <label id="effect_end_prev"></label><br />
        </div > 
        <div id="button">
            <?php echo $this->Form->input('save',
                    [
                        'type'      => 'submit',    
                        'id'        => 'save',
                        'onclick'   => 'btn_click("'.CON_SAVE_IN.'")',
                        'value'     => CON_SAVE_IN,
                        'style'     => 'width: 200',
                        'label'     => false,
                    ]); ?>
            <button id="cancel" onclick="return func_cancel()">キャンセル</button>
        </div>
    </div>
</div>
<script>

    /*
     * プレビュー押下
     */
    function confirm_preview(paid) {

        // 
        document.getElementById('coupon_goods_prev').innerHTML    = coupon_goods.value;
        document.getElementById('coupon_discount_prev').innerHTML = coupon_discount.value;
        document.getElementById('effect_srt_prev').innerHTML      = effect_srt.value;
        document.getElementById('effect_end_prev').innerHTML      = effect_end.value;
        document.getElementById('popup').style.display            = 'block';

        // 会員であれば
        if(paid !== '0'){
            document.getElementById('coupon_shop_nm').style.color       = color.value;
            document.getElementById('coupon_goods_prev').style.color    = color.value;
            document.getElementById('coupon_discount_prev').style.color = color.value;
            document.getElementById('effect_srt_prev').style.color      = color.value;
            document.getElementById('effect_end_prev').style.color      = color.value;
            document.getElementById('from').style.color                 = color.value;
            document.getElementById("naiyou").style.background          = background.value;            
        }
        return false;
    }

    /*
     * キャンセル押下
     */
    function func_cancel() {
        document.getElementById('popup').style.display = 'none';
        return false;
    }

    /*
     * 画像表示
     */
    function setImage(target) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("preview").setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(target.files[0]);
    }

</script>