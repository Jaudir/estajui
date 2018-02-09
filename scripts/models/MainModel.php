<?php

class MainModel{
    protected $conn;
    protected $loader;

    //chamar quando o model é instanciado, return false em caso de falha
    public function init($DB, $loader){
        try{
            $this->loader = $loader;
            
            $servername = $DB['SERVER'];
            $dbname = $DB['NAME'];
            $username = $DB['USERNAME'];
            $password = $DB['PASSWORD'];
            
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

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
}