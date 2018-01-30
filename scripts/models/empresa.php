<?php

require_once('MainModel.php');

class EmpresaModel extends MainModel{
    public function verificaPreCadastro($cnpj){
        $st = $this->conn->prepare('select cnpj from empresa where id = $cnpj');
        if(!$st->execute()){
            error_log('DB error: ' . $st->errorCode() . '', 0);
            return false;
        }

        return count($st->fetchAll()) > 0;
    }

    //altera a situação de uma empresa conveniada
    public function alterarConvenio($veredito, $justificativa){
        $st = $this->conn->prepare('update ');
        return $st->execute();
    }
}

?>