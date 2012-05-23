<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>合作學習組間互評結果</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>合作學習組間互評結果</h1>
	{foreach from = $group_list item = element}
	    <!--<tr>
			<td colspan="3"><p class="intro">第<span class="imp">{$element.group_no}</span>組對第{$Group_no}組的評分</p></td>
		</tr>-->
		<table class="datatable">
		<caption>第<span class="imp">{$element.group_no}</span>組對第{$Group_no}組的評分</caption>
		<tr>
			<th>評分組別</th>
			<th>所評分數</th>
		</tr>
		{foreach from = $element.group_score item = group name = contentloop}
		<tr class="{cycle values=" ,tr2"}">
			<td>{$group.name}</td>
			<td>{$group.score}</td>
		</tr>
		{foreachelse}
		<tr><td colspan="2">目前此組別學生皆尚未評分。</td></tr>
		{/foreach}
		<tr class="tr2">
			<th>第{$element.group_no}組所評分數平均值</th>
			<td><span class="imp">{$element.average}</span></td>
		</tr> 
		</table>
		<br />
	{/foreach}
	
	<p class="intro">每組對第{$Group_no}組的分數總平均：<span class="imp">{$total_avg}</span>
	<br />(註：未評分的組別不列入計算。)</p>
	<!--<tr>
		<th>作業下載</th>
		<td><a href="#">download</a></td>
	</tr> -->

</body>
</html>
