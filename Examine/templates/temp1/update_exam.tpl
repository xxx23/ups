<!-- 作者：吳朋憲 
	在這裡應得到課程的ID 教師的ID
-->
<html>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>select test</title>
<head>

<style type="text/css">
<!--
@import url(css/newExam.css);
-->
</style>

<script type="text/javascript" charset="utf-8" src="script/exam_relation.js">
<!--
-->
</script>
</head>

<body>
<center>製作測驗</center>
<br/>
<div align='center'>
<table>
<form method='POST' action="tea_examine_info.php">
	<tr>
		<td>請輸入測驗名稱：<input type="text" name="name" id="examName" width="6"/></td>
	</tr>
	<tr>
		<td>請選擇測驗類型：
		<select name="type" onChange="typeChange(this.selectedIndex);">
			<option value="1">自我評量</option>
			<option value="2">正式測驗</option>
		</select></td>
	</tr>
	<tr>
	  <td>請輸入配分：<input type="text" name="score" size="3"/>&nbsp;%</td>
	</tr>
	<tr>
		<td><input type='submit' id="submit_button" value="進入試題編輯介面"/>&nbsp;<input type='reset' value='重新輸入'/></td>
	</tr>
</form>
</table>
</div>
</body>

</html>
