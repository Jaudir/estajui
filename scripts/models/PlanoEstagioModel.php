<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class PlanoEstagioModel extends MainModel{
    public function create($plano, $supervisor, $responsavel, $empresa, $usuario){
        $empresaModel = $this->loader->loadModel('EmpresaModel', 'EmpresaModel');
        $responsavelModel = $this->loader->loadModel('ResponsavelModel', 'ResponsavelModel');
        $supervisorModel = $this->loader->loadModel('SupervisorModel', 'SupervisorModel');
        $statusModel = $this->loader->loadModel('StatusModel', 'StatusModel');

        try{
            //verifica se a empresa já existe
            $_empresa = $empresaModel->buscarConveniada($empresa->getcnpj(), 0);
            $_responsavel = $responsavelModel->read($responsavel->getemail(), 1);
        
            $this->conn->beginTransaction();

            //pré-cadastra empresa caso não esteja cadastrada
            if(!$_empresa){
                $empresaModel->cadastrar($empresa);
            }else{
                $empresa = $_empresa;
            }

            //cadastra responsável caso não esteja cadastrado
            if(!$_responsavel){
                $responsavelModel->create($responsavel);
            }else{
                $responsavel = $_responsavel;
            }

            //sempre cadastra um novo supervisor :SSSSS
            $supervisorModel->create($supervisor);

            $stmt = $this->conn->prepare(
                'INSERT INTO `plano_estagio`(
                    `estagio_id`,
                    `atividades`,
                    `data_ini`, 
                    `data_fim`, 
                    `hora_inicio1`,
                    `hora_fim1`,
                    `total_horas`) 
                    VALUES (
                        :estagio,
                        :atividades,
                        :data_ini,
                        :data_fim,
                        :hora_inicio1,
                        :hora_fim1,
                        :total_horas)');

            $stmt->execute(
                array(
                    ':estagio' => $plano->getestagio()->getid(),
                    ':atividades' => $plano->getatividades(),
                    ':data_ini' => $plano->getdata_inicio(),
                    ':data_fim' => $plano->getdata_fim(),
                    ':hora_inicio1' => $plano->gethora_inicio1(),
                    ':hora_fim1' => $plano->gethora_fim1(),
                    ':total_horas' => $plano->gettotal_horas()));

            //atualiza o status do modafoquing dark night
            $statusModel->adicionaNotificacao(StatusModel::$AGURDANDO_DEF, $plano->getestagio(), $usuario);

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }
}