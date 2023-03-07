<?php $this->assign('title', '.loglog'.$title); ?>
<?php echo $this->element('Common/header'); ?>
<?php echo $this->Html->css('MlR'); ?>
<form method="post">
<input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getAttribute('csrfToken') ?>"> 

        <div id="USERInfo">
            <table align="center">
            <th id="table_head">
             顧客情報 &#x1f4ca;
            </th>
            <tr id=table_head_2>
                <td>来店日時</td>
                <td>来店者お名前</td>   
            </tr>
             <?php  
                   if($user_data){
                   $updatetime   = '';
                   $user_nm      = '';
                   foreach($user_data as $users){
                       $updatetime     = substr($users['updatetime'],2);
                       $updatetime     = date('y年m月d日h時m分',strtotime($users['updatetime'])); 
                       $user_nm        = ($users['user_nm']);
               ?>  
            <tr>
                <td><?= h($updatetime) ?></td>
                <td><?= h($user_nm)?>様</td> 
            </tr>
            <?php        
                    }
                }
                ?>
            </table>
        </div>
</form>