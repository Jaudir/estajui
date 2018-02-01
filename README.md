# estajui

Arquivos do front-end:
Optei por criar uma pasta para cada ator (Coordenador de Extensão, Estudante, Secretaria e Organizador de estágio).
Dentro da pasta tem a respectiva home(pag principal para o ator, de acordo com o seu perfil, que irá abrir assim que ele logar).
Tem tambem os subitens da home-item que são os itens do menu.

Há na pasta JS um script chamado masks.js que possui máscaras de formato para entrada de dados, 
o formulário de cadastro dos usuários utiliza dessas máscaras como exemplo.

Como criar um caso de uso
=========================
  Para implementar um caso de uso, os seguintes passos devem ser tomados:

  * **1-** Criar uma branch a partir da master branch.
  * **2-** Implementar seu caso de uso.
  * **3-** Upar sua branch no github e iniciar uma pull request da sua branch.
  * **4-** Informar aos testadores sobre sua requisição, que devem baixar sua branch(pull) e realizar os testes necessários.
  * **5-** Caso hajam erros, que devem ser informados através da pull request, correções necessárias devem ser feitas na mesma branch, sempre commitando elas na sua branch e dando push no github para que fiquem disponíveis pra todos verem. 
  * **6-** Quando seu caso de uso finalmente for aceito, você pode aceitar a pull request e dar merge na master branch.

  Sobre pull requests: [About Pull requests Github](https://help.github.com/articles/about-pull-requests/), é simples de usar e vai facilitar a comunicação entre a equipe de teste e os desenvolvedores.

  Caso não queira utilizar pull requests, você pode seguir este modelo:

  * **1-** Criar uma branch a partir da master branch.
  * **2-** Implementar seu caso de uso.
  * **3-** Upar sua branch no github.
  * **4-** Informar aos testadores sobre sua branch, que devem baixa-la(pull) e realizar os testes necessários.
  * **5-** Caso hajam erros, correções necessárias devem ser feitas na mesma branch, sempre commitando elas na sua branch e dando push no github para que fiquem disponíveis pra todos verem. 
  * **6-** Quando seu caso de uso finalmente for aceito, você pode dar merge na master branch.

Estrutura do Projeto
=======================

* **assets/**

  Recursos do site, imagens, css, javascripts, etc.
* **estajui/**
  
  Nessa pasta devem ser colocados todos os arquivos de front-end(views), organaziados da seguinte forma: Criar uma pasta para cada ator (Coordenador de Extensão, Estudante, Secretaria e Organizador de estágio). Dentro da pasta tem a respectiva home(pag principal para o ator, de acordo com o seu perfil, que irá abrir assim que ele logar). Tem também os subitens da home-item que são os itens do menu.
  
 * **scripts/**
  
    Nessa pasta vai todo o código que faz o site funcionar, cada subpasta tem scripts separados pelo seu propósito:
  
    * **controllers/**
      
      Aqui vão todos os controllers, é recomendado que os controllers fiquem em pastas equivalentes aos views aos quais eles estão relacionados, por exemplo, controllers que interagem com views do coordenador de extensão ficam dentro de uma subpasta coordenador-extensao(assim como no caso dos views.
      
    * **daos/**
      
      Aqui ficam as estruturas de dados que representam entidades no BD, são utilizadas em todos os lugares: models, controllers e views. Os dados são carregados em um DAO(pelo model, vindo do BD) ou por um controller(vindo do lado cliente pela variavel POST, geralmente).
      
    * **models/**
      
      Aqui ficam os models, todos os models são classes e devem herdar do MainModel. Um model deve possuir métodos para realizar operações no BD, por exemplo: cadastrar usuário, listarEstagios, etc.
      
    * **util/**
    
      Aqui ficam scripts auxiliares, qualquer script útil e que deve ser muito utilizado pode ser colocado aqui, exemplo: formatação de strings, manipulação de sessão, etc.
  
  Por último, não é recomendado que a pasta scripts contenham arquivos soltos, cada arquivo deve ser colocado em alguma de suas subpastas.

Desenvolvendo
=============

  Criando views
  -------------

  Caso a view do seu caso de uso necessite de dados do banco de dados, você deve criar um controller que será incluído pela view(*require_once*) e deixará os dados disponíveis para serem utilizados no script da view, exemplo:

  ```php
  <?php
  require_once('../../scripts/controllers/coordenador-extensao/load-home.php');
?>
<!DOCTYPE html>
<html>
  <head>
  ... <!--Algum código aqui--> ...

  foreach($statusEstagios as $estagio)://variável $statusEstagios foi criada pelo script(controller) load-home.php
  
  ... <!--Mais código aqui--> ...
  ```

  Criando controllers
  -------------------

Controllers devem incluir o controller base: *base-controller.php* que fica na raiz do diretório dos controllers, 
esse arquivo possui algumas funções importantes para todos os controllers e também instancia um objeto da classe *Loader*, que é responsável por fazer carregamentos de Models, classes utilitárias e daos, não hesite em olhar o código dessa classe antes de usa-la :).

Exemplo de Controller:

  ```php
<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

//carrega e inicia a sessão
$session = getSession();

... algum código php ...

//carregamento de um model(informa o arquivo dentro da pasta models e o nome da classe)
$model = $loader->loadModel('coord-ext', 'CoordExtModel');
if($model != null){
    //...
    if(!$model->verificaPreCadastro($cnpj)){
        if($model->alterarConvenio($veredito, $justificativa, $cnpj)){
        }else{ 
            $session->pushError('Não foi possível realizar a operação! Por favor contate o administrador do sistema!');
        }
    }else{
        //adiciona erros à sessão
        $session->pushError('Esta empresa não está pre cadastrada!');
    }
}

//função de redirecionamento
redirect(base_url() . '/estajui/coordenador-extensao/home.php');
  ```

Caso seja necessário, você pode adicionar funções ao arquivo *base-controller.php*.

O arquivo *configs.php* possui informações de configuração do sistema, por exemplo a url base e 
as informações de acesso ao banco de dados(que são repassadas aos models pelo loader).

  Criando Models
  -------------------

  Todo model deve herdar da classe *MainModel*, então absta utilizar a variável membro *$conn* para acessar o banco de dados e variável *loader* para carregar daos e arquivos da pasta util que possam ser necessários.

  Dentro dos controllers, os models são carregados através do loader, que também trata da inicialização do model.

  Exemplo de Model:

  ```php
  <?php

  require_once(dirname(__FILE__) . '/MainModel.php');

  class CoordExtModel extends MainModel{
      //verifica se uma empresa já foi pré cadastrada
      public function verificaPreCadastro($cnpj){
          $st = $this->conn->prepare("select conveniada from empresa where cnpj = $cnpj");
          if(!$st->execute()){
              //Log::LogPDOError($st->errorInfo(), true);//descomentar quando estiver debugando
              return false;
          }

          $data = $st->fetchAll();
          if(count($data) > 0){
              return ($data[0]['conveniada'] == 1);
          }

          return false;
      }
      ...
  }
  ```

  Util e Daos
  -----------

  Arquivos podem ser adicionados à pasta util sempre que for necessário, mas também devem ser carregados através do loader.

  Os daos são geralmente incluídos nos models, e consequentemente nos controllers e também devem ser carregados pelo loader.