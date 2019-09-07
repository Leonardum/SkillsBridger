<?php

	session_start();
	
	$_SESSION['userId'] = 5;
	
	require('../model/database.php');
	require_once('../model/user_object.php');
	
	$user = user::get_userById(5);
	
	$user->setAccountActivated(1);
	
	$user->save();
	
	header('Location: ../index.php?action=welcome');
	
	?>