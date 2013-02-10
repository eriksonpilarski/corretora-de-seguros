$(document).ready(function() {

    var Proposta = {
        STATUS_N_CHECADO: "nao_checado",
        STATUS_FALTA_ASS: "falta_ass",
        STATUS_OK: "ok",

        reiniciarObjeto: function(){
            this.id         = "";
            this.proposta   = "";
            this.segurado   = "";
            this.vig_inicio = {
                dt1: "",
                dt2: ""
            };
            this.vig_termino = {
                dt1: "",
                dt2: ""
            };
            this.detalhes   = "";
            this.cia        = "";
            this.tipo       = "";
            this.apolice    = "";
            this.prem_liq   = "";
            this.comissao   = "";
            this.status     = "";
        },

        filtrado: function(){
            var flag = false;

            //id
            //renovação
            if(this.proposta != "")   {flag = true}
            if(this.segurado != "")   {flag = true}
            if(this.vig_inicio != "" && this.vig_termino != ""){flag = true;}
            if(this.detalhes != "")   {flag = true}
            if(this.cia != "")        {flag = true}
            if(this.tipo != "")       {flag = true}
            if(this.apolice != "")    {flag = true}
            if(this.prem_liq != "")   {flag = true}
            if(this.comissao != "")   {flag = true}
            if(this.status != "")     {flag = true}

            return flag;
        }
    };
    Proposta.reiniciarObjeto();

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

    var TelaInserir = {
        elem: $("#inserir"),
        mostrarFormulario: function(){
            var me = this;
            $.post( "view_form_inserir.php", function( data ) {
                    me.elem.empty().append( data );
                    me.CtrInserir.init();
                }
            );
            TelaLista.elem.slideUp("slow");
            this.elem.slideDown("slow");
        },
        esconderFormulario: function(){
            this.elem.slideUp("slow");
            TelaLista.elem.slideDown("slow");
        },
        CtrInserir: {
            elem: {},
            btnInserir: {},
            btnCancelar: {},
            init: function(){
                this.elem        = $('#form-inserir'),
                this.btnInserir  = this.elem.find('#btn-inserir'),
                this.btnCancelar = this.elem.find('#btn-inserir-cancelar');
                this.setButtonInserir();
                this.setButtonCancelar();
            },
            setButtonInserir: function(){
                this.btnInserir.click(function(){
                    console.log("inserir");
                })
            },
            setButtonCancelar: function(){
                this.btnCancelar.click(function(){
                    TelaInserir.esconderFormulario();
                })
            }
        }
    }

    var CtrMenuAction = {
        btnInserir:         $('#btn-action-inserir'),
        btnRenovar:         $('#btn-action-renovar'),
        btnFiltros:         $('#btn-action-filtros'),
        btnRemoverFiltros:  $('#btn-action-rem-filtros'),
        btnVerDataAtual:    $('#btn-action-data-atual'),
        btnImprimir:        $('#btn-action-imprimir'),
        btnExcel:           $('#btn-action-excel'),
        btnBackup:          $('#btn-action-renovar'),
        btnSair:            $('#btn-action-sair'),

        init: function(){
            this.setButtonInserir();
            this.setButtonRenovar()
            this.setButtonFiltros();
//            this.setButtonImprimir();
//            this.setButtonRemoverFiltros();
        },
        setButtonInserir: function(){
            this.btnInserir.click(function(){
                TelaInserir.mostrarFormulario();
            });
        },
        setButtonRenovar: function(){
            this.btnRenovar.click(function(){
//                if(  CtrTabelaProposta.alguma_proposta_selecionada()  ){
                    TelaRenovacao.mostrarFormulario();
//                } else {
//                    alert("Selecione alguma proposta para poder renovar!!!");
//                }
            });
        },
        setButtonFiltros: function(){
            this.btnFiltros.click(function(){
                TelaFiltros.mostrarFormulario();
            });
        },
        setButtonImprimir: function(){
//            this.btnImprimir.click(function(){
//                Proposta.renovacao = {
//                    inicio:  CtrMeses.retDataAtualParaMysql('primeira'),
//                    termino: CtrMeses.retDataAtualParaMysql('ultima')
//                };
//                $(this).attr("target","_blanck");
//                $(this).attr("href","view_imprimir.php?proposta="+JSON.stringify(Proposta));
//            });
        },
        setButtonRemoverFiltros: function(){
//            this.btnRemoverFiltros.click(function(){
//                TelaLista.esconderAlerta();
//                TelaFiltro.reiniciar();
//                CtrStatus.reiniciar();
//                if(CtrMeses.mes_atual){
//                    Proposta.renovacao = {
//                        inicio:  CtrMeses.retDataAtualParaMysql('primeira'),
//                        termino: CtrMeses.retDataAtualParaMysql('ultima')
//                    };
//                    CtrTabelaProposta.tbody.show();
//                    CtrTabelaProposta.popular(Proposta);
//                }
//                CtrTabelaProposta.esconderCtrSalvar()
//            });
        }
    };
    CtrMenuAction.init();

    var ctrMeses = {
        elem: $("#ctr-meses"),
        btnPrincipal: $("#btn-meses-principal"),
        lisMeses: {},
        lisAnos: {},
        dt: {},

        init: function(){
            this.lisMeses   = this.elem.children(".nav").find("li");
            this.aAnos      = this.elem.find(".dropdown-menu").find("a");
            this.dt = {
                ano: 0,
                mes: "",
                pri_dia_mes: 1,
                ulti_dia_mes: 0
            }
            this.setClickAnos();
            this.setClickMeses();
            this.hoje();
            this.selecionar_mes();
            this.setLabelBtnPrincipal(this.dt.ano);
        },
        hoje: function(){
            var hoje = new Date();
            this.dt.mes = String(hoje.getMonth()+1);
            this.dt.ano = hoje.getFullYear();
            this.dt.ulti_dia_mes = this.daysInMonth(this.dt.mes, this.dt.ano);
        },
        //http://blog.lppjunior.com/javascript-ultimo-dia-do-mes/
        daysInMonth: function (month,year) {
            var dd = new Date(year, month, 0);
            return dd.getDate();
        },
        // =======================================================
        retDataAtual: function(){
            var data_atual = {
                inicio:  this.dt.pri_dia_mes + "/" + this.dt.mes + "/" + this.dt.ano,
                termino: this.dt.ulti_dia_mes + "/" + this.dt.mes + "/" + this.dt.ano
            };
            return data_atual;
        },
        remover_meses: function(){
            this.lisMeses.each(function(){
                $(this).removeClass('active');
            });
        },
        selecionar_mes: function(){
            this.lisMeses.eq(this.dt.mes -1).addClass('active');
        },
        setClickAnos: function(){
            var me = this;
            this.aAnos.each(function(){
                $(this).click(function(event){
                    event.preventDefault();
                    me.setLabelBtnPrincipal(  $(this).text()  );
                    me.dt.ano =  $(this).text();
                    me.remover_meses();
                });
            });
        },
        setClickMeses: function(){
            var me = this;
            this.lisMeses.each(function(){
                var li = $(this),
                    a  = $(this).children();

                a.unbind('click');
                a.click(function(event){
                    event.preventDefault();
                    me.remover_meses();
                    li.addClass('active');
                    me.dt.mes = a.attr('href');
                    me.dt.ulti_dia_mes = me.daysInMonth(me.dt.mes, me.dt.ano);
                    Proposta.vig_inicio = {
                        dt1: me.retDataAtual().inicio,
                        dt2: me.retDataAtual().termino
                    };
                    CtrTabelaProposta.popular(Proposta);
                });
            });
        },
        setLabelBtnPrincipal: function(label) {
            this.btnPrincipal.text(label);
            this.btnPrincipal.append(" <span class=\"caret\"></span>");
        }
    }
    ctrMeses.init();

    var CtrTabelaProposta = {
        elem: $("#tab-propostas"),
        thead: {},
        tbody: {},
        init: function(){
//            this.thead             = this.elem.find("thead");
            this.tbody             = this.elem.find("tbody");
//
//            this.setEventos();
//            Proposta.renovacao = {
//                inicio:  CtrMeses.retDataAtualParaMysql('primeira'),
//                termino: CtrMeses.retDataAtualParaMysql('ultima')
//            };
//            this.popular(Proposta);
//            this.setAlterarTabela();

        },
        setAlterarTabela: function(){
//            var me = this,
//                els = this.tbody.find("input, select").not("input:checkbox").not("input:hidden");
//
//            els.each(function(){
//                $(this).change(function(){
//                    $(this).css("border-color", "red");
//                        me.setButtonSalvar();
//                        me.mostrarCtrSalvar();
//                        me.esconderCtrInserir();
//                });
//            });
        },
        setButtonsDeletar: function(){
//            var me = this,
//                linha,
//                id;
//
//            $("a[title='deletar']", this.tbody).each(function(){
//                $(this).click(function(event){
//                    event.preventDefault();
//                    linha = $(this).parent().parent();
//                    id = linha.find("input:hidden").val();
//                    ajax.crudTabPropostas({
//                        id: id,
//                        ac: "del"
//                    });
//                    linha.hide(500);
//                });
//            });
        },
        setComboStatus: function(){
//            var me = this;
//            $("select", this.elem).each(function(){
//                $(this).change(function(){
//                    me.colorirLinhas($(this).parent().parent());
//                });
//            });
        },
        setCheckTodos: function(){
//            var checks = this.tbody.find("input:checkbox");
//            $("input", this.thead).click(function(){
//
//                if(  $(this).is(":checked")  ){
//                    checks.attr("checked", true);
//                } else {
//                    checks.attr("checked", false);
//                }
//            });
        },
        alguma_proposta_selecionada: function(){
//            var flag = false
//
//            this.tbody.find("input:checkbox").each(function(){
//                if(  $(this).is(":checked") )
//                    flag = true;
//            });
//
//            return flag;
        },
        mascaras: function(){
//            this.tbody.find('input[name="dt-renova"]').mask("99/99/9999");
//            this.tbody.find('input[name="dt-venc"]').mask("99/99/9999");
//            this.tbody.find('input[name="prem_liq"]').priceFormat({
//                prefix: '',
//                centsSeparator: ',',
//                thousandsSeparator: '.'
//            });
        },
        data_para_nova_proposta: function(){
//            var hoje               = new Date(),
//                quase_hoje         = "",
//                quase_daqui_um_ano = "",
//                mes_dois_digitos   = "";
//
//            mes_dois_digitos = (CtrMeses.mes_atual < 10) ? "0"+CtrMeses.mes_atual: CtrMeses.mes_atual;
//
//            quase_hoje = hoje.getDate().toString() + "/" + mes_dois_digitos   + "/" + CtrMeses.ano_atual;
//            quase_daqui_um_ano = hoje.getDate() + "/" + mes_dois_digitos + "/" + (CtrMeses.ano_atual+1);
//
//            this.tbody.find('tr[title="novo"]').find('input[name="dt-renova"]').mask("99/99/9999").val(quase_hoje);
//            this.tbody.find('tr[title="novo"]').find('input[name="dt-venc"]').mask("99/99/9999").val(quase_daqui_um_ano);
        },
        colorir_options: function(){
//            this.elem.find("select[title='status']").each(function(){
//                $(this).find("option").eq(0).addClass("status_n_check");
//                $(this).find("option").eq(1).addClass("falta_ass");
//                $(this).find("option").eq(2).addClass("ok");
//            });
        },
        colorirLinhas: function(linhas){
//            var retEstiloStatus = function(status){
//                switch(status){
//                    case "n_check":
//                        return "status_n_check"
//                        break;
//                    case "falta_ass":
//                        return "falta_ass"
//                        break;
//                    case "ok":
//                        return "ok"
//                        break;
//                }
//            }
//            linhas.each(function(){
//                var status    = $(this).find("select[title='status']").val(),
//                    controles = $(this).find("input[type='text'], select");
//
//                controles.each(function(){
//                    $(this).removeClass("status_n_check").removeClass("falta_ass").removeClass("ok");
//                    $(this).addClass(  retEstiloStatus(status)  );
//                });
//            });
        },
        popular: function(dados){
            var me = this,
                _dados,
                callback;

            _dados   = {proposta: JSON.stringify(dados)}
            callback = function(){
//                me.colorirLinhas(  me.elem.find('tr:not([class="cabecalho"])')  );
//                me.colorir_options();
//                me.mascaras();
//                me.setComboStatus();
//                me.setAlterarTabela();
//                me.setButtonsDeletar();
//                me.setCheckTodos();
            };
            $.post( "view_lista_pospostas.php", _dados, function( data ) {
                me.tbody.empty().append( data );
                    callback();
            });
        }
    }
    CtrTabelaProposta.init();


    var TelaRenovacao = {
        elem: $('#renovacao'),
        init: function(){
        },
        mostrarFormulario: function(){
            var me = this;
            $.post( "view_form_renovacoes.php", function( data ) {
                    me.elem.empty().append( data );
                    me.CtrRenovar.init();                    
                }
            );
            TelaLista.elem.slideUp("slow");
            this.elem.slideDown("slow");
        },
        esconderFormulario: function(){
            this.elem.slideUp("slow");
            TelaLista.elem.slideDown("slow");
        },
        CtrRenovar: {
            elem: {},
            btnInserir: {},
            btnCancelar: {},
            init: function(){
                this.elem        = TelaRenovacao.elem,
                this.btnRenovar  = this.elem.find('#btn-renovar'),
                this.btnCancelar = this.elem.find('#btn-renovar-cancelar');
                this.setButtonRenovar();
                this.setButtonCancelar();
            },
            setButtonRenovar: function(){
                this.btnRenovar.click(function(){
                    console.log("renovar");
                })
            },
            setButtonCancelar: function(){
                this.btnCancelar.click(function(){
                    TelaRenovacao.esconderFormulario();
                })
            }
        }
    };
    TelaRenovacao.init();

    var TelaFiltros = {
        elem: $("#filtros"),
        mostrarFormulario: function(){
            var me = this;
            $.post( "view_form_filtros.php", function( data ) {
                    me.elem.empty().append( data );
                    me.CtrFiltrar.init();
                }
            );
            TelaLista.elem.slideUp("slow");
            this.elem.slideDown("slow");
        },
        esconderFormulario: function(){
            this.elem.slideUp("slow");
            TelaLista.elem.slideDown("slow");
        },
        CtrFiltrar: {
            elem: {},
            btnFiltrar: {},
            btnVoltar: {},
            init: function(){
                this.elem        = $('#form-filtros'),
                this.btnAplicar  = this.elem.find('#btn-filtros-aplicar'),
                this.btnCancelar = this.elem.find('#btn-filtros-cancelar');
                this.setButtonAplicar();
                this.setButtonCancelar();
            },
            setButtonAplicar: function(){
                this.btnAplicar.click(function(){
                    console.log("aplicar");
                })
            },
            setButtonCancelar: function(){
                this.btnCancelar.click(function(){
                    TelaFiltros.esconderFormulario();
                })
            }
        }
    }



//    (function(){
//        $("#teste").click(function(){
//            console.log(Proposta.vig_inicio);
//        })
//    }());


});// end ready