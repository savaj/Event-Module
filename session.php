<?php
session_start();
	require_once 'class.event.php';
		$session = new EVENT();

	if(!$session->is_loggedin())
	{
		$session->redirect('index.php');
	}


?>