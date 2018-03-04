<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Estagio.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Funcionario.php';

/**
 * Description of ComentarioPE
 *
 * @author gabriel Lucas
 */
class ComentarioPE {
    
    private $_id;
    private $_data;
    private $_descricao;
    private $_correcao;
    private $_funcionario;
    
    public function __construct($_id, $_data, $_descricao, $_correcao, $_funcionario) {
        $this->_id = $_id;
        $this->_data = $_data;
        $this->_descricao = $_descricao;
        $this->_correcao = $_correcao;
        $this->_funcionario = $_funcionario;
    }

    public function getid() {
        return $this->_id;
    }

    public function getdata() {
        return $this->_data;
    }

    public function getdescricao() {
        return $this->_descricao;
    }

    public function getcorrecao() {
        return $this->_correcao;
    }

    public function getfuncionario() {
        return $this->_funcionario;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setdata($_data) {
        $this->_data = $_data;
        return $this;
    }

    public function setdescricao($_descricao) {
        $this->_descricao = $_descricao;
        return $this;
    }

    public function setcorrecao($_correcao) {
        $this->_correcao = $_correcao;
        return $this;
    }

    public function setfuncionario($_funcionario) {
        $this->_funcionario = $_funcionario;
        return $this;
    }


    
}
