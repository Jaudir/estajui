<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class SupervisorModel extends MainModel{
    public function create($supervisor){
        try{
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare('INSERT INTO supervisor (nome, cargo, habilitacao, empresa_cnpj) VALUES(:nome, :cargo, :habilitacao, :empresa_cnpj)');
            $stmt->execute(
                array(
                    ':nome' => $supervisor->get_nome(),
                    ':cargo' => $supervisor->get_cargo(),
                    ':habilitacao' => $supervisor->get_habilitacao(),
                    ':empresa_cnpj' => $supervisor->get_empresa()->get_cnpj()));

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }

    public function read($supervisor){
        try{
            $stmt = $this->conn->prepare('SELECT * FROM supervisor WHERE id=:id');
            $stmt->bindParam(':id', $supervisor->get_id());
            $stmt->execute();

            $res = $stmt->fetchAll();

            return $res;
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }
}