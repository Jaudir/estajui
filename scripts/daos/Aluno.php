<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Endereco.php';

/**
 * Description of Discente
 *
 * @author gabriel Lucas
 */
class Aluno extends Usuario {

    private $_cpf;
    private $_nome;
    private $_data_nasc;
    private $_rg_num;
    private $_rg_orgao;
    private $_estado_civil;
    private $_sexo;
    private $_telefone;
    private $_celular;
    private $_nome_pai;
    private $_nome_mae;
    private $_cidade_natal;
    private $_estado_natal;
    private $_acesso;
    private $_endereco;

    public function __construct($login, $senha, $tipo, $_cpf, $_nome, $_data_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso, $_endereco) {
        parent::__construct($login, $senha, $tipo);
        $this->_cpf = $_cpf;
        $this->_nome = $_nome;
        $this->setdata_nasc($_data_nasc);
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

    public static function fromDataBase($login, $senha, $tipo, $_cpf, $_nome, $_datat_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso, $_endereco) {
        $instance = new self($login, $senha, $tipo);
        $instance->setcpf($_cpf);
        $instance->setnome($setnome);
        $instance->setdatat_nasc($_datat_nasc);
        $instance->setrg_num($_rg_num);
        $instance->setrg_orgao($_rg_orgao);
        $instance->setestado_civil($_estado_civil);
        $instance->setsexo($_sexo);
        $instance->settelefone($_telefone);
        $instance->setcelular($_celular);
        $instance->setnome_pai($_nome_pai);
        $instance->setnome_mae($_nome_mae);
        $instance->setcidade_natal($_cidade_natal);
        $instance->setestado_natal($_estado_natal);
        $instance->setacesso($_acesso);
        $instance->setendereco($_endereco);
        return $instance;
    }

    //Gambiarra para fazer um construtor  de acordo com a necessidade
    public static function fromController($login, $senha, $tipo, $_cpf, $_nome, $_datat_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal) {
        $instance = new self($login, $senha, $tipo);
        $instance->setcpf($_cpf);
        $instance->setnome($setnome);
        $instance->setdatat_nasc($_datat_nasc);
        $instance->setrg_num($_rg_num);
        $instance->setrg_orgao($_rg_orgao);
        $instance->setestado_civil($_estado_civil);
        $instance->setsexo($_sexo);
        $instance->settelefone($_telefone);
        $instance->setcelular($_celular);
        $instance->setnome_pai($_nome_pai);
        $instance->setnome_mae($_nome_mae);
        $instance->setcidade_natal($_cidade_natal);
        $instance->setestado_natal($_estado_natal);
        $instance->setendereco($_endereco);
        return $instance;
    }

    public function getcpf() {
        return $this->_cpf;
    }

    public function getcpfformatado() {
        $one = substr($this->_cpf, 0, 3);
        $two = substr($this->_cpf, 3, 3);
        $three = substr($this->_cpf, 6, 3);
        $four = substr($this->_cpf, 9, 2);
        return $one . "." . $two . "." . $three . "-" . $four;
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

    public function getrg_numformatado() {
        return substr($this->_rg_num, 0, 2) . "." . substr($this->_rg_num, 2, 3) . "." . substr($this->_rg_num, 5, 3) . "-" . substr($this->_rg_num, 8, 1);
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

    public function getusuario_email() {
        return $this->usuario_email;
    }

    public function setusuario_email($_usuario_email) {
        $this->usuario_email = $_usuario_email;
        return $this;
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

    function getdata_nasc() {
        return $this->_data_nasc;
    }

    function setdata_nasc($_data_nasc) {
        $date = new DateTime($_data_nasc);
        $this->_data_nasc = $date->format('d/m/Y');
    }

}
