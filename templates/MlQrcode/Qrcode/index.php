<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>

<head>
<script src="/loglog/webroot/js/Qrjs/jquery.min.js"></script> 
<script src="/loglog/webroot/js/Qrjs/jquery.qrcode.min.js"></script> 
<script src='/loglog/webroot/js/PDF/print.min.js'></script>
<link rel="stylesheet" type="text/css" href="/loglog/webroot//js/PDF/print.min.css">
<script type="text/JavaScript"> 
    $(function(){
      var qrtext = ".loglog#<?= h($shop_data[0]['shop_cd']) ?>#<?= h($shop_data[0]['shop_nm']) ?>";
      var utf8qrtext = unescape(encodeURIComponent(qrtext));
      $("#img-qr").html("");
      $("#img-qr").qrcode({text:utf8qrtext});
    });
    </script>
</head>
<style>
    #printqr{
        text-align:center;
        border: 1px solid black;
        margin-left:35%;
        margin-right:30%;
        background-color:white;
        
    }
    #img-qr{
        margin: 10px;
        text-align:center;
    }
    #letters{
        color:black;
        font-size: 50px;
    }
    #print_btn{
        margin: 10px;
    }
    /*携帯対応*/
    @media screen and (max-width: 480px) {
        #printqr{
            margin-left:10%;
            margin-right:10%;

        }
    }
</style>
<body>
    <form method="post">

    <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">    
        <div style="text-align:center">
            <div id="printqr">
                <div><p id="letters">QRを読んで<br />ログを保存<br />.LOGLOG</p></div>
                <div id="img-qr"></div>
            </div>
            <input id="print_btn" type="button" value="印刷する" onclick="printPDF();" />
        </div>
    </form>>
</body>
<script>
    //ファンクションPDF出力
    function printPDF(){
        
        style = '';
        style += '    #printqr{ ';
        style += '            text-align:center; ';
        style += '            border: 1px solid black; ';
        style += '            background-color:#336378; ';
        style += '            margin-left:10%; ';
        style += '            margin-right:10%; ';
        style += '    }';
        style += '    #img-qr{ ';
        style += '        margin: 10px; ';
        style += '        text-align:center; ';
        style += '    } ';
        style += '    #letters{ ';
        style += '        color:whitesmoke; ';
        style += '        font-size: 50px; ';
        style += '    } ';

        printJS({
            printable:'printqr',
            type: 'html',
            scanStyles: false,
            honorMarginPadding:false,
            style:style,
        });
        pdf_header.innerHTML = '';
        setTimeout(remove_iframe, 10000);
        document.getElementById('printJS').parentNode.removeChild(document.getElementById('printJS'));
        
    }      
</script>    