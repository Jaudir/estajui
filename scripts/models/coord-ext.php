<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class CoordExtModel extends MainModel{
    //verifica se uma empresa já foi pré cadastrada
    public function verificaPreCadastro($cnpj){
        try{
            $st = $this->conn->prepare("select conveniada from empresa where cnpj = $cnpj");
            $st->execute();

            $data = $st->fetchAll();
            if(count($data) > 0){
                return ($data[0]['conveniada'] != 0);
            }
        }catch(PDOException $ex){            
            Log::LogPDOError($ex, true);
            return false;
        }
        return true;
    }

    //altera a situação de uma empresa conveniada e notifica os alunos em estágios associados
    public function alterarConvenio($veredito, $justificativa, $cnpj){
        try{
            $status_codigo = $veredito == 1 ? 11 : 12;//tipo de status baseado na aceitação ou não da empresa

            /*Carregar alunos de estágios associados que devem ser notificados desta ação*/
            $stmt = $this->conn->prepare(
                "select * from estagio
                JOIN aluno ON aluno.cpf = estagio.aluno_cpf
                JOIN usuario ON aluno.usuario_email = usuario.email
                where empresa_cnpj = $cnpj");
            $stmt->execute();

            $alunos = $stmt->fetchAll();
            if(count($alunos) == 0){
                Log::LogError("Empresa não tem estágios associados", true);//não tem estágios associados, ou alunos associados aos estágios ??
            }

            //inserção dos dados

            $this->conn->beginTransaction();

            $this->conn->exec("update empresa set conveniada = $veredito where cnpj = $cnpj");

            //notificar todos os alunos
            foreach($alunos as $aluno){
                $estagio_id = $aluno['id'];
                $email = $aluno['email'];

                $this->conn->exec("insert into modifica_status(data, estagio_id, status_codigo, usuario_email) values(now(), '$estagio_id', '$status_codigo', '$email')");
                $last_id = $this->conn->lastInsertId();
                $this->conn->exec("insert into notificacao(lida, modifica_status_id) values(0, $last_id)");
            }

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex, true);
            $this->conn->rollback();
            return false;
        }
        return true;
    }

    /*Lista status de todos os estágios*/
    public function listaEstagios(){
        //listar estágios aqui
        return array();
    }

    /*Lista empresas que estão aguardando aprovação do convênio*/
    public function listaEmpresas(){
        try{
            $st = $this->conn->prepare(
                'select 
                endereco.*,
                empresa.*,
                responsavel.nome as resp_nome, responsavel.email as resp_email, responsavel.telefone as resp_tel, responsavel.cargo as resp_cargo
                from empresa 
                inner join endereco on endereco.id = empresa.endereco_id 
                left join responsavel on responsavel.empresa_cnpj = empresa.cnpj
                where conveniada = 0');
            $st->execute();
            return $st->fetchAll();
        }catch(PDOException $ex){
            Log::LogPDOError($ex, true);
            return false;
        }
    }
}

?>