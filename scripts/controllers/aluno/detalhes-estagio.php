<?php

/* Contexto do caso de uso:
 * Visualizar informações gerais de todos os estágios do estudante e 
 * permitir que ele escolha algum para mais detalhes
 */
 
 require_once(dirname(__FILE__) . '/../base-controller.php');
 
$loader->loadUtil('String');
$loader->loadDao('Aluno');

//$session = getSession();

if(1 /*$session->isAluno()*/){
	if (1) {
		/*$session->clearErrors();
		$aluno = $session->getUsuario('usuario');

		$alunoModel = $loader->loadModel('AlunoModel', 'AlunoModel');
		$aluno = $alunoModel->read($aluno->getcpf(),1)[0];*/
		if (isset($_GET['estagio_id'])){
			$estagioModel = $loader->loadModel('EstagioModel','EstagioModel');
			$estagio = $estagioModel->recuperar($_GET['estagio_id'] /*$_POST['estagio_id']*/);
			if ($estagio != false){
				var_dump($estagio->getstatus()->get_descricao());echo"<br/>";
				var_dump($estagio->getapolice()->get_numero());echo"<br/>";
				var_dump($estagio->getapolice()->get_seguradora());echo"<br/>";
				var_dump($estagio->getsupervisor()->get_nome());echo"<br/>";
				var_dump($estagio->getsupervisor()->get_habilitação());echo"<br/>";
				var_dump($estagio->getsupervisor()->get_cargo());echo"<br/>";
				var_dump($estagio->getfuncionario()->getnome());echo"<br/>";
				var_dump($estagio->getfuncionario()->getformacao());echo"<br/>";
				var_dump($estagio->getpe()->get_data_inicio());echo"<br/>";
				var_dump($estagio->getpe()->get_data_fim());echo"<br/>";
				var_dump($estagio->getpe()->get_hora_inicio1());echo"<br/>";
				var_dump($estagio->getpe()->get_hora_fim1());echo"<br/>";
				var_dump($estagio->getpe()->get_hora_inicio2());echo"<br/>";
				var_dump($estagio->getpe()->get_hora_fim2());echo"<br/>";
				var_dump($estagio->getpe()->get_total_horas());echo"<br/>";
				var_dump($estagio->getpe()->get_atividades());echo"<br/>";
				var_dump($estagio->getempresa()->get_nome());echo"<br/>";
				var_dump($estagio->getempresa()->get_cnpj());echo"<br/>";
				var_dump($estagio->getempresa()->get_endereco()->getlogradouro());echo"<br/>";
				var_dump($estagio->getempresa()->get_endereco()->getnumero());echo"<br/>";
				var_dump($estagio->getempresa()->get_endereco()->getbairro());echo"<br/>";
				var_dump($estagio->getempresa()->get_endereco()->getcidade());echo"<br/>";
				var_dump($estagio->getempresa()->get_endereco()->getuf());echo"<br/>";
				var_dump($estagio->getempresa()->get_endereco()->getcep());echo"<br/>";
				var_dump($estagio->getempresa()->get_telefone());echo"<br/>";
				var_dump($estagio->getempresa()->get_fax());echo"<br/>";
				var_dump($estagio->getempresa()->get_nregistro());echo"<br/>";
				var_dump($estagio->getempresa()->get_conselhofiscal());echo"<br/>";
				
			}
		}
		
		
	} else {
		//$session->pushError("Dados inválidos!");
	}
}else{
	//$session->pushError("Você não é um aluno!");
}
//redirect(base_url() . '/estajui/login/cadastro.php');