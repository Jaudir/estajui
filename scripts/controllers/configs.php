<?php

/*Definir constantes que serão usadas em controllers e models
Este arquivo é incluido no controller base
*/

$url = $_SERVER['REQUEST_URI']; //returns the current URL
$parts = explode('/',$url);
$dir = $_SERVER['SERVER_NAME'];
for ($i = 0; $i < count($parts) - 1; $i++) {
 $dir .= $parts[$i] . "/";
}
$configs['BASE_URL'] = $dir;

//envio de emails
$configs['email_estajui'] = 'estajui@estajui.estajui';
$configs['responsavel_estajui'] = 'Estajui master';

$configs['DB']['SERVER'] = 'localhost';
$configs['DB']['NAME'] = 'estajui';
$configs['DB']['USERNAME'] = 'root';
$configs['DB']['PASSWORD'] = '';