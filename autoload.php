<?php
header("Access-Control-Allow-Origin: *");

if (hasParam('utf'))
{
header("Content-Type: application/json; charset=UTF-8");
}


$proxy = getRandomProxy();
if (hasParam('proxy'))
{
$proxy = $_GET['proxy'];
}

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
  $proxies = file('https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=2000&country=all&ssl=all&anonymity=all');
 return trim($proxies[array_rand($proxies,1)]);
}
function getRandomAgent()
{
if (hasParam('agent'))
{
  return urlDecode($_GET['agent']);
}
else
{
$bits = file('agent.list');
 return trim($bits[array_rand($bits,1)]);
}
}

function proxy($proxy, $url){
$url = ($url);
$agent = getRandomAgent();
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_URL, $url);
$ref = "http://google.com";
if (hasParam('referer'))
{
$ref = urlDecode($_GET['referer']);
}

curl_setopt($ch, CURLOPT_REFERER, $ref);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2500);
curl_setopt($ch, CURLOPT_USERAGENT,  $agent);
curl_setopt($ch, CURLOPT_HEADER, 0);
$page = curl_exec($ch);
curl_close($ch);
return $page;
}


function hasParam($param) 
{
   return array_key_exists($param, $_REQUEST);
}

?>
