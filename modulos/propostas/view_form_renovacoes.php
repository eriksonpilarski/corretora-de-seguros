<?php
/**
 *
 */

/**
 *
 */
require "../../php/class/App.php";


try {

    /*
     *
     */
    $ids = (isset($_POST['ids'])) ? $_POST['ids'] : null ;

    $obj    = new Propostas();
//    $filtro = $obj->retFiltroTabRenovacoes($ids);

    $renovacoes = array();
//    $renovacoes = Propostas::getObjects($filtro);


} catch (Exception $ex){

    var_dump($ex->getMessage());

}

?>
<div class="row-fluid">
    <div class="span11">
        <fieldset>
            <legend>Formulário de renovação</legend>
        </fieldset>
    </div>
</div>
<div class="row-fluid">
    <div class="span9">
        <table class="table" id="tab-renovacao">
            <thead>
                <tr class="cabecalho">
                    <th>Renovação</th>
                    <th>Proposta</th>
                    <th>Segurado</th>
                    <th>CIA</th>
                    <th>Tipo</th>
                    <th>Detalhes</th>
                    <th>Apolice</th>
                    <th>Vencimento</th>
                    <th>Prémio Liq.</th>
                    <th>Comissão</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
</div>
<div class="row-fluid">
    <div class="span9">
        <div style="margin-top: 11px; text-align: center">
            <button id="btn-renovar-cancelar" class="btn btn-inverse btn-small" type="button">Cancelar</button>
            <button id="btn-renovar" class="btn btn-success btn-small" type="button">Renovar</button>
        </div>
    </div>
</div>
