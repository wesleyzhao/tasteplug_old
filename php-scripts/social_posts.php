<?php
include_once("../page-templates/single_plug.php");
include_once("../page-templates/custom_url_functions.php");
$method = $_GET["method"];
echo doThing($method);

function doThing($met){
	if ($met == "toList"){
	//requires a GET variable with plugID,customURL, and FBid
		$plug_id=$_GET["plugID"];		//num
		$custom_url = $_GET["customURL"];		//angryjunebug
		$FBid = $_GET["FBid"];		//wesleyID

		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$result = mysql_query("SELECT * FROM ".$custom_url." WHERE post_id='".$plug_id."'");
		$row = mysql_fetch_array($result);
	
		$img_src=$row["image_src"];
		$search_link=$row["search_link"];
		$title=$row["title"];
		$category = $row['category'];
		$attribute_prefix=$row["attribute_prefix"];
		$attribute=$row["attribute"];
		$listed_by=$row["listed_by"];
				
		//$blurb=$row["blurb"];
		
	
		$attribute_extra_prefix=$row["attribute_extra_prefix"];
		$attribute_extra=$row["attribute_extra"];
		
		$result2 = mysql_query("SELECT custom_url FROM Users WHERE FBid='$FBid'");
		$row2 = mysql_fetch_array($result2);
		
			$lister = $row2['custom_url'];		//wesley
			$newString = makeCommaString($listed_by,$lister);		//wesley
			mysql_query("UPDATE $custom_url SET listed_by='$newString' WHERE post_id='$plug_id'");		//works
		
			$test = mysql_query("SELECT owner_post_id FROM ".$lister."_list WHERE owner_url='$custom_url'");		//[6,8]
			if (mysql_num_rows($test)){		//pass
			//$testRow= mysql_fetch_array($test);
			$testArr=array();
			while ($testRow =mysql_fetch_array($test)){
				$testArr[] = $testRow['owner_post_id'];
			}
			//testArr should be 6,8
				if (!in_array($plug_id,$testArr)){
					$table_name = $row2['custom_url'].'_list';
					mysql_query("INSERT INTO $table_name (image_src,search_link,title,category,attribute_prefix,attribute,attribute_extra_prefix,attribute_extra,owner_url,owner_post_id)
					VALUES ('$img_src','$search_link','$title','$category','$attribute_prefix','$attribute','$attribute_extra_prefix','$attribute_extra','$custom_url','$plug_id')");
				}
			}
			else{
				$table_name = $row2['custom_url'].'_list';
					mysql_query("INSERT INTO $table_name (image_src,search_link,title,category,attribute_prefix,attribute,attribute_extra_prefix,attribute_extra,owner_url,owner_post_id)
					VALUES ('$img_src','$search_link','$title','$category','$attribute_prefix','$attribute','$attribute_extra_prefix','$attribute_extra','$custom_url','$plug_id')");
			}
		return "this:".$img_src.$search_link.$title.$category;
		
	}
	
	if ($met == "itemDelete"){
		$item_id=$_GET["itemID"];
		$custom_url = $_GET["customURL"];
		
		$con=mysql_connect("host","username","password");
		mysql_select_db("tasteplug",$con);
		
		$res = mysql_query("SELECT owner_post_id,owner_url FROM ".$custom_url."_list WHERE item_id='$item_id'");
		mysql_query("DELETE FROM ".$custom_url.'_list'." WHERE item_id='$item_id'");
		
		$row = mysql_fetch_array($res);
		$post_id = $row['owner_post_id'];
			$owner_url = $row['owner_url'];
			
		if ($post_id){
			$result = mysql_query("SELECT listed_by FROM $owner_url WHERE post_id='$post_id'");
			$row2=mysql_fetch_array($result);
			$listed_by = $row2['listed_by'];
			$newListed = removeCommaString($listed_by,$custom_url);
				mysql_query("UPDATE $owner_url SET listed_by='$newListed' WHERE post_id='$post_id'");
				//mysql_query("UPDATE ajay SET listed_by='WINNER?' WHERE post_id='$post_id'");
		}
		reloadListArray($custom_url);
		return getList();
	}
	
	if ($met == 'toEndorse'){
	//requires a GET variable with plugID,customURL, and FBid
		$plug_id=$_GET["plugID"];		//num
		$custom_url = $_GET["customURL"];		//angryjunebug
		$FBid = $_GET["FBid"];		//wesleyID

		$con=mysql_connect("host","username","password");
		mysql_select_db("tasteplug",$con);
		$result = mysql_query("SELECT endorsed_by FROM ".$custom_url." WHERE post_id='".$plug_id."'");
		$row = mysql_fetch_array($result);
		$endorsed_by=$row["endorsed_by"];
		
		$result2 = mysql_query("SELECT custom_url FROM Users WHERE FBid='$FBid'");
		$row2 = mysql_fetch_array($result2);
		
			$endorser = $row2['custom_url'];		//wesley
			$newString = makeCommaString($endorsed_by,$endorser);		//wesley
			mysql_query("UPDATE $custom_url SET endorsed_by='$newString' WHERE post_id='$plug_id'");		//works

		$output = getEndorseOutput($newString,$endorser);
		return $output;
				
	}
	
	if ($met == "deleteEndorse"){
		$plug_id=$_GET["plugID"];		//num
		$FBid = $_GET["FBid"];		//wesleyID
		$owner_url = $_GET["customURL"];
		$con=mysql_connect("host","username","password");
		mysql_select_db("tasteplug",$con);
		$customResult = mysql_query("SELECT custom_url FROM Users WHERE FBid='$FBid'");
		$customRow = mysql_fetch_array($customResult);
		
		$endorser = $customRow['custom_url'];
		
			$result = mysql_query("SELECT endorsed_by FROM $owner_url WHERE post_id='$plug_id'");
			$row2=mysql_fetch_array($result);
			$endorsed_by = $row2['endorsed_by'];
			$newEndorsed = removeCommaString($endorsed_by,$endorser);
				mysql_query("UPDATE $owner_url SET endorsed_by='$newEndorsed' WHERE post_id='$plug_id'");
		
		$output = getEndorseOutput($newEndorsed,$endorser);
		return $output;
	}
	
}

function makeCommaString($oldString,$newString){
	if (strlen($oldString)==0){
		return $newString;
	}
	//else if (strpos($oldString,',')){
		//if there is a comma in the string (e.g. more than one)
	else{
	//if the string already contains something
		if (strstr($oldString,$newString)){
			return $oldString;
		}
		else{
			return $oldString.','.$newString;
		}
	}
}

function getEndorseOutput($commaString, $customUrl = ''){
	$names = explode(',',$commaString);
	$html = '';
	if (strlen($commaString)>0){
		if ($customUrl!='' && in_array($customUrl,$names)){
			//if there is a url given
			//if the person viewing has endorsed
			$count=0;
			foreach($names as $name){
				if ($name == $customUrl){
				unset($names[$count]);
				}
				$count++;
			}
					
			if (count($names)==0){
				$html = 'You endorse this';
			}
			else if (count($names)==1){
				$other = $names[0];
				$html  = "You and <a href='http://tasteplug.com/$other'>$other</a> endorse this";
			}
			else if (count($names)==2){
				$other = $names[0];
				$html  = "You, <a href='http://tasteplug.com/$other'>$other</a> and 1 person endorse this";
			}
			else if (count($names)>=3){
				$other = $names[0];
				$count = strval(count($names)-1);
				$html  = "You, <a href='http://tasteplug.com/$other'>$other</a> and $count other people endorse this";
			}
		}
		else{
			//if url is not given or if url is not included
			if (count($names)==1){
				$other = $names[0];
				$html  = "<a href='http://tasteplug.com/$other'>$other</a> endorses this";
			}
			else if (count($names)==2){
				$other = $names[0];
				$other2 = $names[1];
				$html  = "<a href='http://tasteplug.com/$other'>$other</a> and 1 person endorse this";
			}
			else if (count($names)>=3){
				$other = $names[0];
				$count = strval(count($names)-1);
				$html  = "<a href='http://tasteplug.com/$other'>$other</a> and $count other people endorse this";
			}					
		}
		}
		else{
			$html = '';
		}
		return $html;
}

function removeCommaString($oldString,$newString){
	if (strlen($oldString)==0){
		return $oldString;
	}
	else{
		$names=explode(',',$oldString);
		if (in_array($newString,$names)){
			$count=0;
			foreach($names as $name){
				if ($name == $newString){
					unset($names[$count]);
				}
				$count++;
			}
		if (count($names)>0){
			if (count($names>1)){
				return implode(',',$names);
			}
			else{
				return $names[0];
			}
		}
		else{
			return '';
		}
		}
		
	}
}


?>