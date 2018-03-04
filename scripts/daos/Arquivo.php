<?php

class Arquivo{

    private $tipo;
    private $conteudo;
    private $nome;
    private $size;
    public function read($var,$name){
        $this->tipo = $var[$name]['type'];
        $this->nome = $var[$name]['name'];
        $ax = fopen($var[$name]['tmp_name'],"rb");
        $this->conteudo = fread($ax,$this->size);
        $this->conteudo = base64_encode($this->conteudo);
        fclose($ax);
    }
}