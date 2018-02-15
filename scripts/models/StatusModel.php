<?php

require_once(dirname(__FILE__) . '/MainModel.php');

/* Trata as tabelas status, modifica_status e notificacao */
class StatusModel extends MainModel{
    public static $PARECER_SEC = 1;
    public static $ESTAGIO_DEF = 2;
    public static $AGURDANDO_DEF = 3;
    public static $PROFESSOR_DEF = 4;
    public static $AGURDADNDO_EST = 5;
    public static $INICIO_ESTAGIO = 6;
    public static $AGURDANDO_REL = 7;
    public static $RELATORIO_APR = 8;
    public static $RELATORIO_SEC = 9;
    public static $ESTAGIO_CON = 10;
    public static $CONVENIO_APR = 11;
    public static $CONVENIO_RPR = 12;

    public function adicionaNotificacao($statusId, $estagio, $usuario, $justificativa = null){
        try{
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare(
                'INSERT INTO 
                modifica_status(data, estagio_id, status_codigo, usuario_email) 
                VALUES(NOW(), :estagio_id, :status_codigo, :usuario_email)');
            $stmt->execute(array(':estagio_id' => $estagio->getid(), ':status_codigo' => $statusId, ':usuario_email' => $usuario->getlogin()));

            $stmt->execute();
            $id = $this->conn->lastInsertId();
            
            $stmt = $this->conn->prepare('INSERT INTO notificacao(lida, modifica_status_id, temJustificativa, justificativa) VALUES(:lida, :modifica_status_id, :temJustificativa, :justificativa)');
            $stmt->execute(
                array(
                    ':lida' => 0, 
                    ':modifica_status_id' => $id, 
                    ':temJustificativa' => $justificativa != null, 
                    ':justificativa' => $justificativa));

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }
}