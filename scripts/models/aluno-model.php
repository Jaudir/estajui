<?php

require_once('MainModel.php');

class AlunoModel extends MainModel{
    public function cadastrar($aluno){
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO usuario (email, senha, tipo) VALUES(?,?, ?)");
            $pstmt->execute(array($aluno->_login,Usuario::generateSenha($aluno->_senha), $aluno->_tipo));

            $pstmt = $this->conn->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
            $pstmt->execute(array($aluno->_logradouro, $aluno->_bairro, $aluno->_numero, $aluno->_complemento, $aluno->_cidade, $aluno->_uf, $aluno->_cep));

            $aluno->endereco_id = $this->conn->lastInsertId();

            $pstmt = $this->conn->prepare(" INSERT INTO aluno (nome, estado_natal, cidade_natal, data_nasc, nome_pai, nome_mae, estado_civil, sexo, rg_num, rg_orgao, cpf, telefone, celular, usuario_email, endereco_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pstmt->execute(array($aluno->_nome,$aluno->_estado_natal,$aluno->_cidade_natal,$aluno->_data_nasc,$aluno->_nome_pai,$aluno->_nome_mae,$aluno->_estado_civil,$aluno->_sexo,$aluno->_rg_num,$aluno->_rg_orgao,$aluno->_cpf,$aluno->_telefone,$aluno->_celular,$aluno->_login,$aluno->endereco_id));
            
            return $this->conn->commit();
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }
}