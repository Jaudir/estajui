<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/ModificacaoStatus.php";

class ModificacaoStatusModel extends MainModel {

    private $_tabela = "modifica_status";

    public function create(ModificacaoStatus $modificacao) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (data, estagio_id, status_codigo, usuario_email) VALUES(?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($modificacao->getdata(), $modificacao->getestagio()->getid(), $modificacao->getstatus()->getcodigo(), $modificacao->getusuario()->getlogin()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            $modificacao->setid($id);
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return FALSE;
        }
    }

    public function read($id, $limite) {
        if ($limite == 0) {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id LIKE :id");
                $pstmt->bindParam(':id', $id);
            }
        } else {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id LIKE :id LIMIT :limite");
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
                $statusModel = $this->loader->loadModel("StatusModel", "StatusModel");
                $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
                $result[$cont] = new ModificacaoStatus($row["id"], $row["data"], $estagioModel->read($row["estagio_id"], 1)[0], $statusModel->read($row["status_codigo"], 1)[0], $usuarioModel->read($row["usuario_email"], 1)[0]);
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
                $key = $estagio->getid();
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id LIKE :estagio_id");
                $pstmt->bindParam(':estagio_id', $key);
            }
        } else {
            if ($estagio == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $key = $estagio->getid();
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id LIKE :estagio_id LIMIT :limite");
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
                $statusModel = $this->loader->loadModel("StatusModel", "StatusModel");
                $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
                $result[$cont] = new ModificacaoStatus($row["id"], $row["data"], $estagio, $statusModel->read($row["status_codigo"], 1)[0], $usuarioModel->read($row["usuario_email"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbystatus(Status $status, $limite) {
        if ($limite == 0) {
            if ($status == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE status_codigo LIKE :status_codigo");
                $pstmt->bindParam(':status_codigo', $status->getcodigo());
            }
        } else {
            if ($status == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE status_codigo LIKE :status_codigo LIMIT :limite");
                $pstmt->bindParam(':status_codigo', $status->getcodigo());
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
                $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
                $result[$cont] = new ModificacaoStatus($row["id"], $row["data"], $estagioModel->read($row["estagio_id"], 1)[0], $status, $usuarioModel->read($row["usuario_email"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyusuario(Usuario $usuario, $limite) {
        if ($limite == 0) {
            if ($usuario == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email");
                $pstmt->bindParam(':usuario_email', $usuario->getlogin());
            }
        } else {
            if ($usuario == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email LIMIT :limite");
                $pstmt->bindParam(':usuario_email', $usuario->getlogin());
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
                $statusModel = $this->loader->loadModel("StatusModel", "StatusModel");
                $result[$cont] = new ModificacaoStatus($row["id"], $row["data"], $estagioModel->read($row["estagio_id"], 1)[0], $statusModel->read($row["status_codigo"], 1)[0], $usuario);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(ModificacaoStatus $modificacao) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET data=?, estagio_id=?, status_codigo=?, usario_email=? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($modificacao->getdata(), $modificacao->getestagio()->getid(), $modificacao->getstatus()->getcodigo(), $modificacao->getusuario()->getemail(), $modificacao->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(ModificacaoStatus $modificacao) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($modificacao->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
