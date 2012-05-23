<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="javascript">
<!--
{literal}
function showInput(name){

	var tmp =  "query_"+name;
	if($(tmp).style.display == "none")
		$(tmp).style.display = "";
	else
		$(tmp).style.display = "none";
}

function showInputAll(obj){
	var tmp = obj.value;	
}

function showProfile(name){
	var tmp = "course_"+name;
	if($(tmp).style.display =="")
		$(tmp).style.display = "none";
	else
		$(tmp).style.display = "";
}

function modifyProfile(name){
	var tmp = "modify_"+name;
	var len = document.getElementsByName(tmp).length;
	var all_data = document.getElementsByName(tmp);
	var	index;
	for(index=0; index<len; index++){
		if(all_data[index].disabled == true){
			all_data[index].disabled = false;		
		}
		else{
			all_data[index].disable = true;	
		}	
	}
	//alert(tmp+"_button");
	if($(tmp+"_button").style.display == "none")
		$(tmp+"_button").style.display = "";
	else
		$(tmp+"_button").style.display = "none";
}

function doCheckAll(string){
	var nodes = document.getElementsByName(string);
	//alert(nodes[1].innerHTML);
	//alert(nodes.length);
	if(nodes.item(0).checked){
		for(var i=0; i < nodes.length ; i++)
			nodes.item(i).checked = false;
	}else{
		for(var i=0; i < nodes.length ; i++)
			nodes.item(i).checked = true;	
	}
}

{/literal}
-->
</script>
<title>觀看開課情形</title>
</head>

<body>
課程查詢
<form method="get" action="show_all_begin_course_advance.php">
<table border="0">
<tr>
	<td><input type="checkbox" name="query" value="0" onclick="showInputAll(this);" checked>查詢所有開課</td>
</tr>
<tr>
	<td><input type="checkbox" name="query" value="1" onclick="showInput(this.value);">依開課名稱</td>
	<td id="query_1" style="display:none;">
		<input type="text" name="begin_course_name_input">(可用關鍵字查詢)
	</td>
</tr>
<tr>
	<td><input type="checkbox" name="query" value="2"onclick="showInput(this.value);">依開課單位</td>
	<td id="query_2" style="display:none;">
		<input type="text" name="unit_input">
	</td>
</tr>
<tr>
	<td><input type="checkbox" name="query" value="3" onclick="showInput(this.value);">依授課教師</td>
	<td id="query_3" style="display:none;" >
		<input type="text" name="teacher_input">
	</td>
</tr>
</table>
<input type="hidden" name="search" value="yes">
<input type="submit" value="查詢課程資訊">
</form>
<hr>
{if $show_search == 1}
<form>
<table border="1" >
	<tr>
		<td><input type="checkbox" name="checkAll" onClick="doCheckAll('check[]');" />全選</td>
		<td>課程編號</td><td>開課單位</td><td>開課名稱</td><td>授課教師</td>
		<td>教師在職進修登錄</td>
	</tr>
	{foreach from=$course_data item=course}
	<tr>
		<td><input type="checkbox" name="check[]" /></td>
		<td>{$course.inner_course_cd}</td><td>{$course.unit_name}</td><td>{$course.begin_course_name}</td>
		<td>{$course.personal_name}</td>
		<td><a href="./view_advance_course.php?begin_course_cd={$course.begin_course_cd}" >登錄</a></td>
	</tr>	
	{/foreach}
</table>
<input type="submit" value="匯出Excel" />
</form>
{/if}
</body>
</html>
