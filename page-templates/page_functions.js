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