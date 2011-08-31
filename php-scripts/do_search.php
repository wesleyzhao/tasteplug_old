<?php
require_once "search_functions.php";
require_once "../page-templates/single_plug.php";

$searchWords = $_GET["keywords"];
$category = $_GET["category"];
$firstName = $_GET["firstName"];
$resultXML = getXMLresponse($category,$searchWords);


$image_html = getImageHTML($resultXML);
$search_url = getSearchURL($resultXML);
$title = getTitle($resultXML);

if ($category == "Books"){
	$attribute_prefix="Written by ";
	$attribute = getAuthor($resultXML);
}

if ($category == "VideoGames"){
	$attribute_prefix="Made by ";
	$attribute=getStudio($resultXML);
}

else if ($category == "DVD"){
	$attribute_prefix="Starring ";
	$attribute=getStar($resultXML);
	if (strlen(getDirector($resultXML))>1){
		$attribute_extra_prefix="Directed by ";
		$attribute_extra=getDirector($resultXML);
	}
}

else if ($category == "Music"){				//MUSIC vs DIGITAL MUSIC
	$attribute_prefix="Performed by ";
	$attribute=getArtist($resultXML);
}
else if ($category == "DigitalMusic"){				//MUSIC vs DIGITAL MUSIC
	$attribute_prefix="Performed by ";
	$attribute=getArtist($resultXML);
}
if ($attribute_extra){
	$return = makeNewPlug($image_html,$search_url,$title,$attribute_prefix,$attribute,$firstName,"",0,$attribute_extra_prefix,$attribute_extra);
}
else
{
	$return = makeNewPlug($image_html,$search_url,$title,$attribute_prefix,$attribute,$firstName);
}

echo $return;
?>