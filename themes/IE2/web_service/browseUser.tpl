<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <title>Web Service</title>
		<link type="text/css" href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" />
		<link type="text/css" href="{$tpl_path}/css/content_course.css" rel="stylesheet" />
		<link type="text/css" href="{$webroot}/css/webservice.css" rel="stylesheet" />
        <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
		<link type="text/css" href="../css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet">
		<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
</head>
    </head>
<body>
<h1>API使用者管理</h1>

<div class="searchbar">
<form method="post" action="?action=browseUser" name="browsUser">
	<label>帳號:</label>
    <input name="account" type="text" value="{$search_name}"/>
    <label>類別:</label>
    <select name="category">
    {html_options values=$category_keys output=$category_values selected=$category_sel}
    </select>
    <input name="searchIt" value="搜尋" type="submit"/>
</form>
</div>
<hr/>
<div class="searchlist">
    <table class ="datatable">
        <thead> 
            <th>使用者(帳號)</th>
            <th>類別</th>
            <th>apikey</th>
            <th>使用記錄</th>
        </thead>
        <tbody>
        {foreach from=$users item=user}
            <tr>
                <td>{$user.org_title}({$user.account})</td>
                <td>{$user.category}</td>
                <td>{$user.api_key}</td>
                <td><a href="?action=browseUserLog&api_key={$user.api_key}">查閱</td>
            </tr>
        {foreachelse}
            <tr><td colspan="4">無資料</td></tr>
        {/foreach}
        </tbody>
    </table>
</div>
</body></html>
