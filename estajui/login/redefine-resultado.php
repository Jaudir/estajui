<!DOCTYPE html>
<?php
    require_once(dirname(__FILE__) . '/../../scripts/controllers/login/redefinir-senha.php');
?>
<html>

<head>
    <title>Redefinir senha</title>
</head>

<body>
    <h3>
        <?php 
            if($session->hasError()){
                $session->printErrors();
            }else if($session->hasValues()){
                echo $session->getValues('resultado')[0];
            }
        ?>
    </h3>
</body>

</html>