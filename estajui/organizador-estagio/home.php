<!DOCTYPE html>
<?php

require_once(dirname(__FILE__) . '/../../scripts/controllers/organizador-estagio/load-home.php');

?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Página inicial | Organizador de Estágio </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
  </head>
  <body>
    <div class="container-home container-fluid fullscreen">
      <nav class="navbar navbar-expand-lg navbar-light nav-menu">
        <a class="navbar-brand" href="#">
          <img src="../../assets/img/LOGO.PNG" height="42" class="d-inline-block align-top" alt="">
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
        <div class="col-lg-2 left-menu">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Professores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Estágios</a>
            </li>
          </ul>
        </div>
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
                    foreach($estagios as &$estagio):
                  ?>
                  <?php
                    $usuario = $estagio->get_estagio()->getusuario();
                  ?>
                  <tr class="red">
                    <th scope="row"><?php echo ++$i;?></th>
                    <td><?php echo $estagio->get_estagio()->getstatus()->get_descricao(); ?></td>
                    <td><?php $estagio->get_estagio()->getusuario()->getnome(); ?></td>
                    <td><?php $estagio->get_data_inicio(); ?></td>
                    <td><?php $estagio->getEstagio()->get_estagio()->getcurso()->getnome(); ?></td>
                    <td class="center">
                      <button class="definirOrientador" type="button" class="btn btn-link"
                        data-toggle="modal" data-target="#definirOrientador">
                        <i class="fa fa-pencil"></i>
                      </button>
                    </td>
                    <td class="center"><a href="#"> <i class="fa fa-eye"></i> </a></td>
                  </tr>
                  <?php endforeach;?>
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
                <div id="modal-data-target" class="row">
                  <div class="col-md-12 dados-aluno">

                </div>
                <form name="dados-aluno">
                  <div class="row">
                    <div class="col-md-6 mb-2">
                      <label for="validationCustom17">Professor Orientador</label>
                      <select class="form-control" required>
                        <?php foreach($professores as $professor):?>
                        <option value="<?php echo $professor->getsiape(); ?>"><?php echo $professor->getnome(); ?></option>
                        <?php endforeach;?>
                      </select>
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
      <?php if($session->hasErrors('normal')):?>
        alert(<?php echo "\"" . $session->getErrors('normal')[0] . "\""?>);
      <?php endif;?>

        $('.definirOrientador').click(function(){
          $('');
        });
      });
    </script>
  </body>
</html>
