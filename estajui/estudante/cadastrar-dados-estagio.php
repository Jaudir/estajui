<!DOCTYPE html>
<?php
  require_once('../../scripts/controllers/base-controller.php');
  $session = getSession();

  function printErrorFeedback($error){
    echo '<span class="error">';
    echo $error[0];
    echo '</span>';
  }

  function printError($index){
    global $session;

    if($session->hasError($index))
      printErrorFeedback($session->getErrors($index));
  }

  function printValue($index){
    global $session;

    if($session->hasValues($index))
      echo 'value="' . $session->getValues($index)[0] . '"';
  }

  function selectOption($index, $opt){
    global $session;
    if($session->getValues($index) == $opt)
      echo 'selected';
  }

  $_POST['estagio'] = 1;
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cadastro de Estágio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
  </head>
  <body>
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light nav-menu">
        <a class="navbar-brand" href="#">
          <img src="../../assets/img/LOGO.PNG" height="42" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="nav-content navbar-nav">
            <li class="nav-item">
              <a href="home-preencher-dados.html"><button type="button" class="btn btn-outline-light bt-sair">Voltar</button></a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="row">
        <div class="offset-lg-2 col-lg-8 content-form-cadastro">
          <div class="row form-title">
            <div class="col-md-12">
              <h3>Informe os dados do estágio</h3>
            </div>
          </div>
          <form class="container" id="needs-validation" method="post" action="<?php echo base_url() . '/scripts/controllers/estudante/cadastrar-estagio.php'?>" novalidate>
            <input name='estagio' type='hidden' value="<?php echo $_POST['estagio']?>">
            <div class="row">
              <div class="col-md-12 form-sub-title">
                <h3>Dados da empresa</h3>
              </div>
            </div>
            <section>
              <div class="row">
                <div class="col-md-12 mb-3">
                  <h6> Busque e selecione a empresa onde será feito o estágio. </h6>
                  <div class="input-group">
                    <input class="form-control" type="search" id="search" 
                    placeholder="Buscar empresa .." aria-label="Pesquisar" 
                    aria-describedby="buscarEmpresaHelp" required>
                    <button id="search-btn" type="button" class="input-group-addon"><i class="fa fa-search"></i></button>
                  </div>
                  <small id="buscarEmpresaHelp" class="form-text text-muted">
                     Caso a empresa não esteja cadastrada preencha os campos abaixo.
                  </small>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom03">Nome fantasia</label>
                    <input <?php printValue('nome_fantasia');?> name="nome_fantasia" type="text" class="form-control" id="validationCustom03" required>
                    <?php printError('nome_fantasia'); //Por favor, informe um nome válido.?>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="cnpj">CNPJ</label>
                    <input <?php printValue('cnpj')?> name="cnpj" type="text" class="form-control" id="cnpj" required>
                    <?php printError('cnpj'); // Por favor, informe um CNPJ válido.?>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="validationCustom04">Razão Social</label>
                    <input <?php printValue('razao_social')?> name="razao_social" type="text" class="form-control" id="validationCustom04" required>
                    <?php printError('razao_social'); //Por favor, informe a razão social.?>
                  </div>
                  <div class="col-md-8 mb-3">
                    <label for="validationCustom11">Logradouro</label>
                    <input <?php printValue('logradouro')?> name="logradouro" type="text" class="form-control" id="validationCustom11" placeholder="Rua, Av., etc." required>
                    <?php printError('logradouro'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label for="validationCustom13">Número</label>
                    <input <?php printValue('numero')?> name="numero" type="text" class="form-control" id="validationCustom13" required>
                    <?php printError('numero'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="validationCustom12">Bairro</label>
                    <input <?php printValue('bairro')?> name="bairro" type="text" class="form-control" id="validationCustom12" required>
                    <?php printError('bairro'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="validationCustom15">Sala</label>
                    <input <?php printValue('sala')?> name="sala" type="text" class="form-control" id="validationCustom15">
                    <?php printError('sala'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-3 mb-2">
                    <label for="cep">CEP</label>
                    <input <?php printValue('cep')?> name="cep" type="text" class="form-control" id="cep" required>
                    <?php printError('cep'); //Por favor, informe um CEP válido.?>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="validationCustom16">Cidade</label>
                    <input <?php printValue('cidade')?> name="cidade" type="text" class="form-control" id="validationCustom16" required>
                    <?php printError('cidade'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="validationCustom17">Estado</label>
                    <select name="estado" class="form-control" required>
                      <option <?php selectOption('estado', 'MG') ?> value="MG">Minas Gerais</option>
                      <option <?php selectOption('estado', 'BA') ?> value="BA">Bahia</option>
                    </select>
                    <?php printError('estado'); //Selecione um estado.?>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="telefone">Telefone</label>
                    <input <?php printValue('telefone')?> name="telefone" type="text" class="form-control" id="telefone" placeholder="(DD) 9999-9999" required>
                    <?php printError('telefone'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom18">FAX</label>
                    <input <?php printValue('fax')?> name="fax" type="text" class="form-control" id="validationCustom18">
                    <?php printError('fax'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="validationCustom20">Nº de registro</label>
                    <input <?php printValue('nregistro')?> name="nregistro" type="text" class="form-control" id="validationCustom20" required>
                    <?php printError('nregistro'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom21">Conselho de fiscalização</label>
                    <input <?php printValue('conselhofiscal')?> name="conselhofiscal" type="text" class="form-control" id="validationCustom21" required>
                    <?php printError('conselhofiscal'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="validationCustom22">Nome do responsável</label>
                    <input <?php printValue('nome_responsavel')?> name="nome_responsavel" type="text" class="form-control" id="validationCustom22" required>
                    <?php printError('nome_responsavel'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="tel-resp">Telefone do responsável</label>
                    <input <?php printValue('telefone_responsavel')?> name="telefone_responsavel" type="text" class="form-control" id="tel-resp" placeholder="(DD) 9999-9999" required>
                    <?php printError('telefone_responsavel'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="validationCustom24">Email</label>
                    <input <?php printValue('email_responsavel')?> name="email_responsavel" type="text" class="form-control" id="validationCustom24" required>
                    <?php printError('email_responsavel'); //Preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom25">Cargo ocupado</label>
                    <input <?php printValue('cargo_responsavel')?> name="cargo_responsavel" type="text" class="form-control" id="validationCustom25" required>
                    <?php printError('cargo_responsavel'); //Preencha este campo.?>
                  </div>
              </div>
            </section>
            <div class="row">
              <div class="col-md-12 form-sub-title">
                <h3>Dados do supervisor de estágio</h3>
              </div>
            </div>
            <section>
              <div class="row" id="secao-supervisor">
                  <div class="col-md-12 mb-3">
                    <label for="validationCustom26">Nome do supervisor</label>
                    <input <?php printValue('nome_supervisor')?> name="nome_supervisor" type="text" class="form-control" id="validationCustom26" required>
                    <?php printError('nome_supervisor'); //Por favor, informe um nome válido.?>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom27">Habilitação profissional</label>
                    <input <?php printValue('habilitacao')?> name="habilitacao" type="text" class="form-control" id="validationCustom27" required>
                    <?php printError('habilitacao'); //Por favor, preencha este campo.?>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="validationCustom28">Cargo</label>
                    <input <?php printValue('cargo')?> name="cargo" type="text" class="form-control" id="validationCustom28" required>
                    <?php printError('cargo'); //Por favor, preencha este campo.?>
                  </div>
                </div>
              </section>
              <div class="row">
                <div class="col-md-12 form-sub-title">
                  <h3>Dados do estágio</h3>
                </div>
              </div>
              <section>
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom29">Setor/Unidade</label>
                      <input <?php printValue('setor')?> name="setor" type="text" class="form-control" id="validationCustom29" required>
                      <?php printError('setor'); //Por favor, preencha este campo.?>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="validationCustom30">Data de início</label>
                      <input <?php printValue('data_inicio')?> name="data_inicio" type="date" class="form-control" id="validationCustom30" required>
                      <?php printError('data_inicio'); //Por favor, preencha este campo.?>
                      <small id="dataIniHelp" class="form-text text-muted">
                         Previsão de início.
                      </small>
                    </div>

                    <div class="col-md-3 mb-3">
                      <label for="validationCustom31">Data de término</label>
                      <input <?php printValue('data_termino')?> name="data_termino" type="date" class="form-control" id="validationCustom31" required>
                      <?php printError('data_termino'); //Por favor, preencha este campo.?>
                      <small id="dataFimHelp" class="form-text text-muted">
                         Previsão de término.
                      </small>
                    </div>

                    <div class="col-md-12 mb-3">
                      <label for="validationCustom32">Atividades principais a serem desenvolvidas: </label>
                      <textarea name="atividades" rows="6" class="form-control" id="validationCustom32" required><?php if($session->hasValues('atividades')) echo $session->getValues('atividades')[0]?></textarea>
                      <?php printError('atividades'); //Por favor, preencha este campo.?>
                    </div>

                    <div class="col-md-6 mb-2">
                      <label for="validationCustom33">Ínicio da jornada de trabalho:</label>
                      <input <?php printValue('inicio_jornada')?> name="inicio_jornada" type="text" class="form-control" id="validationCustom33" placeholder="HH:mm" required>
                      <?php printError('inicio_jornada'); //Por favor, preencha este campo.?>
                      <small id="dataFimHelp" class="form-text text-muted">
                         Horas e minutos do ínicio.
                      </small>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label for="validationCustom34">Término da jornada de trabalho</label>
                      <input <?php printValue('termino_jornada')?> name="termino_jornada" type="text" class="form-control" id="validationCustom34" placeholder="HH:mm" required>
                      <?php printError('termino_jornada'); //Por favor, preencha este campo.?>
                      <small id="dataFimHelp" class="form-text text-muted">
                         Horas e minutos do término.
                      </small>
                    </div>

                    <div class="col-md-12 mb-2">
                      <label for="validationCustom35">Total de horas semanais:</label>
                      <input <?php printValue('horas_semanais')?> name="horas_semanais" type="text" class="form-control" id="validationCustom35" placeholder="HH:mm" required>
                      <?php printError('horas_semanais'); //Por favor, preencha este campo.?>
                      <small id="dataFimHelp" class="form-text text-muted">
                         Total de horas semanais.
                      </small>
                    </div>
                  </div>
              </section>
              <div class="row">
                <div class="col-md-12" style="margin-top: 30px;">
                  <button id="cadastrar" class="btn btn-success" type="submit">Cadastrar</button>
                  <button class="btn btn-danger" type="submit">Cancelar</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- SCRIPTS -->
    <script src="../../assets/js/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../../assets/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="../../assets/js/masks.js" type="text/javascript"></script>
    <script src="../../assets/js/search-box.js" type="text/javascript"></script>
    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
          // Example starter JavaScript for disabling form submissions if there are invalid fields
          $(function() {
          <?php if($session->hasValues('resultado')):?>
            alert(<?php echo "\"" . $session->getValues('resultado')[0] ."\""?>);
          <?php elseif($session->hasError('estagio')):?>
            alert(<?php echo "\"" . $session->getErrors('estagio')[0] . "\""?>);
          <?php elseif($session->hasError('normal')):?>
            alert(<?php echo "\"" . $session->getErrors('normal')[0] . "\""?>);
          <?php endif;?>

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
          
            $('#cadastrar').click(function(){
              $('#needs-validation').submit();
            });
          });
          </script>
        </div>
      </div>
    </div>
</body>
</html>
