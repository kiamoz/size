<?php

$url = 'http://www.instagram.com/p/BnWbkmCgXqA/?taken-by=papia.ir';
$returned_content = get_data($url);
print_r($returned_content);
/* gets the data from a URL */
function get_data($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  //Update.................
  curl_setopt($ch, CURLOPT_USERAGENT, 'spider');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HEADER, false);
  //....................................................
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
  $data = curl_exec($ch);
  curl_close($ch);
  echo $data;
}
?>