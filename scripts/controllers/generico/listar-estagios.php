<?php
require_once(dirname(__FILE__) . '/../base-controller.php');
$session = getSession();
//Estudante Aluno
/*$session->setUsuario(
    new Aluno("aluno@aluno", "12345", 1, 1, "Nome de um aluno 1", null, null, null, null, null, null, null, null, null, null, null, null, null)
	);*/
//OE
/*$session->setUsuario(
	new Funcionario("func@func", "12345", 1, 2, "Professor2", false, true, false, false, null, null, null, null)
);*/
//PO
/*$session->setUsuario(
	new Funcionario("func@func", "12345", 1, 1, "Professor1", true, false, false, false, null, null, null, null)
);*/
//CE
$session->setUsuario(
	new Funcionario("func@func", "12345", 1, 2, "Professor2", false, false, true, false, null, null, null, null)
);
if($session->isoe()){
		echo "is oe!<br/>";
        $session->clearErrors();
        // Criar o objeto com as informações da sessão
        $oe = $session->getUsuario('usuario');
		$model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
		$oe = $model->read($oe->getsiape(),1)[0];
		
		
		$palavras_chave = array("Google", "Responsavel01", "Nome de um aluno 1", "Professor1", "2010-01-01", "2019-01-01");
		$palavras_chave[0] = "%".$palavras_chave[0]."%";
		$palavras_chave[1] = "%".$palavras_chave[1]."%";
		$palavras_chave[2] = "%".$palavras_chave[2]."%";
		$palavras_chave[3] = "%".$palavras_chave[3]."%";
		$listaEstagios = $model->listarEstagios($palavras_chave, $oe->getsiape(), "oe.siape");
		if (is_array($listaEstagios)){
			foreach($listaEstagios as $le){
				echo "Nome do estagiário: ".$le->getaluno()->getnome()."<br/>";
				echo "Data de início: ".$le->getpe()->get_data_inicio()."<br/>";
				echo "Data de término: ".$le->getpe()->get_data_fim()."<br/>";
				echo "PO: ".$le->getfuncionario()->getnome()."<br/>";
				echo "Empresa: ".$le->getempresa()->get_nome()."<br/>";
			}
		} else {
			echo "Nenhum resultado.<br/>";
		}
}else if($session->ispo()){
		echo "is po!<br/>";
        $session->clearErrors();
        // Criar o objeto com as informações da sessão
        $po = $session->getUsuario('usuario');
		$model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
		$po = $model->read($po->getsiape(),1)[0];
		
		
		$palavras_chave = array("Google", "Responsavel01", "Nome de um aluno 1", "Professor1", "2010-01-01", "2019-01-01");
		$palavras_chave[0] = "%".$palavras_chave[0]."%";
		$palavras_chave[1] = "%".$palavras_chave[1]."%";
		$palavras_chave[2] = "%".$palavras_chave[2]."%";
		$palavras_chave[3] = "%".$palavras_chave[3]."%";
		$listaEstagios = $model->listarEstagios($palavras_chave, $po->getsiape(), "po.siape");
		if (is_array($listaEstagios)){
			foreach($listaEstagios as $le){
				echo "Nome do estagiário: ".$le->getaluno()->getnome()."<br/>";
				echo "Data de início: ".$le->getpe()->get_data_inicio()."<br/>";
				echo "Data de término: ".$le->getpe()->get_data_fim()."<br/>";
				echo "PO: ".$le->getfuncionario()->getnome()."<br/>";
				echo "Empresa: ".$le->getempresa()->get_nome()."<br/>";
			}
		} else {
			echo "Nenhum resultado.<br/>";
		}
}else if($session->isce()){
		echo "is ce!<br/>";
        $session->clearErrors();
        // Criar o objeto com as informações da sessão
        $ce = $session->getUsuario('usuario');
		$model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
		$ce = $model->read($ce->getsiape(),1)[0];
		
		
		$palavras_chave = array("Google", "Responsavel01", "Nome de um aluno 1", "Professor1", "2010-01-01", "2019-01-01");
		$palavras_chave[0] = "%".$palavras_chave[0]."%";
		$palavras_chave[1] = "%".$palavras_chave[1]."%";
		$palavras_chave[2] = "%".$palavras_chave[2]."%";
		$palavras_chave[3] = "%".$palavras_chave[3]."%";
		$listaEstagios = $model->listarEstagios_ce($palavras_chave);
		if (is_array($listaEstagios)){
			foreach($listaEstagios as $le){
				echo "Nome do estagiário: ".$le->getaluno()->getnome()."<br/>";
				echo "Data de início: ".$le->getpe()->get_data_inicio()."<br/>";
				echo "Data de término: ".$le->getpe()->get_data_fim()."<br/>";
				echo "PO: ".$le->getfuncionario()->getnome()."<br/>";
				echo "Empresa: ".$le->getempresa()->get_nome()."<br/>";
			}
		} else {
			echo "Nenhum resultado.<br/>";
		}
}else if($session->isAluno()){
		echo "is aluno!<br/>";
        $session->clearErrors();
        // Criar o objeto com as informações da sessão
        $aluno = $session->getUsuario('usuario');
		$model = $loader->loadModel('AlunoModel', 'AlunoModel');
		$aluno = $model->read($aluno->getcpf(),1)[0];
		
		
		$palavras_chave = array("Google", "Responsavel01", "Nome de um aluno 1", "Professor1", "2010-01-01", "2019-01-01");
		$palavras_chave[0] = "%".$palavras_chave[0]."%";
		$palavras_chave[1] = "%".$palavras_chave[1]."%";
		$palavras_chave[2] = "%".$palavras_chave[2]."%";
		$palavras_chave[3] = "%".$palavras_chave[3]."%";
		$listaEstagios = $model->listarEstagios($palavras_chave, $aluno->getcpf(), "aluno.cpf");
		if (is_array($listaEstagios)){
			foreach($listaEstagios as $le){
				echo "Nome do estagiário: ".$le->getaluno()->getnome()."<br/>";
				echo "Data de início: ".$le->getpe()->get_data_inicio()."<br/>";
				echo "Data de término: ".$le->getpe()->get_data_fim()."<br/>";
				echo "PO: ".$le->getfuncionario()->getnome()."<br/>";
				echo "Empresa: ".$le->getempresa()->get_nome()."<br/>";
			}
		} else {
			echo "Nenhum resultado.<br/>";
		}
}else{
	$session->pushError("Tipo de usuário incorreto!");
	//echo "Tipo de usuário incorreto!";
	redirect(base_url() . '/estajui/login/cadastro.php');
}