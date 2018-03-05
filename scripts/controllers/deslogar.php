<?php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";
	
	$session = getSession();
	
	$session->destroy();
	
	redirect(base_url() . '/estajui/login.php');	