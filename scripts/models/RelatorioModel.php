<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Relatorio.php";

class RelatorioModel extends MainModel {

    private $_tabela = "relatorio";

    public function create(Relatorio $relatorio) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (endereco, data_envio, estagio_id) VALUES(?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($relatorio->getarquivo(), $relatorio->getdata_envio(), $relatorio->getestagio()->getid()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            return $id;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($id, $limite) {
        if ($limite == 0) {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id");
                $pstmt->bindParam(':id', $id);
            }
        } else {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id LIMIT :limite");
                $pstmt->bindParam(':id', $id);
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
                $estagioModel = $this->loader->loadModel("EstagioModel", "EstagioModel");
                $comentariorelatorioModel = $this->loader->loadModel("ComentarioRelatorioModel", "ComentarioRelatorioModel");
                $result[$cont] = new Relatorio($row["endereco"], $row["data_envio"], $estagioModel->read($row["estagio_id"], 1)[0], null);
                $result[$cont]->setcomentarios($comentariorelatorioModel->read($this, 0));
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyestagio(Estagio $estagio, $limite) {
        if ($limite == 0) {
            if ($estagio == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id = :estagio_id");
                $pstmt->bindParam(':estagio_id', $estagio->getid());
            }
        } else {
            if ($estagio == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id = :estagio_id LIMIT :limite");
                $pstmt->bindParam(':estagio_id', $estagio->getid());
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
                $comentariorelatorioModel = $this->loader->loadModel("ComentarioRelatorioModel", "ComentarioRelatorioModel");
                $result[$cont] = new Relatorio($row["id"], $row["endereco"], $row["data_envio"], $estagio, null);
                $result[$cont]->setcomentarios($comentariorelatorioModel->read($this, 0));
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Relatorio $relatorio) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET endereco=?, data_envio=?, estagio_id=w WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($relatorio->getarquivo(), $relatorio->getdata_envio(), $relatorio->getestagio()->getid(), $relatorio->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Relatorio $relatorio) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($relatorio->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
