<?php
include_once("indexFunctions.php");

define('FACEBOOK_APP_ID', '189134051097540');
define('FACEBOOK_SECRET', '8408c2db6134680bca065ac615c86a24');
function getLogIn(){
	$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);

	if ($cookie){
		//if the Facebook cookie exists
		echo logged_in($cookie);
	}
	else{
		//if the user is neither logged in or registered
		echo logged_out();
	}

}

function getID(){
	return getFBid(get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET));
}

?>