$(document).ready(function() {

    var Proposta = {
        STATUS_N_CHECADO: "nao_checado",
        STATUS_FALTA_ASS: "falta_ass",
        STATUS_OK: "ok",

        reiniciarObjeto: function(){
            this.id         = "";
            this.renovacao = {
                    inicio: "",
                    termino: ""
            };
            this.proposta   = "";
            this.segurado   = "";
            this.cia        = "";
            this.tipo       = "";
            this.detalhes   = "";
            this.apolice    = "";
            this.vencimento = {
                    inicio: "",
                    termino: ""
            };
            this.prem_liq   = "";
            this.comissao   = "";
            this.status     = {
                nao_checado: false,
                falta_ass: false,
                ok: false
            };
        },

        filtrado: function(){
            var flag = false;

            //id
            //renovação
            if(this.proposta != "")   {flag = true}
            if(this.segurado != "")   {flag = true}
            if(this.cia != "")        {flag = true}
            if(this.tipo != "")       {flag = true}
            if(this.detalhes != "")   {flag = true}
            if(this.apolice != "")    {flag = true}
            if(this.vencimento.inicio != "" && this.vencimento != ""){flag = true;}
            if(this.prem_liq != "")  {flag = true}
            if(this.comissao != "")  {flag = true}

            if(this.status.nao_checado) {flag = true}
            if(this.status.falta_ass)   {flag = true}
            if(this.status.ok)          {flag = true}

            return flag;
        }
    };
    Proposta.reiniciarObjeto();

    var ajax = {
        crudTabPropostas: function(dados){
            $.post( "index_action.php", dados, function( data ) {
                $('body').append( data );
            });
        },
        carregarTabPropostas: function(dados, callback){
            $.post( "view_lista_pospostas.php", dados, function( data ) {
                $('tbody', '#tabPropostas').empty().append( data );
                    callback();
            });
        },
        carregarTabRenovacao: function(dados){
            $.post( "view_lista_renovacoes.php", dados, function( data ) {
                $('tbody', '#tabRenovacao').empty().append( data );
            });
        }
    };

    var TelaLista = {
        elem: $("#lista"),
        eAlerta: $("#lista-alerta"),
        mostrarAlerta: function(){
            this.eAlerta.empty().append('<div class="alert alert-success">'+
                                            '<strong>Atenção!</strong> Conteúdo filtrado!'+
                                        '</div>')
        },
        esconderAlerta: function(){
            this.eAlerta.empty();
        }
    };

    var CtrMeses = {
        elem: $('#ctr-meses'),  // elemento principal
        eAno_ant: {},           // elemento <li> ano anterior
        eAno_prox: {},          // elemento <li> ano posterior
        lis: {},                // lista com elementos <li> sem os anos
        ano_atual: 0,           // ano atual
        mes_atual: 0,           // mês atual
        mes_dia_pri: 1,         // primeiro dia do mês
        mes_dia_ulti: 0,        // último dia do mês

        init: function(){
            this.lis       = this.elem.find('li:not([id])');
            this.eAno_ant  = this.elem.find('#btn-ano-ant');
            this.eAno_prox = this.elem.find('#btn-ano-prox');
            this.removerAtual();
            this.setEventos();
            this.hoje();
        },
        hoje: function(){
            var hoje = new Date();
            this.mes_atual = hoje.getMonth()+1;
            this.ano_atual = hoje.getFullYear();
            this.mes_dia_ulti = this.daysInMonth(this.mes_atual, this.ano_atual);
        },
        retDataAtualParaMysql: function($primeira_ou_ultima){

            if($primeira_ou_ultima == "primeira")
                return this.ano_atual + "-" + this.mes_atual + "-" + this.mes_dia_pri;

            else if($primeira_ou_ultima == "ultima")
                return this.ano_atual + "-" + this.mes_atual + "-" + this.mes_dia_ulti;

        },
        removerAtual: function(){
            this.lis.each(function(){
                $(this).removeClass('active');
            });
        },
        //http://blog.lppjunior.com/javascript-ultimo-dia-do-mes/
        daysInMonth: function (month,year) {
            var dd = new Date(year, month, 0);
            return dd.getDate();
        },
        // =======================================================
        setEventos: function(){
            this.setClickMeses();
            this.setClickAnos();
        },
        setClickMeses: function(){
            var me = this;
            this.lis.each(function(){
                var li = $(this),
                    a  = $(this).children();

                a.unbind('click');
                a.click(function(event){
                    event.preventDefault();
                    me.removerAtual();
                    li.addClass('active');
                    me.mes_atual  = a.attr('href');
                    me.mes_dia_ulti  = me.daysInMonth(me.mes_atual, me.ano_atual);
                    Proposta.renovacao = {
                        inicio:  me.retDataAtualParaMysql('primeira'),
                        termino: me.retDataAtualParaMysql('ultima')
                    };
                    CtrTabelaProposta.popular(Proposta);
                    CtrTabelaProposta.tbody.show();         // caso esteja hiden
                    CtrTabelaProposta.mostrarCtrInserir();  // caso esteja hiden
                });
            });
        },
        setClickAnos: function(){
            var me = this;
            var trocaAno = function(){
                me.eAno_ant.fadeOut(function(){
                    me.eAno_ant.children().text(  me.ano_atual - 1  );
                    me.eAno_ant.fadeIn();
                });
                me.eAno_prox.fadeOut(function(){
                    me.eAno_prox.children().text(  me.ano_atual + 1  );
                    me.eAno_prox.fadeIn();
                });
                me.removerAtual();
                TelaLista.esconderAlerta();
                CtrTabelaProposta.esconderCtrInserir();
                CtrTabelaProposta.esconderCtrSalvar();
                CtrTabelaProposta.tbody.hide();
                CtrStatus.reiniciar();
                CtrMeses.mes_atual = 0; // zerar o mês atual
            };
            this.eAno_ant.click(function(){
                me.ano_atual = me.ano_atual - 1;
                trocaAno();
            });
            this.eAno_prox.click(function(){
                me.ano_atual = me.ano_atual + 1;
                trocaAno();
            });
        },
        atualizar: function(){
            this.removerAtual();
            this.lis.eq(this.mes_atual-1).addClass('active');
            this.eAno_ant.children().text(this.ano_atual  - 1);
            this.eAno_prox.children().text(this.ano_atual + 1);
        },
        reiniciar: function(){
            console.log("o reiniciar do CtrMeses está desligado (393)");
//            var me = this,
//                dia_inicio  = 1,
//                dia_termino = this.daysInMonth(this.mes_atual, this.ano_atual);
//
//            this.removerAtual();
//            this.lis.eq(this.mes_atual-1).addClass('active');
//            this.eAno_ant.children().text(this.ano_atual  - 1);
//            this.eAno_prox.children().text(this.ano_atual + 1);
        }
    };
    CtrMeses.init();
    CtrMeses.atualizar();

    var CtrTabelaProposta = {
        elem: $("#tabPropostas"),
        thead: {},
        tbody: {},
        ctrSalvarCancelar: {},
        ctrInserir: {},
        btnSalvar: {},
        btnCancelar: {},
        btnInserir: {},
        init: function(){
            this.thead             = this.elem.find("thead");
            this.tbody             = this.elem.find("tbody");

            this.ctrSalvarCancelar = $("#ctrSalvarCancelar");
            this.btnSalvar         = $("#btn-salv-prop");
            this.btnCancelar       = $("#btn-canc-prop");

            this.ctrInserir        = $("#ctrInserir");
            this.btnInserir        = $("#btn-ins-prop");

            this.setEventos();
            Proposta.renovacao = {
                inicio:  CtrMeses.retDataAtualParaMysql('primeira'),
                termino: CtrMeses.retDataAtualParaMysql('ultima')
            };
            this.popular(Proposta);

        },
        setEventos: function(){
            this.setAlterarTabela();
            //this.setCheckTodos();// não precisa fazer isso neste ponto
            //this.setButtonSalvar();// não precisa fazer isso neste ponto
            this.setButtonCancelar();
            this.setButtonInserir();
        },
        setAlterarTabela: function(){
            var me = this,
                els = this.tbody.find("input, select").not("input:checkbox").not("input:hidden");

            els.each(function(){
                $(this).change(function(){
                    $(this).css("border-color", "red");
                        me.setButtonSalvar();
                        me.mostrarCtrSalvar();
                        me.esconderCtrInserir();
                });
            });
        },
        mostrarCtrSalvar: function(){
            this.ctrSalvarCancelar.show(1000);
        },
        esconderCtrSalvar: function(){
            this.ctrSalvarCancelar.hide(700);
        },
        mostrarCtrInserir: function(){
            this.ctrInserir.show(1000);
        },
        esconderCtrInserir: function(){
            this.ctrInserir.hide(700);
        },
        setButtonSalvar: function(inserir){
            var me = this,
                propostas = [],  // array com as propostas
                propTemp = {},   // posposta clonada, temporária
                linha_dados,     // cada linha da tabela
                linha_dados_str; // string de busca das linhas

            this.btnSalvar.unbind('click');
            this.btnSalvar.click(function(){
                me.esconderCtrSalvar();
                me.mostrarCtrInserir();

                linha_dados_str = (inserir) ? "tr[title='novo']" : "tr" ;
                me.tbody.find(linha_dados_str).each(function(){
                    linha_dados = $(this).find("input, select").not('input:checkbox');

                    Proposta.reiniciarObjeto();
                    propTemp = jQuery.extend({}, Proposta);
                    propTemp.id         = linha_dados.eq(0).val();
                    propTemp.renovacao  = linha_dados.eq(1).val();
                    propTemp.proposta   = linha_dados.eq(2).val();
                    propTemp.segurado   = linha_dados.eq(3).val();
                    propTemp.cia        = linha_dados.eq(4).val();
                    propTemp.tipo       = linha_dados.eq(5).val();
                    propTemp.detalhes   = linha_dados.eq(6).val();
                    propTemp.apolice    = linha_dados.eq(7).val();
                    propTemp.vencimento = linha_dados.eq(8).val();
                    propTemp.prem_liq   = linha_dados.eq(9).val();
                    propTemp.comissao   = linha_dados.eq(10).val();
                    propTemp.status     = linha_dados.eq(11).val();
                    propostas.push(propTemp);
                });
                ajax.crudTabPropostas({
                    propostas: JSON.stringify(propostas),
                    ac: (inserir) ? "in" : "up"
                });
                CtrMeses.reiniciar();
            });
        },
        setButtonCancelar: function(){
            var me = this;

            this.btnCancelar.click(function(){
                me.esconderCtrSalvar();
                me.mostrarCtrInserir();
                CtrMeses.reiniciar();
            });
        },
        setButtonInserir: function(){
            var me = this;
            this.btnInserir.click(function(){
                $.post( "view_lista_linha.php", function( data ) {
                        me.tbody.append( data );
                    }
                );
                me.mostrarCtrSalvar();
                me.setButtonSalvar('inserir');
            });
        },
        setButtonsDeletar: function(){
            var me = this,
                linha,
                id;

            $("a[title='deletar']", this.tbody).each(function(){
                $(this).click(function(event){
                    event.preventDefault();
                    linha = $(this).parent().parent();
                    id = linha.find("input:hidden").val();
                    ajax.crudTabPropostas({
                        id: id,
                        ac: "del"
                    });
                    linha.hide(500);
                });
            });
        },
        setComboStatus: function(){
            var me = this;
            $("select", this.elem).each(function(){
                $(this).change(function(){
                    me.colorirLinhas($(this).parent().parent());
                });
            });
        },
        setCheckTodos: function(){
            var checks = this.tbody.find("input:checkbox");
            $("input", this.thead).click(function(){

                if(  $(this).is(":checked")  ){
                    checks.attr("checked", true);
                } else {
                    checks.attr("checked", false);
                }
            });
        },
        alguma_proposta_selecionada: function(){
            var flag = false

            this.tbody.find("input:checkbox").each(function(){
                if(  $(this).is(":checked") )
                    flag = true;
            });

            return flag;
        },
        colorir_options: function(){
            this.elem.find("select[title='status']").each(function(){
                $(this).find("option").eq(0).addClass("status_n_check");
                $(this).find("option").eq(1).addClass("falta_ass");
                $(this).find("option").eq(2).addClass("ok");
            });
        },
        colorirLinhas: function(linhas){
            var retEstiloStatus = function(status){
                switch(status){
                    case "n_check":
                        return "status_n_check"
                        break;
                    case "falta_ass":
                        return "falta_ass"
                        break;
                    case "ok":
                        return "ok"
                        break;
                }
            }
            linhas.each(function(){
                var status    = $(this).find("select[title='status']").val(),
                    controles = $(this).find("input[type='text'], select");

                controles.each(function(){
                    $(this).removeClass("status_n_check").removeClass("falta_ass").removeClass("ok");
                    $(this).addClass(  retEstiloStatus(status)  );
                });
            });
        },
        popular: function($dados){
            var me = this,
                dados,
                callback;

            dados    = {proposta: JSON.stringify($dados)}
            callback = function(){
                me.colorirLinhas(  me.elem.find('tr:not([class="cabecalho"])')  );
                me.colorir_options();
                me.setComboStatus();
                me.setAlterarTabela();
                me.setButtonsDeletar();
                me.setCheckTodos();
            };
            ajax.carregarTabPropostas(dados, callback);
        }
    }
    CtrTabelaProposta.init();

    var CtrStatus = {
        btnNChecado: {},
        btnFaltaAss: {},
        btnOK: {},
        init: function() {

            this.btnNChecado.elem = $("#btn-status-n-checado");
            this.btnFaltaAss.elem = $("#btn-status-falta-ass");
            this.btnOK.elem       = $("#btn-status-ok");

            this.btnNChecado.estado = "off";
            this.btnFaltaAss.estado = "off";
            this.btnOK.estado       = "off";

            this.btnNChecado.total = this.btnNChecado.elem.find('span');
            this.btnFaltaAss.total = this.btnFaltaAss.elem.find('span');
            this.btnOK.total       = this.btnOK.elem.find('span');

            this.setEventos();

        },
        setEventos: function(){
            var me = this;
            var atualizar_tabela = function(){
                CtrTabelaProposta.popular(Proposta);
                TelaLista.mostrarAlerta();
            }

            this.btnNChecado.elem.click(function(){
                if (me.btnNChecado.estado == "off") {// ligar
                    me.btnNChecado.estado = "on";
                    Proposta.status.nao_checado = true;
                    atualizar_tabela();
                    CtrTabelaProposta.esconderCtrSalvar();
                    CtrTabelaProposta.mostrarCtrInserir();
               } else {// desligar
                    me.btnNChecado.estado = "off";
                    Proposta.status.nao_checado = false;
                    atualizar_tabela();
                    if( ! Proposta.filtrado() ){TelaLista.esconderAlerta();}
                    CtrTabelaProposta.esconderCtrSalvar();
                    CtrTabelaProposta.mostrarCtrInserir();
                }
            });

            this.btnFaltaAss.elem.click(function(){
                if (me.btnFaltaAss.estado == "off") {// ligar
                    me.btnFaltaAss.estado = "on";
                    Proposta.status.falta_ass = true;
                    atualizar_tabela();
                    CtrTabelaProposta.esconderCtrSalvar();
                    CtrTabelaProposta.mostrarCtrInserir();
                } else {// desligar
                    me.btnFaltaAss.estado = "off";
                    Proposta.status.falta_ass = false;
                    atualizar_tabela();
                    if( ! Proposta.filtrado() ){TelaLista.esconderAlerta();}
                    CtrTabelaProposta.esconderCtrSalvar();
                    CtrTabelaProposta.mostrarCtrInserir();
                }
            });

            this.btnOK.elem.click(function(){
                if (me.btnOK.estado == "off") {// ligar
                    me.btnOK.estado = "on";
                    Proposta.status.ok = true;
                    atualizar_tabela();
                    CtrTabelaProposta.esconderCtrSalvar();
                    CtrTabelaProposta.mostrarCtrInserir();
                } else {// desligar
                    me.btnOK.estado = "off";
                    Proposta.status.ok = false;
                    atualizar_tabela();
                    if( ! Proposta.filtrado() ){TelaLista.esconderAlerta();}
                    CtrTabelaProposta.esconderCtrSalvar();
                    CtrTabelaProposta.mostrarCtrInserir();
                }
            });

        },
        reiniciar: function(){
            var desliga_botao = function(botao){
                if(botao.estado == "on"){
                    botao.estado = "off";
                    botao.elem.button('toggle');
                }
            }
            desliga_botao(this.btnNChecado);
            desliga_botao(this.btnFaltaAss);
            desliga_botao(this.btnOK);
        }
    }
    CtrStatus.init();

    var CtrMenuAction = {
        btnFiltros: $('#btn-filtros'),
        btnRemoverFiltros: $('#btn-rem-filtros'),
        btnImprimir: $('#btn-imprimir'),
        btnRenovar: $('#btn-renovar'),

        init: function(){
            this.setEventos();
        },
        setEventos: function(){
            this.setButtonFiltros();
            this.setButtonImprimir();
            this.setButtonRemoverFiltros();
            this.setButtonRenovar()
        },
        setButtonFiltros: function(){
            this.btnFiltros.click(function(){
                TelaFiltro.mostrarFormulario();
            });
        },
        setButtonImprimir: function(){
            this.btnImprimir.click(function(){
                Proposta.renovacao = {
                    inicio:  CtrMeses.retDataAtualParaMysql('primeira'),
                    termino: CtrMeses.retDataAtualParaMysql('ultima')
                };
                $(this).attr("target","_blanck");
                $(this).attr("href","imprimir.php?proposta="+JSON.stringify(Proposta));
            });
        },
        setButtonRemoverFiltros: function(){
            this.btnRemoverFiltros.click(function(){
                TelaLista.esconderAlerta();
                TelaFiltro.reiniciar();
                CtrStatus.reiniciar();
                if(CtrMeses.mes_atual){
                    Proposta.renovacao = {
                        inicio:  CtrMeses.retDataAtualParaMysql('primeira'),
                        termino: CtrMeses.retDataAtualParaMysql('ultima')
                    };
                    CtrTabelaProposta.tbody.show();
                    CtrTabelaProposta.popular(Proposta);
                }
            });
        },
        setButtonRenovar: function(){
            this.btnRenovar.click(function(){
                if(  CtrTabelaProposta.alguma_proposta_selecionada()  ){
                    TelaRenovacao.mostrarFormulario();
                } else {
                    alert("Selecione alguma proposta para poder renovar!!!");
                }
            });
        }
    };
    CtrMenuAction.init();

    var TelaFiltro = {
        elem: $('#filtro'),
        frmFiltro: $('#form-filtro'),
        btnAplicarFiltro: $('#btn-apli-filtros'),
        btnCancelar: $('#btn-canc-filtros'),

        init: function(){
            this.setEventos();
        },
        mostrarFormulario: function(){
            TelaLista.elem.slideUp("slow");
            this.elem.slideDown("slow");
        },
        esconderFormulario: function(){
            TelaLista.elem.slideDown("slow");
            this.elem.slideUp("slow");
        },
        limparFormulario: function(){
            //id
            //renovacao
            $("#proposta").val(null);
            $("#segurado").val(null);
            $("#cia").val(null);
            $("#tipo").val(null);
            $("#detalhes").val(null);
            $("#apolice").val(null);
            $("#venc_inicio").val(null);
            $("#venc_termino").val(null);
            $("#prem-liq").val(null);
            $("#comissao").val(null);
            //status
        },
        reiniciar: function(){
            this.limparFormulario();
            Proposta.reiniciarObjeto();
        },
        setEventos: function(){
            this.setButtonAplicarFiltro();
            this.setButtonCancelar();
            this.setSubmitFormFiltro();
        },
        setButtonAplicarFiltro: function(){
            var me = this;

            this.btnAplicarFiltro.click(function(){
                me.frmFiltro.submit();
                if( Proposta.filtrado() ){
                    TelaLista.mostrarAlerta();
                    CtrTabelaProposta.popular(Proposta);
                    if(Proposta.vencimento.inicio && Proposta.vencimento.termino){
                        CtrMeses.removerAtual();
                    }
                }
                me.esconderFormulario();
            });
        },
        setButtonCancelar: function(){
            var me = this;
            this.btnCancelar.click(function(){
                me.esconderFormulario();
            });
        },
        setSubmitFormFiltro: function(){
           this.frmFiltro.submit(function(event){
                event.preventDefault();
                //id
                //renovacao
                Proposta.renovacao = {
                    inicio:  "",
                    termino: ""
                };
                Proposta.proposta   = $("#proposta").val();
                Proposta.segurado   = $("#segurado").val();
                Proposta.cia        = $("#cia").val();
                Proposta.tipo       = $("#tipo").val();
                Proposta.detalhes   = $("#detalhes").val();
                Proposta.apolice    = $("#apolice").val();
                Proposta.vencimento = {
                    inicio:  $("#venc_inicio").val(),
                    termino: $("#venc_termino").val()
                };
                Proposta.prem_liq   = $("#prem-liq").val();
                Proposta.comissao   = $("#comissao").val();
                //status
            });
        }
    };
    TelaFiltro.init();

    var TelaRenovacao = {
        elem:                $('#renovacao'),
        btnAplicarRenovacao: $('#btn-apli-renovacao'),
        btnCancelar:         $('#btn-canc-renovacao'),
        init: function(){
            this.tbody = this.elem.find("tbody");
            this.setEventos();
        },
        setEventos: function(){
            this.setButtonAplicarRenovacao();
            this.setButtonCancelar();
        },
        setButtonCancelar: function() {
            var me = this;
            this.btnCancelar.click(function(){
                me.esconderFormulario();
            });
        },
        setButtonAplicarRenovacao: function(){
            var me = this,
                propostas = [], // array com as propostas
                propTemp = {},  // posposta clonada, temporária
                linha_dados;    // cada linha da tabela

            this.btnAplicarRenovacao.click(function(){
                propostas = [];

                me.tbody.find("tr").each(function(){
                    linha_dados = $(this).find("input, select").not('input:checkbox');

                    Proposta.reiniciarObjeto();
                    propTemp = jQuery.extend({}, Proposta);
                    propTemp.id         = linha_dados.eq(0).val();
                    propTemp.renovacao  = linha_dados.eq(1).val();
                    propTemp.proposta   = linha_dados.eq(2).val();
                    propTemp.segurado   = linha_dados.eq(3).val();
                    propTemp.cia        = linha_dados.eq(4).val();
                    propTemp.tipo       = linha_dados.eq(5).val();
                    propTemp.detalhes   = linha_dados.eq(6).val();
                    propTemp.apolice    = linha_dados.eq(7).val();
                    propTemp.vencimento = linha_dados.eq(8).val();
                    propTemp.prem_liq   = linha_dados.eq(9).val();
                    propTemp.comissao   = linha_dados.eq(10).val();
                    propTemp.status     = linha_dados.eq(11).val();

                    propostas.push(propTemp);
                });
                ajax.crudTabPropostas({
                    propostas: JSON.stringify(propostas),
                    ac: "renovar"
                });
                TelaRenovacao.esconderFormulario();
                // Quem sabe devemos atualizar a lista para o mês atual ?
                // é igual ao "remover filtro"
            });
        },
        idsSelecionados: function(){
            var id = [];
            $('input:checked[type="checkbox"]', "#tabPropostas").each(function(){
                id.push( $(this)
                    .parent()
                    .parent()
                        .find("input[type='hidden']")
                        .val() )
            });
            return id;
        },
        mostrarFormulario: function(){
            var me = this;
            CtrTabelaRenovacao.popular( me.idsSelecionados() );
            TelaLista.elem.slideUp("slow");
            this.elem.slideDown("slow");
        },
        esconderFormulario: function(){
            TelaLista.elem.slideDown("slow");
            this.elem.slideUp("slow");
        }
    };
    TelaRenovacao.init();

    var CtrTabelaRenovacao = {
        elem: $("#tabRenovacao"),
        init: function(){
        },
        popular: function($dados){
            var me = this,
                dados,
                opt = {};

            opt.sem_checkboxes = true;
            opt.sem_btn_del    = true;

            dados = {ids: JSON.stringify($dados)}
            ajax.carregarTabRenovacao(dados);
        }
    }
    CtrTabelaRenovacao.init();

});// end ready