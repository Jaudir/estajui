<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/dao/Aluno.php";

class AlunoModel extends MainModel {

    private $_tabela = "aluno";

    public function create($aluno) {
        $usuarioModel = $this->loadModel("UsuarioModel", "UsuarioModel");
        $result = $usuarioModel->create($aluno);
        if ($result) {
            $pstmt = $this->conn->prepare("INSERT INTO " . $this->$_tabela . " (cpf, nome, data_nasc, rg_num, rg_orgao, estado_civil, sexo, telefone, celular, nome_pai, nome_mae, cidade_natal, estado_natal, acesso, endereco_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,)");
            try {
                $this->conn->beginTransaction();
                $pstmt->execute(array($aluno->getcpf(), $aluno->getnome(), $aluno->getdata_nasc(), $aluno->getrg_num(), $aluno->getrg_orgao(), $aluno->getestado_civil(), $aluno->getsexo(), $aluno->gettelefone(), $aluno->getcelular(), $aluno->getnome_pai(), $aluno->getnome_mae(), $aluno->getcidade_natal(), $aluno->getestado_natal(), (int) $aluno->getacesso(), $aluno->getendereco()->getid()));
                $this->conn->commit();
                return 0;
            } catch (PDOExecption $e) {
                $this->conn->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return 2;
            }
        } else {
            return $result;
        }
    }

    public function read($cpf, $limite) {
        if ($limite == 0) {
            if ($cpf == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . " WHERE cpf LIKE :cpf");
                $pstmt->bindParam(':cpf', $cpf);
            }
        } else {
            if ($cpf == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . " WHERE cpf LIKE :cpf LIMIT :limite");
                $pstmt->bindParam(':cpf', $cpf);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $usuarioModel = $this->loadModel("UsuarioModel", "UsuarioModel");
                $user = $usuarioModel->read($row["usuario_email"], 1)[0];
                $result[$cont] = new Aluno($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["cpf"], $row["nome"], $row["data_nasc"], $row["rg_num"], $row["rg_orgao"], $row["estado_civil"], $row["sexo"], $row["telefone"], $row["celular"], $row["nome_pai"], $row["nome_mae"], $row["cidade_natal"], $row["estado_natal"], boolval($row["acesso"]), Endereco::read($row["endereco_id"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public static function readbyusuario(Usuario $user, $limite) {
        $key = $user->getlogin();
        if ($this->conn) {
            if ($limite == 0) {
                if ($user == NULL) {
                    $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . "");
                } else {
                    $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . " WHERE usuario_email LIKE :usuario_email");
                    $pstmt->bindParam(':usuario_email', $key);
                }
            } else {
                if ($user == NULL) {
                    $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . " LIMIT :limite");
                } else {
                    $pstmt = $this->conn->prepare("SELECT * FROM " . $this->$_tabela . " WHERE usuario_email LIKE :usuario_email LIMIT :limite");
                    $pstmt->bindParam(':usuario_email', $key);
                }
                $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            }
            try {
                $pstmt->execute();
                $cont = 0;
                $result = [];
                while ($row = $pstmt->fetch()) {
                    $result[$cont] = new Aluno($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["cpf"], $row["nome"], $row["data_nasc"], $row["rg_num"], $row["rg_orgao"], $row["estado_civil"], $row["sexo"], $row["telefone"], $row["celular"], $row["nome_pai"], $row["nome_mae"], $row["cidade_natal"], $row["estado_natal"], boolval($row["acesso"]), Endereco::read($row["endereco_id"], 1)[0]);
                    $cont++;
                }
                return $result;
            } catch (PDOExecption $e) {
                #return "Error!: " . $e->getMessage() . "</br>";
                return 2;
            }
        } else {
            return 1;
        }
    }

    public function update(Aluno $aluno) {
        $pstmt = $this->conn->prepare("UPDATE " . $aluno->$_tabela . " SET cpf=?, nome=?, data_nasc=?, rg_num=?, rg_orgao=?, estado_civil=?, sexo=?, telefone=?, celular=?, nome_pai=?, nome_mae=?, cidade_natal=?, estado_natal=?, acesso=?, endereco_id=? WHERE cpf = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($aluno->getcpf(), $aluno->getnome(), $aluno->getdata_nasc(), $aluno->getrg_num(), $aluno->getrg_orgao(), $aluno->getestado_civil(), $aluno->getsexo(), $aluno->gettelefone(), $aluno->getcelular(), $aluno->getnome_pai(), $aluno->getnome_mae(), $aluno->getcidade_natal(), $aluno->getestado_natal(), (int) $aluno->getacesso(), $aluno->getendereco()->getid(), $aluno->getcpf()));
            $this->conn->commit();
            $usuarioModel = $this->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->update($aluno);
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Aluno $aluno) {
        $pstmt = $this->conn->prepare("DELETE from " . $aluno->$_tabela . " WHERE cpf LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($aluno->getcpf()));
            $this->conn->commit();
            $usuarioModel = $this->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->delete($aluno);
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }
}
