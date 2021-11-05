<?php

require __DIR__ . '/../app/database/db.class.php';
require __DIR__ . '/user.class.php';
require __DIR__ . '/channel.class.php';
require __DIR__ . '/message.class.php';

    class ChatService{
        public function getMyChannels( $id_user )
        {
            $mychannels = [];
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_channels WHERE id_user=:id_user' );
            $st->execute( ['id_user' => $id_user] );

            while( $row = $st->fetch() )
                $mychannels[] = new Channel( $row['id'], $row['id_user'], $row['name']);
            
            return $mychannels;
        }

        public function getAllChannels ()
        {
            $channels = [];
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_channels' );
            $st->execute();

            while( $row = $st->fetch() )
                $channels[] = new Channel($row['id'], $row['id_user'], $row['name']);
            
            return $channels;
        }

        public function getMyMessages ($id_user)
        {
            $mymessages = [];

            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_messages WHERE id_user=:id_user ORDER BY date DESC' );
            $st->execute( ['id_user' => $id_user] );

            while( $row = $st->fetch() )
                $mymessages[] = new Message( $row['id'], $row['id_user'], $row['id_channel'], $row['content'], $row['thumbs_up'], $row['date'] );
            
            return $mymessages;
        }
        //dohvati sve poruke određenog kanala ciji je id = id_channel
        public function getAllMessages ( $id_channel )
        {
            $allmessages = [];

            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_messages WHERE id_channel=:id_channel ORDER BY date' );
            $st->execute( ['id_channel' => $id_channel] );

            while( $row = $st->fetch() )
                $allmessages[] = new Message( $row['id'], $row['id_user'], $row['id_channel'], $row['content'], $row['thumbs_up'], $row['date'] );
            
            return $allmessages;
        }
        
        public function getUsername( $id ) 
        {
            
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_users WHERE id=:id' );
            $st->execute( ['id' => $id] );
            $row = $st->fetch();
            $user = new User ($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered']);

            return $user->username;
        }

        public function getUserId( $username )
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_users WHERE username=:username' );
            $st->execute( ['username' => $username] );
            $row = $st->fetch();
            $user = new User ($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered']);

            return $user->id;
        }

        public function getAllUsers()
        {
            $allusers = [];

            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_users' );
            $st->execute();

            while( $row = $st->fetch() )
                $allusers[] = new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
            
            return $allusers;
        }

        public function getChannelName( $id )
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_channels WHERE id=:id' );
            $st->execute( ['id' => $id] );
            $row = $st->fetch();
            $channel = new Channel ($row['id'], $row['id_user'], $row['name']);

            return $channel->name;
        }
    
        public function writeNewMessage($id_channel, $content)
        {
            $id = (int)$_SESSION['id_user'];
            date_default_timezone_set("Europe/Zagreb");
            $date = date("Y-m-d H:i:s"); 
            $db = DB::getConnection();
            $st = $db->prepare( 'INSERT INTO dz2_messages (id_user, id_channel, content, thumbs_up, date) VALUE (:id_user, :id_channel, :content, :thumbs_up, :date)' );
            $st->execute(['id_user' => $id, 'id_channel' => $id_channel, 'content' => $content, 'thumbs_up' => 0, 'date' => $date]);
        }


        public function newChannel( $name )
        {
            $id = (int)$_SESSION['id_user'];

            $db = DB::getConnection();
            $st = $db->prepare( 'INSERT INTO dz2_channels (id_user, name) VALUE (:id_user, :name)' );
            $st->execute( ['id_user' => $id, 'name' => $name] );

            return;

        }

        public function refreshThumb( $id )
        {

            $db = DB::getConnection();
            $st = $db->prepare( 'UPDATE dz2_messages SET thumbs_up=thumbs_up+1 WHERE id=:id' );
            $st->execute( ['id' => $id] );
        }

        public function loginUser()
        {
            $db = DB::getConnection();

            $st = $db->prepare( 'SELECT has_registered FROM dz2_users WHERE username=:username' );
            $st->execute( array( 'username' => $_POST["username"] ) );
            $row = $st->fetch();
            if ($row === 0)
                return false;

            $st = $db->prepare( 'SELECT password_hash FROM dz2_users WHERE username=:username' );
            $st->execute( array( 'username' => $_POST["username"] ) );

            $row = $st->fetch();

            return $row;

        }

        public function newUser()
        {
            $reg_seq = '';
		    for( $i = 0; $i < 20; ++$i )
                $reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo
            
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT * FROM dz2_users WHERE username=:username' );
            $st->execute( ['username' => $_POST['newusername']] );
            
		    if( $st->rowCount() !== 0 )
		    {
			// Taj user u bazi već postoji
                return 0;
            }
            
            $reg_seq = '';
		    for( $i = 0; $i < 20; ++$i )
			    $reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo

			$st = $db->prepare( 'INSERT INTO dz2_users(username, password_hash, email, registration_sequence, has_registered) VALUES ' .
				                '(:username, :password, :email, :reg_seq, 0)' );
			
			$st->execute( array( 'username' => $_POST['newusername'], 
				                 'password' => password_hash( $_POST['newpassword'], PASSWORD_DEFAULT ), 
				                 'email' => $_POST['newemail'], 
				                 'reg_seq'  => $reg_seq ) );
            return $reg_seq;
        }

        public function hasRegistered()
        {
            $db = DB::getConnection();

	        $st = $db->prepare( 'SELECT * FROM dz2_users WHERE registration_sequence=:reg_seq' );
	        $st->execute( array( 'reg_seq' => $_SESSION['niz'] ) );

            $row = $st->fetch();

            if( $st->rowCount() !== 1 )
	            return 0;
            else
            {
	            // Sad znamo da je točno jedan takav. Postavi mu has_registered na 1.
		        $st = $db->prepare( 'UPDATE dz2_users SET has_registered=1 WHERE registration_sequence=:reg_seq' );
                $st->execute( array( 'reg_seq' => $_SESSION['niz'] ) );
                return 1;
            }
        }
    }
?>