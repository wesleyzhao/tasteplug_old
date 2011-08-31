<?php
require_once "Amazon.php";

function getXMLresponse($SearchIndex,$Keywords)
//returns an XML response to the query
{
	$params = array(
		"region"=>"com",
		"Operation"=>"ItemSearch",
		"SearchIndex"=>$SearchIndex,
		//"SearchIndex"=>"Books", DigitalMusic
		'ResponseGroup'=>'Medium',
		//"Keywords"=>"'".$Keywords."'"
		"Keywords"=>$Keywords
	);
	$Amazon=new Amazon();
	$queryUrl = $Amazon->getSignedUrl($params);
	//mail('wesley.zhao@gmail.com',queryUrl,"$queryUrl");
	$response = simplexml_load_file($queryUrl);
	//$str = simplexml_load_string($queryUrl);
	//mail('wesley.zhao@gmail.com',queryXMLstr,"$str");
	return $response;
}

function getImageHTML($xmlResponse)
//echos image results based off xmlResponse
{
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$imageSRC = $xmlResponse->Items->Item->MediumImage->URL;
		if (!strlen($imageSRC)>0) $imageSRC = 'images/tasteplug-logo.png';
		
	}
	else{
		//no response
		$imageSRC='images/tasteplug-logo.png';
	}
	
	return $imageSRC;
	//return $imageSRC;
}

function getTitle($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$title = $xmlResponse->Items->Item->ItemAttributes->Title;
	}
	else{
		//no response
		$title='not found';
	}
	return $title;
}

function getProductGroup($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
	//have at least one response
	$group = $xmlResponse->Items->Item->ItemAttributes->ProductGroup;
	}
	else{
		//no response
		$group='';
	}
	return $group;
}

function getSearchURL($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$url = $xmlResponse->Items->Item->DetailPageURL;
	}
	else{
		//no response
		$url='';
	}
	return $url;
}

function getPrice($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$url = $xmlResponse->Items->Item->OfferSummary->LowestNewPrice->FormattedPrice;
	}
	else{
		//no response
		$url='';
	}
	return $url;
	
}

function getDirector($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$url = $xmlResponse->Items->Item->ItemAttributes->Director;
	}
	else{
		//no response
		$url='';
	}
	return $url;
}

function getAuthor($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$url = $xmlResponse->Items->Item->ItemAttributes->Author;
	}
	else{
		//no response
		$url='';
	}
	return $url;
}

function getStar($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$url = $xmlResponse->Items->Item->ItemAttributes->Actor;
	}
	else{
		//no response
		$url='';
	}
	return $url;
}

function getStudio($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$url = $xmlResponse->Items->Item->ItemAttributes->Studio;
	}
	else{
		//no response
		$url='';
	}
	return $url;
}

function getArtist($xmlResponse){
	if($xmlResponse->Items->TotalResults >0){
		//have at least one response
		$url = $xmlResponse->Items->Item->ItemAttributes->Creator;
		//$url = $xmlResponse->Items->Item->ItemAttributes->Artist;
	}
	else{
		//no response
		$url='';
	}
	return $url;
}
?>