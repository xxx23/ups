<html>
	<head>
		<meta http-equiv="Contetn-Type" content="text/html; charset=utf-8"/>

		<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
	<h1> 學生作答情形</h1>
	{foreach from=$exam_data item=data}
	
<div style="border: 1px solid #f4f4f4; margin:2px; padding:2px;">	<p>
	{$data.num}.&nbsp;{$data.question}({if $isreply == 1}<span class="imp">{$data.grade}分</span>&nbsp;{/if}{$data.type_string})<br/>
	{if $data.hasPicture == 1}<img src="{$data.picture}" style="width:480px; height:360px;"/><br/>{/if}
	{if $data.hasVideo == 1}<embed src="{$data.video}" height="300" width="300"/><br/>{/if}
	{if $data.type == 0}
		正確解答為：<span class="imp">{$data.ans}<br/></span>
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="radio" name="question_{$data.sequence}" value=""/>{$answer.content}&nbsp;&nbsp;<span class="imp">({$answer.num}人)</span><br/>
		{/foreach}
	{elseif $data.type == 1}
		正確解答為：<span class="imp">{$data.ans}<br/></span>
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="checkbox" name="question_{$data.sequence}[]" value=""/>{$answer.content}&nbsp;&nbsp;<span class="imp">({$answer.num}人)</span><br/>
		{/foreach}
	{elseif $data.type == 2}
		正確解答為：<span class="imp">{if $data.ans == 0}非{else}是{/if}<br/></span>
		&nbsp;&nbsp;1：<input type="radio" name="question_{$data.sequence}" value=""/>非&nbsp;&nbsp;<span class="imp">({$data.answers[0]}人)</span><br/>
		&nbsp;&nbsp;2：<input type="radio" name="question_{$data.sequence}" value=""/>是&nbsp;&nbsp;<span class="imp">({$data.answers[1]}人)</span><br/>
	{elseif $data.type == 3}
		正確解答為：<span class="imp">{$data.ans}<br/></span>
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="text" name="question_{$data.sequence}[]"/><br/>
		{/foreach}
	{else}
		<textarea cols="30" rows="6" name="question_{$data.sequence}"></textarea>
	{/if}

	{if $data.type == 2}
	學生的回答為：{if $data.reply == 0}非{else}是{/if}<br/>
	{else}
	學生的回答為：{$data.reply}<br/>
	{/if}
	</p></div>
	{/foreach}
	<p class="al-left"><a href="complie_exam.php?option=display_students&test_no={$test_no}"><img src="{$tpl_path}/images/icon/return.gif" />返回學生列表</a></p>
</body>
</html>
