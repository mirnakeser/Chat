<?php

require_once __DIR__ . '/../model/chatservice.class.php';
require_once __DIR__ . '/../model/message.class.php';

    class MessagesController{
        public function index(){
            $ls = new ChatService;

            $title = 'My messages';
            $messageList = $ls->getMyMessages(1);

            require_once __DIR__ . '/../view/messages_index.php';
        }
    }


    // od kud mi id_user?
?>