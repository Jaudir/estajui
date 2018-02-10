<?php
require_once('../util/PHPMailer/PHPMailerAutoload.php');


class Email{
    private $mail;
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = 'smtp.google.com';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->Username = 'cabronzputo@gmail.com';                 // SMTP username
        $this->mail->Password = 'secret-123';                           // SMTP password
        $this->mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = 587;
    }

    public function criarEmailAluno($destinatario){
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->setFrom('wadson.ayres@gmail.com', 'Your Name');
        $this->mail->addAddress($destinatario, 'Um FDP User');
        $this->mail->isHTML(true);                                  // Set email format to HTML
        $this->mail->Subject = 'Confirmação de conta ESTAJUI';
        $this->mail->Body  ='Seu link dev confirmação: Clique neste <a href="email_ativacao.php?code=$this->geraCodigoConfirmacao()"> Link </a> para ativar sua conta';

    }
    public function enviarEmail(){
        if($this->mail->send()){
            return true;
        }
        return false;
    }
    public function getcodigo(){
        return $this->codigo;

    }
    public function setcodigo($codigo){
         $this->codigo = $codigo;

    }
    public function geraCodigoConfirmacao(){
        $this->codigo = substr(md5(mt_rand()),0,20);
        return $this->codigo;
    }
 }

