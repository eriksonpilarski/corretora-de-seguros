<?php
/**
 *
 */


/**
 *
 */
class App {

    static function getAppPath() {

        return "../../";
    }

}



/**
 * Dependências
 */
require App::getAppPath() . "php/class/DB.class.php";
require App::getAppPath() . "php/class/DatasFuncAux.class.php";
require App::getAppPath() . "php/class/HTMLcombo.class.php";
require App::getAppPath() . "php/models/Propostas.php";
require App::getAppPath() . "php/models/Usuarios.php";


/**
 *
 */
session_start();

?>
