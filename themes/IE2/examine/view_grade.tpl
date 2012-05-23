<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body class="ifr">
<h1>檢視測驗成績</h1>
	<table class="datatable"><tbody>
		<tr>
			<th>學號</th>
			<th>姓名</th>
			<th>成績</th>
			<th>問答題</th>
            <th>重置學生測驗</th>
		</tr>
		{foreach from=$people item=person}
		<tr class="{cycle values=" ,tr2"}">
			<td>{$person.login_id}</td>
			<td>{$person.personal_name}</td>
			<td>{$person.grade}</td>
			<td>
			{if $person.isreply == 1}<a href="tea_correct.php?pid={$person.personal_id}&test_no={$test_no}&course_cd={$course_cd}"><img src="{$tpl_path}/images/icon/correct.gif"/></a>
			{else}&nbsp;{/if}
			</td>
            <td>
            {if $person.grade eq '未測驗'}
                未測驗無需重置
            {else}
                <a href="view_grade.php?test_no={$test_no}&reset_stu_test=1&sid={$person.personal_id}">重置</a>
            {/if}
                </td>
		</tr>
		{/foreach}
	</tbody></table>
<p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上測驗列表</a></p>
</body>
</html>
