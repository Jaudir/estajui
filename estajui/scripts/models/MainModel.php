<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/util/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/util/Loader.php";

class MainModel {

    protected $conn;
    protected $loader;

    //chamar quando o model é instanciado, return false em caso de falha
    public function init($DB, $loader) {
        try {
            $this->loader = $loader;

            $database = new Database();

            $database->setServername($DB['SERVER']);
            $database->setUsername($DB['USERNAME']);
            $database->setPassword($DB['PASSWORD']);
            $database->setDbname($DB['NAME']);

            $this->conn = $database->getConnection();

            //atributos
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }

    public function getLastError(){
        return $this->conn->errorInfo();
    }

    public function getLastId(){
        $stmt = $this->conn->query("SELECT LAST_INSERT_ID()");
        return $stmt->fetchColumn();
    }
}
