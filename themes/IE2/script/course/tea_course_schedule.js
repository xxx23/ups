window.onload = onload_init;
var tpl_path;

function onload_init(){
	with($("information")){
		style.display = "none";
		tpl_path = firstChild.nodeValue.split(":")[1];
	}
}

var serverAddress = 'update_course_schedule.php';
var position, date, teach_teacher, course_type, subject, course_activity, teacher_name;
var courseUnit;
var trClass = 'tr2';
function updatePosition(res){
	var responseXML = res.responseXML;
	var xmlDoc = responseXML.documentElement;
	var allOption = xmlDoc.getElementsByTagName('option');
	//清除原本的
	var orignialNode = $('positionSelect');
	while(orignialNode.firstChild) orignialNode.removeChild(orignialNode.firstChild);
	//更新原本的select
	var tmpNode;
	for(var i=0; i < allOption.length ; i++){
		tmpNode = document.createElement('option');
		tmpNode.setAttribute("value", i);
		if(i == allOption.length-1) tmpNode.setAttribute("selected", true);
		tmpNode.appendChild(document.createTextNode(allOption[i].firstChild.nodeValue));
		orignialNode.appendChild(tmpNode);
	}
	//顯示輸入的地方
	
	var node = $("newInputArea"); //.style.display = "";
	var tmp = $("new_button");
	node.style.left = getLeft(tmp)+10;
	node.style.top = getTop(tmp)+40;
	node.style.display = "";
}

function showDataInputArea(name){
	//如果目前已經出現 轉為隱藏
	var node = $(name);
	if(node.style.display == ""){
		node.style.display = "none";		
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
	var node = $(name) ;
	if(node.style.display == "")
		node.style.display = "none";
	else
		node.style.display = "";	
}

function updateCourseUnit(res){
	//更新
	var node = $('courseUnit');
	node.firstChild.nodeValue = "期數(" + courseUnit + ")";
	//隱藏選擇courseUnit的地方
	$('unitArea').style.display="none";
}

function changeCourseUnit(obj){
	var selectedOption = obj.options[obj.selectedIndex];
	//用AJAX更新的位置
	courseUnit = selectedOption.value;
	//show hint
	
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
	var buttonNode = document.createElement('div');
	buttonNode.onclick = function(){modifyThisRow(this);};	
	buttonNode.appendChild(create_img("edit.gif"));
	buttonNode.style.cursor = "pointer";
	newCell.appendChild(buttonNode);

	newCell = newRow.insertCell(7);
	var buttonNode = document.createElement('div');
	buttonNode.onclick = function(){deleteThisRow(this);};
	buttonNode.appendChild(create_img("delete.gif"));
	buttonNode.style.cursor = "pointer";
	newCell.appendChild(buttonNode);
	return 	tbody;
}

function create_img(src){
	var tmp = document.createElement("img");
	tmp.src = tpl_path + "/images/icon/" + src;
	return tmp;
}

function updateSchedule(res){
	//將輸入的地方隱藏
	if($('newInputArea').style.display == "")
			$('newInputArea').style.display = "none";
	//將原本的資料加到table中
	var tbody = $('course_schedule').getElementsByTagName('tbody')[0]; 
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
	rows = tbody.getElementsByTagName('tr');
	for(i=0; i < rows.length; i++ ){
		if(i % 2 == 0)
			rows[i].setAttribute("className","tr2");
		else
			rows[i].setAttribute("className","");		
	}
}
 
 
function submitInputArea(name){
	var inputAreaForm = $(name).getElementsByTagName('form')[0];
	//取得各個欄位的值
	for(var i=0; i< inputAreaForm.elements.length; i++){
		switch(inputAreaForm.elements[i].type){
			case "select-one" :
				if(inputAreaForm.elements[i].name == "position"){
					position = inputAreaForm.elements[i].value;
				}else if(inputAreaForm.elements[i].name == "teach_teacher"){
					teach_teacher = inputAreaForm.elements[i].value;
					teacher_name = inputAreaForm.elements[i].options[inputAreaForm.elements[i].selectedIndex].text;
				}				
				break;
			case "text" :
				if(inputAreaForm.elements[i].name == "course_type"){
					course_type = inputAreaForm.elements[i].value;
				}
				else if(inputAreaForm.elements[i].name == "e_date"){
					date = inputAreaForm.elements[i].value;
				}
				break;				
			case "textarea" :
				if(inputAreaForm.elements[i].name == "textarea"){
					subject = inputAreaForm.elements[i].value;
				}else if(inputAreaForm.elements[i].name == "course_activity"){
					course_activity = inputAreaForm.elements[i].value;
				}
				break;			
			default:break;
		}
	}
	inputAreaForm.reset();
	if(position != 0 & date != ''){			
		//用AJAX送出
		var parms = 'target=insertSchedule&position='+position+'&course_schedule_day='+date+'&course_type='+course_type+'&teach_teacher='+teach_teacher+'&subject='+subject+'&course_activity='+course_activity;
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'post',
									  postBody: parms,
									  onComplete: updateSchedule
									 });
	}else if(position == 0){
		alert("請選擇插入點");	
	}else if(date == ''){
		alert("請選擇時間");	
	}
}

function createModifyArea(){
	//拷貝一份 newInputArea
	var inputArea = $('newInputArea');
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



function modify(id){
	//將值取出
	//取得各個欄位的值
	var inputAreaForm = $('modifyInputArea').getElementsByTagName('form')[0];	
	for(var i=0; i< inputAreaForm.elements.length; i++){
		switch(inputAreaForm.elements[i].type){
			case "select-one" :
				if(inputAreaForm.elements[i].name == "position"){
					position = inputAreaForm.elements[i].value;
				}else if(inputAreaForm.elements[i].name == "teach_teacher"){
					teach_teacher = inputAreaForm.elements[i].value;
					teacher_name = inputAreaForm.elements[i].options[inputAreaForm.elements[i].selectedIndex].text;
				}				
				break;
			case "text" :
				if(inputAreaForm.elements[i].name == "course_type"){
					course_type = inputAreaForm.elements[i].value;
				}
				else if(inputAreaForm.elements[i].name == "position"){
					position = inputAreaForm.elements[i].value;
				}
				else if(inputAreaForm.elements[i].name == "m_date"){
					date = inputAreaForm.elements[i].value;
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

	//用AJAX送出
	var parms = 'target=modifySchedule&position='+position+'&course_schedule_day='+date+'&course_type='+course_type+'&teach_teacher='+teach_teacher+'&subject='+subject+'&course_activity='+course_activity;
	var ajaxQ = new Ajax.Request(serverAddress,
		{
			method:'post',
			postBody: parms,
			onComplete: updateSchedule2
		});
}

var modify_tmp_obj ;
function updateSchedule2(res){

	var obj = modify_tmp_obj;
	var row = obj.parentNode;
	var tbody = row.parentNode;
	var tmp = tbody.getElementsByTagName('td');

	tmp[1].innerHTML = date;
	tmp[3].innerHTML = course_type;
	tmp[2].innerHTML = subject;
	tmp[4].innerHTML = teacher_name;
	tmp[5].innerHTML = course_activity;
	$('modifyInputArea').style.display = "none";
}


function modifyThisRow(obj){


	//取得 row
modify_tmp_obj = obj;
	var row = obj.parentNode;
	var tbody = row.parentNode;
	var tmp = tbody.getElementsByTagName('td');
	var position = tmp[0].innerHTML;
	var date = tmp[1].innerHTML;
	var course_type = tmp[3].innerHTML;
	var subject = tmp[2].innerHTML;
	var teach_teacher = tmp[4].innerHTML;
	teacher_name = tmp[4].innerHTML;
	var course_activity = tmp[5].innerHTML;
	//將直塞入
	var inputAreaForm = $('modifyInputArea').getElementsByTagName('form')[0];
	//show
	//取得各個欄位的值
	for(var i=0; i< inputAreaForm.elements.length; i++){
		switch(inputAreaForm.elements[i].type){
			case "select-one" :
				if(inputAreaForm.elements[i].name == "position"){
					inputAreaForm.elements[i].value = position;
				}else if(inputAreaForm.elements[i].name == "teach_teacher"){
					//teach_teacher = inputAreaForm.elements[i].value;
					//teacher_name = inputAreaForm.elements[i].options[inputAreaForm.elements[i].selectedIndex].text;
				}				
				break;
			case "text" :
				if(inputAreaForm.elements[i].name == "course_type"){
					inputAreaForm.elements[i].value = course_type;
				}else if(inputAreaForm.elements[i].name == "position"){
					inputAreaForm.elements[i].value = position;
				}
				else if(inputAreaForm.elements[i].name == "m_date"){
					inputAreaForm.elements[i].value = date;
				}					
				break;				
			case "textarea" :
				if(inputAreaForm.elements[i].name == "subject"){
					inputAreaForm.elements[i].value = subject;
				}else if(inputAreaForm.elements[i].name == "course_activity"){
					inputAreaForm.elements[i].value = course_activity;
				}
				break;			
			default:break;
		}
	}	
	
	//顯示輸入的地方
	
	var node = $("modifyInputArea"); //.style.display = "";
	var tmp = $("new_button");
	node.style.left = getLeft(tmp)+10;
	node.style.top = getTop(tmp)+40;
	node.style.display = "";	
	
}

function updateDeleteSchedule(res){
	var tbody = $('course_schedule').getElementsByTagName('tbody')[0]; 
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
	rows = tbody.getElementsByTagName('tr');
	for(i=0; i < rows.length; i++ ){
		if(i % 2 == 0)
			rows[i].setAttribute("className","tr2");
		else
			rows[i].setAttribute("className","");		
	}			
}

function deleteThisRow(obj){
	//取得 row
	var row = obj.parentNode.parentNode;
	position = row.getElementsByTagName('td')[0].firstChild.nodeValue;
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

function PXtoInt(str){
  return parseInt(str.substr(0, str.length - 2));
}

function getLeft(obj){
  var x = 0;
  do{
    x += obj.offsetLeft;
    obj = obj.offsetParent;
  }while(obj);
  return x;
}

function getTop(obj){
  var y = 0;
  do{
    y += obj.offsetTop;
    obj = obj.offsetParent;
  }while(obj);
  return y;
}

var x, y, z, down=false, obj_b;

function init(){
  obj_b=event.srcElement.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;     //事件觸發對象
    obj_b.setCapture();            //設置屬於當前對象的鼠標捕捉
    z = obj_b.style.zIndex;          //獲取對象的z軸坐標值
    //設置對象的z軸坐標值為100，確保當前層顯示在最前面
    obj_b.style.zIndex=100;
    x=event.offsetX;   //獲取鼠標指針位置相對於觸發事件的對象的X坐標
    y=event.offsetY;   //獲取鼠標指針位置相對於觸發事件的對象的Y坐標
    down=true;         //布爾值，判斷鼠標是否已按下，true為按下，false為未按下
}

function moveit(){
  //判斷鼠標已被按下且onmouseover和onmousedown事件發生在同一對象上
  if(down){
	with(obj_b.style){
		/*設置對象的X坐標值為文檔在X軸方向上的滾動距離加上當前鼠標指針相當於文檔對象的X坐標值減鼠標按下時指針位置相對於觸發事件的對象的X坐標*/
		posLeft = document.body.scrollLeft+event.x-x;
		/*設置對象的Y坐標值為文檔在Y軸方向上的滾動距離加上當前鼠標指針相當於文檔對象的Y坐標值減鼠標按下時指針位置相對於觸發事件的對象的Y坐標*/
		posTop = document.body.scrollTop+event.y-y;
	}
  }
}

function stopdrag(){
  //onmouseup事件觸發時說明鼠標已經鬆開，所以設置down變量值為false
  if(down){
    down=false; 
    obj_b.style.zIndex=z;       //還原對象的Z軸坐標值
    obj_b.releaseCapture(); //釋放當前對象的鼠標捕捉
  }
}

function cancelEdit(name){
	if(confirm("你將放棄你目前所編輯的？")){
		$(name).style.display = "none";
	}
}
