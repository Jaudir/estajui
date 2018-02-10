<!DOCTYPE html>
<?php
    require_once(dirname(__FILE__) . '/scripts/controllers/verificar-codigo.php');
?>
<html>

<head>
    <title>Redifinir senha</title>
</head>

<body>
    <?php if($session->hasErrors()):?>

    <h3><?php echo $session->printErrors();?></h3>

    <?php elseif($session->hasValues()):?>
    
    <h3><?php echo $session->getValues('resultado')[0];?></h3>

    <?php else:?>
    <form action="<?php echo base_url() . '/scripts/controllers/login/recuperar-senha.php'?>" method="POST">
        Email: <?php echo $usuario->getlogin()?><br>
        Nova senha:<br>
        <input type="password" name="novaSenha"><br>
        Repetir senha:<br>
        <input type="password" name="novaSenha2"><br>
        <input type="submit" value="Confirmar">
    </form>

    <?php endif;?>
</body>

</html>