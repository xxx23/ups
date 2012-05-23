<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation step 2.</title>
<link href="../tabs.css" rel="stylesheet" type="text/css" />
<link href="../css/content.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />
<link href="../form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">

function prev_step()
{
	location.href = "install2.php";
}

function next_step()
{
	location.href = "install4.php";
}
</script>
{/literal}
</head>

<body><br /><br />
	<center>
	<h1>Installation Process - step 3.</h1>
	
	下方四個資料夾為config.php中定義您存放檔案的位置，<br />
	分別定義教材、題庫、測驗、問卷、個人筆記本等資料要存放在哪些地方。<br />
	這些資料夾必須擁有網頁寫入權限，請以root身分執行下表所列指令，確保這些資料夾運作無誤。<br />
	執行完指令後，可按下"重新整理"，確保資料夾皆可寫入。<br /><br />
	<table border="1" class="datatable" style="width:650px;">
	<caption>檔案資料夾寫入權限</caption>
	<tr>
		<td>{$DATA_FILE_PATH}</td>
		<td>{$DATA_FILE_PATH_WRITE}</td>
	</tr>
	<tr>
		<td>{$MEDIA_FILE_PATH}</td>
		<td>{$MEDIA_FILE_PATH_WRITE}</td>
	</tr>
	<tr>
		<td>{$COURSE_FILE_PATH}</td>
		<td>{$COURSE_FILE_PATH_WRITE}</td>
	</tr>
	<tr>
		<td>{$PERSONAL_PATH}</td>
		<td>{$PERSONAL_PATH_WRITE}</td>
	</tr>
	<tr>
		<td>{$SCORM_PATH}</td>
		<td>{$SCORM_PATH_WRITE}</td>
	</tr>
	<tr>
		<td>{$SHARE_PATH}</td>
		<td>{$SHARE_PATH_WRITE}</td>
	</tr>

	</table>
	<br />
	<input type="button" value="重新整理" onclick="location.reload();" />
	<br /><br /><br />
	<table border="1" class="datatable" style="width:650px;">
	<caption>請執行以下指令：</caption>
	<form method="POST" action="install3.php">
        <tr><td colspan="2"><font color="#FF0000"><br>{$command}</font><br>(執行完此指令不必再執行以下指令，此執行檔包含以下指令)</td></tr>	
{*
<tr>
	<td>新增電子報定期發送：</td>
	<td><font color="#FF6600">{$script13}</font></td>
</tr>
<tr>
	<td>更改樣板暫存資料夾群組為www (註linux常為www-dist)：</td>
	<td><font color="#FF6600">{$script1}</font></td>
</tr>
<tr>
	<td>允許樣板暫存資料夾網頁群組寫入權限：</td>
	<td><font color="#FF6600">{$script2}</font></td>
</tr>
<tr>
	<td>允許DATA_FILE_PATH網頁群組寫入權限：</td>
	<td><font color="#FF6600">{$script3}</font><br>
	<font color="#FF6600">{$script4}</font></td>
</tr>
<tr>
	<td>允許MEDIA_FILE_PATH網頁群組寫入權限：</td>
	<td><font color="#FF6600">{$script5}</font><br>
	<font color="#FF6600">{$script6}</font></td>
</tr>
<tr>
	<td>允許COURSE_FILE_PATH網頁群組寫入權限：</td>
	<td><font color="#FF6600">{$script7}</font><br>
	<font color="#FF6600">{$script8}</font></td>
</tr>
<tr>
	<td>允許PERSONAL_PATH網頁群組寫入權限：</td>
	<td><font color="#FF6600">{$script9}</font><br>
	<font color="#FF6600">{$script10}</font></td>
</tr>
<tr>
	<td>修改config.php權限：</td>
	<td><font color="#FF6600">{$script11}</font><br>
	<font color="#FF6600">{$script12}</font></td>
</tr>
*}
</table>
	<br /><br />
	<!-- input type="button" value="上一步" onclick="prev_step();" --> 
	<input type="button" value="下一步" onclick="next_step();"> 
	<br /><br/>
	</form>
<!--	<a href="install1.php">步驟1.</a>&nbsp;&nbsp;步驟2.
	<a href="install3.php">步驟3.</a>-->
	</center>
</body>
</html>
