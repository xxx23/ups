var xmlHttp = createXMLHttpRequest();
var url = "validate.php";
var name_flag = 0;
var score_flag = 1;
function createXMLHttpRequest(){
	var xmlHttp;
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}
	return xmlHttp;
}

function displayButton(){
	var tmp = document.getElementById("submit_button");
	var flag = name_flag & score_flag;
	
	if( flag == 1 )
		tmp.disabled=false;
	else
		tmp.disabled=true;
}

function typeChange(x){
	tmp = document.getElementById("score_str");
	tmp2 = document.getElementById("score_msg");
	
	if(x == 1){
		tmp.innerHTML = "請輸入配分：";
		tmp2.innerHTML = "(必填)";
		tmp3 = document.createElement("input");
		tmp3.setAttribute('type', "text");
		tmp3.setAttribute('size', "4");
		tmp3.setAttribute('name', "score");
		tmp3.setAttribute('id', "score_input");
		tmp3.onkeyup = function(){scoreChange();};
		
		tmp.appendChild(tmp3);
		score_flag = 0;
	}else{
		tmp.innerHTML = "";
		tmp2.innerHTML = "";
		score_flag = 1;
	}
	displayButton();
}

function checkName(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			var tmp = document.getElementById('name_msg');
//			tmp.innerHTML = xmlHttp.responseText;
			var num = xmlHttp.responseText;
			
			if(num == 0){
				tmp.innerHTML = "";
				name_flag = 1;
			}else{
				tmp.innerHTML = "(測驗名稱重複)";
				name_flag = 0;
			}
			displayButton();
		}
	}
}

function nameChange(x){
	var y = document.getElementById(x).value;
	var tmp = document.getElementById('name_msg');
	
	xmlHttp.open("POST", url, true);
	xmlHttp.onreadystatechange = checkName;
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	if(y.length > 0){
		str = "option=name&name="+y;
		xmlHttp.send(str);
	}else{
		tmp.innerHTML = "(必填)";
		name_flag = 0;
		displayButton();
	}
}

function checkScore(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			var tmp = document.getElementById('score_msg');
			option = xmlHttp.responseText;
			if(option == 0){
				tmp.innerHTML = "";
				score_flag = 1;
			}else{
				tmp.innerHTML = "(不正確的輸入)";
				score_flag = 0;
			}
			displayButton();
		}
	}
}

function scoreChange(){
	var y = document.getElementById('score_input').value;
	var tmp = document.getElementById('score_msg');

	xmlHttp.open("POST", url, true);
	xmlHttp.onreadystatechange = checkScore;
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	if(y.length > 0){
		str = "option=score&score="+y;
		xmlHttp.send(str);
	}else{
		tmp.innerHTML = "(必填)";
		score_flag = 0;
	}
}