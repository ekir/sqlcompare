/* 
* getHTTP is a very small library for making Ajax simple 
* It is developed by Erik Gustafsson, ekir.gustafsson@gmail.com
* and released under public domain
*
* The API for using getHTTP is
*
* syncHTTP(URL)
* That makes a HTTP request and returns the result as a string.
* 
* 
* asyncHTTP(URL, myHandler)
* Make a HTTP request in the background, and when the result is retrived 
* it calls the myHandler that takes a string with the obtained result. 
*
* Version: 1.0
*/

var myHTTPobj;
var myHandler;

function getXMLHTTPRequest()
{
        var request = false;
        try
        {
                request = new XMLHttpRequest();
        }
        catch(err1)
        {
		try
		{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(err2)
		{
			try
			{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(err3)
			{
				return(false);
			}
		}
        }
        return(request);
}

function syncHTTP(tURL)
{	
        var httpobj=getXMLHTTPRequest();	
        httpobj.open("GET",tURL,false); 		
        httpobj.send(null);	
        return httpobj.responseText;
}

function reactHTTP(handler)
{
	document.title=myHTTPobj.readyState;
	if(myHTTPobj.readyState==4)
	{
		myHandler(myHTTPobj.responseText);
	}
}
	
function asyncHTTP(tURL,tHandler)
{
	myHandler=tHandler;
	myHTTPobj=getXMLHTTPRequest();
	myHTTPobj.onreadystatechange=reactHTTP;
	myHTTPobj.open("GET",tURL,true);
	myHTTPobj.send(null);
}

