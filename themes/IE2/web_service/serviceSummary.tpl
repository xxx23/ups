<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Service</title>
		<link type="text/css" href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" />
		<link type="text/css" href="{$tpl_path}/css/content_course.css" rel="stylesheet" />
		<link type="text/css" href="{$webroot}/css/webservice.css" rel="stylesheet" />
        <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
		<link type="text/css" href="../css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet">
		<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
</head>

<body>
<h1>API說明</h1>
<hr/>
<div class="searchlist">
{foreach from=$services item=service}
	<table class="datatable ws-table">
        <tr>
            <th>服務名稱</th>
            <td>{$service.name}</td>
            
        </tr>
        <tr>
             <th>WSDL網址</th>
            <td>{$homeurl}{$webroot}Web_Service/api.php?wsdl&service={$service.class}</td>
            
        </tr>
        <!--tr>
             <th>服務網址:</th>
            <td>{$homeurl}{$webroot}Web_Service/api.php?service={$service.class}</td>
            
        </tr-->
        <tr>
            <td colspan="2">
             服務描述:{$service.description}
            </td>      
        </tr>
    </table>
{/foreach}
</div>
</body>
</html>
