<?php
session_start();


if(isset($_SESSION['thisusername'])) {
//$_SESSION = array();
$_POST['Calculate_QMDJ'] = array();
$_SESSION['session_tree'] = array();
$_POST['usname'] = array();
$_SESSION['thisusername'] = array();
$_SESSION['session_tree'] = array();
session_destroy();

} else {
	$_POST['Calculate_QMDJ'] = array();
$_SESSION['session_tree'] = array();
$_POST['usname'] = array();
$_SESSION['thisusername'] = array();
$_SESSION['session_tree'] = array();
session_destroy();
session_destroy();
	}

header("Location: memlogin.html");



?>
