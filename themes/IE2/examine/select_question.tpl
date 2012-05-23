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
<p class="al-left"><a href="random.php">[重新選擇題庫]</a></p>
<form action="random.php" method="POST" name="random">
<input type="hidden" name="option" value="select_question"/>
<table class="datatable">
<caption>請決定各題型出題數及其配分</caption>

<!-- ----------------------- 0 ------------------------------- -->
<tr>
	<th>難易度(簡易)</th>
	<th>選擇題</th>
	<th>是非題</th>
	<th>填充題</th>
	<th>簡答題</th>
</tr>
<tr class="tr2">
	<td>總題數</td>
	<td>{$group[0][1]}</td>
	<td>{$group[0][2]}</td>
	<td>{$group[0][3]}</td>
	<td>{$group[0][4]}</td>
<input type="hidden" name="sum_0_1" value="{$group[0][1]}"/>
<input type="hidden" name="sum_0_2" value="{$group[0][2]}"/>
<input type="hidden" name="sum_0_3" value="{$group[0][3]}"/>
<input type="hidden" name="sum_0_4" value="{$group[0][4]}"/>	
</tr>
<tr>
	<td>該題型題數</td>
	<td><input type="text" name="num_0_1" size="4" value="0"/></td>
	<td><input type="text" name="num_0_2" size="4" value="0"/></td>
	<td><input type="text" name="num_0_3" size="4" value="0"/></td>
	<td><input type="text" name="num_0_4" size="4" value="0"/></td>
</tr>
<tr>
	<td>該題型佔分</td>
	<td><input type="text" name="grade_0_1" size="4" value="0"/></td>
	<td><input type="text" name="grade_0_2" size="4" value="0"/></td>
	<td><input type="text" name="grade_0_3" size="4" value="0"/></td>
	<td><input type="text" name="grade_0_4" size="4" value="0"/></td>
</tr>
<!-- ----------------------- 1 ------------------------------- -->

<tr>
	<th>難易度(中等)</th>
	<th>選擇題</th>
	<th>是非題</th>
	<th>填充題</th>
	<th>簡答題</th>
</tr>
<tr class="tr2">
	<td>總題數</td>
	<td>{$group[1][1]}</td>
	<td>{$group[1][2]}</td>
	<td>{$group[1][3]}</td>
	<td>{$group[1][4]}</td>
<input type="hidden" name="sum_1_1" value="{$group[1][1]}"/>
<input type="hidden" name="sum_1_2" value="{$group[1][2]}"/>
<input type="hidden" name="sum_1_3" value="{$group[1][3]}"/>
<input type="hidden" name="sum_1_4" value="{$group[1][4]}"/>	
</tr>
<tr>
	<td>該題型題數</td>
	<td><input type="text" name="num_1_1" size="4" value="0"/></td>
	<td><input type="text" name="num_1_2" size="4" value="0"/></td>
	<td><input type="text" name="num_1_3" size="4" value="0"/></td>
	<td><input type="text" name="num_1_4" size="4" value="0"/></td>
</tr>
<tr>
	<td>該題型佔分</td>
	<td><input type="text" name="grade_1_1" size="4" value="0"/></td>
	<td><input type="text" name="grade_1_2" size="4" value="0"/></td>
	<td><input type="text" name="grade_1_3" size="4" value="0"/></td>
	<td><input type="text" name="grade_1_4" size="4" value="0"/></td>
</tr>

<!-- ----------------------- 2 ------------------------------- -->
<tr>
	<th>難易度(困難)</th>
	<th>選擇題</th>
	<th>是非題</th>
	<th>填充題</th>
	<th>簡答題</th>
</tr>
<tr class="tr2">
	<td>總題數</td>
	<td>{$group[2][1]}</td>
	<td>{$group[2][2]}</td>
	<td>{$group[2][3]}</td>
	<td>{$group[2][4]}</td>
<input type="hidden" name="sum_2_1" value="{$group[2][1]}"/>
<input type="hidden" name="sum_2_2" value="{$group[2][2]}"/>
<input type="hidden" name="sum_2_3" value="{$group[2][3]}"/>
<input type="hidden" name="sum_2_4" value="{$group[2][4]}"/>	
</tr>
<tr>
	<td>該題型題數</td>
	<td><input type="text" name="num_2_1" size="4" value="0"/></td>
	<td><input type="text" name="num_2_2" size="4" value="0"/></td>
	<td><input type="text" name="num_2_3" size="4" value="0"/></td>
	<td><input type="text" name="num_2_4" size="4" value="0"/></td>
</tr>
<tr>
	<td>該題型佔分</td>
	<td><input type="text" name="grade_2_1" size="4" value="0"/></td>
	<td><input type="text" name="grade_2_2" size="4" value="0"/></td>
	<td><input type="text" name="grade_2_3" size="4" value="0"/></td>
	<td><input type="text" name="grade_2_4" size="4" value="0"/></td>
</tr>
</table>
<p class="al-left"><input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="確定送出"/></p>
	<p class="al-left"><a href="display_exam.php?test_no={$test_no}"><img src="{$tpl_path}/images/icon/return.gif" />返回線上測驗題目列表</a></p>

</form>
</body>
</html>
