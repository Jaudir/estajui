<?php

/**
 * Description of Status
 *
 * @author gabriel Lucas
 */
class Status {
    
    private $_codigo;
    private $_descricao;
    
    public function __construct($_codigo, $_descricao) {
        $this->_codigo = $_codigo;
        $this->_descricao = $_descricao;
    }
    
    public function get_codigo() {
        return $this->_codigo;
    }

    public function get_descricao() {
        return $this->_descricao;
    }

    public function set_codigo($_codigo) {
        $this->_codigo = $_codigo;
        return $this;
    }

    public function set_descricao($_descricao) {
        $this->_descricao = $_descricao;
        return $this;
    }


}
