<?php
// // error_reporting
error_reporting(E_ERROR);//E_ALL
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// include_once("http.php");
// include_once("ncore.php");
include_once("../transmission-php/class/TransmissionRPC.class.php");

$data = json_decode(file_get_contents("php://input"));
if($data){

	//get config file
	$config = json_decode(file_get_contents("../.config"));	

	// declares	
	$url = "https://ncore.cc/torrents.php?action=download&key={$config->ncore->accesskey}&id={$data->id}"; 
	$path = realpath("../../torrents/");
	$file_name = "$path/$data->id"; 

	// the magic
	function dl_add($url, $file_name, $config){
		if(file_put_contents($file_name, file_get_contents($url)) && $config) { 
			$rpc = new TransmissionRPC($config->transmission->host, $config->transmission->user, $config->transmission->pw);
			$result = $rpc->add( $file_name, $config->transmission->download_dir, array('paused' => $config->transmission->pauseOnAdd) );
			if($result->result == "success"){
				print "true";
			}else{
				print " transmission: false";
			}
		} else { 
				print "download torrent file: false";
		}
	}

	// make folder for torrent files
	if (!file_exists($path)) {
		if(mkdir($path, 0777, true)){
			dl_add($url,  $file_name, $config);
		}else{
			print "make torrent dir: false";
		}
	}else{
		dl_add($url,  $file_name, $config);
	} 
}else{
	print "false";
}
	
?>