<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$proxy = getRandomProxy();


if (!hasParam('url'))
{
  echo "no url provided";
  exit;
}
else
{
  $url = urlDecode($_GET['url']);
  $result = proxy($proxy, $url);
  while(strlen($result) < 5)
  {
    $result = proxy(getRandomProxy(), $url);
  }

  echo $result;
  exit;
}

function getRandomProxy()
{
  $proxies = file('working-proxies.txt');
 return trim($proxies[array_rand($proxies,1)]);
}
function getRandomAgent()
{
  $bits = file('useragents.txt');
 return trim($bits[array_rand($bits,1)]);
}

function proxy($proxy, $url){
$url = ($url);
$agent = getRandomAgent();
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_REFERER, "https://www.youtube.com/");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2500);
curl_setopt($ch, CURLOPT_USERAGENT,  $agent);
curl_setopt($ch, CURLOPT_HEADER, 0);
$page = curl_exec($ch);
curl_close($ch);
if (strlen($page) > 5)
{
   $hit = true;
}

return $page;
}


function hasParam($param) 
{
   return array_key_exists($param, $_REQUEST);
}

?>
