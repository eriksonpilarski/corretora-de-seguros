$(document).ready(function(){
    var ajax = {
        logar: function(dados){
            $.post( "index_action.php", dados, function( resp ) {
                if($.trim(resp) == "logou-se"){
                    $(location).attr("href", "../propostas/index.php");
                } else {
                    $('#msg').empty().append( resp );
                    $('#msg').parent().show(700);
                }
            });
        }
    };
    var telaLogin = {
        form: $("form"),
        init: function(){
            this.setForm();
        },
        setForm: function(){
            this.form.submit(function(event){
                var form_is_valid;

                event.preventDefault();

                function validaCampo(ctr){
                    if( ctr.val() == "" ){
                        ctr.focus();
                        ctr.parent().parent().addClass('error');
                        ctr.siblings().show(500);
                        form_is_valid = false;
                    } else {
                        ctr.parent().parent().removeClass('error');
                        ctr.siblings().hide(500);
                        form_is_valid = true;
                    }
                }
                validaCampo( $('#pass') )
                validaCampo( $('#login') )

                if( ! form_is_valid ) return false;

                ajax.logar(  $(this).serialize()  );
            });
        }
    }
    telaLogin.init();
});