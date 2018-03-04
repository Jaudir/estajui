<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/HomeController.php";

if(is_a($usuario, "Aluno")){
    if(isset($_POST['enviar_relatorio'])){
        $arquivo = $_FILES["relatorio"];
        if(!is_uploaded_file($_FILES['relatorio']['tmp_name'])){
            $session->pushError("Nenhum arquivo selecionado!", "error-validacao");
            redirect(base_url().'/estajui/home.php');
        }else if(!preg_match("/\.(pdf){1}$/i", $arquivo["name"], $ext)){
            $session->pushError("Fomarto de arquivo inválido!", "error-validacao");
            redirect(base_url().'/estajui/home.php');
        } else if($_FILES['relatorio']['size']>55000000){
            $session->pushError("O arquivo excedeu o tamanho máximo!", "error-validacao");
            redirect(base_url().'/estajui/home.php');      
        }else{
            $estagio_atual = $_SESSION['estagio'];
            unset($_SESSION['estagio']);
            $arq = new Arquivo();

                $arq->read($_FILES, 'relatorio');
                $x = $estagioModel->submeterrelatorio($estagio_atual->getid(),$arq,$usuario);
                if($x == false){
                    $session->pushError("Erro ao cadastrar novo relatório!", "error-critico");
                    redirect(base_url().'/estajui/home.php');
                }else{
                    $session->pushValue("Relatorio enviado com sucesso!", "sucesso");
                    redirect(base_url().'/estajui/home.php');
                }
            }

        }else {
            $session->pushError("O arquivo excedeu o tamanho máximo!", "error-validacao");
            redirect(base_url().'/estajui/home.php');
        }
    }else{
        
        redirect(base_url().'/estajui/login.php');
}
