<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/HomeController.php";

if(is_a($usuario, "Aluno")){
    if(isset($_POST['enviar_relatorio']) ){
        $arquivo = $_FILES["relatorio"];
        if(!is_uploaded_file($_FILES['relatorio']['tmp_name']) || !preg_match("/\.(pdf){1}$/i", $arquivo["name"], $ext)){
            $session->pushError("Formato de arquivo invalido!", "error-validacao");
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
            echo "vazio";
            $session->pushError("Deve ser preenchido", "error-validacao");
            redirect(base_url().'/estajui/home.php');
        }
    }else{
        echo "erro aqui2";  
        redirect(base_url().'/estajui/login.php');
}
