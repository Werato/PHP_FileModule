<?php
session_start();
include($_SERVER['DOCUMENT_ROOT']."/liss_v_1_0"."/module/file/Files.php");
include($_SERVER['DOCUMENT_ROOT']."/liss_v_1_0"."/registration/bd.php");

$class = $_POST["className"];
$method = $_POST["methodName"];
$argument = explode(",", $_POST["arguments"]);


switch ($class) {
	case 'file':
	
		$file->init($db, $_SESSION["WebPage"]);	
		echo $file->$method($argument[0], $argument[1]);

	break;
}
