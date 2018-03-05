<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/HomeController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Página inicial | <?php echo $titulo ?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="../assets/css/icons/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/main.css">
    </head>
    <body>
        <div class="container-home container-fluid fullscreen">
            <nav class="navbar navbar-expand-lg navbar-light nav-menu">
                <a class="navbar-brand" href="#">
                    <img src="../assets/img/LOGO.PNG" height="42" class="d-inline-block align-top" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="nav-content navbar-nav">
                        <li>
                            <span class="navbar-text">
                                <?php echo $nome ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="btn nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                                    <span class="notification"> <?php echo count($notificacoes) ?> </span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <?php
                                    foreach ($notificacoes as $notificacao) {
                                        if (!$notificacao->getlida()) {
                                            ?>
                                            <a class="dropdown-item" href="#estagio<?php echo $notificacao->getmodificacao_status()->getestagio()->getid(); ?>">
                                                Novo status:<br>
                                                <?php echo $notificacao->getmodificacao_status()->getstatus()->getdescricao(); ?>
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <form method="get">
                                <button type="submit" name="logoff" class="btn btn-outline-light bt-sair">Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="row fullscreen">
                <div class="col-lg-2 left-menu">
                    <ul class="nav flex-column">

                        <!--Comum a todos-->
                        <li class="nav-item">
                            <a class="nav-link active" href="home.php">Home</a>
                        </li>

                        <!--Estudante-->
                        <?php
                        if (is_a($usuario, "Aluno")) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="estudante/alterar-dados-pessoais.php">Meus dados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="estudante/historico.php">Histórico de estágios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Orientações gerais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"  data-toggle="modal" data-target="#modalNovoEstagio" >+ Novo estágio</a>
                            </li>
                            <?php
                        }
                        ?>



                        <!--ROOT, CE-->
                        <?php
                        if (is_a($usuario, "Funcionario")) {
                            if ($usuario->isroot() || $usuario->isce()) {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="coordenador-extensao/usuarios.php">Usuários</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Empresas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Cursos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Campi</a>
                                </li>
                                <?php
                            }
                        }
                        ?>


                        <!--OE-->
                        <?php
                        if (is_a($usuario, "Funcionario")) {
                            if ($usuario->isoe()) {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Professores</a>
                                </li>
                                <?php if ($usuario->ispo() || $usuario->isce()) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Relatórios</a>
                                    </li>
                                    <?php
                                }
                            }
                        }
                        ?>

                    </ul>
                </div>
                <!--Coordenador de extensão-->
                <?php
                if (is_a($usuario, "Funcionario")) {
                    if ($usuario->isce()) {
                        ?>
                        <div class="col-lg-10 status-desc">
                            <div class="row table-estagios">
                                <div class="offset-lg-1 col-lg-10 table-title">
                                    <h3 class="bg-gray"> Todos os estágios </h3>
                                </div>
                                <div class="offset-lg-1 col-lg-10">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Data início</th>
                                                <th scope="col">Curso</th>
                                                <th scope="col">Editar</td>
                                                <th scope="col">Ver</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $row_id = 1;
                                            foreach ($estagios as $le):
                                                if ($le->getstatus()->getcodigo() == 4 /* || $le->getstatus()->getcodigo() == 7 */) {
                                                    ?>
                                                    <tr class="">
                                                        <th scope="row"><input type="hidden" value="<?php echo $le->getid(); ?>" class="form-control" id="estagioID<?php echo $row_id; ?>"><?php echo $row_id; ?></th>
                                                        <td><?php echo $le->getstatus()->getdescricao(); ?></td>
                                                        <td><?php echo $le->getpe()->getdata_inicio(); ?></td>
                                                        <td><?php echo $le->getmatricula()->getoferta()->getcurso()->getnome(); ?></td>
                                                        <td class="center">
                                                            <button type="button" class="btn btn-link empresaModalToggle"
                                                                    onclick="setarId('<?php echo "estagioID" . $row_id++; ?>')" data-toggle="modal" data-target="<?php
                                                                    if ($le->getstatus()->getcodigo() == 4) {
                                                                        echo "#apoliceSeguro";
                                                                    } else {
                                                                        echo "#aprovarConvenio";
                                                                    }
                                                                    ?>" >
                                                                <i class="fa fa-pencil"></i>
                                                            </button>

                                                        </td>
                                                        <td class="center">
                                                            <a href="" onclick="preencherModal(<?php echo $le->getid(); ?>)" data-toggle="modal" data-target="#ver-estagio" id="ver<?php echo $lin++; ?>"> <i class="fa fa-eye ver"></i></a>
                                                        </td>
                                                    </tr>

                                                <?php } endforeach; ?>

                                            <?php
                                            foreach ($statusEmpresas as $empresa):
                                                ?>
                                                <tr class="red">
                                                    <th scope="row"><?php echo $row_id++; ?></th>
                                                    <td>Aguardando aprovação de convênio</td>
                                                    <td><?php echo "-" ?></td>
                                                    <td><?php echo "-" ?></td>
                                                    <td class="center">
                                                        <button type="button" class="btn btn-link empresaModalToggle"
                                                                data-toggle="modal" data-target="#aprovarConvenio">
                                                            <i class="fa fa-pencil"></i>
                                                            <div class="empresaDados" style="display:none;">
                                                                <h6>Razão Social: </h6> <p><?php echo $empresa->getrazaosocial() ?></p><br>
                                                                <h6>CNPJ: </h6> <p class="cnpj"><?php echo $empresa->getcnpj() ?></p><br>
                                                                <h6>Nome fantasia: </h6> <p><?php echo $empresa->getnome() ?></p> <br>
                                                                <h6>Telefone: </h6> <p><?php echo $empresa->gettelefone() ?></p> <br>
                                                                <h6>FAX: </h6> <p><?php echo $empresa->getfax() ?></p> <br>
                                                                <h6>Registro: </h6> <p><?php echo $empresa->getnregistro() ?></p> <br>
                                                                <h6>Conselho de fiscalização: </h6> <p><?php echo $empresa->getconselhofiscal() ?></p> <br>
                                                                <h6>Nome do responsável: </h6> <p><?php echo $empresa->getresponsavel()->getnome() ?></p> <br>
                                                                <h6>Telefone do responsável: </h6> <p><?php echo $empresa->getresponsavel()->gettelefone() ?></p> <br>
                                                                <h6>Email: </h6> <p><?php echo $empresa->getresponsavel()->getemail() ?></p> <br>
                                                                <h6>Cargo: </h6> <p><?php echo $empresa->getresponsavel()->getcargo() ?></p> <br>
                                                                <h6>Logradouro: </h6> <p><?php echo $empresa->getendereco()->getlogradouro() ?></p> <br>
                                                                <h6>Número: </h6> <p><?php echo $empresa->getendereco()->getnumero() ?></p> <br>
                                                                <h6>Sala: </h6> <p><?php echo $empresa->getendereco()->getsala() ?></p> <br>
                                                                <h6>Bairro: </h6> <p><?php echo $empresa->getendereco()->getbairro() ?></p><br>
                                                                <h6>Cidade: </h6> <p><?php echo $empresa->getendereco()->getcidade() ?></p><br>
                                                                <h6>Estado: </h6> <p><?php echo $empresa->getendereco()->getuf() ?></p><br>
                                                                <h6>CEP: </h6> <p><?php echo $empresa->getendereco()->getcep() ?></p>
                                                            </div>
                                                        </button>
                                                    </td>
                                                    <td class="center"><a href="#"> <i class="fa fa-eye"></i> </a></td>
                                                </tr>

                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal para aprovar o convênio da empresa -->
                        <div class="modal fade" id="aprovarConvenio" tabindex="-1" role="dialog" aria-labelledby="aprovarConvenioTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aprovarConvenioTitle">Dados da empresa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 dados-aluno" id="empresaDadosInModal">
                                                <table class="table table-bordered" id="tabela_modal_editar_aprov">
                                                    <tbody>
                                                        <!-- BODY Não digite nada aqui -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <form name="convenio" id="empresaForm" method="post" action="<?php echo base_url() . '/scripts/controllers/coordenador-extensao/validar-cadastro-empresa.php' ?>">
                                            <input type="hidden" id="ecnpj" name="cnpj" value="">
                                            <div class="form-group">
                                                <div class="custom-controls-stacked d-block my-3" style="margin-top: 10px;">
                                                    <label class="custom-control custom-radio">
                                                        <input id="radioStacked1" name="veredito" value="1" type="radio" class="custom-control-input" required>
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Aprovado</span>
                                                    </label>
                                                    <label class="custom-control custom-radio" style="margin-left: 20px;">
                                                        <input id="radioStacked2" name="veredito" value="0" type="radio" class="custom-control-input" required>
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Reprovado</span>
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="justificativa">Justificativa</label>
                                                        <textarea placeholder="Só será usada em caso de reprovação." name="justificativa" rows="3" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                        <button type="button" id="enviarFormEmpresa" class="btn btn-primary">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para inserir ápolice de seguro -->
                        <div class="modal fade" id="apoliceSeguro" tabindex="-1" role="dialog" aria-labelledby="apoliceSeguroTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="apoliceSeguroTitle">Ápolice Seguro</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 dados-aluno">
                                                <div class="modal-body">
                                                    <table class="table table-bordered" id="tabela_modal_editar">
                                                        <tbody>
                                                            <!-- BODY Não digite nada aqui -->
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                        <form name="convenio">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom01">Nº da apólice</label>
                                                        <input type="text" class="form-control" id="validationCustom01" required>
                                                        <div class="invalid-feedback">
                                                            Por favor, informe um número válido.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom02">Nome da seguradora</label>
                                                        <input type="text" class="form-control" id="validationCustom02" required>
                                                        <div class="invalid-feedback">
                                                            Por favor, informe uma seguradora.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="preencherDadosApolice()">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--MODAL de destalhes do estágio -->
                    <div class="modal fade" id="ver-estagio" tabindex="-1" role="dialog" aria-labelledby="detalhesEstagioTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detalhesEstagioTitle">Detalhes do estágio</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered" id="tabela_modal">
                                        <tbody>
                                            <!-- BODY -->
                                        </tbody>
                                    </table>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                    <button type="button" class="btn btn-primary">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <!--Professor orientador-->
        <!--"Wadson,aqui"-->
        <?php
        if (is_a($usuario, "Funcionario")) {
            if ($usuario->ispo()) {
                ?>
                <?php
            }
        }
        ?>
        <!--Organizador de estágio-->
        <?php
        if (is_a($usuario, "Funcionario")) {
            if ($usuario->isoe()) {
                ?>
                <div class="col-lg-10 status-desc">
                    <div class="row table-estagios">
                        <div class="offset-lg-1 col-lg-10 table-title">
                            <h3 class="bg-gray"> Todos os estágios</h3>
                        </div>
                        <div class="offset-lg-1 col-lg-10">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Data início</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Editar</td>
                                        <th scope="col">Ver</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($estagios as &$estagio):
                                        ?>
                                        <?php $aluno = $estagio->getestagio()->getaluno(); ?>
                                        <tr class="red">
                                            <th scope="row"><?php echo ++$i; ?></th>
                                            <td><?php echo $estagio->getestagio()->getstatus()->getdescricao(); ?></td>
                                            <td><?php echo $estagio->getestagio()->getaluno()->getnome(); ?></td>
                                            <td><?php echo $estagio->getdata_inicio(); ?></td>
                                            <td><?php echo $estagio->getestagio()->getaluno()->getcursos()[0]->getnome() ?></td>
                                            <td class="center">
                                                <button type="button" class="definirOrientador btn btn-link"
                                                        data-toggle="modal" data-target="#definirOrientador">
                                                    <i class="fa fa-pencil"></i>
                                                    <div style="display:none;" class="modal-data-hold row">
                                                        <span class="estagio-id" style="display:none;"><?php echo $estagio->getestagio()->getid(); ?></span>
                                                        <h6>Nome: </h6> <p><?php echo $aluno->getnome(); ?></p><br>
                                                        <h6>Cpf: </h6> <p><?php echo $aluno->getcpf(); ?></p><br>
                                                        <h6>Curso: </h6> <p><?php echo $aluno->getcursos()[0]->getnome(); ?></p> <br>
                                                        <h6>Nome fantasia da empresa: </h6> <p><?php echo $estagio->getestagio()->getempresa()->getnome(); ?></p> <br>
                                                        <h6>Setor/Unidade da empresa: </h6> <p><?php echo "T.I."; //$estagio->getestagio()->getempresa()->getsetor_unidade();           ?></p> <br>
                                                        <h6>Supervisor: </h6> <p><?php echo $estagio->getestagio()->getsupervisor()->getnome(); ?></p> <br>
                                                        <h6>Telefone do supervisor: </h6> <p><?php echo "(38) 9878-3177"//$estagio->getestagio()->getsupervisor()->gettelefone();           ?></p> <br>
                                                        <h6>Habilitação profissional: </h6> <p><?php echo $estagio->getestagio()->getsupervisor()->gethabilitacao(); ?></p> <br>
                                                        <h6>Cargo: </h6> <p><?php echo $estagio->getestagio()->getsupervisor()->getcargo(); ?></p> <br>
                                                        <h6>Principais atividdes a serem desenvolvidas: </h6>
                                                        <p><?php echo $estagio->getatividades(); ?></p> <br>
                                                        <h6>Data prevista para ínicio do estágio: </h6> <p><?php echo $estagio->getdata_inicio(); ?></p> <br>
                                                        <h6>Data prevista para término do estágio: </h6> <p><?php echo $estagio->getdata_fim(); ?></p> <br>
                                                    </div>
                                                </button>
                                            </td>
                                            <td class="center">
                                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#detalhes<?php echo $estagio->getid(); ?>">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- MODAL para mostrar detalhes do estágio -->
                                    <div class="modal fade" id="detalhes<?php echo $estagio->getid(); ?>" tabindex="-1" role="dialog" aria-labelledby="detalhesEstagioTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detalhesEstagioTitle">Detalhes do estágio</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 dados-aluno">
                                                            <a target="_blank" href="./pe/pe.php?estagio_id=<?php echo $estagio->getid(); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>Plano de Estagio</a>
                                                            <a target="_blank" href="./tc/tc.php?estagio_id=<?php echo $estagio->getid(); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>Termo de Compromisso</a>
                                                            <br>
                                                            <br>
                                                            <h6>Status: </h6> <p><?php echo $estagio->getstatus()->getdescricao(); ?></p><br>
                                                            <h6>Nº da apólice seguradora: </h6> <p><?php echo ($estagio->getapolice()) ? $estagio->getapolice()->getnumero() : NULL; ?></p><br>
                                                            <h6>Setor/Unidade da empresa: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getsetor_unidade() : NULL; ?></p> <br>
                                                            <h6>Supervisor: </h6> <p><?php echo (!$estagio->getsupervisor()) ? NULL : $estagio->getsupervisor()->getnome(); ?></p> <br>
                                                            <h6>Habilitação profissional: </h6> <p><?php echo (!$estagio->getsupervisor()) ? NULL : $estagio->getsupervisor()->gethabilitacao(); ?></p> <br>
                                                            <h6>Cargo: </h6> <p><?php echo (!$estagio->getsupervisor()) ? NULL : $estagio->getsupervisor()->getcargo(); ?></p> <br>
                                                            <h6>Professor orientador: </h6> <p><?php echo ($estagio->getfuncionario()) ? $estagio->getfuncionario()->getnome() : NULL; ?></p> <br>
                                                            <h6>Formação profissional: </h6> <p><?php echo ($estagio->getfuncionario()) ? $estagio->getfuncionario()->getformacao() : NULL; ?></p> <br>
                                                            <h6>Data prevista para ínicio do estágio: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getdata_inicio() : NULL; ?></p> <br>
                                                            <h6>Data prevista para término do estágio: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getdata_fim() : NULL; ?></p> <br>
                                                            <h6>Jornada: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->gethora_inicio1() . "h às " . $estagio->getpe()->gethora_fim1() . "h, totalizando " . $estagio->getpe()->gettotal_horas() . "h semanais." : NULL ?></p> <br>
                                                            <h6>Principais atividdes a serem desenvolvidas: </h6>
                                                            <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getatividades() : NULL; ?></p> <br>
                                                            <h6>Nome fantasia da empresa: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getnome(); ?></p> <br>
                                                            <h6>Razão social da empresa: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getrazaosocial(); ?></p> <br>
                                                            <h6>CNPJ: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getcnpj(); ?></p> <br>
                                                            <h6>Telefone: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->gettelefone(); ?></p> <br>
                                                            <h6>FAX: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getfax(); ?></p> <br>
                                                            <h6>Logradouro: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getlogradouro(); ?></p> <br>
                                                            <h6>Número: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getnumero(); ?></p> <br>
                                                            <h6>Sala: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getsala(); ?></p> <br>
                                                            <h6>Bairro: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getbairro(); ?></p> <br>
                                                            <h6>Cidade: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getcidade(); ?></p> <br>
                                                            <h6>UF: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getuf(); ?></p> <br>
                                                            <h6>CEP: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getcep(); ?></p> <br>
                                                            <h6>Cidade: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getcidade(); ?></p> <br>
                                                            <h6>Nº de registro da empresa: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getnregistro(); ?></p> <br>
                                                            <h6>Conselho de fiscalização: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getconselhofiscal(); ?></p> <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- MODAL para definir prof. Orientador -->
                <div class="modal fade" id="definirOrientador" tabindex="-1" role="dialog" aria-labelledby="definirOrientadorTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="definirOrientadorTitle">Atribuir Orientador</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-data-target" class="row">
                                </div>
                                <form id="form-def-orientador" name="dados-aluno" method="post" action="<?php echo base_url() . '/scripts/controllers/organizador-estagio/definir-po.php'; ?>">
                                    <input type="hidden" value="define" name="tipo">
                                    <input id="estagio-id" type="hidden" value="" name="estagio">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="validationCustom17">Professor Orientador</label>
                                            <select class="form-control" name="professor" required>
                                                <?php foreach ($professores as $professor): ?>
                                                    <option value="<?php echo $professor->getsiape(); ?>"><?php echo $professor->getnome(); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                <button id="definirOrientadorBtt" type="button" class="btn btn-primary">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <!--Secretaria-->
        <?php
        if (is_a($usuario, "Funcionario")) {
            if ($usuario->issra()) {
                ?>
                <div class="col-lg-10 status-desc">

                    <?php if ($session->hasError("error-validacao")) { ?>
                        <div class="alert alert-warning">
                            <strong>Aviso:</strong> <?php echo $session->getErrors("error-validacao")[0]; ?>
                        </div>
                    <?php } ?>
                    <?php if ($session->hasError("error-critico")) { ?>
                        <div class="alert alert-danger">
                            <strong>Erro:</strong> <?php echo $session->getErrors("error-critico")[0]; ?>
                        </div>
                    <?php } ?>
                    <?php if ($session->hasValues("sucesso")) { ?>
                        <div class="alert alert-success">
                            <strong>Sucesso:</strong> <?php echo $session->getValues("sucesso")[0]; ?>
                        </div>
                    <?php } ?>
                    <div class="row table-estagios">
                        <div class="offset-lg-1 col-lg-10 table-title">
                            <h3 class="bg-gray"> Todos os estágios </h3>
                        </div>
                        <div class="offset-lg-1 col-lg-10">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Data início</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Editar</td>
                                        <th scope="col">Ver</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cont = 1;
                                    foreach ($estagios as $estagio) {
                                        if ($estagio->getstatus()->getcodigo() == 1 || $estagio->getstatus()->getcodigo() == 5 || $estagio->getstatus()->getcodigo() == 9) {
                                            ?>
                                            <tr class="red">
                                                <th scope="row"><?php echo $cont; ?></th>
                                                <td><?php echo $estagio->getstatus()->getdescricao(); ?></td>
                                                <td><?php echo $estagio->getaluno()->getnome(); ?></td>
                                                <td><?php echo (!$estagio->getpe()) ? " - " : $estagio->getpe()->getdata_inicio(); ?></td>
                                                <td><?php echo (!$estagio->getmatricula()) ? " - " : $estagio->getmatricula()->getoferta()->getcurso()->getnome() ?></td>
                                                <td class="center">
                                                    <button type="button" class="btn btn-link"
                                                            data-toggle="modal" data-target="#modal<?php echo $estagio->getid() ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                </td>
                                                <td class="center"><a href="#"> <i class="fa fa-eye"></i> </a></td>
                                            </tr>
                                            <?php
                                            $cont++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- MODAL para solicitação de estágio -->
                <?php
                foreach ($estagios as $estagio) {
                    if ($estagio->getstatus()->getcodigo() == 1) {
                        ?>
                        <div class="modal fade" id="modal<?php echo $estagio->getid() ?>" tabindex="-1" role="dialog" aria-labelledby="solicitacaoEstagioTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="solicitacaoEstagioTitle">Analisar conformidades</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="dados-aluno" method="post" action="../scripts/controllers/secretaria/avaliaPE.php">
                                        <input type="hidden" name="id" name="id" value="<?php echo $estagio->getid() ?>">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 dados-aluno">
                                                    <h6>Nome: </h6> <p><?php echo $estagio->getaluno()->getnome() ?></p><br>
                                                    <h6>Cpf: </h6> <p><?php echo $estagio->getaluno()->getcpfformatado(); ?></p><br>
                                                    <h6>Curso: </h6> <p><?php echo (!$estagio->getmatricula()) ? " - " : $estagio->getmatricula()->getoferta()->getcurso()->getnome(); ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="matricula">Matrícula:</label>
                                                        <input type="text" name="matricula" pattern="^\d+$" class="form-control" placeholder="" value="<?php
                                                        if ($estagio->getmatricula()) {
                                                            if (!empty($estagio->getmatricula()->getmatricula()))
                                                                echo $estagio->getmatricula()->getmatricula();
                                                        }
                                                        ?>" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="semestre">Aluno iniciou o curso em (Semestre/Ano):</label>
                                                        <input type="text" id="semestre<?php echo $estagio->getid() ?>" name="semestre" pattern="[1-2]\/(19[0-9][0-9]|2[0-9][0-9][0-9])" value="<?php
                                                        if ($estagio->getmatricula()) {
                                                            if (!empty($estagio->getmatricula()->getsemestre_inicio()) && !empty($estagio->getmatricula()->getano_inicio()))
                                                                echo $estagio->getmatricula()->getsemestre_inicio() . "/" . $estagio->getmatricula()->getano_inicio();
                                                        }
                                                        ?>" class="form-control" placeholder="s/AAAA"  required="required">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="custom-controls-stacked">
                                                    <label class="custom-control custom-radio" style="margin-top: 10px;">
                                                        <input id="matriculado<?php echo $estagio->getid() ?>" name="matriculado" type="checkbox" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Aluno está regularmente matriculado</span>
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="serie">Série:</label>
                                                            <input type="number" name="serie" id="serie<?php echo $estagio->getid() ?>" class="form-control" placeholder="" disabled="disabled">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="modulo">Módulo:</label>
                                                            <input type="number" name="modulo" id="modulo<?php echo $estagio->getid() ?>" class="form-control" placeholder="" disabled="disabled">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="periodo">Período:</label>
                                                            <input type="number" name="periodo" id="periodo<?php echo $estagio->getid() ?>" class="form-control" placeholder="" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <label class="custom-control custom-radio">
                                                        <input id="integralizado<?php echo $estagio->getid() ?>" name="integralizado" type="checkbox" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Aluno integralizou a carga horário do curso</span>
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="integralizacao">Semestre/Ano de integralização</label>
                                                            <input type="text" name="integralizacao" id="integralizacao<?php echo $estagio->getid() ?>"  pattern="[1-2]\/(19[0-9][0-9]|2[0-9][0-9][0-9])" class="form-control" placeholder="s/AAAA" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <label class="custom-control custom-radio">
                                                        <input id="emregime<?php echo $estagio->getid() ?>" name="emregime" type="checkbox" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Aluno em regime de dependência</span>
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="dependencias">Dependências</label>
                                                            <textarea name="dependencias" id="dependencias<?php echo $estagio->getid() ?>" rows="3" class="form-control" disabled="disabled"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6>O aluno está apto para realizar o estágio?</h6>
                                                    </div>
                                                </div>
                                                <div class="custom-controls-stacked">
                                                    <label class="custom-control custom-radio" style="margin-top: 10px;">
                                                        <input id="aptidao1<?php echo $estagio->getid() ?>" name="aptidao" value="1" onchange='if ($(this).is(":checked")) {
                                                            $("#justificativa<?php echo $estagio->getid() ?>").attr("disabled", "disabled");
                                                            $("#justificativa<?php echo $estagio->getid() ?>").removeAttr("required");
                                                            }' type="radio" class="custom-control-input" required="required">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">SIM</span>
                                                    </label>
                                                    <label class="custom-control custom-radio" style="margin-top: 3px;">
                                                        <input id="aptidao2<?php echo $estagio->getid() ?>"  onchange='if ($(this).is(":checked")) {
                                                            $("#justificativa<?php echo $estagio->getid() ?>").removeAttr("disabled");
                                                            $("#justificativa<?php echo $estagio->getid() ?>").attr("required", "required");
                                                            $("#justificativa<?php echo $estagio->getid() ?>").focus();
                                                            }' name="aptidao" value="0" type="radio" class="custom-control-input" required="required">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">NÃO</span>
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="justificativa">Justificativa</label>
                                                        <textarea name="justificativa" id="justificativa<?php echo $estagio->getid() ?>" rows="3" class="form-control" disabled="disabled"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php
            } elseif ($estagio->getstatus()->getcodigo() == 5) {
                ?>
                        <!-- MODAL autorizar o inicio do estágio -->
                        <div class="modal fade" id="modal<?php echo $estagio->getid(); ?>" tabindex="-1" role="dialog" aria-labelledby="solicitacaoEstagioTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="solicitacaoEstagioTitle">Autorizar início do estágio</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="autorizacao-estadio" method="post" action="../scripts/controllers/secretaria/autorizaEstagio.php">
                                        <input type="hidden" name="id" name="id" value="<?php echo $estagio->getid() ?>">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 dados-aluno">
                                                    <h6>Nome: </h6> <p><?php echo $estagio->getaluno()->getnome() ?></p><br>
                                                    <h6>Cpf: </h6> <p><?php echo $estagio->getaluno()->getcpfformatado(); ?></p><br>
                                                    <h6>Curso: </h6> <p><?php echo (!$estagio->getmatricula()) ? " - " : $estagio->getmatricula()->getoferta()->getcurso()->getnome(); ?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6>Os documentos para iniciar o
                                                            estágio foram corretamente entregues pelo aluno?</h6>
                                                    </div>
                                                </div>
                                                <div class="custom-controls-stacked">
                                                    <label class="custom-control custom-radio" style="margin-top: 10px;">
                                                        <input id="entregue" name="entregue" value="1" type="radio" class="custom-control-input" required="required">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">SIM</span>
                                                    </label>
                                                    <label class="custom-control custom-radio" style="margin-top: 3px;">
                                                        <input id="entregue" name="entregue" value="0" type="radio" class="custom-control-input" required="required">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">NÃO</span>
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="justificativa">Justificativa</label>
                                                        <textarea name="justificativa" rows="3" class="form-control" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php
            } elseif ($estagio->getstatus()->getcodigo() == 9) {
                ?>
                        <!-- MODAL registrar a conclusao do estágio -->
                        <div class="modal fade" id="modal<?php echo $estagio->getid(); ?>" tabindex="-1" role="dialog" aria-labelledby="solicitacaoEstagioTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="conclusaoEstagioTitle">Registrar a conclusão do estágio</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form name="finalizacao-estadio" method="post" action="../scripts/controllers/secretaria/finalizaEstagio.php">
                                        <input type="hidden" name="id" name="id" value="<?php echo $estagio->getid() ?>">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 dados-aluno">
                                                    <h6>Nome: </h6> <p><?php echo $estagio->getaluno()->getnome() ?></p><br>
                                                    <h6>Cpf: </h6> <p><?php echo $estagio->getaluno()->getcpfformatado(); ?></p><br>
                                                    <h6>Curso: </h6> <p><?php echo (!$estagio->getmatricula()) ? " - " : $estagio->getmatricula()->getoferta()->getcurso()->getnome(); ?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6>Documentos finais de estágio devidamente recebidos e estágio concluído.</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="horas">Horas contabilizadas:</label>
                                                        <input type="text" name="horas" max="100" class="form-control" placeholder="HH:mm" pattern="^(800|[0-7][0-9][0-9]|[0-9][0-9]|[0-9]):[0-5][0-9]$" required="required">
                                                        <small id="dataFimHelp" class="form-text text-muted">
                                                            Maximo: 800:59.
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        }
        ?>
        <!--Aluno-->

        <!-- Modal para solicitar um novo estágio -->
        <div class="modal fade" id="modalNovoEstagio" tabindex="-1" role="dialog" aria-labelledby="modalNovoEstagioTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNovoEstagioTitle">Solicitação de estágio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="novo-estagio" name="novo-estagio" style="text-align: left;" method="POST" action="<?php echo base_url() ?>/scripts/controllers/estudante/comeca-estagio.php">
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="obrigatorio" id="exampleRadios1" value="1" checked>
                                        Obrigatório
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="obrigatorio" id="exampleRadios2" value="2">
                                        Não obrigatório.
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Campus</label>
                                <select class="form-control" id="campus" name="campus" required>
<?php foreach ($campi as $campus): ?>
                                        <option value="<?php echo $campus->getcnpj(); ?>"><?php echo $campus->getendereco()->getcidade(); ?></option>
<?php endforeach; ?> 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Curso</label>
                                <select class="form-control" id="cursos" name="curso" required>

                                </select>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="horario" id="" value="1" checked>
                                        Integral
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="horario" id="" value="2">
                                        Matutino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="horario" id="" value="3">
                                        Vespertino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="horario" id="" value="4">
                                        Noturno
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                        <button type="button" id="cadastrar-estagio" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (is_a($usuario, "Aluno")) {
            if (count($estagios) == 0) {
                ?>
                <div class="col-lg-10 align-self-center center">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modalNovoEstagio" style="padding: 25px;">Novo estágio</button>
                </div>
                    <?php
                } else {
                    ?>
                <div class="col-lg-10 status-desc">
                    <?php if ($session->hasError("error-validacao")) { ?>
                        <div class="alert alert-warning">
                            <strong>Aviso:</strong> <?php echo $session->getErrors("error-validacao")[0]; ?>
                        </div>
        <?php } ?>
                    <?php if ($session->hasError("error-critico")) { ?>
                        <div class="alert alert-danger">
                            <strong>Erro:</strong> <?php echo $session->getErrors("error-critico")[0]; ?>
                        </div>
        <?php } ?>
                    <?php if ($session->hasValues("sucesso")) { ?>
                        <div class="alert alert-success">
                            <strong>Sucesso:</strong> <?php echo $session->getValues("sucesso")[0]; ?>
                        </div>
                    <?php } ?>
                    <?php
                    $cont = 1;
                    foreach ($estagios as $estagio) {
                        if ($estagio->getstatus()->getcodigo() <= 11) {
                            ?>
                            <div class="row" id="estagio<?php echo $estagio->getid(); ?>">
                                <div class="offset-lg-1 col-lg-10 status-desc-item bg-gray">
                                    <h3> Estágio atual <?php echo (!$estagio->getempresa()) ? NULL : "(" . $estagio->getempresa()->getnome() . ")"; ?> </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-lg-1 col-lg-10 status-desc-item" style="border-bottom: none;">
                                    <h4>Status: </h4>
                                    <p><?php echo $estagio->getstatus()->getdescricao(); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-lg-1 col-lg-10 status-desc-item">
                                    <?php if ($estagio->getstatus()->gettexto()) {
                                        ?>
                                        <h4>Descrição: </h4>
                                        <p><?php echo $estagio->getstatus()->gettexto() ?></p>
                                        <?php
                                    }
                                    if ($estagio->getstatus()->getcodigo() == 2) {
                                        ?>
                                        <a href="./estudante/cadastrar-dados-estagio.php"><button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                                                                                  data-target="#modalEstagio" style="padding: 10px;">Preencher dados</button></a>
                    <?php
                } elseif ($estagio->getstatus()->getcodigo() == 6) {
                    ?>
                                        <form  enctype="multipart/form-data"  method="POST" action="<?php echo base_url() . '/scripts/controllers/estudante/submeter_relatorio.php'; ?>" >
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Relatório final</label>
                                                <input type="file" name="relatorio" class="form-control-file" id="exampleFormControlFile1" required>
                                                <small id="fileHelpBlock" class="form-text text-muted">
                                                    O seu arquivo deve ter um tamanho máximo de 50 MB.
                                                </small>
                                            </div>
                    <?php $_SESSION['estagio'] = $estagio; ?>
                                            <!--input type="hidden" name="MAX_FILE_SIZE" value="55000000"-->
                                            <button type="submit" name="enviar_relatorio" class="btn btn-outline-success"
                                                    style="padding: 10px; width: 100px;">Enviar</button>
                                        </form>
                    <?php
                }
                ?>
                                </div>
                            </div>

                            <!-- TIMELINE DE STATUS -->
                            <div class="row row-timeline">
                                <div class="offset-lg-1 col-lg-10">
                                    <!--<div class="page-header">
                                      <h3>Progresso</h3>
                                    </div>-->
                                    <div style="display:inline-block;width:100%;overflow-y:auto;">
                                        <ul class="timeline timeline-horizontal">
                                            <?php
                                            $modificacaoModel = $loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                                            $modificacoes = $modificacaoModel->readbyestagio($estagio, 0);
                                            $ultimoPasso = 0;
                                            foreach ($modificacoes as $modicacao) {
                                                ?>
                                                <li class="timeline-item">
                                                    <div class="timeline-badge success"><i class="fa fa-check"></i></div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title"><?php
                                                                if ($modicacao->getstatus()->getcodigo() == 1) {
                                                                    echo "Estagio criado";
                                                                } elseif ($modicacao->getstatus()->getcodigo() == 2) {
                                                                    echo "Estagio deferido";
                                                                } elseif ($modicacao->getstatus()->getcodigo() == 4) {
                                                                    echo "Professor orientador definido";
                                                                } elseif ($modicacao->getstatus()->getcodigo() == 6) {
                                                                    echo "Inicio de estágio autorizado";
                                                                } elseif ($modicacao->getstatus()->getcodigo() == 8) {
                                                                    echo "Relatório aprovado";
                                                                } elseif ($modicacao->getstatus()->getcodigo() == 11) {
                                                                    echo "Empresa conveniada";
                                                                } elseif ($modicacao->getstatus()->getcodigo() == 12) {
                                                                    echo "Estágio concluido";
                                                                }
                                                                ?></h4>
                                                            <p><small class="text-muted"><?php
                                                $date = new DateTime($modicacao->getdata());
                                                echo $date->format('d/m/Y') . " às " . $date->format('H:i');
                                                ?></small></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                                $ultimoPasso = $modicacao->getstatus()->getcodigo();
                                            }
                                            while ($ultimoPasso < 12) {
                                                $ultimoPasso++;
                                                if ($ultimoPasso != 3 && $ultimoPasso != 5 && $ultimoPasso != 7 && $ultimoPasso != 9 && $ultimoPasso != 10) {
                                                    ?>
                                                    <li class="timeline-item">
                                                        <div class="timeline-badge primary"><i class=""></i></div>
                                                        <div class="timeline-panel">
                                                            <div class="timeline-heading">
                                                                <h4 class="timeline-title"><?php
                                                                    if ($ultimoPasso == 1) {
                                                                        echo "Estagio criado";
                                                                    } elseif ($ultimoPasso == 2) {
                                                                        echo "Estagio deferido";
                                                                    } elseif ($ultimoPasso == 4) {
                                                                        echo "Professor orientador definido";
                                                                    } elseif ($ultimoPasso == 6) {
                                                                        echo "Inicio de estágio autorizado";
                                                                    } elseif ($ultimoPasso == 8) {
                                                                        echo "Relatório aprovado";
                                                                    } elseif ($ultimoPasso == 11) {
                                                                        echo "Empresa conveniada";
                                                                    } elseif ($ultimoPasso == 12) {
                                                                        echo "Estágio concluido";
                                                                    }
                                                                    ?></h4>
                                                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> - </small></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 20px;"></div>
                            <?php
                        }
                        $cont++;
                    }
                    ?>
                    <div class="row table-estagios">
                        <div class="offset-lg-1 col-lg-10 table-title bg-gray">
                            <h3> Todos os estágios </h3>
                        </div>
                        <div class="offset-lg-1 col-lg-10" style="padding: 0;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Data início</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Ver</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cont = 1;
                                    foreach ($estagios as $estagio) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $cont ?></th>
                                            <td><?php echo ($estagio->getpe()) ? $estagio->getpe()->getdata_inicio() : " - " ?></td>
                                            <td><?php echo (!$estagio->getempresa()) ? " - " : $estagio->getempresa()->getnome() ?></td>
                                            <td><?php echo $estagio->getstatus()->getdescricao() ?></td>
                                            <td><?php echo (!$estagio->getmatricula()) ? " - " : $estagio->getmatricula()->getoferta()->getcurso()->getnome() ?></td>
                                            <td class="center">
                                                <button type="button" class="btn btn-link"
                                                        data-toggle="modal" data-target="#detalhes<?php echo $estagio->getid() ?>">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- MODAL para mostrar detalhes do estágio -->
                                    <div class="modal fade" id="detalhes<?php echo $estagio->getid(); ?>" tabindex="-1" role="dialog" aria-labelledby="detalhesEstagioTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detalhesEstagioTitle">Detalhes do estágio</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 dados-aluno">
                                                            <a target="_blank" href="./pe/pe.php?estagio_id=<?php echo $estagio->getid(); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>Plano de Estagio</a>
                                                            <a target="_blank" href="./tc/tc.php?estagio_id=<?php echo $estagio->getid(); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>Termo de Compromisso</a>
                                                            <br>
                                                            <br>
                                                            <h6>Status: </h6> <p><?php echo $estagio->getstatus()->getdescricao(); ?></p><br>
                                                            <h6>Nº da apólice seguradora: </h6> <p><?php echo ($estagio->getapolice()) ? $estagio->getapolice()->getnumero() : NULL; ?></p><br>
                                                            <h6>Setor/Unidade da empresa: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getsetor_unidade() : NULL; ?></p> <br>
                                                            <h6>Supervisor: </h6> <p><?php echo (!$estagio->getsupervisor()) ? NULL : $estagio->getsupervisor()->getnome(); ?></p> <br>
                                                            <h6>Habilitação profissional: </h6> <p><?php echo (!$estagio->getsupervisor()) ? NULL : $estagio->getsupervisor()->gethabilitacao(); ?></p> <br>
                                                            <h6>Cargo: </h6> <p><?php echo (!$estagio->getsupervisor()) ? NULL : $estagio->getsupervisor()->getcargo(); ?></p> <br>
                                                            <h6>Professor orientador: </h6> <p><?php echo ($estagio->getfuncionario()) ? $estagio->getfuncionario()->getnome() : NULL; ?></p> <br>
                                                            <h6>Formação profissional: </h6> <p><?php echo ($estagio->getfuncionario()) ? $estagio->getfuncionario()->getformacao() : NULL; ?></p> <br>
                                                            <h6>Data prevista para ínicio do estágio: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getdata_inicio() : NULL; ?></p> <br>
                                                            <h6>Data prevista para término do estágio: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getdata_fim() : NULL; ?></p> <br>
                                                            <h6>Jornada: </h6> <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->gethora_inicio1() . "h às " . $estagio->getpe()->gethora_fim1() . "h, totalizando " . $estagio->getpe()->gettotal_horas() . "h semanais." : NULL ?></p> <br>
                                                            <h6>Principais atividdes a serem desenvolvidas: </h6>
                                                            <p><?php echo ($estagio->getpe()) ? $estagio->getpe()->getatividades() : NULL; ?></p> <br>
                                                            <h6>Nome fantasia da empresa: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getnome(); ?></p> <br>
                                                            <h6>Razão social da empresa: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getrazaosocial(); ?></p> <br>
                                                            <h6>CNPJ: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getcnpj(); ?></p> <br>
                                                            <h6>Telefone: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->gettelefone(); ?></p> <br>
                                                            <h6>FAX: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getfax(); ?></p> <br>
                                                            <h6>Logradouro: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getlogradouro(); ?></p> <br>
                                                            <h6>Número: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getnumero(); ?></p> <br>
                                                            <h6>Sala: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getsala(); ?></p> <br>
                                                            <h6>Bairro: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getbairro(); ?></p> <br>
                                                            <h6>Cidade: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getcidade(); ?></p> <br>
                                                            <h6>UF: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getuf(); ?></p> <br>
                                                            <h6>CEP: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getcep(); ?></p> <br>
                                                            <h6>Cidade: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getendereco()->getcidade(); ?></p> <br>
                                                            <h6>Nº de registro da empresa: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getnregistro(); ?></p> <br>
                                                            <h6>Conselho de fiscalização: </h6> <p><?php echo (!$estagio->getempresa()) ? NULL : $estagio->getempresa()->getconselhofiscal(); ?></p> <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $cont++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script src="../../assets/js/busca_estagio.js"></script>
<script src="../../assets/js/ce-load-home.js"></script>
<script>
                                            $(function(){
<?php
if ($session->hasError('normal')):
    ?>
                                                alert(<?php echo "\"" . $session->getErrors('normal')[0] . "\"" ?>);
<?php elseif ($session->hasValues('resultado')): ?>
                                                alert(<?php echo "\"" . $session->getValues('resultado')[0] . "\"" ?>);
<?php endif; ?>

                                            $('.empresaModalToggle').click(function(){
                                            $('#ecnpj').val($(this).find('.cnpj').html());
                                            $('#empresaDadosInModal').html($(this).children('.empresaDados').html());
                                            });
                                            $('#enviarFormEmpresa').click(function(){
                                            $('#empresaForm').submit();
                                            });
                                            });</script>
<script>
    $(function(){
<?php
if ($session->hasError('normal')):
    ?>
        alert('<?php echo $session->getErrors('normal')[0] ?>');
<?php elseif ($session->hasValues('resultado')): ?>
        alert('<?php echo $session->getValues('resultado')[0] ?>');
<?php endif ?>

    var options = {
<?php
foreach ($campi as $campus):
    ?>
    <?php echo $campus->getcnpj() ?> :
        {
    <?php
    foreach ($cursos[$campus->getcnpj()] as $curso):
        ?>
        <?php
        echo "\"" . $curso->getnome() . "\": \"" . $curso->getid() . "\",";
        ?>
        <?php
    endforeach;
    ?>
        },
    <?php
endforeach;
?>
    };
    var alteraCampus = function(campus){
    console.log(campus);
    $cursos = $('#cursos');
    $cursos.empty();
    $.each(options[campus.val()], function(key, value) {
    $cursos.append($("<option></option>")
            .attr("value", value).text(key));
    });
    }

    $("#campus").select(function(){
    alteraCampus($(this));
    });
    $('#cadastrar-estagio').click(function(){
    $('#novo-estagio').submit();
    });
    alteraCampus($('#campus').children());
    });</script>

<?php
if (is_a($usuario, "Funcionario")) {
    if ($usuario->issra()) {
        foreach ($estagios as $estagio) {
            ?>
            <script type="text/javascript">
                $(function () {
                $("#matriculado<?php echo $estagio->getid() ?>").click(function () {
                if ($(this).is(":checked")) {
                $("#serie<?php echo $estagio->getid() ?>").removeAttr("disabled");
                $("#modulo<?php echo $estagio->getid() ?>").removeAttr("disabled");
                $("#periodo<?php echo $estagio->getid() ?>").removeAttr("disabled");
                $("#serie<?php echo $estagio->getid() ?>").attr("required", "required");
                $("#modulo<?php echo $estagio->getid() ?>").attr("required", "required");
                $("#periodo<?php echo $estagio->getid() ?>").attr("required", "required");
                $("#serie<?php echo $estagio->getid() ?>").focus();
                } else {
                $("#serie<?php echo $estagio->getid() ?>").attr("disabled", "disabled");
                $("#modulo<?php echo $estagio->getid() ?>").attr("disabled", "disabled");
                $("#periodo<?php echo $estagio->getid() ?>").attr("disabled", "disabled");
                $("#serie<?php echo $estagio->getid() ?>").removeAttr("required");
                $("#modulo<?php echo $estagio->getid() ?>").removeAttr("required");
                $("#periodo<?php echo $estagio->getid() ?>").removeAttr("required");
                }
                });
                });</script>
            <script type="text/javascript">
                $(function () {
                $("#integralizado<?php echo $estagio->getid() ?>").click(function () {
                if ($(this).is(":checked")) {
                $("#integralizacao<?php echo $estagio->getid() ?>").removeAttr("disabled");
                $("#integralizacao<?php echo $estagio->getid() ?>").attr("required", "required");
                $("#integralizacao<?php echo $estagio->getid() ?>").focus();
                } else {
                $("#integralizacao<?php echo $estagio->getid() ?>").attr("disabled", "disabled");
                $("#integralizacao<?php echo $estagio->getid() ?>").removeAttr("required");
                }
                });
                });</script>
            <script type="text/javascript">
                $(function () {
                $("#emregime<?php echo $estagio->getid() ?>").click(function () {
                if ($(this).is(":checked")) {
                $("#dependencias<?php echo $estagio->getid() ?>").removeAttr("disabled");
                $("#dependencias<?php echo $estagio->getid() ?>").attr("required", "required");
                $("#dependencias<?php echo $estagio->getid() ?>").focus();
                } else {
                $("#dependencias<?php echo $estagio->getid() ?>").attr("disabled", "disabled");
                $("#dependencias<?php echo $estagio->getid() ?>").removeAttr("required");
                }
                });
                });</script>
            <?php
        }
    }
}
?>
<script>
    $(function(){
<?php if ($session->hasError('normal')): ?>
        alert(<?php echo "\"" . $session->getErrors('normal')[0] . "\"" ?>);
<?php elseif ($session->hasValues('resultado')): ?>
        alert(<?php echo "\"" . $session->getValues('resultado')[0] . "\"" ?>);
<?php endif ?>

    $('.definirOrientador').click(function(){
    $('.modal-data-target').html($(this).find('div').html());
    $('#estagio-id').val($(this).find('div').find('.estagio-id').html());
    });
    $('#definirOrientadorBtt').click(function(){
    $('#form-def-orientador').submit();
    });
    });</script>
<script src="../../assets/js/busca_estagio.js"></script>
<script src="../../assets/js/ce-load-home.js"></script>
<script>
    $(function(){
<?php
if ($session->hasError('normal')):
    ?>
        alert(<?php echo "\"" . $session->getErrors('normal')[0] . "\"" ?>);
<?php elseif ($session->hasValues('resultado')): ?>
        alert(<?php echo "\"" . $session->getValues('resultado')[0] . "\"" ?>);
<?php endif; ?>

    $('.empresaModalToggle').click(function(){
    $('#ecnpj').val($(this).find('.cnpj').html());
    $('#empresaDadosInModal').html($(this).children('.empresaDados').html());
    });
    $('#enviarFormEmpresa').click(function(){
    $('#empresaForm').submit();
    });
    });
</script>
</body>
</html>
