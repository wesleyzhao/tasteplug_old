<?php
include_once('single_plug.php');
//include_once('../php-scripts/indexFunctions.php');
$customUrl='';$first_name='';$last_name='';$avatar_src='';$FBurl='';$website='';$location='';$FBid='';
$cookie = array();
$postsArray= array();
$listAray = array();
$plugCount = 0;
$isOwner = false;

function createPage($pageTitle){
	$temp =fopen("../page-templates/custom_url.php",'r');
	$data = fread($temp,filesize("../page-templates/custom_url.php"));
		fclose($temp);
	
	$newFile=$pageTitle.".php";
	$fileHandle = fopen('../'.$newFile,'w');
	fwrite($fileHandle,$data);
		fclose($fileHandle);
	}
	
function getScripts(){
	$temp = fopen("../page-templates/foot_script.php",'r');
	$data = fread($temp,filesize("../page-templates/foot_script.php"));
	fclose($temp);
	return $data;
}
function setGlobalUrl($url){
	global $customUrl,$first_name,$last_name,$avatar_src,$FBurl,$website,$location,$FBid;
	global $postsArray,$plugCount;
	global $listArray, $listCount;
	
	$customUrl = $url;
	
	$worked = false;
	$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
	mysql_select_db("tasteplug",$con);
		
		$result=mysql_query("SELECT * FROM Users WHERE custom_url='".$customUrl."'");
		$exists=mysql_num_rows($result);
		if ($exists)
			{
				$row = mysql_fetch_array($result);
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$avatar_src = $row['avatar_src'];
				$FBurl = "http://www.facebook.com/profile.php?id=".$row['FBid'];
				$website = $row['website'];
				$location = $row['location'];
				
				$FBid = $row['FBid'];
				$worked= true;
			}
		else{
			$worked= false;
		}
		$postResult = mysql_query("SELECT * FROM $customUrl");
		if (mysql_num_rows($postResult)){
		
			while ($postRow = mysql_fetch_array($postResult)){
				$postsArray[] = $postRow;
				$plugCount++;
			}
		}
		
		$listTable = $customUrl."_list";
		$listResult = mysql_query("SELECT * FROM $listTable");
		if (mysql_num_rows($listResult)){
			while ($listItem = mysql_fetch_array($listResult)){
				$listArray[]=$listItem;
				$listCount++;
			}
		}
	
	mysql_close($con);
	return $worked;
}

//if(!function_exists('setCookie')){

function setArray($cook){
	global $cookie,$FBid,$isOwner;
	$cookie = $cook;
	if ($cookie){
		if ($cookie['uid']==$FBid) $isOwner = true;
	}
}

//}

function isOwner(){
	global $isOwner;
	if ($isOwner) {
		return true;
	}
	else return false;
}

function fullName(){
	return firstName()." ".lastName();
}

function firstName(){
	global $first_name;
	return $first_name;
}

function lastName(){
	global $last_name;
	return $last_name;
}

function getAvatar(){
	global $avatar_src;
	return $avatar_src;
}

function FBurl(){
	global $FBurl;
	return $FBurl;
}

function userWebsite(){
	global $website;
	return $website;
}

function location(){
	global $location;
	return $location;
}

function plugCount(){
	global $plugCount;
	return $plugCount;
}

function reloadPostsArray($customURL){
	global $postsArray,$plugCount,$first_name,$isOwner;
	global $customUrl;
	$customUrl = $customURL;
			
		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$nameResult = mysql_query("SELECT first_name FROM Users WHERE custom_url='$customUrl'");
		$nameRow = mysql_fetch_array($nameResult);
		$first_name = $nameRow["first_name"];
		
		$postResult = mysql_query("SELECT * FROM $customUrl");
		if (mysql_num_rows($postResult)){
		
			while ($postRow = mysql_fetch_array($postResult)){
				$postsArray[] = $postRow;
				$plugCount++;
			}
		}
		$isOwner = true;
	
}

function reloadListArray($customURL){
	global $listArray,$listCount,$isOwner;
	$table = $customURL.'_list';
		
		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$listResult = mysql_query("SELECT * FROM $table");
		if (mysql_num_rows($listResult)){
		
			while ($itemRow = mysql_fetch_array($listResult)){
				$listArray[] = $itemRow;
				$listCount++;
			}
		}
	
	$isOwner=true;
}

function getPlugs(){
	global $plugCount,$postsArray,$customUrl;
	$plugsHTML='';
	$endorsed_by='';
	$tweetScript = '<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>';
	$fbScript = '<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>';
	
	$ordered = array_sort($postsArray,'post_id',SORT_ASC);
	if ($plugCount>0)
	{
		foreach ($ordered as $postRow){
			$postArr = array();
			$endorseFunc = "<a href='javascript:endorse(".$postRow["post_id"].")'>endorse</a>";
			$addedFunc = "<a href='javascript:addToList(".$postRow["post_id"].")'>add to list</a>";
			if (isOwner()) {
				$edit = "<a href='javascript:doEdit(".$postRow["post_id"].")'>edit</a>";
				$delete = "<a href='javascript:doDelete(".$postRow["post_id"].")'>delete</a>";
				$thisUrl = "http://tasteplug.com/$customUrl#plug_{$postRow['post_id']}";
				$blurb = str_replace("'",'&#39;',$postRow['blurb']);
				$tweet = "a href='http://twitter.com/share' class = 'twitter-share-button' data-count='none' data-url='$thisUrl' data-text='Just plugged {$postRow['title']} on @tasteplug! ".$blurb."' data-counturl='$thisUrl'";
				$fb_meta = "meta property='og:title' content='My plug for {$postRow['title']} on TastePlug'/><meta property='og:description' content='{$postRow['blurb']}' /><meta property='og:image' content='{$postRow['image_src']}'/";
				$encodedUrl = urlencode($thisUrl);$encodedTitle =urlencode($postRow['title']);
				$fb_href = "http://www.facebook.com/sharer.php?u=$encodedUrl&t=$encodedTitle";
				$fb_share = "a name='fb_share' type='button' share_url='$thisUrl' href='$fb_href'";
				$fbml_share = "<fb:share-button class='meta'><meta name='title' contents='My plug for {$postRow['title']} on TastePlug'/><meta name='description' content='{$postRow['blurb']}'/><link rel='image_src' href='{$postRow['image_src']}'/><link rel='target_url' href='$thisUrl' /></fb:share-button>";
				$postArr["userTools"]= "<div class ='user-tool'><$fb_meta><$fb_share>Share</a> | <$tweet>twitter</a> | ".$edit." | ".$delete."</div>".$fbScript.$tweetScript;
				$endorsed_by = getEndorsedBy($postRow['post_id']);
			}
			else {
				$cook = getCookie(); //inherited from indexFunctions.php
				if (isLoggedIn($cook)){	//also inherited from indexFunctions
					$fb_id = getFBid($cook);		//inherited from indexFunctions.php
					$endorsed_by = getEndorsedBy($postRow["post_id"],$fb_id);
					if (isEndorsed($fb_id,$postRow["post_id"])) $endorseFunc = "<a href='javascript:unEndorse(".$postRow["post_id"].")'>unendorse</a>";
					if (isAdded($fb_id,$postRow["post_id"])) $addedFunc = "added";
				}
				else{
					//if not logged-in
					$endorsed_by = getEndorsedBy($postRow["post_id"]);
				}
				$addList = "<div class='add-button' id='add_".$postRow["post_id"]."'>$addedFunc</div>";
				$endorse  = "<div class='endorse-button' id='endorse_".$postRow["post_id"]."'>$endorseFunc</div>";
				$postArr["userTools"]="<div class ='user-tool'>$addList | $endorse</div>";
				}
			$postArr["imageSrc"] = "<div class ='plug-image'><a href='".$postRow['search_link']."'><img height='120' class='amazon-icon' src='".$postRow['image_src']."' /></a></div>";
			$postArr["plugTitle"]= '<div class = "plug-title"><a href="'.$postRow['search_link'].'">'.$postRow['title'].'</a></div>';
			$postArr["plugAttributes"]= getPlugAttributes($postRow);
			$postArr["plugEndorsed"] = $endorsed_by;
			$postArr["plugTime"]= '<div class = "plug-timestamp">'.convertTime($postRow['time_stamp']).'</div>';
			$postArr["author"]=firstName();
			$postArr["plugBlurb"]=$postRow['blurb'];
			$postArr["post_id"] = $postRow['post_id'];
			
			$plugsHTML = makePlug($postArr).$plugsHTML;
		}
	}
	
	return $plugsHTML;
}

function getEndorsedBy($post_id,$FBid='000'){
		global $customUrl;
		$html = '';
		$custom = hasCustom($FBid);		//inherited from indexFunction
		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$result = mysql_query("SELECT endorsed_by FROM $customUrl WHERE post_id='$post_id'");
		$row = mysql_fetch_array($result);
		$endorsed_by = $row['endorsed_by'];
		if (strlen($endorsed_by)>0){
			$endorsed_arr = explode(',',$endorsed_by);
			if ($custom && in_array($custom,$endorsed_arr)){
			//if there is a url given
					//if the person viewing has endorsed
					$count=0;
					foreach($endorsed_arr as $name){
						if ($name == $custom){
						unset($endorsed_arr[$count]);
						}
					$count++;
					}
					
					if (count($endorsed_arr)==0){
						$html = 'You endorse this';
					}
					else if (count($endorsed_arr)==1){
						$other = $endorsed_arr[0];
						$html  = "You and <a href='http://tasteplug.com/$other'>$other</a> endorse this";
					}
					else if (count($endorsed_arr)==2){
						$other = $endorsed_arr[0];
						$html  = "You, <a href='http://tasteplug.com/$other'>$other</a> and 1 person endorse this";
					}
					else if (count($endorsed_arr)>=3){
						$other = $endorsed_arr[0];
						$count = strval(count($endorsed_arr)-1);
						$html  = "You, <a href='http://tasteplug.com/$other'>$other</a> and $count other people endorse this";
					}
			}
			else{
			//if url is not given or if url is not included
					if (count($endorsed_arr)==1){
						$other = $endorsed_arr[0];
						$html  = "<a href='http://tasteplug.com/$other'>$other</a> endorses this";
					}
					else if (count($endorsed_arr)==2){
						$other = $endorsed_arr[0];
						$other2 = $endorsed_arr[1];
						$html  = "<a href='http://tasteplug.com/$other'>$other</a> and 1 person endorse this";
					}
					else if (count($endorsed_arr)>=3){
						$other = $endorsed_arr[0];
						$count = strval(count($endorsed_arr)-1);
						$html  = "<a href='http://tasteplug.com/$other'>$other</a> and $count other people endorse this";
					}					
			}
			
		}
		$html = "<div class ='plug-endorsed-by' id='endorsed-by_".$post_id."'>".$html."</div>";
		return $html;
}

function isEndorsed($FBid,$post_id){
		global $customUrl;
		$custom = hasCustom($FBid);		//inherited from indexFunction
		$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
		mysql_select_db("tasteplug",$con);
		$result = mysql_query("SELECT endorsed_by FROM $customUrl WHERE post_id='$post_id'");
		$row = mysql_fetch_array($result);
		$endorsed_by = $row['endorsed_by'];
		if (strlen($endorsed_by)>0){
			$endorsed_arr = explode(',',$endorsed_by);
			if ($custom && in_array($custom,$endorsed_arr)){	
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
}

function isAdded($FBid,$post_id){
	global $customUrl;
	$custom = hasCustom($FBid);
	$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
	mysql_select_db("tasteplug",$con);
	$table = $custom.'_list';
		$result = mysql_query("SELECT owner_post_id FROM $table WHERE owner_url='$customUrl'");
		if (mysql_num_rows($result)){
			$arr = array();
			while ($row = mysql_fetch_array($result)){
				$arr[] = $row['owner_post_id'];
			}
			
			if (in_array($post_id,$arr)) return true;
			else return false;
		}
		else{
			return false;
		}
}

function getList(){
	global $listArray,$listCount;
	$listHTML='';
	$beginList ='';
	$endList='';
	
	
	$listArr = array();
	if ($listCount>0){
		$beginList ='<div id = "list-container"><div id="list-title"><a href="">The List</a></div>';
		$endList='</div><!--end list-container-->';
		
		$ordered = array_sort($listArray,'item_id',SORT_ASC);
		
		foreach ($ordered as $itemRow){
			$listArr = array();
			if (isOwner()){
				$delete = "<a href='javascript:listDelete(".$itemRow['item_id'].")'>X</a>";
				$listArr['functions']='<div class="list-delete">'.$delete.'</div>';
			}
			else{
				$listArr['functions']='<div class="list-delete"></div>';
			}
			$listArr["imageSrc"]='<a href="/'.$itemRow['owner_url'].'"><img class="list-item-image" src="'.$itemRow['image_src'].'"/></a>';
			$listArr["item_id"]=$itemRow['item_id'];
			$listArr["title"]='<div class="list-item-title"><a href="'.$itemRow['search_link'].'">'.$itemRow['title'].'</a></div>';
			$listArr["owner_url"]='<div class="list-item-owner">From <a href="/'.$itemRow['owner_url'].'">'.$itemRow['owner_url']."</a>'s plugs</div>";
		
			$listHTML=makeListItem($listArr).$listHTML;
		}
	}
	$listHTML=$beginList.$listHTML.$endList;
	return $listHTML;
	
}

function getPlugAttributes($rowArray){
	$att2='';
	$type = $rowArray['category'];
	$attribute = $rowArray['attribute'];
	
	if ($type=='DVD'){
		$att = 'Starring '.$attribute;
		if (strlen($rowArray['attribute_extra'])>0)
		{
			$att2='Directed by '.$rowArray['attribute_extra'];
		}
	}
	else if ($type=='Music'){
		$att = 'Performed by '.$attribute;
	}
	else if ($type=='Books'){
		$att = 'Written by '.$attribute;
	}
	else if ($type=='VideoGames'){
		$att = 'Made by '.$attribute;
	}
	$html = '<div class = "plug-attribute">'.$att.'</div>';
	if (strlen($att2>0)) {
		$html = $html.'<div class = "plug-attribute">'.$att2.'</div>';
	}
	return $html;
}

function convertTime($sqlTime){
	return date("g:i a M j",strtotime($sqlTime));
}

function profileBar(){
		$website='';
		$location='';
		
		$title = '<div id = "title">'.firstName()."'s Taste</div>";
		$pic ='<div id = "profile-pic"> <img src="'.getAvatar().'"/></div>';
		$FBprofile = '<div class="descriptor">Facebook profile:</div><div class="profile-info"> <a href="'.FBurl().'">'.fullName().'</a> </div>';
		//$twitter ='<div class="descriptor">Twitter:</div><div class="profile-info"> @<a href="http://twitter.com/ajaymehta">ajaymehta</a> </div>';
		if (strlen(userWebsite())>0){
		$website = '<div class="descriptor">Website:</div><div class="profile-info"><a href="'.userWebsite().'">'.userWebsite().'</a></div>';
		}
		if (strlen(location())>0){
		$location = '<div class="descriptor">City:</div><div class="profile-info">'.location().'</div>';
		}
		//$about = '<div class="descriptor">About me: </div><div class="profile-info">Intern, student. </div>';
		//$likes = '<div class="descriptor">Things I like: </div><div class="profile-info">(Pull top 2 movies, books, tv shows, music) </div>';
		$plugCount = '<div class= "descriptor">Plug count:</div><div class="profile-info">'.plugCount().'</div>';
		
		$html = $title.$pic.$FBprofile.$website.$location.$plugCount;
		$startList = '<div id="updated-list">';
		$endList='</div><!--end updated list-->';
		$html = $html.$startList.getList().$endList;
		
		return $html;
}

function footer(){
	$html = '<div id="footer"> A Wesley & Ajay Production <a href="http://tasteplug.com"> (Home)</a><a href="about.php">(About)</a></div>';
	return $html;
}

function pageHeader(){
	//$html = 'tasteplug';
	$html = '<a href="http://tasteplug.com" alt="tasteplug - reveal your culture"><img src="images/header.png"/></a>';
	$search = "<div class='search-link'><a href='/search' alt='Search for people on TastePlug'>search for friends</a></div>";
	$fb="";
	/*
	$fb_js='<script type="text/javascript">FB.init({appId: "189134051097540", status: true,cookie: true, xfbml: true});FB.Event.subscribe("auth.login", function(response) {window.location.href="http://tasteplug.com"; });</script>';
	$facebook = getFB();
	if (isLogged($facebook)) {
		try{
		$ref = $facebook->getLogoutUrl();
		}
		catch (Exception $e){}
		$fb = "<div class='log-out'><a href='$ref'>log-out</a></div>";
		$fb = $fb.$fb_js;
	}	
	
	else{
		$fb = "<div class='log-out'><a href='/'>log-in</a></div>";
	}
	
	else{
		$log = '<div class="log-out"><fb:login-button perms="user_website,email,user_location,user_likes,publish_stream,read_friendlists"></fb:login-button></div>';
		$fb = $log.getFBscripts().$fb_js;
	}
	*/
	return $html.$search.$fb;
}

function getFBscripts(){
		$script ='<div id="fb-root"></div>'.'<script src="http://connect.facebook.net/en_US/all.js"></script>\n';
		return $script;
		}

function getFB(){
	require('src/facebook.php');

	$facebook = new Facebook(array(
		'appId' => '189134051097540',
		'secret' => '8408c2db6134680bca065ac615c86a24',
		'cookie' => true,
		));
	return $facebook;
}

function isLogged($facebook){
	
	$session = $facebook->getSession();
	if ($session){
		$uid = $facebook->getUser();
		$person = $facebook->api("/$uid");
		return $uid;
	}
	else{
		return false;
	}
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function javascriptFunctions(){
$js =<<<EOD
<script type="text/javascript">
function doEdit(post_id){
if (window.XMLHttpRequest)
{
xmlhttpEdit=new XMLHttpRequest();
}
else{
xmlhttpEdit=new ActiveXOBject("Microsoft.XMLHTTP");
}
xmlhttpEdit.onreadystatechange=function()
{
if (xmlhttpEdit.readyState==4 && xmlhttpEdit.status==200)
{
document.getElementById("plug_"+post_id).innerHTML=xmlhttpEdit.responseText;
}
}
//var imgSrc=document.getElementById
var customURL = <?php echo $customURL;>;
var firstName = <?php echo $firstName();>;
xmlhttpEdit.open("GET","/php-scripts/modify_posts.php?method=doEdit&plugID="+post_id+"&customURL="+customURL+"&firstName="+firstName,true);
xmlhttpEdit.send();		
}	
function doDelete(post_id){
if (window.XMLHttpRequest)
{
xmlhttpDelete=new XMLHttpRequest();
}
else{
xmlhttpDelete=new ActiveXOBject("Microsoft.XMLHTTP");
}
xmlhttpDelete.onreadystatechange=function()
{
if (xmlhttpDelete.readyState==4 && xmlhttpDelete.status==200)
{
document.getElementById("plug_"+post_id).innerHTML='';
}
}
//var imgSrc=document.getElementById
var customURL = <?php echo $customURL;>;
xmlhttpDelete.open("GET","/php-scripts/modify_posts.php?method=doDelete&plugID="+post_id+"&customURL="+customURL+"&firstName="+firstName,true);
xmlhttpDelete.send();
}	
function search(){
if (window.XMLHttpRequest)
{
xmlhttpSearch=new XMLHttpRequest();
}
else{
xmlhttpSearch=new ActiveXOBject("Microsoft.XMLHTTP");
}
xmlhttpSearch.onreadystatechange=function()
{
if (xmlhttpSearch.readyState==4 && xmlhttpSearch.status==200)
{
document.getElementById("edit-plug").innerHTML=xmlhttpSearch.responseText;
}
}
//var imgSrc=document.getElementById
var customURL = <?php echo $customURL;>;
var radArray = new Array(document.getElementById("Books"),document.getElementById("VideoGames"),document.getElementById("DigitalMusic"),document.getElementById("DVD"));
var selected =  getSelectedRadioValue(radArray);
var keywords = document.getElementById("keywords").value;
var firstName = <?php echo $firstName();>;	
xmlhttpSearch.open("GET","/php-scripts/do_search.php?keywords="+keywords+"&category="+selected+"&firstName"+firstName,true);
xmlhttpSearch.send();
}
function savePlug(plugID){
if (window.XMLHttpRequest)
{
xmlhttpSave=new XMLHttpRequest();
}
else{
xmlhttpSave=new ActiveXOBject("Microsoft.XMLHTTP");
}
xmlhttpSave.onreadystatechange=function()
{
if (xmlhttpSave.readyState==4 && xmlhttpSave.status==200)
{
document.getElementById("edit_"+plugID).innerHTML='';
}
}
//var imgSrc=document.getElementById
var customURL = <?php echo $customURL;>;
var title = document.getElementById("title_"+plugID);
var attribute_prefix =  document.getElementById("prefix_"+plugID);
var attribute = document.getElementById("attribute_"+plugID).value;
if (document.getElementById("prefix_extra_"+plugID)){
var attribute_extra_prefix =  document.getElementById("prefix_extra_"+plugID);
var attribute_extra = document.getElementById("attribute_extra_"+plugID).value;
var image_src = document.getElementById("image_"+plugID).src;
var link = document.getElementById("link_"+plugID).href;
}
else {
var attribute_extra='';
}
var blurb = document.getElementById("blurb_"+plugID).value;		
xmlhttpSave.open("GET","/php-scripts/modify_posts.php?method=save&plugID="+post_id+"&customURL="+$custom_url+
"&title="+title+"&att_pre="+attribute_prefix+"&att="+attribute+"&att_ex_pre"+attribute_extra_prefix+
"&att_ex="+attribute_extra+"&blurb="+blurb+"&link="+link+"&img_src="+image_src,true);
xmlhttpSave.send();
}	
function getSelectedRadioValue(buttonGroup)
{
// returns the value of the selected radio button or "" if no button is selected
var i = getSelectedRadio(buttonGroup);
if (i == -1) {
return "Books";	//default
		} else {
if (buttonGroup[i]) { // Make sure the button group is an array (not just one button)
return buttonGroup[i].value;
} else { // The button group is just the one button, and it is checked
return buttonGroup.value;
}
}
}
function getSelectedRadio(buttonGroup) {
// returns the array number of the selected radio button or -1 if no button is selected
if (buttonGroup[0]) { // if the button group is an array (one button is not an array)
for (var i=0; i<buttonGroup.length; i++) {
if (buttonGroup[i].checked) {
return i
}
}
} else {
if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero
}	
// if we get to this point, no radio button is selected
return -1;
} // Ends the "getSelectedRadio" function
</script>
EOD;

return $js;
}

?>