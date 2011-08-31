<!DOCTYPE html>
<html lang="en">
<?php
	include_once("page-templates/custom_url_functions.php");
	include_once("php-scripts/indexFunctions.php");
	include_once("php-scripts/handler_functions.php");
	$allURLS=array();		//will store all custom_urls
	
 
 $request = $_SERVER['REQUEST_URI'];
 $exploded = explode('/',$request);	//element 0 should be tasteplug.com
 $customURL = $exploded[1];
 
 
	$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
	mysql_select_db("tasteplug",$con);
		
		$result=mysql_query("SELECT custom_url FROM Users");
		while ($row = mysql_fetch_array($result)){
			$allURLS[]=$row['custom_url'];
		}
	if (in_array($customURL,$allURLS)){
	//if the customURL typed exists in the database
	//setGlobalUrl($customURL);
	//setArray(getCookie());
	
		if (count($exploded)>2){
		//if the url exists, and there is call for something else (e.g. tasteplug.com/wesley/foo)
			if (count($exploded)==3){
				if ($exploded[2]=='list'){
					echo loadList();
				}
				else if (strlen($exploded[2])==0){
					//echo customPage();
					include_once("page-templates/custom_page.php");
				}
				else {
					echo notFound();
				}
			}
			else{
				echo notFound();
			}
		}
		else{
		//if there is just one thing after / e.g. tasteplug.com/foo
			//echo customPage();
			include_once("page-templates/custom_page.php");
		}
	}
	else if ($customURL=='search'){
		include_once("page-templates/search-people.php");
	}
	else{
	//if url does not exist
		echo notFound();
	}
		
//$customURL = 'wesley';
?>