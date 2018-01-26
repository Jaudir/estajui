<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/models/Endereco.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/models/Aluno.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/util/String.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/util/connect.php';

//if (isset($_POST['cadastrar'])) {



   $_cpf=LimpaString::limpar($_POST['cpf']);
   $_nome=LimpaString::limpar($_POST['nome']);
   $_datat_nasc=LimpaString::limpar($_POST['data_nasc']);
   $_rg_num=LimpaString::limpar($_POST['rg']);
   $_rg_orgao=LimpaString::limpar($_POST['orgao_exp']);
   $_estado_civil=LimpaString::limpar($_POST['estado_civil']);
   $_sexo=LimpaString::limpar($_POST['sexo']);
   $_telefone=LimpaString::limpar($_POST['telefone']);
   $_celular=LimpaString::limpar($_POST['celular']);
   $_nome_pai=LimpaString::limpar($_POST['nome_pai']);
   $_nome_mae=LimpaString::limpar($_POST['nome_mae']);
   $_cidade_natal=LimpaString::limpar($_POST['cidade_natal']);
   $_estado_natal=LimpaString::limpar($_POST['estado_natal']);

    $_logradouro=LimpaString::limpar($_POST['logradouro']);
    $_bairro=LimpaString::limpar($_POST['bairro']);
    $_numero=LimpaString::limpar($_POST['numero']);
    $_complemento=LimpaString::limpar($_POST['complemento']);
    $_cidade=LimpaString::limpar($_POST['cidade']);
    $_uf=LimpaString::limpar($_POST['uf']);
    $_cep=LimpaString::limpar($_POST['cep']);

    $_login = LimpaString::limpar($_POST['email']);
    $_login_confirmacao= LimpaString::limpar($_POST['email_confirmacao']);
    $_senha= $_POST['senha'];
    $_senha_confirmacao= $_POST['senha_confirmacao'];
    $_tipo = 1;//Aluno


    $erros = 0;

      if (!filter_var($_login, FILTER_VALIDATE_EMAIL) || (filter_var($_login, FILTER_VALIDATE_EMAIL) && strcmp($_login, $_login_confirmacao)!=0)) {
          echo "insira um email valido";
          $erros++;
      }
      if(strcmp($_senha, $_senha_confirmacao)!=0){
        echo "as senhas não correspondem";
        $erros++;
      }



    if ($erros == 0) {
        /**
        begin Transaction
        */
        $aluno = new Aluno($login, $senha, $tipo, $_cpf, $_nome, $_datat_nasc, $_rg_num, $_rg_orgao, $_estado_civil, $_sexo, $_telefone, $_celular, $_nome_pai, $_nome_mae, $_cidade_natal, $_estado_natal, $_acesso);
        $endereco = new Endereco($_logradouro, $_bairro, $_numero, $_complemento, $_cidade, $_uf, $_cep);
        $usuario  = new Usuario($_login, Usuario::generateSenha($_senha), $_tipo);

        $array= array($endereco,$usuario,$aluno);
        conexao::multiplesInsertions($array);
        /**
            end Transaction
        */
    }
  #header("Location:../../login/cadastro.html");
