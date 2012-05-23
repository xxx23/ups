<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增合作學習project題目內容</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$webroot}script/tiny_mce/usable_proprities.js"></script>
<script type="text/javascript">
	function choose(option,project_no){
		id_text = "group_num_"+project_no;
		if(option == 1)
			document.getElementById(id_text).disabled = "disabled";
		else
			document.getElementById(id_text).disabled = "";
	}
	function deleteProject(no){
		//alert(proj_no);
		del_str = "delete_"+no;
		//document.getElementById("project_no").value = no;
		//alert(document.getElementById("Project_no").value );
		document.getElementById(del_str).value = "true";
		//alert(document.getElementById("delete").value);
		if(confirm("確定刪除這個專案題目？"))
			return true;
		else
			return false;
	}
	function ratio_init(num,project_no){
		id_ratio = "group_num_free_id_"+project_no;
		id_text = "group_num_type_id_"+project_no;
		id_ratio_text = "group_num_"+project_no;
		//id_free = "free_"+project_no;
		if(num == 0){
			document.getElementById(id_ratio).checked = "checked";
			document.getElementById(id_text).checked = "";
			document.getElementById(id_ratio_text).disabled = "disabled";
			//document.getElementById().disabled = "disabled";
		}
		else{
			document.getElementById(id_ratio).checked = "";
			document.getElementById(id_text).checked = "checked";
			document.getElementById(id_ratio_text).disabled = "";
		}
	}
	function assign_proj_no(proj_no){
		//alert(proj_no);
		id = "Project_no_"+proj_no;
		document.getElementById(id).value = proj_no;
		//alert(document.getElementById("Project_no").value);
	}
	function spread(num){
		id = "content_"+num;
		btn_id = "spread_btn_"+num;
		document.getElementById(id).style.display = "";
		document.getElementById(btn_id).style.display = "none";
	}
	function shrink(num){
		id = "content_"+num;
		btn_id = "spread_btn_"+num;
		document.getElementById(id).style.display = "none";
		document.getElementById(btn_id).style.display = "";
	}
</script>
{/literal}
</head>
<body id="tabB">

<h1>新增合作學習 專案題目內容</h1>
<p class="intro">以下專案隸屬於<span class="imp">"{$homework_name}"&nbsp;</span>作業</p>
{foreach from = $project_list item = element name=contentloop}
<div id="spread_btn_{$element.project_no}">
    專案<span class="imp">{$smarty.foreach.contentloop.iteration}</span>內容資訊
	   
    <input type="button" class="btn" value="展開" onclick="spread({$element.project_no});"/>
    {if $element.groupno_topic != 0}	
	  (學生自定)
	  {else}
	  {/if}</div>
<div id="content_{$element.project_no}" style="display:none">
  <form name="form_{$element.project_no}" method="post" action="./modify_project.php" >
  專案<span class="imp">{$smarty.foreach.contentloop.iteration}</span>內容資訊
 
  <input type="button" class="btn" id="shrink_btn_{$element.project_no}" value="縮小" onclick="shrink({$element.project_no});"/>
  {if $element.groupno_topic != 0}	
  		(學生自定)
	  {else}
	  {/if}
	<fieldset>
	<legend>專案<span class="imp">{$smarty.foreach.contentloop.iteration}</span>內容資訊</legend>
	<table class="form">
	  <tr>
	  	<th rowspan="2"><span class='required'>*</span>本專案題目的組數,最多允許幾組?</th>
	    <td>&nbsp;&nbsp;&nbsp;
	        <input type="radio" value="" id="group_num_free_id_{$element.project_no}" name="group_num_name_{$element.project_no}" onclick="choose(1,{$element.project_no});" />
	      不限制</td>
	  </tr>
	  <tr>
		<td>&nbsp;&nbsp;&nbsp;
	        <input type="radio" value="" id="group_num_type_id_{$element.project_no}" name="group_num_name_{$element.project_no}" onclick="choose(2,{$element.project_no});" />
	      請輸入組數：
	      <input type="text" name="group_num_{$element.project_no}" id="group_num_{$element.project_no}" disabled="disabled" size="1" value="{$element.similar_project_number}" />
	      &nbsp;組</td>
	  </tr>
	  <tr>
	  	<th><span class='required'>*</span>請輸入專案題目：&nbsp;</th>
	    <td><textarea name="project_content_{$element.project_no}" id="projcet_content" cols="60" rows="20">{$element.project_content}</textarea></td>
	  </tr>
	</table>
	</fieldset>
	<!--<div class="buttons"><a href="./tea_project_list.php">放棄編輯</a></div>-->
	<p class="al-left">
    <input type="hidden" id="Project_no_{$element.project_no}" name="project_no" value="{$element.project_no}" /> &nbsp;
    <input type="hidden" name="homework_no" value="{$element.homework_no}" /> &nbsp;
    <input type="submit" class="btn" value="更新資訊" onclick="assign_proj_no({$element.project_no});"/>&nbsp;
    <input type="hidden" name="delete_{$element.project_no}" id="delete_{$element.project_no}" value="" />
    <input type="submit" class="btn" value="刪除此題" onclick="deleteProject({$element.project_no});"/>
	</p>
     </form>
    </br></br>
  <script>ratio_init({$element.similar_project_number},{$element.project_no});</script>
  </div>
  {foreachelse}
	目前沒有任何專案題目。
	{/foreach}
<br /><br />
</body>
</html>
