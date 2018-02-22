<?php

/**
 * Description of Notificacao
 *
 * @author gabriel Lucas
 */
class Notificacao {
    
    private $_id;
    private $_lida;
    private $_status;
    private $_usuario;
    
	public function __construct($id, $lida, $status, $usuario){
		$this->$_id = $id;
		$this->$_lida = $lida;
		$this->$_status = $status;
		$this->$_usuario = $usuario;
	}
	
	public function getid(){
		return $this->$_id;
	}
	
	public function getlida(){
		return $this->$_lida;
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
	
	public function setdata($lida){
		$this->$_lida = $lida;
	}
	
	public function set($status){
		$this->$_status = $status;
	}
	
	public function set($usuario){
		$this->$_usuario = $usuario;
	}
	
}
