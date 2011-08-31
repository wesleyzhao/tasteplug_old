<!DOCTYPE html>
<html lang="en">
<head><link rel="stylesheet" href="style.css" type="text/css"/>
<meta charset=utf-8>
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
</head>
<title>tasteplug - reveal your culture</title>
<body>
	<?php 		//get Facebook ready
	include_once("php-scripts/FacebookScripts.php");
	define('FACEBOOK_APP_ID', '189134051097540');
	define('FACEBOOK_SECRET', '8408c2db6134680bca065ac615c86a24');
	?>
	
	<script type="text/javascript">
	function toCustomize(){
		window.location.href="/customize.php"
	}

	function toProfile(url){
		window.location.href="/"+url;
	}
</script>
	
<div id="wrapper">
<div id = "index-header"><a href="http://tasteplug.com" alt="tasteplug - reveal your culture"><img src="images/header.png"/></a></div>
<!--<div id = "log-in"><?php getLogIn(); ?></div>-->
<div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
<div id = "featured">
	<div id ="description">Share your tastes in books, movies, television, games, and more on a beautiful page.
<br><br>
Plug your recent experiences, so your friends can do them too.
<br><br>
And it's so easy.

<div id = "example"><img src="images/front-directions.png"/></div>
<br><br><br>
</div>
<b>Get started now by connecting to Facebook (don't worry, we won't post anything without your permission):</b>
<div id="fb-login"><?php getLogIn(); ?></div>
</div>


	<?php
	$cookie = getCookie();
	if (isLoggedIn($cookie)){
		if (hasCustom(getFBid($cookie))){
			echo "<script type='text/javascript'>var custom=".json_encode(hasCustom(getFBid($cookie))).";";
			?>toProfile(custom)</script><?php
		}
		else{
			?><script type="text/javascript">toCustomize()</script><?php
			//header("Location:/customize.php");
			//echo "$cookie : ".getFBid($cookie);
		}
	}
	?>

<div id="footer-container">
	<div id="footer"> A Wesley & Ajay Production. <a href="/about.php"> (About) </a></div>
</div>

</div>

</body>

<script type="text/javascript">
	  //start of FB gen code
      FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true,
               cookie: true, xfbml: true});
      FB.Event.subscribe('auth.login', function(response) {
        window.location.href="/customize.php";
		//window.location.reload();
      });
    //end of FB gen code
	
</script>