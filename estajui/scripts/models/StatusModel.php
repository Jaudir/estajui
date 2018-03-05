<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Status.php";

class StatusModel extends MainModel {

    private $_tabela = "status";
    public static $PARECER_SEC = 1;
    public static $ESTAGIO_DEF = 2;
    public static $AGURDANDO_DEF = 3;
    public static $PROFESSOR_DEF = 4;
    public static $AGURDADNDO_EST = 5;
    public static $INICIO_ESTAGIO = 6;
    public static $AGURDANDO_REL = 7;
    public static $RELATORIO_APR = 8;
    public static $RELATORIO_SEC = 9;
    public static $ESTAGIO_CON = 12;
    public static $CONVENIO_APR = 11;
    public static $CONVENIO_RPR = 13;
    public static $REENTREG_DOC = 10;
    public static $ESTAGIO_RPR = 14;

    public function adicionaNotificacao($statusId, $estagio, $usuario, $justificativa = null) {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare(
                    'INSERT INTO 
                modifica_status(data, estagio_id, status_codigo, usuario_email) 
                VALUES(NOW(), :estagio_id, :status_codigo, :usuario_email)');
            $stmt->execute(array(':estagio_id' => $estagio->getid(), ':status_codigo' => $statusId, ':usuario_email' => $usuario->getlogin()));

            $id = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare('INSERT INTO notificacao(lida, modifica_status_id, temJustificativa, justificativa) VALUES(:lida, :modifica_status_id, :temJustificativa, :justificativa)');
            $stmt->execute(
                    array(
                        ':lida' => 0,
                        ':modifica_status_id' => $id,
                        ':temJustificativa' => (int) ($justificativa != null),
                        ':justificativa' => $justificativa));

            $this->conn->commit();
        } catch (PDOException $ex) {
            Log::LogPDOError($ex);
            return false;
        }
    }

    public function create(Status $status) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (descricao, bitmap_usuarios_alvo, texto) VALUES(?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($status->getdescricao(), $status->get_usuarios_alvo(), $status->gettexto()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            $status->setcodigo($id);
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($codigo, $limite) {
        if ($limite == 0) {
            if ($codigo == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE codigo LIKE :codigo");
                $pstmt->bindParam(':codigo', $codigo);
            }
        } else {
            if ($codigo == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE codigo LIKE :codigo LIMIT :limite");
                $pstmt->bindParam(':codigo', $codigo);
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
                $result[$cont] = new Status($row["codigo"], $row["descricao"], $row["bitmap_usuarios_alvos"]);
                $result[$cont]->settexto($row["texto"]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Status $status) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET descricao=?, bitmap_usuarios_alvo=?, texto=? WHERE codigo = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($status->getdescricao(), $status->get_usuarios_alvo(), $status->gettexto(), $status->getcodigo()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Status $status) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE codigo = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($status->getcodigo()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
