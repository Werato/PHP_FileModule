<?php
class File
{
	private $DB;
	private $WebPage;

	public function init($dbLinq, $WebPageUrl){
		$this->DB = &$dbLinq;
		$this->WebPage = $WebPageUrl;
	}

	function stat($forFbject, $objectID)
	{
		$include = "";

		$content = "
			<form id=\"form\" target=\"hiddenframe\" action=\"".$_SESSION['WebPage']."module/file/layoutDynamicClass.php\"
			method=\"POST\" enctype=\"multipart/form-data\">
				<input type=\"file\" name=\"img\">
				<input type=\"hidden\" name=\"className\" value=\"file\">
				<input type=\"hidden\" name=\"methodName\" value=\"saveĪmg\">
				<input type=\"hidden\" name=\"arguments\" value=\"".$forFbject.", ".$objectID."\">
				<button id=\"SendFile\">
					Save file
				</button>
			</form>
			<iframe id=\"hiddenframe\" name=\"hiddenframe\" style=\"display:none\">
			</iframe>
			<script type=\"text/javascript\" src=\"".$this->WebPage."module/file/files.js\"></script>
			<div class=\"unloadImg\"></div>
		";
		return $content;

	}

	function saveImg($object, $objectID) {
		
		$blob = $this->DB->escape_string(file_get_contents($_FILES["img"]["tmp_name"]));
		$mimeType = $_FILES["img"]["type"];
		$name = $_FILES["img"]["name"];

		$content = $this->DB->query("INSERT INTO `files` SET Name ='".$name."', MnimeType='".$mimeType."',
		Object='".$object."',File = '".$blob."', ObjectID = ".$objectID) or die($db->error);

		$src = $this->WebPage."module/File/View/img.php?id=".$this->DB->insert_id;
		$content .= '<img src="'.$src.'">';

		$js = "<script>
		var content = window.parent.document.getElementsByClassName(\"unloadImg\");
		window.parent.file.afterLoad.cloneElement(content);
		window.parent.file.afterLoad.getContentFromFrame(content);
		</script>";
		return $content.$js;
	}

	function linqToObj($objName, $objID)
	{
		$select =
		$this->DB->query("UPDATE `files` SET `ObjectID`=".$objID." WHERE Object='".$objName."' AND ObjectID = ".$_SESSION["tmpNewTaskID"]);

	}

	function show($objName, $objID){
		
		$select =
		$this->DB->query("SELECT FilesID FROM `files` WHERE `ObjectID`=".$objID." AND Object='".$objName."'");

		$numRow = $select->num_rows;
		$wrapper = "<table><tr>";
		$index = 1;
		$content = "";
		while ($row = $select->fetch_assoc()) 
		{

			if( ($index % 5) == 0 )
			{
				$content .= "</tr><tr>";
				$index = 1;
			}

			$content .= "<td>";
			$src = $this->WebPage."module/file/img.php?id=".$row["FilesID"];
			$content .= '<img style="width:200px;heighi:100px" src="'.$src.'">';
			$index++;

		}

		$wrapper .= $content."</tr></table>";

		return $wrapper;
	}	
}

$file = new File();