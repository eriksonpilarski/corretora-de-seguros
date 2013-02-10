<?php
/**
 *  Este arquivo...
 */

/**
 *
 */
require "../../php/class/App.php";



/**
 * Recebendo dados
 */
$login = (isset($_POST['login'])) ? $_POST['login'] : null ;
$pass  = (isset($_POST['pass'])) ? $_POST['pass'] : null ;

try {

    if( !$login || !$pass )
        throw new Exception("Preencha campo login e senha !");

    $obj = new Usuarios();

    $usuario = $obj->login($login, $pass);

    if(  ! $usuario   )
        throw new Exception("Login ou senha incorretos !");


    # Criar sessions
    $_SESSION['id-usuario'] = $usuario ->id;


} catch (Exception $exc){
    echo $exc->getMessage();
}


?>
