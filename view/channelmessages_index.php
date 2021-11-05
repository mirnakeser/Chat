<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/izbornik.php'; ?>

<form method="post" action="chat.php?rt=channels/thumb">
<?php
    foreach ( $messageList as $message )
    {
        
        echo 
            '<p>' . 
            $users[$i++] . ' ' .
            $message->date .
            '<br>' .
            $message->content .
            '<br>' .
            '<button type="submit" name="thumb" value="' . $message->id . '">
            <img width="25" height="25" src="https://graphicriver.img.customer.envatousercontent.com/files/283487043/thumb%20up%20emoticon%20with%20medical%20mask%20preview.jpg?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=b0646ad2d98820912aa6a80b0cccafa4" />'
            . $message->thumbs_up .
            '</button>
            </p>';
    }
?>
</form>
<br>
<label for="newmessage">
Write a message:
<br>
<form method="post" action="chat.php?rt=channels/novaPoruka">
<textarea name="content" cols="10" rows="10"></textarea>
</label>
<br>
<button type="submit" name="answer">Send your message</button>
</form>



<?php require_once __DIR__ . '/_footer.php'; ?>