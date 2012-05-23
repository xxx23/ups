<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>測驗結果</h1>

	{$data.num}.&nbsp;{$data.question}({if $isreply == 1}<span class="imp">{$data.grade}分</span>&nbsp;{/if}{$data.type_string})<br/>
	{if $data.hasPicture == 1}<img src="{$data.picture}" style="width:480px; height:360px;"/><br/>{/if}
	{if $data.hasVideo == 1}<embed src="{$data.video}" height="300" width="300"/><br/>{/if}
	{if $data.type == 0}
	<span class="imp">正確解答為：{$data.ans}<br/></span>
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="radio" name="question_{$data.sequence}" value="{$answer.number}"/>{$answer.content}<br/>
		{/foreach}
	{elseif $data.type == 1}
	<span class="imp">正確解答為：{$data.ans}<br/></span>
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="checkbox" name="question_{$data.sequence}[]" value="{$answer.number}"/>{$answer.content}<br/>
		{/foreach}
	{else}
	<span class="imp">正確解答為：{if $data.ans == 0}非{else}是{/if}<br/></span>
		&nbsp;&nbsp;1：<input type="radio" name="question_{$data.sequence}" value="1"/>非<br/>
		&nbsp;&nbsp;2：<input type="radio" name="question_{$data.sequence}" value="2"/>是<br/>
	{/if}
	<p>
	<table class="datatable"><tbody>
		<tr>
			<th>學生帳號</th><th>學生姓名</th><th>學生回答</th>
		<tr>
		{foreach from=$stu item=s}
		<tr>
			<td>{$s.login_id}</td><td>{$s.personal_name}</td><td>{$s.answer}</td>
		</tr>
		{foreachelse}
		<tr><td colspan="3" style="text-align:center;">無任何學生</td></tr>
		{/foreach}
	</tbody></table>
	<p class="al-left"><a href="complie_exam.php?test_no={$test_no}"><img src="{$tpl_path}/images/icon/return.gif" />返回線上測驗題目列表</a></p>
</body>

</html>
