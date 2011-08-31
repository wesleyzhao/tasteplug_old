<?php
	include_once("php-scripts/indexFunctions.php");
	include_once("php-scripts/people_search_functions.php");
	include_once("page-templates/custom_url_functions.php");
?>
<html lang="en">

<head><link rel="stylesheet" href="style.css" type="text/css"/>
<meta charset=utf-8>
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
</head>

<title>Search for friends on TastePlug</title>

<body>

<div id = "wrapper">  

	<div id = "header"><?php echo pageHeader(); ?></div>

	<h3> Search for your friends on tasteplug: </h3> 
		<input type="text" id="user-search" value="Enter a name to search" onfocus="this.value=''" onkeyup="javascript:doResults(this.value)"/> 
			<div id = "submit_taken"></div> 
           
			<div id ='results-container'> 
			</div>

	<div id="footer-container">
		<?php echo footer();?>
	</div>
</div><!--end wrapper-->

</body>

<script type="text/javascript">
	function doResults(keywords){
		if (keywords.length<2)
		{ 
			document.getElementById("results-container").innerHTML="";
			return;
		}
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
			{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("results-container").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","php-scripts/people_search_functions.php?keywords="+keywords,true);
		xmlhttp.send();
	}
</script>
<!--<script type="text/javascript" src="page-templates/page_functions.js"></script>-->
</html>