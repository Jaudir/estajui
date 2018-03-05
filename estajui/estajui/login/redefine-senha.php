<!DOCTYPE html>
<?php
    require_once(dirname(__FILE__) . '/../../scripts/controllers/login/verificar-codigo.php');
?>
<html>

<head>
    <title>Redefinir senha</title>
</head>

<body>
    <?php if($session->hasError()):?>

    <h3><?php echo $session->printErrors();?></h3>

    <?php else:?>
    
    <form action="<?php echo base_url() . '/estajui/login/redefine-resultado.php'?>" method="POST">
        Email: <?php echo $usuario->getlogin()?><br>
        Nova senha:<br>
        <input type="password" name="senha"><br>
        Repetir senha:<br>
        <input type="password" name="senha2"><br>
        Codigo:<br>
        <input type="text" name="c" value="<?php echo $_GET['c']?>"><br>
        <input type="submit" value="Confirmar">
    </form>

    <?php endif;?>
</body>

</html>