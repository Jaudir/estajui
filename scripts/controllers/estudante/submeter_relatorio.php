<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/HomeController.php";

if(is_a($usuario, "Aluno") && isset($_POST['enviar_relatorio'])){
    if(isset($_POST['estagio_id'])){
        // validar ser o relatorio que vem pode submeter estágio;
        if(!preg_match("/\.(pdf){1}$/i", $arquivo["name"], $ext)){
            $session->pushError("Formato de arquivo invalido!", "arquivo");
        }else{
            $arquivo = $_FILES["relatorio"];
            if(is_uploaded_file($_FILES['relatorio']['tmp_name'])){
                preg_match("/\.(pdf){1}$/i", $arquivo["name"], $ext);
                $nome_arquivo = md5(uniqid(time())).".".$ext[1];
                $caminho_imagem = 'relatorios/estudantes/'.$usuario->getcpf().'/'.$_POST['estagio_id'].'/'.$nome_arquivo;
                if($estagioModel->submeterRelatorio($_POST['estagio_id'],$caminho_imagem)){
                    move_uploaded_file($arquivo["tmp_name"], $caminho_imagem);
                }else{
                    $session->pushError("Erro ao enviar relatorio", "arquivo");             
                }
            }
        }
    }
}else{
redirect(base_url().'estajui/login.php');
}