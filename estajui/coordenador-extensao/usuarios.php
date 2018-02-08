<!DOCTYPE html>
<?php
	session_start();
	
	//session_destroy();
	//session_unset();
	
	//var_dump($_SESSION);
?>

<script>
	function mensagemSalvamento() {	
		
		if(<?php if(isset($_SESSION['erros'])) echo 0; else echo 1; ?>) {
			
			return ;
		}
		if(<?php if(isset($_SESSION['erros']) && $_SESSION['erros'] == 0) echo 1; else echo 0; ?>) {
			window.alert("O usuário foi salvo no BD!");
			return ;
		}
		else {
			var msg;
			var i;
			window.alert('<?php if (isset($_SESSION['mensagensErro'])) {foreach($_SESSION['mensagensErro'] as &$msg) echo $msg . " "; unset($msg); } ?>');
			return ;
		}
		
		<?php unset($_SESSION['erros']);	unset($_SESSION['mensagensErro']); unset($_SESSION['pau1']); unset($_SESSION['pau12']); unset($_SESSION['curso'])?>
	}
</script>
<html>
  <head>
    <meta charset="utf-8">
    <title>Usuários | Coordenação de Extensão </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body onload = "mensagemSalvamento()">
    <div class="container-home container-fluid">
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
                Mario Sérgio Costa da Silveira
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

      <div class="row">
        <div class="col-lg-2 left-menu">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Usuários</a>
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
          <div class="row">
            <div class="offset-md-1 col-md-10">
              <form class="container" id="needs-validation" novalidate method="POST" action="../../scripts/controllers/persiste-usuario.php">
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="validationCustom01">Nome completo</label>
                    <input type="text" class="form-control" id="validationCustom01" required type="text" name="nome">
                    <div class="invalid-feedback">
                      Por favor, informe o nome completo.
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom03">SIAPE</label>
                      <input type="text" class="form-control" id="validationCustom03" placeholder="" required type="number" name="siape">
                      <div class="invalid-feedback">
                        Por favor, informe este campo.
                      </div>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label>Vínculo</label>
                      <select class="form-control" required name="vinculo">
                        <option value="">...</option>
                        <option>Docente</option>
                        <option>Técnico administrativo</option>
                      </select>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom05">Email</label>
                    <input type="text" class="form-control" id="validationCustom05" placeholder="" required type="email" name="email">
                    <div class="invalid-feedback">
                      Por favor, informe um e-mail válido.
                    </div>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Confirmação de email</label>
                    <input type="text" class="form-control" id="validationCustom06" placeholder="" required type="confirmEmail" name="confirmEmail">
                    <div class="invalid-feedback">
                      Por favor, informe um e-mail válido.
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <h6>Caso seja docente, marque os cursos em que ele ministra aulas:</h6>
                  </div>
                  <div class="col-md-12 mb-2">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="CComp">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Ciência da Computação</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="EQuim">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Engenharia Química</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="TecInf">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Técnico em Informática</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="TecQuim">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Técnico em Química</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="TecElet">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Técnico em Eletrotécnica</span>
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <h6>Quais permissões o usuário possui:</h6>
                  </div>
                  <div class="col-md-12 mb-2">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="PO">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Professor Orientador</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="CE">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Coordenador de Extensão</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="SRA">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Secretaria</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="OE">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Organizador de Estágio</span>
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="margin-top: 30px;">
                    <button class="btn btn-success" type="submit" name="cadastrar">Cadastrar</button>
                    <button class="btn btn-danger" type="submit" name="cancelar">Cancelar</button>
                  </div>
                </div>
              </form>

              <script>
              // Example starter JavaScript for disabling form submissions if there are invalid fields
              (function() {
                'use strict';
                window.addEventListener('load', function() {
                  var form = document.getElementById('needs-validation');
                  form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                }, false);
              })();
              </script>
            </div>
          </div>
          <div class="row table-usuarios">
            <div class="offset-lg-1 col-lg-10 table-title">
              <h3 class="bg-gray"> Todos os usuários </h3>
            </div>
            <div class="offset-lg-1 col-lg-10">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Siape</th>
                    <th scope="col">Vínculo</td>
                    <th scope="col">Curso</th>
                    <th scope="col">Permissões</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Excluir</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Lúcio Dutra</td>
                    <td>lucinho@ifnmg.edu.br</td>
                    <td>123456</td>
                    <td>Docente</td>
                    <td>Ciência da Computação</td>
                    <td>Professor Orientador, Organizador de estágio</td>
                    <td class="center red">
                      <a href="#"> <i class="fa fa-pencil"></i> </a>
                    </td>
                    <td class="center red"><a href="#"> <i class="fa fa-trash"></i> </a></td>
                  </tr>
                  <tr>
                    <td>João das neves</td>
                    <td>algumacoisa@ifnmg.edu.br</td>
                    <td>7891011</td>
                    <td>Técnico Administrativo</td>
                    <td> - </td>
                    <td>Secretaria</td>
                    <td class="center red">
                      <a href="#"> <i class="fa fa-pencil"></i> </a>
                    </td>
                    <td class="center red"><a href="#"> <i class="fa fa-trash"></i> </a></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Modal Recuperação de Senha -->
        <div class="modal fade" id="solicitacaoEstagio" tabindex="-1" role="dialog" aria-labelledby="solicitacaoEstagioTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="solicitacaoEstagioTitle">Analisar conformidades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12 dados-aluno">
                    <h6>Nome: </h6> <p>Camila Rocha Lopes</p><br>
                    <h6>Cpf: </h6> <p>014.727.846-50</p><br>
                    <h6>Curso: </h6> <p>Ciência da Computação</p>
                  </div>
                </div>
                <form name="dados-aluno">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="matricula">Matrícula:</label>
                        <input type="text" name="matricula" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="semestre">Aluno iniciou o curso em (Semestre/Ano):</label>
                        <input type="text" name="semestre" class="form-control" placeholder="s/AAAA">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-controls-stacked">
                      <label class="custom-control custom-radio" style="margin-top: 10px;">
                        <input id="radioStacked3" name="radio-stacked" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Aluno está regularmente matriculado</span>
                      </label>
                      <div class="row">
                        <div class="col-md-4">
                          <label for="serie">Série:</label>
                          <input type="text" name="serie" class="form-control" placeholder="">
                        </div>
                        <div class="col-md-4">
                          <label for="modulo">Módulo:</label>
                          <input type="text" name="modulo" class="form-control" placeholder="">
                        </div>
                        <div class="col-md-4">
                          <label for="periodo">Período:</label>
                          <input type="text" name="periodo" class="form-control" placeholder="">
                        </div>
                      </div>
                      <label class="custom-control custom-radio">
                        <input id="radioStacked4" name="radio-stacked" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Aluno integralizou a carga horário do curso</span>
                      </label>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="integralizacao">Semestre/Ano de integralização</label>
                          <input type="text" name="integralizacao" class="form-control" placeholder="s/AAAA">
                        </div>
                      </div>
                      <label class="custom-control custom-radio">
                        <input id="radioStacked5" name="radio-stacked" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Aluno em regime de dependência</span>
                      </label>
                      <div class="row">
                        <div class="col-md-12">
                          <label for="dependencias">Dependências</label>
                          <textarea name="dependencias" rows="3" class="form-control" required>
                          </textarea>
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
                        <input id="radioStacked3" name="radio-stacked" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">SIM</span>
                      </label>
                      <label class="custom-control custom-radio" style="margin-top: 3px;">
                        <input id="radioStacked5" name="radio-stacked" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">NÃO</span>
                      </label>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="justificativa">Justificativa</label>
                        <textarea name="justificativa" rows="3" class="form-control" required>
                        </textarea>
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
  </body>
</html>
