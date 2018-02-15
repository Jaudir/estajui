<?php

/* Acompanhamento dos status dos estágios; 
 * Apresenta todos os estágios e permite que ele selecione algum para ver todas as informações; 
 * Permite busca por estágios por curso e status
 */
 
 require_once(dirname(__FILE__) . '/../base-controller.php');

$loader->loadDao('Aluno');
//$session = getSession();

if(/*$session->isAluno()*/ 1){
	if (isset($_GET['oe_cpf'])) {
        //$session->clearErrors();
        // Criar o objeto aluno com as informações da sessão
        //$aluno = $session->getUsuario('usuario');
		$model = $loader->loadModel('AlunoModel', 'AlunoModel');
		//$aluno = $model->read($aluno->getcpf(),1)[0];
		$aluno = new Aluno(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
		$aluno->setcpf($_GET['oe_cpf']);
		
		$listaEstagios = $model->visualizarEstagios($aluno);
		if ($listaEstagios != false){
			foreach($listaEstagios as $le){
				echo "<br/>";
				var_dump($le->getpe()->get_data_inicio());
				echo "<br/>";
				var_dump($le->getfuncionario()->getnome());
				echo "<br/>";
				var_dump($le->getempresa()->get_nome());
				echo "<br/>";
				var_dump($le->getstatus()->get_descricao());
				echo "<br/>";	
			}
		}
		
		
    } else {
		echo "Dados inválidos!";// $session->pushError("Dados inválidos!");
	}
}else{
	echo "Você não é um aluno!";//$session->pushError("Você não é um aluno!");
}
//redirect(base_url() . '/estajui/login/cadastro.php');