<?php

require "../../class/App.php";

if( ! isset($_SESSION['id-usuario'])  ) header("Location: ".App::getAppPath()."modulos/usuarios/")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SEG</title>
        <link href="<?php echo App::getAppPath(); ?>css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <style type="text/css" media="all">
            .btn-group > .btn:first-child {
                margin-top: 2px;
                margin-right: 2px;
            }
            .table {
                border: 2px solid #F5F5F5;
            }
            .table th, .table td {
                text-align: center;
                line-height: 12px;
                padding: 2px 0px;
            }
            .table thead th {
                vertical-align: middle;
            }
            .table tr.cabecalho {
                background-color: #F5F5F5;
                color: #767676;
                font-size: 12px
            }
            input[type='text'], select {
                font-size: 10px;
                margin-bottom: 0px;
                text-align: center;
            }
            input[type='text'] {
                height: 14px;
                line-height: 14px;
            }
            select {
                height: 24px;
                line-height: 24px;
            }
            input[type='text'].nao-validado, select.nao-validado {
                border-color: red;
                color: red;
            }
            input[type='text'].status_n_check, select.status_n_check {
                color: #FAA732;
            }
            input[type='text'].falta_ass, select.falta_ass {
                color: #DA4F49;
            }
            input[type='text'].ok, select.ok {
                color: #49AFCD;
            }
            div.status button {
                width: 150px;
                margin-top:5px
            }

            option.status_n_check {color: #FAA732}
            option.falta_ass {color: #DA4F49}
            option.ok {color: #49AFCD}

            div#filtro input, div#filtro select {
                margin-bottom: 16px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">

            <div class="row">
                <div class="span12">
                    <h3>Listando Propostas</h3>
                </div>
            </div>

            <div id="lista">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="btn-group pull-left">
                            <a class="btn dropdown-toggle btn-inverse" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                <li><a tabindex="-1" href="#" id="btn-filtros">Filtros</a></li>
                                <li><a tabindex="-1" href="#" id="btn-rem-filtros">Remover Filtros</a></li>
                                <li class="divider"></li>
                                <li><a tabindex="-1" href="#" id="btn-imprimir">Imprimir</a></li>
                                <li><a tabindex="-1" href="javascript: alert('void()')" id="btn-imprimir">Abrir Excel</a></li>
                                <li class="divider"></li>
                                <li><a tabindex="-1" href="#" id="btn-renovar">Renovar</a></li>
                                <li class="divider"></li>
                                <li><a tabindex="-1" href="../usuarios/" id="btn-renovar">Sair</a></li>
                            </ul>
                        </div>

                        <ul id="ctr-meses" class="nav nav-pills pull-left" style="-margin-bottom: 0px">
                            <li id="btn-ano-ant"><a href="#"></a></li>
                            <li><a href="1">jan</a></li>
                            <li><a href="2">fev</a></li>
                            <li><a href="3">mar</a></li>
                            <li><a href="4">abr</a></li>
                            <li><a href="5">mai</a></li>
                            <li><a href="6">jun</a></li>
                            <li><a href="7">jul</a></li>
                            <li><a href="8">ago</a></li>
                            <li><a href="9">set</a></li>
                            <li><a href="10">out</a></li>
                            <li><a href="11">nov</a></li>
                            <li><a href="12">dez</a></li>
                            <li id="btn-ano-prox"><a href="#"></a></li>
                        </ul>

                        <div class="status pull-left">
                            <button type="button" class="btn btn-warning btn-mini" data-toggle="button" id="btn-status-n-checado">Não checado (<span>10</span>)</button>
                            <button type="button" class="btn btn-danger btn-mini" data-toggle="button" id="btn-status-falta-ass">Falta assinatura (<span>3</span>)</button>
                            <button type="button" class="btn btn-info btn-mini" data-toggle="button" id="btn-status-ok">OK (<span>12</span>)</button>
                        </div>
                        <div class="clearfix"></div>

                        <div id="lista-alerta"></div>

                        <table class="table" id="tabPropostas">
                            <thead>
                                <tr class="cabecalho">
                                    <th><input type="checkbox" class="input-mini "/></th>
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
                                    <th>deletar</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div><!-- row -->

                <div class="row-fluid" style="display: none" id="ctrSalvarCancelar">
                    <div class="span12" style="margin-top: 11px; text-align: center">
                        <button class="btn btn-inverse btn-small" type="button" id="btn-canc-prop">cancelar</button>
                        <button class="btn btn-danger btn-small" type="button" id="btn-salv-prop">salvar</button>
                    </div>
                </div>

                <div class="row-fluid" id="ctrInserir">
                    <div class="span12" style="margin-top: 11px; text-align: center">
                        <button class="btn btn-small btn-success" type="button" id="btn-ins-prop">Inserir</button>
                    </div>
                </div>

            </div><!-- lista -->


            <div id="filtro" style="display: none">
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
                                $combo = new HTMLcombo();
                                $combo->valor_selecionado = $proposta->cia;
                                echo $combo->getOptions(Propostas::retComboCia());
                                ?>
                            </select>
                        </div>
                        <div class="span2">
                            <label for="tipo">Tipo</label>
                            <select class="span12" name="tipo" id="tipo">
                                <option></option>
                                <?php
                                $combo = new HTMLcombo();
                                $combo->valor_selecionado = $proposta->tipo;
                                echo $combo->getOptions(Propostas::retComboTipo());
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
            </div><!--formFiltro -->

            <div id="renovacao" style="display: none">
                <div class="row-fluid">
                    <div class="span11">
                        <fieldset>
                            <legend>Formulário de renovação</legend>
                        </fieldset>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span9">
                        <table class="table" id="tabRenovacao">
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
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span9">
                        <div style="margin-top: 11px; text-align: center">
                            <button id="btn-canc-renovacao" class="btn btn-inverse btn-small" type="button">Cancelar</button>
                            <button id="btn-apli-renovacao" class="btn btn-success btn-small" type="button">Renovar</button>
                        </div>
                    </div>
                </div>
            </div><!--renovacao -->

        </div><!-- container -->

        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/jquery1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="index.js"></script>
    </body>
</html>