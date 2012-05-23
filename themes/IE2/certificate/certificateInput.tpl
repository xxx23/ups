<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>設定成績單</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}

<script type="text/JavaScript">

function pop(sUrl,sName,sFeature) 
{
	//window.name = 'rootWindow';
	window.remoteWindow = window.open(sUrl,sName,sFeature);
	window.remoteWindow.window.focus();
}

</script>

<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script>
/*
	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "content",
plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu",
theme_advanced_buttons1_add_before : "save,separator",
theme_advanced_buttons3_add_before : "fontselect,fontsizeselect",
theme_advanced_buttons3_add : "preview,zoom,separator,forecolor,backcolor",
theme_advanced_buttons2_add: "cut,copy,paste,separator,replace,separator",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_path_location : "bottom",
theme_advanced_resizing : true,
plugin_insertdate_dateFormat : "%Y-%m-%d",
plugin_insertdate_timeFormat : "%H:%M:%S",
extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
external_link_list_url : "example_data/example_link_list.js",
external_image_list_url : "example_data/example_image_list.js",
flash_external_list_url : "example_data/example_flash_list.js"
});
*/
</script>

{/literal}

</head>

<body>

<fieldset>
<legend><h1>設定證書</h1></legend>
	
	<table class="datatable">	
	<form method="POST" enctype="multipart/form-data" action="setupCertificateSave.php">

	<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}">
	<tr>
		<td colspan="2"><font color="blue">請依照下列步驟完成成績單設定</font></td>
	</tr>

	<tr>
		<td><font color="red">1.設定外框</font></td>
		<td>
			{if $action=="modify"}
			<input type="radio" name="outerType" value="-1" checked="checked"/>使用原樣式
			<a href="{$outerFile}">原圖片</a>
			{/if}
			<br>
			<input type="radio" name="outerType" value="1" {if $action=="new"}checked="checked"{/if}/>使用內建樣式
			<select name="outerTemplateNumber">
				<option value="1" selected>樣式1</option>
			</select>
			<!--
			<a href="javascript:pop('templateList.php','remoteWindow','width=550,height=400,scrollbars,resizable')">觀看樣式</a>
			-->
			<br />
			
			<input type="radio" name="outerType" value="2"/>自行上傳樣式
			<input type="file" name="outerFile" />	(800x1100)(jpg)
			
		</td>
	</tr>
	
	<tr>
		<td><font color="red">2.設定背景浮水印</font></td>
		<td>
			{if $action=="modify" && $isUsebackgroundFile == 1}
			<input type="radio" name="backgroundType" value="-1" checked="checked"/>使用原樣式
			<a href="{$backgroundFile}">原圖片</a>
			<br>
			{/if}
					
			<input type="radio" name="backgroundType" value="0" {if $action=="new" || $isUsebackgroundFile == 0}checked="checked"{/if}/>不使用浮水印
			<br>
			
			<input type="radio" name="backgroundType" value="1"/>使用浮水印
			<input type="file" name="backgroundFile" />	(450x600)(jpg)
		</td>
	</tr>
	
	<tr>
		<td><font color="red">3.設定內容</font></td>
		<td><div class="imp">學員名稱請用：%NAME<br>課程名稱請用：%COURSE</div><br>
		
			上面:<br>
			<textarea name="content1" rows="6" cols="60">{$content1}</textarea><br><br>
			
			中間:<br>
			<textarea name="content2" rows="6" cols="60">{$content2}</textarea><br><br>
			
			下面:<br>
			<textarea name="content3" rows="6" cols="60">{$content3}</textarea><br>
		</td>
	</tr>
	</table>
	
	<P class="al-left">
		<input type="submit" value="設定" class="btn"> 
		<input type="reset"  value="清除" name="reset" class="btn">
	</P>	
</form>
</fieldset>



</body>
</html>
