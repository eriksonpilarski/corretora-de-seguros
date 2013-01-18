<?php
/**
 *
 */

/**
 *
 */
class Propostas {


    /**
     *
     * @param type $prop_filtro
     * @return type
     */
    static function getObjects($criterio = null){

        $propostas = array();

        $pdo = DB::conectar();
        $sql = "SELECT * FROM propostas $criterio";

        $result = $pdo->query($sql);

        if($result){
            while (  $obj = $result->fetch(PDO::FETCH_OBJ)  ) {
                $propostas[] = $obj;
            }
        }
        else {
            $err = $pdo->errorInfo();
            throw new Exception($err[2], $err[1]);
        }

        return $propostas;
    }

    /**
     *
     * @param type $proposta
     * @return type
     * @throws Exception
     */
    function retFiltroTabPropostas($proposta){

        $filtro        = "";
        $filtro_status = "";

        if( ! $proposta){
            throw new Exception(get_class($this).": Como filtrar sem a 'proposta filtro'?");
        }

        $proposta = json_decode($proposta);


        /*
         * Filtro sempre por renovação, mas caso filtrem por vencimento então trocamos o campo.
         * Este "if" significa que ou filtramos por renovação ou por vencimento.
         */
        if( $proposta->renovacao->inicio && $proposta->renovacao->termino ){
            # Como a informação já vem mastigada pelo JS não presisamos convertar a data para o Mysql
            $filtro .= "(renovacao BETWEEN '{$proposta->renovacao->inicio}' AND '{$proposta->renovacao->termino}') AND ";

        } else if( $proposta->vencimento->inicio && $proposta->vencimento->termino ) {
            $proposta->vencimento->inicio  = FuncAux::data_converte_para_mysql( $proposta->vencimento->inicio );
            $proposta->vencimento->termino = FuncAux::data_converte_para_mysql( $proposta->vencimento->termino );
            $filtro .= "(vencimento BETWEEN '{$proposta->vencimento->inicio}' AND '{$proposta->vencimento->termino}') AND ";
        }

        if($proposta->proposta) $filtro .= "proposta LIKE '%{$proposta->proposta}%' AND ";
        if($proposta->segurado) $filtro .= "segurado LIKE '%{$proposta->segurado}%' AND ";
        if($proposta->cia)      $filtro .= "cia LIKE '%{$proposta->cia}%' AND ";
        if($proposta->tipo)     $filtro .= "tipo LIKE '%{$proposta->tipo}%' AND ";
        if($proposta->detalhes) $filtro .= "detalhes LIKE '%{$proposta->detalhes}%' AND ";
        if($proposta->prem_liq) $filtro .= "prem_liq LIKE '%{$proposta->prem_liq}%' AND ";
        if($proposta->comissao) $filtro .= "segurado LIKE '%{$proposta->comissao}%' AND ";

        if($proposta->status->nao_checado) $filtro_status .= "status = 'n_check' OR ";
        if($proposta->status->falta_ass)   $filtro_status .= "status = 'falta_ass' OR ";
        if($proposta->status->ok)          $filtro_status .= "status = 'ok' OR ";


        # Se filtrou mas não filtrou por status...
        if($filtro && !$filtro_status){
            $filtro = substr($filtro, 0, strlen($filtro)-4);// remover último AND
        }

        # Se houve filtro por status
        if($filtro_status){
            $filtro_status = substr($filtro_status,  0, strlen($filtro_status)-3);// remover último OR

            // Atenção... concatenando.
            $filtro = "$filtro ($filtro_status)";
        }

        /*
         * Retorna filtro ou filtro por status se um deles existir
         */
        if($filtro || $filtro_status)
            return " WHERE " . $filtro;

    }

    /**
     *
     * @param type $ids String json, ex:  '["101","108","109"]'
     * @return type
     * @throws Exception
     */
    function retFiltroTabRenovacoes($ids){

        if( ! $ids){
            throw new Exception(get_class($this).": Como filtrar sem os ids?");
        }

        $ids = implode(", ", json_decode($ids) );
        return " WHERE id IN($ids)";

    }


    /**
     *
     * @return type
     */
    static function retComboStatus(){
        return array(
            "n_check"   => "Não checado",
            "falta_ass" => "Falta assinatura",
            "ok"        => "OK",
        );

    }

    /**
     *
     * @return type
     */
    static function retComboTipo(){
        return array(
            "auto"         => "auto",
            "residencial"  => "residencial",
            "empresarial"  => "empresarial",
            "vida"         => "vida",
            "saude"        => "saúde",
            "equipamentos" => "equipamentos"
        );
    }

    /**
     *
     * @return type
     */
    static function retComboCia(){
        return array(
            "allianz"    => "ALLIANZ",
            "azul"       => "Azul",
            "bradesco"   => "Bradesco",
            "hdi"        => "HDI",
            "itau"       => "Itaú",
            "maritima"   => "Marítima",
            "mafre"      => "Mafre",
            "porto"      => "Porto",
            "sulamerica" => "Sulamérica",
            "toqui"      => "Tóquio"
        );
    }

}
?>
