<?php

require_once __DIR__ . '/../model/chatservice.class.php';
require_once __DIR__ . '/../model/channel.class.php';
require_once __DIR__ . '//channelsController.php';


    class UsersController{

        public function index()
        {
            require_once __DIR__ . '/../view/forma_login.php';
        }

        

        public function logout()
        {
            require_once __DIR__ . '/../view/logout.php';
            
            //destroy session?
            if ($_GET['rt'] === 'users/index')
            {
                session_unset();
                session_destroy();
            }
        }

        public function dovrsiRegistraciju()
        {
            $x = new ChatService;
            $x->hasRegistered();
            
            $pocetna = new UsersController;
            $pocetna->index();
            
        }

        public function register()
        {
            if( !isset( $_POST['newusername'] ) || !isset( $_POST['newpassword'] ) || !isset( $_POST['newemail'] ) )
	        {
                $x = new UsersController;
                $x->index();
		        exit();
            }

            if( !preg_match( '/^[A-Za-z]{3,10}$/', $_POST['newusername'] ) )
	        {
		        $x = new UsersController;
                $x->index();
		        exit();
            }
            
	        else if( !filter_var( $_POST['newemail'], FILTER_VALIDATE_EMAIL) )
	        {
	        	$x = new UsersController;
                $x->index();
	        	exit();
            }
            
            else
	    {
            $x = new ChatService;
            $novi = $x->newUser();

            if ($novi === 0)
            {
                $povratak = new UsersController;
                $povratak->index();
	        	exit();
            }
            else
            {
                $_SESSION['id_user'] = $_POST['newusername'];
                // Sad mu još pošalji mail
		        $to       = $_POST['newemail'];
		        $subject  = 'Registracijski mail';
		        $message  = 'Poštovani ' . $_POST['newusername'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
		        $message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/chat.php?niz="' . $novi ."\n";
		        $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		                    'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		                    'X-Mailer: PHP/' . phpversion();

		        $isOK = mail($to, $subject, $message, $headers);

		        if( !$isOK )
                    exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );
                    
                // Zahvali mu na prijavi.
                require_once __DIR__ . '/../view/registracija.php';
		        exit();
            }
	    }


        }

        public function login()
        {
                // Provjeri sastoji li se ime samo od slova; ako ne, crtaj login formu.
	            if( !isset( $_POST["username"] ) || preg_match( '/[a-zA-Z]{1, 20}/', $_POST["username"] ) )
                {
                    $x = new UsersController;
                    $x->index();
                }

                // Možda se ne šalje password; u njemu smije biti bilo što.
                if( !isset( $_POST["password"] ) )
                {
                    $x = new UsersController;
                    $x->index();
                }
                    
                $provjera = new ChatService;
                $row = $provjera->loginUser();

                if( $row === false )
                {
                    // Taj user ne postoji, ili nije registriran upit u bazu nije vratio ništa.
                    $x = new UsersController;
                    $x->index();
                    return;
                }
                else
                {

                    // Postoji user. Dohvati hash njegovog passworda.
                    $hash = $row['password_hash'];

                    // Da li je password dobar?
                    if( password_verify( $_POST['password'], $hash ) )
                    {
                        // Dobar je. Ulogiraj ga.
                        $y = new ChatService;
                        $_SESSION['id_user'] = $y->getUserId($_POST['username']);

                        $x = new ChannelsController;
                        $x->naslovna();
                        
                        return;
                    }
                    else
                    {
                        // Nije dobar. Crtaj opet login formu s pripadnom porukom.
                        $x = new UsersController;
                        $x->index();
                        return;
                    }
                }
        }
    }


// omoguciti ispis MOJIH kanala, ako se u [post]?---session salje id_user, ispisi samo njegove kanale??
?>