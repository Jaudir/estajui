
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Funcionario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/OfereceCurso.php';

/**
 * Description of OfereceCurso
 *
 * @author Igor Alberte
 */
class Leciona {
    
    private $_funcionario;
    private $_ofereceCurso;
    
    public function __construct($_funcionario, $_ofereceCurso) {
        $this->_funcionario= $_funcionario;
        $this->_ofereceCurso= $_ofereceCurso;
    }

    public function getfuncionario() {
        return $this->_funcionario;
    }

    public function getoferececurso() {
        return $this->_ofereceCurso;
    }

    public function setfuncionario($_funcionario) {
        $this->_funcionario= $_funcionario;
        return $this;
    }

    public function set_oferececurso($_ofereceCurso) {
        $this->_ofereceCurso= $_ofereceCurso;
        return $this;
    }

}
