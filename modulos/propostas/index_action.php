<?php

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
        if($propostas){
            $sqls = array();
            $propostas = json_decode($propostas);
            foreach($propostas as $proposta){
                $proposta->renovacao  = FuncAux::data_converte_para_mysql( $proposta->renovacao );
                $proposta->vencimento = FuncAux::data_converte_para_mysql( $proposta->vencimento );

                $s  = "";
                $s  = "UPDATE propostas SET ";
                $s .= "id = {$proposta->id}, ".
                     "renovacao = '{$proposta->renovacao}', ".
                     "proposta = '{$proposta->proposta}', ".
                     "segurado = '{$proposta->segurado}', ".
                     "detalhes = '{$proposta->detalhes}', ".
                     "cia = '{$proposta->cia}', ".
                     "tipo = '{$proposta->tipo}', ".
                     "apolice = '{$proposta->apolice}', ".
                     "vencimento = '{$proposta->vencimento}', ".
                     "prem_liq = '{$proposta->prem_liq}', ".
                     "comissao = '{$proposta->comissao}', ".
                     "status = '{$proposta->status}'";
                $s .= "WHERE id = {$proposta->id}";
                $sqls[] = $s;
            }
//            var_dump($sqls);
            $pdo = DB::conectar();
            foreach($sqls as $sql){
                $result = $pdo->query($sql);
                if(!$result){
                    var_dump($pdo->errorInfo());
                }
            }
        }
        break;

    case "renovar"://insert
    case "in":
        $propostas = (isset($_POST['propostas'])) ? $_POST['propostas'] : null ;
//        var_dump(json_decode($propostas));
        if($propostas){
            $sqls = array();
            $propostas = json_decode($propostas);
            foreach($propostas as $proposta){
                $proposta->renovacao  = FuncAux::data_converte_para_mysql( $proposta->renovacao );
                $proposta->vencimento = FuncAux::data_converte_para_mysql( $proposta->vencimento );

                $s  = "";
                $s  = "INSERT INTO propostas VALUES ( ";
                $s .= "null, ".
                     "'{$proposta->renovacao}', ".
                     "'{$proposta->proposta}', ".
                     "'{$proposta->segurado}', ".
                     "'{$proposta->cia}', ".
                     "'{$proposta->tipo}', ".
                     "'{$proposta->detalhes}', ".
                     "'{$proposta->apolice}', ".
                     "'{$proposta->vencimento}', ".
                     "'{$proposta->prem_liq}', ".
                     "'{$proposta->comissao}', ".
                     "'{$proposta->status}' )";
                $sqls[] = $s;
            }
//            var_dump($sqls);
            $pdo = DB::conectar();
            foreach($sqls as $sql){
                $result = $pdo->query($sql);
                if(!$result){
                    var_dump($pdo->errorInfo());
                }
            }
        }
        break;


    case "del":
        $id = (isset($_POST['id'])) ? $_POST['id'] : null ;
        if($id){
            $sql = "DELETE FROM propostas WHERE id = $id LIMIT 1";
            //var_dump($sql);
            $pdo = DB::conectar();
            $result = $pdo->query($sql);
            if(!$result){
                var_dump($pdo->errorInfo());
            }
        }
        break;
}
?>