<?php

/**
 *
 */
require "../../class/App.php";


/**
 * Recebendo dados
 */
$proposta = (isset($_POST['proposta'])) ? $_POST['proposta'] : null ;
require "read.php";

?>
<?php foreach ($propostas as $proposta): ?>
    <tr>
        <td>
            <input type="checkbox" name="" value="<?php echo $proposta->id ?>" class="input-mini"/>
            <input type="hidden" name="" value="<?php echo $proposta->id ?>" />
        </td>
        <td>
            <input type="text" value="<?php echo FuncAux::data_converte_para_visualizar($proposta->renovacao) ?>" class="input-mini "/>
        </td>
        <td>
            <input type="text" value="<?php echo $proposta->proposta ?>" class="input-mini "/>
        </td>
        <td>
            <input type="text" value="<?php echo $proposta->segurado ?>"/>
        </td>
        <td>
            <select class="input-small ">
                <?php
                $combo = new HTMLcombo();
                $combo->valor_selecionado = $proposta->cia;
                echo $combo->getOptions(Propostas::retComboCia());
                ?>
            </select>
        </td>
        <td>
            <select class="input-small ">
                <?php
                $combo = new HTMLcombo();
                $combo->valor_selecionado = $proposta->tipo;
                echo $combo->getOptions(Propostas::retComboTipo());
                ?>
            </select>
        </td>
        <td>
            <input type="text" value="<?php echo $proposta->detalhes ?>"/>
        </td>
        <td>
            <input type="text" value="<?php echo $proposta->apolice ?>" class="input-small" />
        </td>
        <td>
            <input type="text" value="<?php echo FuncAux::data_converte_para_visualizar($proposta->vencimento) ?>"
                   class="input-small "/>
        </td>
        <td>
            <input type="text" value="<?php echo $proposta->prem_liq ?>" class="input-small "/>
        </td>
        <td>
            <input type="text" value="<?php echo $proposta->comissao ?>" class="input-mini "/>
        </td>
        <td>
            <select class="input-small" title="status">
                <?php
                $combo = new HTMLcombo();
                $combo->valor_selecionado = $proposta->status;
                echo $combo->getOptions(Propostas::retComboStatus());
                ?>
            </select>
        </td>
        <td>
            <a class="btn btn-mini" href="#" title="deletar"><i class="icon-remove"></i></a>
        </td>
    </tr>
<?php endforeach; ?>