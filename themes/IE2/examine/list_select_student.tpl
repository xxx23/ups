<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<head>

<body>
<h1>學生填答結果</h1>
<table class="datatable"><tbody>
	<tr>
		<th>學生帳號</th><th>學生姓名</th>
	<tr>
	{foreach from=$stu item=s}
	<tr class="{cycle values=" ,tr2"}">
		<td>{$s.login_id}</td><td>{$s.personal_name}</td>
	</tr>
	{foreachelse}
	<tr><td colspan="2" style="text-align:center;">此選項無學生選取</td></tr>
	{/foreach}
</tbody></table>
</body>

</html>
