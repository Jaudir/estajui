<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class FuncionarioModel extends MainModel{
    public function cadastrar($funcionario, $cursos){
		$this->loader->loadUtil('funcao-geraSenha');
		$this->loader->loadDAO('Usuario');
		
        try {
			
			
			///Sempre cadastra no Campus Montes Claros!
            $this->conn->beginTransaction();
			
			
			$pstmt = $this->conn->prepare("INSERT INTO usuario (email, senha, tipo) VALUES (?, ?, ?)");
			
			
			if($funcionario->getsenha() == NULL || $funcionario->getsenha() == " ") {
				$verif = $pstmt->execute(array($funcionario->getlogin(), Usuario::generateSenha(geraSenha(8, true, true, true)), 2));
				if(!$verif) {					
					print_r($pstmt->errorInfo());
					return false;
				} 					
			}
			else {
				$verif = $pstmt->execute(array($funcionario->getlogin(), $funcionario->getsenha(), 2));
				if(!$verif) {
					echo "<br>Ali!";
					print_r($pstmt->errorInfo());
					$_SESSION['pau12'] = $pstmt->errorInfo();
					return false;
				}
			}
			
			
			
            $pstmt = $this->conn->prepare("INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, 
							usuario_email, campus_cnpj) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
			$verif = $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), $funcionario->ispo(), $funcionario->isoe(), $funcionario->isce(), $funcionario->issra(), 
							$funcionario->isroot(), $funcionario->getformacao(), $funcionario->isprivilegio(), $funcionario->getlogin(), 10727655000462));
            if(!$verif) {
					
				$_SESSION['pau1'] = $pstmt->errorInfo();
				return false;
			}
				
			
			/*echo "\n".$pstmt->queryString."\n";
			echo $funcionario->getsiape() . '<br>' . $funcionario->getnome() . '<br>' . $funcionario->ispo() . '<br>' . $funcionario->isoe() . '<br>' .
							$funcionario->isce() . '<br>' .	$funcionario->issra() . '<br>' . $funcionario->isroot() . '<br>' . $funcionario->getformacao() . 
							'<br>' . $funcionario->isprivilegio() . '<br>' . $funcionario->getlogin() . '<br>' . 10727655000462;*/
			
			if(isset($cursos)) {
				
				foreach($cursos as $i => $c) {
					$_SESSION['curso'] = $c;
					if(strcmp($c, "cienciadacomputacao") == 0) {
						$pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
						$verif = $pstmt->execute(array($funcionario->getsiape(), 1));
						if(!$verif) {
							$_SESSION['pau10'] = $pstmt->errorInfo();
							return false;
						}
					}
					
					if(strcmp($c,"engenhariaquimica") == 0) {
						$pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
						$verif = $pstmt->execute(array($funcionario->getsiape(), 2));
						if(!$verif) {
							$_SESSION['pau20'] = $pstmt->errorInfo();
							return false;
						}
					}
					
					if(strcmp($c,"tecnicoeminformatica") == 0) {
						$pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
						$verif = $pstmt->execute(array($funcionario->getsiape(), 3));
						if(!$verif) {
							$_SESSION['pau30'] = $pstmt->errorInfo();
							return false;
						}
					}
					
					if(strcmp($c,"tecnicoemquimica") == 0) {
						$pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
						$verif = $pstmt->execute(array($funcionario->getsiape(), 4));
						$_SESSION['pau39'] = "Inseriu";
						if(!$verif) {
							$_SESSION['pau40'] = $pstmt->errorInfo();
							return false;
						}
					}
					
					if(strcmp($c,"tecnicoemeletrotecnica") == 0) {
						$pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
						$verif = $pstmt->execute(array($funcionario->getsiape(), 5));
						if(!$verif) {
							$_SESSION['pau50'] = $pstmt->errorInfo();
							return false;
						}
					}
					
					if(strcmp($c,"tecnicoemsegurancadotrabalho") == 0) {
						$pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
						$verif = $pstmt->execute(array($funcionario->getsiape(), 6));
						if(!$verif) {
							$_SESSION['pau60'] = $pstmt->errorInfo(); 
							return false;
						}
					}
				}
			}
			
            return $this->conn->commit();
			
			
        } catch (PDOException $e) {
            $this->conn->rollback();
            return false;
        }
    }

    //verifica se uma empresa já foi pré cadastrada
    public function verificaPreCadastro($cnpj){
        try{
            $st = $this->conn->prepare("SELECT conveniada FROM empresa WHERE cnpj = $cnpj");
            $st->execute();

            $data = $st->fetchAll();
            if(count($data) > 0){
                return ($data[0]['conveniada'] != 0);
            }
        }catch(PDOException $ex){            
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }

    //altera a situação de uma empresa conveniada e notifica os alunos em estágios associados
    public function alterarConvenio($veredito, $justificativa, $cnpj){
        try{
            $status_codigo = 0;
            $temJustificativa = 0;

            if($veredito == 1){
                $status_codigo = 11;//id direto do BD ://///
                $justificativa = '';
                $temJustificativa = 0;
            }else{
                $status_codigo = 12;//id direto do BD ://///
                $temJustificativa = 1;
            }

            /*Carregar alunos de estágios associados que devem ser notificados desta ação*/
            $stmt = $this->conn->prepare(
                "SELECT * FROM estagio
                JOIN aluno ON aluno.cpf = estagio.aluno_cpf
                JOIN usuario ON aluno.usuario_email = usuario.email
                WHERE empresa_cnpj = $cnpj");
            $stmt->execute();

            $alunos = $stmt->fetchAll();
            if(count($alunos) == 0){
                Log::LogError("Empresa não tem estágios associados", true);//não tem estágios associados, ou alunos associados aos estágios ??
            }

            //inserção dos dados

            $this->conn->beginTransaction();

            $this->conn->exec("UPDATE empresa SET conveniada = $veredito WHERE cnpj = $cnpj");

            //notificar todos os alunos
            foreach($alunos as $aluno){
                $estagio_id = $aluno['id'];
                $email = $aluno['email'];

                $this->conn->exec("INSERT INTO modifica_status(data, estagio_id, status_codigo, usuario_email) VALUES(NOW(), '$estagio_id', '$status_codigo', '$email')");
                $last_id = $this->conn->lastInsertId();
                $this->conn->exec("INSERT INTO notificacao(lida, temJustificativa, justificativa, modifica_status_id) VALUES(0, $temJustificativa, '$justificativa', $last_id)");
            }

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            $this->conn->rollback();
            return false;
        }
        return true;
    }

    public function removerCadastroEmpresa($cnpj){
        try{
            $this->conn->exec("delete from empresa where cnpj = $cnpj");
            //remover endereço aqui(delete deve ser on cascade)
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }

    /*Lista status de todos os estágios*/
    public function listaEstagios(){
        //listar estágios aqui
        return array();
    }

    /*Lista empresas que estão aguardando aprovação do convênio*/
    public function listaEmpresas(){
        try{
            $st = $this->conn->prepare(
                'SELECT 
                endereco.*,
                empresa.*,
                responsavel.nome AS resp_nome, responsavel.email AS resp_email, responsavel.telefone AS resp_tel, responsavel.cargo AS resp_cargo
                FROM empresa 
                INNER JOIN endereco ON endereco.id = empresa.endereco_id 
                LEFT JOIN responsavel ON responsavel.empresa_cnpj = empresa.cnpj
                WHERE conveniada = 0');
            $st->execute();
            return $st->fetchAll();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }
}

?>