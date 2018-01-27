<?php
class LimpaString
{
    public static function limpar($var)
    {
        $var = trim($var);
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlspecialchars($var);
        return $var;
    }
}