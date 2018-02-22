<?php
$session = getSession();
if (isset($_GET["logoff"])) {
    $session->destroy();
    redirect("login.php");
}
if (!$session->isLogged()) {
    redirect("login.php");
}


if (isset($_POST["matricula"]) && isset($_POST["semestre"])) {
    
}