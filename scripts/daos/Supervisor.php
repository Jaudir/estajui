<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Empresa.php';

/**
 * Description of Supervisor
 *
 * @author gabriel Lucas
 */
class Supervisor {
    
    private $_id;
    private $_nome;
    private $_cargo;
    private $_habilitacao;
    private $_empresa;
    
    function __construct($_id, $_nome, $_cargo, $_habilitacao, $_empresa) {
        $this->_id = $_id;
        $this->_nome = $_nome;
        $this->_cargo = $_cargo;
        $this->_habilitacao = $_habilitacao;
        $this->_empresa = $_empresa;
    }

    public function getid() {
        return $this->_id;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function getcargo() {
        return $this->_cargo;
    }

    public function gethabilitação() {
        return $this->_habilitação;
    }

    public function getempresa() {
        return $this->_empresa;
    }

    public function setid($_id) {
        $this->_id = $_id;
        
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        
    }

    public function setcargo($_cargo) {
        $this->_cargo = $_cargo;
        
    }

    public function sethabilitação($_habilitação) {
        $this->_habilitação = $_habilitação;
        
>>>>>>> caso_uso_5
    }

    public function setempresa($_empresa) {
        $this->_empresa = $_empresa;
        
    }


    
}
