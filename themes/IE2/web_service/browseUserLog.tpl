<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Service</title>
		<link type="text/css" href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" />
		<link type="text/css" href="{$tpl_path}/css/content_course.css" rel="stylesheet" />
		<link type="text/css" href="{$web_root}css/webservice.css" rel="stylesheet" />
        <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
		<link type="text/css" href="../css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet">
		<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
		var WEBROOT = '{$webroot}';
		{literal}
		$(document).ready(function(){
			$("#start_time").datepicker({dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true, showOn: 'button', buttonImage: WEBROOT + 'images/calendar.gif'});
			$("#end_time").datepicker({dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true, showOn: 'button', buttonImage: WEBROOT + 'images/calendar.gif'});
		});
		{/literal}
		</script>
</head>

<body>
<h1>API使用紀錄</h1>

<div class="searchbar">
<form method="post" action="" name="browsUser">
	<label>服務名稱:</label>
    <select name="service">
	<option value="">全部</option>
    {html_options values=$services_values output=$services_outputs selected=$services_sel }
    </select>
    <label>訊息級別:</label>
    <select name="level">
    {html_options values=$levels output=$levels selected=$levels_sel }
    </select>
    <br/>
    <label>起始時間:</label>
    <input id="start_time" name="start" type="text" value="{$start}" />
    <label>結束時間:</label>
    <input id="end_time" name="end" type="text" value="{$end}" />
    <input name="searchIt" value="搜尋" type="submit">
</form>
</div>
<hr/> 	
<div class="searchlist">
    <table class ="datatable">
        <thead> 
            <th>時間</th>
            <th>服務名稱</th>
            <th>API Key</th>
            <th>訊息級別</th>
            <th>訊息</th>            
        </thead>
        <tbody>
		{foreach from=$logs item=log}
            <tr>
                <td>{$log.timestamp}</td>
                <td>{$log.service_id}</td>
                <td>{$log.api_key}</td>
                <td>{$log.level}</td>
                <td>{$log.message}</td>
            </tr>
		{foreachelse}
		<tr><td colspan="5" align="center">無資料</td></tr>
		{/foreach}
        </tbody>
    </table>
</div>
</body>
</html>
