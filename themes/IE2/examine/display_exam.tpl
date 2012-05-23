<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script type="text/javascript" charset="utf-8" src="{$webroot}script/examine/exam_main.js"></script>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<title></title>
</head>

<body>
<h1>測驗名稱：{$exam_name}</h1>
<p class="al-left"><a href="exam_main.php?test_no={$test_no}">修改測驗題目</a></p>
<table class="datatable"><tbody>
<caption>測驗題目列表</caption>
  <tr>
    <th>題號</th>
    <th>題型</th>
    <th>題目內容</th>
    <th>配分</th>
	<th>刪除</th>
  </tr>
  {foreach from=$exam_data item=exam}
  <tr class="{cycle values=" ,tr2"}">
    <td>{$exam.num}</td>
    <td>{$exam.type_string}</td>
    <td><a target="_blank" href="../Test_Bank/show_test.php?from=1&test_bankno={$exam.test_bankno}">{$exam.question|truncate:45:"...":true}</a></td>
    <td>{$exam.grade}</td>
	<td><input type="button" class="btn" value="刪除" onClick="return delete_question({$exam.test_no}, {$exam.sequence}, '{$exam.function}')"/></td>
  </tr>
  {/foreach}
</table>
<p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" />返回線上測驗列表</a></p>
</body>
</html>
