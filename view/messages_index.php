<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/izbornik.php'; ?>

<ul> 
<?php

   foreach( $messageList as $message ){
    echo
    '<li>' . 
    $message->date .
    '<br>' .
    $message->content .
    '<br>
    <a href="chat.php?id_channel=' . $message->id_channel . '">View channel</a>
    </li>';
    
}
    ?>
        
</ul>

<?php require_once __DIR__ . '/_footer.php'; ?>