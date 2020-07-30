<?php


function get_data($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  // curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function post_data($site,$data){
    $datapost = curl_init();
    $headers = array("Expect:");
    curl_setopt($datapost, CURLOPT_URL, $site);
    curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
    curl_setopt($datapost, CURLOPT_HEADER, TRUE);
    curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($datapost, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36");
    curl_setopt($datapost, CURLOPT_POST, TRUE);
    curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
    curl_setopt($datapost, CURLOPT_COOKIEFILE, "cookie.txt");

    curl_setopt($datapost, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($datapost, CURLOPT_SSL_VERIFYPEER,false);
    // curl_setopt($datapost, CURLOPT_HEADER, false);
    curl_setopt($datapost, CURLOPT_NOBODY, false);
    curl_setopt($datapost, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($datapost, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    curl_setopt($datapost, CURLOPT_AUTOREFERER, true);
    curl_setopt($datapost, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($datapost, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($datapost, CURLOPT_COOKIEJAR, "cookie.txt");
    ob_start();
    return curl_exec ($datapost);
    ob_end_clean();
    curl_close ($datapost);
    unset($datapost);
}

function getElementsByClassName($dom, $ClassName, $tagName=null) {
    if($tagName){
        $Elements = $dom->getElementsByTagName($tagName);
    }else {
        $Elements = $dom->getElementsByTagName("*");
    }
    $Matched = array();
    for($i=0;$i<$Elements->length;$i++) {
        if($Elements->item($i)->attributes->getNamedItem('class')){
            if($Elements->item($i)->attributes->getNamedItem('class')->nodeValue == $ClassName) {
                $Matched[]=$Elements->item($i);
            }
        }
    }
    return $Matched;
}
function element_to_obj($element) {
  if(gettype($element) == "array"){
    $obj = array();
    foreach($element as $el){
      $obj[] = element_to_obj($el);
    }
    return $obj;
  }else{
    $obj = array( "tag" => $element->tagName );
    if($element->nodeType == XML_TEXT_NODE) {
      $obj = $element->nodeValue;
    }else{
      foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
      }
      if($element->hasChildNodes()){
        foreach ($element->childNodes as $subElement) {
          if($subElement->nodeName != '#text'){
            $obj["childs"][] = element_to_obj($subElement);
          }else{
            $obj["text"] = $subElement->nodeValue;
          }
        }
      }

    }
    return $obj;
  }
}
// function element_to_obj_old($element) {
//   if(gettype($element) == "array"){
//     $obj_a = array();
//     for ($i=0; $i < sizeof($element); $i++) {
//       $obj_a[] = element_to_obj($element[$i]);
//     }
//     return $obj_a;
//   }else{
//     $obj = array( "tag" => $element->tagName );
//     foreach ($element->attributes as $attribute) {
//       $obj[$attribute->name] = $attribute->value;
//     }
//     foreach ($element->childNodes as $subElement) {
//       if ($subElement->nodeType == XML_TEXT_NODE) {
//         $obj["html"] = $subElement->wholeText;
//       }
//       else {
//         $obj["children"][] = element_to_obj($subElement);
//       }
//     }
//     return $obj;
//   }
// }

?>