<?php

require_once('MainModel.php');

class EmailModel extends MainModel{
    public function emitirCodigoConfirmacao($usuario, $email){
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO verificar (email, codigo, verificado) VALUES(?,?, ?)");
            $pstmt->execute(array($usuario->getlogin(),$email->getcodigo(),0));// 0 == não verificado
            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }

<<<<<<< HEAD
    public function validarCodigoConfirmacao($code){

        try{
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo");
            $pstmt->bindParam(':codigo', $code);
            $pstmt->execute(); 
            if($pstmt->fetch() == null) return false;
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo AND verificado LIKE :verificado");
            $verificado = 1;
            $pstmt->bindParam(':codigo', $code);
            $pstmt->bindParam(':verificado',$verificado);
            $pstmt->execute();
            if($pstmt->fetch()!=null) return false;
       
        } catch (PDOExecption $e){
            return false;
        }

        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("UPDATE verificar SET verificado  = ? WHERE codigo = ? AND verificado = ?");
            $pstmt->execute(array(1,$code,0));// 0 == não verificado
             $this->conn->commit();
             return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }

    //busca o usuário associado ao código
    public function verificarUsuarioCodigo($code){
        try{
            $stmt = $this->conn->prepare('SELECT usuario.* FROM verificar JOIN usuario on verificar.email = usuario.email where codigo = :code');
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            $result = $stmt->fetchAll();

            if(count($stmt) > 0){
                $result = $result[0];
                return new Usuario($result['email'], $result['senha'], $result['tipo']);
            }
        }catch(PDOException $ex){
            Log::logPDOError($ex);
        }
        return false;
    }

    public function validarCodigoRecuperacao($code, $senha){
        $usuario;
        try{
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo");
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
=======
<<<<<<< HEAD:scripts/models/EmailModel.php
    public function validarCodigoConfirmacao($code, $email) {

        try {
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo ANd email LIKE :email");
            $pstmt->bindParam(':codigo', $code);
            $pstmt->bindParam(':email', $email);
            $pstmt->execute();
            if ($pstmt->fetch() == null)
                return false;
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo AND verificado LIKE :verificado ANd email LIKE :email");
            $verificado = 1;
            $pstmt->bindParam(':codigo', $code);
            $pstmt->bindParam(':verificado', $verificado);
=======
    public function validarCodigoConfirmacao($code,$email){

        try{
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo ANd email LIKE :email");
            $pstmt->bindParam(':codigo', $code);
            $pstmt->bindParam(':email', $email);
            $pstmt->execute(); 
            if($pstmt->fetch() == null) return false;
            $pstmt = $this->conn->prepare("SELECT id from verificar WHERE codigo LIKE :codigo AND verificado LIKE :verificado ANd email LIKE :email");
            $verificado = 1;
            $pstmt->bindParam(':codigo', $code);
            $pstmt->bindParam(':verificado',$verificado);
>>>>>>> master:scripts/models/email-model.php
            $pstmt->bindParam(':email', $email);
            $pstmt->execute();
            if ($pstmt->fetch() != null)
                return false;
        } catch (PDOExecption $e) {
>>>>>>> e1fa80302a1b25822d8e8bf927a39a841d4e581e
            return false;
        }

        try {
            $this->conn->beginTransaction();
<<<<<<< HEAD
            $pstmt = $this->conn->prepare("UPDATE verificar SET verificado  = ? WHERE codigo = ? AND verificado = ?");
            $pstmt->execute(array(1,$code,0));// 0 == não verificado
            $pstmt = $this->conn->prepare("UPDATE usuario SET senha = ? WHERE email = ?");
            $pstmt->execute(array($senha, $usuario['email']));
            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            Log::LogPDOError($e);
=======
            $pstmt = $this->conn->prepare("UPDATE verificar SET verificado  = ? WHERE codigo = ? AND verificado = ? AND email = ?");
<<<<<<< HEAD:scripts/models/EmailModel.php
            $pstmt->execute(array(1, $code, 0, $email)); // 0 == não verificado
            $this->conn->commit();
            return true;
=======
            $pstmt->execute(array(1,$code,0, $email));// 0 == não verificado
             $this->conn->commit();
             return true;
>>>>>>> master:scripts/models/email-model.php
        } catch (PDOExecption $e) {
>>>>>>> e1fa80302a1b25822d8e8bf927a39a841d4e581e
            $this->conn->rollback();
            return false;
        }
    }
<<<<<<< HEAD
=======

>>>>>>> e1fa80302a1b25822d8e8bf927a39a841d4e581e
}