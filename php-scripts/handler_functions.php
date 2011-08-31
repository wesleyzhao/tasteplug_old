<?php
function getPageText($dir){
	$temp =fopen($dir,'r');
	$data = fread($temp,filesize("$dir"));
		fclose($temp);
	
	return $data;
	}
function customPage(){
	$html = getPageText("page-templates/custom_page.php");
	return $html;
}

function notFound(){
	$html = getPageText("not_found.php");
	return $html;
}

function loadList(){
	$html = getPageText("page-templates/list_template.php");
	$html = '';
	return $html;
}


?>