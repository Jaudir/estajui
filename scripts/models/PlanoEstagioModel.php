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

    public function carregarAguardandoOrientador(){
        try{
            $estagioModel = $this->loader->loadModel('EstagioModel', 'EstagioModel');
            $this->loader->loadDao('PlanoDeEstagio');

            $stmt = $this->conn->prepare("SELECT plano_estagio.* FROM estagio JOIN plano_estagio ON estagio.id = plano_estagio.estagio_id WHERE po_siape is NULL");
            $stmt->execute();

            $estagios = $stmt->fetchAll();

            $estagiosDAOs = array();
            foreach($estagios as &$estagio){
                $plano = new PlanoDeEstagio(
                    $estagio['setor_unidade'], 
                    $estagioModel->recuperar($estagio['estagio_id']),
                    $estagio['data_assinatura'],
                    $estagio['atividades'],
                    $estagio['remuneracao'],
                    $estagio['vale_transporte'],
                    $estagio['data_ini'],
                    $estagio['data_fim'],
                    $estagio['hora_inicio1'],
                    $estagio['hora_inicio2'],
                    $estagio['hora_fim1'],
                    $estagio['hora_fim2'],
                    $estagio['total_horas'],
                    $estagio['data_efetivacao'],
                    null
                );
                $estagiosDAOs[] = $plano;
            }
            return $estagiosDAOs;
        }catch(PDOException $ex){
            echo "AQUI<br>";
            Log::LogPDOError($ex);
            return false;
        }
    }
}