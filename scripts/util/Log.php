<?php
class Log{
    private static $isDebugging;

    public function setIsDebugging($bool){
        self::$isDebugging = $bool;
    }

    public static function LogError($string, $echo = false){
        if(self::$isDebugging){
            echo "Error: " . $string . "<br>";
        }
    }

    public static function logPDOError($pdoEx, $echo = false){
        if(self::$isDebugging){
            echo "Date and time: " . $date = date('m/d/Y h:i:s a', time()) . "<br>";
            echo "Message: ". $pdoEx->getMessage() . "<br>";
            echo "File: " . $pdoEx->getFile() . " at line " . $pdoEc->getLine() . "<br>";
            echo "Traceback: " . $pdoEx->getTraceString() . " <br>";
        }
    }
}