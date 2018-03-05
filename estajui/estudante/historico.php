<?php
require_once('../../scripts/controllers/aluno/acompanhar-estagio.php');
$errosExibir = $session->getErrors('normal');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Language" content="pt-br">
        <title>Histórico Estágios | Estudante</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../assets/css/main.css">
    </head>
    <body>
        <div class="container-home container-fluid fullscreen">
            <nav class="navbar navbar-expand-lg navbar-light nav-menu">
                <a class="navbar-brand" href="../home.php">
                    <img src="../../assets/img/LOGO.PNG" height="42" class="d-inline-block align-top" alt="">
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
                        <li class="nav-item">
                            <a class="nav-link active" href="../home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="alterar-dados-pessoais.php">Meus dados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Histórico de estágios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Orientações gerais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#modalNovoEstagio" >+ Novo estágio</a>
                        </li>
                    </ul>
                </div>


                <div class="col-lg-10 status-desc">
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
                                        <th scope="col">Orientador</th>
                                        <th scope="col">Ver</td>
                                    </tr>
                                </thead>
                                <tbody><?php
                                    $cont = 1;
                                    foreach ($estagios as $estagio) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $cont ?></th>
                                            <td><?php echo ($estagio->getpe()) ? $estagio->getpe()->getdata_inicio() : " - " ?></td>
                                            <td><?php echo (!$estagio->getempresa()) ? " - " : $estagio->getempresa()->getnome() ?></td>
                                            <td><?php echo $estagio->getstatus()->getdescricao() ?></td>
                                            <td><?php echo (!$estagio->getfuncionario()) ? " - " : $estagio->getfuncionario()->getnome() ?></td>
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
            </div>
        </div>

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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script>
            let idlinha;
            $('table').on('click', '.ver', function () {
            idlinha = $(this).attr('data-id');
            idlinha = (parseInt(idlinha)) - 1;
            });
        </script>
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
            });
        </script>
    </body>
</html>