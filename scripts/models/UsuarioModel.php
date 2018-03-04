<?php
require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Usuario.php";

class UsuarioModel extends MainModel {
    private $_tabela = "usuario";
    public function create(Usuario $user) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (email, senha, tipo) VALUES(?,?, ?)");
        try {
            $this->conn->beginTransaction();
            $this->conn->execute(array($user->getlogin(), $user->getsenha(), $user->gettipo()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }
    
    public function read($email, $limite) {
        if ($limite == 0) {
            if ($email == null) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE email LIKE :email");
				$emailAux = "%".$email."%";
                $pstmt->bindParam(':email', $emailAux);
            }
        } else {
            if ($email == null) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE email LIKE :email LIMIT :limite");
				$emailAux = "%".$email."%";
                $pstmt->bindParam(':email',  $emailAux);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            //$result = [];
			$result = array();
            while ($row = $pstmt->fetch()) {
				$u = new Usuario($row["email"], $row["senha"], $row["tipo"]);
				array_push($result, $u);
                //$result[$cont] = new Usuario($row["email"], $row["senha"], $row["tipo"]);
				
                $cont++;
            }
			
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return false;
        }
    }
	
	public function updateSenha(Usuario $user) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET senha=? where email = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($user->getsenha(), $user->getlogin()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }
	
    public function update(Usuario $user) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET email=?, senha=?, tipo=? where email = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($user->getlogin(), $user->getsenha(), $user->gettipo(), $user->getlogin()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }
    
    public function delete(Usuario $user) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->_tabela . " WHERE email LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($user->getlogin()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }
    
    /**
     * Validador de login
     *
     * Compara os valores passados com o usuário, e se forem iguais (válidos) o usuário pode logar no sistema.
     *
     * @param string $login O login (e-mail) digitado
     * @param string $senha A senha digitada (não o hash)
     *
     * @return Usuario||false Login válido (Usuario), ou não (false)
     * @access public
     */
    public function validate($login, $senha) {
        /* @var $alunoModel type */
        $alunoModel = $this->loader->loadModel("AlunoModel", "AlunoModel");
        $funcionarioModel = $this->loader->loadModel("FuncionarioModel","FuncionarioModel");
        if ($alunoModel != NULL && $funcionarioModel != NULL) {
            $user = $this->read($login, 1);
            if (is_array($user)) {
                if (count($user) > 0) {
                    if ($login == $user[0]->getlogin() && password_verify($senha, $user[0]->getsenha())) {
                        if ($user[0]->gettipo() == 1) {
                            return $alunoModel->readbyusuario($user[0], 1)[0];
                        } elseif ($user[0]->gettipo() == 2) {
                            var_dump($funcionarioModel->readbyusuario($user[0], 1));
                            return $funcionarioModel->readbyusuario($user[0], 1)[0];
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            return false;
        } else {
            return false;
        }
    }
    
    public function VerificaLoginCadastrado($email) {
        try {
            $pstmt = $this->conn->prepare("SELECT id from " . $this->_tabela . " WHERE email LIKE :email");
            $pstmt = $this->conn->prepare("SELECT email from " . $this->_tabela . " WHERE email LIKE :email");
            $pstmt->bindParam(':email', $email);
            $pstmt->execute();
            if ($pstmt->fetch() == null) {
                return false;
            }
            return true;
        } catch (PDOExecption $e) {
            return false;
        }
    }
}
