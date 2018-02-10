<?php
/**
 * Representação de um usuário para o sistema.
 *
 * @author gabriel Lucas
 */
class Usuario {

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

}
