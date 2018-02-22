<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Cadastro de Estágio</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
    crossorigin="anonymous">
  <link rel="stylesheet" href="../../assets/css/icons/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>

<body>
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light nav-menu">
      <a class="navbar-brand" href="#">
        <img src="../../assets/img/logo.png" height="42" class="d-inline-block align-top" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav-content navbar-nav">
          <li class="nav-item">
            <a href="home-preencher-dados.html">
              <button type="button" class="btn btn-outline-light bt-sair">Voltar</button>
            </a>
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
        <form class="container" id="needs-validation" method="POST" action="../../scripts/controllers/aluno/cadastrar-dados-estagio-empresa.php"
          novalidate>
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
                  <input class="form-control" type="search" id="search" placeholder="Buscar empresa .." aria-label="Pesquisar" aria-describedby="buscarEmpresaHelp"
                    required>
                  <button id="search-btn" type="button" class="input-group-addon">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
                <small id="buscarEmpresaHelp" class="form-text text-muted">
                  Caso a empresa não esteja cadastrada preencha os campos abaixo.
                </small>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="validationCustom03">Nome fantasia</label>
                <input type="text" class="form-control" name="nome_fantasia" id="validationCustom03" required>
                <div class="invalid-feedback">
                  Por favor, informe um nome válido.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" name="cnpj" id="cnpj" required>
                <div class="invalid-feedback">
                  Por favor, informe um CNPJ válido.
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <label for="validationCustom04">Razão Social</label>
                <input type="text" class="form-control" name="razao_social" id="validationCustom04" required>
                <div class="invalid-feedback">
                  Por favor, informe a razão social.
                </div>
              </div>
              <div class="col-md-8 mb-3">
                <label for="validationCustom11">Logradouro</label>
                <input type="text" class="form-control" name="logradouro" id="validationCustom11" placeholder="Rua, Av., etc." required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-4 mb-2">
                <label for="validationCustom13">Número</label>
                <input type="text" class="form-control" name="numero" id="validationCustom13" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom12">Bairro</label>
                <input type="text" class="form-control" name="bairro" id="validationCustom12" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="validationCustom15">Sala</label>
                <input type="text" name="sala" class="form-control" id="validationCustom15">
              </div>
              <div class="col-md-3 mb-2">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" name="cep" id="cep" required>
                <div class="invalid-feedback">
                  Por favor, informe um CEP válido.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom16">Cidade</label>
                <input type="text" class="form-control" name="cidade" id="validationCustom16" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom17">Estado</label>
                <select name="uf" class="form-control" required>
                  <option value="AC">Acre</option>
                  <option value="AL">Alagoas</option>
                  <option value="AP">Amapá</option>
                  <option value="AM">Amazonas</option>
                  <option value="BA">Bahia</option>
                  <option value="CE">Ceará</option>
                  <option value="DF">Distrito Federal</option>
                  <option value="ES">Espírito Santo</option>
                  <option value="GO">Goiás</option>
                  <option value="MA">Maranhão</option>
                  <option value="MT">Mato Grosso</option>
                  <option value="MS">Mato Grosso do Sul</option>
                  <option value="MG">Minas Gerais</option>
                  <option value="PA">Pará</option>
                  <option value="PB">Paraíba</option>
                  <option value="PR">Paraná</option>
                  <option value="PE">Pernambuco</option>
                  <option value="PI">Piauí</option>
                  <option value="RJ">Rio de Janeiro</option>
                  <option value="RN">Rio Grande do Norte</option>
                  <option value="RS">Rio Grande do Sul</option>
                  <option value="RO">Rondônia</option>
                  <option value="RR">Roraima</option>
                  <option value="SC">Santa Catarina</option>
                  <option value="SP">São Paulo</option>
                  <option value="SE">Sergipe</option>
                  <option value="TO">Tocantins</option>
                </select>
              </div>
              <div class="col-md-6 mb-2">
                <label name="telefone" for="telefone">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="(DD) 9999-9999" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom18">FAX</label>
                <input type="text" name="fax" class="form-control" id="validationCustom18">
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom20">Nº de registro</label>
                <input type="text" name="numero_registro" class="form-control" id="validationCustom20" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom21">Conselho de fiscalização</label>
                <input type="text" name="conselho_fiscal" class="form-control" id="validationCustom21" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom22">Nome do responsável</label>
                <input type="text" name="nome_responsavel" class="form-control" id="validationCustom22" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="tel-resp">Telefone do responsável</label>
                <input type="text" class="form-control" name="telefone_responsavel" id="tel-resp" placeholder="(DD) 9999-9999" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom24">Email</label>
                <input type="text" name="email" class="form-control" id="validationCustom24" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom25">Cargo ocupado</label>
                <input type="text" name="cargo_ocupado" class="form-control" id="validationCustom25" required>
                <div class="invalid-feedback">
                  Preencha este campo.
                </div>
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
                <input type="text" class="form-control" name="nome_supervisor" id="validationCustom26" required>
                <div class="invalid-feedback">
                  Por favor, informe um nome válido.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom27">Habilitação profissional</label>
                <input type="text" class="form-control" name="habilitacao_profissional" id="validationCustom27" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="validationCustom28">Cargo</label>
                <input type="text" class="form-control" name="cargo_supervisor" id="validationCustom28" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
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
                <input type="text" class="form-control" name="setor_unidade" id="validationCustom29" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="validationCustom30">Data de início</label>
                <input type="date" class="form-control" name="data_inicio" id="validationCustom30" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
                <small id="dataIniHelp" class="form-text text-muted">
                  Previsão de início.
                </small>
              </div>

              <div class="col-md-3 mb-3">
                <label for="validationCustom31">Data de término</label>
                <input type="date" class="form-control" name="data_fim" id="validationCustom31" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
                <small id="dataFimHelp" class="form-text text-muted">
                  Previsão de término.
                </small>
              </div>

              <div class="col-md-12 mb-3">
                <label for="validationCustom32">Atividades principais a serem desenvolvidas: </label>
                <textarea name="ativ-text" name="atividades" rows="6" class="form-control" id="validationCustom32" required>
                </textarea>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
              </div>

              <div class="col-md-6 mb-2">
                <label for="validationCustom33">Ínicio da jornada de trabalho:</label>
                <input type="text" class="form-control" name="hora_inicio1" id="validationCustom33" placeholder="HH:mm" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
                <small id="dataFimHelp" class="form-text text-muted">
                  Horas e minutos do ínicio.
                </small>
              </div>
              <div class="col-md-6 mb-2">
                <label for="validationCustom34">Término da jornada de trabalho</label>
                <input type="text" class="form-control" name="hora_inicio2" id="validationCustom34" placeholder="HH:mm" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
                <small id="dataFimHelp" class="form-text text-muted">
                  Horas e minutos do término.
                </small>
              </div>

              <div class="col-md-12 mb-2">
                <label for="validationCustom35">Total de horas semanais:</label>
                <input type="text" class="form-control" name="total_horas" id="validationCustom35" placeholder="HH:mm" required>
                <div class="invalid-feedback">
                  Por favor, preencha este campo.
                </div>
                <small id="dataFimHelp" class="form-text text-muted">
                  Total de horas semanais.
                </small>
              </div>
            </div>
          </section>
          <div class="row">
            <div class="col-md-12" style="margin-top: 30px;">
              <button class="btn btn-success" name="cadastrar" type="submit">Cadastrar</button>
              <button class="btn btn-danger" name="cadastrar" type="submit">Cancelar</button>
            </div>
          </div>
        </form>


        <script>
          // Example starter JavaScript for disabling form submissions if there are invalid fields
          (function () {
            'use strict';
            window.addEventListener('load', function () {
              var form = document.getElementById('needs-validation');
              form.addEventListener('submit', function (event) {
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
  <!-- SCRIPTS -->
  <script src="../../assets/js/jquery-1.9.0.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="../../assets/js/jquery.maskedinput.js" type="text/javascript"></script>
  <script src="../../assets/js/masks.js" type="text/javascript"></script>
  <script src="../../assets/js/search-box.js" type="text/javascript"></script>
  <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
    crossorigin="anonymous"></script>
</body>

</html>
