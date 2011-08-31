<?php
function makePlug($array){
/*
$array elements=> post_id,userTools,imageSrc,plugTitle,plugAttributes,plugTime,author, and plugBlurb
*/
$blurb = checkReference($array["plugBlurb"]);
	//deleted <div class = "plug-blurb">{$array["plugBlurb"]}</div>
$plug = <<<EOD
<div class = "one-plug" id="plug_{$array['post_id']}">
{$array['userTools']}
<!--<div class = "user-tool">facebook | twitter | <a href='javascript:doEdit({$array["post_id"]})'>edit</a> | <a href='javascript:doDelete({$array["post_id"]})'>delete</div>-->
{$array["imageSrc"]}
<!--<div class = "plug-image"><a href=""><img height="120" src=""/></a></div>-->
{$array["plugTitle"]}
<!--<div class = "plug-title">Ender's Game (first edition)</div>-->
{$array["plugAttributes"]}
{$array["plugEndorsed"]}
<!--<div class = "plug-attribute">Written by: Orson Scott Card</div>-->
{$array["plugTime"]}
<!--<div class = "plug-timestamp">4:35 pm - Jan 5</div>-->
<div class = "user-says">{$array["author"]} says...</div>
<div class = "plug-blurb">{$blurb}</div>
</div>
EOD;
	return $plug;
	}
	
function makeNewPlug($img_src,$search_link,$title,$attribute_prefix,$attribute,$author_first_name,$blurb='',$plug_id=0,$attribute_extra_prefix='',$attribute_extra=''){
	$formOpen = '<form name="plug-edit" action="javascript:savePlug('.$plug_id.');" method="get">';
		$divWrongResult = '<input class="save-button" id="save_button" name="save_button" type="button" value="save" onclick="javascript:savePlug('.$plug_id.');"/>';
		$divPlugImage =  '<div class="plug-image"><a id="link_'.$plug_id.'" href="'.$search_link.'"><img class="amazon-icon" height="120" src="' .$img_src. '" id="image_'.$plug_id.'"/></a></div>';
		$divEditPlugTitle = '<input class="edit-plug-title" type="text" id="title_'.$plug_id.'" name="title" size="40" maxlength="40" value="'.$title.'"/>';
		$divEditPlugAttribute = '<div id="prefix_'.$plug_id.'">'.$attribute_prefix.' </div><input class="edit-plug-attribute" type="text" id="attribute_'.$plug_id.'" name="attribute" size="40" maxlength="40" value="'.$attribute.'"/>';
		$divTimeStamp = '<div class="plug-timestamp">4:35 pm on Jan 5</div>';
		$divUserSays='<div class="user-says">'.$author_first_name.' says... </div>';
			//$blurb = checkReference($blurb);
		$divEditBlurb='<textarea class="edit-plug-blurb" id="blurb_'.$plug_id.'" name="blurb" cols="60" rows="2" style="overflow:hidden">'.$blurb.'</textarea>';
		if (strlen($attribue_extra)>0){
			$divEditPlugAttribute2 = '<div id="prefix_extra_'.$plug_id.'">'.$attribute_extra_prefix.' </div><input type="text" class="edit-plug-attribute" id="attribute_extra_'.$plug_id.'" name="attribute" size="40" maxlength="40" value="'.$attribute_extra.'"/>';
		}
	$formClose ='</form>';
	$openEdit = '<div class="edit-plug" id="edit-plug"><div id="edit_'.$plug_id.'">';
	$closeEdit = '</div>';
	if ($divEditPlugAttribute2){
		$editHTML = $openEdit .$formOpen.$divWrongResult.$divPlugImage.$divEditPlugTitle.$divEditPlugAttribute.$divEditPlugAttribute2.$divTimeStamp.$divUserSays.$divEditBlurb.$formClose.$closeEdit;
	}
	else{
		$editHTML = $openEdit .$formOpen.$divWrongResult.$divPlugImage.$divEditPlugTitle.$divEditPlugAttribute.$divTimeStamp.$divUserSays.$divEditBlurb.$formClose.$closeEdit;
	}
	return $editHTML;
}

function checkReference($string){
	$URLs = array();
	$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$nameResult = mysql_query("SELECT custom_url FROM Users");
		$nameRow = mysql_fetch_array($nameResult);
		if (mysql_num_rows($nameResult)){
		
			while ($urlRow = mysql_fetch_array($nameResult)){
				$URLs[]=$urlRow['custom_url'];
			}
		}
	/*
	if (strpos($string,'@')){
		$pos = strpos($string,'@');
		//$endStr = substr($string,$pos);
		//$arr = preg_split("/[^a-zA-Z0-9_]/",$endStr);
		//$possible = $arr[0];
		
		//$new_string=preg_replace("/@([^a-zA-Z0-9_]+)/","<a href='$1'>$0</a>",$string);
		$new_string=preg_replace("/@([a-zA-Z0-9_]+)/","<a href='$1'>$0</a>",$string);
		return $new_string;
	}
	else{
		return $string;
	}
	*/
	$new_string=preg_replace("/@([a-zA-Z0-9_]+)/","<a href='$1'>$0</a>",$string);
		return $new_string;
	
}

function newSearch(){
	//javascript search function needs to call makeNewPlug
	//MUSIC vs DIGITAL MUSIC
	$html = <<<EOD
	<div id = "search">
		<form name="search-amazon" action="javascript:search();" method="get">
			<input class=search-field type="text" id="keywords" name="keywords" size=40 value="Search Keywords (What are you experiencing?)" onfocus="this.value=''"/>
			<div class="clear-left"></div>
			<div class="radio-button"> <input type="radio" name="media-type" id="VideoGames" value="VideoGames">Game </div>
			<div class="radio-button"> <input type="radio" name="media-type" id="Music" value="DigitalMusic">Music </div>
			<div class="radio-button"> <input type="radio" name="media-type" id="DVD" value="DVD">Movie/TV </div>
			<div class="radio-button"> <input type="radio" name="media-type" id="Books" value="Books" checked>Book </div>
			<input class="find-button" type="button" name="find_button" value="Find!" onclick="javascript:search();"/>
		</form>
	</div>
EOD;

	//$editDiv = '<div class="edit-plug" id="edit-plug">'.'</div>';
	$editDiv = '<div class="edit-plug-container" id="edit-plug-container">'.'</div>';
	
	return $html.$editDiv;
	
}

function makeListItem($array){
/*
$array elements=> functions,imageSrc,item_id,title,owner_url
*/
$item = <<<EOD
<div class = "list-item" id="item_{$array['item_id']}">
{$array['functions']}
{$array["imageSrc"]}
{$array["title"]}
{$array["owner_url"]}
</div>
EOD;

	return $item;
}
?>