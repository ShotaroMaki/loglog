<div id="main">
    <?php echo $this->element('Common/navbar'); ?>
    <div id="container" >
        <span onclick="openNav()">&#9776; </span>
        <div id="titlehead"><?= h($shop_nm) ?>.loglog</div>
    </div>

<script>
    function openNav() {
      document.getElementById("mySidenav").hidden = false;
      document.getElementById("nav_btn").hidden = true;
    }

    function closeNav() {
      document.getElementById("mySidenav").hidden = true;
      document.getElementById("nav_btn").hidden = false;
    }
    
    function drop_menu(e){
        obj=document.getElementById('drop_menu'+e).style;
        console.log(obj);
        if (obj.display=='none'){
            obj.display='block';
        }else if(obj.display==''){
            obj.display='block';
        }else{
            obj.display='none';
        }
    }
</script>