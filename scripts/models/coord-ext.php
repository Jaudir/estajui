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

    //altera a situação de uma empresa conveniada
    public function alterarConvenio($veredito, $justificativa, $cnpj){
        $st = $this->conn->prepare("update empresa set conveniada = true where cnpj = $cnpj");
        return $st->execute();
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
        $st = $this->conn->prepare('select * from empresa inner join endereco on endereco.id = empresa.endereco_id where conveniada = 0');
        if(!$st->execute()){
            //log?
            return false;
        }

        return $st->fetchAll();
    }
}

?>