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
<h1>API管理</h1>
<hr/>
<div class="searchlist">
    <div align="right">
    <button id="addService" onclick="javascript:window.location.href='?action=serviceDetail'">新增服務</button>
    </div>
   <table class ="datatable">
        <thead> 
            <th>服務名稱</th>
            <th>class名稱</th>
            <th>狀態</th>
            <th>服務描述</th>
            <th>操作</th>
        </thead>
        <tbody>
        {foreach from=$services item=service}
            <tr>
                <td>{$service.name}</td>
                <td>{$service.class}</td>
                <td>
                {if $service.status eq 0}
                    <a href="?action=activeService&id={$service.id}">不開放</a>
                {else}
                    <a href="?action=deactiveService&id={$service.id}">開放</a>
                {/if}
                </td>
                <td>
                    <a href="?action=serviceDetail&id={$service.id}" >編輯</a>
                </td>
                <td>
                    <a href="?action=serviceDetail&id={$service.id}" >編輯</a>
                    <a href="#" onclick="if(confirm('確定刪除?'))window.location.href ='?action=removeService&id={$service.id}'" >刪除</a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
</body>
</html>
