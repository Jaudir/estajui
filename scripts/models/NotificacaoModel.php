<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Notificacao.php";

class NotificacaoModel extends MainModel {

    private $_tabela = "notificacao";

    public function create(Notificacao $notificacao) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (lida, temJustificativa, justificativa, modifica_status_id) VALUES(?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array((int) $notificacao->getlida(), (int) boolval($notificacao->getjustificativa()), $notificacao->getjustificativa(), $notificacao->getmodificacao_status()->getid()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            $notificacao->setid($id);
            return 0;
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
                $modificastatusModel = $this->loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                $result[$cont] = new Notificacao($row["id"], $row["lida"], $modificastatusModel->read($row["modifica_status_id"], 1)[0], $row["justificativa"]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
#return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function getNotificacoes(Usuario $usuario) {
        $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute();
            $this->conn->commit();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $modificastatusModel = $this->loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                $modificacao = $modificastatusModel->read($row["modifica_status_id"], 1)[0];
                if ($modificacao->getestagio()->getaluno()->getlogin() == $usuario->getlogin()) {
                    $result[$cont] = new Notificacao($row["id"], $row["lida"], $modificacao, $row["justificativa"]);
                    $cont++;
                } elseif ($modificacao->getestagio()->getfuncionario()) {
                    if ($modificacao->getestagio()->getfuncionario()->getlogin() == $usuario->getlogin()) {
                        $result[$cont] = new Notificacao($row["id"], $row["lida"], $modificacao, $row["justificativa"]);
                        $cont++;
                    }
                } elseif (is_a($usuario, "Funcionario")) {
                    if ($usuario->isoe() && $modificacao->getestagio()->getstatus()->getcodigo() == 3) {
                        $result[$cont] = new Notificacao($row["id"], $row["lida"], $modificacao, $row["justificativa"]);
                        $cont++;
                    }elseif ($usuario->issra() && ($modificacao->getestagio()->getstatus()->getcodigo() == 1 || $modificacao->getestagio()->getstatus()->getcodigo() == 5 || $modificacao->getestagio()->getstatus()->getcodigo() == 9)) {
                        $result[$cont] = new Notificacao($row["id"], $row["lida"], $modificacao, $row["justificativa"]);
                        $cont++;
                    }
                }
            }
            return $result;
        } catch (PDOExecption $e) {
#return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Notificacao $notificacao) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET lida=?, temJustificativa=?, justificativa=?, modifica_status_id=? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($notificacao->getlida(), boolval($notificacao->getjustificativa()), $notificacao->getjustificativa(), $notificacao->getmodificacao_status()->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
#return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Notificacao $notificacao) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($notificacao->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
#return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
