<?php

class Verifica{
    private $id;
	private $email;
	private $codigo;
	private $verificado;
	private $data_geracao;
    private $tipo;
    
    public __construct($id, $email, $codigo, $verificado, $data_geracao, $tipo){
        setId($id);
        setEmail($email);
        setCodigo($codigo);
        setVerificado($verificado);
        setDataGeracao($data_geracao);
        setTipo($tipo);
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function setVerificado($verificado){
        $this->verificado = $verificado;
    }

    public function setDataGeracao($data_geracao){
        $this->data_geracao = $data_geracao;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getVerificado(){
        return $this->verifiacdo;
    }

    public function getDataGeracao(){
        return $this->data_geracao;
    }

    public function getTipo(){
        return $this->tipo;
    }

}