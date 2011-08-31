<?php
include_once("../page-templates/single_plug.php");
include_once("../page-templates/custom_url_functions.php");
include_once("indexFunctions.php");
$method = $_GET["method"];
	echo doThing($method);
function doThing($met){
	if ($met == "doEdit"){
		$plug_id=$_GET["plugID"];
		$author_first_name=$_GET["firstName"];
		$custom_url = $_GET["customURL"];

		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$result = mysql_query("SELECT * FROM ".$custom_url." WHERE post_id='".$plug_id."'");
		$row = mysql_fetch_array($result);
	
		$img_src=$row["image_src"];
		$search_link=$row["search_link"];
		$title=$row["title"];
		$attribute_prefix=$row["attribute_prefix"];
		$attribute=$row["attribute"];
	
		$blurb=$row["blurb"];
		
	
		$attribute_extra_prefix=$row["attribute_extra_prefix"];
		$attribute_extra=$row["attribute_extra"];
	
		return makeNewPlug($img_src,$search_link,$title,$attribute_prefix,$attribute,$author_first_name,$blurb,$plug_id,$attribute_extra_prefix,$attribute_extra);
	}
	
	if ($met == "doDelete"){
		$plug_id=$_GET["plugID"];
		$custom_url = $_GET["customURL"];
		
		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		mysql_query("DELETE FROM ".$custom_url." WHERE post_id='".$plug_id."'");
		
		reloadPostsArray($custom_url);
		return getPlugs();
	}
	
	if ($met == "save"){
		$plug_id=$_GET["plugID"];
		$author_first_name=$_GET["firstName"];
		$custom_url = $_GET["customURL"];
		$attribute_prefix=$_GET["att_pre"];
		$attribute=$_GET["att"];
		$attribute_extra_prefix=$_GET["att_ex_pre"];
		$attribute_extra=$_GET["att_ex"];
		$blurb = $_GET["blurb"];
		$title =$_GET["title"];
		$image_src=$_GET["img_src"];
		$search_url=$_GET["link"];
		$category=$_GET["category"];
		
		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$result = mysql_query("SELECT * FROM $custom_url WHERE post_id='$plug_id'");
		if (mysql_num_rows($result)){
			mysql_query("UPDATE $custom_url SET title='$title', attribute='$attribute',".
			"attribute_extra='$attribute_extra',blurb='$blurb' WHERE post_id='$plug_id'");
			
			
		}
		else{
			mysql_query("INSERT INTO $custom_url (image_src,search_link,title,attribute,attribute_prefix,".
			"attribute_extra,attribute_extra_prefix,blurb,category) VALUES ('$image_src','$search_url',".
			"'$title','$attribute','$attribute_prefix','$attribute_extra','$attribute_extra_prefix',".
			"'$blurb','$category')");
			
			
			/*
			mysql_query("INSERT INTO $custom_url (image_src,search_url,title,attribute,attribue_prefix,
			attribute_extra,attribute_extra_prefix,blurb) VALUES ('$image_src','$search_url',
			'$title','$attribute','$attribute_prefix','$attribute_extra','$attribute_extra_prefix',
			'$blurb')");
			*/
		}
		reloadPostsArray($custom_url);
		return getPlugs();
	}
}


?>