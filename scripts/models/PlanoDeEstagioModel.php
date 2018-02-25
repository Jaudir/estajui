<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/PlanoDeEstagio.php";

class PlanoDeEstagioModel extends MainModel {

    private $_tabela = "plano_estagio";

    public function create(PlanoDeEstagio $pe) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (estagio_id, data_assinatura, atividades, remuneracao, vale_transporte, data_ini, data_fim, hora_inicio1, hora_inicio2, hora_fim1, hora_fim2, total_horas, data_efetivacao) VALUES(?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($pe->getestagio()->getid(), $pe->getdata_assinatura(), $pe->getatividades(), $pe->getremuneracao(), $pe->getvale_transporte(), $pe->getdata_inicio(), $pe->getdata_fim(), $pe->gethora_inicio1(), $pe->gethora_inicio2(), $pe->gethora_fim1(), $pe->gethora_fim2(), $pe->gettotal_horas(), $pe->getdata_efetivacao()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read(Estagio $estagio, $limite) {
        if ($limite == 0) {
            if ($estagio == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $key = $estagio->getid();
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id = :estagio_id");
                $pstmt->bindParam(':estagio_id', $key);
            }
        } else {
            if ($estagio == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $key = $estagio->getid();
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id = :estagio_id LIMIT :limite");
                $pstmt->bindParam(':estagio_id', $key);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $this->conn->beginTransaction();
            $pstmt->execute();
            $this->conn->commit();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $comentariopeModel = $this->loader->loadModel("ComentarioPEModel", "ComentarioPEModel");
                $result[$cont] = new PlanoDeEstagio($estagio, $row["data_assinatura"], $row["atividades"], $row["remuneracao"], $row["vale_transporte"], $row["data_ini"], $row["data_fim"], $row["hora_inicio1"], $row["hora_inicio2"], $row["hora_fim1"], $row["hora_fim2"], $row["total_horas"], $row["data_efetivacao"], $comentariopeModel->readbyestagio($estagio, 0));
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(PlanoDeEstagio $pe) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET data_assinatura = ? , atividades = ? , remuneracao = ? , vale_transporte = ? , data_ini = ? , data_fim = ? , hora_inicio1 = ? , hora_inicio2 = ? , hora_fim1 = ? , hora_fim2 = ? , total_horas = ? , data_efetivacao = ? WHERE estagio_id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($pe->getdata_assinatura(), $pe->getatividades(), $pe->getremuneracao(), $pe->getvale_transporte(), $pe->getdata_inicio(), $pe->getdata_fim(), $pe->gethora_inicio1(), $pe->gethora_inicio2(), $pe->gethora_fim1(), $pe->gethora_fim2(), $pe->gettotal_horas(), $pe->getdata_efetivacao(), $pe->getestagio()->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(PlanoDeEstagio $pe) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE estagio_id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($pe->getestagio()->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
