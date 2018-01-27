<?php

require_once './util/CrudInterface.php';
require_once './util/connect.php';

/**
 * Description of Campus
 *
 * @author gabriel Lucas
 */
class Campus implements CrudInterface {
    
    private $_cnpj;
    private $_telefone;
    private $_endereco;
    
    public function __construct($_cnpj, $_telefone, $_endereco) {
        $this->_cnpj = $_cnpj;
        $this->_telefone = $_telefone;
        $this->_endereco = $_endereco;
    }

    public function getcnpj() {
        return $this->_cnpj;
    }

    public function gettelefone() {
        return $this->_telefone;
    }

    public function getendereco() {
        return $this->_endereco;
    }

    public function setcnpj($_cnpj) {
        $this->_cnpj = $_cnpj;
        return $this;
    }

    public function settelefone($_telefone) {
        $this->_telefone = $_telefone;
        return $this;
    }

    public function setendereco($_endereco) {
        $this->_endereco = $_endereco;
        return $this;
    }

    public function create() {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("INSERT INTO campus (cnpj, telefone, endereco_id) VALUES(?, ?, ?)");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_cnpj, $this->_telefone, $this->_endereco));
                $conexao->commit();
                return "Usuario cadastrado com sucesso";
            } catch (PDOExecption $e) {
                $conexao->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return "Erro ao salvar no banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }

    public static function read($key, $limite) {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            if ($limite == 0) {
                if ($key == NULL) {
                    $pstmt = $conexao->prepare("SELECT * FROM campus");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM campus WHERE cnpj LIKE :cnpj");
                    $pstmt->bindParam(':cnpj', $key);
                }
            } else {
                if ($key == NULL) {
                    $pstmt = $conexao->prepare("SELECT * FROM campus LIMIT :limite");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM campus WHERE cnpj LIKE :cnpj LIMIT :limite");
                    $pstmt->bindParam(':cnpj', $key);
                }
                $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            }
            try {
                $pstmt->execute();
                $cont = 0;
                $result = [];
                while ($row = $pstmt->fetch()) {
                    $result[$cont] = new Endereco($row["cnpj"], $row["telefone"], Endereco::read($row["endereco_id"], 1)[0]);
                    $cont++;
                }
                return $result;
            } catch (PDOExecption $e) {
                #return "Error!: " . $e->getMessage() . "</br>";
                return "Erro ao consultar o banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }

    public function update() {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("UPDATE endereco SET cnpj=?, telefone=?, endereco_id=? WHERE cnpj = ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_cnpj, $this->_telefone, $this->_endereco->getid(), $this->_cnpj));
                $conexao->commit();
                return "Seus dados foram alterados com sucesso";
            } catch (PDOExecption $e) {
                $conexao->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return "Erro ao salvar no banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }

    public function delete() {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("DELETE from campus WHERE cnpj LIKE ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_cnpj));
                $conexao->commit();
                return "O campus " . $this->_cnpj . " foi excluido com sucesso";
            } catch (PDOExecption $e) {
                $conexao->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return "Erro ao deletar no banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }


}
