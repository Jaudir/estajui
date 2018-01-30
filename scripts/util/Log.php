<?php

class Log{
    public static function logPDOError($info, $echo = false){
        if($echo)
            var_dump($info);
            //echo 'DB error: SQLSTATE: ' . $info[0] . ' MySQL code: ' $info[1] . 'Description:' . $info[2] . '<br>';
        //error_log('DB error: SQLSTATE: ' . $info[0] . ' MySQL code: ' $info[1] . 'Description:' . $info[2], 0);
    }
}