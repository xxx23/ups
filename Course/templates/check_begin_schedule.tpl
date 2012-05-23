<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>課程大綱</title>
<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}
var serverAddress = 'update_course_schedule.php';
var position, date, teach_teacher, course_type, subject, course_activity, teacher_name;
var courseUnit;
function updatePosition(res){
	//var response = res.responseText;
	//alert(response);	
	var responseXML = res.responseXML;
	var xmlDoc = responseXML.documentElement;
	var allOption = xmlDoc.getElementsByTagName('option');
	//清除原本的
	var orignialNode = document.getElementById('positionSelect');
	while(orignialNode.firstChild) orignialNode.removeChild(orignialNode.firstChild);
	//更新原本的select
	var tmpNode;
	for(var i=0; i < allOption.length ; i++){
		tmpNode = document.createElement('option');
		tmpNode.setAttribute("value", i);
		tmpNode.appendChild(document.createTextNode(allOption[i].firstChild.nodeValue));
		orignialNode.appendChild(tmpNode);
	}
	//alert(orignialNode.innerHTML);
	//顯示輸入的地方
	document.getElementById("newInputArea").style.display = "";
}

function showDataInputArea(name){
	//如果目前已經出現 轉為隱藏
	if(document.getElementById(name).style.display == ""){
		document.getElementById(name).style.display = "none";
	}else{	
		//用AJAX動態查出insert的位置
		var parms = 'target=updatePosition';
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'post',
									  postBody: parms,
									  onComplete: updatePosition
									 });
	}		
}

function showUnitArea(name){
	var node = document.getElementById(name) ;
	if(node.style.display == "")
		node.style.display = "none";
	else
		node.style.display = "";	
}

function updateCourseUnit(res){
	//更新
	var node = document.getElementById('courseUnit');
	node.firstChild.nodeValue = "期數(" + courseUnit + ")";
	//隱藏選擇courseUnit的地方
	document.getElementById('unitArea').style.display="none";
}

function changeCourseUnit(obj){
	var selectedOption = obj.options[obj.selectedIndex];
	//用AJAX更新的位置
	courseUnit = selectedOption.value;
	var parms = 'target=updateCourseUnit&unit='+selectedOption.value;
	var ajaxQ = new Ajax.Request(serverAddress,
								 {method:'post',
								  postBody: parms,
								  onComplete: updateCourseUnit
								 });	
}

function addRow(tbody){
	var newRow, newCell, textNode, divNode;
	newRow = tbody.insertRow(position-1);
	
	newCell = newRow.insertCell(0);
	textNode = document.createTextNode(position);
	newCell.appendChild(textNode);
	
	newCell = newRow.insertCell(1);
	textNode = document.createTextNode(date);
	newCell.appendChild(textNode);	
	
	newCell = newRow.insertCell(2);
	textNode = document.createTextNode(subject);
	newCell.appendChild(textNode);	
	
	newCell = newRow.insertCell(3);
	textNode = document.createTextNode(course_type);
	newCell.appendChild(textNode);
	
	newCell = newRow.insertCell(4);
	textNode = document.createTextNode(teacher_name);
	newCell.appendChild(textNode);
	
	newCell = newRow.insertCell(5);
	textNode = document.createTextNode(course_activity);
	newCell.appendChild(textNode);
	
	newCell = newRow.insertCell(6);
	newCell.onclick= function(){modifyThisRow(this);};
	textNode = document.createTextNode('修改');	
	newCell.appendChild(textNode);

	newCell = newRow.insertCell(7);
	newCell.onclick= function(){deleteThisRow(this);};
	textNode = document.createTextNode('刪除');	
	newCell.appendChild(textNode);	
}

function updateSchedule(res){
	//將輸入的地方隱藏
	if(document.getElementById('newInputArea').style.display == "")
			document.getElementById('newInputArea').style.display = "none";
	//將原本的資料加到table中
	var tbody = document.getElementById('course_schedule').getElementsByTagName('tbody')[0]; 
	var rows = tbody.getElementsByTagName('tr'); 
	//insert在中間
	if(position <= rows.length){
		for(var i = position -1; i < rows.length; i++){		
			tbody.rows[i].getElementsByTagName('td')[0].firstChild.nodeValue = (i+2).toString(10) ;
		}		
	}else{  //append在最後
		//do nothing
	}
	tbody = addRow(tbody);
}
 
function submitInputArea(name){
	var inputAreaForm = document.getElementById(name);
	//取得各個欄位的值
	for(var i=0; i< inputAreaForm.elements.length; i++){
		switch(inputAreaForm.elements[i].type){
			case "select-one" :
				if(inputAreaForm.elements[i].name == "position"){
					position = inputAreaForm.elements[i].value;
				}else if(inputAreaForm.elements[i].name == "date"){
					date = inputAreaForm.elements[i].value;
				}else if(inputAreaForm.elements[i].name == "teach_teacher"){
					teach_teacher = inputAreaForm.elements[i].value;
					teacher_name = inputAreaForm.elements[i].options[inputAreaForm.elements[i].selectedIndex].text;
				}				
				break;
			case "text" :
				if(inputAreaForm.elements[i].name == "course_type"){
					course_type = inputAreaForm.elements[i].value;
				}
				break;				
			case "textarea" :
				if(inputAreaForm.elements[i].name == "subject"){
					subject = inputAreaForm.elements[i].value;
				}else if(inputAreaForm.elements[i].name == "course_activity"){
					course_activity = inputAreaForm.elements[i].value;
				}
				break;			
			default:break;
		}
	}
	if(position != 0){			
		//用AJAX送出
		var parms = 'target=insertSchedule&position='+position+'&course_schedule_day='+date+'&course_type='+course_type+'&teach_teacher='+teach_teacher+'&subject='+subject+'&course_activity='+course_activity;
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'post',
									  postBody: parms,
									  onComplete: updateSchedule
									 });
	}else{
		alert("請選擇插入點");	
	}	
}

function createModifyArea(){
	//拷貝一份 newInputArea
	var inputArea = document.getElementById('newInputArea');
	var cloneNode = inputArea.cloneNode(true);
	cloneNode.style.display = "";
	var newRow = document.createElement('tr');
	var newCell = document.createElement('td');
	newCell.setAttribute("colSpan",8);
	newCell.appendChild(cloneNode);
	newRow.appendChild(newCell);	
	return newRow;
}

function insertAfter(parent, node, referenceNode) {
    parent.insertBefore(node, referenceNode.nextSibling);
}

function modifyThisRow(obj){
	//取得 row
	var row = obj.parentNode;
	var tbody = row.parentNode;
	position = row.getElementsByTagName('td')[0].firstChild.nodeValue;
	//create input area
	var modifyArea = createModifyArea();
	//alert(modifyArea.innerHTML);
	insertAfter(tbody, modifyArea, row);
	//alert(tbody.innerHTML);
}

function updateDeleteSchedule(res){
	var tbody = document.getElementById('course_schedule').getElementsByTagName('tbody')[0]; 
	var rows = tbody.getElementsByTagName('tr');
	//刪除中間的
	var delPosition = position-1;
	if(position < rows.length){
		//刪掉的index 為 position	
		//將刪除掉的row 以下的row都shift 1	
		for(var i = position; i < rows.length; i++){
			tbody.rows[i].getElementsByTagName('td')[0].firstChild.nodeValue = (i).toString(10) ;
		}		
	}else{ //刪除最後面
		//do nothing
	}
	//刪除已經刪除的row
	tbody.removeChild(tbody.getElementsByTagName('tr')[delPosition]);		
}

function deleteThisRow(obj){
	//取得 row
	var row = obj.parentNode.parentNode;
	//alert(ode.innerHTML);
	position = row.getElementsByTagName('td')[0].firstChild.nodeValue;
	//alert(position); 	
	if(confirm("按下[確定]將會永久刪除此筆資料")){	
		//用AJAX送出
		var parms = 'target=delectSchedule&position='+position;
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'post',
									  postBody: parms,
									  onComplete: updateDeleteSchedule
									 });	
	}else{
		alert("放棄刪除");
	}
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
<center>編輯課程進度</center>
<!-- 內容說明 -->
<div>
<br />
確認開課：<br />
步驟一：填寫課程大綱 <font color="#FF0000">(已經完成)</font> <br />
步驟二：填寫課程進度 (課程進度可讓學生對於課程整體規劃有清楚的認知。) <br />
</div>
<br />
<!--功能部分 -->
<!-- 標題 -->
<table>
<tr>
	<td><center><font color="#FF0000">{$course_name}</font>的課程進度表</center></td>
</tr>
</table>

<div onclick="showDataInputArea('newInputArea');">新增一筆資料</div>
<div onclick="showUnitArea('unitArea');">修改計算單位</div>
<!-- 計算單位 -->
<div id="unitArea" style="display:none;">
<select name="unit" id="courseUnitSelect" onchange="changeCourseUnit(this);">
{html_options values=$unit_ids selected=$unit_id output=$unit_names}
</select>
</div>
<!-- 編輯區域 -->
<form id="newInputArea" style="display:none;" >
<table>
<tr>
	<td colspan="2">
	選擇插入點：
	<select name="position" id="positionSelect">
	{html_options values=$position_ids selected=$position_id output=$position_names}
	</select>
	</td>
</tr>
<tr>
	<td>
	日期：
	<select name="date">
	{html_options values=$date_ids selected=$date_id output=$date_names}
	</select>
	</td>
</tr>
<tr>
	<td>
	課程內容：<br />
	<textarea cols="50" rows="20" name="subject" ></textarea>
	</td>
	<td>
	上課方式： <input type="text" name="course_type" /> <br />
	授課教師： <select name="teach_teacher">{html_options values=$teach_teacher_ids selected=$teach_teacher_id output=$teach_teacher_names}</select> <br />
	教學活動： <br />
	<textarea cols="26" rows="15" name="course_activity" ></textarea>
	</td>
</tr>
<tr>
<!--<td><input type="button" value="清除內容" onclick=""></td>-->
<td><input type="button" value="確定送出" onclick="submitInputArea('newInputArea');"></td>
</tr>
</table>
</form>
<!--課程進度 -->
<table id="course_schedule" border="1">
<thead>
<tr>
	<td id="courseUnit">期數({$schedule_unit})</td>
	<td>日期</td>
	<td>內容</td>
	<td>上課方式</td>
	<td>授課教師</td>
	<td>教學活動</td>
	<td>修改</td>
	<td>刪除</td>	
</tr>
</thead>
<tbody>
{foreach from=$schedule_data item=schedule}
<tr>
	<td>{$schedule.schedule_index}</td>
	<td>{$schedule.course_schedule_day}</td>
	<td>{$schedule.subject}</td>
	<td>{$schedule.course_type}</td>
	<td>{$schedule.teacher_name}</td>
	<td>{$schedule.course_activity}</td>
	<td onclick="modifyThisRow(this);">修改</td>
	<td onclick="deleteThisRow(this);">刪除</td>	
</tr>
{/foreach}
</tbody>
</table>
<hr />
<div>
<font color="#0000FF">接填寫完畢。</font></font><br />
</div>
<input type="button" name="returnButton" value="返回個人首頁" onclick="returnPersonalPage();" />

</body>
</html>