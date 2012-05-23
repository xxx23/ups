<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{literal}
<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="javascript">
<!--
var serverAddress = 'note.php';
var cur_id;
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
function delDiv(){
	var tmp = document.getElementById(cur_id);
	var par = tmp.parentNode;
	par.removeChild(tmp);
	//更新
	
}

function note(name, year, month, day){
	//將 note紀錄
	cur_id = "div-"+name;
	var content = document.getElementById(name).value;		
	var parms = 'target=note&content='+content+'&year='+year+'&month='+month+'&day='+day;//encodeURIComponent(content);
	var ajaxQ = new Ajax.Request(serverAddress,
								 {method:'post',
								  postBody: parms,
								  onComplete: delDiv
								 });			
}

function setNote(obj, year, month, day){
	//開啟div 在下方
	var node = document.createElement('div');
	document.getElementsByTagName('body')[0].appendChild(node);
	node.setAttribute('id', "div-"+year+"-"+month+"-"+day);	
	var inputNode = document.createElement('input');
	inputNode.setAttribute('type','text');
	inputNode.setAttribute('id',year+"-"+month+"-"+day);
	var buttonNode = document.createElement('input');
	buttonNode.setAttribute('type','button');
	buttonNode.setAttribute('value','紀錄');
	buttonNode.onclick = function(){ note(year+"-"+month+"-"+day, year, month, day); };
	node.appendChild(inputNode);
	node.appendChild(buttonNode);
	node.style.position = "absolute";
	node.backgroundColor= "#FFFF99";
	node.style.left = getLeft(obj);
	node.style.top = getTop(obj) + 25;  //very sad
	node.style.display = "";
}
-->
</script>
{/literal}
<title>{$personal_name}的行事曆</title>
</head>

<body>

<!--  顯示上方 -->
<table>
<tr>
	<td><a href="./month.php?action=sub&target=year&valueY={$year}&valueM={$month}"> < </a></td>
	<td colspan="3">{$year}年</td>
	<td><a href="./month.php?action=add&target=year&valueY={$year}&valueM={$month}"> > </a></td>
	<td><a href="./month.php?action=sub&target=month&valueY={$year}&valueM={$month}"> < </a></td>
	<td colspan="3"> {$month}月 </td>
	<td><a href="./month.php?action=add&target=month&valueY={$year}&valueM={$month}"> > </a></td>				
	<td>
	<select name="mode" onChange="changeMode(this);">
		<option value="month" selected>月瀏覽</option>
		<option value="week">週瀏覽</option>
	</select>
	</td>
</tr>
</table>
<!-- 顯示下方 -->
<table width="100%" height="80%" bordercolor="#BFCFFF" border="1">
<tr bgcolor="#BFCFFF" height="5%">
	<td width="15%"><font color="#FF0000">星期日</font></td>
	<td width="14%"><font color="#FFFFFF">星期一</font></td>
	<td width="14%"><font color="#FFFFFF">星期二</font></td>
	<td width="14%"><font color="#FFFFFF">星期三</font></td>
	<td width="14%"><font color="#FFFFFF">星期四</font></td>
	<td width="14%"><font color="#FFFFFF">星期五</font></td>
	<td width="15%"><font color="#00FF00">星期六</font></td>
</tr>	
{foreach from=$week item=weeks}	
<tr height="20%">
{$weeks.0}{$weeks.1}{$weeks.2}{$weeks.3}{$weeks.4}{$weeks.5}{$weeks.6}				
</tr>
{/foreach}
</table>

<form method="get" name="selectForm" action="./month.php">
移至
<select name="sel_year">

</select>
<select name="sel_year">

</select>
<select name="sel_day">

</select>
<input type="submit" name="submitButton" value="Go!" />						
</form>

</body>
</html>
