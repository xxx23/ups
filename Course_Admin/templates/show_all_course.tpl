<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <script src="../script/prototype.js" type="text/javascript"></script>
<script>
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
{/literal}
-->
</script>
<title>瀏覽課程</title>
</head>

<body>

<center>
<form method="get" action="show_all_course.php">
<table border="1">
<tr>
	<td><input type="checkbox" name="query" value="0" onclick="showInputAll(this);" checked>列出全部課程</td>
</tr>
<div id="show_all">
<tr>
	<td><input type="checkbox" name="query" value="1" onclick="showInput(this.value);">課程科目名稱</td>
	<td>
	<div id="query_1" style="display:none;">
		<input type="text" name="name_input">
	</div>
	</td>
</tr>
<tr>
	<td><input type="checkbox" name="query" value="2"onclick="showInput(this.value);">課程科目編號</td>
	<td>
	<div id="query_2" style="display:none;">
		<input type="text" name="cd_input">
	</div>
	<td>
</tr>
<tr>
	<td><input type="checkbox" name="query" value="3" onclick="showInput(this.value);">課程科目層級</td>
	<td>
	<div id="query_3" style="display:none;" >
		<input type="text" name="parent_input">
	</div>
	</td>
</tr>
</div>
</table>
<input type="hidden" name="search" value="yes">
<input type="submit" value="送出查詢">
</form>
<hr>
<if {$show_search} == 1>
<table width="717" border=1>
	<tr>
		<td>課程科目名稱</td><td>課程科目編號</td><td>課程科目層級</td>
		<td>授課教師</td>
		<td>
			<table>
				<tr><td>修改</td><tr>
				<tr><td>刪除</td><tr>
			</table>
		</td>
		<td>詳細資訊...</td>
	</tr>
	{foreach from=$course_data item=course}
	<tr>
		<td>{$course.course_name}</td><td>{$course.course_classify_cd}</td><td>{$course.course_classify_parent}</td>
		<td>{$course.course_teacher}</td>
		<td>
			<table>
				<tr>
					<td name="" ><input type="button" name="profile_{$course.num}" value="修改" onClick="modifyProfile(this.name);"></td>
				</tr>
				<tr>
					<td><input type="button" name="delete" value="刪除"></td>
				</tr>
			</table>
		</td>
		<td name="profile_{$course.num}" onClick="showProfile(this.name);" >詳細資訊...</td>
	</tr>	
	<tr id="course_profile_{$course.num}" style="display:none;">
		<td colspan="6">
			<table>
			<form>
				<tr><td>課程科目名稱：</td><td ><input type="text" name="modify_profile_{$course.num}" value="{$course.course_name}" disabled ></td></tr>
				<tr><td>課程科目編號：</td><td ><input type="text" name="modify_profile_{$course.num}" value="{$course.course_classify_cd}" disabled ></td></tr>
				<tr><td>課程科目層級：</td><td ><input type="text" name="modify_profile_{$course.num}" value="{$course.course_classify_parent}" disabled ></td></tr>
				<tr><td>課程科目收費標準：</td><td ><input type="text" name="modify_profile_{$course.num}" value="{$course.charge}" disabled ></td></tr>
				<tr><td>是否需核准選課：</td><td ><input type="text" name="modify_profile_{$course.num}" value="{$course.charge}" disabled ></td></tr>
				<tr><td>教材作業是否公開：</td><td><input type="text"  name="modify_profile_{$course.num}" value="{$course.charge}" disabled ></td></tr>
				<tr><td>課程科目時程單位(月份、週、天、次、時)：</td><td><input type="text"  name="modify_profile_{$course.num}" value="{$course.charge}" disabled ></td></tr>
				<tr id="modify_profile_{$course.num}_button"  style="display:none;">
					<td colspan="2">
						<input type="submit" name="modify_profile" value="確定修改"/>
					</td>
				</tr>
			</form>	
			</table>
		</td>
	</tr>	
	{/foreach}
</table>
</if>
</center>

</body>
</html>
