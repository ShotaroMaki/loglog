<style>

    .msg_window {
        position         : fixed;
        top              : 50%;
        left             : 50%;
        width            : 80vw;
        height           : 40vw;
        background-color : #ffffff;
        border-radius    : 4px;
        align-items      : center;
        transform        : translate(-50%, -50%); 
        text-align       : center;
    }
    .header ,.text {
        margin          : 5%;
        color           : #3D3939;
        font-size       : 17px;
    }
    
    .button2{
        width           : 40%;
        font-size       : 14px;
        border-radius   : 20px 20px 20px 20px;
        background      : #ffffff;
        color           : #3D3939;
        border          : 1px solid #3D3939;
        height          : 40px; 
        width           : 40%;
    }
    
</style>
<div id="popup">
    <div class="msg_window">
        <div class="header">エラー</div>
        <div class="line"></div>
        <?php if($shop_search == 'null_shop'){ ?>
        <div class="text">クーポンがありません。</div >
        <?php  }else if($shop_search == 'null_category'){ ?>
        <div class="text">検索カテゴリーでクーポンのあるお店がありません。</div >
        <?php  }else if($shop_search == 'null_address'){ ?>
        <div class="text">現在地付近にクーポンのあるお店がありません。</div >
        <?php  }else if($shop_search == 'null_search_address'){ ?>
        <div class="text">検索エリアにクーポンのあるお店がありません。</div >
        <?php  } ?>
        <button id="cancel" class="button2" onclick="return func_cancel()">閉じる</button>
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
     * キャンセル押下
     */
    function func_cancel() {
        document.getElementById('popup').style.display = 'none';
        return false;
    }
</script>