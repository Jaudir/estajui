<?php
/**
* Função para gerar senhas aleatórias (ADAPTADA DO ORIGINAL)
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se terá letras maiúsculas
* @param boolean $numeros Se terá números
* @param boolean $simbolos Se terá símbolos
*
* @return string A senha gerada
*/

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
	$lmin = 'abcdefghijklmnopqrstuvwxyz';//0-25
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';//26-51
	$num = '1234567890';//52-61
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	$caracteres .= $lmin;
	$pegouNum = FALSE;
	$pegouLetra = FALSE;
	
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
		if($rand-1 >= 52 && $rand-1 <= 61) $pegouNum = TRUE;
		if($rand-1 >= 0 && $rand-1 <= 51) $pegouLetra = TRUE;
	}
	if($pegouNum == FALSE) {
		$rand = mt_rand(0, $tamanho-1);
		$numSort = mt_rand(0,9);
		$retorno[$rand] = $numSort;
	}
	if($pegouLetra == FALSE) {
		$rand = mt_rand(0, $tamanho-1);
		$numSort = mt_rand(0,51);
		$retorno[$rand] = $numSort;
	}
	return $retorno;
}
?>