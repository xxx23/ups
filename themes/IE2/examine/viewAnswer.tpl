<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=uft-8"/>
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css"/>
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css"/>
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css"/>
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h1>觀看解答</h1>
	{foreach from=$exam_data item=data}
<div style="border:1px solid #F4F4F4; margin:2px; padding:2px;">
<p><span style="font-size:24px;">{$data.num}.</span>&nbsp;{$data.question}&nbsp;({$data.type_string})<br/>
	<span class="imp">正確解答為：{$data.ans}</span><br/>
	{if $data.hasPicture == 1}<img src="{$data.picture}" style="width:480px; height:360px;"/><br/>{/if}
	{if $data.hasVideo == 1}<embed src="{$data.video}" height="300" width="300"/><br/>{/if}
	{if $data.type == 0}
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="radio" name="question_{$data.sequence}" value="{$answer.number}"/>{$answer.content}<br/>
		{/foreach}
	{elseif $data.type == 1}
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="checkbox" name="question_{$data.sequence}[]" value="{$answer.number}"/>{$answer.content}<br/>
		{/foreach}
	{elseif $data.type == 2}
		&nbsp;&nbsp;1：<input type="radio" name="question_{$data.sequence}" value="1"/>非<br/>
		&nbsp;&nbsp;2：<input type="radio" name="question_{$data.sequence}" value="2"/>是<br/>
	{elseif $data.type == 3}
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="text" name="question_{$data.sequence}[]"/><br/>
		{/foreach}
	{else}
	{/if}
	</p></div>
	{/foreach}
	<p class="al-left"><a href="{$location}"><img src="{$tpl_path}/images/icon/return.gif" />回到線上測驗</a></p>
</body>
</html>
