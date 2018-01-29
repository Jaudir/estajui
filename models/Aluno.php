<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/util/CrudInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/util/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/models/Usuario.php';

#require_once './util/CrudInterface.php';
#require_once './util/connect.php';

/**
 * Description of Discente
 *
 * @author gabriel Lucas
 */
class Aluno extends Usuario implements CrudInterface
{
    private $_id;
    private $_cpf;
    private $_nome;
    private $_data_nasc;
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
            
    public function __construct($login, $senha, $tipo, $_cpf, $_nome, $_data_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso, $_endereco) {
        parent::__construct($login, $senha, $tipo);
        $this->_cpf = $_cpf;
        $this->_nome = $_nome;
        $this->_data_nasc = $_data_nasc;
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

    public static function fromDataBase($login, $senha, $tipo, $_cpf, $_nome, $_datat_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso, $_endereco)
    {
        $instance = new self($login, $senha, $tipo);
        $instance->setcpf($_cpf);
        $instance->setnome ( $setnome);
        $instance->setdatat_nasc ( $_datat_nasc);
        $instance->setrg_num ( $_rg_num);
        $instance->setrg_orgao ( $_rg_orgao);
        $instance->setestado_civil ( $_estado_civil);
        $instance->setsexo($_sexo);
        $instance->settelefone($_telefone);
        $instance->setcelular($_celular);
        $instance->setnome_pai($_nome_pai);
        $instance->setnome_mae($_nome_mae);
        $instance->setcidade_natal($_cidade_natal);
        $instance->setestado_natal($_estado_natal);
        $instance->setacesso($_acesso);
        $instance->setendereco($_endereco);
        return $instance;
    }


    //Gambiarra para fazer um construtor  de acordo com a necessidade
    public static function fromController($login, $senha, $tipo, $_cpf, $_nome, $_datat_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal)
    {
        $instance = new self($login, $senha, $tipo);
        $instance->setcpf($_cpf);
        $instance->setnome ( $setnome);
        $instance->setdatat_nasc ( $_datat_nasc);
        $instance->setrg_num ( $_rg_num);
        $instance->setrg_orgao ( $_rg_orgao);
        $instance->setestado_civil ( $_estado_civil);
        $instance->setsexo($_sexo);
        $instance->settelefone($_telefone);
        $instance->setcelular($_celular);
        $instance->setnome_pai($_nome_pai);
        $instance->setnome_mae($_nome_mae);
        $instance->setcidade_natal($_cidade_natal);
        $instance->setestado_natal($_estado_natal);
        $instance->setendereco($_endereco);
        return $instance;

    }

    public function getcpf()
    {
        return $this->_cpf;
    }

    public function getnome()
    {
        return $this->_nome;
    }

    public function getdatat_nasc() {
        return $this->_data_nasc;
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

    public function getusuario_email(){
      return $this->usuario_email;
    }
    public function setusuario_email($_usuario_email){

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

    public function setdata_nasc($_data_nasc) {
        $this->_data_nasc = $_data_nasc;
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
            $pstmt = $conexao->prepare("INSERT INTO aluno (cpf, nome, data_nasc, rg_num, rg_orgao, estado_civil, sexo, telefone, celular, nome_pai, nome_mae, cidade_natal, estado_natal, acesso, usuario_email, endereco_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array( $this->$_cpf, $this->$_nome, $this->$_data_nasc, $this->$_rg_num, $this->$_rg_orgao, $this->$_estado_civil, $this->$_sexo, $this->$_telefone, $this->$_celular, $this->$_nome_pai, $this->$_nome_mae, $this->$_cidade_natal, $this->$_estado_natal, $this->$_acesso, parent::getlogin(), $this->_endereco->getid()) );
                $conexao->commit();
                return "Aluno cadastrado com sucesso";
            } catch (PDOExecption $e) {
                $conexao->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return "Erro ao salvar no banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }
/**
    public static function read($key, $limite, Usuario $user)
    {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            if ($limite == 0) {
                if ($key == NULL) {
                    $pstmt = $conexao->prepare("SELECT * FROM aluno");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM aluno WHERE cpf LIKE :cpf");
                    $pstmt->bindParam(':cpf', $key);
                }
            } else {
                if ($key == NULL) {
                    $pstmt = $conexao->prepare("SELECT * FROM aluno LIMIT :limite");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM aluno WHERE cpf LIKE :cpf LIMIT :limite");
                    $pstmt->bindParam(':cpf', $key);
                }
                $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            }
            try {
                $pstmt->execute();
                $cont = 0;
                $result = [];
                while ($row = $pstmt->fetch()) {
                    $result[$cont] = new Aluno($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["cpf"], $row["nome"],  $row["data_nasc"],  $row["rg_num"],  $row["rg_orgao"],  $row["estado_civil"],  $row["sexo"],  $row["telefone"],  $row["celular"],  $row["nome_pai"],  $row["nome_mae"],  $row["cidade_natal"],  $row["estado_natal"], boolval($row["acesso"]), Endereco::read( $row["endereco_id"]));
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
            $pstmt = $conexao->prepare("UPDATE Aluno SET nome=?, rg_orgao=?, estado_civil=?, sexo=?, telefone=?, celular=?, nome_pai=?, nome_mae=?, cidade_natal=?, estado_natal=?, acesso=?, endereco_id=? where cpf = ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->$_nome, $this->$_rg_orgao, $this->$_estado_civil, $this->$_sexo, $this->$_telefone, $this->$_celular, $this->$_nome_pai, $this->$_nome_mae,$this->$_cidade_natal, $this->$_estado_natal,  $this->$_acesso, $this->$_endereco->getid()));
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

    public function delete() { #necessario deletar o usuario tbm?
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt_endereco = $conexao->prepare("DELETE from endereco WHERE id LIKE ?");
            $pstmt_aluno = $conexao->prepare("DELETE from aluno WHERE cpf LIKE ?");
            try {
                $conexao->beginTransaction();
                $pstmt_endereco->execute(array($this->_endereco->getid()));
                $pstmt_aluno->execute(array($this->_cpf));
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
