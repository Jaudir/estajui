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

	public function recuperar($aluno)
	{
		try {
            $pstmt = $this->conn->prepare("SELECT * FROM aluno JOIN endereco ON endereco.id=aluno.endereco_id JOIN usuario ON aluno.usuaio_email=usuario.email WHERE aluno.cpf=?");
            $pstmt->execute($aluno->getcpf());
			$res = $pstmt->fetchAll();
			
			if(count($res)==0)
				return false;
			
			$endereco = new Endereco($res['id'], $res['logradouro'], $res['bairro'], $res['numero'], $res['complemento'], $res['cidade'], $res['uf'], $res['cep']);
			$aluno = new Aluno($res['usuario_email'], $res['senha'], $res['tipo'], $res['cpf'], $res['nome'], $res['data_nasc'], $res['rg_num'], $res['rg_orgao'],
							   $res['estado_civil'], $res['sexo'], $res['telefone'], $res['celular'], $res['nome_pai'], $res['nome_mae'], $res['cidade_natal'],
							   $res['estado_natal'], $res['acesso'], $endereco );
			
			return $aluno;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }	
	}
	
	public function atualizar($aluno)
	{
		try {
			$pstmt = $this->conn->prepare("UPDATE usuario SET senha=? WHERE email=?");
			$pstmt->execute($aluno->getsenha(), $aluno->getemail());
			
			$pstmt = $this->conn->prepare("UPDATE endereco SET logradouro=?, bairro=?, numero=?, complemento=?, cidade=?, uf=?, cep=? WHERE id=?");
			$pstmt->execute($endereco->getlogradouro(), $endereco->getbairro(), $endereco->getnumero(), $endereco->getcomplemento(), $endereco->getcidade(), $endereco->getuf(), 
							$endereco->getcep(), $endereco->getid());
			
            $pstmt = $this->conn->prepare("UPDATE aluno SET nome=?, rg_orgao=?, estado_civil=?, sexo=?, telefone=?, celular=?, nome_pai=?, nome_mae=?, cidade_natal=?, estado_natal=?,
										  WHERE cpf=?");
            $pstmt->execute($aluno->getnome(), $aluno->getrg_orgao(), $aluno->getestado_civil(), $aluno->getsexo(), $aluno->gettelefone(), $aluno->getcelular(), $aluno->getnome_pai(),
							$aluno->getnome_mae(), $aluno->getcidade_natal(), $aluno->getestado_natal(), $aluno->getcpf());
			
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
