<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Empresa.php";

class EmpresaModel extends MainModel {

    private $_tabela = "empresa";
    private $tabela1 = "responsavel";
    private $tabela2 = "endereco";

    public function buscarConveniada($cnpj, $boolConveniada) {
        try {
            $this->loader->loadDAO('Empresa');

            $stmt = $this->conn->prepare('SELECT * FROM empresa WHERE cnpj = :cnpj AND conveniada = :conveniada');
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->bindParam(':conveniada', $boolConveniada);
            $stmt->execute();
            $empresa = $stmt->fetchAll();

            if (count($empresa) > 0) {
                $empresa = $empresa[0];
                return new Empresa($empresa['cnpj'], $empresa['nome'], $empresa['telefone'], $empresa['fax'], $empresa['cnpj'], $empresa['nregistro'], $empresa['conselhofiscal'], $empresa['endereco_id'], $empresa['conveniada'], $empresa['razao_social']);
            }
        } catch (PDOException $ex) {
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
                $result[$cont++] = new Empresa($row["cnpj"], $row["empresanome"], $row["empresatelefone"], $row["razao_social"], $row["fax"], $row["nregistro"], $row["conselhofiscal"], null, null);

                $result[$cont++] = new Responsavel($row["email"], $row["responsavelnome"], $row["responsaveltelefone"], $row["cargo"], null);
                $result[$cont++] = new Endereco(null, $row["logradouro"], $row["bairro"], $row["numero"], $row["complemento"], $row["cidade"], $row["uf"], $row["cep"], $row["sala"]);
            }
            if ($cont == 0)
                return null;
            else
                return $result;
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
                            null,
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

    public function create(Empresa $empresa) {
        //deveria registrar o endereço!!!
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (cnpj, nome, razao_social, telefone, fax, nregistro, conselhofiscal, endereco_id, conveniada) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($empresa->getcnpj(), $empresa->getnome(), $empresa->getrazaosocial(), $empresa->gettelefone(), $empresa->getfax(), $empresa->getnregistro(), $empresa->getconselhofiscal(), $empresa->getendereco()->getid(), (int) $empresa->getconveniada()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function cadastrar($empresa){
        $enderecoModel = $this->loader->loadModel('EnderecoModel', 'EnderecoModel');
        try{
            $this->conn->beginTransaction();
            $enderecoModel->create($empresa->getendereco());
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
                    ':cnpj' => $empresa->getcnpj(),
                    ':nome' => $empresa->getnome(),
                    ':telefone' => $empresa->gettelefone(),
                    ':fax' => $empresa->getfax(),
                    ':nregistro' => $empresa->getnregistro(),
                    ':conselhofiscal' => $empresa->getconselhofiscal(),
                    ':endereco_id' => $empresa->getendereco()->getid(),
                    ':conveniada' => 0,
                    ':razao_social' => $empresa->getrazaosocial()));
            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }

    public function read($cnpj, $limite) {
        if ($limite == 0) {
            if ($cnpj == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE cnpj = :cnpj");
                $pstmt->bindParam(':cnpj', $cnpj);
            }
        } else {
            if ($cnpj == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE cnpj = :cnpj LIMIT :limite");
                $pstmt->bindParam(':cnpj', $cnpj);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $this->conn->beginTransaction();
            $pstmt->execute();
            $this->conn->commit();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $enderecoModel = $this->loader->loadModel("EnderecoModel", "EnderecoModel");
                $responsavelModel = $this->loader->loadModel("ResponsavelModel", "ResponsavelModel");
                $result[$cont] = new Empresa($row["cnpj"], $row["nome"], $row["telefone"], $row["fax"], $row["nregistro"], $row["conselhofiscal"], $enderecoModel->read($row["endereco_id"], 1)[0], null, boolval($row["conveniada"]), $row["razao_social"]);
                $result[$cont]->setresponsavel($responsavelModel->readbyempresa($result[$cont], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Empresa $empresa) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET cnpj=?, nome=?, razao_social=?, telefone=?, fax=?, nregistro=?, conselhofiscal=?, endereco_id=?, conveniada=? WHERE cnpj = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($empresa->getcnpj(), $empresa->getnome(), $empresa->getrazao_social(), $empresa->gettelefone(), $empresa->getfax(), $empresa->getnregistro(), $empresa->getconselhofiscal(), $empresa->getendereco()->getid(), (int) $empresa->getconveniada(), $empresa->getcnpj()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Empresa $empresa) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE cnpj LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($empresa->getcnpj()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
