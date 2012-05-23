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
<h1>API權限管理</h1>
<hr/>
<div class="searchlist">
    {if $saved eq true}<span class="alert">儲存成功</span>{/if}
    <form method="post" action="?action=servicePermission" class="">
    <div align="right">
        <input type="submit" name="submitit1" value="儲存" />
     </div>
    <table class ="datatable">
            <thead> 
                     {foreach from=$categories item=category}
                    <th>{$category}</th>
                    {/foreach}
            </thead>
            <tbody>
                {foreach from=$permissions key=service_id item=categories name=pem }
                <tr>
                   <th> {$services[$smarty.foreach.pem.index]}</th>
                    {foreach from=$categories key=category item=haspermission}
                    <td><input type="checkbox" name="permissions[{$service_id}][{$category}]" value ="1" {if $haspermission eq 1}checked{/if}/></td>
                    {/foreach}
                </tr>
                {/foreach}  
            </tbody>
        </table>
     <div align="right">
        <input type="submit" name="submitit1" value="儲存" />
     </div>
    </form>
</div>
</body>
</html>
