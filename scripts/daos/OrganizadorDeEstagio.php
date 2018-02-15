<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Usuario.php';

class Aluno extends Usuario {
	public function __construct(){
		parent::__construct($login, $senha, $tipo);
	}
	public function getusuario_email() {
        return $this->usuario_email;
    }
	public function setusuario_email($_usuario_email) {
        $this->usuario_email = $_usuario_email;
        return $this;
    }
}