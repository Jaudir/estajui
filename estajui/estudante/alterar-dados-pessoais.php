<!DOCTYPE html>
<?php
  require_once('../../scripts/controllers/base-controller.php');

  $session = getSession();

  //comentar quando não estiver testando
  $loader->loadDao('Aluno');
  $session->setUsuario(new Aluno(
    'email@email50.com',
    '101',
    1,
    "12345678100",
    "João",
    DateTime::createFromFormat("d/m/Y", "12/12/1990"),
    "21341324",
    "SD",
    "solteiro",
    "masc",
    124314,
    123412,
    "Pai",
    "Mae",
    "MOC",
    "MG",
    10,
    new Endereco(
      1,
      "Logradouro",
      "bairro",
      123,
      "Complemento",
      "MOC",
      "MG",
      12313,null
    )
  ));

  $usuario = $session->getUsuario();
  $endereco = $usuario->getEndereco();
  //$errors = $session->getErrors();
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Meus Dados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/main.css">
  </head>
  <body>
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light nav-menu">
        <a class="navbar-brand" href="#">
          <img src="<?php echo base_url();?>/assets/img/logo.png" height="42" class="d-inline-block align-top" alt="">
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
          <form class="container" id="needs-validation" novalidate method="POST" action="<?php echo base_url()?>/scripts/controllers/persiste_alteracao.php">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom01">Nome completo</label>
                <input name="nome" value="<?php echo htmlspecialchars($usuario->getnome()); ?>" type="text" class="form-control" id="validationCustom01" placeholder="" >
                <div class="invalid-feedback">
                  Por favor, informe seu nome completo.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom02">CPF</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="023.010.123-12"  required>
              </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom03">Nº de identidade</label>
                  <input type="text" class="form-control" id="validationCustom03" placeholder="16781491"  required>
                </div>
                <div class="col-md-6 mb-2">
                  <label for="validationCustom04">Orgão expedidor</label>
                  <input name="orgao_exp" value="<?php echo  htmlspecialchars($usuario->getrg_orgao()); ?>" type="text" class="form-control" id="validationCustom04" placeholder="PCMG" >
                  <div class="invalid-feedback">
                    Por favor, informe o orgão expedidor da identidade.
                  </div>
                </div>
              </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom05">Cidade natal</label>
                <input name="cidade_natal" value="<?php echo htmlspecialchars($usuario->getcidade_natal());?>" type="text" class="form-control" id="validationCustom05" placeholder="Montes Claros" >
                <div class="invalid-feedback">
                  Por favor, informe sua cidade natal.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom06">Estado natal</label>
                <select name="estado_natal" value="<?php echo  htmlspecialchars($usuario->getestado_natal());?>" class="form-control" >
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
                <input type="text" class="form-control" id="validationCustom06" placeholder="DD/MM/AAAA" >
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom07">Sexo</label>
                <select name="sexo" value="<?php echo  htmlspecialchars($usuario->getsexo()); ?>" class="form-control">
                  <option>Feminino</option>
                  <option>Masculino</option>
                  <option>Outro</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="validationCustom08">Estado civil</label>
                <select name="estado_civil" value="<?php echo  htmlspecialchars($usuario->getestado_civil());?>" class="form-control">
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
                <input name="nome_mae" value="<?php echo  htmlspecialchars($usuario->getnome_mae());?>" type="text" class="form-control" id="validationCustom09" placeholder="Maria Joaquina Rodrigues" >
                <div class="invalid-feedback">
                  Por favor, informe um nome.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom10">Nome do pai</label>
                <input name="nome_pai" value="<?php htmlspecialchars($usuario->getnome_pai());?>" type="text" class="form-control" id="validationCustom03" placeholder="José Pereira Alberte" >
                <div class="invalid-feedback">
                  Por favor, informe um nome.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="validationCustom11">Logradouro</label>
                <input name="logradouro" value="<?php echo  htmlspecialchars($endereco->getlogradouro());?>" type="text" class="form-control" id="validationCustom11" placeholder="Rua: Qualquer coisa" >
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom12">Bairro</label>
                <input name="bairro" value="<?php echo  htmlspecialchars($endereco->getbairro());?>" type="text" class="form-control" id="validationCustom12" placeholder="Fim do mundo" >
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-2 mb-2">
                <label for="validationCustom13">Número</label>
                <input name="numero" value="<?php echo  htmlspecialchars($endereco->getnumero());?>" type="text" class="form-control" id="validationCustom13" placeholder="22" >
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-2 mb-2">
                <label for="validationCustom14">CEP</label>
                <input name="cep" value="<?php echo  htmlspecialchars($endereco->getcep());?>" type="text" class="form-control" id="validationCustom14" placeholder="38425-098" >
                <div class="invalid-feedback">
                  Por favor, informe um CEP válido.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="validationCustom15">Complemento</label>
                <input value="<?php echo  htmlspecialchars($endereco->getcomplemento());?>" type="text" class="form-control" id="validationCustom15">
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom16">Cidade</label>
                <input name="cidade" value="<?php echo  htmlspecialchars($endereco->getcidade());?>" type="text" class="form-control" id="validationCustom16" placeholder="Montes Claros" >
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom17">Estado</label>
                <select name="uf" value="<?php echo  htmlspecialchars($endereco->getuf());?>" class="form-control" >
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
                <input name="celular" value="<?php echo  htmlspecialchars($usuario->getcelular());?>" type="text" class="form-control" id="validationCustom18" placeholder="(DDD) 9999-9999" >
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom19">Telefone fixo</label>
                <input value="<?php echo  htmlspecialchars($usuario->gettelefone());?>" type="text" class="form-control" id="validationCustom19">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom20">Email</label>
                <input type="text" class="form-control" id="validationCustom20" placeholder=""  required>
                <div class="invalid-feedback">
                  Por favor, informe um e-mail válido.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom23">Senha</label>
                <input name="senha" value="<?php echo  htmlspecialchars($usuario->getsenha());?>" type="password" class="form-control" id="validationCustom23" >
                <div class="invalid-feedback">
                  Por favor, informe um senha coerente.
                </div>
            
            <span class="error">
              <?php

                  if (!empty($errors['senha_erro2'])) {
                    echo " Por favor, informe um senha coerente.<br>Minímo: 8 digítos.";
                    unset($errors['senha_erro2']);
                }
              ?>
            </span>
            <span class="error">
                <?php

                  if (!empty($errors['senha_erro1'])) {
                    echo $errors['senha_erro1'];
                  }

                ?>
            </span>
          </div>
          
          <div class="col-md-6 mb-3">
                    <label for="validationCustom23">Confirmação de senha</label>
                    <input name="senha_confirmacao" value="<?php if(!empty($errors['senha_confirmacao'])) echo  htmlspecialchars($errors['senha_confirmacao']);unset($errors['senha_confirmacao']); ?>" name="senha_confirmacao"type="password" class="form-control" id="validationCustom23" >
                    <div class="invalid-feedback">
                      Por favor, informe um senha coerente.
                    </div>
                    <span class="error">
                    <?php

                      if (!empty($errors['senha_erro1'])) {
                          echo $errors['senha_erro1'];
                          unset($errors['senha_erro1']);
                      }
                    ?>

                  </div>
            
              </div>
              <div class="row">
                <div class="col-md-12" style="margin-top: 30px;">
                  <input class="btn btn-success" type="submit" value="Alterar">
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
