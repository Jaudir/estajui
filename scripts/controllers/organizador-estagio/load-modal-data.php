<?php
?>
<h6>Nome: </h6> <p><?php echo $usuario->getnome(); ?></p><br>
<h6>Cpf: </h6> <p><?php echo $usuario->getcpf(); ?></p><br>
<h6>Curso: </h6> <p><?php echo $estagio->get_estagio()->getcurso()->getnome(); ?></p> <br>
<h6>Nome fantasia da empresa: </h6> <p><?php echo $estagio->get_estagio()->getempresa()->getnome(); ?></p> <br>
<h6>Setor/Unidade da empresa: </h6> <p>T.I.</p> <br>
<h6>Supervisor: </h6> <p><?php echo $estagio->get_estagio()?></p> <br>
<h6>Telefone do supervisor: </h6> <p>38 3221-2011</p> <br>
<h6>Habilitação profissional: </h6> <p>Cientista da computação</p> <br>
<h6>Cargo: </h6> <p>Diretor de T.I.</p> <br>
<h6>Principais atividdes a serem desenvolvidas: </h6>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> <br>
<h6>Data prevista para ínicio do estágio: </h6> <p>22/01/2006</p> <br>
<h6>Data prevista para término do estágio: </h6> <p>23/10/2006</p> <br>
</div>