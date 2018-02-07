<?php

require_once(dirname(__FILE__) . '/base-controller.php');
//require_once('base-controller.php');


if (isset($_POST['cadastrar'])) {
    //carregar arquivo da pasta util e model para cadastrar o aluno
    $loader->loadUtil('String');
	$loader->loadDao('Funcionario');	

    session_start();
    //talvez seja uma boa inicializar o aluno pelo post(não no construtor, mas em um método init():bool)
    //$aluno = new Aluno(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
	$funcionario = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
	
	$funcionario->setnome(LimpaString::limpar($_POST['nome']));
	$funcionario->setsiape((int)(LimpaString::limpar($_POST['siape'])));
	if(isset($_POST['PO'])) {
		$funcionario->setpo(FALSE);
		if($_POST['PO'] == "on")
			$funcionario->setpo(TRUE);
	}
	if(isset($_POST['CE'])) {
		$funcionario->setce(FALSE);
		if($_POST['CE'] == "on")
			$funcionario->setce(TRUE);
	}
	if(isset($_POST['SRA'])) {
		$funcionario->setsra(FALSE);
		if($_POST['SRA'] == "on")
			$funcionario->setsra(TRUE);
	}
	if(isset($_POST['OE'])) {
		$funcionario->setpo(FALSE);
		if($_POST['OE'] == "on")
			$funcionario->setoe(TRUE);
	}
	$funcionario->setlogin(LimpaString::limpar($_POST['email']));
	
	$X = $_POST;
	
	echo $_POST["siape"];
	
	//echo $X;
	echo "OI";

	// $VAR guarda o nome de cada variável e cada valor de $X é passado
	// para $VALUE na ordem das variáveis.
	foreach ( $X as $VAR => $VALUE) {

	// Imprime o nome da variável e seu respectivo valor.
	print "$VAR = $VALUE<p>";
	}
	
    $erros = 0;
    $notificao_erros = array();
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || !filter_var($_POST["confirmEmail"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_erro1'] = true;
        unset($_SESSION['email']);
        unset($_SESSION['email_confirmacao']);
        $erros++;
    } else {
        if (strcmp($_POST["email"],$_POST["confirmEmail"])!=0) {
            $_SESSION['email_erro2'] = "Os emails informados não são iguais.";
            unset($_SESSION['email']);
            unset($_SESSION['email_confirmacao']);
            $erros++;
        }
    }

    if($erros != 0) {
		echo "Não salvou!";
	}
	
	echo "<br>".$funcionario->isroot();

    $model = $loader->loadModel('funcionario-model', 'FuncionarioModel');
    if($model != null){
        if($model->cadastrar($funcionario)){
			echo "Salvo no BD!";
            //redirect(base_url() . '/estajui/coodenador-extensao/usuarios.html');
        }else{
            echo "Problema ao salvar!!!";
        }
    }else{
        echo "ERROR MESSAGE!!!";
    }
}
//header("Location: cadastro.php");
//redirect(base_url() . '/estajui/coodenador-extensao/usuarios.html');
?>