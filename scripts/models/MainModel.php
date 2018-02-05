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
        }catch(PDOException $ex){
            echo "Model não pode se conectar ao banco de dados: " . $ex->getMessage() . '<br>';
            print_r($DB);
            return false;
        }

        return true;
    }

    public function listarEstagiosEmpresa($cnpj){
        $st = $this->conn->prepare("select * from estagio where empresa_cnpj = $cnpj");
        if(!$st->execute()){
            return false;
        }
        return $st->fetchAll();
    }

    public function listarAlunosEstagio($aluno_cpf){
        $st = $this->conn->prepare("select * from aluno where cpf = $aluno_cpf");
        if(!$st->execute()){
            return false;
        }
        return $st->fetchAll();
    }
}