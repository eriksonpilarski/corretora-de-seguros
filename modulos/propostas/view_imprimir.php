<?php
/**
 * View que imprime a lista de propostas
 */

/**
 *
 */
require "../../class/App.php";


try {

    /*
     *
     */
    $proposta_filtro = (isset($_GET['proposta'])) ? $_GET['proposta'] : null ;

    $obj    = new Propostas();
    $filtro = $obj->retFiltroTabPropostas($proposta_filtro);

    $propostas = array();
    $propostas = Propostas::getObjects($filtro);


} catch (Exception $ex){

    var_dump($ex->getMessage());

}


/*
 *  Acerta a legenda
 */
if(  is_object($proposta_filtro->renovacao)  ){
    $dt_inicio  = $proposta_filtro->renovacao->inicio;
    $dt_termino = $proposta_filtro->renovacao->termino;
}
else if(  is_object($proposta_filtro->vencimento)  ){
    $dt_inicio  = $proposta_filtro->vencimento->inicio;
    $dt_termino = $proposta_filtro->vencimento->termino;
}

$dt_inicio  = DatasFuncAux::data_converte_para_visualizar($dt_inicio);
$dt_termino = DatasFuncAux::data_converte_para_visualizar($dt_termino);


/**
 * HTML
 */
$html  = "<h1>Listando propostas</h1>";
$html .= "<legend>Período $dt_inicio à $dt_termino</legend>";
$html .= "<table border=\"1\">";
$html .= "<thead>".
            "<tr>".
                "<th>Proposta</th>".
                "<th>Segurado</th>".
                "<th>CIA</th>".
                "<th>Apolice</th>".
                "<th>Vencimento</th>".
                "<th>Prémio Liq.</th>".
                "<th>Comissão</th>".
                "<th>Status</th>".
            "<tr>".
         "</thead>";

$html .= "<tbody>";
foreach ($propostas as $proposta){
    $html .= "<tr>".
                "<td>{$proposta->proposta}</td>".
                "<td>{$proposta->segurado}</td>".
                "<td>{$proposta->cia}</td>".
                "<td>{$proposta->apolice}</td>".
                "<td>".DatasFuncAux::data_converte_para_visualizar($proposta->vencimento)."</td>".
                "<td>{$proposta->prem_liq}</td>".
                "<td>{$proposta->comissao}</td>".
                "<td>{$proposta->status}</td>".
            "</tr>";
}
$html .=     "</tbody>";
$html .= "</table>";



/**
 * PDF
 */
require("../../php/mpdf54/mpdf.php");
$mpdf = new mPDF('c','A4','','',15,15,15,15,15,15);
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML( file_get_contents('view_imprimir.css') , 1);
$mpdf->WriteHTML($html, 2);
$mpdf->Output('mpdf.pdf','I');
?>