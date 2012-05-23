<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>課程大綱</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}
var serverAddress = 'update_textarea.php';
var tmpContent; //暫存 用
function submitTextArea(divNode, delTextNode){
	var node_id = divNode.id;
	var content;
	var tmpNode = divNode.getElementsByTagName('textarea')[0].firstChild;
	//alert(divNode.innerHTML);
	if( tmpNode != null)
		content = tmpNode.nodeValue;
	else
		content = '';	
	tmpContent = content;			
	var parms = 'target='+node_id+'&content='+content;//encodeURIComponent(content);
	if(delTextNode != null)
		delTextNode.removeNode(true);		//刪除textNode
	var ajaxQ = new Ajax.Request(serverAddress,
								 {method:'post',
								  postBody: parms,
								  onComplete: updateDiv
								 });		
}

function updateDiv(res){
	//var response = res.responseText;
	//alert(response);
	var responseXML = res.responseXML;
	var xmlDoc = responseXML.documentElement;
	var divId = xmlDoc.getElementsByTagName('id')[0].firstChild.nodeValue;
	//var divContent = xmlDoc.getElementsByTagName('content')[0].firstChild.nodeValue;
	//取得div
	var node = document.getElementById(divId);
	//清除div內的東西
	while(node.firstChild) node.removeChild(node.firstChild);
	//建立div內的內容	
	//node.appendChild(document.createTextNode(divContent));
	node.appendChild(document.createTextNode(tmpContent));
}

function createTextArea(obj, div_name){
	var textNode ,content;
	if(obj.firstChild != null){
		textNode = obj.firstChild; //先取得div裡的textNode
		content = textNode.nodeValue; //暫存舊的資料			
		textNode.nodeValue = ""; //第一節點內容設空
	}
	else{	
		content = '';
	}
	var node = document.createElement('div');
	node.setAttribute('id', 'node-' + div_name);
	
	var textAreaNode = document.createElement('textarea');
	textAreaNode.setAttribute("value", content);	
	textAreaNode.setAttribute("cols", 70);
	textAreaNode.setAttribute("rows", 20);
	var buttonNode = document.createElement('input');
	buttonNode.setAttribute('type','button');
	buttonNode.setAttribute('value','確定修改');
	buttonNode.onclick = function(){submitTextArea(node, textNode);};
	
	node.appendChild(textAreaNode);
	node.appendChild(buttonNode);

	obj.appendChild(node);
}

function checkFirstClick(obj){
	if(obj.getElementsByTagName('div').length != 0)
		return false;
	else
		return true;	
}

function edit(id){
	var div_name = "div_" + id;	
	var obj = document.getElementById(div_name);
	if(checkFirstClick(obj))
		createTextArea(obj, id);	
}

function checkBeginSchedule(course_cd, begin_course_cd){
	window.location="../Course/check_begin_schedule.php?begin_course_cd="+begin_course_cd+"&course_cd="+course_cd;
}

function returnPersonalPage(){
	alert("您的開課已成完成。");
	window.location="../Course_Admin/show_teacher_begin_course.php";
}

{/literal}
-->
</script>
</head>

<body>
<!-- 標題 -->
<h1>編輯課程大綱</h1>
<p class="intro">
確認開課：<br />
步驟一：填寫課程大綱 (課程大綱可讓學生對於課程有初步的了解。) <br />
</p>
<!--功能部分 -->
<table>
<!--menu bar-->
<!--<tr> 
	<td>
	<table>
	<tr> 
		<td><a href="#future">宗旨</a></td>
		<td><a href="#introduction">課程簡介</a></td>
		<td><a href="#goal">教學目標</a></td>
		<td><a href="#person_mention">教授簡介</a></td>
		<td><a href="#course_process">課程進行方式</a></td>
		<td><a href="#learning_test">評量標準</a></td>
		<td><a href="#environment">軟硬體與介面說明</a></td>
	</tr>
	</table>
	</td>
</tr>-->
<!-- 課程宗旨-->
<tr>
	<td>
	<table>
	<tr>
		<td><a name="future"></a><img src="images-es/future.jpg" width="225" height="30"></td>
		<td>...............................................................</td>
		<td><input class="btn" type="button" value="編輯" onClick="edit('future');" /></td>		
	</tr>
	<tr>
		<td colspan="3"><pre><div id="div_future">{$course_future}</div></pre></td>
	</tr>
	</table>
	</td>
</tr>
<!-- 課程簡介-->
<tr>
	<td>
	<table>
	<tr>
		<td><a name="introduction"></a><img src="images-es/introduction.jpg" width="225" height="30"></td>
		<td>...............................................................</td>
		<td><input class="btn" type="button" value="編輯" onClick="edit('introduction');" /></td>	
	</tr>
	<tr>
		<td colspan="2"><pre><div id="div_introduction">{$course_introduction}</div></pre><td>
	</tr>
	</table>
	</td>
</tr>
<!-- 課程目標-->
<tr>
	<td>
	<table>
	<tr>
		<td><a name="goal"></a><img src="images-es/goal.jpg" width="225" height="30"></td>
		<td>...............................................................</td>
		<td><input class="btn" type="button" value="編輯" onClick="edit('goal');" /></td>		
	</tr>
	<tr>
		<td colspan="2"><pre><div id="div_goal">{$course_goal}</div></pre><td>
	</tr>
	</table>
	</td>
</tr>
<!-- 教授簡介-->
<tr>
	<td>
	<table>
	<tr>
		<td><a name="person_mention"></a><img src="images-es/teacher.jpg" width="225" height="30"></td>
		<td>...............................................................</td>
		<td><input class="btn" type="button" value="編輯" onClick="edit('person_mention');" /></td>		
	</tr>
	<tr>
		<td colspan="2"><pre><div id="div_person_mention">{$person_mention}</div></pre><td>
	</tr>
	</table>
	</td>
</tr>
<!-- 課程進行方式-->
<tr>
	<td>
	<table>
	<tr>
		<td><a name="course_process"></a><img src="images-es/course_process.jpg" width="225" height="30"></td>
		<td>...............................................................</td>
		<td><input class="btn" type="button" value="編輯" onClick="edit('course_process');" /></td>		
	</tr>
	<tr>
		<td colspan="2"><pre><div id="div_course_process">{$course_process}</div></pre><td>
	</tr>
	</table>
	</td>
</tr>
<!-- 評量標準-->
<tr>
	<td>
	<table>
	<tr>
		<td><a name="learning_test"></a><img src="images-es/learning_test.jpg" width="225" height="30"></td>
		<td>...............................................................</td>
		<td><input class="btn" type="button" value="編輯" onClick="edit('learning_test');" /></td>		
	</tr>
	<tr>
		<td colspan="2"><pre><div id="div_learning_test">{$learning_test}</div></pre><td>
	</tr>
	</table>
	</td>
</tr>					 
</table>
<!-- 軟硬體介面說明-->
<tr>
	<td>
	<table>
	<tr>
		<td><a name="environment"></a><img src="images-es/environment.jpg" width="225" height="30"></td>
		<td>...............................................................</td>
		<td><input class="btn" type="button" value="編輯" onClick="edit('environment');" /></div></td>		
	</tr>
	<tr>
		<td colspan="2"><pre><div id="div_environment">{$course_environment}</div></pre><td>
	</tr>
	</table>
	</td>
</tr>					 
</table>
<br />
<div class="intro">
<strong>填寫完成，是否繼續填寫課程進度</strong><br />
<input class="btn" type="button" name="checkButton" value="填選課程進度" onclick="checkBeginSchedule({$course_cd}, {$begin_course_cd});" />
<br />
<strong>不填寫課程進度。</strong></font><br />
<input class="btn" type="button" name="returnButton" value="返回個人首頁" onclick="returnPersonalPage();" />
</div>

</body>
</html>
