<?php

/**
 * Description of Curso
 *
 * @author gabriel Lucas
 */
class Curso {
    
    private $_id;
    private $_nome;
    private $_campus;
    
	public function __construct($id, $nome, $campus){
		$this->_id = $id;
		$this->_nome = $nome;
		$this->_campus = $campus;
	}
	
	public function getid(){
		return $this->_id;
	}
	
	public function getnome(){
		return $this->_nome;
	}
	
	public function getcampus(){
		return $this->_campus;
	}
	
	public function setid($id){
		$this->_id = $id;
	}
	
	public function setnome($nome){
		$this->_nome = $nome;
	}
	
	public function setcampus($campus){
		$this->_campus = $campus;
	}
	
}
