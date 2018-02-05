<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class CoordExtModel extends MainModel{
    //verifica se uma empresa já foi pré cadastrada
    public function verificaPreCadastro($cnpj){
        $st = $this->conn->prepare("select conveniada from empresa where cnpj = $cnpj");
        if(!$st->execute()){
            Log::LogPDOError($st->errorInfo(), true);
            return false;
        }

        $data = $st->fetchAll();
        if(count($data) > 0){
            return ($data[0]['conveniada'] == 1);
        }

        return false;
    }

    //altera a situação de uma empresa conveniada e notifica os alunos em estágios associados
    public function alterarConvenio($veredito, $justificativa, $cnpj){

        /*Listar estagios associados*/
        $estagios = $this->listarEstagiosEmpresa($cnpj);
        if(!$estagios)
            return false;

        //listar alunos que estão no estagio associado
        $alunos = array();
        foreach($estagios as $estagio){
            $alunos = array_merge($alunos, $this->listarAlunoEstagio($estagio['aluno_cpf']));
        }

        if($this->conn->beginTransaction()){
            $this->conn->exec("update empresa set conveniada = true where cnpj = $cnpj");

            //notificar todos os alunos
            foreach($alunos as $aluno){
                $this->conn->exec("");
            }

            if(!$this->conn->commit()){
                return false;
            }
        }else{
            return false;
        }

        return true;
    }

    /*Lista status de todos os estágios*/
    public function listaEstagios(){
        $st = $this->conn->prepare('select status.descricao as descricao, curso.nome as nome from estagio inner join status on status.codigo == estagio.status_codigo inner join curso on estagio.curso_id == curso.id');
        if(!$st->execute()){
            //log?
            return false;
        }

        return $st->fetchAll();
    }

    /*Lista empresas que estão aguardando aprovação do convênio*/
    public function listaEmpresas(){
        $st = $this->conn->prepare(
            'select 
            endereco.*,
            empresa.*,
            responsavel.nome as resp_nome, responsavel.email as resp_email, responsavel.telefone as resp_tel, responsavel.cargo as resp_cargo
            from empresa 
            inner join endereco on endereco.id = empresa.endereco_id 
            left join responsavel on responsavel.empresa_cnpj = empresa.cnpj
            where conveniada = 0');
        if(!$st->execute()){
            //log?
            return false;
        }

        return $st->fetchAll();
    }
}

?>