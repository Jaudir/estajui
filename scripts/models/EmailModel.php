<?php
require_once('MainModel.php');

class EmailModel extends MainModel{
    public static $CODIGO_CONFIRMACAO = 0;
    public static $CODIGO_RECUPERACAO = 1;

    public function emitirCodigoConfirmacao($usuario, $email){
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO verificar (email, codigo, verificado, data_geracao, tipo) VALUES(?, ?, ?, now(), ?)");
            $pstmt->execute(array($usuario->getlogin(), $email->getcodigo(), 0, self::$CODIGO_CONFIRMACAO));// 0 == não verificado
            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }

    /* Retorna a linha da tabela associado ao código*/
    public function buscarCodigo($codigo, $tipo){
        try{
            $this->loader->loadDAO('Verifica');

            $stmt = $this->conn->prepare("SELECT * FROM verificar WHERE codigo = :codigo AND tipo = :tipo");
            $stmt->execute(array(':codigo' => $codigo, ':tipo' => $tipo));
            $codigos = $stmt->fetchAll();

            if(count($codigos) == 0){
                return false;
            }

            $codigos = $codigos[0];
            return new Verifica($codigos[]);
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }

    /* Insere um novo código de verificação de email */
    public function salvarCodigoVerificacao($usuario, $email){
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO verificar (email, codigo, verificado, data_geracao, tipo) VALUES(?, ?, ?, now(), ?)");
            $pstmt->execute(array($usuario->getlogin(), $email->getcodigo(), 0, self::$CODIGO_VERIFICACAO));// 0 == não verificado
            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }

    /* Atualiza o código de verificação associado ao usuário */
    public function atualizarCodigoVerificacao($usuario, $email){
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("UPDATE TABLE verificar SET codigo = :novo_codigo where email = :email AND tipo = :tipo");
            $pstmt->execute(array(':novo_codigo' => $email->getcodigo(), ':email' => $usuario->getlogin(), ':tipo' => self::$CODIGO_VERIFICACAO));
            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }
/*
    public function atualizarCodigoVerificacao($usuario, $email){
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO verificar (email, codigo, verificado, data_geracao) VALUES(?, ?, ?, now())");
            $pstmt->execute(array($usuario->getlogin(), $email->getcodigo(),0));// 0 == não verificado
            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }
*/

    /* Valida o código de confirmação de email */
    public function validarCodigoConfirmacao($code, $email) {
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("UPDATE verificar SET verificado  = ? WHERE codigo = ? AND verificado = ? AND email = ?");
            $pstmt->execute(array(1, $code, 0, $email)); // 0 == não verificado

            $pstmt = $this->conn->prepare("UPDATE usuario SET verificado  = ? WHERE codigo = ? AND verificado = ? AND email = ?");
            

            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }

    /* Verifica se o código ainda é válido, o código é válido se:
        1 - existe no banco
        2 - não foi verificado
        3 - a data de validade não foi expirada
    */
    public function verificarValidadeCodigo($code, $tipo){
        try{
            $stmt = $this->conn->prepare('SELECT * FROM verificar WHERE codigo = :code AND tipo = :tipo AND verificado = :verificado AND DATE_ADD(data_geracao, INTERVAL 1 DAY) < DATE(NOW(), "%Y-%m-%d")');
            $stmt->execute(array(':code' => $code, ':tipo' => $tipo, ':verificado' => 0));
            $result = $stmt->fetchAll();
            return count($result) > 0;
        }catch(PDOException $ex){
            Log::logPDOError($ex);
        }
        return false;
    }

    /*Valida o código de recuperação de senha, caso seja válido(não está expirado e já não foi validado)*/
    public function validarCodigoRecuperacao($code, $senha){
        $usuario;
        try{
            //busca o código que ainda não foi expirado
            $pstmt = $this->conn->prepare('SELECT id from verificar WHERE codigo LIKE :codigo AND  DATE_ADD(data_geracao, INTERVAL 1 DAY) < DATE(NOW(), "%Y-%m-%d")');
            $pstmt->bindParam(':codigo', $code);
            $pstmt->execute();
            if(count($pstmt->fetchAll()) == 0) return false;
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo AND verificado LIKE :verificado");
            $verificado = 1;
            $pstmt->bindParam(':codigo', $code);
            $pstmt->bindParam(':verificado',$verificado);
            $pstmt->execute();
            if(count($pstmt->fetchAll())!=0) return false;
            $pstmt = $this->conn->prepare("SELECT usuario.* FROM verificar INNER JOIN usuario ON usuario.email = verificar.email WHERE verificar.codigo = :codigo");
            $pstmt->bindParam(':codigo', $code);
            $pstmt->execute();
            $usuario = $pstmt->fetchAll();
            //código registrado sem usuário??
            if(count($usuario) == 0){
                Log::LogError('O usuário com o código associado não existe!');
                return false;
            }
            $usuario = $usuario[0];
        } catch (PDOExecption $e){
            Log::LogPDOError($e);
            return false;
        }
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("UPDATE verificar SET verificado  = ? WHERE codigo = ? AND verificado = ?");
            $pstmt->execute(array(1,$code,0));// 0 == não verificado
            $pstmt = $this->conn->prepare("UPDATE usuario SET senha = ? WHERE email = ?");
            $pstmt->execute(array($senha, $usuario['email']));
            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            Log::LogPDOError($e);
            $this->conn->rollback();
            return false;
        }
    }
}
