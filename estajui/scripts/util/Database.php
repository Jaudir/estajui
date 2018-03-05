<?php

class CascadePDO extends PDO {

    protected $transactionCounter = 0;

    function beginTransaction() {
        if (!$this->transactionCounter++)
            return parent::beginTransaction();
        return $this->transactionCounter >= 0;
    }

    function commit() {
        if (!--$this->transactionCounter)
            return parent::commit();
        return $this->transactionCounter >= 0;
    }

    function rollback() {
        if ($this->transactionCounter >= 0) {
            $this->transactionCounter = 0;
            return parent::rollback();
        }
        $this->transactionCounter = 0;
        return false;
    }

//...
}

/**
 * Conexão e relações gerais com o BD
 *
 * @author gabriel Lucas
 */
class Database {

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
    }

    public static function setUsername($username) {
        self::$username = $username;
    }

    public static function setPassword($password) {
        self::$password = $password;
    }

    public static function setDbname($dbname) {
        self::$dbname = $dbname;
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
                self::$db = new CascadePDO("mysql:host=" . self::$servername . ";dbname=" . self::$dbname . ";charset=utf8", self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                return false;
            }
        }
        return self::$db;
    }

}
