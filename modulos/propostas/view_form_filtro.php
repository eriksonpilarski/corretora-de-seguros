<form action="#" method="post" id="form-filtro">
    <div class="row-fluid">
        <div class="span8">
            <legend>Formulário de filtro</legend>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <label for="proposta">Proposta</label>
            <input type="text" name="proposta" id="proposta" class="span12"/>
        </div>
        <div class="span4">
            <label for="apolice">Apolice</label>
            <input type="text"  name="apolice" id="apolice" class="span12"/>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <label for="segurado">Segurado</label>
            <input type="text" name="segurado" id="segurado" class="span12"/>
        </div>
        <div class="span2">
            <label for="venc_inicio">Vencimento</label>
            <input type="text"  name="venc_inicio" id="venc_inicio" class="span12" placeholder="data inicial"/>
        </div>
        <div class="span2">
            <label for="venc_inicio">&nbsp;</label>
            </span><input type="text"  name="venc_termino" id="venc_termino" class="span12" placeholder="data final"/>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <label for="cia">CIA</label>
            <select class="span12" name="cia" id="cia">
                <option></option>
                <?php
//                $combo = new HTMLcombo();
//                $combo->valor_selecionado = $proposta->cia;
//                echo $combo->getOptions(Propostas::retComboCia());
                ?>
            </select>
        </div>
        <div class="span2">
            <label for="tipo">Tipo</label>
            <select class="span12" name="tipo" id="tipo">
                <option></option>
                <?php
//                $combo = new HTMLcombo();
//                $combo->valor_selecionado = $proposta->tipo;
//                echo $combo->getOptions(Propostas::retComboTipo());
                ?>
            </select>
        </div>
        <div class="span4">
            <label for="prem-liq">Prémio Liq.</label>
            <input type="text" name="prem-liq" id="prem-liq" class="span12"/>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <label for="detalhes">Detalhes</label>
            <input type="text"  name="detalhes" id="detalhes" class="span12"/>
        </div>
        <div class="span4">
            <label for="comissao">Comissão</label>
            <input type="text" name="comissao" id="comissao" class="span12"/>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span8" style="margin-top: 11px; text-align: center">
            <button id="btn-canc-filtros" class="btn btn-inverse btn-small" type="button">Cancelar</button>
            <button id="btn-apli-filtros" class="btn btn-success btn-small" type="button">Aplicar filtro</button>
        </div>
    </div>
</form>