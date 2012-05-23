<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="{$webroot}script/default.js"></script>
	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>亂數出題</h1>
<form action="random.php" method="POST" name="random">
<input type="hidden" name="option" value="select_bank"/>
<table class="datatable" style="width:65%;">
<caption>
請勾選所欲出題之題庫
</caption>
<tbody><tr>
	<th style="text-align:center;"><input type="checkbox" onClick="clickAll('random', this);"/></th>
	<th>題庫名稱</th>
	<th>選擇題</th>
	<th>是非題</th>
	<th>填充題</th>
	<th>回答題</th>
</tr>
{foreach from=$banks item=bank}
<tr class="{cycle values=" ,tr2"}">
	<td style="text-align:center;"><input type="checkbox" name="test_bank_id[]" value="{$bank.test_bank_id}"/></td>
	<td>{$bank.test_bank_name}</td>
	<td>{$bank[1]}</td>
	<td>{$bank[2]}</td>
	<td>{$bank[3]}</td>
	<td>{$bank[4]}</td>
</tr>
{/foreach}
</tbody></table>
<p class="al-left">
<input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/></p>
</form>

<p class="al-left"><a href="exam_main.php"><img src="{$tpl_path}/images/icon/return.gif" />放棄亂數出題</a></p>

</body>
</html>
