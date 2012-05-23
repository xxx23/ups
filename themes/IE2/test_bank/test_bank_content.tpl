<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>題庫管理頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$tpl_path}/script/test_bank/test_related.js"></script>
<script type="text/JavaScript">
{literal}
function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
		var tmp = document.getElementsByTagName("p")[0];
		tmp.replaceChild(document.createTextNode("目前所在位置: 題庫管理 >> 題目瀏覽"), tmp.firstChild);
	}
	else if(option == 2){
		document.getElementById("inner_contentB").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabB";
		var tmp = document.getElementsByTagName("p")[0];
		tmp.replaceChild(document.createTextNode("目前所在位置: 題庫管理 >> 新增題目"), tmp.firstChild);
	}
}
</script>

<style type="text/css">
li.tabA	{cursor:pointer;}
li.tabB	{cursor:pointer;}
</style>
{/literal}

<title>檢視題庫內容</title>
</head>
<body class="ifr" id="tabA">
	<p class="address">目前所在位置: 學習活動 >> 測驗 >>  題庫管理 >> 題目瀏覽</p>
	[題庫管理工具]<span class="imp">{$status}</span>
	<div class="tab">
		<ul id="tabnav">
    	    <li class="tabA" onClick="display(1)">題目瀏覽</li>	
			<li class="tabB" onClick="display(2)">新增題目</li>
    	</ul>
	</div>
	<div class="inner_contentA" id="inner_contentA">
    <fieldset>
		<legend>
		<h1>題庫<span class="imp">{$title}</span>內容如下：</h1></legend>
		共存在<span class="imp">{$test_num}</span>筆題目
		<form method="POST" action="">
		<table class="datatable">
			<tr>
				<th>題號索引</th> 
				<th>題型</th> 
				<th>題目描述</th>
				<th>修改題目</th>
				<th>檢視題目</th>
				<th>刪除此題</th>
			</tr>
			{foreach from = $content item = element name=contentloop}
			<tr class="{cycle values=" ,tr2"}">
				<td>{$smarty.foreach.contentloop.iteration}</td>
				<td>{$element.test_type_name}</td>
				<td>{$element.question|truncate:100:" ...":true}</td>
				<td><a href="./modify_test.php?test_bankno={$element.test_bankno}"><img src="{$tpl_path}/images/icon/edit.gif"></a></td>
				<td><a href="./show_test.php?test_bankno={$element.test_bankno}"><img src="{$tpl_path}/images/icon/question.gif" width="19" height="19" border="0"/></a></td>
				<td>
				<img src="{$tpl_path}/images/icon/delete.gif" width="19" height="19" border="0" onClick="return delete_test({$element.test_bankno})" style="cursor:hand;"/></td>
				</tr>
			{foreachelse}
				<tr><td colspan="6">目前此題庫下沒有任何題目</td></tr>
			{/foreach}
			</table>
			<br><br>	
			<a href="./test_bank.php"><img src="{$tpl_path}/images/icon/return.gif">返回題庫選擇頁面</a>
	<!--<input type= "button" name = "" value="返回教材題庫頁面" onClick="window.location='./test_bank.php';">-->
		</form>
		</fieldset>
	</div>
		
	<div class="inner_contentB" id="inner_contentB" style="display:none;">
		<fieldset>
		<legend><h1>新增題目</h1></legend>
		<select name="type" onChange="selectTestType(this.selectedIndex);">
			<option value = "0" > 請選擇題型 </option>
			<option value = "1" > 選擇題 </option>
			<option value = "2" > 是非題 </option>
			<option value = "3" > 填充題 </option>	
			<option value = "4" > 簡答題 </option>
		</select>
		<br/><br/><a href="./test_bank.php"><img src="{$tpl_path}/images/icon/return.gif">返回題庫選擇頁面</a>
		</fieldset>
	</div>
		

</body>
</html>
