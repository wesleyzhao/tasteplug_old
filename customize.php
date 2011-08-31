<!DOCTYPE html>
<html lang="en">
<head><link rel="stylesheet" href="style.css" type="text/css"/>
<meta charset=utf-8>
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
</head>
<title>tasteplug - choose your URL</title>
<body>
	<?php 		//get Facebook ready
	include_once("php-scripts/FacebookScripts.php");
	include_once("page-templates/custom_url_functions.php");
	define('FACEBOOK_APP_ID', '152050941511848');
	define('FACEBOOK_SECRET', '5290ad67b00e033d49953ddcc163914b');
	?>
	<script type="text/javascript">
	function toHome(){
		window.location.href="/index.php"
	}

	function toProfile(url){
		window.location.href="/"+url;
		//window.location.href="http://google.com";
	}
</script>

<?php
	$cookie = getCookie();
	if (isLoggedIn($cookie)){
		logged_in($cookie);
		if (hasCustom(getFBid($cookie))){
			echo "<script type='text/javascript'>var custom=".json_encode(hasCustom(getFBid($cookie))).";";
			?>
			toProfile(custom);</script>
			<?php
		}
	}
	
	else if (!isLoggedIn($cookie)){
		?><script type="text/javascript">toHome();</script><?php
	}
	
?>

<div id="wrapper">
<div id = "index-header"><?php echo pageHeader();?></div>


<div id ="choose-url">



<h1>
Hello <?php echo getFirstName();?>, </h1> <br>
You're about to have your own beautiful tasteplug page. <br><br>Get ready to show your friends what you've been listening to, reading, watching, or playing. 
 <br> <h3> Create your unique tasteplug URL: </h3>


    
		<h3>Your Custom URL</h3>
        <form name="input" action="javascript:submitURL();" method="get">http://tasteplug.com/<input type="text" id="customURL" name="customURL" onkeyup="javascript:doLightBox(this.value)" size=20 maxlength="20"/>
		<input type="hidden" id="FBid" name="FBid" value="<?php echo getID();?>" />
		<div id = "submit_taken"><!--<input type="submit" value="OK"/>--></div>
            <!--<a href="#" class="close" title="close window">x</a>-->

</div>
<div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
<div id="footer-container">
	<div id="footer"> A Wesley & Ajay Production. <a href="/about.php"> (About) </a></div>
</div>

</div>

</body>
<script type="text/javascript">
      FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true,
               cookie: true, xfbml: true});
			   
function doLightBox(str){
	if (str.length==0){
		document.getElementById("submit_taken").innerHTML="please enter custom URL";
		return;
	}
	
	if (window.XMLHttpRequest)
	{
		xmlhttpCheck = new XMLHttpRequest();
	}
	
	else{
		xmlhttpCheck=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttpCheck.onreadystatechange=function()
	{
		if (xmlhttpCheck.readyState==4 && xmlhttpCheck.status==200)
		{
			document.getElementById("submit_taken").innerHTML=xmlhttpCheck.responseText;
		}
	}
	xmlhttpCheck.open("GET","php-scripts/lightbox.php?curStr="+str,true);
	xmlhttpCheck.send();
}

function submitURL(){
	var FBid = document.getElementById("FBid").value;
	var customURL = document.getElementById("customURL").value;
	
	if (window.XMLHttpRequest)
	{
		xmlhttpSubmit = new XMLHttpRequest();
	}
	
	else{
		xmlhttpSubmit=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttpSubmit.onreadystatechange=function()
	{
		if (xmlhttpSubmit.readyState==4 && xmlhttpSubmit.status==200)
		{
			var output = xmlhttpSubmit.responseText;
			window.location.href="/"+customURL;
			//with PHP end
		}
	}
	xmlhttpSubmit.open("GET","php-scripts/lightbox_submit.php?customURL="+customURL+"&FBid="+FBid,true);
	xmlhttpSubmit.send();
}
</script>