<?php
require_once(dirname(__FILE__) . '/../base-controller.php');
$session = getSession();

/*$session->setUsuario(
    new Aluno("aluno@aluno", "12345", 1, 1, "Nome de um aluno 1", null, null, null, null, null, null, null, null, null, null, null, null, null)
	);*/
$session->setUsuario(
	new Funcionario("func@func", "12345", 1, 2, "Professor2", false, true, false, false, null, null, null, null)
);
if($session->isoe()){
        $session->clearErrors();
        // Criar o objeto aluno com as informações da sessão
        $oe = $session->getUsuario('usuario');
		$model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
		$oe = $model->read($oe->getsiape(),1)[0];
		
		
		$palavras_chave = array("Google", "Responsavel01", "Nome de um aluno 1", "Professor1", "2010-01-01", "2019-01-01");
		$palavras_chave[0] = "%".$palavras_chave[0]."%";
		$palavras_chave[1] = "%".$palavras_chave[1]."%";
		$palavras_chave[2] = "%".$palavras_chave[2]."%";
		$palavras_chave[3] = "%".$palavras_chave[3]."%";
		$listaEstagios = $model->listarEstagios_oe($palavras_chave, $oe->getsiape());
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
	$session->pushError("Você não é um aluno!");
	redirect(base_url() . '/estajui/login/cadastro.php');
}