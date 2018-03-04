<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/ComentarioPE.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Estagio.php';

/**
 * Description of PlanoDeEstagio
 *
 * @author gabriel Lucas
 */
class PlanoDeEstagio {
    private $_setor_unidade;
    private $_estagio;
    private $_data_assinatura;
    private $_atividades;
    private $_remuneracao;
    private $_vale_transporte;
    private $_data_inicio;
    private $_data_fim;
    private $_hora_inicio1;
    private $_hora_inicio2;
    private $_hora_fim1;
    private $_hora_fim2;
    private $_total_horas;
    private $_data_efetivacao;
    private $_comentarios;
    
    public function __construct($_setor_unidade, $_estagio, $_data_assinatura, $_atividades, $_remuneracao, $_vale_transporte, $_data_inicio, $_data_fim, $_hora_inicio1, $_hora_inicio2, $_hora_fim1, $_hora_fim2, $_total_horas, $_data_efetivacao, $_comentarios) {
        $this->_setor_unidade = $_setor_unidade;
        $this->_estagio = $_estagio;
        $this->_data_assinatura = $_data_assinatura;
        $this->_atividades = $_atividades;
        $this->_remuneracao = $_remuneracao;
        $this->_vale_transporte = $_vale_transporte;
        $this->_data_inicio = $_data_inicio;
        $this->_data_fim = $_data_fim;
        $this->_hora_inicio1 = $_hora_inicio1;
        $this->_hora_inicio2 = $_hora_inicio2;
        $this->_hora_fim1 = $_hora_fim1;
        $this->_hora_fim2 = $_hora_fim2;
        $this->_total_horas = $_total_horas;
        $this->_data_efetivacao = $_data_efetivacao;
        $this->_comentarios = $_comentarios;
    }
    public function get_setor_unidade(){
        return $_setor_unidade;
    }
    public function set_setor_unidade($_setor_unidade){
        $this->_setor_unidade = $_setor_unidade;
    }
    public function get_tabela(){
        return "plano_estagio";
    }
    public function get_estagio() {
        return $this->_estagio;
    }

    public function get_data_assinatura() {
        return $this->_data_assinatura;
    }

    public function get_atividades() {
        return $this->_atividades;
    }

    public function get_remuneracao() {
        return $this->_remuneracao;
    }

    public function get_vale_transporte() {
        return $this->_vale_transporte;
    }

    public function get_data_inicio() {
        return $this->_data_inicio;
    }

    public function get_data_fim() {
        return $this->_data_fim;
    }

    public function get_hora_inicio1() {
        return $this->_hora_inicio1;
    }

    public function get_hora_inicio2() {
        return $this->_hora_inicio2;
    }

    public function get_hora_fim1() {
        return $this->_hora_fim1;
    }

    public function get_hora_fim2() {
        return $this->_hora_fim2;
    }

    public function get_total_horas() {
        return $this->_total_horas;
    }

    public function get_data_efetivacao() {
        return $this->_data_efetivacao;
    }

    public function get_comentarios() {
        return $this->_comentarios;
    }

    public function set_estagio($_estagio) {
        $this->_estagio = $_estagio;
        return $this;
    }

    public function set_data_assinatura($_data_assinatura) {
        $this->_data_assinatura = $_data_assinatura;
        return $this;
    }

    public function set_atividades($_atividades) {
        $this->_atividades = $_atividades;
        return $this;
    }

    public function set_remuneracao($_remuneracao) {
        $this->_remuneracao = $_remuneracao;
        return $this;
    }

    public function set_vale_transporte($_vale_transporte) {
        $this->_vale_transporte = $_vale_transporte;
        return $this;
    }

    public function set_data_inicio($_data_inicio) {
        $this->_data_inicio = $_data_inicio;
        return $this;
    }

    public function set_data_fim($_data_fim) {
        $this->_data_fim = $_data_fim;
        return $this;
    }

    public function set_hora_inicio1($_hora_inicio1) {
        $this->_hora_inicio1 = $_hora_inicio1;
        return $this;
    }

    public function set_hora_inicio2($_hora_inicio2) {
        $this->_hora_inicio2 = $_hora_inicio2;
        return $this;
    }

    public function set_hora_fim1($_hora_fim1) {
        $this->_hora_fim1 = $_hora_fim1;
        return $this;
    }

    public function set_hora_fim2($_hora_fim2) {
        $this->_hora_fim2 = $_hora_fim2;
        return $this;
    }

    public function set_total_horas($_total_horas) {
        $this->_total_horas = $_total_horas;
        return $this;
    }

    public function set_data_efetivacao($_data_efetivacao) {
        $this->_data_efetivacao = $_data_efetivacao;
        return $this;
    }

    public function set_comentarios($_comentarios) {
        $this->_comentarios = $_comentarios;
        return $this;
    }


    
}
