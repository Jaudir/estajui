<?php

require_once('MainModel.php');

class AlunoModel extends MainModel
{
    public function cadastrar($aluno)
    {
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO usuario (email, senha, tipo) VALUES(?,?, ?)");
            $pstmt->execute(array($aluno->getlogin(),Usuario::generateSenha($aluno->getsenha()), $aluno->gettipo()));

            $pstmt = $this->conn->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
            $pstmt->execute(array($aluno->endereco->getlogradouro(), $aluno->endereco->getbairro(), $aluno->endereco->getnumero(), $aluno->endereco->getcomplemento(), $aluno->endereco->getcidade(), $aluno->endereco->getuf(), $aluno->endereco->getcep()));

            $aluno->setendereco_id($this->conn->lastInsertId());

            $pstmt = $this->conn->prepare(" INSERT INTO aluno (nome, estado_natal, cidade_natal, data_nasc, nome_pai, nome_mae, estado_civil, sexo, rg_num, rg_orgao, cpf, telefone, celular, usuario_email, endereco_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pstmt->execute(array($aluno->getnome(),$aluno->getestado_natal(),$aluno->getcidade_natal(),$aluno->getdata_nasc(),$aluno->getnome_pai(),$aluno->getnome_mae(),$aluno->getestado_civil(),$aluno->getsexo(),$aluno->getrg_num(),$aluno->getrg_orgao(),$aluno->getcpf(),$aluno->gettelefone(),$aluno->getcelular()
            ,$aluno->getlogin(),$aluno->getendereco_id()));

            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }


    public function VerificaLoginCadastrado($email)
    {
        try {
            $pstmt = $this->conn->prepare("SELECT id from usuario WHERE email LIKE :email");
            $pstmt->bindParam(':email', $email);
            $pstmt->execute();
            if ($pstmt->fetch() == null) {
                return false;
            }
            return true;
        } catch (PDOExecption $e) {
            return false;
        }
    }
}
