<?php echo $this->Html->css('navbar'); ?>
<?php $shop_cd = $this->request->getQuery('shop_cd'); ?>

<div id="mySidenav" class="sidenav" hidden>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="../ml-home/home?shop_cd=<?= h($shop_cd) ?>">■トップ</a>
    <div onclick="drop_menu('1');">
        <a>■クーポン管理</a>
    </div>
    <div id="drop_menu1" hidden="">
        <a href="../ml-coupon/coupon?shop_cd=<?= h($shop_cd) ?>">&nbsp;&nbsp;&nbsp;&nbsp;クーポン作成</a>
        <a href="../MlRCpn/RCpn?shop_cd=<?= h($shop_cd) ?>">&nbsp;&nbsp;&nbsp;&nbsp;クーポン履歴</a>
    </div>
    <div onclick="drop_menu('2');">
        <a>■メッセージ管理</a>
    </div>
    
    <div id="drop_menu2" hidden="">
        <a href="../ml-message/message?shop_cd=<?= h($shop_cd) ?>">&nbsp;&nbsp;&nbsp;&nbsp;メッセージ作成</a>
        <a href="../MlRMsg/RMsg?shop_cd=<?= h($shop_cd) ?>">&nbsp;&nbsp;&nbsp;&nbsp;メッセージ履歴</a>
        <a href="http://133.242.50.64:8888/#/chat/<?= h($shop_cd) ?>">&nbsp;&nbsp;&nbsp;&nbsp;チャット</a>
    </div>

<!--    <div onclick="drop_menu('3');">
        <a>■顧客管理</a>
    </div>
    <div id="drop_menu3" hidden="">
        <a href="../ml-message/message?shop_cd=<?= h($shop_cd) ?>">&nbsp;&nbsp;&nbsp;&nbsp;顧客台帳</a>
    </div>-->
    <div onclick="drop_menu('4');">
        <a href="../MlQrcode/Qrcode?shop_cd=<?= h($shop_cd) ?>">■QRコード</a>
    </div>
    <div onclick="drop_menu('4');">
        <a href="../ml-edit/edit?shop_cd=<?= h($shop_cd) ?>">■登録内容変更</a>
    </div>
    <!--ミリオネット側管理画面-->
    <?php if ($shop_cd=='0001'){ ?>
    <div onclick="drop_menu('4');">
        <a href="../MlMaster/Shoplist?shop_cd=<?= h($shop_cd) ?>">■店舗登録</a>
        <a href="../MlMaster/Report?shop_cd=<?= h($shop_cd) ?>">■実績レポート</a>
    </div>
    <div onclick="drop_menu('4');">
        <a href="../MlMaster/Category?shop_cd=<?= h($shop_cd) ?>">■カテゴリー登録</a>
    </div>
    <div onclick="drop_menu('4');">
        <a href="../MlMaster/Custrank?shop_cd=<?= h($shop_cd) ?>">■顧客ランク登録</a>
    </div>
    <!-- KARL 2023/01 -->
    <div onclick="drop_menu('4');">
        <a href="../MlMaster/Poll?shop_cd=<?= h($shop_cd) ?>">■アンケート</a>
    </div>
    <?php }?>
</div>
