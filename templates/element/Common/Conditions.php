<?php if($shop_data[0]['paidmember'] == '1'){ ?>
<?php echo $this->Html->css('Conditions'); ?>
<div class="Conditions">
    ※絞込条件<br />
    <div class="dselect">
        都道府県　：
        <select name="user_add" class="select">
            <option></option>
            <?php foreach($area as $data){
                $selected = '';
                if ($data['area_nm'] == $prefecture) {
                    $selected = 'selected';
                }else{
                     $selected = '""';
                }
             ?>    
                <option value="<?= h($data['area_nm']) ?>" <?= h($selected); ?>><?= h($data['area_nm']) ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="dselect">
        年齢　　　：
        <select name="age" class="select">
           <option></option>
                <?php
                    foreach($ages as $data){
                        $selected = '';
                        if ($data['cd'] == $age) {
                            $selected = 'selected';
                        }else{
                             $selected = '""';
                        }
                ?>
                    <option value="<?= h($data['cd']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="dselect">
        性別　　　：
        <select name="gender" class="select">
            <option></option>
                <?php
                    foreach($genders as $data){
                        $selected = '';
                        if ($data['cd'] == $genderB) {
                            $selected = 'selected';
                        }else{
                             $selected = '""';
                        }
                ?>
                    <option value="<?= h($data['cd']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="dselect">
        誕生日　　：
        <select name="birth_month" class="select">
           <option></option>
                <?php
                    foreach($months as $data){
                        $selected = '';
                        if ($data['cd'] == $birthday) {
                            $selected = 'selected';
                        }else{
                             $selected = '""';
                        }
                ?>
                    <option value="<?= h($data['cd']) ?>"<?= h($selected); ?>><?= h($data['name']) ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="dselect">
        顧客ランク：
        <select name="rank" class="select">
           <option></option>
            <?php foreach($rank as $data){ 
                $selected = '';
                if ($data['rank_cd'] == $rankB) {
                    $selected = 'selected';
                }else{
                     $selected = '""';
                }
            ?>            
                <option value="<?= h($data['rank_cd']) ?>"<?= h($selected); ?> ><?= h($data['rank_nm']) ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="dselect">
        <label class="coupon_goods fieldbox">
            背景選択　：
            <input type="color"
                   name="background" 
                   class="select"
                   id="background"
                   value="<?php  echo $background; ?>">
        </label><br>
        <label class="coupon_goods fieldbox">
            文字色選択：
            <input type="color"
                   name="color"
                   class="select"
                   id="color"
                    value="<?php  echo $color; ?>">
        </label><br>
    </div>
</div>
<?php } else { ?>
    ※絞込条件<br />
    <font color="red">(※こちらはプレミアム会員様のみご利用いただけます)</font>
    <br />
<?php } ?>
