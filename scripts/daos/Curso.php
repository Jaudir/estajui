<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Campus.php';

/**
 * Description of Curso
 *
 * @author gabriel Lucas
 */
class Curso {
    
    private $_id;
    private $_nome;
    
	public function __construct($id, $nome){
		$this->_id = $id;
		$this->_nome = $nome;
	}
	
	public function getid(){
		return $this->_id;
	}
	
	public function getnome(){
		return $this->_nome;
	}
	
	public function setid($id){
		$this->_id = $id;
	}
	
	public function setnome($nome){
		$this->_nome = $nome;
	}
}
