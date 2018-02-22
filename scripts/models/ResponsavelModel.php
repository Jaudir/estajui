<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class ResponsavelModel extends MainModel{
    public function create($responsavel){
        try{
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare('INSERT INTO responsavel (email, nome, telefone, cargo, empresa_cnpj, aprovado) VALUES(:email, :nome, :telefone, :cargo, :empresa_cnpj, :aprovado)');
            $stmt->execute(
                array(
                    ':email' => $responsavel->get_email(),
                    ':nome' => $responsavel->get_nome(),
                    ':telefone' => $responsavel->get_telefone(),
                    ':cargo' => $responsavel->get_cargo(),
                    ':empresa_cnpj' => $responsavel->get_empresa()->get_cnpj(),
                    ':aprovado' => 0));

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }

    public function read($responsavel){
        try{
            $this->loader->loadDAO('Responsavel');

            $stmt = $this->conn->prepare('SELECT * FROM responsavel WHERE email = :email');
            $stmt->execute(array(':email' => $responsavel->get_email()));

            $responsavel = $stmt->fetchAll();

            if(count($responsavel) > 0){
                $responsavel = $responsavel[0];
                return new Responsavel($responsavel['email'], $responsavel['nome'], $responsavel['telefone'], $responsavel['cargo'], $responsavel['empresa_cnpj'], $responsavel['aprovado']);
            }
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }
}