<?php
require_once __DIR__ . '/_header.php';
?>



    <hr>
        <dl>
            <dt>
                <a href="chat.php?rt=channels/naslovna">List of my channels</a>
            </dt>
            <dt>
                <a href="chat.php?rt=channels/index">List of all channels</a>
            </dt>
            <dt>
                <a href="chat.php?rt=channels/new">Start a new channel</a>
            </dt>
            <dt>
                <a href="chat.php?rt=channels/mojePoruke">My messages</a>
            </dt>
            <dt>
                <a href="chat.php?rt=users/logout">Logout</a>
            </dt>
        </dl>
    <hr>

    <h2> <?php echo $title; ?> </h2>

<?php
require_once __DIR__ . '/_footer.php';
?>