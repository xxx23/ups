var serverAddress = 'note.php';
var cur_id;
var cur_name;
var edit_flag = false;
var cur_node;
var tmp_htm;
var this_year, this_month, this_day;
function changeMode(selObj){
	var sel = selObj.options[selObj.selectedIndex];
	switch(sel.value){
		case 'week':
			location.href="./week.php";
			break;
		case 'month':
			location.href="./month.php";
			break;
		default:
			alert("error");
			break;
	}
	//alert(this.selectedIndex);
}

function PXtoInt(str){
  return parseInt(str.substr(0, str.length - 2))
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
function hideNewNote(res){
	//更新	內容
	var response = res.responseText;
	//var tmp_text = response;	
	var ul = cur_node.parentNode.getElementsByTagName('ul');
	if(ul.length != 0){
		for(var i=0; i < ul.length ; i++){
			ul[i].parentNode.removeChild( ul[i] );
		}
		var t_u = document.createElement('ul');
		t_u.innerHTML = response;
		cur_node.parentNode.appendChild( t_u );
				
	}else{
		cur_node.parentNode.setAttribute("className","active");	
		var t_u = document.createElement('ul');
		t_u.innerHTML = response;
		cur_node.parentNode.appendChild( t_u );		
	}	
	//隱藏
	edit_flag = false; 
	document.getElementById('new_note_edit').style.display = "none";
	//document.getElementById('note_area').value = " ";	
}
function hideModifyNote(res){
	//更新	內容
	var response = res.responseText;
	//alert(response);	
	cur_node.parentNode.innerHTML =  response;
	if(response.innerHTML == "")
		cur_node.parentNode.setAttribute("className","");		
	//隱藏 
	edit_flag = false;
	document.getElementById('note_edit').style.display = "none";
	//document.getElementById('new_note_area').value = null;	
}

function doNote( name /*, year, month, day */){
	//將 note紀錄
	//cur_id = "div-"+name;	
	//將資料撈出
	var editNode = document.getElementById(name).value;
	var content  = document.getElementById('new_note_area').value;
	var year  = this_year;
	var month = this_month;
	var day   = this_day;
	var notify  = document.getElementById('new_note_notify').value;
	var notify_num  = document.getElementById('new_note_notify_num').value;
	var parms = 'target=note&content='+content+'&year='+year+'&month='+month+'&day='+day+'&notify='+notify+'&notify_num='+notify_num;//encodeURIComponent(content);
	//tmp_htm = "<li></li>";
	
	var ajaxQ = new Ajax.Request(serverAddress,
								 {method:'post',
								  postBody: parms,
								  onComplete: hideNewNote
								 });			
}

function modifyNote( name /*, year, month, day */){
	//將 note紀錄
	//cur_id = "div-"+name;	
	//將資料撈出
	var editNode = document.getElementById(name).value;
	var content  = document.getElementById('note_area').value;
	var year  = this_year;
	var month = this_month;
	var day   = this_day;
	var notify  = document.getElementById('note_notify').value;
	var notify_num  = document.getElementById('note_notify_num').value;
	var parms = 'target=modifynote&id='+cur_id+'&content='+content+'&year='+year+'&month='+month+'&day='+day+'&notify='+notify+'&notify_num='+notify_num;//encodeURIComponent(content);
	var ajaxQ = new Ajax.Request(serverAddress,
								 {method:'post',
								  postBody: parms,
								  onComplete: hideModifyNote
								 });			
}

function showModifyNote(obj, year, month, day, id){	
	//先判斷是否已經有開啟的 note edit
	var NoteEdit = document.getElementById('note_edit');

	if(edit_flag == true){
		if(confirm("你目前還有一個編輯中的視窗，如果你要再開啟，將會放棄上一個編輯中的視窗，要放棄嗎？")){
			//NoteEdit.style.display ="none";
			document.getElementById('note_edit').style.display = "none";
			document.getElementById('new_note_edit').style.display = "none";			
		}
		else{
			alert("放棄新增。");
			return ;
		}		
	}
	cur_node = obj;
	//else{				
		//insert data	
		edit_flag = true;
		cur_id = id;					
		var DateTd = NoteEdit.getElementsByTagName('tr')[0].getElementsByTagName('td')[1];
		DateTd.firstChild.nodeValue = " 西元  "+year+"年  "+month+"月  "+day+"日";		
		this_year 	= year;
		this_month	= month;
		this_day	= day;
		//將該型事曆的內容讀出
		var $content = document.getElementById(id).firstChild.nodeValue;
		document.getElementById('note_area').value = $content;		
		//display
		NoteEdit.style.left = getLeft(obj);	
		NoteEdit.style.top  = getTop(obj) + 25;//PXtoInt(obj.style.height); 
		NoteEdit.style.display = "";
	
}

function setNote(obj, year, month, day, id){	
	//先判斷是否已經有開啟的 note edit
	var NoteEdit = document.getElementById('new_note_edit');

	if(edit_flag == true){
		if(confirm("你目前還有一個編輯中的視窗，如果你要再開啟，將會放棄上一個編輯中的視窗，要放棄嗎？")){
			//NoteEdit.style.display ="none";
			document.getElementById('note_edit').style.display = "none";
			document.getElementById('new_note_edit').style.display = "none";			
		}
		else{
			alert("放棄新增。");
			return ;
		}		
	}
	cur_node = obj;	
	//else{				
		//insert data	
		edit_flag = true;							
		var DateTd = NoteEdit.getElementsByTagName('tr')[0].getElementsByTagName('td')[1];
		DateTd.firstChild.nodeValue = " 西元  "+year+"年  "+month+"月  "+day+"日";		
		this_year 	= year;
		this_month	= month;
		this_day	= day;
		document.getElementById('new_note_area').value = '';
		//將該型事曆的內容讀出
//		var $content = document.getElementById(id).firstChild.nodeValue;
		//document.getElementById('new_note_area').value = $content;
		
		//display
		NoteEdit.style.left = getLeft(obj);	
		NoteEdit.style.top  = getTop(obj) + 25;//PXtoInt(obj.style.height); 
		NoteEdit.style.display = "";

}

function setFocus(obj){
	obj.style.backgroundColor = "#FFFFBF";
}

function unsetFocus(obj){
	obj.style.backgroundColor = "";
}

var x, y, z, down=false, obj_b;

function init(e){
	obj_b=Event.element(e).parentNode;     //事件觸發對象
	window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
	//obj_b.setCapture();            設置屬於當前對象的鼠標捕捉
	z = obj_b.style.zIndex;          //獲取對象的z軸坐標值
	//設置對象的z軸坐標值為100，確保當前層顯示在最前面
	obj_b.style.zIndex=100;
	x = e.clientX - parseInt(obj_b.style.left);
	y = e.clientY - parseInt(obj_b.style.top);
	down=true;         //布爾值，判斷鼠標是否已按下，true為按下，false為未按下
}

function moveit(e){
	//判斷鼠標已被按下且onmouseover和onmousedown事件發生在同一對象上
	if(down){
		with(obj_b.style){
			left = e.clientX - x + 'px';
			top = e.clientY - y + 'px';
			$("aaa").innerHTML = left + " " + top;
		}
	}
}

function stopdrag(){
	//onmouseup事件觸發時說明鼠標已經鬆開，所以設置down變量值為false
	if(down){
		down=false; 
		obj_b.style.zIndex=z;       //還原對象的Z軸坐標值
		window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
	}
} 

function cancelEdit(name){
	if(confirm("你之前的編輯，將不會存入，你確定嗎？")){
		document.getElementById('note_edit').style.display = "none";
		document.getElementById('new_note_edit').style.display = "none";
		edit_flag = false;
	}
}
function showMessage(obj, id){
	document.getElementById(id).style.display = "";
}

function hideMessage(obj, id){
	document.getElementById(id).style.display = "none";
}
