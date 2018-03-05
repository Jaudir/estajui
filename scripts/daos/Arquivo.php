<?php

class Arquivo{

    private $tipo;
    private $conteudo;
    private $nome;
    private $size;
    public function read($var,$name){
        if($empty($var)){
        $this->tipo = null;
        $this->nome = null;
        $this->size = null;
        $this->conteudo = null;
        fclose($ax);
        }else{
        $this->tipo = $var[$name]['type'];
        $this->nome = $var[$name]['name'];
        $this->size = $var[$name]['size'];
        $ax = fopen($var[$name]['tmp_name'],"rb");
        $this->conteudo = fread($ax,$this->size);
        $this->conteudo = base64_encode($this->conteudo);
        fclose($ax);
        }
    }
    public function get_nome(){
        return $this->nome;
    }

    public function get_tipo(){
        return $this->tipo;
    }

    public function get_conteudo(){
        return $this->conteudo;
    }

    public function get_conteudo_decodificado(){
        return base64_decode($this->conteudo);
    }
}