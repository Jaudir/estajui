<?php
require_once("conectaBanco.php");
require_once("Registry.php");

class DaoGenerico {
	private $conn;
	
	public function __construct() {
		$registry = Registry::getInstance();
		$this->conn = $registry->get('Connection');
	}
	
	public function salvarGenerico(String $tabela, Array $atributos, Array $valores) {
		$this->conn->beginTransaction();
				
		try {
			if(count($atributos) != count($valores)){
				throw new Exception('Não há a mesma quantidade de atributos e valores!');
			}
				
			$sqlAux = "INSERT INTO";
			$sqlAux .= " ".$tabela." ("; ///Substitui o nome da tabela
			$i = 0;
				
			foreach($atributos as $value){
				if($i == 0)
					$sqlAux .= (string)$value; ///Coloca os atributos na sql
				else
					$sqlAux .= ", ".(string)$value;
				$i++;
			}
				
			$sqlAux .= ") VALUES (";
				
			$i = 0;
				
			foreach($atributos as $value){ ///Coloca os nomes dos atributos na string como elementos para substituição
				if($i == 0)
					$sqlAux .= ":".(string)$value; 
				else
					$sqlAux .= ", :".(string)$value;
				$i++;
			}
				
			$sqlAux .= ")";
			
			//echo $sqlAux;
			
			$stmt = $this->conn->prepare($sqlAux);
				
			$i = 0;
			foreach($valores as $value){ ///Substitui os valores na sentença SQL
				$strASubst = ":".$atributos[$i];
				$stmt->bindValue($strASubst, $valores[$i]);
					
				//echo "Substituindo ".$strASubst." por ".$valores[$i];
				$i++;
			}
				
			$stmt->execute();
				
			$this->conn->commit();
			//echo "\n".$stmt->queryString."\n";
		}
		catch(Exception $e) {
			echo $e;
			$this->conn->rollback();
		}
	}	

	///Compara se os atributos são IGUAIS aos VALORES
	public function excluirGenerico(String $tabela, Array $atributos, Array $valores) {
		$this->conn->beginTransaction();
			
		try {
			if(count($atributos) != count($valores)){
				throw new Exception('Não há a mesma quantidade de atributos e valores!');
			}
				
			$sqlAux = "DELETE FROM";
			$sqlAux .= " ".$tabela." WHERE "; ///Substitui o nome da tabela
			$tam = count($atributos);
			$i = 0;
			
			foreach($atributos as $value){
				$sqlAux .= (string)$value . " = " . ":".(string)$value;
				
				if($i != $tam-1) ///Não é o final
					$sqlAux .= " AND ";
					$i++;
				}
				
				//echo $sqlAux;
				
				$stmt = $this->conn->prepare($sqlAux);
				
				$i = 0;
				foreach($valores as $value){ ///Substitui os valores na sentença SQL
					$strASubst = ":".$atributos[$i];
					$stmt->bindValue($strASubst, $valores[$i]);
					
					//echo "Substituindo ".$strASubst." por ".$valores[$i];
					$i++;
				}
				
				$stmt->execute();
				
				$this->conn->commit();
				//echo "\n".$stmt->queryString."\n";
		}
		catch(Exception $e) {
			echo $e;
			$this->conn->rollback();
		}
	}

	
}

?>