<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/HomeController.php";

require_once ('../base-controller.php');

$session = getSession();

$_POST['estagio_id'] = 6;
$_POST['relatorio_id'] = 1;


if(isset($_POST['confirmar']) && isset($_POST['estagio_id']) && isset($_POST['relatorio_id'])){
    $estagio_atual = $loader->loadModel('EstagioModel','EstagioModel');
    $loader->loadDao('Arquivo');
    if(isset($_POST['aprovado'])){
        $estagio_atual->avaliarrelatorio(isset($_POST['aprovado']),$_POST['estagio_id'], null,$session->getusuario(),$_POST['relatorio_id'],null);
        $session->pushValue('Relatorio aprovado!', 'sucesso');
    }else if(isset($_POST['reprovado'])){
        if(isset($_POST['justificativa'])){
            $session->pushError('Ao rejeitar um relatório é necessário expressar uma justificativa!', 'error-validacao');
        }else{
            if(!is_uploaded_file($_FILES['correcao']['tmp_name'])){
                $arquivo = new Arquivo(null);
            }else{
                $arquivo = new Arquivo($_FILES);                
            }
            $estagio_atual->avaliarrelatorio(isset($_POST['aprovado']),$_POST['estagio_id'],$arquivo,$session->getusuario(),$_POST['relatorio_id'],$_POST['justificativa']);
        }
    }else{
        $session->pushError('Nenhum campo foi preenchido!', 'error-validacao');
    }
}else{
    $session->pushError('Nenhum campo foi preenchido2!', 'error-validacao');
}
$session->pushError('PassouDireto!', 'error-validacao');
redirect(base_url().'/estajui/professor-orientador/home.php');





