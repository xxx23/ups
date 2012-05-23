<html>
<head>
<title>批次匯入帳號</title>
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

<body>
<!-- 標題 -->
<h1>批次建立帳號</h1>
<!-- 內容說明 -->
<h2>操作說明：</h2>
<div class="intro">
  <ol>
    <li>在帳號關鍵字地方，輸入帳號。</li>
	<li>在數量的地方，輸入要建立的帳號數量</li>
	<li>帳號 = 帳號關鍵字 + 數量流水號</li>
	<li>密碼 = 密碼關鍵字 + 帳號</li>
    <li>批次建立帳號時，需選擇身份別，若無選擇則會預設為一般民眾</li>
  </ol>
<span class="imp">注意: </span></div>
<!--功能部分 -->
<form method="post" action="./adm_insert_student.php?action=create">
<h2>建立帳號</h2>
<table class="datatable">
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號關鍵字</th>
	<td><input type="text" name="id" /></td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>數量</th>
	<td><input type="text" name="num" /></td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>密碼關鍵字</th>
	<td><input type="text" name="passwd" /></td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>角色</th>
	<td>
        <select name="role">	
	<!--{html_options values=$role_ids selected=$role_id output=$role_names}-->
	{foreach from = $roles  key = k item = v}
		{if $user_role == 0}
 			<option value='{$v.id}'>{$v.name}</option>
	        {else if $user_role == 6}
			{if $v.id == 0 || $v.id == 5 || $v.id == 6 }
 			<!--<option value='{$v.id}'>{$v.name}</option>-->
			{else}
			<option value='{$v.id}'>{$v.name}</option>
			{/if}
		{/if}	
	{/foreach}
	</select>
	</td>
</tr>
<tr>
<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>身份別</th>
<td>
<select name="student_dist" id="student_dist">
<option value="-1">請選擇</option>
<option value="0">一般民眾</option>
<option value="1">國小學教師</option>
<option value="2">高中職教師</option>
<option value="3">大專院校學生</option>
<option value="4">大專院校教師</option>
<option value="5">數位機會中心輔導團隊教師</option>
<option value="6">縣市政府研習課程老師</option>
<option value="7">其它</option>
</select>
</td>
</tr>
</table>
<input type="submit" name="建立帳號" />
<input type="reset" name="清空" />
</form>

{if $create==1}
<h2>建立成功帳號</h2>
<table class="datatable">
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>編號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>密碼</th>
</tr>
{foreach from=$data_list item=data}
<tr>
	<td>{$data.index}</td>
	<td>{$data.id}</td>
	<td>{$data.passwd}</td>
</tr>
{/foreach}
</table>


<h2>建立失敗帳號</h2>
<table class="datatable">
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>建立失敗原因</th>
</tr>
{foreach from=$error_list item=error}
<tr>
	<td>{$error.id}</td>
	<td>{$error.reason}</td>
</tr>
{/foreach}
</table>

{/if}

<br/><br/><br/>
</body>
</html>
