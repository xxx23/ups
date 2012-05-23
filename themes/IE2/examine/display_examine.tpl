<html>
	<head>
		<meta http-equiv="Contetn-Type" content="text/html; charset=utf-8"/>

		<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src ="{$webroot}/script/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src ="{$webroot}/script/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" >
			var end_time = {$end_time};
		{literal}
			$(document).ready(function(){
				if(end_time!=0)
                    setTimeout(function(){update_time();},100);
			});

			function update_time()
			{
			    	
				var now = new Date;
				var period = (end_time - now.getTime()/1000)|0;
				var hour = (period % 86400)/3600|0;
				var min = ((period % 86400)%3600)/60|0;
				var sec = (((period % 86400)%3600)%60)|0;
				
				if(period == 0){
					post_exam();
					return ;
				}
				$("#exam_time").html("所剩時間 "+hour+":"+min+":"+sec);
				setTimeout(function(){update_time();},1000);
			}
			function post_exam()
			{
				$("#exam_form").submit();
			}	
		{/literal}
		</script>
	</head>

	<body>
	<h1>進行測驗</h1>
	<div class="ui-state-highlight ui-corner-all" style="width: 150px;padding: 0 .7em;"id = "exam_time"></div>
 	<form id="exam_form" method="POST" action="stu_examine.php">
	<input type="hidden" name="test_no" value="{$test_no}"/>
	{foreach from=$exam_data item=data}
	<div style="border:1px solid #f4f4f4; margin:2px; padding:2px;"><p><span style="font-size:24px;">
	{$data.num}.</span>&nbsp;{$data.question}({if $isreply == 1}<span class="imp">{$data.grade}分</span>&nbsp;{/if}{$data.type_string})<br/>
	{if $data.hasPicture == 1}<img src="{$data.picture}" style="width:480px; height:360px;"/><br/>{/if}
	{if $data.hasVideo == 1}<embed src="{$data.video}" height="300" width="300"/><br/>{/if}
{*	{if $iscorrect == 1 and $data.type != 4}<span class="imp">
	正確解答為：{$data.ans}<br/>
	你的回答為：{$data.reply}&nbsp;&nbsp;&nbsp;&nbsp;得分為：{$data.get_grade}<br/>
	</span>{/if}*}
	{if $data.type == 0}
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="radio" name="question_{$data.sequence}" value="{$answer.number}"/>{$answer.content}<br/>
		{/foreach}
	{elseif $data.type == 1}
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="checkbox" name="question_{$data.sequence}[]" value="{$answer.number}"/>{$answer.content}<br/>
		{/foreach}
	{elseif $data.type == 2}
		&nbsp;&nbsp;1：<input type="radio" name="question_{$data.sequence}" value="0"/>非<br/>
		&nbsp;&nbsp;2：<input type="radio" name="question_{$data.sequence}" value="1"/>是<br/>
	{elseif $data.type == 3}
		{foreach from=$data.answers item=answer}
		&nbsp;&nbsp;{$answer.number}：<input type="text" name="question_{$data.sequence}[]"/><br/>
		{/foreach}
	{else}
		<textarea cols="30" rows="6" name="question_{$data.sequence}"></textarea>
	{/if}
	</p></div>
	{/foreach}

{*	{if $iscorrect == 1}
	<div span="imp">
	你的得分為&nbsp;{$grade}<br/>
	若有回答題，請等候教師批閱。
	</div>
	{/if}*}

	{if $isreply == 1}
	<input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/>
	{else}
	<a href="stu_view.php"><img src="{$tpl_path}/images/icon/return.gif" />回到線上測驗</a>
	{/if}
	</form>
	</body>
</html>
