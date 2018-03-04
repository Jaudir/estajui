<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Aluno.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/OfereceCurso.php';

/**
 * Description of Matricula
 *
 * @author gabriel Lucas
 */
class Matricula {

    private $_matricula;
    private $_semestre_inicio;
    private $_ano_inicio;
    private $_oferta;
    private $_aluno;

    public function __construct($_matricula, $_semestre_inicio, $_ano_inicio, $_oferta, $_aluno) {
        $this->setmatricula($_matricula);
        $this->setsemestre_inicio($_semestre_inicio);
        $this->setano_inicio($_ano_inicio);
        $this->setoferta($_oferta);
        $this->setaluno($_aluno);
    }

    public function getmatricula() {
        return $this->_matricula;
    }

    public function getsemestre_inicio() {
        return $this->_semestre_inicio;
    }

    public function getano_inicio() {
        return $this->_ano_inicio;
    }

    public function getoferta() {
        return $this->_oferta;
    }

    public function getaluno() {
        return $this->_aluno;
    }

    public function setmatricula($_matricula) {
        $this->_matricula = (int)$_matricula;
        return $this;
    }

    public function setsemestre_inicio($_semestre_inicio) {
        $this->_semestre_inicio = (int)$_semestre_inicio;
        return $this;
    }

    public function setano_inicio($_ano_inicio) {
        $this->_ano_inicio =  (int)$_ano_inicio;
        return $this;
    }

    public function setoferta( OfereceCurso $_oferta) {
        $this->_oferta = $_oferta;
        return $this;
    }

    public function setaluno( Aluno $_aluno) {
        $this->_aluno = $_aluno;
        return $this;
    }

}
