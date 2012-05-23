var xmlHttp = createXMLHttpRequest();
var url = "validate.php";
var tpl_path;

function assign_tpl_path(input){
	tpl_path = input;
}

function getObject(id){
	return document.getElementById(id);
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

function changePublic(test_no, block){
	var _url = "ajax/set_public.php";

	xmlHttp.open("GET", _url + "?test_no=" + test_no, true);
	xmlHttp.onreadystatechange = function (){ setPublic(block);};
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(null);
}

function setPublic(block){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			var value = xmlHttp.responseText;
			var tmp = block.firstChild;
			while(tmp != null){
				block.removeChild(tmp);
				tmp = block.firstChild;
			}
			tmp = document.createElement("img");
			if(value == 1)
				tmp.setAttribute("src", tpl_path + "/images/examine/green.gif");
			else
				tmp.setAttribute("src", tpl_path + "/images/examine/red.gif");
			block.appendChild(tmp);
		}
	}
}

function changeAnswer(test_no, block){
	var _url = "ajax/set_answer.php";

	xmlHttp.open("GET", _url + "?test_no=" + test_no, true);
	xmlHttp.onreadystatechange = function (){ setPublic(block);};
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(null);
}

function myredirect(id, test_bank_id, type, tab){
	window.location = 'exam_main.php?test_bank_id='+ test_bank_id +'&content_cd='+id+'&test_type='+type+'&tab='+tab;
}

function temp(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			document.getElementById('wph').innerHTML = xmlHttp.responseText;
		}
	}
}

function clicked(num){
	var in_str = 'in_box'+num;
	var in_tmp = document.getElementById(in_str);
	var ch_str = 'ch_box'+num;
	var ch_tmp = document.getElementById(ch_str);
	in_tmp.disabled = !ch_tmp.checked;
	if( ch_tmp.checked == false )
		in_tmp.value = "";
	xmlHttp.open("POST", url, true);
//	xmlHttp.onreadystatechange = temp;
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	str = "option=checkbox&checked="+ch_tmp.checked+"&value="+num;
	xmlHttp.send(str);
}

function scoreChange(x){
	var y = document.getElementById(x).value;
}

function distribute(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			var str = xmlHttp.responseText;
			var arr = str.split("/");
			for(i = 0 ; i < arr.length ; i++){
				tmp = arr[i].split(".");
				document.getElementById('in_box'+tmp[0]).value = tmp[1];
			}
		}
	}
}

function auto_distribute(){
	var score = document.getElementById('auto_score').value;
	xmlHttp.open("POST", url, true);
	xmlHttp.onreadystatechange = distribute;
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	str = "option=auto&auto="+score;
	xmlHttp.send(str);
}

function show(e,helpmsg){
	if(document.layers){
		x = e.layerX;
		y = e.layerY;
		document.layers[0].document.open();
		document.layers[0].document.write(helpmsg);
		document.layers[0].document.close();
		document.layers[0].moveTo(x, y);
		document.layers[0].visibility = "SHOW";
	}else if(document.all){
		x = event.clientX;
		y = event.clientY;
		document.all("lay").innerHTML = helpmsg;
		document.all["lay"].style.pixelLeft = x - 30;
		document.all["lay"].style.pixelTop = y + 10;
		document.all["lay"].style.visibility = "visible";
	}
}

function hide(){
	if(document.layers){
		document.layers[0].visibility = "HIDE";
	}else if(document.all){
		$("lay").style.visibility = "hidden";
//		document.all["lay"].style.visibility = "hidden";
	}
}

function _delete(){
	if(confirm("這將會刪除所有關於這些測驗的資訊，是否繼續？")){
		var form = document.getElementsByName("deleteExam")[0];
		form.submit();
		return true;
	}
	return false
}

function delete_exam(test_no) {
	if( confirm('這將會刪除所有關於此測驗的資訊，是否繼續？') ) {
		location.href = "display_exams.php?option=delete&test_no="+test_no;
		return true;
	}
	else
		return false;
}

function delete_question(test_no, sequence, fun) {
	if( confirm('這將會刪除此題，是否繼續？') ) {
		location.href = "delete_question.php?test_no="+test_no+"&sequence="+sequence+"&url="+fun;
		return true;
	}
	else
		return false;
}
