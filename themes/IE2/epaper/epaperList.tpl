<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>電子報列表</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
	
{literal}
<script type="text/JavaScript">

function pop(sUrl,sName,sFeature) 
{
	window.remoteWindow = window.open(sUrl,sName,sFeature);
	//window.name = 'rootWindow';
	window.remoteWindow.window.focus();
}

</script>
{/literal}

</head>

<body>

<h1>電子報列表</h1>
<table class="datatable">
<tr>
	<th>期刊</th>
	<th>發布日期</th>
{if $isShowPublish == 1}
	<th>狀態</th>
{/if}
{if $isPublishOn == 1}
	<th>發布設定</th>
{/if}
{if $isDeleteOn == 1}
	<th>刪除</th>
{/if}
</tr>
<!---------------------電子報列表------------------------->
{section name=counter loop=$epaperList}
<tr class="{cycle values=",tr2"}">	
	<td><a href="javascript:pop('{$epaperList[counter].epaper_file_url}','remoteWindow','width=550,height=400,scrollbars,resizable')">第{$epaperList[counter].periodical_cd}期</a></td>
	<td>{$epaperList[counter].d_public_day}</td>
{if $isShowPublish == 1}
	<td>{if $epaperList[counter].if_auto == 'Y'}<span class="imp">已發佈</span>{else}未發布{/if}</td>
{/if}
{if $isPublishOn == 1}
	<form method="post" action="publishEPaper.php">
	<td>				
		<input type="hidden" name="behavior" value="{$behavior}">
		<input type="hidden" name="currentPage" value="{$currentPage}">
		<input type="hidden" name="epaper_cd" value="{$epaperList[counter].epaper_cd}">
		<input type="submit" name="submit" value="發布設定" class="btn">		
	</td>
	</form>
{/if}
{if $isDeleteOn == 1}
    <td><a href="deleteEPaper.php?epaper_cd={$epaperList[counter].epaper_cd}&behavior={$behavior}" onClick="return confirm('確定要刪除此電子報嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>  
{/if}
</tr>
{sectionelse}
<tr><td colspan="2" style="text-align:center;">目前無任何資料</td></tr>
{/section}
<!-------------------------------------------------------->

</table>


</body>
</html>
