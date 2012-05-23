<html>
<head>
<meta http-equiv="Content-Language" content="zh-tw">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檔案列表</title>
{literal}
<script language="JavaScript">
function OnPreview()
{
	var fname = list.filename;
	if( fname == '' )
		alert( '請選取檔案' );
	else
	{
		preview.src = fname;
	}
}

function OnRefresh()
{
	list.location.reload();
}

function OnUpload()
{
	var top = (window.screen.availHeight - 100) / 2;
	var left = (window.screen.availWidth - 400 ) / 2;
	var child = window.open( "image.php?PHPSESSID=PHPSD&action=uploadpage", "upload", "height=100,width=400,top="+top+",left="+left+",toolbar=no,status=no,menubar=no,location=no" );
}

function OnOK()
{
	var fname = list.filename;
	if( fname == '' )
	{
		alert( '請選取圖檔' );
		return false;
	}
	if( window.name == 'image' )
	{
		window.opener.Image_Paste( 'upload/' + fname );
		window.close();
	}
}
</script>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{/literal}

</head>
<body>

<table border="0" class="datatable">
<tr>
<th nowrap>檔案列表</th>
<th nowrap>預覽區</th>
</tr>
<tr>
<td valign="top">
<iframe id="list" width="325" height="210" src="list_img.php"></iframe>
<br>
<input class="btn" type="button" value="更新列表" onClick="OnRefresh();"> 
<input class="btn" type="button" value="上傳圖片" onClick="OnUpload();">
<input class="btn" type="button" value="[ 確定 ]" onClick="OnOK();">
<input class="btn" type="button" value=" 取消 " onClick="window.close();">
</td>
<td valign="top">
<input class="btn" type="button" value="預覽圖片" onClick="OnPreview();">
<p><img id="preview" src="{$webroot}images/p1.gif"></p>
</td>
</tr>
</table>
</body>
</html>
