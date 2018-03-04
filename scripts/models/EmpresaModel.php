<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class EmpresaModel extends MainModel{
    private $tabela = "empresa";
    private $tabela1 = "responsavel";
    private $tabela2 = "endereco";
	
	public function create($empresa){
        $enderecoModel = $this->loader->loadModel('EnderecoModel', 'EnderecoModel');
        try{
            $this->conn->beginTransaction();

            $enderecoModel->create($empresa->get_endereco());

            echo $empresa->get_endereco()->getid() . '<br>';
            $stmt = $this->conn->prepare(
                'INSERT INTO `empresa`(
                    `cnpj`, 
                    `nome`, 
                    `telefone`, 
                    `fax`, 
                    `nregistro`, 
                    `conselhofiscal`, 
                    `endereco_id`, 
                    `conveniada`, 
                    `razao_social`) 
                    VALUES (
                        :cnpj,
                        :nome,
                        :telefone,
                        :fax,
                        :nregistro,
                        :conselhofiscal,
                        :endereco_id,
                        :conveniada,
                        :razao_social)');
            $stmt->execute(
                array(
                    ':cnpj' => $empresa->get_cnpj(),
                    ':nome' => $empresa->get_nome(),
                    ':telefone' => $empresa->get_telefone(),
                    ':fax' => $empresa->get_fax(),
                    ':nregistro' => $empresa->get_nregistro(),
                    ':conselhofiscal' => $empresa->get_conselhofiscal(),
                    ':endereco_id' => $empresa->get_endereco()->getid(),
                    ':conveniada' => 0,
                    ':razao_social' => $empresa->get_razaosocial()));

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }

    public function buscarConveniada($cnpj, $boolConveniada){
        try{
            $this->loader->loadDAO('Empresa');

            $stmt = $this->conn->prepare('SELECT * FROM empresa WHERE cnpj = :cnpj AND conveniada = :conveniada');
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->bindParam(':conveniada', $boolConveniada);
            $stmt->execute();
            $empresa = $stmt->fetchAll();

            if(count($empresa) > 0){
                $empresa = $empresa[0];
                return new Empresa($empresa['cnpj'], $empresa['nome'], $empresa['telefone'], $empresa['fax'], $empresa['cnpj'], $empresa['nregistro'], $empresa['conselhofiscal'], $empresa['endereco_id'], $empresa['conveniada'], $empresa['razao_social']);
            }
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }
	
    public function RecuperaDadosEmpresa($id) {    
        try {
            $this->loader->loadDAO('Empresa');
            $this->loader->loadDAO('Responsavel');
            $this->loader->loadDAO('Endereco');
            $pstmt = $this->conn->prepare("SELECT empresa.cnpj ,empresa.nome as empresanome,empresa.telefone as empresatelefone,
            empresa.razao_social ,empresa.fax ,empresa.nregistro ,empresa.conselhofiscal,
            responsavel.email , responsavel.nome as responsavelnome , responsavel.telefone as responsaveltelefone , 
            responsavel.cargo,endereco.logradouro,endereco.bairro,endereco.numero,endereco.complemento,
            endereco.cidade,endereco.uf,endereco.cep
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

    public function buscar($cnpj) {    
        try {
            $this->loader->loadDAO('Empresa');
            $this->loader->loadDAO('Responsavel');
            $this->loader->loadDAO('Endereco');
            $pstmt = $this->conn->prepare("SELECT empresa.cnpj ,empresa.nome as empresanome,empresa.telefone as empresatelefone,
            empresa.razao_social ,empresa.fax ,empresa.nregistro ,empresa.conselhofiscal,
            responsavel.email , responsavel.nome as responsavelnome , responsavel.telefone as responsaveltelefone , 
            responsavel.cargo,endereco.logradouro,endereco.bairro,endereco.numero,endereco.complemento,
            endereco.cidade,endereco.uf,endereco.cep
            FROM  empresa 
            LEFT JOIN responsavel on responsavel.empresa_cnpj = empresa.cnpj  
            LEFT JOIN endereco on endereco.id = empresa.endereco_id 
            WHERE empresa.cnpj = :cnpj");
            $pstmt->bindParam(':cnpj', $cnpj);
            $pstmt->execute();

            $empresa = $pstmt->fetchAll();

            if(count($empresa) == 1){
                $empresa = $empresa[0];
                return
                    new Empresa(
                        $empresa["cnpj"],
                        $empresa["empresanome"],
                        $empresa["empresatelefone"],
                        $empresa["fax"],
                        $empresa["nregistro"],
                        $empresa["conselhofiscal"],
                        new Endereco(
                            null,
                            $empresa["logradouro"],
                            $empresa["bairro"],
                            $empresa["numero"],
                            $empresa["complemento"],
                            $empresa["cidade"],
                            $empresa["uf"],
                            $empresa["cep"],
                            null),
                        new Responsavel(
                            $empresa["email"], 
                            $empresa["responsavelnome"],
                            $empresa["responsaveltelefone"], 
                            $empresa["cargo"], 
                            null),
                        null,
                        $empresa["razao_social"]);
            }
            return false;
            
        } catch (PDOExecption $e) {
            Log::LogPDOError($e);
            return false;
        }
    }
}

