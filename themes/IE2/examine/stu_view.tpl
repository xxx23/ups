<html>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title></title>
<head>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript" charset="utf-8" src="{$webroot}script/examine/stu_view.js">
<!--
{literal}
if(document.layers){
	document.write('<LAYER visibility="hide" bgcolor="#ffffcc"></LAYER>');
}else if(document.all){
	document.write('<DIV id="lay" style="position:absolute;background-color:#ffffcc"></DIV>');
}

hide();

{/literal}
-->
</script>

<script type="text/javascript" >
<!--
{literal}
function alertReadTime()
{
	alert("閱讀時數未達下限，無法進行測驗");
}
{/literal}
-->
</script>


</head>

<body>
  <h1>線上測驗</h1>
  <table class="datatable">
    <tbody>
	<tr>
		<th>測驗名稱</th>
		<th>類型</th>
		<th>配分</th>
		<th>測驗</th>
		<th>開始時間</th>
		<th>結束時間</th>
		<th>成績</th>
	</tr>
	{foreach from=$exam_data item=exam}
	<tr class="{cycle values=" ,tr2"}">
		<td>{$exam.test_name}</td>
		<td>{if $exam.test_type == 1}自我評量{else}正式測驗{/if}</td>
		<td>{$exam.percentage}%</td>
		<td>
		{if $exam.disabled == 0}
			<input onclick = "alertReadTime()" type="button" class="btn" value="進入測驗" />
		{elseif $exam.disabled == 1}<input type="button" class="btn" value="進入測驗" disabled/>
		{elseif $exam.disabled == 2}<input type="button" class="btn" value="進入測驗" onClick="enterExamine({$exam.test_no});"/>
		{elseif $exam.disabled == 3}<input type="button" class="btn" value="觀看解答" disabled/>
		{elseif $exam.disabled == 4}<input type="button" class="btn" value="觀看解答" onClick="viewAnswer({$exam.test_no});"/>{/if}
		</td>
		<td>{$exam.d_test_beg}</td>
		<td>{$exam.d_test_end}</td>
		<td>{$exam.grade}</td>
	</tr>
	{foreachelse}
	<tr><td colspan="7" style="text-align:center;">目前無任何測驗</td></tr>
	{/foreach}
  </tbody>
</table>
<LAYER visibility="hide" bgcolor="#ffffcc"/>
<DIV id="lay" style="position:absolute;background-color:#ffffcc"/></div></body>
</body>

</html>
