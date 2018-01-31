<?php

require_once 'CrudInterface.php';

/**
 * Representação de um usuário para o sistema.
 *
 * @author gabriel Lucas
 */
class Usuario implements CrudInterface {

    /**
     * O e-mail do usuário para logar no sistema (chave primária).
<<<<<<< HEAD
     *
     * Deve ser checado quanto a validade do BD ( máximo de 50 caracteres, caracteristica de email e caracteres inválidos) antes de entregue a classe.
     *
     * @var string Utilizada para a verificação de login
     * @access private
     */
    private $_login;
    private $_login_confirmacao;
    private $_senha_confirmacao;
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
=======
     * 
     * Deve ser checado quanto a validade do BD ( máximo de 50 caracteres, caracteristica de email e caracteres inválidos) antes de entregue a classe.
     * 
     * @var string Utilizada para a verificação de login
     * @access private
     */
    public $_login;

    /**
     *  A senha (hash) do usuário para logar no sistema.
     * 
     * Deve ser checado quanto a validade do BD (256 caracteres e caracteres inválidos) antes de entregue a classe, além de utilizar o método
     * generateSenha() ao salvar pela primeira vez para gerar o hash seguro.
     * 
     * @var string Utilizada para a verificação de login
     * @access private
     */
    public $_senha;

    /**
     * Indicador de tipo de login
     * 
     * É gerenciada pelo sistema e indica se o usuário é um discente (1) ou funcionario (2)
     * 
     * @var int Utilizada para identificar o tipo de usuário
     * @access private
     */
    public $_tipo;

    /**
     * Construtor de Usuário
     * 
>>>>>>> upstream/master
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
<<<<<<< HEAD
     *
     * Devolve o e-mail do usuario
     *
=======
     * 
     * Devolve o e-mail do usuario
     * 
>>>>>>> upstream/master
     * @return string E-mail do usuário
     * @access public
     */
    public function getlogin() {
        return $this->_login;
    }

    /**
     * Getter de senha
<<<<<<< HEAD
     *
     * Devolve o hash da senha do usuario
     *
=======
     * 
     * Devolve o hash da senha do usuario
     * 
>>>>>>> upstream/master
     * @return string Senha do usuário
     * @access public
     */
    public function getsenha() {
        return $this->_senha;
    }

    /**
     * Getter de tipo
<<<<<<< HEAD
     *
     * Devolve o tipo de login do usuario
     *
=======
     * 
     * Devolve o tipo de login do usuario
     * 
>>>>>>> upstream/master
     * @return int tipo do usuário
     * @access public
     */
    public function gettipo() {
        return $this->_tipo;
    }

    /**
     * Setter de login
<<<<<<< HEAD
     *
     * Define o valor de login (e-mail) do usuário
     *
     * @param string $login O valor a ser definido para login (e-mail)
     *
=======
     * 
     * Define o valor de login (e-mail) do usuário
     * 
     * @param string $login O valor a ser definido para login (e-mail)
     * 
>>>>>>> upstream/master
     * @return string O novo valor de login (e-mail)
     * @access public
     */
    public function setlogin($login) {
        $this->_login = $login;
        return $this;
    }

    /**
     * Setter de senha
<<<<<<< HEAD
     *
     * Define o valor de senha do usuário. Este valor deve ser o hash da senha digitada.
     *
     * @param string $senha O valor a ser definido para senha
     *
=======
     * 
     * Define o valor de senha do usuário. Este valor deve ser o hash da senha digitada.
     * 
     * @param string $senha O valor a ser definido para senha
     * 
>>>>>>> upstream/master
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
<<<<<<< HEAD
     *
     * Define o tipo do usuário.
     *
     * @param int $tipo O tipo a ser definido ao usuário
     *
=======
     * 
     * Define o tipo do usuário.
     * 
     * @param int $tipo O tipo a ser definido ao usuário
     * 
>>>>>>> upstream/master
     * @return int O novo tipo
     * @access public
     * @see Usuario::$_tipo
     */
    public function settipo($tipo) {
        $this->_tipo = $tipo;
        return $this;
    }

<<<<<<< HEAD
    public function setlogin_confirmacao($_login_confirmacao){
      $this->_login_confirmacao = $_login_confirmacao;
    }
    public function getlogin_confirmacao(){
      return $this->_login_confirmacao;
    }

    public function setsenha_confirmacao($_senha_confirmacao){
      $this->_senha_confirmacao = $_senha_confirmacao;
    }
    public function getsenha_confirmacao(){
      return $this->_senha_confirmacao;
    }

    /**
     * Gerador de hashes
     *
     * A partir de um valor recebido cria um hash seguro.
     *
     * @param string $senha O valor a ser convertido em hash
     *
=======
    /**
     * Gerador de hashes
     * 
     * A partir de um valor recebido cria um hash seguro.
     * 
     * @param string $senha O valor a ser convertido em hash
     * 
>>>>>>> upstream/master
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
<<<<<<< HEAD
     *
     * Compara os valores passados com o usuário, e se forem iguais (válidos) o usuário pode logar no sistema.
     *
     * @param string $login O login (e-mail) digitado
     * @param string $senha A senha digitada (não o hash)
     *
=======
     * 
     * Compara os valores passados com o usuário, e se forem iguais (válidos) o usuário pode logar no sistema.
     * 
     * @param string $login O login (e-mail) digitado
     * @param string $senha A senha digitada (não o hash)
     * 
>>>>>>> upstream/master
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

<<<<<<< HEAD

=======
>>>>>>> upstream/master
}
