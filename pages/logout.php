<?php
	$user = new users();
	$user->logout();
	header('Location: ?page=login');
	exit();
?>