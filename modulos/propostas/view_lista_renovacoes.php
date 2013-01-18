<?php
/**
 *
 */

/**
 *
 */
require "../../class/App.php";


try {

    /*
     *
     */
    $ids = (isset($_POST['ids'])) ? $_POST['ids'] : null ;

    $obj    = new Propostas();
    $filtro = $obj->retFiltroTabRenovacoes($ids);

    $renovacoes = array();
    $renovacoes = Propostas::getObjects($filtro);


} catch (Exception $ex){

    var_dump($ex->getMessage());

}

?>

<?php foreach ($renovacoes as $proposta): ?>
    <tr>
        <td>
            <input type="hidden" name="" value="null" />
            <input type="text" value="<?php echo DatasFuncAux::addUmAno($proposta->renovacao) ?>" class="input-mini" />
        </td>
        <td>
            <input type="text" value="" class="input-mini "/><!-- proposta -->
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
            <input type="text" value="<?php echo $proposta->apolice ?>" class="input-small"/>
        </td>
        <td>
            <input type="text" value="<?php echo DatasFuncAux::addUmAno($proposta->vencimento) ?>" class="input-small"/>
        </td>
        <td>
            <input type="text" value="" class="input-mini"/>
        </td>
        <td>
            <input type="text" value="" class="input-mini"/>
        </td>
        <td>
            <select class="input-small">
                <?php
                $combo = new HTMLcombo();
                $combo->valor_selecionado = "n_check";
                echo $combo->getOptions(Propostas::retComboStatus());
                ?>
            </select>
        </td>
    </tr>
<?php endforeach; ?>