<?php
/**
 * Created by PhpStorm.
 * User: Luciano Oliva
 * Date: 04/03/2018
 * Time: 22:40
 */

require_once(dirname(__FILE__) . '/../base-controller.php');



$session = getSession();
if($session->isce()) {
    $session->clearErrors();
    // Criar o objeto com as informações da sessão
    $ce = $session->getUsuario('usuario');
    $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
    $ce = $model->read($ce->getsiape(), 1)[0];
    if (isset($_POST['apolice_numero']) && isset($_POST['estagio_id']) && isset($_POST['apolice_seguradora'])){
        $apoliceModel = $loader->loadModel('ApoliceModel', 'ApoliceModel');
        $apolice = new Apolice($_POST['apolice_numero'], $_POST['apolice_seguradora']);
        $retorno = $apoliceModel->create($apolice, $_POST['estagio_id']);

    }
}