<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class EmpresaModel extends MainModel{
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
}