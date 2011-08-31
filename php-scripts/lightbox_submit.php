<?php
include_once("customPageFunctions.php");

$customURL = $_GET["customURL"];
$FBid = $_GET["FBid"];

add_url($customURL,$FBid);
function add_url($customURL,$FBid){
	$con=mysql_connect("host","username","password");
	mysql_select_db("tasteplug",$con);
	if (!$con)
		{die('Could not connect: ' . mysql_error());}
	else{
		
		$result=mysql_query("UPDATE Users SET custom_url='" .$customURL. "' WHERE FBid='" .$FBid. "'");
		mysql_query("CREATE TABLE " .$customURL. "(post_id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(post_id), image_src TEXT NOT NULL,
		search_link TEXT NOT NULL, title TEXT NOT NULL,category TEXT NOT NULL, attribute_prefix TEXT NOT NULL, attribute TEXT NOT NULL,
		attribute_extra_prefix TEXT NOT NULL, attribute_extra TEXT NOT NULL,time_stamp TIMESTAMP DEFAULT NOW(),blurb TEXT NOT NULL,listed_by TEXT NOT NULL,endorsed_by TEXT NOT NULL)");
		
		mysql_query("CREATE TABLE " .$customURL.'_list'. "(item_id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(item_id), image_src TEXT NOT NULL,
		search_link TEXT NOT NULL, title TEXT NOT NULL,category TEXT NOT NULL, attribute_prefix TEXT NOT NULL, attribute TEXT NOT NULL,
		attribute_extra_prefix TEXT NOT NULL, attribute_extra TEXT NOT NULL,time_stamp TIMESTAMP DEFAULT NOW(),owner_url TEXT NOT NULL,owner_post_id TEXT NOT NULL)");
		//createNewPage($customURL);		//from included file 		//deleted 1/9/2011 now using handler.php
		
		mysql_close($con);
		}
	}

?>