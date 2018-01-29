<?php

require_once('MainModel.php');
require_once('../util/funcao-geraSenha.php');

class FuncionarioModel extends MainModel{
	
	///Se a senha estiver NULL, cria uma aleatória
    public function cadastrar($funcionario){
        try {
			
			
			///Sempre cadastra no Campus Montes Claros!
            $this->conn->beginTransaction();
			
			
			/*$pstmt = $this->conn->prepare("INSERT INTO usuario (email, senha, tipo) VALUES (?, ?, ?)");
			
			if($funcionario->getsenha() == NULL) 
				$a = $pstmt->execute(array($funcionario->getlogin(), Usuario::generateSenha(geraSenha(8, true, true, true)), 2));
			else
				$a = $pstmt->execute(array($funcionario->getlogin(), $funcionario->getsenha(), 2));
			
			echo "a: ";
			echo $a;
			echo "\n".$pstmt->queryString."\n";
			echo $funcionario->getlogin() . $funcionario->getsenha() . 2;
			*/
            $pstmt = $this->conn->prepare("INSERT INTO funcionario (siape, nome, po, oe, ce, sra, root, formacao, privilegio, usuario_email, campus_cnpj) 
							VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $b = $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), $funcionario->ispo(), $funcionario->isoe(), $funcionario->isce(), $funcionario->issra(), 
							$funcionario->isroot(), $funcionario->getformacao(), $funcionario->isprivilegio(), $funcionario->getlogin(), 10727655000462));
			
			echo "b: ";
			echo $b;
			echo "\n".$pstmt->queryString."\n";
			echo $funcionario->getsiape() . '<br>' . $funcionario->getnome() . '<br>' . $funcionario->ispo() . '<br>' . $funcionario->isoe() . '<br>' .
							$funcionario->isce() . '<br>' .	$funcionario->issra() . '<br>' . $funcionario->isroot() . '<br>' . $funcionario->getformacao() . 
							'<br>' . $funcionario->isprivilegio() . '<br>' . $funcionario->getlogin() . '<br>' . 10727655000462;
			
            return $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollback();
            return false;
        }
    }
}

?>