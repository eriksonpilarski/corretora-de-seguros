<?php
require "../../php/class/App.php";

if (!isset($_SESSION['id-usuario']))
    header("Location: " . App::getAppPath() . "modulos/usuarios/")
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SEG</title>
        <link href="<?php echo App::getAppPath(); ?>css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link href="index.css" rel="stylesheet" media="screen" />
        <style type="text/css" media="all">
        </style>
    </head>
    <body>
        <!--<button id="teste">teste</button>-->
        <div class="container-fluid">

            <div class="row">
                <div class="span12">
                    <h3>Listando Propostas</h3>
                </div>
            </div>

            <div id="lista">
                <div class="row-fluid">
                    <div class="span12">

                        <div id="ctr-action" class="btn-group pull-left respiro">
                            <a class="btn dropdown-toggle btn-inverse" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                <li><a tabindex="-1" href="#" id="btn-action-inserir">Inserir</a></li>
                                <li><a tabindex="-1" href="#" id="btn-action-renovar">Renovar</a></li>
                                <li class="divider"></li>
                                <li><a tabindex="-1" href="#" id="btn-action-filtros">Filtros</a></li>
                                <li><a tabindex="-1" href="#" id="btn-action-rem-filtros">Remover Filtros</a></li>
                                <li><a tabindex="-1" href="index.php" id="btn-action-data-atual">Ver data autal</a></li>
                                <li class="divider"></li>
                                <li><a tabindex="-1" href="#" id="btn-action-imprimir">Imprimir</a></li>
                                <li><a tabindex="-1" href="javascript: alert('void()')" id="btn-action-excel">Abrir Excel</a></li>
                                <li class="divider"></li>
                                <li><a tabindex="-1" href="javascript: alert('void()')" id="btn-action-backup">Backup</a></li>
                                <li><a tabindex="-1" href="../usuarios/" id="btn-action-sair">Sair</a></li>
                            </ul>
                        </div>

                        <div id="ctr-meses">
                            <div class="btn-group pull-left respiro">
                                <a id="btn-meses-principal" class="btn dropdown-toggle btn-inverse" data-toggle="dropdown"
                                    href="#"></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                    <li><a tabindex="-1" href="2012" >2012</a></li>
                                    <li><a tabindex="-1" href="2013" >2013</a></li>
                                    <li><a tabindex="-1" href="2014" >2014</a></li>
                                    <li><a tabindex="-1" href="2015" >2015</a></li>
                                </ul>
                            </div>
                            <ul class="nav nav-pills pull-left" style="-margin-bottom: 0px">
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
                            </ul>
                        </div>

<!--                        <div  class="status pull-left">
                            <button type="button" class="btn btn-success btn-mini" data-toggle="button" >Não checado </button>
                            <button type="button" class="btn btn-danger btn-mini" data-toggle="button" >Falta assinatura </button>
                            <button type="button" class="btn btn-info btn-mini" data-toggle="button" >OK </button>
                        </div>-->
                        <div id="ctr-status" class="btn-group status pull-left" data-toggle="buttons-radio">
                            <button type="button" class="btn btn-success">Não checado</button>
                            <button type="button" class="btn btn-danger">Falta assinatura </button>
                            <button type="button" class="btn btn-info">OK</button>
                        </div>
                        <div class="clearfix"></div>

                        <div id="lista-alerta"></div>

                        <table id="tab-propostas" class="table" >
                            <thead>
                                <tr class="cabecalho">
                                    <th><input type="checkbox" class="input-mini "/></th>
                                    <th>Proposta</th>
                                    <th>Segurado</th>
                                    <th>Renovação</th>
                                    <th>Vencimento</th>
                                    <th>Detalhes</th>
                                    <th>CIA</th>
                                    <th>Tipo</th>
                                    <th>Apolice</th>
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

            </div><!-- lista -->

            <div id="inserir"   style="display: none"></div>
            <div id="renovacao" style="display: none"></div>
            <div id="filtros"   style="display: none"></div>

        </div><!-- container -->

        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/jquery1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/jquery.maskedinput-1.3.min.js"></script>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/jquery.priceFormat1.7.min.js"></script>
        <script type="text/javascript" src="index.js"></script>
    </body>
</html>