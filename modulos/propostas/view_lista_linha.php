<?php

/**
 *
 */
require "../../class/App.php";

/**
 * Array combo status
 */
$arrComboStatus = array(
    "n_check"   => "Não checado",
    "falta_ass" => "Falta assinatura",
    "ok"        => "OK",
);

?>
<tr title="novo">
    <td>
        <input type="hidden"  value="null"/><!-- id -->
    </td>
    <td>
        <input type="text" class="input-mini "/><!-- renovação -->
    </td>
    <td>
        <input type="text" class="input-mini "/><!-- proposta -->
    </td>
    <td>
        <input type="text" /><!-- segurado -->
    </td>
    <td>
        <select class="input-small ">
            <?php
            $combo = new HTMLcombo();
            echo $combo->getOptions(Propostas::retComboTipo());
            ?>
        </select>
    </td>
    <td>
        <select class="input-small ">
            <?php
            $combo = new HTMLcombo();
            echo $combo->getOptions(Propostas::retComboCia());
            ?>
        </select>
    </td>
    <td>
        <input type="text" /><!-- detalhes -->
    </td>
    <td>
        <input type="text" class="input-small" /><!-- apolice -->
    </td>
    <td>
        <input type="text" class="input-small "/><!-- vencimento -->
    </td>
    <td>
        <input type="text" class="input-small "/><!-- prémio liquido -->
    </td>
    <td>
        <input type="text" class="input-mini "/><!-- comissão -->
    </td>
    <td><!-- status -->
        <select class="input-small ">
            <?php
            $combo = new HTMLcombo();
            echo $combo->getOptions(Propostas::retComboStatus());
            ?>
        </select>
    <td>
        &nbsp;
    </td>
</tr>