<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/izbornik.php'; ?>


    
<ul>
<?php
    foreach( $channelList as $channel ){
        echo '<li>' .
             $channel->name .
             '<br>
            <a href="chat.php?id_channel=' . $channel->id . '">View channel</a>
            </li>';
             
    }
    ?>
</ul>      


<?php require_once __DIR__ . '/_footer.php'; ?>