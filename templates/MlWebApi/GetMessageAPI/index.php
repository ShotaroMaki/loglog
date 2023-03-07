
<meta name="viewport" content="width=device-width,initial-scale=1.0" />



<table class="tables">
    <?php foreach ($msgData as $rows) { ?>
        <tr class="table_tr">
            <td>Time: <?= h($rows['datesent']) ?> FROM <?= h($rows['sender_id']) ?> ：　<?= h($rows['content']) ?></td>
        </tr>
    <?php } ?>
</table>








