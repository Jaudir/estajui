<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class OrientaEstagio extends MainModel {

    public function defineOrientador($estagio, $professorSiape, $usuario, $alterando) {
        try {
            $status = $this->loader->loadModel('StatusModel', 'StatusModel');
            $this->conn->beginTransaction();

            if ($alterando == false) {
                $stmt = $this->conn->prepare('insert into orienta_estagio(estagio_id, po_siape) values(:estagio, :po)');
            } else {
                $stmt = $this->conn->prepare('update orienta_estagio set po_siape = :po where estagio_id = :estagio');
            }
            $stmt->execute(array(':estagio' => $estagio->getid(), ':po' => $professorSiape));

            $stmt = $this->conn->prepare('update estagio set po_siape = :po, status_codigo=4 where id = :estagio');
            $stmt->execute(array(':estagio' => $estagio->getid(), ':po' => $professorSiape));

            $status->adicionaNotificacao(StatusModel::$PROFESSOR_DEF, $estagio, $usuario);

            $this->conn->commit();
        } catch (PDOException $ex) {
            Log::LogPDOError($ex);
            $this->conn->rollback();
            return false;
        }
        return true;
    }

}
