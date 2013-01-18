<?php

/**
 *
 */

/**
 *
 */
class Usuarios {


    /**
     *
     * @param type $login
     * @param type $pass
     * @return type
     * @throws Exception
     */
    function login($login, $pass){

        if( !$login || !$pass)
            throw new Exception(get_class($this).": Impossível logar sem login e senha!");

        # Query
        $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$pass'";
        $pdo = DB::conectar();
        $result = $pdo->query($sql);

        # Erros
        $err = $pdo->errorInfo();
        if( $err[2]  ){
            throw new Exception($err[2], $err[1]);
        }

        # Retorna objeto usuario
        return $result->fetch(PDO::FETCH_OBJ);
    }


}

?>