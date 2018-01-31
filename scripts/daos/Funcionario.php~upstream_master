<?php

require_once 'Usuario.php';
//require_once './util/connect.php';

/**
 * Representação de um usuário para o sistema.
 *
 * @author gabriel Lucas
 */
class Funcionario extends Usuario implements CrudInterface {

    private $_siape;
    private $_nome;
    private $_po;
    private $_oe;
    private $_ce;
    private $_sra;
    private $_root;
    private $_formacao;
    private $_privilegio;
    private $_campus;

    public function __construct($login, $senha, $tipo, $_siape, $_nome, $_po, $_oe, $_ce, $_sra, $_root, $_formacao, $_privilegio, $_campus) {
        parent::__construct($login, $senha, $tipo);
        $this->_siape = $_siape;
        $this->_nome = $_nome;
        $this->_po = $_po;
        $this->_oe = $_oe;
        $this->_ce = $_ce;
        $this->_sra = $_sra;
        $this->_root = $_root;
        $this->_formacao = $_formacao;
        $this->_privilegio = $_privilegio;
        $this->_campus = $_campus;
    }

    public function getsiape() {
        return $this->_siape;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function ispo() {
        return $this->_po;
    }

    public function isoe() {
        return $this->_oe;
    }

    public function isce() {
        return $this->_ce;
    }

    public function issra() {
        return $this->_sra;
    }

    public function isroot() {
        return $this->_root;
    }

    public function getformacao() {
        return $this->_formacao;
    }

    public function isprivilegio() {
        return $this->_privilegio;
    }

    public function getcampus() {
        return $this->_campus;
    }

    public function setsiape($_siape) {
        $this->_siape = $_siape;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function setpo($_po) {
        $this->_po = $_po;
        return $this;
    }

    public function setoe($_oe) {
        $this->_oe = $_oe;
        return $this;
    }

    public function setce($_ce) {
        $this->_ce = $_ce;
        return $this;
    }

    public function setsra($_sra) {
        $this->_sra = $_sra;
        return $this;
    }

    public function setroot($_root) {
        $this->_root = $_root;
        return $this;
    }

    public function setformacao($_formacao) {
        $this->_formacao = $_formacao;
        return $this;
    }

    public function setprivilegio($_privilegio) {
        $this->_privilegio = $_privilegio;
        return $this;
    }

    public function setcampus($_campus) {
        $this->_campus = $_campus;
        return $this;
    }

    public function create() {
        parent::create();
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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

    public static function read($key, $limite, Usuario $user) {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            if ($limite == 0) {
                if ($key == NULL) {
                    $pstmt = $conexao->prepare("SELECT * FROM funcionario");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM funcionario WHERE siape LIKE :siape");
                    $pstmt->bindParam(':siape', $key);
                }
            } else {
                if ($key == NULL) {
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

    public function update() {
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

    public function delete() {
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
