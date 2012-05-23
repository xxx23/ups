<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/learner_profile/delete_student.js"></script>
<script type="text/javascript" src="{$webroot}script/default.js"></script>

<title>學生刪除</title>
</head>

<body>
<h1>刪除學生帳號</h1>
		<!-- p class="al-left"><a href="recover_deleted_student.php">回復學生資料</a><br/>
		<a href="delete_student.php?option=delete_backup">刪除資料備份</a>
		</p -->
<h2>操作說明：</h2>
<div class="intro">
查尋完學生後將要刪除的學生打勾，按下送出即可刪除<br />
<!-- 回復學生資料將會顯示出已被刪除的學生<br />
刪除資料備份後將無法回復學生資料 -->
</div>
<form action="delete_student.php" method="GET">
<h2>搜尋</h2>
<table class="datatable">
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>搜尋依據</th>
	<th width="50%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>輸入</th>
</tr>
	<td>
	<select name="rule" id="_rule">
		<option value="all">全部學生</option>
		<option value="account">帳號</option>
		<option value="name">姓名</option>
	</select>
	</td>
	<td id="_arg"></td>
<tr>
	<td colspan="2"><p class="al-left"> <input type="submit" name="送出搜尋"/></p></td>
</tr>
</table>
</form>
{if $result == 1}
<hr/>
<h2>搜尋結果</h2>
<form action="delete_student.php" method="GET" name="del_form">
<table class="datatable"><tbody>
<tr>
	<th style="width:7%;"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/><input type="checkbox" onclick="clickAll('del_form', this);"/></th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>姓名</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>修課列表</th>
</tr>
{foreach from=$data item=e}
<tr>
	<td><input type="checkbox" name="pid[]" value="{$e.personal_id}"/></td>
	<td>{$e.login_id}</td>
	<td>{$e.personal_name}</td>
	<td>
	{foreach from=$e.course item=c}
	{$c}<br/>
	{foreachelse}
	該學生並無修課
	{/foreach}
	</td>
</tr>
{foreachelse}
<tr><td colspan="4" style="text-align:center;">沒有任何符合資料</td></tr>
{/foreach}
</tbody></table>
<input type="hidden" name="option" value="_delete"/>
<p class="al-left"><input type="button" id="_delete" value="確定刪除"/></p>
</form>
{/if}
</body>

</html>
