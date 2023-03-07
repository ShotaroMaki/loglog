<style>
    body{
        margin : 0;
    }
    form {
        margin : 0;
        height : 100%;
    }
    .sns_size{
        width  : 100%;
        height : 100%;

    }
     .frame_size{
        height : 100vh;
        width  : 99vw;
    }
</style>

<?php echo $this->Form->create(null, ['id' => 'SNSForm', 'name' => 'SNSForm', 'onsubmit' => 'return searchCheck()','method' => 'post', 'enctype' =>'multipart/form-data']) ?>
<meta name    = "viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
<body>
    <form method="post">
    <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>">
    <div style = "height:100%">
        <button style="font-size: 20px" type="button" onclick="history.back()" >×</button>
        <div class="sns_size">
            <iframe  src= "<?= h($url_sns) ?>" class="frame_size"></iframe>
        </div>
    </div>
    </form>
<?php echo $this->Form->end() ?>
</body>