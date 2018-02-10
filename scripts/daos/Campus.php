<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/models/Endereco.php';

/**
 * Description of Campus
 *
 * @author gabriel Lucas
 */
class Campus {
    
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

}
