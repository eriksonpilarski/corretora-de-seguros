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
     * @param type $propostas
     * @throws Exception
     */
    function insert($propostas){
        if( ! $propostas){
            throw new Exception(get_class($this).": Impossível inserir/renovar sem as propostas?");
        }

        $sqls = array();

        $propostas = stripslashes($propostas);
        $propostas = json_decode($propostas);
        foreach($propostas as $proposta){
            $proposta->renovacao  = DatasFuncAux::data_converte_para_mysql( $proposta->renovacao );
            $proposta->vencimento = DatasFuncAux::data_converte_para_mysql( $proposta->vencimento );

            $s  = "";
            $s  = "INSERT INTO propostas VALUES ( ";
            $s .= "null, ".
                    "'{$proposta->renovacao}', ".
                    "'{$proposta->proposta}', ".
                    "'{$proposta->segurado}', ".
                    "'{$proposta->cia}', ".
                    "'{$proposta->tipo}', ".
                    "'{$proposta->detalhes}', ".
                    "'{$proposta->apolice}', ".
                    "'{$proposta->vencimento}', ".
                    $this->convMoedaToMysql($proposta->prem_liq).", ".
                    "'{$proposta->comissao}', ".
                    "'{$proposta->status}' )";
            $sqls[] = $s;
        }
//        var_dump($sqls);

        $pdo = DB::conectar();
        foreach($sqls as $sql){
            $result = $pdo->query($sql);
            if(!$result){
                $err = $pdo->errorInfo();
                throw new Exception($err[2], $err[1]);
            }
        }
    }


    /**
     *
     * @param type $propostas
     * @throws Exception
     */
    function update($propostas){
        if( ! $propostas){
            throw new Exception(get_class($this).": Impossível atualizar sem as propostas?");
        }


        $sqls = array();

        $propostas = stripslashes($propostas);
        $propostas = json_decode($propostas);
        foreach($propostas as $proposta){
            $proposta->renovacao  = DatasFuncAux::data_converte_para_mysql( $proposta->renovacao );
            $proposta->vencimento = DatasFuncAux::data_converte_para_mysql( $proposta->vencimento );

            $s  = "";
            $s  = "UPDATE propostas SET ";
            $s .= "id = {$proposta->id}, ".
                    "renovacao = '{$proposta->renovacao}', ".
                    "proposta = '{$proposta->proposta}', ".
                    "segurado = '{$proposta->segurado}', ".
                    "detalhes = '{$proposta->detalhes}', ".
                    "cia = '{$proposta->cia}', ".
                    "tipo = '{$proposta->tipo}', ".
                    "apolice = '{$proposta->apolice}', ".
                    "vencimento = '{$proposta->vencimento}', ".
                    "prem_liq = ".$this->convMoedaToMysql($proposta->prem_liq).", ".
                    "comissao = '{$proposta->comissao}', ".
                    "status = '{$proposta->status}'";
            $s .= "WHERE id = {$proposta->id}";
            $sqls[] = $s;
        }
//        var_dump($sqls);

        $pdo = DB::conectar();
        foreach($sqls as $sql){
            $result = $pdo->query($sql);
            if(!$result){
                $err = $pdo->errorInfo();
                throw new Exception($err[2], $err[1]);
            }
        }
    }

    /**
     *
     * @param type $id
     * @throws Exception
     */
    function delete($id){

        if( !$id ){
            throw new Exception(get_class($this).": Como deletar sem o ID ?");
        }

        $sql = "DELETE FROM propostas WHERE id = $id LIMIT 1";

//        var_dump($sql);
        $pdo = DB::conectar();
        $result = $pdo->query($sql);
        if(!$result){
            $err = $pdo->errorInfo();
            throw new Exception($err[2], $err[1]);
        }
    }

    /**
     *
     * @param type $prop_filtro
     * @return type
     */
    static function getObjects($criterio = null){

        $propostas = array();

        $pdo = DB::conectar();
        $sql = "SELECT * FROM propostas $criterio";
        //var_dump($sql);

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

        if( ! $proposta ){
            throw new Exception(get_class($this).": Como filtrar sem a 'proposta filtro'?");
        }

        $proposta = json_decode(  stripslashes($proposta)  );

        if($proposta->proposta) $filtro .= "proposta LIKE '%{$proposta->proposta}%' AND ";
        if($proposta->segurado) $filtro .= "segurado LIKE '%{$proposta->segurado}%' AND ";

        # Vigência
        if( $proposta->vig_inicio->dt1 && $proposta->vig_inicio->dt2 ){
            $proposta->vig_inicio->dt1 = DatasFuncAux::data_converte_para_mysql( $proposta->vig_inicio->dt1 );
            $proposta->vig_inicio->dt2 = DatasFuncAux::data_converte_para_mysql( $proposta->vig_inicio->dt2 );
            $filtro .= "vig_inicio BETWEEN '{$proposta->vig_inicio->dt1}' AND '{$proposta->vig_inicio->dt2}' AND ";

        } else if( $proposta->vig_termino->dt1 && $proposta->vig_termino->dt2 ) {
            $proposta->vig_termino->dt1 = DatasFuncAux::data_converte_para_mysql( $proposta->vig_termino->dt1 );
            $proposta->vig_termino->dt2 = DatasFuncAux::data_converte_para_mysql( $proposta->vig_termino->dt2 );
            $filtro .= "vig_termino BETWEEN '{$proposta->vig_termino->dt1}' AND '{$proposta->vig_termino->dt2}' AND ";
        }

        if($proposta->detalhes) $filtro .= "detalhes LIKE '%{$proposta->detalhes}%' AND ";
        if($proposta->cia)      $filtro .= "cia LIKE '%{$proposta->cia}%' AND ";
        if($proposta->tipo)     $filtro .= "tipo LIKE '%{$proposta->tipo}%' AND ";
        if($proposta->prem_liq) $filtro .= "prem_liq LIKE '%{$proposta->prem_liq}%' AND ";
        if($proposta->comissao) $filtro .= "segurado LIKE '%{$proposta->comissao}%' AND ";
        if($proposta->status)   $filtro .= "status = '{$proposta->status}' AND ";


        # Se filtrou mas não filtrou por status...
        if($filtro){
            $filtro = substr($filtro, 0, strlen($filtro)-4);// remover último AND
            return " WHERE " . $filtro;
        }

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

        $ids = stripslashes($ids);
        $ids = implode(", ", json_decode($ids) );
        return " WHERE id IN($ids)";

    }


    /**
     * Converte moeda para o formato do mysql
     *
     * entrada 12.000,00
     * saída   12000.00
     *
     * @param type $moeda
     * @return type
     */
    function convMoedaToMysql($moeda){
        $moeda = str_replace(".", "", $moeda); # tira os pontos
        $moeda = str_replace(",", ".", $moeda); # troca a única vírgua(decimal) por ponto

        return $moeda;
    }


    /**
     * Ret
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
            "mapfre"     => "Mapfre",
            "porto"      => "Porto",
            "sulamerica" => "Sulamérica",
            "tokio"      => "Tóko",
            "zurich"     => "Zurich"
        );
    }

}
?>
