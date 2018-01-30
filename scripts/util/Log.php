<?php

class Log{
    public static function logPDOError($stmt){
        error_log('DB error: SQLSTATE: ' . $stmt[0] . ' MySQL code: ' $stmt[1] . 'Description:' . $stmt[2]);
    }
}