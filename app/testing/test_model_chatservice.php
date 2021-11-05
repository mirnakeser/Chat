<?php

require_once __DIR__ . '/../../model/chatservice.class.php';
require_once __DIR__ . '/../../model/user.class.php';
require_once __DIR__ . '/../../model/channel.class.php';
require_once __DIR__ . '/../../model/message.class.php';

    $ls = new ChatService();
    
    $mychannels = $ls->getMyChannels( 1 );

    echo '<pre>';
    print_r( $mychannels );
    echo '</pre>';


    $channels = $ls->getAllChannels( );

    echo '<pre>';
    print_r( $channels );
    echo '</pre>';


    $mymessages = $ls->getMyMessages (1);

    echo '<pre>';
    print_r( $mymessages );
    echo '</pre>';
?>