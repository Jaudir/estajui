<!DOCTYPE html>
<?php
require_once('../../scripts/controllers/base-controller.php');
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/main.css">
  </head>
  <body>

    <div class="container-fluid bg-green fullscreen">
      <div class="row align-items-center fullscreen" style="display: flex;">
        <div class="col-md-12 img-logo">
          <img src="../../assets/img/logo.png" alt="Estajui">
        </div>
        <div class="col-md-4 offset-md-4 content-login">
          <form name="login">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Digite seu email">
            </div>
            <div class="form-group">
              <label for="senha">Senha</label>
              <input type="senha" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
            </div>
            <div class="links-login">
              <!--<a href=#>Recuperar senha</a> <br>-->
              <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalSenha">
                Recuperar senha
              </button><br>
              <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalLink">
                Reenviar link de confirmação
              </button><br>
            </div>
            <div style="text-align: right;">
              <a href="/estajui/estudante/cadastro.php" >Cadastre-se</a>
            </div>
            <div class="bt-logar">
              <button type="submit" name="btn-logar" class="btn btn-success">Entrar</button>
            </div>
          </form>
        </div>

        <!-- Modal Recuperação de Senha -->
        <div class="modal fade" id="modalSenha" tabindex="-1" role="dialog" aria-labelledby="modalSenhaTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalSenhaTitle">Recuperação de senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form name="recup-senha">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="emailRec" name="email" aria-describedby="emailHelp" placeholder="Digite seu email">
                    <small id="emailHelp" class="form-text text-muted">Forneça seu e-mail cadastrado para receber o link de redefinição de senha.</small>

                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                <button type="button" id="recuperarSenha" class="btn btn-primary">Confirmar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal para reenvio do link de confirmação de cadastro -->
        <div class="modal fade" id="modalLink" tabindex="-1" role="dialog" aria-labelledby="modalLinkTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalLinkTitle">Reenvio de link de confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form name="recup-senha">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Digite seu email">
                    <small id="emailHelp" class="form-text text-muted">Forneça seu e-mail cadastrado para receber o link de confirmação de cadastro.</small>
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


    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
    $(function(){
      $('#recuperarSenha').click(function(){
        $.ajax({
          type: "POST",
          url: '<?php echo base_url() . '/scripts/controllers/login/criar-codigo-redefinicao.php'?>',
          data: {
            email: $('#emailRec').val()
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert('Falha ao contatar o servidor!');
          },
          success: function(data, textStatus, jqXHR){
            if(textStatus == 'success'){
              alert(data);
            }
          }
          }
        );
      });
    });
    </script>
  </body>
</html>
