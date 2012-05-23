<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body class="ifr">
<h1>學生回答結果</h1>
	<table class="datatable"><tbody>
		<tr>
			<th>學號</th>
			<th>姓名</th>
			<th>成績</th>
		</tr>
		{foreach from=$people item=person}
		<tr class="{cycle values=" ,tr2"}">
			<td>{$person.login_id}</td>
			<td>{$person.personal_name}</td>
			<td>
			{if $person.isreply == 1}<a href="complie_exam.php?option=student_reply&pid={$person.personal_id}">{$person.grade}</a>
			{else}{$person.grade}{/if}
			</td>
		</tr>
		{/foreach}
	</tbody></table>
	<p class="al-left"><a href="complie_exam.php?test_no={$test_no}"><img src="{$tpl_path}/images/icon/return.gif" />返回線上測驗題目列表</a></p>
</body>
</html>
