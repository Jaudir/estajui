<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/HomeController.php";?>

<html>
  <head>
    <meta charset="utf-8">
    <title> Página inicial | Professor Orientador </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
  </head>
  <body>
    <div class="container-home container-fluid fullscreen">
      <nav class="navbar navbar-expand-lg navbar-light nav-menu">
        <a class="navbar-brand" href="#">
          <img src="../../assets/img/logo.png" height="42" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="nav-content navbar-nav">
            <li>
              <span class="navbar-text">
                Fulaninho de Tal
              </span>
            </li>
            <li class="nav-item">
              <button type="button" class="btn btn-outline-light bt-sair">Sair</button
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
      

        <div class="col-lg-2 left-menu">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Meus dados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Estágios</a>
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
                    <th scope="col">Nome</th>
                    <th scope="col">Data início</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Editar</td>
                    <th scope="col">Ver</td>
                  </tr>
                </thead>
                <tbody>
                  <tr class="red">
                    <th scope="row">1</th>
                    <td>Solicitação de aprovação do relatório.</td>
                    <td>Igor Alberte Rodrigues</td>
                    <td>22/11/2017</td>
                    <td>Ciência da Computação</td>
                    <td class="center">
                      <button type="button" class="btn btn-link"
                        data-toggle="modal" data-target="#corrigirRelatorio">
                        <i class="fa fa-pencil"></i>
                      </button>
                    </td>
                    <td class="center"><a href="#"> <i class="fa fa-eye"></i> </a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- MODAL Corrigir Relatório -->
        <div class="modal fade" id="corrigirRelatorio" tabindex="-1" role="dialog" aria-labelledby="corrigirRelatorioTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="corrigirRelatorioTitle">Correção de Relatório Final</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12 dados-aluno">
                    <h6>Nome: </h6> <p>Camila Rocha Lopes</p><br>
                    <h6>Curso: </h6> <p>Ciência da Computação</p><br>
                    <h6>Empresa: </h6> <p>Lorem ipsum</p><br>
                    <a class="btn btn-primary" href="http://anothersitehere.com/file.pdf">
                       Baixar relatório
                     </a> <br> <br>
                  </div>
                </div>
                <form enctype="multipart/form-data" name="dados-aluno" method="POST"  action="<?php echo base_url().'/scripts/controllers/organizador-estagio/avaliar-relatorio-final.php';?>" >
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <h6>O relatório final está aprovado?</h6>
                      </div>
                    </div>
                    <div class="custom-controls-stacked">
                      <label class="custom-control custom-radio" style="margin-top: 10px;">
                        <input id="radioStacked3"  name="aprovado" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">SIM</span>
                      </label>
                      <label class="custom-control custom-radio" style="margin-top: 3px;">
                        <input id="radioStacked5" name="reprovado"  type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">NÃO</span>
                      </label>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="correcao">Correções</label>
                        <input type="file" class="form-control-file" name="correcao">
                      </div>
                    </div> <br>
                    <div class="row">
                        
                      <div class="col-md-12">
                        <input type="hidden" name="justificativa" value="" id='justificativa_post'>
                        <label for="justificativa_text">Justificativa</label>
                        <textarea id="justificativa_text" rows="3" class="form-control" required>
                        </textarea>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                <button type="submit"  id='confirmar' name="confirmar" class="btn btn-primary">Confirmar</button>
              </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
   <script src='../../assets/js/home_po.js'></script>
  </body>
</html>
