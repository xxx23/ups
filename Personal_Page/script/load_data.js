var xmlHttp = createXMLHttpRequest();
load_course();

function createXMLHttpRequest(){
	var xmlHttp;
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}
	return xmlHttp;
}

function update_course(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			document.getElementById('course_information').innerHTML = xmlHttp.responseText;
			myredirect(0);
		}
	}
}

function load_course(){
	var url = "courseList.php";
	xmlHttp.open("POST", url, true);
	xmlHttp.onreadystatechange = update_course;
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(null);
}
