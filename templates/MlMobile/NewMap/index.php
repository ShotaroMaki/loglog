<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->css('mobilemap'); ?> 
    <meta charset="utf-8">
    <link rel="stylesheet" href="/loglog/webroot/css/leaflet/leaflet.css"
      crossorigin=""/>
    <script src="/loglog/webroot/js/leaflet/leaflet.js"
      crossorigin=""></script>
    <script src="/loglog/webroot/js/jquery/leaflet.sprite.js"></script>
    
<!-- plugin -->
<link rel="stylesheet" href="/loglog/webroot/css/leaflet/leaflet.fusesearch.css" />
    <link rel="stylesheet" href="/loglog/webroot/css/leaflet/SlideMenu.css" />
    <script src="/loglog/webroot/js/leaflet/SlideMenu.js"></script>
<!-- plugin -->
  </head>
  <body>
    <?php echo $this->Form->create(null, [
                                      'id'       => 'CustrankForm', 
                                      'name'     => 'CustrankForm',
                                      'method'   => 'post', 
                                      'enctype'  => 'multipart/form-data',
                                      'onsubmit' => 'return check()'
                                    ]) ?>

    <div id="view_map"></div>
    <?php echo $this->element('Common/confirm_map'); ?>
    
    <script type="text/javascript">
        
        
        
        //緯度,経度,ズーム
        var map = L.map('view_map').setView([33.581944, 130.400089], 15);
        // OpenStreetMap から地図画像を読み込む
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, '
        }).addTo(map);

        var popup = L.popup();
        var data = new Array();
        var btn = "<?= h($btn_click_name) ?>";
        var i = 0;
        

        
        // Slide Menu Content Html
        var contents = '<ul class="cstm-slidmenu-content">';
        contents += '<li>店名検索</li>';
        contents += '<input id  = "search_shop" class = "search_shop" name = "search_shop" type = "text" placeholder = "店名を入力してください"/>';
        contents += '<li>住所検索</li>';
        contents += '<input id  = "search_add" class = "search_shop" name = "search_add" type = "text" placeholder = "エリアを入力してください"/>';
        contents += '<?php echo $this->Form->input('search',['type' => 'submit','class '=> 'rank_search' ,'id '=> 'rank_search','value' => CON_SEARCH,'label' => false, 'onsubmit' => 'return check()']); ?>' 
        contents += '</ul>';
 
        // SlideMenuA
        var options = {
          width: '60%',
          height: '100%'
        }
        L.control.slideMenu(contents, options).addTo(map);
        
    <?php foreach ($shop_data as $rows ) {?>

        data.push({
            user_cd:"<?= h($user_cd) ?>",
            shop_nm:"<?= h($rows["shop_nm"]) ?>",
            shop_cd:"<?= h($rows["shop_cd"]) ?>",
            count:"<?= h($rows["count"]) ?>",
            shop_add: "<?= h($rows['shop_add']) ?>"
        }); 
        
        callApi(data[i]['shop_add'],data[i]['shop_cd'],data[i]['shop_nm'],data[i]['count'],data[i]['user_cd']);
        i++; 
    <?php } ?>
    
        if(btn!==''){
            console.log(btn,data);
            if(data.length == 0){
                confirm_preview();
            } 
        }
        
        async function callApi(shop_add,shop_cd,shop_nm,count,user_cd) {
            const res = await fetch('https://msearch.gsi.go.jp/address-search/AddressSearch?q='+shop_add);
            const data1 = await res.json();
          
            var lon = data1[0].geometry.coordinates[0];
            var lat = data1[0].geometry.coordinates[1];
            
            if(count >= 1){
                setmarker1(lon,lat,shop_cd,user_cd);
            }else{
                setmarker2(lon,lat,shop_cd,user_cd);
            }
            
            var shop_count = data.length;
            if(shop_count === 1){
                map.setView([lat, lon],15);
                
            }else{
                if(btn === ''){
                    map.on('locationfound', onLocationFound);
                    map.on('locationerror', onLocationError);
                    map.locate({setView: true, maxZoom: 16, timeout: 20000});
                }else{
                    map.setView([lat, lon],15);
                }
            }    
        };
        function setmarker1(lon,lat,shop_cd,user_cd){
           
            //地図にマーカーを立てる
            L.marker([lat, lon],{icon: L.icon({iconUrl:"/loglog/webroot/img/mappin_ittabasho_35.png",iconAnchor:[15,15]})}).addTo(map).on('click', function (e) {    
                  popup
                      .setLatLng(e.latlng)
                      .setContent("<iframe class = 'frame_size' scrolling='no' allowtransparency='true' frameborder='0' src= 'https://loglog.biz/loglog/MlMobile/mapshop?shop_cd="+shop_cd+"&user_cd="+user_cd+"'>店舗詳細</iframe>" )
                      .openOn(map);
            });
        }
       
        function setmarker2(lon,lat,shop_cd,user_cd){
           
            //地図にマーカーを立てる
            L.marker([lat, lon],{icon: L.icon({iconUrl:"/loglog/webroot/img/mappin_kameiten.png",iconAnchor:[15,15]})}).addTo(map).on('click', function (e) {    
                  popup
                      .setLatLng(e.latlng)
                      .setContent("<iframe class = 'frame_size' scrolling='no' allowtransparency='true' frameborder='0' src= 'https://loglog.biz/loglog/MlMobile/mapshop?shop_cd="+shop_cd+"&user_cd="+user_cd+"'>店舗詳細</iframe>" )
                      .openOn(map);
            });
        }
        
        // 初期表示を現在地付近にする
        function onLocationFound(e) {
            L.map('map').setView([e, latlng], 15);
        }
        // 現在地を取得でき無かったろ時初期表示をミリオネットにする
        function onLocationError(e) {
            L.map('map').setView([33.581944, 130.400089], 15);
        }
        
    </script>
  </body>
</html>
