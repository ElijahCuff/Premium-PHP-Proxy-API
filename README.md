# Premium PHP Proxy API
PHP Proxy Loader Backend, Takes a given URL and returns the DATA through a predefined Premium proxy list.   
   
### Installation   
* Download 3 Files (proxyloade.php,agents.list,proxy.list)    
* Place All Files On PHP Server that supports CURL    


### Usage   
* Get a desired URL   
* Send the URL to the script via a GET request   
* The script will select randomly a proxy from the list and use that proxy to request the page, if a proxy is not working it'll proceed to the next proxy automatically ( adding an additional 2 second load overhead )


### Tips  
* I have tested these Proxies for about 3 Days now - everyone is always online except maybe a few dead ones after i wrote this post.
