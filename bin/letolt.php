<?php
// // error_reporting
// error_reporting(E_ERROR);//E_ALL
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

include_once("http.php");
// include_once("ncore.php");
include_once("transmission-php/class/TransmissionRPC.class.php");

$data = json_decode(file_get_contents("php://input"));
if($data){

	$config = json_decode(file_get_contents("./.config"));	
	$accesskey = "6f2bb8786b5a7f4b0be902e791dcb184";

	$url = "https://ncore.cc/torrents.php?action=download&key={$accesskey}&id={$data->id}"; 
	$path = realpath("../torrents/");
	$file_name = "$path/$data->id";  
		
	if(file_put_contents($file_name, file_get_contents($url)) && $config) { 
			$rpc = new TransmissionRPC($config->host, $config->user, $config->pw);
			$result = $rpc->add( $file_name, $config->download_dir, array('paused' => false) );
			if($result->result == "success"){
				print "true";
			}else{
				print "false";
			}
	} 
	else { 
			print "false";
	} 

}

?>