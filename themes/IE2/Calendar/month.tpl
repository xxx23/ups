<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/calendar.css" rel="stylesheet" type="text/css" />
<link href="../css/calendar.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/personal/calendar_full.css" rel="stylesheet" type="text/css">
<link href="../css/personal/calendar_full.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$tpl_path}/script/drag.js"></script>

<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="javascript">
{literal}
<!--
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

function init(){
  obj_b=event.srcElement.parentNode;     //事件觸發對象
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
//    if(obj_b.style != null){
		with(obj_b.style){
			/*設置對象的X坐標值為文檔在X軸方向上的滾動距離加上當前鼠標指針相當於文檔對象的X坐標值減鼠標按下時指針位置相對於觸發事件的對象的X坐標*/
			posLeft = document.body.scrollLeft+event.x-x;
			/*設置對象的Y坐標值為文檔在Y軸方向上的滾動距離加上當前鼠標指針相當於文檔對象的Y坐標值減鼠標按下時指針位置相對於觸發事件的對象的Y坐標*/
			posTop = document.body.scrollTop+event.y-y;
		}
//	}
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

{/literal}
-->
</script>
<title>{$personal_name}的行事曆</title>
</head>

<body onmousemove="moveit();" onmouseup="stopdrag();">
<h1>行事曆</h1>
<p class="intro">
說明：<br />
按<span class="imp">日期上的數字</span>可以<strong>新增筆記</strong>。 <br />
按<span class="imp">筆記的部分</span>可以<strong>修改該筆記</strong>。 <br />
把<span class="imp">筆記的部分清空</span>可以<strong>刪除</strong>該筆記。 <br />
</p>
<!-- 顯示下方 -->
<table class="clmonth">
<caption>
<a href="./month.php?action=sub&target=month&valueY={$year}&valueM={$month}"> &lt; </a> {$month} 月 <a href="./month.php?action=add&target=month&valueY={$year}&valueM={$month}"> &gt; </a> 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <a href="./month.php?action=sub&target=year&valueY={$year}&valueM={$month}"> &lt; </a> {$year} 年 <a href="./month.php?action=add&target=year&valueY={$year}&valueM={$month}"> &gt; </a>  
</caption>	
<tr>
	<th scope="col" class="sun" >星期日</th>
	<th scope="col" >星期一</th>
	<th scope="col" >星期二</th>
	<th scope="col" >星期三</th>
	<th scope="col" >星期四</th>
	<th scope="col" >星期五</th>
	<th scope="col" class="sat" >星期六</th>
</tr>	
{foreach from=$week item=weeks}	
<tr>
	{$weeks.0}{$weeks.1}{$weeks.2}{$weeks.3}{$weeks.4}{$weeks.5}{$weeks.6}				
</tr>
{/foreach}
</table>

<p>
  <select name="mode" onChange="changeMode(this);" >
	<option value="month" selected>月瀏覽</option>
	<option value="week">週瀏覽</option>
</select>
<input class="btn" type="button" value="今天" /></p>
<form method="get" name="selectForm" action="./month.php">
<p>前往
<select name="sel_year">{$sel_year}</select>
<select name="sel_month">{$sel_month}</select>
<select name="sel_day">{$sel_day}</select>
<input class="btn" type="submit" name="submitButton" value="Go!" />	</p>					
</form>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<!--修改模式 -->
<div id="note_edit" style="display:none;position:absolute;width:30%;height:10%; background-color:#FFFFFF; z-index:100;">
	<div style="cursor:move;width:100%;height:100%; text-align:center; border:1px solid #CCCCCC;"  onmousedown="init();"  >{$personal_name}的行事曆</div>
	<table class="datatable">
	  <tr class="tr2">
	  <td>日期</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">筆記 (修改)</td>
	  </tr>
	  <tr>
		<td colspan="2"><textarea id="note_area" cols="30" rows="10"></textarea></td>
	  </tr>
	  <tr>
	  	<td colspan="2">
		行事曆
		<select name='notify' id='note_notify'>
		<option value="0" selected>當天</option>
		<option value="1">一天前</option>
		<option value="2">二天前</option>
		<option value="3">三天前</option>
		<option value="4">四天前</option>
		<option value="5">五天前</option>
		<option value="6">六天前</option>
		<option value="7">一星期前</option>
		<option value="14">二星期前</option>
		<option value="21">三星期前</option>
		<option value="28">四星期前</option>				
		</select>		
		提醒我		
		<select name='notify_num' id='note_notify_num'>
		<option value="2" selected>二</option>
		<option value="4">四</option>
		<option value="6">六</option>
		<option value="8">八</option>
		<option value="10">十</option>
		<option value="12">十二</option>
		</select>
		次		</td>
	  </tr>
	  <tr>
	  	<td colspan="2">
			<div class="buttons">
              <input name="button" type="submit" class="btn" value="放棄編輯" onClick="cancelEdit('note_edit');" />
			  <input name="button" type="submit" class="btn" value="確定送出" onClick="modifyNote('note_edit');" />
			</div>		</td>
	  </tr>
	</table>
</div>
<!-- edit note-->
<div id="new_note_edit" style="display:none;position:absolute;width:30%;height:10%; background-color:#FFFFFF;">
	<div style="cursor:move;width:100%;height:100%; border: 1px solid #CCCCCC;"  onmousedown="init();"  >{$personal_name}的行事曆</div>
	<table class="datatable">
	  <tr class="tr2">
		<td>日期</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">筆記 (新增)</td>
	  </tr>
	  <tr>
		<td colspan="2"><textarea id="new_note_area" cols="30" rows="10"></textarea></td>
	  </tr>
	  <tr>
	  	<td colspan="2">
		行事曆
		<select name='new_notify' id='new_note_notify'>
		<option value="0" selected>當天</option>
		<option value="1">一天前</option>
		<option value="2">二天前</option>
		<option value="3">三天前</option>
		<option value="4">四天前</option>
		<option value="5">五天前</option>
		<option value="6">六天前</option>
		<option value="7">一星期前</option>
		<option value="14">二星期前</option>
		<option value="21">三星期前</option>
		<option value="28">四星期前</option>				
		</select>		
		提醒我		
		<select name='new_notify_num' id='new_note_notify_num'>
		<option value="2" selected>二</option>
		<option value="4">四</option>
		<option value="6">六</option>
		<option value="8">八</option>
		<option value="10">十</option>
		<option value="12">十二</option>
		</select>
		次
		</td>
	  </tr>
	  <tr>
	  	<td colspan="2">
			<div class="buttons">
              <input name="button" type="submit" class="btn" value="放棄編輯" onClick="cancelEdit('new_note_edit');" />
			  <input name="button" type="submit" class="btn" value="確定送出" onClick="doNote('new_note_edit');" />
			</div>			
		</td>
	  </tr>
	</table>
</div>

</body>
</html>
