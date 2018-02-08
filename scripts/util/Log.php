<?php

class Log{
    public static function LogError($string, $echo = false){
        if($echo){
            echo "Error: " . $string . "<br>";
        }
    }

    public static function logPDOError($pdoEx, $echo = false){
        if($echo){
            echo "Date and time: " . $date = date('m/d/Y h:i:s a', time()) . "<br>";
            echo "Message: ". $pdoEx->getMessage() . "<br>";
            echo "File: " . $pdoEx->getFile() . " at line " . $pdoEc->getLine() . "<br>";
            echo "Traceback: " . $pdoEx->getTraceString() . " <br>";
        }
    }
}