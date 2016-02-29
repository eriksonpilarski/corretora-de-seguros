<?php
/**
 *
 */
session_start();

/**
 *
 */
ini_set('display_errors', 'on');
ini_set('track_errors', 'on');
ini_set('html_errors', 'on');
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

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


?>