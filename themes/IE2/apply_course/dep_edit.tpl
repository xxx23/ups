<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <script src="{$webroot}script/prototype.js" type="text/javascript"></script>
  <script src="{$webroot}script/dep_edit.js" type="text/javascript"></script>


<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/course.css" rel="stylesheet" type="text/css" />


<title>TEST</title>
</head>

<body class="ifr" {if $finish==1} onload="ylf('ok', 5, 'false')" {/if} >

<form name="frmRegistration" method="post" action="dep_edit.php">
<center>

{if $finish==0}
<table class="datatable"><tbody>
	{foreach from=$Department item=dep}
	<input type="hidden" id="unit_cd" name="unit_cd" readonly=true value={$dep.unit_cd}>
	<!--
	<tr>
		<td>類別編號</td>
		<td><input type="hidden" id="unit_cd" name="unit_cd" type="text" readonly=true value={$dep.unit_cd} />{$dep.unit_cd}</td>
	</tr>
	-->
	<tr>
		<td>類別名稱</td>
		<td><input id="unit_name" name="unit_name" type="text" value={$dep.unit_name|escape} /></td>
	</tr>
	<!--
	<tr>
		<td>系所英文名稱</td>
		<td><input id="unit_abbrev" name="unit_abbrev" type="text" value={$dep.unit_abbrev} /></td>
	</tr>
	
	<tr>
		<td>系所簡稱</td>
		<td><input id="unit_e_name" name="unit_e_name" type="text" value={$dep.unit_e_name} /></td>
	</tr>
	
	<tr>
		<td>系所英文簡稱</td>
		<td><input id="unit_e_abbrev" name="unit_e_abbrev" type="text" value={$dep.unit_e_abbrev} /></td>
	</tr>
	
	<tr>
		<td>目前狀態</td>
		<td><input id="unit_state" name="unit_state" type="text" readonly=true value={$dep.unit_state} /></td>
	</tr>
	-->
	<!--
	<tr>
		<td>所屬部門</td>
		<td><input id="department" name="department" type="text" value={$dep.department} /></td>
	</tr>-->
	{/foreach}
	
<tbody></table>
<p class="al-left"><input type="submit" name="submitbutton" value="確認送出" /></p>

{else if $finish==1}
<div ID="ok">修改成功</div> <br>
<a href=dep_list.php>回列表</a>
{/if}
</center>
</form>
</body>
</html>
