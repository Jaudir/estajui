<?php
require_once('../../scripts/controllers/generico/listar-estagios.php');
$errosExibir = $session->getErrors('normal');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Buscar estágios </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../assets/css/main.css">
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

            <div class="row">
                <div class="col-lg-2 left-menu">
                    <ul class="nav flex-column">

                        <!--Comum a todos-->
                        <li class="nav-item">
                            <a class="nav-link active" href="../home.php">Home</a>
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
                                    <a class="nav-link" href="../coordenador-extensao/usuarios.php">Usuários</a>
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

                <div class="col-lg-10 status-desc">
                    <div class="row">
                        <div class="offset-md-1 col-md-10">
                            <form class="container" id="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom01">Aluno</label>
                                        <input type="text" class="form-control" id="inputAluno">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Professor orientador</label>
                                        <input type="text" class="form-control" id="inputPo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Responsável</label>
                                        <input type="text" class="form-control" id="inputResponsavel">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Empresa</label>
                                        <input type="text" class="form-control" id="inputEmpresa">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom05">Data inicio</label>
                                        <input type="date" class="form-control" id="inputDataInicio">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>Data conclusão</label>
                                        <input type="date" class="form-control" id="inputDataFim">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Status</label>
                                        <input type="text" class="form-control" id="inputStatus">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Curso</label>
                                        <input type="text" class="form-control" id="inputCurso">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 30px; margin-bottom: 30px;">
                                        <a href="#tabela"><button id="filtrar" class="btn btn-success" type="button">Filtrar</button></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row table-estagios">
                        <div class="offset-lg-1 col-lg-10 table-title bg-gray">
                            <h3 class=""> Todos os estágios </h3>
                        </div>

                        <div class="offset-lg-1 col-lg-10" style="padding: 0;">
                            <table class="table table-bordered" id="tabela">
                                <thead>
                                    <tr>
                                        <th scope="col">Estudante</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Data de início</th>
                                        <th scope="col">Data de término</th>
                                        <th scope="col">Professor orientador</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Ver</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $lin = 0; ?>
                                    <?php
                                    if (is_array($listaEstagios)) {
                                        foreach ($listaEstagios as $le):
                                            ?>
                                            <tr>
                                                <td><?php echo $le->getaluno()->getnome(); ?></td>
                                                <td><?php echo $le->getstatus()->getdescricao(); ?></td>
                                                <td><?php echo $le->getpe()->getdata_inicio(); ?></td>
                                                <td><?php echo $le->getpe()->getdata_fim(); ?></td>
                                                <td><?php echo $le->getfuncionario()->getnome(); ?></td>
                                                <td><?php echo $le->getempresa()->getnome(); ?></td>
                                                <td><?php echo $le->getmatricula()->getoferta()->getcurso()->getnome(); ?></td>
                                                <td class="center">
                                                    <a href="" onclick="preencherModal(<?php echo $le->getid(); ?>)" data-toggle="modal" data-target="#ver-estagio" id="ver<?php echo $lin++; ?>"> <i class="fa fa-eye ver"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- MODAL para mostrar detalhes do estágio -->

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


    <!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script-->
    <script src="../../assets/js/jquery-1.9.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="../../assets/js/busca_estagio.js"></script> 

</body>
</html>
                            <!-- <h6>Status: </h6> <p>/p><br>
                            <h6>Nº da apólice seguradora: </h6> <p></p><br>
                            <h6>Setor/Unidade da empresa: </h6> <p>T.I.</p> <br>
                            <h6>Supervisor: </h6> <p>Joaquim da Silva Júnior</p> <br>
                            <h6>Habilitação profissional: </h6> <p>Cientista da computação</p> <br>
                            <h6>Cargo: </h6> <p>Diretor de T.I.</p> <br>
                            <h6>Professor orientador: </h6> <p>João Neves Castro</p> <br>
                            <h6>Formação profissional: </h6> <p>Cientista da computação</p> <br>
                            <h6>Data prevista para ínicio do estágio: </h6> <p>22/01/2006</p> <br>
                            <h6>Data prevista para término do estágio: </h6> <p>23/10/2006</p> <br>
                            <h6>Jornada: </h6> <p>Xh às Xh e Xh às Xh, totalizando Xh semanais</p> <br>
                            <h6>Principais atividdes a serem desenvolvidas: </h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> <br>
                            <h6>Nome fantasia da empresa: </h6> <p>Lorem ipsum</p> <br>
                            <h6>Razão social da empresa: </h6> <p>Lorem 1234</p> <br>
                            <h6>CNPJ: </h6> <p>1234.56778/000001</p> <br>
                            <h6>Telefone: </h6> <p>1234-5678</p> <br>
                            <h6>FAX: </h6> <p> - </p> <br>
                            <h6>Logradouro: </h6> <p>Consectetur adipisicing elit</p> <br>
                            <h6>Número: </h6> <p>21</p> <br>
                            <h6>Sala: </h6> <p> - </p> <br>
                            <h6>Bairro: </h6> <p> Sit amet </p> <br>
                            <h6>Cidade: </h6> <p> Montes Claros </p> <br>
                            <h6>Estado: </h6> <p> Minas Gerais </p> <br>
                            <h6>CEP: </h6> <p> 39201-021 </p> <br>
                            <h6>Cidade: </h6> <p> Montes Claros </p> <br>
                            <h6>Nº de registro da empresa: </h6> <p> 1234 </p> <br>
                            <h6>Conselho de fiscalização: </h6> <p>Consectetur amet </p> <br>-->