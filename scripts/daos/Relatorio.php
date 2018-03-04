<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Estagio.php';

/**
 * Description of relatorio
 *
 * @author gabriel Lucas
 */
class Relatorio {
    
    private $_id;
    private $_arquivo;
    private $_data_envio;
    private $_estagio;
    private $_comentarios;
    
    public function __construct($_id, $_arquivo, $_data_envio, $_estagio, $_comentarios) {
        $this->_id = $_id;
        $this->_arquivo = $_arquivo;
        $this->_data_envio = $_data_envio;
        $this->_comentarios = $_comentarios;
        $this->_estagio = $_estagio;
    }
    
    public function getid() {
        return $this->_id;
    }

    public function getarquivo() {
        return $this->_arquivo;
    }

    public function getdata_envio() {
        return $this->_data_envio;
    }

    public function getestagio() {
        return $this->_estagio;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setarquivo($_arquivo) {
        $this->_arquivo = $_arquivo;
        return $this;
    }

    public function setdata_envio($_data_envio) {
        $this->_data_envio = $_data_envio;
        return $this;
    }

    public function setestagio($_estagio) {
        $this->_estagio = $_estagio;
        return $this;
    }
    public function getcomentarios() {
        return $this->_comentarios;
    }

    public function setcomentarios($_comentarios) {
        $this->_comentarios = $_comentarios;
        return $this;
    }




}
