<?php

if(!isset($_GET["id"]))
	exit();

include($_SERVER['DOCUMENT_ROOT']."/liss_v_1_0"."/registration/bd.php");

$fileID = $_GET["id"];

$select = $db->query("SELECT MnimeType, File FROM files Where FilesID=".$fileID);

$res = $select->fetch_assoc();

header("Content-type:".$res["MnimeType"]);
echo $res["File"];

$select->clear();	