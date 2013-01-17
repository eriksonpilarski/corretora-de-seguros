<?php


/**
 *  Consulta SQL
 */
$sql    = "SELECT * FROM propostas";
$filtro = "";


if($proposta){
    $proposta = json_decode($proposta);

    $filtro_status = "";

    if( is_string($proposta->renovacao) ){
        $proposta->renovacao = FUncAux::data_converte_para_mysql($proposta->renovacao);
        $filtro .= "renovacao = '{$proposta->renovacao}' AND ";
    }
    else{
        $filtro .= "(renovacao BETWEEN '{$proposta->renovacao->inicio}' AND '{$proposta->renovacao->termino}') AND";
    }

    if($proposta->proposta)
        $filtro .= "proposta LIKE '%{$proposta->proposta}%' AND ";

    if($proposta->segurado)
        $filtro .= "segurado LIKE '%{$proposta->segurado}%' AND ";

    if($proposta->cia)
        $filtro .= "cia LIKE '%{$proposta->cia}%' AND ";

    if($proposta->tipo)
        $filtro .= "tipo LIKE '%{$proposta->tipo}%' AND ";

    if($proposta->detalhes)
        $filtro .= "detalhes LIKE '%{$proposta->detalhes}%' AND ";

    if( is_string($proposta->vencimento) ){
        $proposta->vencimento = FUncAux::data_converte_para_mysql($proposta->vencimento);
        $filtro .= "vencimento = '{$proposta->vencimento}' AND ";
    }
    else{
        $filtro .= "(vencimento BETWEEN '{$proposta->vencimento->inicio}' AND '{$proposta->vencimento->termino}') AND";
    }

    if($proposta->prem_liq)
        $filtro .= "prem_liq LIKE '%{$proposta->prem_liq}%' AND ";

    if($proposta->comissao)
        $filtro .= "segurado LIKE '%{$proposta->comissao}%' AND ";

    if($proposta->status->nao_checado)
        $filtro_status .= "status = 'n_check' OR ";

    if($proposta->status->falta_ass)
        $filtro_status .= "status = 'falta_ass' OR ";

    if($proposta->status->ok)
        $filtro_status .= "status = 'ok' OR ";

    if($filtro && !$filtro_status){
        $filtro = substr($filtro, 0, strlen($filtro)-4);// remover último AND
    }


    if($filtro_status){
        $filtro_status = substr($filtro_status,  0, strlen($filtro_status)-3);// remover último OR

        // Atenção... concatenado.
        $filtro = "$filtro ($filtro_status)";
    }

    if($filtro || $filtro_status)
        $sql = $sql . " WHERE " . $filtro;

}

//var_dump($sql);

/*
 * Array propostas, tabela principal
 */
$propostas = array();

$pdo = DB::conectar();
$result = $pdo->query($sql);
if($result){
    while (  $obj = $result->fetch(PDO::FETCH_OBJ)  ) {
        $propostas[] = $obj;
    }
}
?>
