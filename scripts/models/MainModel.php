<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/util/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/util/Loader.php";

class MainModel {

    protected $conn;
    protected $loader;

    //chamar quando o model é instanciado, return false em caso de falha
    public function init($DB, Loader $loader) {
        try {
            $this->loader = $loader;
            $database = new Database();

            $database->setServername($DB['SERVER']);
            $database->setUsername($DB['USERNAME']);
            $database->setPassword($DB['PASSWORD']);
            $database->setDbname($DB['NAME']);

            $this->conn = $database->getConnection();
        } catch (PDOException $ex) {
//            return "Model não pode se conectar ao banco de dados: " . $ex->getMessage() . '<br>';
            return 1;
        }
        return 0;
    }

}
