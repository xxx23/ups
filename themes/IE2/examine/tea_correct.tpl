<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>教師批閱題目</h1>
<form action="tea_correct.php" method="POST">
{foreach from=$questions item=question}
<p>
{$question.sequence}. {$question.question}&nbsp;&nbsp;(<span class="imp">{$question.grade}</span>分)<br/><br/>
<textarea cols="30" rows="6" readonly>{$question.answer}</textarea><br/><br/>
得分：<input type="text" size="3" name="question_{$question.test_bankno}" value="{$question.ans_grade}"/>
</p>
{/foreach}
<input type="hidden" name="option" value="correct"/>
<input type="hidden" name="course_cd" value="{$course_cd}"/>
<input type="hidden" name="test_no" value="{$test_no}"/>
<input type="hidden" name="pid" value="{$pid}"/>
<input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/>
</form>
<p class="al-left"><a href="view_grade.php?test_no={$test_no}"><img src="{$tpl_path}/images/icon/return.gif"/>返回上一頁</a></p>
</body>
</html>
