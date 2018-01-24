<?php

require_once './util/CrudInterface.php';
require_once './util/connect.php';

/**
 * Description of Discente
 *
 * @author gabriel Lucas
 */
class Aluno extends Usuario implements CrudInterface
{
    private $_cpf;
    private $_nome;
    private $_datat_nasc;
    private $_rg_num;
    private $_rg_orgao;
    private $_estado_civil;
    private $_sexo;
    private $_telefone;
    private $_celular;
    private $_nome_pai;
    private $_nome_mae;
    private $_cidade_natal;
    private $_estado_natal;
    private $_acesso;
    private $_endereco;

    public function __construct($login, $senha, $tipo, $_cpf, $_nome, $_datat_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso, $_endereco)
    {
        parent::__construct($login, $senha, $tipo);
        $this->_cpf = $_cpf;
        $this->_nome = $_nome;
        $this->_datat_nasc = $_datat_nasc;
        $this->_rg_num = $_rg_num;
        $this->_rg_orgao = $_rg_orgao;
        $this->_estado_civil = $_estado_civil;
        $this->_sexo = $_sexo;
        $this->_telefone = $_telefone;
        $this->_celular = $_celular;
        $this->_nome_pai = $_nome_pai;
        $this->_nome_mae = $_nome_mae;
        $this->_cidade_natal = $_cidade_natal;
        $this->_estado_natal = $_estado_natal;
        $this->_acesso = $_acesso;
        $this->_endereco = $_endereco;
    }

    public function getcpf()
    {
        return $this->_cpf;
    }

    public function getnome()
    {
        return $this->_nome;
    }

    public function getdatat_nasc()
    {
        return $this->_datat_nasc;
    }

    public function getrg_num()
    {
        return $this->_rg_num;
    }

    public function getrg_orgao()
    {
        return $this->_rg_orgao;
    }

    public function getestado_civil()
    {
        return $this->_estado_civil;
    }

    public function getsexo()
    {
        return $this->_sexo;
    }

    public function gettelefone()
    {
        return $this->_telefone;
    }

    public function getcelular()
    {
        return $this->_celular;
    }

    public function getnome_pai()
    {
        return $this->_nome_pai;
    }

    public function getnome_mae()
    {
        return $this->_nome_mae;
    }

    public function getcidade_natal()
    {
        return $this->_cidade_natal;
    }

    public function getestado_natal()
    {
        return $this->_estado_natal;
    }

    public function getacesso()
    {
        return $this->_acesso;
    }

    public function getendereco()
    {
        return $this->_endereco;
    }

    public function setcpf($_cpf)
    {
        $this->_cpf = $_cpf;
        return $this;
    }

    public function setnome($_nome)
    {
        $this->_nome = $_nome;
        return $this;
    }

    public function setdatat_nasc($_datat_nasc)
    {
        $this->_datat_nasc = $_datat_nasc;
        return $this;
    }

    public function setrg_num($_rg_num)
    {
        $this->_rg_num = $_rg_num;
        return $this;
    }

    public function setrg_orgao($_rg_orgao)
    {
        $this->_rg_orgao = $_rg_orgao;
        return $this;
    }

    public function setestado_civil($_estado_civil)
    {
        $this->_estado_civil = $_estado_civil;
        return $this;
    }

    public function setsexo($_sexo)
    {
        $this->_sexo = $_sexo;
        return $this;
    }

    public function settelefone($_telefone)
    {
        $this->_telefone = $_telefone;
        return $this;
    }

    public function setcelular($_celular)
    {
        $this->_celular = $_celular;
        return $this;
    }

    public function setnome_pai($_nome_pai)
    {
        $this->_nome_pai = $_nome_pai;
        return $this;
    }

    public function setnome_mae($_nome_mae)
    {
        $this->_nome_mae = $_nome_mae;
        return $this;
    }

    public function setcidade_natal($_cidade_natal)
    {
        $this->_cidade_natal = $_cidade_natal;
        return $this;
    }

    public function setestado_natal($_estado_natal)
    {
        $this->_estado_natal = $_estado_natal;
        return $this;
    }

    public function setacesso($_acesso)
    {
        $this->_acesso = $_acesso;
        return $this;
    }

    public function setendereco($_endereco)
    {
        $this->_endereco = $_endereco;
        return $this;
    }

    public function create()
    {
        parent::create();
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("INSERT INTO aluno (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_siape, $this->_nome, (int)$this->_po, (int)$this->_oe, (int)$this->_ce, (int)$this->_sra, (int)$this->_root, $this->_formacao, (int)$this->_privilegio, parent::getlogin(), $this->_campus->getcnpj()));
                $conexao->commit();
                return "Funcionario cadastrado com sucesso";
            } catch (PDOExecption $e) {
                $conexao->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return "Erro ao salvar no banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }

    public static function read($key, $limite, Usuario $user)
    {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            if ($limite == 0) {
                if ($key == null) {
                    $pstmt = $conexao->prepare("SELECT * FROM funcionario");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM funcionario WHERE siape LIKE :siape");
                    $pstmt->bindParam(':siape', $key);
                }
            } else {
                if ($key == null) {
                    $pstmt = $conexao->prepare("SELECT * FROM funcionario LIMIT :limite");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM funcionario WHERE siape LIKE :siape LIMIT :limite");
                    $pstmt->bindParam(':siape', $key);
                }
                $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            }
            try {
                $pstmt->execute();
                $cont = 0;
                $result = [];
                while ($row = $pstmt->fetch()) {
                    $result[$cont] = new Funcionario($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["siape"], $row["nome"], boolval($row["bool_po"]), boolval($row["bool_oe"]), boolval($row["bool_ce"]), boolval($row["bool_sra"]), boolval($row["bool_root"]), $row["formacao"], boolval($row["privilegio"]), Campus::read($row["campus_cnpj"], 1));
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
            $pstmt = $conexao->prepare("UPDATE Funcionario SET siape=?, nome=?, bool_po=?, bool_oe=?, bool_ce=?, bool_sra=?, bool_root=?, formacao=?, privilegio=?, campus_cnpj=? where siape = ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_siape, $this->_nome, (int)$this->_po, (int)$this->_oe, (int)$this->_ce, (int)$this->_sra, (int)$this->_root, $this->_formacao, (int)$this->_privilegio, parent::getlogin(), $this->_campus->getcnpj(), $this->_siape));
                $conexao->commit();
                return parent::update();
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
            $pstmt = $conexao->prepare("DELETE from funcionario WHERE siape LIKE ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_siape));
                $conexao->commit();
                return parent::delete();
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
?>
