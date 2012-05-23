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
		<script type="text/javascript" src="../script/tiny_mce_new/tiny_mce.js"></script>
</head>

<body>
    <div class="formContainer">
<form method="post" action="" name="browsUser"  class="ws-form">
    <input name="id" type="hidden" value="{$service.id}"/>
	<label>服務名稱:</label>
    <input name="name" type="text" value="{$service.name}"/>
    {if $error.name eq true}<span class="form-error">*不可為空</span>{/if}
    <br/>
	<label>class名稱:</label>
    <input name="class" type="text" value="{$service.class}"/>
    {if $error.class eq true}<span class="form-error">*不可為空</span>{/if}
    <br/>
	<label>服務描述:</label>
    <textarea name="description" type="textarea" />{$service.description}</textarea>
    <br/>
	<input name="searchIt" value="儲存" type="submit"/>
    {if $saved eq true}
		<span class="alert">儲存成功</span>
		<script type="text/javascript">
		{literal}
			setTimeout(function(){
				window.location.href="?action=serviceList";
			},2000);
		{/literal}
		</script>
	{/if}
</form>
    </div>
        <script type="text/javascript">
        {literal}
        tinyMCE.init({
            // General options
            mode : "textareas",
            theme : "advanced",
            plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,visualchars,nonbreaking,xhtmlxtras,template",
            width: "600px",
    
            
            // Theme options
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,forecolor,backcolor",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,iespell,media,advhr,fullscreen",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",

        });
        {/literal}
        </script>

</body>
</html>
