<?php

/**
 * Conexão e relações gerais com o BD
 *
 * @author gabriel Lucas
 */
class Databsae {

    private static $servername = "localhost";
    private static $username = "projeto_estajui";
    private static $password = "est*826491735";
    private static $dbname = "estajui";
    private static $db = null;
    
    public static function getServername() {
        return self::$servername;
    }

    public static function getUsername() {
        return self::$username;
    }

    public static function getPassword() {
        return self::$password;
    }

    public static function getDbname() {
        return self::$dbname;
    }

    public static function setServername($servername) {
        self::$servername = $servername;
        return self;
    }

    public static function setUsername($username) {
        self::$username = $username;
        return self;
    }

    public static function setPassword($password) {
        self::$password = $password;
        return self;
    }

    public static function setDbname($dbname) {
        self::$dbname = $dbname;
        return self;
    }
    
    /**
     * Gerador de coneção
     * 
     * Cria uma coneção PDO com o BD.
     * 
     * @return PDO|string Objeto de coneção com o BD
     * @access public
     */
    public static function getConnection() {
        if (is_null(self::$db)) {
            try {
                $conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname, self::$username, self::$password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (PDOException $e) {
                return false;
            }
        } else {
            return self::$db;
        }
    }

}
