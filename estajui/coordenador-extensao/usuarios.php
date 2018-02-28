<!DOCTYPE html>
<?php
	
	//require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/controllers/busca-usuario.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Leciona.php';
	//require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Usuario.php';
	//require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Funcionario.php';
	//require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/OfereceCurso.php';
	//session_start();
	session_start();
	//session_unset();
	//session_destroy();
	
	
	//var_dump($_SESSION);
	
?>


<script>
	function mensagemSalvamento() {	
		
		if(<?php if(isset($_SESSION['erros'])) echo 0; else echo 1; ?>) {
			
			return ;
		}
		if(<?php if(isset($_SESSION['erros']) && $_SESSION['erros'] == 0) echo 1; else echo 0; ?>) {
			if(<?php if(isset($_SESSION['busca']) && $_SESSION['busca'] == true) echo 1; else echo 0; ?>) {
				<?php 
					$_SESSION['busca'] = null; 
				?>
				return ;
			}
			window.alert("Usuário cadastrado com sucesso!");
			
			<?php $_SESSION['erros'] = null; ?>
			return ;
		}
		else {
			var msg;
			var i;
			window.alert('<?php if (isset($_SESSION['mensagensErro'])) {foreach($_SESSION['mensagensErro'] as &$msg) echo $msg . " "; unset($msg); } ?>');
			
			<?php $_SESSION['erros'] = null;
			$_SESSION['mensagensErro'] = null; ?>
			return ;
		}
		
		<?php
			$_SESSION['erros'] = null;
			$_SESSION['mensagensErro'] = null;
		?>
		<?php /*unset($_SESSION['erros']);	unset($_SESSION['mensagensErro']); unset($_SESSION['pau1']); unset($_SESSION['pau12']); unset($_SESSION['curso']) */?>
	}
	
	function ocultarCursos() {
		document.getElementById("ministraAulas").style.display = "hidden";
	}
	
	function mostrarCursos() {
		//window.alert("Mudou");
		//window.alert(document.getElementById("vinculo").value);
		if(document.getElementById("vinculo").value == "Docente") {
			document.getElementById("ministraAulas").style.display = "block";
			document.getElementById("PO").disabled = false;
			document.getElementById("formacao").disabled = false;
			return ;
		}
		if(document.getElementById("vinculo").value == "Técnico administrativo") {
			
			document.getElementById("ministraAulas").style.display = "none";
			document.getElementById("PO").disabled = true;
			document.getElementById("formacao").disabled = true;
			return ;
		}
		document.getElementById("ministraAulas").style.display = "block";
		document.getElementById("PO").disabled = false;
		document.getElementById("formacao").disabled = false;
		
	}
	
	function preencherDados(posicao) {
		var idClicado = "nome"+posicao;
		
		document.getElementById("nome").value = document.getElementById(idClicado).innerHTML;
		
		idClicado = "siape"+posicao;
		document.getElementById("siape").value = document.getElementById(idClicado).innerHTML;
		document.getElementById("idUsuario").value = document.getElementById(idClicado).innerHTML;
		
		idClicado = "email"+posicao;
		document.getElementById("email").value = document.getElementById(idClicado).innerHTML;
		document.getElementById("confirmEmail").value = document.getElementById(idClicado).innerHTML;
		
		document.getElementById("siape").disabled = true;
		document.getElementById("email").disabled = true;
		document.getElementById("confirmEmail").disabled = true;
		
		idClicado = "CComp"+posicao;
		if (document.getElementById(idClicado) != null) 
			document.getElementById("CComp").checked = true;
		else
			document.getElementById("CComp").checked = false;
		
		idClicado = "EQuim"+posicao;
		if (document.getElementById(idClicado) != null) 
			document.getElementById("EQuim").checked = true;
		else
			document.getElementById("EQuim").checked = false;
		
		idClicado = "TecInf"+posicao;
		if (document.getElementById(idClicado) != null) 
			document.getElementById("TecInf").checked = true;
		else
			document.getElementById("TecInf").checked = false;
		
		idClicado = "TecQuim"+posicao;
		if (document.getElementById(idClicado) != null) 
			document.getElementById("TecQuim").checked = true;
		else
			document.getElementById("TecQuim").checked = false;
		
		idClicado = "TecElet"+posicao;
		if (document.getElementById(idClicado) != null) 
			document.getElementById("TecElet").checked = true;
		else
			document.getElementById("TecElet").checked = false;
		
		idClicado = "PO"+posicao;
		if (document.getElementById(idClicado) != null && document.getElementById(idClicado).innerHTML != "") 
			document.getElementById("PO").checked = true;
		else
			document.getElementById("PO").checked = false;
		
		idClicado = "CE"+posicao;
		if (document.getElementById(idClicado) != null && document.getElementById(idClicado).innerHTML != "") 
			document.getElementById("CE").checked = true;
		else
			document.getElementById("CE").checked = false;
		
		idClicado = "SRA"+posicao;
		if (document.getElementById(idClicado) != null && document.getElementById(idClicado).innerHTML != "") {
			document.getElementById("SRA").checked = true;
			document.getElementById("vinculo").options[2].selected = true;
			mostrarCursos();
		}
		else {
			document.getElementById("SRA").checked = false;
			document.getElementById("vinculo").options[1].selected = true;
			mostrarCursos();
		}
		
		idClicado = "OE"+posicao;
		if (document.getElementById(idClicado) != null && document.getElementById(idClicado).innerHTML != "") 
			document.getElementById("OE").checked = true;
		else
			document.getElementById("OE").checked = false;
		
		idClicado = "Privilegio"+posicao;
		if (document.getElementById(idClicado) != null && document.getElementById(idClicado).innerHTML != "")
			document.getElementById("Privilegio").checked = true;
		else
			document.getElementById("Privilegio").checked = false;
			
		idClicado = "Formacao"+posicao;
		document.getElementById("formacao").value = document.getElementById(idClicado).innerHTML;
		
		
		//window.alert(document.getElementById("idUsuario").value);
	}
	
	function Cancelar() {
		document.getElementById("nome").value = "";
		document.getElementById("siape").value = "";
		document.getElementById("email").value = "";
		document.getElementById("confirmEmail").value = "";
		document.getElementById("idUsuario").value = "";
		document.getElementById("CComp").checked = false;
		document.getElementById("EQuim").checked = false;
		document.getElementById("TecInf").checked = false;
		document.getElementById("TecQuim").checked = false;
		document.getElementById("TecElet").checked = false;
		document.getElementById("PO").checked = false;
		document.getElementById("CE").checked = false;
		document.getElementById("SRA").checked = false;
		document.getElementById("OE").checked = false;
		
		document.getElementById("siape").disabled = false;
		document.getElementById("email").disabled = false;
		document.getElementById("confirmEmail").disabled = false;
		
		//window.alert(document.getElementById("idUsuario").value);
	}
	
	function alterarPrivilegio() {
		if (document.getElementById("Privilegio").checked == true) {
			var r = confirm("Você realmente deseja transferir privilégios para outro usuário? Se sim, você será deslogado do sistema para efetuar a alteração");
			
			if(r == false) {
				document.forms['formCadastro'].onsubmit = function(){return false;}
			}
			else {
				document.forms['formCadastro'].onsubmit = function(){return true;}
			}
		}
	}
	
</script>
<html>
  <head>
    <meta charset="utf-8">
    <title>Usuários | Coordenação de Extensão </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
  </head>
  <body onload = "mensagemSalvamento()">
    <div class="container-home container-fluid">
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
              <form class="container" id="needs-validation" novalidate method="POST" action="../../scripts/controllers/persiste-usuario.php" name="formCadastro" id="formCadastro">
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="validationCustom01">Nome completo</label>
                    <input type="text" class="form-control" id="nome" id="validationCustom01" required type="text" name="nome" >
                    <div class="invalid-feedback">
                      Por favor, informe o nome completo.
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom03">SIAPE</label>
                      <input type="text" class="form-control" id="siape" id="validationCustom03" placeholder="" required type="number" name="siape" >

                      <div class="invalid-feedback">
                        Por favor, informe este campo.
                      </div>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label>Vínculo</label>
                      <select id="vinculo" onchange="mostrarCursos()" class="form-control" required name="vinculo" name="vinculo"  >
                        <option value="">...</option>
                        <option id = "Docente">Docente</option>
                        <option id = "TecAdmin">Técnico administrativo</option>
                      </select>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom05">Email</label>
                    <input type="text" class="form-control" id="email" id="validationCustom05" placeholder="" required type="email" name="email">
                    <div class="invalid-feedback">
                      Por favor, informe um e-mail válido.
                    </div>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label>Confirmação de email</label>
                    <input type="text" class="form-control" id="confirmEmail" id="validationCustom06" placeholder="" required type="confirmEmail" name="confirmEmail">
                    <div class="invalid-feedback">
                      Por favor, informe um e-mail válido.
                    </div>
					
					<label>Formação: </label>
					<input type="text" class="form-control" id="formacao" name="formacao">
					<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!     Se vazio, é um novo usuário  -->
					<input type="hidden" name="idUsuario" id="idUsuario" value=""></input>
					
					
					
					
					
					<!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!       -->
					
					
                  </div>
                </div>
                <div class="row" id="ministraAulas">
                  <div class="col-md-12" id="ministraAulas">
                    <h6>Caso seja docente, marque os cursos em que ele ministra aulas:</h6>
                  </div>
                  <div class="col-md-12 mb-2">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="CComp" class="custom-control-input" name="CComp" >
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Ciência da Computação</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="EQuim" class="custom-control-input" name="EQuim" >
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Engenharia Química</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="TecInf" class="custom-control-input" name="TecInf">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Técnico em Informática</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="TecQuim" class="custom-control-input" name="TecQuim">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Técnico em Química</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="TecElet" class="custom-control-input" name="TecElet" >
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
                      <input type="checkbox" id="PO" class="custom-control-input" name="PO">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Professor Orientador</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="CE" class="custom-control-input" name="CE" >
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Coordenador de Extensão</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="SRA" class="custom-control-input" name="SRA">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Secretaria</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" id="OE" class="custom-control-input" name="OE">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Organizador de Estágio</span>
                    </label>
					<label class="custom-control custom-checkbox">
                      <input type="checkbox" id="Privilegio" class="custom-control-input" name="Privilegio">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Privilégio</span>
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="margin-top: 30px;">
                    <button class="btn btn-success" type="submit" name="cadastrar" onClick="alterarPrivilegio()">Cadastrar</button>
                    <!--<button class="btn btn-danger" type="submit" name="cancelar" onClick="cancelar()">Cancelar</button>-->
					<button class="btn btn-danger" type = "button" name="cancelar" onClick="Cancelar()">Cancelar</button>
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
		  
		  <form method="POST" action="../../scripts/controllers/busca-usuario.php">
		  		  <label>Informe o texto de busca: </label>
				  <input type="text" name="campoBusca"> <br>
				  <input type="radio" name="tipoBusca" value="email">E-mail</input><br>
				  <input type="radio" name="tipoBusca" value="nome">Nome</input><br>
				  <button class="btn btn-success" type="submit" name="buscar">Buscar</button>
		  </form>
		  
		  
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
                    <!--<th scope="col">Vínculo</td>-->
                    <th scope="col">Curso</th>
                    <th scope="col">Permissões</th>
					<th scope="col">Formação</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Excluir</th>
                  </tr>
                </thead>
                <tbody>
					<?php
						if(isset($_SESSION["funcionarios"]) && isset($_SESSION["leciona"])) {
							$funcionarios = $_SESSION["funcionarios"];
							$leciona = $_SESSION["leciona"];
							
							$cont = 0;
							
							if($funcionarios == null || empty($funcionarios)) {
								?> <script> window.alert("A busca não obteve resultado!"); </script> <?php
							}
							
							foreach($funcionarios as $funcionario) {
								$lecionaAux = array();
								echo "<tr>";
								echo "<td id='nome".$cont."'>" . $funcionario->getnome() . "</td>"."\n";
								echo "<td id='email".$cont."'>" . $funcionario->getlogin() . "</td>"."\n";
								echo "<td id='siape".$cont."'>" . $funcionario->getsiape() . "</td>"."\n";
								echo "<td>";
								foreach($leciona as $l) {
									if($l->getfuncionario()->getlogin() == $funcionario->getlogin()) {
										if ($l->getoferececurso()->getcurso()->getid() == 1) echo "<span id='CComp" . $cont . "'>"."\n";
										if ($l->getoferececurso()->getcurso()->getid() == 2) echo "<span id='EQuim" . $cont . "'>"."\n";
										if ($l->getoferececurso()->getcurso()->getid() == 3) echo "<span id='TecInf" . $cont . "'>"."\n";
										if ($l->getoferececurso()->getcurso()->getid() == 4) echo "<span id='TecQuim" . $cont . "'>"."\n";
										if ($l->getoferececurso()->getcurso()->getid() == 5) echo "<span id='TecElet" . $cont . "'>"."\n";
										
										echo $l->getoferececurso()->getcurso()->getnome() . "</span><br>"."\n";
										array_push($lecionaAux, $l);
									}
								}
								echo "</td>"."\n";
								
								echo "<td>"."\n";
								echo "<span id='PO" . $cont . "'>" . ($funcionario->ispo() ? "Prof. Orient.<br><br>" : "")  . "</span>"."\n";
								echo "<span id='OE" . $cont . "'>" .($funcionario->isoe() ? "Org. Est.<br><br>" : "") . "</span>"."\n";
								echo "<span id='CE" . $cont . "'>" .($funcionario->isce() ? "Coord. Ext.<br><br>" : "") . "</span>"."\n";
								echo "<span id='SRA" . $cont . "'>" .($funcionario->issra() ? "SRA" : "") . "</span>"."\n";
									
								echo "\n<span id='Privilegio" . $cont . "'>" .($funcionario->isprivilegio() ? "Privilegio" : ""). "</span>";
								echo "</td>";
								
								
								//$link = "?cont=" . $cont . "&nome=".$funcionario->getnome()."&siape=".$funcionario->getsiape."&email=".$funcionario->getlogin();
								//$link .= http_build_query($lecionaAux);
								//$link .= "&po=" . $
								
								echo "<td>\n";
								echo "<span id='Formacao" . $cont . "'>".$funcionario->getformacao() . "</span>"."\n";
								echo "</td>\n";
								
								echo  "<td class='center red' > <a href='#'> <i class='fa fa-pencil' onClick='preencherDados(".(string)$cont.")'></i> </a> </td>";
                    				echo "<td class='center red'><a href='#'> <i class='fa fa-trash'></i> </a></td>";
                    				echo "</tr>";
								
								$_SESSION['busca'] = null;												
								
								$cont++;
							}
						}
					?>
                  <!--<tr>
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
                  </tr>-->

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
    <!-- SCRIPTS -->
	<script>
	
	</script>
	
    <script src="../../assets/js/jquery-1.9.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../../assets/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="../../assets/js/masks.js" type="text/javascript"></script>
    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
