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
            $_empresa = $empresaModel->buscarConveniada($empresa->get_cnpj(), false);
            $_responsavel = $responsavelModel->read($responsavel);
        
            $this->conn->beginTransaction();

            //pré-cadastra empresa caso não esteja cadastrada
            if(!$_empresa){
                $empresaModel->create($empresa);
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
                    ':estagio' => $plano->get_estagio()->getid(),
                    ':atividades' => $plano->get_atividades(),
                    ':data_ini' => $plano->get_data_inicio(),
                    ':data_fim' => $plano->get_data_fim(),
                    ':hora_inicio1' => $plano->get_hora_inicio1(),
                    ':hora_fim1' => $plano->get_hora_fim1(),
                    ':total_horas' => $plano->get_total_horas()));

            //atualiza o status do modafoquing dark night
            $statusModel->adicionaNotificacao(StatusModel::$AGURDANDO_DEF, $plano->get_estagio(), $usuario);

            $this->conn->commit();
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }
}