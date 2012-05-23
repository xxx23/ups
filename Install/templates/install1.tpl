<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Installation step 1.</title>
	
	<link href="../tabs.css" rel="stylesheet" type="text/css" />
	<link href="../css/content.css" rel="stylesheet" type="text/css" />
	<link href="../css/table.css" rel="stylesheet" type="text/css" />
	<link href="../form.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/javascript">
function next_step() {location.href = "install2.php";}
</script>
{/literal}

</head>

<body>
<br/>
<br/>
<div align="center">
<h1>Installation Process - step 1.</h1>
<table class="datatable" border="1" style="width:400px;">
<caption>系統軟體</caption>
<tr>
	<td>PHP 5以上的版本</td>
	<td>{$PHP_version}</td>
</tr>
<!-- tr>
	<td>Smarty樣本引擎</td>
   <td>{$Smarty_template}</td>
</tr>
<tr>
	<td>PEAR DB套件</td>
	<td>{$PEAR_DB}</td>
</tr -->
<tr>
	<td>rar套件</td>
	<td>{$rar_package}</td>
</tr>
<tr>
	<td>mysql資料庫</td>
	<td>{$Mysql_DB}</td>
</tr>
</table>
<br>
<br>
<table class="datatable" border="1" style="width:400px;">
<caption>PHP延伸套件</caption>
<tr>
	<td>php5-dom</td>
	<td>{$dom}</td>
</tr>
<tr>
	<td>php5-ctype</td>
	<td>{$ctype}</td>
</tr>
<tr>
	<td>php5-iconv</td>
	<td>{$iconv}</td>
</tr><tr>
	<td>php5-mbstring</td>
	<td>{$mbstring}</td>
</tr><tr>
	<td>php5-pcre</td>
	<td>{$pcre}</td>
</tr><tr>
	<td>php5-session</td>
	<td>{$session}</td>
</tr><tr>
	<td>php5-gettext</td>
	<td>{$gettext}</td>
</tr>
<!--<tr>
	<td>php5-readline</td>
	<td>{$readline}</td>
</tr>-->
<tr>
	<td>php5-mysql</td>
	<td>{$mysql}</td>
</tr>
<tr>
	<td>php5-zlib</td>
	<td>{$zlib}</td>
</tr>
<tr>
        <td>php5-mcrypt</td>
        <td>{$mcrypt}</td>
</tr>
</table>
<br><br>
<table class="datatable" border="1" style="width:400px;">
<caption>php.ini相關參數</caption>
<tr>
	<td>magic_quotes_gpc</td>
	<td>{$magic_gpc}</td>
</tr>
<tr>
	<td>register_globals</td>
	<td>{$register_globals}</td>
</tr>
<tr>
	<td>session.use_only_cookies</td>
	<td>{$session_use_only_cookies}</td>
</tr>
<tr>
	<td>post_max_size (POST傳遞最大檔案限制)</td>
	<td>{$post_max_size}</td>
</tr>
<tr>
	<td>upload_max_filesize (上傳檔案大小限制)</td>
	<td>{$upload_max_filesize}</td>
</tr>
<tr>
	<td>max_execution_time (一支PHP最大執行時間,單位：秒)</td>
	<td>{$max_execution_time}</td>
</tr>
<tr>
	<td>max_input_time (處理POST,GET,UPLOAD最大時間,單位：秒)</td>
	<td>{$max_input_time}</td>
</tr>
</table>
<form action="install2.php" method="POST">
<input type="hidden" name="stage" value="<?php echo $stage['current'];?>">
<input type="button" value="下一步" onClick="next_step();">
</form>
<!--
步驟1.&nbsp;&nbsp;<a href="install2.php">步驟2.</a>&nbsp;&nbsp;
	<a href="install3.php">步驟3.</a>
-->
</div>
</body>
</html>
