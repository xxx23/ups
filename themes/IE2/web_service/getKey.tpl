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
                <style>
                    {literal}
                    .apikey
                    {
                        width:90%;
                        font-size:18px;
                        
                        margin:20px;
                    }
                    
                    .apikey span.key
                    {
                        padding:5px;
                       background:#fe9a2e;
                       color: white;
                    }
                    .apikey span.value
                    {
                        padding:5px;
                       background: #ffef8f;
                       color: red;
                      
                    }
                    {/literal}
                </style>
</head>

<body>
<h1> API Key管理</h1>

<div calss="searchlist">
    {if $apiKey eq ''}
    <h1>申請API</h1>
    <form method="post" action="?action=index" name="browsUser" class="ws-form">
        <label>請填入你使用API的用途:</label>
        <textarea name="usage" type="textarea" /></textarea>
        {if $errors.usage eq true}<span class="error">*不可為空白</span>{/if}
        <input name="searchIt" value="送出申請" type="submit"/>
    </form>
    {elseif $status eq 0}
        <span class="alert">API KEY 申請審核中</span>
    {else}
    <div class="apikey">
        <span class="key">API Key</span><span class="value">{$apiKey}</span>
       <p>
       為了維護貴單位的權益，此API Key請妥善保管。
       </p>
    </div>
  
        <div>
            <h1>api使用方法</h1>
            {if $category eq 1}
                <a href="../manual/ws_city_menu.pdf">按我下載</a>
            {elseif $category eq 2} 
                <a href="../manual/ws_university_menu.pdf">按我下載</a>
            {elseif $category eq 3}
                <a href="../manual/ws_doc_menu.pdf">按我下載</a>
            
            {/if}
        </div>
    {/if}
    
</div>
</body>
</html>
