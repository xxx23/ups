<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<h1>設定成績單</h1>
<table class="datatable">
  <caption>
  請依照下列步驟完成成績單設定
  </caption>
  <form method="POST" enctype="multipart/form-data" action="setupGradeReportSave.php">
    <tr>
      <th>1.設定成績單背景</th>
      <td><input type="radio" name="backgroundType" value="1" checked="checked"/>
        使用內建樣式
        <select name="backgroundTemplateNumber">
          <option value="1" selected>樣式1</option>
        </select>
        <a href="javascript:pop('templateList.php','remoteWindow','width=550,height=400,scrollbars,resizable')">觀看樣式</a> <br />
        <input type="radio" name="backgroundType" value="2"/>
        上傳背景樣式
        <input type="file" name="backgroundFile" />
        (800x1100)(jpg) </td>
    </tr>
    <tr>
      <th>2.設定內容</th>
      <td><textarea name="content" wrap="off" cols="60" rows="30" style="width:600"></textarea>
        <br />
        <strong> 學生姓名的地方請填入:%STUDENT_NAME <br />
        總成績的地方請填入:%TOTAL_GRADE <br />
        課程名稱的地方請填入:%COURSE_NAME <br />
        列印的年份請填入:%YEAR <br />
        列印的月份請填入:%MONTH <br />
        列印的日期請填入:%DAY </strong> </td>
    </tr>
    <tr>
      <td colspan="2"><p class="al-left">
          <input type="reset"  value="清除資料" name="reset" class="btn">
          <input type="submit" value="確定送出" class="btn">

          <!--
			<input type="button" value="預覽" onclick="act('sea','one','fa80d6036a976d4a58185fd4f84329a4','true')">
			-->
        </p></td>
    </tr>
  </form>
</table>
</body>
</html>
