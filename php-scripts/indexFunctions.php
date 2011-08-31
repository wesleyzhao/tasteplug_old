<?php

define('FACEBOOK_APP_ID', '189134051097540');
define('FACEBOOK_SECRET', '8408c2db6134680bca065ac615c86a24');

function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $application_secret) != $args['sig']) {
    return null;
  }
  return $args;
}
//$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
function getCookie(){
	$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
	return $cookie;
}

function checkCookie($cookie){
	echo '<div id="fb-root"></div>\n';
	echo '<script src="http://connect.facebook.net/en_US/all.js"></script>\n';
	if ($cookie) logged_in($cookie);
	else logged_out();
}

function hasCustom($FBid){
		$con=mysql_connect("host","username","password");
		$result=mysql_query("SELECT custom_url FROM Users WHERE FBid='".$FBid."'");
		$row2=mysql_fetch_array($result);
		if (strlen($row2['custom_url'])>0){
			return $row2['custom_url'];
		}
		else{
			return false;
		}
}

function getFBid($cookie){
	return $cookie['uid'];
}

function isLoggedIn($cookie){
	//returns false if not logged in
	//returns true if is
	if (!$cookie)
	{
		return false;
	}
	else return true;
}
	
	



function logged_in($cookie){
	$con=mysql_connect("host","username","password");
	$FBid=$cookie['uid'];
	if (!$con)
		{die('Could not connect: ' . mysql_error());}
	else{
		mysql_select_db("tasteplug",$con);
		$result=mysql_query("SELECT first_name,last_name,custom_url FROM Users WHERE FBid='".$FBid."'");
		$exists=mysql_num_rows($result);
		if (!$exists)
			{
			$user=json_decode(file_get_contents(
			'https://graph.facebook.com/'.$FBid.'?access_token='.
			$cookie['access_token']));
			$first_name=$user->first_name;
			$last_name=$user->last_name;
			$avatar_src="http://graph.facebook.com/".$FBid."/picture?type=large";
			
			$test=mysql_query("INSERT INTO Users (FBid,first_name,last_name,avatar_src,email,gender,location,website)
			VALUES ('" .$FBid. "','" .$first_name. "','" .$last_name. "','" .$avatar_src. "','" .$user->email. "','" .$user->gender. "','" .$user->location->name. "','" .$user->website. "')");
			//header("Location: #lightbox-customURL");
			}
		else{		//if user has registered and is already logged-in
		
		$row=mysql_fetch_array($result);
		$custom_url=$row['custom_url'];
		
		}
		mysql_close($con);
	}
	return "<a href='javascript:FB.logout(function(response){});'>log-out</a>";
	//header("Location: ".$custom_url);
}
function logged_out(){
	return '<p><fb:login-button perms="user_website,email,user_location,user_likes,publish_stream,read_friendlists"></fb:login-button></p>';
}

function getURL($cookie){
	$con=mysql_connect("host","username","password");
	$FBid=$cookie['uid'];
	if (!$con)
		{die('Could not connect: ' . mysql_error());}
	else{
		mysql_select_db("tasteplug",$con);
		$result=mysql_query("SELECT custom_url FROM Users WHERE FBid='".$FBid."'");
		$row2=mysql_fetch_array($result);
		$arr = array();
		if (strlen($row2['custom_url'])>0){
			return "";
		}
		else{
			return $row2['custom_url'];
		}
	}
}

function getFirstName(){
			$cookie = getCookie();
			if (isLoggedIn($cookie)){
			
				$FBid=$cookie['uid'];
				$user=json_decode(file_get_contents(
				'https://graph.facebook.com/'.$FBid.'?access_token='.
				$cookie['access_token']));
				$first_name=$user->first_name;
			
			}
			else {
				$first_name = "stranger";
			}
			return $first_name;
}

?>