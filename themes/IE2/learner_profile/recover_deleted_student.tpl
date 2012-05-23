<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<title>回復刪除</title>
</head>

<body>
<h1>回復學生資料</h1>
	<p class="al-left"><a href="delete_student.php">返回刪除學生帳號</a></p>
<h2>操作說明：</h2>
<div class="intro">
	<ul>
		<li>無法回復的原因有使用者編號重複或帳號重複</li>
	</ul>
</div>
<form action="recover_deleted_student.php" method="GET">
<input type="hidden" name="option" value="recover"/>
<h2>回復名單</h2>
<table class="datatable"><tbody>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>使用者編號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>姓名</th>
</tr>
{foreach from=$data item=e}
<tr>
	<td>{$e.personal_id}</td>
	<td>{$e.login_id}</td>
	<td>{$e.personal_name}</td>
</tr>
{foreachelse}
<tr><td colspan="3" style="text-align:center;">沒有任何學生資料可供回復</td></tr>
{/foreach}
<tr>
	<td colspan="3"><p class="al-left"> <input type="submit" value="確定回復"/></p></td>
</tr>
</tbody></table>
</form>
{if $is_error == 1}
<h2>無法回復名單</h2>
<table class="datatable">
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>使用者編號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>帳號</th>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>姓名</th>
</tr>
{foreach from=$err_data item=e}
<tr>
	<td>{$e.personal_id}</td>
	<td>{$e.login_id}</td>
	<td>{$e.personal_name}</td>
</tr>
{/foreach}
</table>
{/if}
</body>

</html>
