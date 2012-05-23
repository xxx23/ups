<html>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>select test</title>
<head>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>修改測驗名稱與比例</h1>
<p class="intro"> 「自我評量」不納入計分項目，配分為零。此為系統設定，無法更改。</p>
<table class="datatable" style="width:300px;">
<form method='GET' action="modify_exam.php">
	<tr>
		<td>測驗名稱：</td>
	    <td><input name="name" type="text" id="examName" value="{$test_name}" size="20"/></td>
	</tr>
<!--	<tr>
		<td><div id="name_msg" style="color:red">(必填)</div></td>
	</tr>-->
	<tr>
		<td>測驗類型：		</td>
	    <td><select name="type" onChange="typeChange(this.selectedIndex);">
			<option value="1" {$select[0]}>自我評量</option>
			<option value="2" {$select[1]}>正式測驗</option>
		</select></td>
	</tr>
<!--	<tr><td><span id="score_str"/></td></tr>
	<tr><td><div id="score_msg" style="color:red"/></td></tr>-->
	<tr><td>測驗配分：</td>
	  <td><input type="text" size="4" name="score" id="score_input" value="{$test_percentage}"/>%</td>
	</tr>
	<tr>
		<td colspan="2"><p class="al-left">
		<input type='reset' class="btn" value='清除資料'/>
		<input type='submit' class="btn" id="submit_button" value='確定送出'/>		
	    <input type="hidden" name="test_no" value="{$test_no}"/><input type="hidden" name="option" value="modify"/></p>	</td>
    </tr>
</form>
</table>

<p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上測驗列表</a></p>

</body>

</html>
