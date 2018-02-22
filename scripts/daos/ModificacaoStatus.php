<?php

/**
 * Description of ModificacaoStatus
 *
 * @author gabriel Lucas
 */
class ModificacaoStatus {
    
    private $_id;
    private $_data;
    private $_estagio;
    private $_status;
    private $_usuario;
    
	public function __construct($id, $data, $estagio, $status, $usuario){
		$this->$_id = $id;
		$this->$_data = $data;
		$this->$_estagio = $estagio;
		$this->$_status = $status;
		$this->$_usuario = $usuario;
	}
	
	public function getid(){
		return $this->$_id;
	}
	
	public function getdata(){
		return $this->$_data;
	}
	
	public function getestagio(){
		return $this->$_estagio;
	}
	
	public function getstatus(){
		return $this->$_status;
	}
	
	public function getusuario(){
		return $this->$_usuario;
	}
		
	public function setid($id){
		$this->$_id = $id;
	}
	
	public function setdata($data){
		$this->$_data = $data;
	}
	
	public function set($estagio){
		$this->$_estagio = $estagio;
	}
	
	public function set($status){
		$this->$_status = $status;
	}
	
	public function set($usuario){
		$this->$_usuario = $usuario;
	}
}
