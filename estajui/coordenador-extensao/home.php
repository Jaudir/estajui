<?php
  require_once('../../scripts/controllers/coordenador-extensao/load-home.php');
  $errosExibir = $session->getErrors('normal');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Página inicial | Coordenação de Extensão </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/main.css">
  </head>
  <body>
    <div class="container-home container-fluid fullscreen">
      <nav class="navbar navbar-expand-lg navbar-light nav-menu">
        <a class="navbar-brand" href="#">
          <img src="<?php echo base_url();?>/assets/img/LOGO.PNG" height="42" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="nav-content navbar-nav">
            <li>
              <span class="navbar-text">
                <?php echo $session->getUsuario()->getnome(); ?>
              </span>
            </li>
            <li class="nav-item">
              <button type="button" class="btn btn-outline-light bt-sair">Sair</button>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
              <span class="notification"> 5 </span>
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <div class="row fullscreen">
        <div class="col-lg-2 left-menu">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Usuários</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Empresas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Professores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Cursos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Campi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Relatórios</a>
            </li>
          </ul>
        </div>

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
                  foreach($listaDeEstagios as $le):
                      if ($le->getstatus()->getcodigo() == 4 || $le->getstatus()->getcodigo() == 7){
                  ?>
                  <tr class="">
                      <th scope="row"><input type="hidden" value="<?php echo $le->getid(); ?>" class="form-control" id="estagioID<?php echo $row_id;?>"><?php echo $row_id; ?></th>
                      <td><?php echo $le->getstatus()->getdescricao(); ?></td>
                      <td><?php echo $le->getpe()->getdata_inicio(); ?></td>
                      <td><?php echo $le->getmatricula()->getoferta()->getcurso()->getnome(); ?></td>
                      <td class="center">
                      <button type="button" class="btn btn-link empresaModalToggle"
                      onclick="setarId('<?php echo "estagioID".$row_id++;?>')" data-toggle="modal" data-target="<?php
                        if ($le->getstatus()->getcodigo() == 4){
                            echo "#apoliceSeguro";
                        } else {
                            echo "#aprovarConvenio";
                        }

                      ?>" >
                        <i class="fa fa-pencil"></i>
                      </button>

                    </td>
                      <td class="center">
                          <a href="" onclick="preencherModal(<?php echo $le->getid();?>)" data-toggle="modal" data-target="#ver-estagio" id="ver<?php echo $lin++; ?>"> <i class="fa fa-eye ver"></i></a>
                      </td>
                  </tr>

                  <?php } endforeach; ?>
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
                <form name="convenio" id="empresaForm" method="post" action="<?php echo base_url() . '/scripts/controllers/coordenador-extensao/validar-cadastro-empresa.php'?>">
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
    <script src="../../assets/js/jquery-1.9.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="../../assets/js/busca_estagio.js"></script>
    <script src="../../assets/js/ce-load-home.js"></script>
    <script>
      $(function(){
        <?php
          if($session->hasError('normal')):
        ?>
          alert(<?php echo "\"" . $session->getErrors('normal')[0] . "\""?>);
        <?php elseif($session->hasValues('resultado')):?>
          alert(<?php echo "\"" . $session->getValues('resultado')[0] . "\""?>);
        <?php endif;?>

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
