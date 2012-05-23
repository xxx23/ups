var xmlHttp = createXMLHttpRequest();

function createXMLHttpRequest(){
	var xmlHttp;
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}
	return xmlHttp;
}

function direct(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			document.getElementById('main_block').innerHTML = xmlHttp.responseText;
		}
	}
}

function direction(url){
	xmlHttp.open("POST", url, true);
	xmlHttp.onreadystatechange = direct;
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(null);
}
