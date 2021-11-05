
<?php

require_once __DIR__ . '/../model/chatservice.class.php';
require_once __DIR__ . '/../model/channel.class.php';
require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/message.class.php';



    class ChannelMessagesController{
        public function index(){
            $ls = new ChatService;
            $i = 0;
            $title = 'All messages';
            $messageList = $ls->getAllMessages( 1 );
            $users = [];
            foreach ($messageList as $message)
                $users[] = $ls->getUsername($message->id_user);

            require_once __DIR__ . '/../view/channelmessages_index.php';
        }
    }
?>