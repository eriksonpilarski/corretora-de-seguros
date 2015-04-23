<?php
/**
 * @version 1.00
 *
 * @package oop
 * @subpackage Banco de Dados
 *
 */

/**
 * Classe responsável pela conexão com o banco de dados
 *
 * <code>
 * $mysqli = DB::conectar("conexaod_dom");
 * var_dump($mysqli); die();
 * unset($mysqli);
 * </code>
 *
 * @package oop
 * @subpackage Conexão
 *
 */
abstract class DB {

    private static $pdo;

    /**
     * Método que retorna a conexão com o SGDB
     * e caso ela não exista ele troca de base(main <-> cliente).
     *
     * Isso significa que se quiser um conexão basta chamar  DB::conectar("nome_da_base_de_dados")
     * E se quiser trocar de base basta chamar  DB::conectar("outra_base_de_dados")
     *
     * @param ConexaoConfig $db
     * @return type
     */
    static function conectar() {
        $local   = "localhost";
        $usuario = "root";
        $senha   = "1234";
        $base    = "devfuria_corretora";

        # if não há conexão...
        if (empty(self::$pdo)) {
            self::$pdo = new PDO("mysql:host=$local;dbname=$base", "$usuario", "$senha");
        }

        return self::$pdo;
    }

}# end class
?>