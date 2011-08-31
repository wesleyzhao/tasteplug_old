<?php
	//$table = 'people';
	$names = array();
	$urls =array();
	$results = array();
	$ids = array();
	
	$con=mysql_connect("tasteplug.db.7195872.hostedresource.com","tasteplug","TastePass123");
	mysql_select_db("tasteplug",$con);
	
	$result = mysql_query("SELECT first_name,last_name,custom_url,FBid FROM Users");
	if (mysql_num_rows($result)){
		while ($row = mysql_fetch_array($result)){
			$name = $row['first_name'].' '.$row['last_name'];
			$url = $row['custom_url'];
			$names[]= $name;
			//$results[]=$url;
			$urls[$name] = $url;
			$ids[$name]=$row['FBid'];
			//$names[$url]=$name;
		}
	}
	
	$search = $_GET['keywords'];
	
	if (strlen($search)>0){
		$hint = '';
		$matches = array();
		for ($i = 0; $i<count($names); $i++){
			if (stristr($names[$i],$search)){
				$matches[] = $names[$i];
			}
		}
		
		if (count($matches)>0){
			echo getResults($matches);
		}
		
		else{
			echo 'no results found';
		}
	}
	else{
		echo '';
	}
	
	function getResults($nameArr){
		$html = '';
		$start = '<div class = "result-containter">';
		$end = '</div>';
		
		foreach ($nameArr as $name){
			$html = $html.getResult($name);
		}
		
		return $start.$html.$end;
	}
	
	function getResult($name){
		global $urls,$ids;
		$url = $urls[$name];
		$id = $ids[$name];
		
		//$pic = getPicture($id,'square');
		$pic = getPicture($id,'large');
		
		$html = '';
		$start = "<div class = one-result>";
		$end = "</div>";
		$html = "<a href='/$url'><img class = 'result-image' src='$pic'/></a><div class='result-name'>".$name."</div><div class='result-username'>(<a href='/$url'>$url</a>)</div>";
		return $start.$html.$end;
		
	}
	
	function getPicture($id,$size='normal'){
		return "http://graph.facebook.com/$id/picture?type=$size";
	}
?>