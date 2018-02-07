<?php

require_once('MainModel.php');

//require_once('../daos/Usuario.php');
//require_once('../util/funcao-geraSenha.php');
//$loader->loadUtil('geraSenha');


class FuncionarioModel extends MainModel{
	
	///Se a senha estiver NULL, cria uma aleatória
    public function cadastrar($funcionario){
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
					return false;
				}
			}
			
			
			
            $pstmt = $this->conn->prepare("INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, 
							usuario_email, campus_cnpj) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
			$verif = $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), $funcionario->ispo(), $funcionario->isoe(), $funcionario->isce(), $funcionario->issra(), 
							$funcionario->isroot(), $funcionario->getformacao(), $funcionario->isprivilegio(), $funcionario->getlogin(), 10727655000462));
            if(!$verif) {
					
				print_r($pstmt->errorInfo());
				return false;
			}
				
			
			/*echo "\n".$pstmt->queryString."\n";
			echo $funcionario->getsiape() . '<br>' . $funcionario->getnome() . '<br>' . $funcionario->ispo() . '<br>' . $funcionario->isoe() . '<br>' .
							$funcionario->isce() . '<br>' .	$funcionario->issra() . '<br>' . $funcionario->isroot() . '<br>' . $funcionario->getformacao() . 
							'<br>' . $funcionario->isprivilegio() . '<br>' . $funcionario->getlogin() . '<br>' . 10727655000462;*/
			
            return $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollback();
            return false;
        }
    }
}

?>