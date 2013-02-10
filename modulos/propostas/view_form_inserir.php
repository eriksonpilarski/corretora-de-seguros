<form action="#" method="post" id="form-inserir">
    <div class="row-fluid">
        <div class="span8">
            <legend>Inserindo novas propostas</legend>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <label for="proposta">Proposta</label>
            <input type="text" name="proposta" id="proposta" class="span12"/>
        </div>
        <div class="span4">
            <label for="segurado">Segurado</label>
            <input type="text" name="segurado" id="segurado" class="span12"/>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <label for="venc_inicio">Vigência</label>
            <input type="text" name="vig_inicio" id="vig_inicio" class="span12" placeholder="início"/>
        </div>
        <div class="span2">
            <label for="venc_inicio">&nbsp;</label>
            </span><input type="text" name="vig_termino" id="vig_termino" class="span12" placeholder="término"/>
        </div>
        <div class="span4">
            <label for="detalhes">Detalhes</label>
            <input type="text"  name="detalhes" id="detalhes" class="span12"/>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <label for="cia">CIA</label>
            <select class="span12" name="cia" id="cia">
                <option></option>
                <?php
//                    $combo = new HTMLcombo();
//                    $combo->valor_selecionado = $proposta->cia;
//                    echo $combo->getOptions(Propostas::retComboCia());
                ?>
            </select>
        </div>
        <div class="span2">
            <label for="tipo">Tipo</label>
            <select class="span12" name="tipo" id="tipo">
                <option></option>
                <?php
//                    $combo = new HTMLcombo();
//                    $combo->valor_selecionado = $proposta->tipo;
//                    echo $combo->getOptions(Propostas::retComboTipo());
                ?>
            </select>
        </div>
        <div class="span4">
            <label for="apolice">Apolice</label>
            <input type="text"  name="apolice" id="apolice" class="span12"/>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <label for="prem-liq">Prémio Liq.</label>
            <input type="text" name="prem-liq" id="prem-liq" class="span12"/>
        </div>
        <div class="span4">
            <label for="comissao">Comissão</label>
            <input type="text" name="comissao" id="comissao" class="span12"/>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span8" style="margin-top: 11px; text-align: center">
            <button id="btn-inserir-voltar" class="btn btn-inverse btn-small" type="button">Voltar</button>
            <button id="btn-inserir" class="btn btn-success btn-small" type="button">Inserir</button>
        </div>
    </div>
</form>
<div id="inserir-tab-propostas"></div>