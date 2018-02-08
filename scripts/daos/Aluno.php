<?php

require_once(dirname(__FILE__) . '/Usuario.php');
require_once(dirname(__FILE__) . '/Endereco.php');
/**
 * Description of Discente
 *
 * @author gabriel Lucas
 */
class Aluno extends Usuario{

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
    private $_endereco_id;
    public $endereco;

    public function __construct($login, $senha, $tipo, $_cpf, $_nome, $_data_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso, $endereco) {
        parent::__construct($login, $senha, $tipo);
        $this->endereco = $endereco;
        $this->_cpf = $_cpf;
        $this->_nome = $_nome;
        $this->_data_nasc = $_data_nasc;
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
    }

    public function getcpf() {
        return $this->_cpf;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function getdata_nasc() {
        return $this->_data_nasc;
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
        return $this->endereco;
    }

    public function getendereco_id() {
        return $this->_endereco_id;
    }

    public function setcpf($_cpf) {
        $this->_cpf = $_cpf;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function setdata_nasc($_data_nasc) {
        $this->_data_nasc = $_data_nasc;
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

    public function setendereco_id($_endereco_id) {
        $this->_endereco_id = $_endereco_id;
        return $this;
    }

    public function setendereco($_endereco){
        $this->endereco = $_endereco;
        return $this;
    }
}
