<?php $this->assign('title', '.log.log' . $title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('MlCoupon'); ?>
<?php echo $this->Form->create(null, ['id' => 'CouponForm', 'name' => 'CouponForm', 'onsubmit' => 'return searchCheck()', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
<form method="post">

    <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
    <div id="sb-site">
        <div class="title">
            COUPON &#x1f3ab;
        </div><br />
        <span>
            ※.loglogを登録されているお客様にクーポンが届きます
        </span>
        <br /><br />
        <br />
        <?php echo $this->element('Common/Conditions'); ?>
        <br />



        <label class="EFFECT">
            有効期限<font color="red">（必須）</font><br>
            <input type="date" name="effect_srt" class="effect" id="effect_srt" required value="<?php echo $effect_srt; ?>">～
            <input id="effect_end" type="date" required name="effect_end" value="<?php echo $effect_end; ?>">
        </label>
        
         <!-- 来店条件 NEW ----------------------- 23/03 -->
         <div class="dselect">
            来店条件　：
            <select name="visit_condition" class="select">
                <?php
                foreach ($visit_condition as $data) {
                    $selected = '';
                    if ($data['cd'] == $visit_condition) {
                        $selected = 'selected';
                    } else {
                        $selected = '""';
                    }
                ?>
                    <option value="<?= h($data['cd']) ?>" <?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
            </select>
        </div>
        <!-- 来店条件 NEW ----------------------- 23/03 -->


        <br /><br />
        <label class="coupon_goods fieldbox">
            クーポン名<font color="red">（必須）</font><br>
            <textarea name="coupon_goods" class="coupon_goods" id="coupon_goods" required maxlength="30" placeholder="割引したい商品やメニュー名を入力してください。"><?= h($cpn_data[0]['coupon_goods']) ?></textarea>
        </label>
        <br /><br />
        <label class="coupon_discount">
            クーポン内容<font color="red">（必須）</font><br>
            <textarea name="coupon_discount" class="coupon_discount" id="coupon_discount" required maxlength="30" placeholder="クーポンの詳細を入力してください"><?= h($cpn_data[0]['coupon_discount']) ?></textarea>
        </label>
        <br /><br />
        <label> &#x1f4f7;サムネイル写真（※画像アップロードの容量上限：5MB）<font color="red">（必須）</font></label>
        <br /><br />
        <input type="file" name="my_file[]" id="myImage" accept="image/*" onchange="setImage(this);" onclick="this.value = '';" required>
        <br /><br />
        <?php echo $this->Form->input(
            'btn_click_name',
            [
                'type'      => 'text',
                'id'        => 'btn_click_name',
                'value'     => '',
                'hidden',
                'label'     => false,
            ]
        ); ?>
        <input type="submit" value="プレビュー" name="preview" onclick="return confirm_preview('<?= ($shop_data[0]['paidmember']) ?>')" />
        <?php echo $this->element('Common/Preview'); ?>
        <br />
    </div>
</form>
<?php echo $this->Form->end() ?>

<script>
    /**
     * 行数制限
     */
    let MAX_LINE_NUM = 2;
    var id = new Array("coupon_goods", "coupon_discount");
    console.log(id);
    for (let j = 0; j < 2; j++) {
        // テキストエリアの取得
        let textarea = document.getElementById(id[j]);
        // 入力ごとに呼び出されるイベントを設定
        textarea.addEventListener("input", function() {
            // 各行を配列の要素に分ける
            let lines = textarea.value.split("\n");

            // 入力行数が制限を超えた場合
            if (lines.length > MAX_LINE_NUM) {

                var result = "";

                for (var i = 0; i < MAX_LINE_NUM; i++) {
                    result += lines[i] + "\n";
                }

                textarea.value = result;
            }
        }, false);
    }
    /**
     * 押下ボタンが「検索」か「CSV出力」かを保持するHiddenテキストボックスに値を詰める
     */
    function btn_click(btn_name) {
        document.getElementById("btn_click_name").value = btn_name;
    }
    /**
     * 確認メッセージ
     */

    function searchCheck() {
        var agree = confirm("この内容で登録します。よろしいですか？");
        if (agree)
            return true;
        else
            return false;
    }
</script>