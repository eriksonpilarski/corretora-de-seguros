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
    $result = $pdo->query($sql);
    
//    if( $pdo->errorInfo()[2] );
//        throw new Exception($pdo->errorInfo()[1]." - ".$pdo->errorInfo()[2]);

    if(!$result)
        throw new Exception("login ou senha incorretos !");
    
    # criar sessions
    $_SESSION['id-usuario'] = $result->fetch(PDO::FETCH_OBJ)->id;

    
} catch (Exception $exc){
    echo $exc->getMessage();
}


?>
