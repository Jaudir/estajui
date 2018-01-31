<?php

/**
 * Conexão e relações gerais com o BD
 *
 * @author gabriel Lucas
 */
class Conexao
{

    /**
     * Gerador de coneção
     *
     * Cria uma coneção PDO com o BD.
     *
     * @return PDO|string Objeto de coneção com o BD
     * @access public
     */
    public static function getConnection()
    {
        $servername = "localhost";
        $username = "projeto_estajui";
        $password = "est*826491735";
        $db = "estajui";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    public static function multiplesInsertions($array)
    {
        $conexao = self::getConnection();
        if ($conexao) {
            try {
                $conexao->beginTransaction();
                foreach ($array as $tabela) {
                    $tabela->createOnTransaction($conexao);
                }
                $conexao->commit();
                return 0;
            } catch (PDOExecption $e) {

                $conexao->rollback();
              return 1;

            }
        } else {
            return 2;// sem conexão com o banco de dados;
        }
    }
}
