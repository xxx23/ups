/*
var xmlHttp = createXmlHttpRequestObject();
var serverAddress = "validateProfile.php";
var showErrors = true;
var cache = new Array();

function createXmlHttpRequestObject() 
{
  var xmlHttp;
  try
  {
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
                                    "MSXML2.XMLHTTP.5.0",
                                    "MSXML2.XMLHTTP.4.0",
                                    "MSXML2.XMLHTTP.3.0",
                                    "MSXML2.XMLHTTP",
                                    "Microsoft.XMLHTTP");
    for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++) 
    {
      try 
      { 
        xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
      } 
      catch (e) {} 
    }
  }
  if (!xmlHttp)
    displayError("Error creating the XMLHttpRequest object.");
  else 
    return xmlHttp;
}

function displayError($message)
{
  if (showErrors)
  {
    showErrors = false;
    alert("Error encountered: \n" + $message);
    setTimeout("validate();", 10000);
  }
}

function validate(inputValue, fieldID)
{
  if (xmlHttp)
  {
    if (fieldID)
    {
      inputValue = encodeURI(inputValue);
      fieldID = encodeURIComponent(fieldID);
      cache.push("inputValue=" + inputValue + "&fieldID=" + fieldID);
    }
    try
    {
      if ((xmlHttp.readyState == 4 || xmlHttp.readyState == 0) && cache.length > 0)
      {
        var cacheEntry = cache.shift();
        xmlHttp.open("POST", serverAddress, true);
        xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttp.onreadystatechange = handleRequestStateChange;
        xmlHttp.send(cacheEntry);
      }
    }
    catch (e)
    {
      displayError(e.toString());
    }
  }
}

function handleRequestStateChange() 
{
  if (xmlHttp.readyState == 4) 
  {
    if (xmlHttp.status == 200) 
    {
      try
      {
        readResponse();
      }
      catch(e)
      {
        displayError(e.toString());
      }
    }
    else
    {
      displayError(xmlHttp.statusText);
    }
  }
}

function readResponse()
{

  var response = xmlHttp.responseText;
  if (response.indexOf("ERRNO") >= 0 || response.indexOf("error:") >= 0|| response.length == 0)
    throw(response.length == 0 ? "Server error." : response);
  responseXml = xmlHttp.responseXML;

  xmlDoc = responseXml.documentElement;
  result = xmlDoc.getElementsByTagName("result")[0].firstChild.data;
  fieldID = xmlDoc.getElementsByTagName("fieldid")[0].firstChild.data;
  errorMsg = xmlDoc.getElementsByTagName("msg")[0].firstChild.data;
  message = document.getElementById(fieldID + "Failed");
  message.className = (result == "0") ? "error" : "hidden";
  message.innerHTML = errorMsg; 
  setTimeout("validate();", 500);
}
*/
function setFocus()    
{
  //document.getElementById("txtName").focus();
}

/*
function include(file) {
document.write(file);
}
include('../script/prototype.js');
include('menu.js');*/
/*
var MAX_SELECTION = 10;
var suggestMenu;
var addrQuery;

function init()
{
	suggestMenu = new Menu('suggestMenu','selAddr', 'choose_addr', "son", "soff");
	addrQuery ="";
}
function choose_addr(id)
{
	$('txtAddr').value = suggestMenu.get_content(id);
	Element.hide('selAddr');
	query();
}
function showResult(req)
{
	if(req.responseText.length > 0){
		var addList = req.responseText.split('\n').without('\r','\n','');
		//Element.hide('');
		if(addList.length == 0)
			return;
		Element.show('selAddr');
		suggestMenu.clear();
		for(var w=0; w < Math.min(addList.length, MAX_SELECTION); w++){
				suggestMenu.add_item(addList[w]);
		}
		suggestMenu.highlight(0);
	}
}

function query()
{
	var user_input =  document.getElementById("txtAddr").value;
	//var user_input = $F('txtAddr');
	if(user_input.length > 0 && addrQuery != user_input){
		addrQuery = user_input;
		var parms = 'prefix ='+encodeURIcomponent(user_input);
		var ajaxQ = new Ajax.Request('test.php',
									 {method:'get',
									  parameters: parms,
									  onComplete: showRequest
									 });
		//Element.show();
	}
}	
*/