<?php
	session_start();
	if (isset($_GET['logout'])){
		unset($_SESSION['user_session']);
		session_unset();
		session_destroy();
	}
?>