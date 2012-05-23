<html>
<head/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" charset="utf-8" src="{$webroot}script/examine/exam_main.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>編輯測驗題目</h1>
  <div class="tab">
  <ul id="tabnav">
      <li><a href="exam_main.php?content_cd={$content_cd}">繼續編輯</a></li>
      <li><a href="tea_view.php">結束編輯</a></li>
      <li><a href="set_publish.php?test_no={$test_no}">結束編輯並進行發佈設定</a></li>
  </ul></div>
  <table class="datatable">
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
      <td>{$exam.question|truncate:45:"...":true}</td>
      <td>{$exam.grade}</td>
      <td><input type="button" class="btn" value="刪除" onClick="return delete_question({$exam.test_no}, {$exam.sequence}, '{$exam.function}')"/></td>
    </tr>
	{/foreach}
  </table>
</body>

</html>
