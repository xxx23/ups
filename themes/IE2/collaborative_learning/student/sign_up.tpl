<HTML>
<head>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<title>修改專案</title>
{literal}
<script type="text/javascript">
function sign_up(homework_no){
	location.href = "./sign_up_form.php?homework_no="+homework_no;
}
function func(homework_no){
	id = "sign_up_"+homework_no;
	//document.getElementById(id).disabled = "disabled";
	//alert(id);
	//alert(document.getElementById(id));
}
</script>
{/literal}
</head>
<body>

<h1>分組報名</h1>
<table class="datatable">
  <tr> 
	  <th> 名稱</th>
	  <th> 配分</th>
	  <th> 分組狀況</th>
	  <th> 報名結束時間</th>
	  <th>  project結束時間</th>
	  <th>  申請報名</th>
  </tr>
  {foreach from = $project_list item = element name=contentloop}
	{if $smarty.foreach.contentloop.iteration %2 == 1}
  <tr>
	  <td>{$element.homework_name}</td>
	  <td>{$element.percentage}%</td>
	  {if $element.num == 0}
	  <td>未分組<script>func({$element.homework_no});</script></td>
	  {else}
	  <td>已分組</td>
	  {/if}
	  <td>{$element.due_date}</td>
	  <td>{$element.d_dueday}</td>
	  <td><input type="submit" id="sign_up_{$element.homework_no}" name="submit" value="報名" onClick="sign_up({$element.homework_no});"/></td>
  </tr>
  {else}
  <tr class="tr2">
	  <td>{$element.homework_name}</td>
	  <td>{$element.percentage}%</td>
	  {if $element.num == 0}
	  <td>未分組<script>func({$element.homework_no});</script></td>
	  {else}
	  <td>已分組</td>
	  {/if}
	  <td>{$element.due_date}</td>
	  <td>{$element.d_dueday}</td>
	  <td><input type="submit" id="sign_up_{$element.homework_no}" name="submit" value="報名" onClick="sign_up({$element.homework_no});"/></td>
  </tr>
  {/if}
	{foreachelse}
	目前沒有任何合作學習作業。
	{/foreach}
</table>
</BODY></html>

