<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="{$webroot}script/prototype.js" type="text/javascript"></script>
<script src="{$webroot}script/list_unit.js" type="text/javascript"></script>
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/course.css" rel="stylesheet" type="text/css" />

<title>課程性質設定頁面</title>
</head>
<body class="ifr">
<h1>課程性質管理</h1>
{if $temp_number == 1 } <!-- 這個是顯示修改的頁面 -->
<h2>課程性質修改</h2>
<form method="post" action="course_property.php?action=after_modify">
<table class="datatable">
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>原始課程性質</th>
	<th>修改後課程性質</th>
</tr>
<tr>
	<td>{$old_name}</td>
	<td>
		<input type="text" name="property_new_name" size="20">類</input> <input type="submit" value="送出"></input>
		<input type="hidden" name="property_cd" value="{$property_cd}"></input>
	</td>
</tr>
</table>
</form>
{elseif $temp_number == 0}
<h2>課程性質控制頁面</h2>
<center>
<table class="datatable">
<tbody>
	<tr>
		<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>課程性質序號</th>
		<th>課程性質名稱</th>
        {if $show_delete == 1}
		<th>刪除</th>
        {/if}
		<th>修改</th>
	</tr>
	{assign var="count" value=1}
	<!-- 印出所有的課程性質 -->
	{section name=counter loop=$course_property}
	<tr>
		<td>{$count++}</td>
		<td>{$course_property[counter].property_name|escape}</td>
		{if $show_delete == 1}
        <td><a href="./course_property.php?action=delete&property_cd={$course_property[counter].property_cd}" onclick="return confirm('您確認要刪除此性質嗎？');">刪除</a></td>
        {/if}
		<td>
		<a href="./course_property.php?action=modify&property_cd={$course_property[counter].property_cd}">修改</a>
		</td>
	</tr>
	{/section}
</tbody>
</table>
<h2>新增課程性質</h2>
<form method="post" action="course_property.php?action=new_property">
<table class="datatable" style="border-width:2px">
<tr style="vertical-align:middle;">
	<td>課程性質名稱 </td>
	<td><input type="text" name="property_new_name" size="20">類</td> 
	<td><input type="submit" value="送出"></td>
</tr>
</table>
</form>
</center>
{/if}
</body>
</html>
