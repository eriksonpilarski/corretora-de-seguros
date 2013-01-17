$(document).ready(function(){
    var ajax = {
        crud: function(dados){
            $.post( "crud.php", dados, function( resp ) {
                if(resp == ""){
                    $(location).attr("href", "../propostas/");
                }

            });
        }
    };
    telaLogin = {
        form: $("form"),
        init: function(){
            this.setForm();
        },
        setForm: function(){
            this.form.submit(function(event){
                event.preventDefault();
                ajax.crud(  $(this).serialize()  );
            });
        }
    }
    telaLogin.init();
});