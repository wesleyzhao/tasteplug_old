<?php
require_once('search_functions.php');

$term = $_GET['term'];
$term = urlencode($term);

$wrapper = 'http://click.linksynergy.com/fs-bin/stat?id=m90ulZ6eSFI&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=';
$partnerId='30';
$siteID = '2687633';

$url = "http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?media=music&kind=song&limit=5&term=$term";
$json = file_get_contents($url);
$arr = json_decode($json,true);
$results = $arr['results'];
$result = $results[0];
//print_r($results);
$title = $result['trackName'];
$artist = $result['artistName'];
$trackUrl = urlencode($result['trackViewUrl']."&partnerId=$partnerId");
	$trackUrl = $wrapper.urlencode($trackUrl);
	
$previewUrl = $result['previewUrl'];
$artwork = $result['artworkUrl60'];
$price = $result['trackPrice'];

$arr = array('title'=>$title,'artist'=>$artist,'trackUrl'=>$trackUrl,'previewUrl'=>$previewUrl,'artwork'=>$artwork,'price'=>$price);
$audioHtml = "<audio src='$previewUrl' controls='controls'>Not supported</audio>";
$html = "<img src='$artwork'/><br><b>Title:</b> $title<br><b>Artist:</b> $artist<br><b>Preview:</b>$audioHtml<br><a href='$trackUrl' target='_blank'><img src='http://tasteplug.com/images/itunes_badge.gif' alt='Download on iTunes' /></a> $price";
//print_r($result);
	$amazonArr = getAmazonLink($title,$artist);
	$amazonUrl = $amazonArr['link'];
	if ($amazonUrl) {
		$amazon = "<a href='$amazonUrl' alt='Download $title from Amazon' target='_blank'><img src='http://tasteplug.com/images/amazon_badge.gif' alt='Download $title from Amazon'></a>";
		$html = $html."<br>$amazon".$amazonArr['price'];
	}
echo $html;
//$xml = getXMLresponse('DigitalMusic',"$title by $artist");
	//print_r($xml);
function getAmazonLink($title,$artist){
	$xml = getXMLresponse('DigitalMusic',"$title by $artist");
	$url = getSearchURL($xml);
	$price = getPrice($xml);
	
	return array('link'=>$url,'price'=>$price);
} 
/*
$arr = getSongArr($term);
	$title = $arr['title'];
	$artist = $arr['artist'];
	print_r($arr);
echo "Title $title. Artist $artist";
function getSongArr($term){
	$url = "http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?media=music&kind=song&limit=5&term=$term";
	$json = file_get_contents($url);
	$arr = json_decode($json,true);
	try{
		$results = $arr['results'];
		$result = $results[0];
	}
	catch (Exception $e){
		return array('message'=>"Could not find song");
	}
	$title = $result['trackName'];
	$artist = $result['artistName'];
	$trackUrl = $result['trackViewUrl'];
	$previewUrl = $result['previewUrl'];
	$artwork = $result['artworkUrl60'];
	
	if ($title && $artist){
		$arr = array('message'=>'ok','title'=>$title,'artist'=>$artist,'trackUrl'=>$trackUrl,'previewUrl'=>$previewUrl,'artwork'=>$artwork);
		return $arr;
	}
	else{
		return array('message'=>"Could not find song");
	}
}
*/
?>