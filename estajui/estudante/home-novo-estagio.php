<?php  
require_once(dirname(__FILE__) . '/../../scripts/controllers/estudante/load_campos_cadastro.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Página inicial | Estudante</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/main.css">
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
                Igor Alberte Rodrigues Eleutério
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
                  <form name="novo-estagio" style="text-align: left;" method="POST" action="comeca-estagio.php">
                    <div class="form-group">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios1" value="obrigatorio" checked>
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
                      <select class="form-control" value="<?php if(!empty($_SESSION['campus_nome'])) echo  htmlspecialchars($_SESSION['campus_nome']);unset($_SESSION['campus_nome']); ?>" required>
                        <?php foreach($campi as $campus): ?>
						<option value="<?php echo $campus->getcnpj(); ?>"><?php echo $campus->endereco()->getcidade(); ?></option>
						<?php endforeach;?> 
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Curso</label>
                      <select class="form-control" id="cursos" value="<?php if(!empty($_SESSION['curso_nome'])) echo  htmlspecialchars($_SESSION['curso_nome']);unset($_SESSION['curso_nome']); ?>" required>
                       
                      </select>
                    </div>
                    <div class="form-group">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="integral" id="" value="option1" checked>
                          Integral
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="matutino" id="" value="option2">
                          Matutino
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="vespertino" id="" value="option3">
                          Vespertino
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="noturno" id="" value="option4">
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
	<script>
		var options = {
		<?php 
		foreach($campi as $campus): 
		?>
			<?php echo $campus->getcnpj() ?> : 
			{
					<?php 
						foreach($cursos[$campus->getcnpj()] as $curso): 
					?>
					<?php 
						echo "\"$curso->getnome()\" : \"$curso->getid()\"";
					?>
					<?php
						endforeach;
					?>
		<?php 
		endforeach;
		?>
		};
		 $("#cursos"),select(function(){
		 	var $el = $(this);
			$el.empty();
			$.each(options[el.val()], function(key,value) {
			  $el.append($("<option></option>")
				 .attr("value", value).text(key));
			});	
		 }); 
		
	</script>
  </body>
</html>
