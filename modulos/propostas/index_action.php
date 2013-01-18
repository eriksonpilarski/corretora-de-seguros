<?php
/**
 *
 */

/**
 *
 */
require "../../class/App.php";

/**
 * Recebendo dados
 */
$ac = (isset($_POST['ac'])) ? $_POST['ac'] : null ;

switch ($ac) {

    case "up":
        $propostas = (isset($_POST['propostas'])) ? $_POST['propostas'] : null ;
        $obj = new Propostas();
        $obj->update($propostas);
        break;

    case "renovar"://insert
    case "in":
        $propostas = (isset($_POST['propostas'])) ? $_POST['propostas'] : null ;
        $obj = new Propostas();
        $obj->insert($propostas);
        break;


    case "del":
        $id = (isset($_POST['id'])) ? $_POST['id'] : null ;
        $obj = new Propostas();
        $obj->delete($id);
        break;
}
?>