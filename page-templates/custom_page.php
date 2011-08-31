<?php
	//$customURL = $_GET["customURL"];
	include_once("page-templates/custom_url_functions.php");
	include_once("php-scripts/indexFunctions.php");
	setGlobalUrl($customURL);
	setArray(getCookie());
?>
<html lang="en">

<head><link rel="stylesheet" href="style.css" type="text/css"/>
<meta charset=utf-8>
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
</head>

<title><?php echo fullName();?>'s tasteplug</title>

<body>

<div id = "wrapper">  

	<div id = "header"><?php echo pageHeader(); ?></div>

	<div id = "left-sidebar">
		<?php echo profileBar(); ?>
	</div><!--end left-sidebar-->

	<div id = "plugs-container">
		<?php if (isOwner()){
			echo newSearch();
		}?>
		<div id = "updated-plugs">
			<?php echo getPlugs();?>
		</div>
	</div>

	<div id="footer-container">
		<?php echo footer();?>
	</div>
</div><!--end wrapper-->

</body>

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
				var parent = document.getElementById("updated-plugs");
				document.getElementById("plug_"+post_id).className='';
				document.getElementById("plug_"+post_id).innerHTML=xmlhttpEdit.responseText;
				}
		}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';
		var firstName = '<?php echo firstName();?>';
	
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
				//document.getElementById("plug_"+post_id).innerHTML='';
				document.getElementById("updated-plugs").innerHTML=xmlhttpDelete.responseText;
				}
		}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';
		var firstName = '<?php echo firstName();?>';
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
				document.getElementById("edit-plug-container").innerHTML=xmlhttpSearch.responseText;
				}
		}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';
		var radArray = new Array(document.getElementById("Books"),document.getElementById("VideoGames"),document.getElementById("Music"),document.getElementById("DVD"));
		var selected =  getSelectedRadioValue(radArray);
		var keywords = document.getElementById("keywords").value;
		var firstName = '<?php echo firstName();?>';
		
		xmlhttpSearch.open("GET","/php-scripts/do_search.php?keywords="+keywords+"&category="+selected+"&firstName="+firstName,true);
		xmlhttpSearch.send();
	}
	
	function addToList(plugID){
		if (window.XMLHttpRequest)
			{
				xmlhttpList=new XMLHttpRequest();
			}
		else{
				xmlhttpList=new ActiveXOBject("Microsoft.XMLHTTP");
			}
			xmlhttpList.onreadystatechange=function()
				{
					if (xmlhttpList.readyState==4 && xmlhttpList.status==200)
					{
						//document.getElementById("edit_"+plugID).innerHTML='';
						//document.getElementById("updated-plugs").innerHTML = xmlhttpList.responseText;
						document.getElementById("add_"+plugID).innerHTML='added';
						//document.getElementById("add_"+plugID).removeAttribute('href');
					}
				}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';
		var FBid = '<?php echo getFBid(getCookie());?>';

		xmlhttpList.open("GET","/php-scripts/social_posts.php?method=toList&plugID="+plugID+"&customURL="+customURL+
		"&FBid="+FBid,true);
		xmlhttpList.send();
	}
	
	function listDelete(itemID){
		if (window.XMLHttpRequest)
		{
			xmlhttpItemDelete=new XMLHttpRequest();
		}
		else{
			xmlhttpItemDelete=new ActiveXOBject("Microsoft.XMLHTTP");
		}
		xmlhttpItemDelete.onreadystatechange=function()
		{
			if (xmlhttpItemDelete.readyState==4 && xmlhttpItemDelete.status==200)
				{
				//document.getElementById("plug_"+post_id).innerHTML='';
				document.getElementById("updated-list").innerHTML=xmlhttpItemDelete.responseText;
				}
		}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';

		xmlhttpItemDelete.open("GET","/php-scripts/social_posts.php?method=itemDelete&itemID="+itemID+"&customURL="+customURL,true);
		xmlhttpItemDelete.send();
	}
	
	function endorse(plugID){
		//need to make this...
		if (window.XMLHttpRequest)
			{
				xmlhttpEndorse=new XMLHttpRequest();
			}
		else{
				xmlhttpEndorse=new ActiveXOBject("Microsoft.XMLHTTP");
			}
			xmlhttpEndorse.onreadystatechange=function()
				{
					if (xmlhttpEndorse.readyState==4 && xmlhttpEndorse.status==200)
					{
						document.getElementById("endorse_"+plugID).innerHTML="<a href='javascript:unEndorse("+plugID+")'>unendorse</a>";
						document.getElementById("endorsed-by_"+plugID).innerHTML=xmlhttpEndorse.responseText;
					}
				}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';
		var FBid = '<?php echo getFBid(getCookie());?>';

		xmlhttpEndorse.open("GET","/php-scripts/social_posts.php?method=toEndorse&plugID="+plugID+"&customURL="+customURL+
		"&FBid="+FBid,true);
		xmlhttpEndorse.send();
	}
	
	function unEndorse(plugID){
		//need to make this...
		if (window.XMLHttpRequest)
			{
				xmlhttpUnEndorse=new XMLHttpRequest();
			}
		else{
				xmlhttpUnEndorse=new ActiveXOBject("Microsoft.XMLHTTP");
			}
			xmlhttpUnEndorse.onreadystatechange=function()
				{
					if (xmlhttpUnEndorse.readyState==4 && xmlhttpUnEndorse.status==200)
					{
						document.getElementById("endorse_"+plugID).innerHTML='<a href="javascript:endorse('+plugID+')">endorse</a>';
						document.getElementById("endorsed-by_"+plugID).innerHTML=xmlhttpUnEndorse.responseText;
					}
				}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';
		var FBid = '<?php echo getFBid(getCookie());?>';

		xmlhttpUnEndorse.open("GET","/php-scripts/social_posts.php?method=deleteEndorse&plugID="+plugID+"&customURL="+customURL+"&FBid="+FBid,true);
		xmlhttpUnEndorse.send();
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
				//document.getElementById("edit_"+plugID).innerHTML='';
				document.getElementById("edit-plug-container").innerHTML='';
				document.getElementById("updated-plugs").innerHTML=xmlhttpSave.responseText;
				document.location.reload();
				}
		}
		//var imgSrc=document.getElementById
		var customURL = '<?php echo $customURL;?>';
		var title = document.getElementById("title_"+plugID).value;
		var attribute_prefix =  document.getElementById("prefix_"+plugID).innerHTML;
		var attribute = document.getElementById("attribute_"+plugID).value;
		if (document.getElementById("prefix_extra_"+plugID)){
		var attribute_extra_prefix =  document.getElementById("prefix_extra_"+plugID).innerHTML;
		var attribute_extra = document.getElementById("attribute_extra_"+plugID).value;
		}
		else {
			var attribute_extra_prefix='';
			var attribute_extra='';
		}
		var image_src = document.getElementById("image_"+plugID).src;
		var link = document.getElementById("link_"+plugID).href;
		
		var radArray = new Array(document.getElementById("Books"),document.getElementById("VideoGames"),document.getElementById("Music"),document.getElementById("DVD"));
		var selected =  getSelectedRadioValue(radArray);
		var blurb = document.getElementById("blurb_"+plugID).value;

		
		xmlhttpSave.open("GET","/php-scripts/modify_posts.php?method=save&plugID="+plugID+"&customURL="+customURL+
		"&title="+title+"&att_pre="+attribute_prefix+"&att="+attribute+"&att_ex_pre="+attribute_extra_prefix+
		"&att_ex="+attribute_extra+"&blurb="+blurb+"&link="+link+"&img_src="+image_src+"&category="+selected,true);
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
<!--<script type="text/javascript" src="page-templates/page_functions.js"></script>-->
</html>