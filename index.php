<?php
chdir(__DIR__);
require_once './scripts/controllers/configs.php';
header("Location: http://" . $dir . "estajui/login.php");
die();