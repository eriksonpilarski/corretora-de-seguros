<?php



class Propostas {
    
    
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
