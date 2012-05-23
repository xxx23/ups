<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation step 4.</title>
<link href="../tabs.css" rel="stylesheet" type="text/css" />
<link href="../css/content.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />
<link href="../form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">

function prev_step()
{
	location.href = "install3.php";
}

function next_step()
{
	location.href = "install5.php";
}

</script>
{/literal}
</head>

<body><br /><br />
	<center>
	<h1>Installation Process - step 4.</h1>

	<center>
	請確定資料庫相關帳號密碼新增完畢，且config.php中定義的上述資料庫欄位正確。<br /><br />
	<table border="1" class="datatable" style="width:550px;">
	<caption>匯入資料庫欄位</caption>
	<tr>
		<td>匯入系統資料庫欄位</td>
		<td>{$schema_all}</td>
	</tr>
	<tr>
		<td>匯入管理者選單</td>
		<td>{$lrtmenu_}</td>
	</tr>
	<tr>
		<td>匯入初始角色編號</td>
		<td>{$lrtrole_}</td>
	</tr>
    <tr>                                                           
        <td>匯入初始開課類別</td>                                  
        <td>{$lrtunit_basic_}</td>                                 
    </tr>              
	<tr>
		<td>匯入功能選單</td>
		<td>{$tracking_function_menu}</td>
	</tr>
	<tr>
		<td>匯入系統選單</td>
		<td>{$tracking_system_menu}</td>
	</tr>
	<tr>
		<td>匯入系統選單-2</td>
		<td>{$lrtstorecd_basic_}</td>
	</tr>
	<tr>
		<td>匯入角色選單</td>
		<td>{$menu_role}</td>
	</tr>
	<tr>
		<td>匯入系統選單-3</td>
		<td>{$lrtcourse_classify_}</td>
	</tr>
	<tr>
		<td>匯入聊天室相關資料</td>
		<td>{$lchat_settings}</td>
	</tr>
	<tr>
		<td>匯入縣市名稱</td>
		<td>{$location}</td>
	</tr>
	<tr>
		<td>匯入教材設定</td>
		<td>{$mdl_modules}</td>
	</tr>

	</center>
	</table>
	</form>
	
	<br /><br />
	<input type="button" value="上一步" onclick="prev_step();"> 
	<input type="button" value="下一步" onclick="next_step();"> 
	<br /><br/>
	</form>
	</center>
</body>
</html>
