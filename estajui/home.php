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
                            <form method="get">
                                <button type="submit" name="logoff" class="btn btn-outline-light bt-sair">Sair</button>
                            </form>
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
                            <a class="nav-link" href="#">Meus dados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Histórico de estágios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Orientações gerais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">+ Novo estágio</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-10 align-self-center center">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modalNovoEstagio" style="padding: 25px;">Novo estágio</button>

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
                                    <form name="novo-estagio" style="text-align: left;">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios1" value="option1" checked>
                                                    Obrigatório
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios2" value="option2">
                                                    Não obrigatório.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Campus</label>
                                            <select class="form-control" required>
                                                <option>Montes Claros</option>
                                                <option>Januária</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Curso</label>
                                            <select class="form-control" required>
                                                <option>Ciência da Computação</option>
                                                <option>Engenharia Química</option>
                                                <option>Téc em informática</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="" value="option1" checked>
                                                    Integral
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="" value="option2">
                                                    Matutino
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="" value="option3">
                                                    Vespertino
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="exampleRadios" id="" value="option4">
                                                    Noturno
                                                </label>
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
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>
</html>
