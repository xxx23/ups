<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
</head>

<body>
<!-- 標題 -->
<center>教師新增學生</center>
<!-- 內容說明 -->
<div>
<br />
操作說明：<br />
	<font color="#FF0000">1. 檔案上傳請符合格式。</font><span style="background-color:#FFFFCC;" onclick="window.open('./upload_example.htm', null, 'height=200,width=400,status=yes,toolbar=no,menubar=no,location=no');">參考格式</span><br />
	<font color="#FF0000">2. 新增的學生帳號，密碼預設跟帳號相同。</font><br />
	<br />
</div>

<!--功能部分 -->
<form method="post" action="./tea_file_insertStudent.php?action=doupload" enctype="multipart/form-data">
<table>
<tr>
	<td>上傳匯入檔</td>
	<td><input type="file" name="upload_file" /></td>
</tr>
</table>
<br />
<input type="submit" name="submitButton" value="確定匯入" />
</form>
</body>
</html>
