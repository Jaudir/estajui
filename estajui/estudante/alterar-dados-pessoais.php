<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Meus Dados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body>
    <div class="container-fluid">
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

      <div class="row">
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

        <div class="col-lg-10 align-self-center content-alterar-dados">
          <form class="container" id="needs-validation" novalidate method="POST" action="persiste_cadastro.php">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom01">Nome completo</label>
                <input value="<?php if(!empty($_SESSION['nome'])) echo  htmlspecialchars($_SESSION['nome']); unset($_SESSION['nome']); ?>" type="text" class="form-control" id="validationCustom01" placeholder="Igor Alberte Rodrigues" readonly>
                <div class="invalid-feedback">
                  Por favor, informe seu nome completo.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom02">CPF</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="023.010.123-12" readonly required>
              </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom03">Nº de identidade</label>
                  <input type="text" class="form-control" id="validationCustom03" placeholder="16781491" readonly required>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="validationCustom04">Orgão expedidor</label>
                  <input value="<?php if(!empty($_SESSION['orgao_exp'])) echo  htmlspecialchars($_SESSION['orgao_exp']); unset($_SESSION['orgao_exp']); ?>" type="text" class="form-control" id="validationCustom04" placeholder="PCMG" readonly>
                  <div class="invalid-feedback">
                    Por favor, informe o orgão expedidor da identidade.
                  </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom05">Cidade natal</label>
                <input value="<?php if(!empty($_SESSION['cidade_natal'])) echo  htmlspecialchars($_SESSION['cidade_natal']); unset($_SESSION['cidade_natal']);?>" type="text" class="form-control" id="validationCustom05" placeholder="Montes Claros" readonly>
                <div class="invalid-feedback">
                  Por favor, informe sua cidade natal.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom06">Estado natal</label>
                <select value="<?php if(!empty($_SESSION['estado_natal'])) echo  htmlspecialchars($_SESSION['estado_natal']);unset($_SESSION['estado_natal']); ?>" class="form-control" readonly>
                  <option value = "AC">Acre</option>
                  <option value = "AL">Alagoas</option>
                  <option value = "AP">Amapá</option>
                  <option value = "AM">Amazonas</option>
                  <option value = "BA">Bahia</option>
                  <option value = "CE">Ceará</option>
                  <option value = "DF">Distrito Federal</option>
                  <option value = "ES">Espírito Santo</option>
                  <option value = "GO">Goiás</option>
                  <option value = "MA">Maranhão</option>
                  <option value = "MT">Mato Grosso</option>
                  <option value = "MS">Mato Grosso do Sul</option>
                  <option value = "MG">Minas Gerais</option>
                  <option value = "PA">Pará</option>
                  <option value = "PB">Paraíba</option>
                  <option value = "PR">Paraná</option>
                  <option value = "PE">Pernambuco</option>
                  <option value = "PI">Piauí</option>
                  <option value = "RJ">Rio de Janeiro</option>
                  <option value = "RN">Rio Grande do Norte</option>
                  <option value = "RS">Rio Grande do Sul</option>
                  <option value = "RO">Rondônia</option>
                  <option value = "RR">Roraima</option>
                  <option value = "SC">Santa Catarina</option>
                  <option value = "SP">São Paulo</option>
                  <option value = "SE">Sergipe</option>
                  <option value = "TO">Tocantins</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="validationCustom06">Data de nascimento</label>
                <input type="text" class="form-control" id="validationCustom06" placeholder="DD/MM/AAAA" readonly>
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom07">Sexo</label>
                <select value="<?php if(!empty($_SESSION['sexo'])) echo  htmlspecialchars($_SESSION['sexo']); unset($_SESSION['sexo']); ?>" class="form-control">
                  <option>Feminino</option>
                  <option>Masculino</option>
                  <option>Outro</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="validationCustom08">Estado civil</label>
                <select value="<?php if(!empty($_SESSION['estado_civil'])) echo  htmlspecialchars($_SESSION['estado_civil']); unset($_SESSION['estado_civil']);?>" class="form-control">
                  <option>Solteiro(a)</option>
                  <option>Casado(a)</option>
                  <option>Divorciado(a)</option>
                  <option>Viúvo(a)</option>
                  <option>Separado(a)</option>
                  <option>União Estável</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom09">Nome da mãe</label>
                <input value="<?php if(!empty($_SESSION['nome_mae'])) echo  htmlspecialchars($_SESSION['nome_mae']);unset($_SESSION['nome_mae']); ?>" type="text" class="form-control" id="validationCustom09" placeholder="Maria Joaquina Rodrigues" readonly>
                <div class="invalid-feedback">
                  Por favor, informe um nome.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom10">Nome do pai</label>
                <input value="<?php if(!empty($_SESSION['nome_pai'])) echo  htmlspecialchars($_SESSION['nome_pai']); unset($_SESSION['nome_pai']);?>" type="text" class="form-control" id="validationCustom03" placeholder="José Pereira Alberte" readonly>
                <div class="invalid-feedback">
                  Por favor, informe um nome.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="validationCustom11">Logradouro</label>
                <input value="<?php if(!empty($_SESSION['logradouro'])) echo  htmlspecialchars($_SESSION['logradouro']); unset($_SESSION['logradouro']);?>" type="text" class="form-control" id="validationCustom11" placeholder="Rua: Qualquer coisa" readonly>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom12">Bairro</label>
                <input value="<?php if(!empty($_SESSION['bairro'])) echo  htmlspecialchars($_SESSION['bairro']); unset($_SESSION['bairro']);?>" type="text" class="form-control" id="validationCustom12" placeholder="Fim do mundo" readonly>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-2 mb-2">
                <label for="validationCustom13">Número</label>
                <input value="<?php if(!empty($_SESSION['numero'])) echo  htmlspecialchars($_SESSION['numero']); unset($_SESSION['numero']);?>" type="text" class="form-control" id="validationCustom13" placeholder="22" readonly>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-2 mb-2">
                <label for="validationCustom14">CEP</label>
                <input value="<?php if(!empty($_SESSION['cep'])) echo  htmlspecialchars($_SESSION['cep']); unset($_SESSION['cep']); ?>" type="text" class="form-control" id="validationCustom14" placeholder="38425-098" readonly>
                <div class="invalid-feedback">
                  Por favor, informe um CEP válido.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="validationCustom15">Complemento</label>
                <input value="<?php if(!empty($_SESSION['complemento'])) echo  htmlspecialchars($_SESSION['complemento']);unset($_SESSION['complemento']); ?>" type="text" class="form-control" id="validationCustom15">
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom16">Cidade</label>
                <input value="<?php if(!empty($_SESSION['cidade'])) echo  htmlspecialchars($_SESSION['cidade']); unset($_SESSION['cidade']); ?>" type="text" class="form-control" id="validationCustom16" placeholder="Montes Claros" readonly>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom17">Estado</label>
                <select value="<?php if(!empty($_SESSION['uf'])) echo  htmlspecialchars($_SESSION['uf']); unset($_SESSION['uf']);?>" class="form-control" readonly>
                  <option value = "AC">Acre</option>
                  <option value = "AL">Alagoas</option>
                  <option value = "AP">Amapá</option>
                  <option value = "AM">Amazonas</option>
                  <option value = "BA">Bahia</option>
                  <option value = "CE">Ceará</option>
                  <option value = "DF">Distrito Federal</option>
                  <option value = "ES">Espírito Santo</option>
                  <option value = "GO">Goiás</option>
                  <option value = "MA">Maranhão</option>
                  <option value = "MT">Mato Grosso</option>
                  <option value = "MS">Mato Grosso do Sul</option>
                  <option value = "MG">Minas Gerais</option>
                  <option value = "PA">Pará</option>
                  <option value = "PB">Paraíba</option>
                  <option value = "PR">Paraná</option>
                  <option value = "PE">Pernambuco</option>
                  <option value = "PI">Piauí</option>
                  <option value = "RJ">Rio de Janeiro</option>
                  <option value = "RN">Rio Grande do Norte</option>
                  <option value = "RS">Rio Grande do Sul</option>
                  <option value = "RO">Rondônia</option>
                  <option value = "RR">Roraima</option>
                  <option value = "SC">Santa Catarina</option>
                  <option value = "SP">São Paulo</option>
                  <option value = "SE">Sergipe</option>
                  <option value = "TO">Tocantins</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom18">Celular</label>
                <input value="<?php if(!empty($_SESSION['celular'])) echo  htmlspecialchars($_SESSION['celular']); unset($_SESSION['celular']);?>" type="text" class="form-control" id="validationCustom18" placeholder="(DDD) 9999-9999" readonly>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom19">Telefone fixo</label>
                <input value="<?php if(!empty($_SESSION['telefone'])) echo  htmlspecialchars($_SESSION['telefone']); unset($_SESSION['telefone']);?>" type="text" class="form-control" id="validationCustom19">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom20">Email</label>
                <input type="text" class="form-control" id="validationCustom20" placeholder="igoralberte@gmail.com" readonly required>
                <div class="invalid-feedback">
                  Por favor, informe um e-mail válido.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom23">Senha</label>
                <input value="<?php if(!empty($_SESSION['senha'])) echo  htmlspecialchars($_SESSION['senha']);unset($_SESSION['senha']); ?>" type="password" class="form-control" id="validationCustom23" readonly>
                <div class="invalid-feedback">
                  Por favor, informe um senha coerente.
                </div>
				  
				<span class="error">
                	<?php

                  		if (!empty($_SESSION['senha_erro2'])) {
                   		   echo " Por favor, informe um senha coerente.<br>Minímo: 8 digítos.";
                     	   unset($_SESSION['senha_erro2']);
                 		 }
                	?>
              	  </span>
				  <span class="error">
						<?php

						  if (!empty($_SESSION['senha_erro1'])) {
							  echo $_SESSION['senha_erro1'];
						  }

						?>
                  	</span>
              </div>
				
			  <div class="col-md-6 mb-3">
                  <label for="validationCustom23">Confirmação de senha</label>
                  <input value="<?php if(!empty($_SESSION['senha_confirmacao'])) echo  htmlspecialchars($_SESSION['senha_confirmacao']);unset($_SESSION['senha_confirmacao']); ?>" name="senha_confirmacao"type="password" class="form-control" id="validationCustom23" readonly>
                  <div class="invalid-feedback">
                    Por favor, informe um senha coerente.
                  </div>
                  <span class="error">
                  <?php

                    if (!empty($_SESSION['senha_erro1'])) {
                        echo $_SESSION['senha_erro1'];
                        unset($_SESSION['senha_erro1']);
                    }
                  ?>

                </div>
				  
            </div>
            <div class="row">
              <div class="col-md-12" style="margin-top: 30px;">
                <button class="btn btn-success" type="submit">Alterar</button>
                <button class="btn btn-danger" type="submit">Cancelar</button>
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
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
