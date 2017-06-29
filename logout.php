<?php

		require_once('session.php');
		require_once('class.event.php');

		$logout = new EVENT();
	if(isset($_GET['action']) && $_GET['action']=="logout")
	{
		$logout->dologout();
		$logout->redirect('../AdminModule/index.php');
	}


?>