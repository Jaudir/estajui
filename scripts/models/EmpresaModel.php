<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Empresa.php";

class EmpresaModel extends MainModel {
    private $tabela = "empresa";
    private $tabela1 = "responsavel";
    private $tabela2 = "endereco";
    public function RecuperaDadosEmpresa($id) {    
        try {
            $pstmt = $this->conn->prepare("SELECT empresa.cnpj ,empresa.nome as empresanome,empresa.telefone as empresatelefone,
            empresa.razao_social ,empresa.fax ,empresa.nregistro ,empresa.conselhofiscal,
            responsavel.email , responsavel.nome as responsavelnome , responsavel.telefone as responsaveltelefone , 
            responsavel.cargo,endereco.logradouro,endereco.bairro,endereco.numero,endereco.complemento,
            endereco.cidade,endereco.uf,endereco.cep, endereco.sala
            FROM  empresa 
            JOIN responsavel on responsavel.empresa_cnpj = empresa.cnpj  
            JOIN endereco on endereco.id = empresa.endereco_id 
            WHERE empresa.cnpj LIKE :cnpj");
            
            $pstmt->bindParam(':cnpj', $id);
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $result[$cont++] = new Empresa($row["cnpj"],$row["empresanome"],$row["empresatelefone"],$row["razao_social"],$row["fax"],$row["nregistro"],$row["conselhofiscal"],null,null);
                $result[$cont++] = new Responsavel($row["email"], $row["responsavelnome"], $row["responsaveltelefone"], $row["cargo"], null);
                $result[$cont++] = new Endereco(null,$row["logradouro"],$row["bairro"],$row["numero"],$row["complemento"],$row["cidade"],$row["uf"],$row["cep"],$row["sala"]);
            }
            if($cont == 0) return null;
            else return $result;
        } catch (PDOExecption $e) {
            return null;
        }
    }
}



