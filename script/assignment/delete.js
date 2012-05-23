/*author: lunsrot
 *date: 2007/06/25
 */
//教師用
function delete_work(work_no) {
	if( confirm('這將會刪除所有關於此作業的資訊，是否繼續？') ) {
		location.href = "tea_assignment.php?view=true&option=delete&homework_no="+work_no;
		return true;
	}
	else
		return false;
}

function createXMLHttpRequest(){
	if(window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
		return new XMLHttpRequest();
	}
}

function delete_file(file, no, str){
	var xmlHttp = createXMLHttpRequest();
	var _url = "file_delete.php";
	var _par = "homework_no=" + no + "&file=" + file;
	
	xmlHttp.open("POST", _url, true);
	xmlHttp.onreadystatechange = function (){_delete(xmlHttp, str);};
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(_par);
}

function delete_rel_file(file, no, str){
	var xmlHttp = createXMLHttpRequest();
	var _url = "ajax/tea_file_delete.php";
	var _par = "homework_no=" + no + "&file=" + file;

	xmlHttp.open("POST", _url, true);
	xmlHttp.onreadystatechange = function (){_delete(xmlHttp, str);};
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(_par);
}

function delete_answer(file, no, str){
	var xmlHttp = createXMLHttpRequest();
	var _url = "ajax/tea_answer_delete.php";
	var _par = "homework_no=" + no + "&file=" + file;

	xmlHttp.open("POST", _url, true);
	xmlHttp.onreadystatechange = function (){_delete(xmlHttp, str);};
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(_par);
}

function _delete(xmlHttp, str){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			if(xmlHttp.responseText == "0"){
				var node = document.getElementById(str);
				var _parent = node.parentNode;
				_parent.removeChild(node);
			}
		}
	}
}

//學生用
function stu_delete_file(option, file, str, no){
	var xmlHttp = createXMLHttpRequest();
	var _url = "ajax/stu_file_delete.php";
	var _par = "file=" + file + "&option=" + option + "&homework_no=" + no;

	xmlHttp.open("POST", _url, true);
	xmlHttp.onreadystatechange = function(){_delete(xmlHttp, str);};
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	xmlHttp.send(_par);
}
