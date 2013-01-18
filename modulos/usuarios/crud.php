<?php
/**
 *  Este arquivo...
 */

/**
 *
 */
require "../../class/App.php";



/**
 * Recebendo dados
 */
$login = (isset($_POST['login'])) ? $_POST['login'] : null ;
$pass  = (isset($_POST['pass'])) ? $_POST['pass'] : null ;

try {

    if( !$login || !$pass )
        throw new Exception("Preencha campo login e senha !");

    $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$pass'";
    $pdo = DB::conectar();
    $_result = $result = $pdo->query($sql);

    $erro = $pdo->errorInfo();
    if( $erro[2]  ){
        throw new Exception($erro[1]." - ".$erro[2]);
    }

    $usuario = $result->fetch(PDO::FETCH_OBJ);

    if(  ! $usuario   )
        throw new Exception("Login ou senha incorretos !");


    # Criar sessions
    $_SESSION['id-usuario'] = $usuario ->id;


} catch (Exception $exc){
    echo $exc->getMessage();
}


?>
