<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('MlReport'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Select2.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<!-- Select2本体 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<!-- Select2日本語化 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/ja.js"></script>

<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
<div id="sb-site" style="overflow: hidden;padding-top: 5px;padding-bottom: 5px;">

    <div class="title"><?= h($title); ?></div>

    <?php echo $this->Form->create(null, [
                                      'id'       => 'ReportForm', 
                                      'name'     => 'ReportForm',
                                      'method'   => 'post', 
                                      'enctype'  => 'multipart/form-data',
                                      'onsubmit' => 'return check()'
                                    ]) ?>
    <div >
        <?php echo $this->Form->input('btn_click_name',[
                                        'type'      => 'text',
                                        'id'        => 'btn_click_name',
                                        'value'     => '',
                                        'hidden',
                                        'label' => false,
                                        ]); ?>
    </div>
    <br />
    <div class="div_his1" style="text-align: center">

        <input type="month" name="this_month" value="<?= h($this_month)?>" required>
        <br /><br />
        <select class="test-select2" id="tenpo_select" name="tenpo_select">
          <option></option>
            <?php
                foreach($shop_list as $data){
                    $selected = '';
                    if ($data['shop_cd'] == $shop_sentaku) {
                        $selected = 'selected';
                    }else{
                         $selected = '""';
                    }
                ?>
                <option value="<?= h($data['shop_cd']) ?>"<?= h($selected); ?>><?= h($data['shop_nm']) ?></option>
            <?php } ?>
        </select>
        <br /><br />
        <?php echo $this->Form->input('search',[
                                        'type'      => 'submit',
                                        'id'        => 'rank_search',
                                        'onclick'   => 'btn_click("'.CON_SEARCH.'")',
                                        'value'     => CON_SEARCH,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                        ]); ?>
    </div>
    <br /><br />
    <div class="div_his1"  style="text-align: center">
        <table class="table_id" >
            <tr>
                <th></th>
                <th>来店総数</th>
                <th>クーポン利用者数</th>
                <th>回遊率</th>
            </tr>
            <tr>
                <td></td>
                <td><?php if(isset($raiten_tot)){ echo $raiten_tot[0]['count'].'人';} ?></td>
                <td><?php if(isset($Coupon_tot)){ echo $Coupon_tot[0]['count'].'人';} ?></td>
                <td></td>
            </tr>
            <tr>
                <td>施設内順位</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <br />

    <div class="div_his1"  style="text-align: center">
        <table class="table_id">
            <tr>
                <td>
                    <!-- 水平ヘッダ -->
                    <div id="header_h" onScroll="OnScrollH()">
                        <table id='table_header'>
                            <tr class="caption">
                                <th width=100%>CSV出力</th>
                            </tr>
                        </table>
                    </div>
                    <div id="data" onScroll="OnScrollD()">
                        <table id='table_body'>
                            <tr class="table_tr">
                                <td >        <?php echo $this->Form->input('search',[
                                        'type'      => 'submit',
                                        'id'        => 'rank_search',
                                        'onclick'   => 'btn_click("'.CON_A.'")',
                                        'value'     => CON_A,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                        ]); ?></td>
                                <td >        <?php echo $this->Form->input('search',[
                                        'type'      => 'submit',
                                        'id'        => 'rank_search',
                                        'onclick'   => 'btn_click("'.CON_B.'")',
                                        'value'     => CON_B,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                        ]); ?></td>
                                <td >        <?php echo $this->Form->input('search',[
                                        'type'      => 'submit',
                                        'id'        => 'rank_search',
                                        'onclick'   => 'btn_click("'.CON_C.'")',
                                        'value'     => CON_C,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                        ]); ?></td>
                            </tr>
                            <tr class="table_tr">
                                <td >        <?php echo $this->Form->input('search',[
                                        'type'      => 'submit',
                                        'id'        => 'rank_search',
                                        'onclick'   => 'btn_click("'.CON_D.'")',
                                        'value'     => CON_D,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                        ]); ?></td>
                                <td >        <?php echo $this->Form->input('search',[
                                        'type'      => 'submit',
                                        'id'        => 'rank_search',
                                        'onclick'   => 'btn_click("'.CON_E.'")',
                                        'value'     => CON_E,
                                        'style'     => 'width: 100',
                                        'label'     => false,
                                        'onsubmit'  => 'return check()'
                                        ]); ?></td>
                                <td >  
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
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
    $(function() {
      $('.test-select2').select2({
        language: "ja" //日本語化
      });
    })
</script>
