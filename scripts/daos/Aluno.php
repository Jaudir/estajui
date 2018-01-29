<?php

require_once 'Usuario.php';

/**
 * Description of Discente
 *
 * @author gabriel Lucas
 */
class Aluno extends Usuario implements CrudInterface {
    
    public $_cpf;
    public $_nome;
    public $_datat_nasc;
    public $_rg_num;
    public $_rg_orgao;
    public $_estado_civil;
    public $_sexo;
    public $_telefone;
    public $_celular;
    public $_nome_pai;
    public $_nome_mae;
    public $_cidade_natal;
    public $_estado_natal;
    public $_acesso;
    public $_endereco;

    public function __construct($login, $senha, $tipo, $_cpf, $_nome, $_datat_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso, $_endereco) {
        parent::__construct($login, $senha, $tipo);
        $this->_cpf = $_cpf;
        $this->_nome = $_nome;
        $this->_datat_nasc = $_datat_nasc;
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
    
    public function getcpf() {
        return $this->_cpf;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function getdatat_nasc() {
        return $this->_datat_nasc;
    }

    public function getrg_num() {
        return $this->_rg_num;
    }

    public function getrg_orgao() {
        return $this->_rg_orgao;
    }

    public function getestado_civil() {
        return $this->_estado_civil;
    }

    public function getsexo() {
        return $this->_sexo;
    }

    public function gettelefone() {
        return $this->_telefone;
    }

    public function getcelular() {
        return $this->_celular;
    }

    public function getnome_pai() {
        return $this->_nome_pai;
    }

    public function getnome_mae() {
        return $this->_nome_mae;
    }

    public function getcidade_natal() {
        return $this->_cidade_natal;
    }

    public function getestado_natal() {
        return $this->_estado_natal;
    }

    public function getacesso() {
        return $this->_acesso;
    }

    public function getendereco() {
        return $this->_endereco;
    }

    public function setcpf($_cpf) {
        $this->_cpf = $_cpf;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function setdatat_nasc($_datat_nasc) {
        $this->_datat_nasc = $_datat_nasc;
        return $this;
    }

    public function setrg_num($_rg_num) {
        $this->_rg_num = $_rg_num;
        return $this;
    }

    public function setrg_orgao($_rg_orgao) {
        $this->_rg_orgao = $_rg_orgao;
        return $this;
    }

    public function setestado_civil($_estado_civil) {
        $this->_estado_civil = $_estado_civil;
        return $this;
    }

    public function setsexo($_sexo) {
        $this->_sexo = $_sexo;
        return $this;
    }

    public function settelefone($_telefone) {
        $this->_telefone = $_telefone;
        return $this;
    }

    public function setcelular($_celular) {
        $this->_celular = $_celular;
        return $this;
    }

    public function setnome_pai($_nome_pai) {
        $this->_nome_pai = $_nome_pai;
        return $this;
    }

    public function setnome_mae($_nome_mae) {
        $this->_nome_mae = $_nome_mae;
        return $this;
    }

    public function setcidade_natal($_cidade_natal) {
        $this->_cidade_natal = $_cidade_natal;
        return $this;
    }

    public function setestado_natal($_estado_natal) {
        $this->_estado_natal = $_estado_natal;
        return $this;
    }

    public function setacesso($_acesso) {
        $this->_acesso = $_acesso;
        return $this;
    }

    public function setendereco($_endereco) {
        $this->_endereco = $_endereco;
        return $this;
    }
}
