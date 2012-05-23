<html>
<head>
<title>角色</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<script>
<!--
{literal}

function changeSelect(obj, index){
	var id =  obj.childNodes.item(index*2+1).getAttribute("value");	
	document.getElementById('role').style.display="none";
	document.getElementById('login_id').style.display="none";
	document.getElementById('personal_name').style.display="none";
	if(id != 'all')
		document.getElementById(id).style.display="";
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

function checkThis(id){

	var node = document.getElementById(id);
	//alert(node);
	node.checked = true;
}
 
{/literal}  
-->
</script>
</head>

<body >
<!-- 標題 -->
 <h1>使用者角色管理作業</h1>
<!-- 內容說明 -->
<h2>操作說明：</h2>
<div class="intro">
  <ol>
    <li>先查尋出所要修改的人</li>
    <li>勾選你要修改的人並設定他的角色</li>
    <li>按下確定修改更換角色</li>
  </ol>
<span class="imp">注意: </span></div>
<!--功能部分 -->
<form method="post" action="./user_role.php?action=search">
<h2>搜尋</h2>
<table class="datatable">
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>搜尋依據
	</th>
	<th width="50%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>輸入
	</th>		
</tr>
<tr>
	<td >
	<select name="search" onchange="changeSelect(this, this.selectedIndex);">
		<option value="all" selected="selected">全部</option>
		<option value="role" selected="selected">角色</option>
		<option value="login_id">帳號</option>
		<option value="personal_name">姓名</option>
	</select>
	</td>	
	<td>
	<div id="role">
		<select name="role">
			{html_options values=$role_ids selected=$role_id output=$role_names}
		</select>
	</div>
	<div id="login_id" style="display:none;">
		<input type="text" name="login_id" />
	</div>
	<div id="personal_name" style="display:none;">
		<input type="text" name="personal_name" />
	</div>
	</td>
</tr>
<tr>
	<td colspan="2">
	<p class="al-left"> <input type="submit" name="送出搜尋" /></p>
	</td>
</tr>
</table>
</form>
{if $show == 1}
<form method="post" action="./user_role.php?action=modify">
<h2>搜尋結果</h2>
<table class="datatable">
<tr>
	<th>
	<img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>
	<input type="checkbox" name="checkAll" onClick="doCheckAll('list[]');" />全選</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>姓名</th>	
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>目前角色</th>
</tr>
{foreach from=$data_list item=data}
<tr>
	<td><input type="checkbox" name="list[]" value="{$data.personal_id}" id="list_{$data.personal_id}"/></td>
	<td>{$data.login_id}</td>
	<td>{$data.personal_name}</td>
	<td>
		<select name="data_role[{$data.personal_id}]" onchange="checkThis('list_{$data.personal_id}');">
			{html_options values=$role_ids selected=$data.role_cd output=$role_names}
		</select>
	</td>
	<input type="hidden" name="login_id[{$data.personal_id}]" value="{$data.login_id}" />	
	<input type="hidden" name="personal_name[{$data.personal_id}]" value="{$data.personal_name}" />
	<input type="hidden" name="role[{$data.personal_id}]" value="{$data.role_name}" />
	<input type="hidden" name="role_cd[{$data.personal_id}]" value="{$data.role_cd}" />		
</tr>
{/foreach}
<tr>
	<td colspan="4">
	<input type="submit" value="確定修改" />
	</td>
</tr>
</table>
</form>
{/if}

{if $update == 1}
<h2>更新結果</h2>
<table class="datatable">
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>姓名</th>	
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>更新</th>
</tr>
{foreach from=$update_list item=update}
<tr>
	<td>{$update.login_id}</td>
	<td>{$update.personal_name}</td>
	<td>{$update.message}</td>	
</tr>
{/foreach}
</table>
{/if}



<br/><br/><br/><br/><br/>
</body>
</html>
