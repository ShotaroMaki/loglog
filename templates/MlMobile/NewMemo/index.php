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
  </head>
  <body>
    <div id="view_map" ></div>
    <script type="text/javascript">
        //緯度,経度,ズーム
        var map = L.map('view_map').setView([33.581944, 130.400089], 15);
        // OpenStreetMap から地図画像を読み込む
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, '
        }).addTo(map);

        // 初期表示を現在地付近にする
        function onLocationFound(e) {
             L.map('map').setView([e, latlng], 15);
        }

        function onLocationError(e) {
             L.map('map').setView([33.581944, 130.400089], 15);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        map.locate({setView: true, maxZoom: 16, timeout: 20000});
        var popup = L.popup();
        
    // フォームに入力された住所情報を取得
    <?php foreach ($shop_data as $rows ) {?>

        var data = new Array();
        data.push({
           user_cd:"<?= h($user_cd) ?>",
           shop_cd:"<?= h($rows["shop_cd"]) ?>",
           count:"<?= h($rows["count"]) ?>",
           shop_add: "<?= h($rows['shop_add']) ?>"
        }); 
        

        callApi(data[0]['shop_add'],data[0]['shop_cd'],data[0]['count'],data[0]['user_cd']);
        
    <?php } ?>

        async function callApi(shop_nm,shop_cd,count,user_cd) {
             const res = await fetch('https://msearch.gsi.go.jp/address-search/AddressSearch?q='+shop_nm);
             const data1 = await res.json();
          
             var lon = data1[0].geometry.coordinates[0];
             var lat = data1[0].geometry.coordinates[1];
            if(count >= 1){
                setmarker1(lon,lat,shop_cd,user_cd);
            }else{
                setmarker2(lon,lat,shop_cd,user_cd);
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
    </script>
  </body>
</html>
