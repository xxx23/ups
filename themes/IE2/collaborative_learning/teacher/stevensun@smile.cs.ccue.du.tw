<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分組資訊</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript" src="{$webroot}script/default.js"></script>
{literal}
<script type="text/javascript">
function add(group_no){
	id = "group_no_"+group_no;
	document.getElementById(id).value = group_no;
	id = "new_stu_"+group_no;
	document.getElementById(id).value = "true";
}
function del_student(group_no){
	if(confirm("確定刪除學生？")){
		id = "del_stu_"+group_no;
		document.getElementById(id).value = "true";
		//alert(document.getElementById(id).value);
		id = "group_no_"+group_no;
		document.getElementById(id).value = group_no;
		return true;
	}
	else
		return false;
}
function del_group(group_no){
	//alert("test");
	//alert(group_no);
	id = "group_no_"+group_no;
	//alert(id);
	if(confirm("確定刪除這個組別及所有成員？")){
		document.getElementById(id).value = group_no;
		return true;
	}
	else
		return false;
}
</script>
{/literal}
</head>
<body>
<h1>已分組組別名單</h1>
<p class="intro"> 每組預設為"允許"，按下"不允許"將會刪除此一組別。</br>欲刪除單一組員，請選擇check box並按"刪除所選"。
<br/>
欲新增單一組員，請按"新增組員"鈕。</p>

<h1>"{$homework_name}"作業 已分組名單</h1>
{foreach from = $group_list item = element name=contentloop}
<form name="form_{$element.group_no}" method="post" action="./tea_grouped_list.php">
<input type="hidden" name="homework_no" value="{$element.homework_no}" />
<fieldset>
<legend><span class="imp">第{$element.group_no}組, 組名：{$element.group_name}</span></legend>
<table class="datatable">
	<tr>
		<th width="8%"><input type="checkbox" onclick="clickAll('form_{$element.group_no}', this);"/>全選</th>
		<th width="20%">帳號</th>
		<th>姓名</th>
	</tr>	
	{foreach from = $element.stu_array item = student}
	<tr class="{cycle values=" ,tr2"}">
		<td><input type="checkbox" name="student[]" value="{$student.student_id}" /></td>
		<td>{$student.login_id}</td>
		<td>{$student.personal_name}</td>
		
	</tr>
	{/foreach}
	<tr><td colspan="3">
	<p class="al-left">
		<input type="hidden" name="del_stu_{$element.group_no}" id="del_stu_{$element.group_no}" value=""/>
		<input type="hidden" name="new_stu_{$element.group_no}" id="new_stu_{$element.group_no}" value="" />
		<input class="btn" type="submit" name="del" value="刪除所選學生" onclick="return del_student({$element.group_no});"/></p>
	</td></tr>
	
	<tr><th colspan="4">選擇的題目 <span class="imp">{$element.self_subject}</span></th></tr>
	<tr><td colspan="4">
	{if $element.project_content == ''}
		尚未選擇
	{else}
		{$element.project_content}
	{/if}
	</td></tr>	
	<tr colspan="5">
	  <th colspan="5">新增組員</th>
    </tr>
	 <tr id="input_id_1" colspan="5">
	  <td colspan="5">請輸入學生帳號：
	  <input type="text" class="btn" name="new_member" size="10" />
	  <input type="hidden" name="group_no" id="group_no_{$element.group_no}" value="" />
	  <input type="submit" name="add_member_{$element.group_no}" class="btn" size="10" value="確定新增" onclick="add({$element.group_no})" />
	  </td>
     </tr>
	<tr>
    <th colspan="5">
     </th>
  </tr>
</table>
</fieldset>
</form>
{foreachelse}
	目前沒有任何已分組學生。
{/foreach}

</html>
