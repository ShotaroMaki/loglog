<?php $this->assign('title', '.loglog'.$title); ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<?php echo $this->Form->create(null, ['id' => 'HomeForm', 'name' => 'HomeForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>

<!-- 共通navBar  end   -->

<style>
#sb-site{
    text-align: center;
}
.graph {
    color: #000;
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    background: #fff;
} 
.graph_tab {
     margin-top:2px;
}
</style>
<!-- Site -->
<!--<div id="sb-site" style="overflow: hidden;">-->
<!-- Site -->
<div id="sb-site" style="overflow: auto;padding-top: 5px;padding-bottom: 5px;">
    <table id="table_id" class="graph_tab">
        <tr class="graph">
            <td style='width: 1194px;'>
                <table >
                    <tr ><th text-align="left">新ユーザー状況</th></tr>
                    <tr>
                        <td style="width:1194px!important;" align=center>
                            <canvas  id="canvas" height="250" width="1319px"></canvas>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table>
        <tr>
            <td>先月登録ユーザー合計：</td>
            <td><?= h($priv_user); ?>人</td>
        </tr>
        <tr>
            <td>今月登録ユーザー合計：</td>
            <td><?= h($this_user); ?>人</td>
        </tr>
    </table>
    <table id="table_id" class="graph_tab">
        <tr class="graph">
            <td style='width: 1194px;'>
                <table >
                    <tr ><th text-align="left">新加盟店状況</th></tr>
                    <tr>
                        <td style="width:1194px!important;" align=center>
                            <canvas  id="canvas1" height="250" width="1319px"></canvas>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>先月登録加盟店合計：</td>
            <td><?= h($priv_shop); ?>店</td>
        </tr>
        <tr>
            <td>今月登録加盟店合計：</td>
            <td><?= h($this_shop); ?>店</td>
        </tr>
    </table>
</div>
<script src="../webroot/js/chart.js"></script>
<script>
var pure_data= [];
var prof_data= [];
</script>
    <?php foreach ($user_datas as $rows ) { ?>
<script>
     pure_data.push(<?= h($rows["this"]); ?>);
     prof_data.push(<?= h($rows["priv"]); ?>);
</script>     
    <?php } ?>
<script>
   // 日数を取得
   var now      = new Date(); 
   var month    = now.getMonth()+1;
   var year     = now.getFullYear();
   var last_day = '31';
   var days     = new Array();
   var a_label  = "";
   for(i=1;i<=last_day;i++){
       days.push(i+'日');
   }
  const config = {
    type: 'bar',
    data: {
        labels: days,
        datasets: [{
               label: '先月',
                backgroundColor: "blue",
                pointBackgroundColor: "rgba(2,63,138,0.8)",
               data: prof_data,
           },
    {
          label: '今月',
            backgroundColor: "red",
            data: pure_data,
       },]
    },
    options: {
      tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")　+ '人';
           },
          },
      }, 
       animationEnabled: false,
       responsive: false,
       scales: {
          xAxes: [{
            display: true,
            stacked: false,
            gridLines: {
               display: true

            }
          }],
          yAxes: [{
            display: true,
        ticks: {
          suggestedMax:100,
          suggestedMin: 1,
          stepSize: 100,
          callback: function(value, index, values){
          return value.toLocaleString() +  '人';
          }
        }
          }]
       }
    }
  };
  //  
  const myChart = new Chart(
    document.getElementById('canvas').getContext("2d"),
    config
  );
</script>  
<script>
var pure_data1= [];
var prof_data1= [];
</script>
    <?php foreach ($shop_datas as $row ) { ?>
<script>
     pure_data1.push(<?= h($row["this"]); ?>);
     prof_data1.push(<?= h($row["priv"]); ?>);
</script>     
    <?php } ?>
<script>
  const config1 = {
    type: 'bar',
    data: {
        labels: days,
        datasets: [{
               label: '先月',
                backgroundColor: "blue",
                pointBackgroundColor: "rgba(2,63,138,0.8)",
               data: prof_data1,
           },
    {
          label: '今月',
            backgroundColor: "red",
            data: pure_data1,
       },]
    },
    options: {
      tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")　+ '店';
           },
          },
      }, 
       animationEnabled: false,
       responsive: false,
       scales: {
          xAxes: [{
            display: true,
            stacked: false,
            gridLines: {
               display: true

            }
          }],
          yAxes: [{
            display: true,
        ticks: {
          suggestedMax:100,
          suggestedMin: 1,
          stepSize: 100,
          callback: function(value, index, values){
          return value.toLocaleString() +  '店';
          }
        }
          }]
       }
    }
  };
  //  
  const myChart1 = new Chart(
    document.getElementById('canvas1').getContext("2d"),
    config1
  );  
</script> 