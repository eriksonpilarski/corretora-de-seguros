<?php
/**
 *
 */

/**
 *
 */
class FuncAux {
    /**
     * A função dataConversor é responsavél por alterar o formato da data em dois tipos:
     *
     * 1.) Data de Visualização:
     *     Recebe a data com o formato Americano (Y-m-d) e converte para o formato Brasileiro (d-m-Y)
     *     Para isso é necessário utilizar a função data_converte_para_visualizar.
     *
     *     Exemplo:
     *     $date = FuncAux::data_converte_para_visualizar('2012-07-13');
     *
     * 2.) Data de Gravação:
     *     Recebe a data com o formato Brasileiro (d-m-Y) e converte para o formato Americano (Y-m-d)
     *     Para isso é necessário utilizar a função data_converte_para_mysql.
     *
     *     Exemplo:
     *     $date = FuncAux::data_converte_para_mysql('2012-07-13');
     *
     * @param type $formato_entrada
     * @param type $formato_saida
     * @param type $str_data
     * @return type
     */
    static function dataConversor($formato_entrada, $formato_saida, $str_data){

        date_default_timezone_set('America/Sao_Paulo');
        $date = DateTime::createFromFormat($formato_entrada, $str_data);

        if($date)
            return $date->format($formato_saida);
        else
            return null;

    }

    /**
     * É responsável pela conversão do formato americano para o brasileiro,
     * essa instancia a função dataConversor lhe enviando todos os parametros
     * solicitados para a realização da função.
     *
     * @param type $data
     * @return type
     */
    static function data_converte_para_visualizar( $data ){
        return self::dataConversor("Y-m-j", "j/m/Y", $data);
    }

    /**
     * É responsável pela conversão do formato brasileiro para o americano,
     * essa instancia a função dataConversor lhe enviando todos os parametros
     * solicitados para a realização da função.
     *
     * @param type $data
     * @return type
     */
    static function data_converte_para_mysql( $data ){
        return self::dataConversor("j/m/Y", "Y-m-j", $data);
    }
    
    /**
     * 
     * @param type $data
     * @return type
     */
    static function addUmAno($data){
        $DateTime = new DateTime( $data, new DateTimeZone( 'America/Sao_Paulo') );
        $DateTime->add( new DateInterval( "P1Y" ) );
        
        return $DateTime->format( "d/m/Y" );        
    }



    /**
     * Retorna o mês completo
     *
     *
     * @param type $qual_mes
     * @return type
     */
    static function retMes($qual_mes=null){

        $mes = array(
            '1' => 'Janeiro',
            '2' => 'Fevereiro',
            '3' => 'Março',
            '4' => 'Abril',
            '5' => 'Maio',
            '6' => 'Junho',
            '7' => 'Julho',
            '8' => 'Agosto',
            '9' => 'Setembro',
            '1,'=> 'Outubro',
            '11'=> 'Novembro',
            '12'=> 'Dezembro',
        );

        # mes atual ou o escolhido
        $res = ($qual_mes) ? $mes[$qual_mes] :  $mes[date('m')];

        return $res;
    }


    /**
     * Retorna o primeiro nome
     *
     * <p>Usado tanto para usuário como clientes e pesquisados.</p>
     *
     * @param string $nome
     * @return type
     */
    static function retPrimeiroNome( $nome ) {
        $arr_nome = explode(" ", $nome);

        return $arr_nome[0];
    }

    /**
     * Retorna o primeiro e último nome
     *
     * <p>Usado na exibição do gráfico localizador.</p>
     *
     * @param array $nome
     * @return type
     */
    static function retPrimeiroUltimoNome( $nome ){
       $arr_nome = explode(" ", $nome);
       $i        = count($arr_nome)-1;
       $nome     = $arr_nome[0]." ". $arr_nome[$i];

       return $nome;
    }


    /**
     *
     * @param type $nome_grafico
     * @return string
     */
    static function retNomeGrafico( $nome_grafico ){
        date_default_timezone_set('America/Sao_Paulo');
        $date   = new DateTime();
        $date->add(new DateInterval('PT1S'));
        $codigo = $date->getTimestamp();

        $diretorio = "../../filesTemp/";
        $nome      = Session::getUsuarioId()."_".$codigo."_".$nome_grafico;
        $grafico   = $diretorio.$nome;

        return $grafico;
    }
}# end class