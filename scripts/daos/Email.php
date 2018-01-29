<?php

 class Email{

    private $codigo;
    private $destinatario;
    private $remetente;
    private $mensagem;
    private $assunto;
    private $corpo;
    private $headers;

    public function __construct() {

    }

    public static function sendEmailAluno($destinatario){
        $instancia = new self;
        $instancia->geraCodigoConfirmacao();
        $instancia->setdestinatario($destinatario);
        $instancia->setmensagem('Seu link de confirmação: Click <a href="email_ativacao.php">verifica.php?code='.$instancia->getcodigo().'</a> para ativar sua conta');
        $instancia->setheaders('From:'.$remetente);
        $instancia->setremetente('youremail');
        return $instancia;
    }

    public function getcodigo(){
        return $this->codigo;

    }
    public function getdestinatario(){
        return $this->destinatario;

    }
    public function getremetente(){
        return $this->remetente;

    }
    public function geracodigo(){
        
    }
    public function setcodigo($codigo){
         $this->codigo = $codigo;

    }
    public function setdestinatario($destinatario){
         $this->destinatario = $destinatario;

    }
    public function setremetente($remetente){
         $this->remetente = $remetente;

    }

    public function geraCodigoConfirmacao(){
        $this->codigo = substr(md5(mt_rand()),0,20);
        return $this->codigo;
    }

    public function setmensagem($mensagem){
        $this->mensagem = $mensagem;
    }
    public function setheaders($headers){
        $this->headers = $headers;
    }
    
 }
 ?>

