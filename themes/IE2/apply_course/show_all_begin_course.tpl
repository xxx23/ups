<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />

<script src="{$webroot}script/prototype.js" type="text/javascript" ></script>
<script type="text/javascript" src="{$tpl_path}/script/course_admin/show_all_begin_course.js"></script>
<script language="javascript">
<!--
{literal}
var formname = "show_all_begin_course";
var pageurl = "./show_all_begin_course.php?action=search";
function changePage(page)
{
    var myForm=document.forms[formname];
    if(myForm.page)myForm.page.value =page;
    myForm.action = pageurl;
    myForm.submit();
return;
}
function pageContorlSubmin(form)
{
    var myForm=document.forms[formname];
    var query = document.getElementsByName("query\[\]");
    var query_array = [];
    for(var i = 0;i<query.length;i++)
    {
      if(query[i].checked)
      {
        query_array.push(i);
      }
    }
    myForm.action = window.location.href + "&query[] = "+query_array;
    myForm.submit();
    return;
}
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
	if($(tmp+"_button").style.display == "none")
		$(tmp+"_button").style.display = "";
	else
		$(tmp+"_button").style.display = "none";
}
function doCheckAll(string){
	var nodes = document.getElementsByName(string);
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

{if $show_search == 1}
<body onload="init();">
{else}
<body>
{/if}

<h1>查詢開課</h1>
<div class="describe">小提示：請勾選查詢條件，可進行進階搜尋。</div>
<form name="show_all_begin_course" method="get" action="show_all_begin_course.php">
  <div class="searchbar" style="margin-left:60px;"><table class="datatable" >
    <tr>
      <th width="40%">
        <input type="checkbox" name="query[]" value="0" onclick="showInputAll(this);" checked />
      查詢所有開課</th>
        <td>&nbsp;</td>
    </tr>
    <tr>
      <th width="40%"><input type="checkbox" name="query[]" value="1" onclick="showInput(this.value);">
        依開課名稱</th>
      <td><div id="query_1" style="display:none;"><input type="text" name="begin_course_name_input" />        (可用關鍵字查詢) </div></td>
    </tr>
    <tr>
      <th width="40%"><input type="checkbox" name="query[]" value="2"onclick="showInput(this.value);">依開課單位</th>
      <td><div id="query_2" style="display:none;"><input type="text" name="unit_input" /></div></td>
    </tr>
    <tr>
      <th width="40%"><input type="checkbox" name="query[]" value="3" onclick="showInput(this.value);">依授課教師</th>
      <td><div id="query_3" style="display:none;" ><input type="text" name="teacher_input" />      </div></td>
    </tr>
    <tr>
      <td colspan="2"><p class="al-left">  <input type="hidden" name="search" value="yes" />
        <input type="submit" value="查詢課程資訊">
      </p></td>
    </tr>
  </table></div>
    <div id="pageControl" >
	{if $page_cnt ne 0}
	<span>第
	 <select name="page" onChange="pageContorlSubmin(this)" >
     {html_options values=$page_ids output=$page_names  selected=$page_sel}
     </select>/{$page_cnt}頁
	 </span>
	 <a href="javascript:changePage({$previous_page})">上一頁</a>
	 <a href="javascript:changePage({$next_page})"  >下一頁</a>
	{/if}
	</div>

</form>
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">

{if $show_search == 1}
<h2>查詢結果</h2>
<form action="delete_course.php" method="POST" name="delete_course">
  <table class="datatable" style="width:95%">
    <tr>
      <th> 
        <input type="checkbox" name="checkAll" onClick="doCheckAll('check[]');" />
      </th>
      <th> 課程編號</th>
      <th width="12%"> <div align="center">開課單位</div></th>
      <th> 開課名稱</th>
      <th width="9%"> <div align="center">授課教師</div></th>
	  <th width="5%"> <div align="center">證書</div></th>
      <th width="9%"> <div align="center">課程資訊</div></th>
      <th width="9%"> <div align="center">授課教師</div></th>
      <th width="9%"> <div align="center">重置課程</div></th>
    </tr>
    {foreach from=$course_data item=course}
    <tr>
      <td><input type="checkbox" name="check[]" value="{$course.begin_course_cd}" /></td>
      <td>{$course.inner_course_cd}</td>
      <td><div align="center">{$course.unit_name}</div></td>
      <td>{$course.begin_course_name|escape}</td>
      <td><div align="center">{$course.personal_name}</div></td>
	  <td><div align="center"><a href="../Certificate/certificateManagement.php?begin_course_cd={$course.begin_course_cd}&incomingPage=../Course_Admin/show_all_begin_course.php" >設定</a></div></td>
      <td><div align="center"><a href="./view_course.php?begin_course_cd={$course.begin_course_cd}" >修改</a></div></td>
      <td><div align="center"><a href="./add_teacher_to_course.php?begin_course_cd={$course.begin_course_cd}" >修改</a></div></td>
      <td><div align="center"><a href="reset_course.php?begin_course_cd={$course.begin_course_cd}">重置</a></div></td>
    </tr>
	{/foreach}
    <tr>
      <td colspan="9"><p class="al-left">
      	<input type="hidden" id="option" name="option" value=""/>
	<input id="_delete_course" type="button" value="刪除課程"/></p></td>
    </tr>
  </table>

</form>
{/if}

<input class="btn" type="button" value="返回課程列表" onClick="location.href='begin_course_list.php';" />
</body>
</html>
