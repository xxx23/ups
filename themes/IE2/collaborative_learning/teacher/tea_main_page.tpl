<HTML>
<head>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<title>教師合作學習主選單</title>
{literal}
<script type="text/javascript">
function tea_co_learn(homework_no,Key){
	location.href = "./tea_co_learn.php?homework_no="+homework_no+"&key="+Key;
}
</script>
{/literal}
</head>
<body>

<h1>您目前的合作學習專案列表</h1>
<table class="datatable">
  <tr> 
	  <th> 作業名稱</th>
	  <th> 配分</th>
	  <th>  作業結束時間</th>
	  <th>  進入</th>
  </tr>
  {foreach from = $project_list item = element name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
  <tr>
	  <td>{$element.homework_name}</td>
	  <td>{$element.percentage}%</td>
	  <td>{$element.d_dueday}</td>
	  <td><a href="#" onClick="tea_co_learn('{$element.homework_no}','{$element.key}');"><img src="{$tpl_path}/images/icon/go.gif" /></a></td>
  </tr>
  {else}
  <tr class="tr2">
	  <td>{$element.homework_name}</td>
	  <td>{$element.percentage}%</td>
	  <td>{$element.d_dueday}</td>
	  <td><a href="#" onClick="tea_co_learn('{$element.homework_no}','{$element.key}');"><img src="{$tpl_path}/images/icon/go.gif" /></a></td>
  </tr>
  {/if}
	{foreachelse}
	目前沒有任何合作學習專案。
	
	{/foreach}
</table>
</BODY></html>

