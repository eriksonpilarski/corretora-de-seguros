<?php
/**
 * View que imprime a lsita de propostas
 */

/**
 * 
 */
require "../../class/App.php";

/**
 * Recebendo dados
 */
$proposta = (isset($_GET['proposta'])) ? $_GET['proposta'] : null ;
require "read.php";


/**
 * HTML
 */
$html  = "<h1>Listando propostas</h1>";
if(  is_object($proposta->vencimento)  ){
    $html .= "<legend>".
                "Período ".
                FuncAux::data_converte_para_visualizar($proposta->vencimento->inicio).
                " à ".
                FuncAux::data_converte_para_visualizar($proposta->vencimento->termino).
             "</legend>";
}
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
                "<td>".FuncAux::data_converte_para_visualizar($proposta->vencimento)."</td>".
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
include("../../biblio/mpdf54/mpdf.php");
$mpdf = new mPDF('c','A4','','',15,15,15,15,15,15); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML( file_get_contents('imprimir.css') , 1);
$mpdf->WriteHTML($html, 2);
$mpdf->Output('mpdf.pdf','I');
?>