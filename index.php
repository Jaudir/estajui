<?php
chdir(__DIR__);
require_once './scripts/controllers/configs.php';
header("Location: " . $configs['BASE_URL'] . "/estajui/login.php");
die();