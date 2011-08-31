<!DOCTYPE html>
<html lang="en">
<head><link rel="stylesheet" href="style.css" type="text/css"/>
<meta charset=utf-8>
</head>

<title>tasteplug - reveal your culture</title>

<body>

<div id = "wrapper">  

	<div id = "header"> tasteplug </div>

	<div id = "left-sidebar">
		<div id = "title"> Ajay's Taste</div>
		<div id = "profile-pic"> <img src="http://img.fanbase.com/media.fanbase.com/8/1214/c60158696c34d67635ddb8deb720f2e744363ebc.jpg?x=200&y=223&sig=579ddf063a521e4b5a803d9b905beb86"/></div>
		<div class="descriptor"> Facebook profile: </div>
		<div class="profile-info"> <a href="http://facebook.com/ajaymehta">Ajay Mehta</a> </div>
		<div class="descriptor"> Twitter: </div>
		<div class="profile-info"> @<a href="http://twitter.com/ajaymehta">ajaymehta</a> </div>
		<div class="descriptor">Website: </div>
		<div class="profile-info"><a href="http://www.ajayumehta.com">http://ajayumehta.com</a> </div>
		<div class="descriptor">City: </div>
		<div class="profile-info">New York, NY </div>
		<div class="descriptor">About me: </div>
		<div class="profile-info">Intern, student. </div>
		<div class="descriptor">Things I like: </div>
		<div class="profile-info">(Pull top 2 movies, books, tv shows, music) </div>
		<div class= "descriptor"> Plug count: </div>	
		<div class="profile-info"> 37</div>
</div>

<div id = "plugs-container">
	
	<div id = "search">
	<form name="search-amazon" action="javascript:search();" method="get">
		<input class=search-field type="text" id="keywords" name="keywords" size=70px value="What are you experiencing?" onfocus="this.value=''"/>
		<div class="clear-left"> </div>
		<div class="radio-button"> <input type="radio" name="media-type" value="game">Game </div>
		<div class="radio-button"> <input type="radio" name="media-type" value="music">Music </div>
		<div class="radio-button"> <input type="radio" name="media-type" value="movie-tv">Movie/TV </div>
		<div class="radio-button"> <input type="radio" name="media-type" value="book" checked>Book </div>
		<input class="find-button" type="button" name="find_button" value="Find!" />
	</form>
	</div>
	
	<div class="edit-plug" id="edit-plug"> 
		<div id = "edit01">
			<form name = "plug-edit" action="javascript:savePlug();" method="get">
			<div class="wrong-result">Is this the wrong result? <input type="submit" value="save"/></div>
			<div class="plug-image"><img height="120" src="http://ecx.images-amazon.com/images/I/41SA9GBrroL._SL160_.jpg"/></div>
			
				<input class="edit-plug-title" type="text" id="titleID" name="title" size="40" maxlength="40" value="Psychic Chasms (editable)"/>
				Performed by <input class="edit-plug-attribute" type="text" id="attributeID" name="attribute" size="40" maxlength="40" value="Neon Indian (editable)"/>
				<div class="plug-timestamp">4:35 pm on Jan 5</div>
				<div class="user-says">Ajay says... </div>
				<textarea class="edit-plug-blurb" id="blurb_ID" name="blurb" cols="60" rows="2" style="overflow:hidden">A crazy psychedelic album. Listen to this if you want to zone out to some chill tunes. (editable)</textarea>
			</form>
		</div>
	</div>
	<div id = "plugs">
	<div class = "one-plug" id="thisplug_id">
		<div class = "user-tool">facebook | twitter | edit | delete</div>
		<div class = "plug-image"><img height="120" src="http://ecx.images-amazon.com/images/I/51BoBX-hsyL._SL160_.jpg"/></div>
		<div class = "plug-title">Ender's Game (first edition)</div>
		<div class = "plug-attribute">Written by Orson Scott Card</div>
		<div class = "plug-timestamp">4:35 pm on Jan 5</div>
		<div class="user-says">Ajay says...</div>
		<div class = "plug-blurb">The best book ever - if you're smart teehee.</div>
	</div>
	
	<div class = "one-plug">
		<div class = "user-tool">facebook | twitter | edit | delete</div>
		<div class = "plug-image"><img height="120" src="http://ecx.images-amazon.com/images/I/51Y9HZWJCNL._SL160_.jpg"/></div>
		<div class = "plug-title">Being John Malkovich</div>
		<div class = "plug-attribute">Starring John Cusack, Cameron Diaz | Directed by Spike Jonze</div>
		<div class = "plug-timestamp">10:48 am on Jan 5</div>
		<div class="user-says">Ajay says...</div>
		<div class = "plug-blurb">Awesome absurdist fantasy movie. Very haunting...</div>
	</div>
	</div> <!--end id plugs-->
</div>

<div id="footer-container">
	<div id="footer"> A Wesley & Ajay Production. <a href="http://about.com"> (About) </a></div>
</div>
</div>



</body>
</html>