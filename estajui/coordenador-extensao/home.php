<?php
  require_once('../../scripts/controllers/coordenador-extensao/load-home.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Página inicial | Coordenação de Extensão </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
  </head>
  <body>
    <div class="container-home container-fluid fullscreen">
      <nav class="navbar navbar-expand-lg navbar-light nav-menu">
        <a class="navbar-brand" href="#">
          <img src="../img/LOGO.PNG" height="42" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="nav-content navbar-nav">
            <li>
              <span class="navbar-text">
                <?php echo "PEGAR NOME DA SESSÃO"; ?>
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
                    foreach($statusEstagios as $estagio):
                  ?>

                  <tr class="red">
                    <th scope="row"><?php echo $row_id++; ?></th>
                    <td><?php echo $estagio['descricao']; ?></td>
                    <td><?php echo $estagio['data'] ?></td>
                    <td><?php echo $estagio['curso']; ?></td>
                    <td class="center">
                      <button type="button" class="btn btn-link"
                        data-toggle="modal" data-target="#aprovarConvenio">
                        <i class="fa fa-pencil"></i>
                      </button>
                    </td>
                    <td class="center"><a href="#"> <i class="fa fa-eye"></i> </a></td>
                  </tr>

                  <?php endforeach; ?>

                  <?php
                    foreach($statusEmpresas as $empresa):
                  ?>
                  <tr class="red">
                    <th scope="row"><?php echo $row_id++; ?></th>
                    <td>Aguardando aprovação de convênio</td>
                    <td><?php echo "Data?" ?></td>
                    <td><?php echo "Curso?" ?></td>
                    <td class="center">
                      <button type="button" class="btn btn-link empresaModalToggle"
                        data-toggle="modal" data-target="#aprovarConvenio">
                        <i class="fa fa-pencil"></i>
                        <div class="empresaDados" style="display:none;">
                        <h6>Razão Social: </h6> <p><?php echo $empresa['razao_social']?></p><br>
                        <h6>CNPJ: </h6> <p class="cnpj"><?php echo $empresa['cnpj']?></p><br>
                        <h6>Nome fantasia: </h6> <p><?php echo $empresa['nome']?></p> <br>
                        <h6>Telefone: </h6> <p><?php echo $empresa['telefone']?></p> <br>
                        <h6>FAX: </h6> <p><?php echo $empresa['fax']?></p> <br>
                        <h6>Registro: </h6> <p><?php echo $empresa['nregistro']?></p> <br>
                        <h6>Conselho de fiscalização: </h6> <p><?php echo $empresa['conselhofiscal']?></p> <br>
                        <h6>Nome do responsável: </h6> <p><?php echo $empresa['resp_nome']?></p> <br>
                        <h6>Telefone do responsável: </h6> <p><?php echo $empresa['resp_tel']?></p> <br>
                        <h6>Email: </h6> <p><?php echo $empresa['resp_email']?></p> <br>
                        <h6>Cargo: </h6> <p><?php echo $empresa['resp_cargo']?></p> <br>
                        <h6>Logradouro: </h6> <p><?php echo $empresa['logradouro']?></p> <br>
                        <h6>Número: </h6> <p><?php echo $empresa['numero']?></p> <br>
                        <h6>Sala: </h6> <p><?php echo "Não tem sala"?></p> <br>
                        <h6>Bairro: </h6> <p><?php echo $empresa['bairro']?></p><br>
                        <h6>Cidade: </h6> <p><?php echo $empresa['cidade']?></p><br>
                        <h6>Estado: </h6> <p><?php echo $empresa['estado']?></p><br>
                        <h6>CEP: </h6> <p><?php echo $empresa['cep']?></p>
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
                      <!---->
                  </div>
                </div>
                <form name="convenio" id="empresaForm" method="post" action="<?php echo $configs['BASE_URL'] . '/scripts/controllers/coordenador-extensao/pre-cadastrar-empresa.php'?>">
                  <input type="hidden" id="ecnpj" name="cnpj" value="">
                  <div class="form-group">
                    <div class="custom-controls-stacked d-block my-3" style="margin-top: 10px;">
                      <label class="custom-control custom-radio">
                        <input id="radioStacked1" name="aprova" type="radio" class="custom-control-input" required>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Aprovado</span>
                      </label>
                      <label class="custom-control custom-radio" style="margin-left: 20px;">
                        <input id="radioStacked2" name="reprova" type="radio" class="custom-control-input" required>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Reprovado</span>
                      </label>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="justificativa">Justificativa</label>
                        <textarea name="justificativa" rows="3" class="form-control" required></textarea>
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
                    <h6>Nome: </h6> <p>Joaquim da Silva</p><br>
                    <h6>Matrícula: </h6> <p>XXXXXX</p><br>
                    <h6>Curso: </h6> <p>Engenharia Química</p> <br>
                    <h6>Obrigatoriedade: </h6> <p>Obrigatório</p> <br>
                    <h6>Empresa: </h6> <p>Lorem ipsum</p> <br>
                    <h6>CNPJ: </h6> <p>1029.02930.19303-00001</p> <br>
                    <h6>Razão Social: </h6> <p>Dolor sit amet</p> <br>
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
                <button type="button" class="btn btn-primary">Confirmar</button>
              </div>
            </div>
          </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
      $(function(){
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
