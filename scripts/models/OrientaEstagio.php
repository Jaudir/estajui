<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class OrientaEstagio extends MainModel{
    public function defineOrientador($estagioId, $professorSiape, $usuario, $alterando){
        try{
            $status = $this->conn->loadModel('StatusModel', 'StatusModel');
            $this->conn->beginTransaction();
            
            if($alterando == false){
                $stmt = $this->conn->prepare('insert into orienta_estagio(estagio_id, po_siape) values(:estagio, :po)');
            }else{
                $stmt = $this->conn->prepare('alter table orienta_estagio set po_siape = :po where estagio_id = :estagio');
            }

            $stmt->execute(array(':estagio' => $esatgioId, ':po' => $professorSiape));

            $status->adicionaNotificacao(StatusModel::$PROFESSOR_DEF, $estagioId, $usuario);

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            $this->conn->rollback();
            return false;
        }
        return true;
    }
}