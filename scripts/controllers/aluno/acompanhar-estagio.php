<?php

/* Contexto do caso de uso:
 * Visualizar informações gerais de todos os estágios do estudante e 
 * permitir que ele escolha algum para mais detalhes
 */
require_once(dirname(__FILE__) . '/../base-controller.php');
$session = getSession();

$session->setUsuario(
    new Aluno("aluno@aluno", "12345", 1, 4, "Igu", null, null, null, null, null, null, null, null, null, null, null, null, null)
	);

if($session->isAluno()){
        $session->clearErrors();
        // Criar o objeto aluno com as informações da sessão
        $aluno = $session->getUsuario('usuario');
		$model = $loader->loadModel('AlunoModel', 'AlunoModel');
		
		$listaEstagios = $model->visualizarEstagios($aluno->getcpf());
}else{
	$session->pushError("Você não é um aluno!");
	redirect(base_url() . '/estajui/login/cadastro.php');
}
