<?php
include_once("http.php");

function nCore_HitNRun($e){ //hnr_torrents
	$dat = array();
	for ($i=0; $i < sizeof($e); $i++) {
		$dat[] = array(
			'name' => $e[$i]["children"][0]["children"][0]["children"][0]["title"],
			'href' => $e[$i]["children"][0]["children"][0]["children"][0]["href"],
			'start' => $e[$i]["children"][0]["children"][1]["html"],
			'seedTimeLeft' => $e[$i]["children"][0]["children"][6]["children"][0]["html"],
			'ratio' => $e[$i]["children"][0]["children"][7]["children"][0]["html"]
		);
	}
	return $dat;
}
function nCore_torrents($dat){
	foreach($dat as $item){
		
		if($item["childs"][1]["childs"][0]["childs"][1]["childs"][1]["childs"][0]["title"]){
			$name = $item["childs"][1]["childs"][0]["childs"][1]["childs"][1]["childs"][0]["title"];
			$href = $item["childs"][1]["childs"][0]["childs"][1]["childs"][1]["childs"][0]["href"];
			$imdb = $item["childs"][1]["childs"][0]["childs"][1]["childs"][1]["childs"][1]["childs"][1]["childs"][1]["text"];

			$img = $item["childs"][1]["childs"][0]["childs"][1]["childs"][1]["childs"][1]["childs"][0]["childs"][0]["onmouseover"];
		}else{
			$name = $item["childs"][1]["childs"][0]["childs"][0]["childs"][1]["childs"][0]["title"];
			$href = $item["childs"][1]["childs"][0]["childs"][0]["childs"][1]["childs"][0]["href"];
			$imdb = $item["childs"][1]["childs"][0]["childs"][0]["childs"][1]["childs"][1]["childs"][0]["childs"][0]["text"];

			$img = $item["childs"][1]["childs"][0]["childs"][0]["childs"][1]["childs"][1]["childs"][0]["childs"][0]["onmouseover"];
		}
		$img_pos_start = strpos($img, "mutat('")+strlen("mutat('");
		$img_pos_end = strpos($img, "'", $img_pos_start);
		$img = substr($img, $img_pos_start, $img_pos_end-$img_pos_start);

		$res[] = array(
			'name' => $name,
			'category' => $item["childs"][0]["childs"][0]["childs"][0]["alt"],
			'size' => $item["childs"][1]["childs"][4]["text"],
			'seeders' => $item["childs"][1]["childs"][8]["childs"][0]["text"],
			'leechers' => $item["childs"][1]["childs"][10]["childs"][0]["text"],
			'href' => $href,
			'id' => substr($href, strpos($href, 'id=')+3),
			'img' => $img,
			'imdb' => $imdb,
			'json' => $item
		);
	}
	return $res;
}
function nCore_login($user, $pw){
	return post_data("https://ncore.cc/login.php","set_lang=hu&submitted=1&nev={$user}&pass={$pw}");
}
function nCore_getList($user, $pw, $search, $html){
	$search = rawurlencode($search);
	// $html = get_data("https://ncore.cc/torrents.php?miszerint=seeders&hogyan=DESC&tipus=kivalasztottak_kozott&kivalasztott_tipus=xvid_hun,xvidser_hun&miben=name&mire=$search");
	$html = post_data("https://ncore.cc/login.php?honnan=/torrents.php?miszerint=seeders&hogyan=DESC&tipus=kivalasztottak_kozott&kivalasztott_tipus=xvid_hun,xvidser_hun&miben=name&mire={$search}","set_lang=hu&submitted=1&nev={$user}&pass={$pw}");
	$doc = new DOMDocument();
	$doc->validateOnParse = true;
	$doc->loadHTML($html);
	$output = getElementsByClassName($doc, 'box_torrent');
	$output = element_to_obj($output);
	$output = nCore_torrents($output);
	return $output;
}

// error_reporting
// error_reporting(E_ERROR);//E_ALL
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);


// $data = json_decode(file_get_contents("php://input"));
$data = file_get_contents("php://input");
if($data){
	// print_r( $data );
	
	//get config file
	$config = json_decode(file_get_contents("../.config"));	

	// $output = nCore_login($config->ncore->user, $config->ncore->pw);
	$output = nCore_getList($config->ncore->user, $config->ncore->pw, $data, $output);
	
	echo json_encode($output);
	// print_r($output);
}



// $html = get_dataa("https://ncore.cc/hitnrun.php?showall=true&order_by=start&o=desc");
// $doc = new DOMDocument();
// $doc->validateOnParse = true;
// $doc->loadHTML($html);
// $output = getElementsByClassName($doc, 'hnr_torrents');
// $output = element_to_obj($output);
// $output = nCore_HitNRun($output);
// echo json_encode($output);

?>
