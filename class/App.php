<?php

class App {

    static function getAppPath() {

        return "../../";
    }

}



/**
 * Dependências
 */
require App::getAppPath() . "class/DB.class.php";
require App::getAppPath() . "class/FuncAux.class.php";
require App::getAppPath() . "class/HTMLcombo.class.php";
require App::getAppPath() . "models/Propostas.php";


/**
 * 
 */
session_start();

?>
