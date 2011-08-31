<?php

$curStr = $_GET["curStr"];

function check_possible($str){
	$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
	$customURLS = array();
	if (!$con)
		{die('Could not connect: ' . mysql_error());}
	else{
		mysql_select_db("tasteplug",$con);
		$result=mysql_query("SELECT custom_url FROM Users");
		
		while ($resultRow = mysql_fetch_array($result)){
			$customURLS[]=$resultRow['custom_url'];
		}
		
		mysql_close($con);
		}
	
	$matched = array();
	foreach ($customURLS as $url){
		if ($str == $url) $matched[]=$url;
	}

	if (count($matched)>0) return false;
	else return true;
	}
	
if (check_possible($curStr)){
	//echo 'curStr:'.$curStr;
	
	if (!url_invalid($curStr)){
		echo '<input type="submit" value="OK :)"/>';
	}
	else{
		echo 'invalid URL';
	}
	
}
else {
	echo 'taken :(';
}

function url_invalid($str) {
	return preg_match("/[^a-zA-Z0-9_]/", $str);
}
	
?>
