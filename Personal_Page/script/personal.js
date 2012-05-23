var xmlHttp = createXMLHttpRequest();



function myredirect(id){

	if(id == 0)
		direction("../System_News/systemNews_RoleNews.php");
	else if(id == 1)
		direction("../Discuss_Area/showCollectArticleList.php");
	else if(id == 2)
		direction("../Discuss_Area/showSubscribeDiscussArea.php");
}

function changeCSS(){
	var tmp = document.getElementById('set_css').href;
	if(tmp == "css/left.css")
		document.getElementById('set_css').href = "css/right.css";
	else
		document.getElementById('set_css').href = "css/left.css";
}

function changeTPL(x){
	if(x == 1)
		window.location = 'index.php?template=2';
	else
		window.location = 'index.php?template=1';
}

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
	xmlHttp.open("GET", url, true);
	xmlHttp.onreadystatechange = direct;
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(null);
}

function changeTitle(str){
var tmp = document.getElementById("other_info");
var new_ = document.createTextNode(str);
//tmp.replaceChild(new_, tmp.firstChild);
}
