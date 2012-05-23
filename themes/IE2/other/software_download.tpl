<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />
<title>Software Download</title>
</head>

<body>
<h1>下載區</h1><div class="describe"> 小提示：若您的瀏覽器無法正常支援，可依需求下載更新您的軟體。</div><br/>
<table width="80%" border="0" align="center" >
{foreach item=image from=$images}
  <tr>
    <td width="5%" align="center" style="border-bottom: 1px dashed #808080"><img src="../images/308.gif" /></td>
    <td width="38%" align="center" style="border-bottom: 1px dashed #808080"><div align="center"><a target="_blank" href="{$image.link}">{html_image file=$image.file}</a></div></td>
    <td width="57%" style="border-bottom: 1px dashed #808080">{$image.title}</td>
  </tr>
{/foreach}
</table>


</body>
</html>
