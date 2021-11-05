<?php

//https://rp2.studenti.math.hr/~margaci/library/index.php?rt=users/index
//https://rp2.studenti.math.hr/~margaci/library/index.php?rt=books/search

session_start();
//if ( isset ( $_POST['login'] ) )
    



if( !isset( $_GET['rt'] ) ){

    if ( isset( $_GET['id_channel']))
    {
        $controller = 'channels';
        $action = 'conversation';
    }

    elseif (isset( $_GET['niz'] ))
    {
        $_SESSION['niz'] = $_GET['niz'];
        $controller = 'users';
        $action = 'dovrsiRegistraciju';
    }

    else
    {
        $controller = 'users';
        $action = 'index';
    }
    
}


else{
    $parts = explode( '/', $_GET['rt'] );

    if( isset( $parts[0] ) && preg_match( '/^[A-Za-z0-9]+$/', $parts[0] ) )
        $controller = $parts[0];
    else
        $controller = 'users';

    
    if( isset( $parts[1] ) && preg_match( '/^[A-Za-z0-9]+$/', $parts[1] ) )
        $action = $parts[1];
    else
        $action = 'index';
}

$controllerName = $controller . 'Controller';

if( !file_exists( __DIR__ . '/controller/' . $controllerName . '.php' ) )
    error_404();

require_once __DIR__ . '/controller/' . $controllerName . '.php';

if( !class_exists( $controllerName ) )
    error_404();



$con = new $controllerName();

if( !method_exists( $con, $action ) )
    error_404();

if ( $action === 'conversation')
    $con->$action($_GET['id_channel']);

else
    $con->$action();

exit(0);

//------------------------------------------------

function error_404(){
    require_once __DIR__ . '/controller/_404Controller.php';
    $con = new _404Controller();
    $con->index();

    exit(0);
}

?>