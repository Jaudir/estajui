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
                <?php echo $aluno->getnome();?>
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
                <tbody>
				  <?php
                    $row_id = 1;
                    foreach($listaEstagios as $le):
                  ?>
                  <tr>
                    <th scope="row" id="<?php echo $row_id; ?>"><?php echo $row_id; ?></th>
                    <td><?php echo $le->getpe()->get_data_inicio();?></td>
                    <td><?php echo $le->getempresa()->get_nome();?></td>
                    <td><?php echo $le->getstatus()->get_descricao(); ?></td>
                    <td><?php echo $le->getfuncionario()->getnome();?></td>
                    <td class="center">
					  <button type="button" class="btn btn-link ver" 
					    data-toggle="modal" data-target="#detalhesEstagio<?php echo $row_id++;?>" data-id="<?php echo $row_id; ?>">
                        <i class="fa fa-eye"></i>
                      </button>
                    </td>
                  </tr>
				  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- MODAL para mostrar detalhes do estágio -->
		<?php
            $rid = 1;
             foreach($listaEstagios as $le):
        ?>
        <div class="modal fade" id="detalhesEstagio<?php echo $rid;?>" tabindex="-1" role="dialog" aria-labelledby="detalhesEstagioTitle" aria-hidden="true">
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
                    <h6>Status: </h6> <p><?php echo $le->getstatus()->get_descricao();?></p><br>
                    <h6>Nº da apólice seguradora: </h6> <p><?php echo $le->getapolice()->get_numero(); ?></p><br>
                    <h6>Nome da seguradora: </h6> <p><?php echo $le->getapolice()->get_seguradora(); ?></p> <br>
					<h6>Supervisor: </h6> <p><?php echo $le->getsupervisor()->get_nome(); ?></p> <br>
                    <h6>Habilitação profissional: </h6> <p><?php echo $le->getsupervisor()->get_habilitacao(); ?></p> <br>
                    <h6>Cargo: </h6> <p><?php echo $le->getsupervisor()->get_cargo(); ?></p> <br>
                    <h6>Professor orientador: </h6> <p><?php echo $le->getfuncionario()->getnome(); ?></p> <br>
                    <h6>Formação profissional: </h6> <p><?php echo $le->getfuncionario()->getformacao(); ?></p> <br>
                    <h6>Data prevista para ínicio do estágio: </h6> <p><?php echo date('d/m/Y', strtotime($le->getpe()->get_data_inicio()));?></p> <br>
                    <h6>Data prevista para término do estágio: </h6> <p><?php echo date('d/m/Y', strtotime($le->getpe()->get_data_fim()));?></p> <br>
                    <h6>Jornada: </h6> <p>
					
					<?php /*$data01 = substr($le->getpe()->get_hora_inicio1(), 0, -9); 
					echo date('d/m/Y', strtotime($data01));*/
					$hora01 = substr($le->getpe()->get_hora_inicio1(), 11);
					echo " das ".$hora01; ?> até
					
					<?php /*$data02 = substr($le->getpe()->get_hora_fim1(), 0, -9); 
					echo date('d/m/Y', strtotime($data02));*/
					$hora02 = substr($le->getpe()->get_hora_fim1(), 11);
					echo " as ".$hora02; ?> e 
					
					<?php /*$data03 = substr($le->getpe()->get_hora_inicio2(), 0, -9); 
					echo date('d/m/Y', strtotime($data03));*/
					$hora03 = substr($le->getpe()->get_hora_inicio2(), 11);
					echo " das ".$hora03; ?> até
					
					<?php /*$data04 = substr($le->getpe()->get_hora_fim2(), 0, -9); 
					echo date('d/m/Y', strtotime($data04));*/
					$hora04 = substr($le->getpe()->get_hora_fim2(), 11);
					echo " as ".$hora04; ?> totalizando 
					
					<?php echo $le->getpe()->get_total_horas(); ?> horas
					
					
					semanais</p> <br>
                    <h6>Principais atividdes a serem desenvolvidas: </h6> <p><?php echo $le->getpe()->get_atividades(); ?></p> <br>
                    <h6>Nome fantasia da empresa: </h6> <p><?php echo $le->getempresa()->get_nome(); ?></p> <br>
                    <h6>CNPJ: </h6> <p><?php echo $le->getempresa()->get_cnpj(); ?></p> <br>
                    <h6>Telefone: </h6> <p><?php echo $le->getempresa()->get_telefone(); ?></p> <br>
                    <h6>FAX: </h6> <p> <?php echo $le->getempresa()->get_fax(); ?> </p> <br>
                    <h6>Logradouro: </h6> <p><?php echo $le->getempresa()->get_endereco()->getlogradouro(); ?></p> <br>
                    <h6>Número: </h6> <p><?php echo $le->getempresa()->get_endereco()->getnumero(); ?></p> <br>
                    <h6>Bairro: </h6> <p> <?php echo $le->getempresa()->get_endereco()->getbairro(); ?> </p> <br>
                    <h6>Cidade: </h6> <p> <?php echo $le->getempresa()->get_endereco()->getcidade(); ?> </p> <br>
                    <h6>Estado: </h6> <p> <?php echo $le->getempresa()->get_endereco()->getuf(); ?> </p> <br>
                    <h6>CEP: </h6> <p> <?php echo $le->getempresa()->get_endereco()->getcep(); ?> </p> <br>
                    <h6>Nº de registro da empresa: </h6> <p> <?php echo $le->getempresa()->get_nregistro(); ?> </p> <br>
                    <h6>Conselho de fiscalização: </h6> <p><?php echo $le->getempresa()->get_conselhofiscal(); ?> </p> <br>
					<?php $rid++?>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                <button type="button" class="btn btn-primary">Confirmar</button>
              </div>
            </div>
          </div>
        </div>
		<?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script>
		let idlinha;
		$('table').on('click', '.ver', function() {
			idlinha = $(this).attr('data-id');
			idlinha = (parseInt(idlinha)) - 1;
		});
	</script>
  </body>
</html>