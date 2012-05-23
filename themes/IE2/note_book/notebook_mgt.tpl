<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>個人筆記本管理</title>
<link href="{$tpl_path}/css/tabs.css" 	 	rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" 	rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" 		rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" 		rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" 	rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>

{literal}
<script type="text/JavaScript">

function Check_create()
{	
	if(document.getElementById("notebook_name_new").value == ""){
		alert("請輸入筆記本名稱!");
		return false;
	}
}
function Check_modify()
{	
	if(document.getElementById("notebook_name_mod").value == ""){
		alert("請輸入筆記本名稱!");
		return false;
	}
}

function delete_confirm(){
	if(confirm("確定要刪除整份筆記本(包含本筆記本其下所有目錄與檔案)?"))
		return true;
	else
		return false;
}

function edit_notebook_content(notebook_cd){
	var org_cd = "original_" + notebook_cd ;
	var mod_cd = "modify_" + notebook_cd ; 
	if( document.getElementById( org_cd ).style.display == "none") {
		document.getElementById( mod_cd ).style.display = "none";
		document.getElementById( org_cd ).style.display = "";
	}else {
		document.getElementById( mod_cd ).style.display = "";
		document.getElementById( org_cd ).style.display = "none";		
	}
}
//-->
</script>
{/literal}
</head>
<body>

<p><span class="imp">{$status}</span></p>
<h1>筆記本列表</h1>
<div>

<table class="datatable">
<tr>
	<td width="10%">索引</td>
	<td width="60%">筆記名稱&nbsp;<span style="color:#AAAAAA">(點選編輯詳細內容)</span></td>
	<td>修改</td>
	<td>刪除</td>
</tr>	
{foreach from=$notebooks key=notebook_cd item=notebook_name name=notebook_loop}
<tr class="{cycle values=" ,tr2"}">
	<td>{$smarty.foreach.notebook_loop.iteration}</td>
	<td><div id="original_{$notebook_cd}" style="">
			<a href="nb_loadTreeFromDB.php?notebook_cd={$notebook_cd}">{$notebook_name}</a>
		</div>
		<div id="modify_{$notebook_cd}" style="display:none">	
		<form name="create_notebook" action="notebook_mgt.php" method="post">
			<input type="hidden" name="modify_notebook_cd" id="modify_notebook_cd" value="{$notebook_cd}">
 	        筆記名稱：<input type="text" name="notebook_name" id="notebook_name_mod" value="{$notebook_name}"/><br/>
	        <!--公開：<select name="isPublic" id="modify_isPublic"> <option>否</option> <option>是</option> </select><br/>-->
			<input class="btn" type="submit" name="submit_modify" value="送出" onClick="return Check_modify();">
			<input type="submit" name="modify_and_edit" id="modify_and_edit" class="btn" value="送出並編輯內容" onClick="return Check_modify();">
		</form>
		</div>
	</td>
	<td> 
		<input type="button" value="修改" onclick="edit_notebook_content({$notebook_cd})">		
    </div>
	</td>
	<td>
		<form name="modify_notebook" action="notebook_mgt.php" method="post">
		<input name="del_notebook_this" type="hidden" value="{$notebook_cd}">
		<input name="del_notebook" type="submit" value="刪除" onclick="return delete_confirm()">
	</td>
</tr>
{foreachelse}
<tr>
	<td class="tr2" colspan="4"><div style="text-align:center">您目前沒有筆記</td></td>
</tr>
{/foreach}
</table>
</div>

<br/>
<br/>

<h1>新增筆記本</h1>
<div style="text-align:left">
<form name="create_notebook" action="notebook_mgt.php" method="post">
<input type="hidden" name="submit_content_cd" id="create_notebook_cd" value="">
	<ul>
		<li>筆記本名稱：&nbsp;&nbsp;<input type="text" name="notebook_name" id="notebook_name_new"></li>
        <!--<li>是否公開：&nbsp;&nbsp;&nbsp;&nbsp; <select name="isPublic" id="create_isPublic"> <option value="">否</option> <option>是</option> </select> </li>-->
	</ul>
    <p class="al-left">
		<input name="submit_create" type="submit" class="btn" onClick="return Check_create();" value="   新增   ">
	</p>
</form>
</div>



<!--
<div class="inner_contentF" id="inner_contentF" >
  <h1>匯出整份筆記本</h1>
  欲匯出的筆記本：
  <select name="export_notebook_this" id="export_notebook_this" onChange="export_notebook(this.selectedIndex)">
	{foreach from=$tbArray key=k item=i}
    <option id="{$k}" value="{$k}">{$i}</option>
	{/foreach}
  </select>
  <hr />
  <iframe name="show_export" id = "show_export" onload="ResizeIframe(this);" src="./export_notebook.php?" style="display:none;"> </iframe>
</div>
-->


</body>
</html>
