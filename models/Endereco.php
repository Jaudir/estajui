<?php

require_once '/opt/lampp/htdocs/estajui/util/CrudInterface.php';
require_once '/opt/lampp/htdocs/estajui/util/connect.php';

/**
 * Description of Endereco
 *
 * @author gabriel Lucas
 */
class Endereco implements CrudInterface
{
    private $_id;
    private $_logradouro;
    private $_bairro;
    private $_numero;
    private $_complemento;
    private $_cidade;
    private $_uf;
    private $_cep;

    public function __construct($_logradouro, $_bairro, $_numero, $_complemento, $_cidade, $_uf, $_cep)
    {
        $this->_logradouro = $_logradouro;
        $this->_bairro = $_bairro;
        $this->_numero = $_numero;
        $this->_complemento = $_complemento;
        $this->_cidade = $_cidade;
        $this->_uf = $_uf;
        $this->_cep = $_cep;
    }



    public function getid()
    {
        return $this->_id;
    }

    public function getlogradouro()
    {
        return $this->_logradouro;
    }

    public function getbairro()
    {
        return $this->_bairro;
    }

    public function getnumero()
    {
        return $this->_numero;
    }

    public function getcomplemento()
    {
        return $this->_complemento;
    }

    public function getcidade()
    {
        return $this->_cidade;
    }

    public function getuf()
    {
        return $this->_uf;
    }

    public function getcep()
    {
        return $this->_cep;
    }

    public function setid($_id)
    {
        $this->_id = $_id;
        return $this;
    }


    public function setlogradouro($_logradouro)
    {
        $this->_logradouro = $_logradouro;
        return $this;
    }

    public function setbairro($_bairro)
    {
        $this->_bairro = $_bairro;
        return $this;
    }

    public function setnumero($_numero)
    {
        $this->_numero = $_numero;
        return $this;
    }

    public function setcomplemento($_complemento)
    {
        $this->_complemento = $_complemento;
        return $this;
    }

    public function setcidade($_cidade)
    {
        $this->_cidade = $_cidade;
        return $this;
    }

    public function setuf($_uf)
    {
        $this->_uf = $_uf;
        return $this;
    }

    public function setcep($_cep)
    {
        $this->_cep = $_cep;
        return $this;
    }

    public function create()
    {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_logradouro, $this->_bairro, $this->_numero, $this->_complemento, $this->_cidade, $this->_uf, $this->_cep));
                $conexao->commit();
                $this->_id = $conexao->lastInsertId();
                return true;//"Usuario cadastrado com sucesso";
            } catch (PDOExecption $e) {
                $conexao->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return false;"Erro ao salvar no banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }

    public function createOnTransaction($conexao)
    {
        $pstmt = $conexao->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $pstmt->execute(array($this->_logradouro, $this->_bairro, $this->_numero, $this->_complemento, $this->_cidade, $this->_uf, $this->_cep));
        $this->_id = $conexao->lastInsertId();
    }

    public static function read($key, $limite)
    {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            if ($limite == 0) {
                if ($key == null) {
                    $pstmt = $conexao->prepare("SELECT * FROM endereco");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM endereco WHERE id LIKE :id");
                    $pstmt->bindParam(':id', $key);
                }
            } else {
                if ($key == null) {
                    $pstmt = $conexao->prepare("SELECT * FROM endereco LIMIT :limite");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM endereco WHERE id LIKE :id LIMIT :limite");
                    $pstmt->bindParam(':id', $key);
                }
                $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            }
            try {
                $pstmt->execute();
                $cont = 0;
                $result = [];
                while ($row = $pstmt->fetch()) {
                    $result[$cont] = new Endereco($row["id"], $row["logradouro"], $row["bairro"], $row["numero"], $row["complemento"], $row["cidade"], $row["uf"], $row["cep"]);
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

    public function update()
    {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("UPDATE endereco SET logradouro=?, bairro=?, numero=?, complemento=?, cidade=?, uf=?, cep=? WHERE id = ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_logradouro, $this->_bairro, $this->_numero, $this->_complemento, $this->_cidade, $this->_uf, $this->_cep, $this->_id));
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

    public function delete()
    {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("DELETE from endereco WHERE id LIKE ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_id));
                $conexao->commit();
                return "O endereço " . $this->_id . " foi excluido com sucesso";
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
