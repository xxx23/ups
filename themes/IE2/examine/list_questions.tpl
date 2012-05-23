<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>測驗答案統計</h1>
<div class="tab">
<ul id="tabnav">
	<li><a href="tea_view.php">測驗列表</a></li>
	<li><a href="complie_exam.php?option=display_students&test_no={$test_no}">學生回答結果</a></li>
</ul></div>
<h1>單選題</h1>
<table class="datatable"><tbody>
	<tr>
		<th>題號</th><th>題目內容</th>
		<th colspan="2">選項1的人數/比例</th><th colspan="2">選項2的人數/比例</th><th colspan="2">選項3的人數/比例</th><th colspan="2">選項4的人數/比例</th><th colspan="2">選項的5人數/比例</th><th colspan="2">選項6的人數/比例</th>
		<th colspan="2">正確的人數/比例</th>
	</tr>
	{foreach from=$single item=e}
	<tr>
		<td>{$e.sequence}</td><td><a href="complie_exam.php?option=display_question&sequence={$e.sequence}">{$e.question}</a></td>
		<td {if $e[0].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=1" target="_blank">{$e[0].num}</a></td>
		<td {if $e[0].is_answer == 1}class="td2"{/if}>{$e[0].percentage}%</td>
		<td {if $e[1].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=2" target="_blank">{$e[1].num}</a></td>
		<td {if $e[1].is_answer == 1}class="td2"{/if}>{$e[1].percentage}%</td>
		<td {if $e[2].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=3" target="_blank">{$e[2].num}</a></td>
		<td {if $e[2].is_answer == 1}class="td2"{/if}>{$e[2].percentage}%</td>
		<td {if $e[3].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=4" target="_blank">{$e[3].num}</a></td>
		<td {if $e[3].is_answer == 1}class="td2"{/if}>{$e[3].percentage}%</td>
		<td {if $e[4].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=5" target="_blank">{$e[4].num}</a></td>
		<td {if $e[4].is_answer == 1}class="td2"{/if}>{$e[4].percentage}%</td>
		<td {if $e[5].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=6" target="_blank">{$e[5].num}</a></td>
		<td {if $e[5].is_answer == 1}class="td2"{/if}>{$e[5].percentage}%</td>
		<td><a href="complie_exam.php?option=list_select_student&sequence={$e.right.no-1}" target="_blank">{$e.right.num}</a></td>
		<td>{$e.right.percentage}%</td>
	</tr>
	{foreachelse}
	<tr><td colspan="16" style="text-align:center;">此次測驗無單選題</td></tr>
	{/foreach}
</tbody></table>
<h1>複選題</h1>
<table class="datatable"><tbody>
	<tr>
		<th>題號</th><th>題目內容</th>
		<th colspan="2">選項1的人數/比例</th><th colspan="2">選項2的人數/比例</th><th colspan="2">選項3的人數/比例</th><th colspan="2">選項4的人數/比例</th><th colspan="2">選項的5人數/比例</th><th colspan="2">選項6的人數/比例</th>
		<th colspan="2">正確的人數/比例</th>
	</tr>
	{foreach from=$multi item=e}
	<tr>
		<td>{$e.sequence}</td><td><a href="complie_exam.php?option=display_question&sequence={$e.sequence}">{$e.question}</a></td>
		<td {if $e[0].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=1" target="_blank">{$e[0].num}</a></td><td {if $e[0].is_answer == 1}class="td2"{/if}>{$e[0].percentage}%</td>
		<td {if $e[1].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=2" target="_blank">{$e[1].num}</a></td><td {if $e[1].is_answer == 1}class="td2"{/if}>{$e[1].percentage}%</td>
		<td {if $e[2].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=3" target="_blank">{$e[2].num}</a></td><td {if $e[2].is_answer == 1}class="td2"{/if}>{$e[2].percentage}%</td>
		<td {if $e[3].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=4" target="_blank">{$e[3].num}</a></td><td {if $e[3].is_answer == 1}class="td2"{/if}>{$e[3].percentage}%</td>
		<td {if $e[4].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=5" target="_blank">{$e[4].num}</a></td><td {if $e[4].is_answer == 1}class="td2"{/if}>{$e[4].percentage}%</td>
		<td {if $e[5].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=6" target="_blank">{$e[5].num}</a></td><td {if $e[5].is_answer == 1}class="td2"{/if}>{$e[5].percentage}%</td>
		<td><a href="complie_exam.php?option=list_right_student&sequence={$e.sequence}&answer={$e.answer}" target="_blank">{$e.right.num}</a></td>
		<td>{$e.right.percentage}%</td>
	</tr>
	{foreachelse}
	<tr><td colspan="16" style="text-align:center;">此次測驗無複選題</td></tr>
	{/foreach}
</tbody></table>
<h1>是非題</h1>
<table class="datatable"><tbody>
	<tr>
		<th>題號</th><th>題目內容</th>
		<th colspan="2">選項非的人數/比例</th><th colspan="2">選項是的人數/比例</th>
		<th colspan="2">正確的人數/比例</th>
	</tr>
	{foreach from=$yesno item=e}
	<tr>
		<td>{$e.sequence}</td><td><a href="complie_exam.php?option=display_question&sequence={$e.sequence}">{$e.question}</a></td>
		<td {if $e[0].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=0" target="_blank">{$e[0].num}</a></td>
		<td {if $e[0].is_answer == 1}class="td2"{/if}>{$e[0].percentage}%</td>
		<td {if $e[1].is_answer == 1}class="td2"{/if}><a href="complie_exam.php?option=list_select_student&sequence={$e.sequence}&index=1" target="_blank">{$e[1].num}</a></td>
		<td {if $e[1].is_answer == 1}class="td2"{/if}>{$e[1].percentage}%</td>
		<td><a href="complie_exam.php?option=list_select_student&sequence={$e.right.no}" target="_blank">{$e.right.num}</a></td>
		<td>{$e.right.percentage}%</td>
	</tr>
	{foreachelse}
	<tr><td colspan="8" style="text-align:center;">此次測驗無是非題</td></tr>
	{/foreach}
</tbody></table>
</body>

</html>
