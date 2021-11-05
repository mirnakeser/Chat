<?php

require_once __DIR__ . '/../model/chatservice.class.php';

    class ChannelsController{

        public function index(){
            $ls = new ChatService;

            $title = 'All channels';
            $channelList = $ls->getAllChannels();

            require_once __DIR__ . '/../view/channels_index.php';
        }
        
        public function conversation( $id_channel ){

            $_SESSION['id_channel'] = $id_channel;

            $ls = new ChatService;            
            
            $i = 0;
            $title = 'All messages';
            $messageList = $ls->getAllMessages( $id_channel );

            $name = $ls->getChannelName ( $id_channel );
            $title = 'Channel ' . $name . ' - all messages';

            $users = [];
            foreach ($messageList as $message)
                $users[] = $ls->getUsername($message->id_user);

            require_once __DIR__ . '/../view/channelmessages_index.php';
            
        }
        
        public function naslovna( )
        {
            $ls = new ChatService;

            $title = 'My channels';

            $id = (int) $_SESSION['id_user'];
            $channelList = $ls->getMyChannels($id);

            require_once __DIR__ . '/../view/channels_index.php';
        }
             
        public function mojePoruke()
        {
            $ls = new ChatService;

            $title = 'My messages';
            $messageList = $ls->getMyMessages($_SESSION['id_user']);

            require_once __DIR__ . '/../view/messages_index.php';   
        }
        //novi kanal
        public function new()
        {
            
            if (isset ( $_POST['napraviNovi'] ) )
            {
                $ls = new ChatService;
                $ls->newChannel($_POST['noviKanal']);
                $x = new ChannelsController;
                $x->naslovna();
            }
            else
            {
                $title = 'Make Your New Channel';
                require_once __DIR__ . '/../view/newchannel_index.php';
            }
        }

        public function novaPoruka()
        {
            if (isset ($_POST['answer']))
            {
                $id_channel = (int) $_SESSION['id_channel'];

                $ls = new ChatService;
                $ls->writeNewMessage( $id_channel, $_POST['content'] );
                
                $x = new ChannelsController;
                $x->conversation($id_channel);
            }
            
        }

        public function thumb()
        {
            
                $id_message = (int) $_POST['thumb'];
                $id_channel = (int) $_SESSION['id_channel'];

                $ls = new ChatService;
                $ls->refreshThumb( $id_message );
                
                $x = new ChannelsController;
                $x->conversation($id_channel);
            
        }
        
    }




    
?>