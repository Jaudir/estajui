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
		$this->id = $id;
		$this->nome = $nome;
	}
	
	public function getid(){
		return $this->id;
	}
	
	public function getnome(){
		return $this->nome;
	}
	
	public function setid($id){
		$this->id = $id;
	}
	
	public function setnome($id){
		$this->id = $id;
	}
}
