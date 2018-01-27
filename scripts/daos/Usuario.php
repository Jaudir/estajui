<?php

require_once './util/CrudInterface.php';
require_once './util/connect.php';

/**
 * Representação de um usuário para o sistema.
 *
 * @author gabriel Lucas
 */
class Usuario implements CrudInterface {

    /**
     * O e-mail do usuário para logar no sistema (chave primária).
     * 
     * Deve ser checado quanto a validade do BD ( máximo de 50 caracteres, caracteristica de email e caracteres inválidos) antes de entregue a classe.
     * 
     * @var string Utilizada para a verificação de login
     * @access private
     */
    private $_login;

    /**
     *  A senha (hash) do usuário para logar no sistema.
     * 
     * Deve ser checado quanto a validade do BD (256 caracteres e caracteres inválidos) antes de entregue a classe, além de utilizar o método
     * generateSenha() ao salvar pela primeira vez para gerar o hash seguro.
     * 
     * @var string Utilizada para a verificação de login
     * @access private
     */
    private $_senha;

    /**
     * Indicador de tipo de login
     * 
     * É gerenciada pelo sistema e indica se o usuário é um discente (1) ou funcionario (2)
     * 
     * @var int Utilizada para identificar o tipo de usuário
     * @access private
     */
    private $_tipo;

    /**
     * Construtor de Usuário
     * 
     * Inicia o objeto e define seus valores (login, senha e tipo)
     *
     * @return void Cconstrutor de classe, e por isso retorna void (nada)
     * @access public
     */
    public function __construct($login, $senha, $tipo) {
        $this->_login = $login;
        $this->_senha = $senha;
        $this->_tipo = $tipo;
    }

    /**
     * Getter de login
     * 
     * Devolve o e-mail do usuario
     * 
     * @return string E-mail do usuário
     * @access public
     */
    public function getlogin() {
        return $this->_login;
    }

    /**
     * Getter de senha
     * 
     * Devolve o hash da senha do usuario
     * 
     * @return string Senha do usuário
     * @access public
     */
    public function getsenha() {
        return $this->_senha;
    }

    /**
     * Getter de tipo
     * 
     * Devolve o tipo de login do usuario
     * 
     * @return int tipo do usuário
     * @access public
     */
    public function gettipo() {
        return $this->_tipo;
    }

    /**
     * Setter de login
     * 
     * Define o valor de login (e-mail) do usuário
     * 
     * @param string $login O valor a ser definido para login (e-mail)
     * 
     * @return string O novo valor de login (e-mail)
     * @access public
     */
    public function setlogin($login) {
        $this->_login = $login;
        return $this;
    }

    /**
     * Setter de senha
     * 
     * Define o valor de senha do usuário. Este valor deve ser o hash da senha digitada.
     * 
     * @param string $senha O valor a ser definido para senha
     * 
     * @return string O novo valor de senha
     * @access public
     * @see Usuario::$_senha          Variável da senha
     * @see Usuario::generateSenha()  Método gerador de hash
     */
    public function setsenha($senha) {
        $this->_senha = $senha;
        return $this;
    }

    /**
     * Setter de tipo
     * 
     * Define o tipo do usuário.
     * 
     * @param int $tipo O tipo a ser definido ao usuário
     * 
     * @return int O novo tipo
     * @access public
     * @see Usuario::$_tipo
     */
    public function settipo($tipo) {
        $this->_tipo = $tipo;
        return $this;
    }

    public function create() {
        $conexao = Conexao::getConnection();
        if ($conexao) {
            $pstmt = $conexao->prepare("INSERT INTO usuario (email, senha, tipo) VALUES(?,?, ?)");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_login, $this->_senha, $this->_tipo));
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
                    $pstmt = $conexao->prepare("SELECT * FROM usuario");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM usuario WHERE email LIKE :email");
                    $pstmt->bindParam(':email', $key);
                }
            } else {
                if ($key == NULL) {
                    $pstmt = $conexao->prepare("SELECT * FROM usuario LIMIT :limite");
                } else {
                    $pstmt = $conexao->prepare("SELECT * FROM usuario WHERE email LIKE :email LIMIT :limite");
                    $pstmt->bindParam(':email', $key);
                }
                $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            }
            try {
                $pstmt->execute();
                $cont = 0;
                $result = [];
                while ($row = $pstmt->fetch()) {
                    $result[$cont] = new Usuario($row["email"], $row["senha"], $row["tipo"]);
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
            $pstmt = $conexao->prepare("UPDATE usuario SET email=?, senha=?, tipo=? where email = ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_login, $this->_senha, $this->_tipo, $this->_login));
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
            $pstmt = $conexao->prepare("DELETE from usuario WHERE email LIKE ?");
            try {
                $conexao->beginTransaction();
                $pstmt->execute(array($this->_login));
                $conexao->commit();
                return "O usuário " . $this->_login . " foi excluido com sucesso";
            } catch (PDOExecption $e) {
                $conexao->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return "Erro ao deletar no banco de dados, tente novamente";
            }
        } else {
            return "Erro ao conectar com o banco de dados, tente novamente";
        }
    }

    /**
     * Gerador de hashes
     * 
     * A partir de um valor recebido cria um hash seguro.
     * 
     * @param string $senha O valor a ser convertido em hash
     * 
     * @return string Um hash correspondente ao valor passado ao método.
     * @access public
     * @see Usuario::$_senha          Variável da senha
     */
    public static function generateSenha($senha) {
        $options = [
            'cost' => 10,
        ];
        return password_hash($senha, PASSWORD_DEFAULT, $options);
    }

    /**
     * Validador de login
     * 
     * Compara os valores passados com o usuário, e se forem iguais (válidos) o usuário pode logar no sistema.
     * 
     * @param string $login O login (e-mail) digitado
     * @param string $senha A senha digitada (não o hash)
     * 
     * @return Usuario Login válido (Usuario), ou não (NULL)
     * @access public
     */
    public static function validate($login, $senha) {
        $user = Usuario::read($login, 1)[0];
        if ($login == $user->getlogin() && password_verify($senha, $user->getsenha())) {
            return $user;
        }
        return NULL;
    }

}
