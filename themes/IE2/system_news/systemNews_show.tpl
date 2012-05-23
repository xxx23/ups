<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">



<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />



<title>公告</title>

</head>

<body>

iifiasdfkasskldiii

<h1>{if $isShowCourse == 1}課程公告{else}最新消息{/if}</h1>

{if $isNewOn == 1}

	<a href="systemNews_new.php?incomingPage={$currentPage}{$newArgument}">新增公告</a>

{/if}

<table class="datatable">

<tr>

  <th scope="col" class="ZtoA">公告日期 </th>

{if $isShowCourse == 1}

  <th scope="col">課程名稱</th>

{/if}

  <th scope="col">標題</th>

  <th scope="col">瀏覽次數</th>

{if $isModifyOn == 1}

  <th scope="col"></th>

{/if}

{if $isDeleteOn == 1}

  <th scope="col"></th>

{/if}

</tr>

{section name=counter loop=$newsList}



<!----------------------------BEGIN:公告的標頭------------------------->

{if $newsList[counter].level == "最低"}

<tr class="word"> 

{elseif $newsList[counter].level == "中等"}

<tr class="word"> 

{elseif $newsList[counter].level == "最高"}

<tr class="word"> 

{/if}



	<td width="68" height="18">{$newsList[counter].date}</td>

{if $isShowCourse == 1}

	<td width="68">{$newsList[counter].courseName}</td>

{/if}

	<td width="228">{$newsList[counter].subject}{if $newsList[counter].new == 1}<img src="{$imagePath}/icon/new.gif">{/if}</td>

	<td width="110" align="center" id="viewNum_{$newsList[counter].news_cd}">{$newsList[counter].viewNum}</td>

{if $isModifyOn == 1}

	<form method="post" action="systemNews_modify.php">

		<input type="hidden" name="news_cd" value="{$newsList[counter].news_cd}">

		<td valign="top"> <div align="center"><input type="submit" name="submit" value="修改"></div></td>

	</form>

{/if}

{if $isDeleteOn == 1}

	<form method="post" action="systemNews_delete.php">

		<input type="hidden" name="news_cd" value="{$newsList[counter].news_cd}">

		<td valign="top"> <div align="center"><input type="submit" name="submit" onclick="return confirm('確定要刪除此公告嗎?')" value="刪除"></div></td>

	</form>

{/if}

</tr>

{*<!----------------------------END:公告的標頭---------------------------->

<!----------------------------BEGIN:公告的內容-------------------------->*}

<tr id="news_content_tr_{$newsList[counter].news_cd}">

{if $isShowCourse == 0}

	{if $isModifyOn == 0 && $isDeleteOn == 0}

	<td colspan="4" id="news_content_td_{$newsList[counter].news_cd}">

	{elseif $isModifyOn == 1 && $isDeleteOn == 1}

	<td colspan="6" id="news_content_td_{$newsList[counter].news_cd}">

	{else}

	<td colspan="5" id="news_content_td_{$newsList[counter].news_cd}">

	{/if}

{else}

	{if $isModifyOn == 0 && $isDeleteOn == 0}

	<td colspan="5" id="news_content_td_{$newsList[counter].news_cd}">

	{elseif $isModifyOn == 1 && $isDeleteOn == 1}

	<td colspan="7" id="news_content_td_{$newsList[counter].news_cd}">

	{else}

	<td colspan="6" id="news_content_td_{$newsList[counter].news_cd}">

	{/if}

{/if}

		<strong>公告發佈者：{$newsList[counter].personal_name}</strong>

		<h4>公告內文：</h4>

{if $newsList[counter].showContent == 1}

		<p class="inner">{$newsList[counter].content}</p>

{/if}



{if $newsList[counter].showFile == 1}

		<p class="inner">檔案：<a href="{$newsList[counter].fileUrl}"  target="_blank">{$newsList[counter].fileName}</a></p>

{/if}



{if $newsList[counter].showUrl == 1}

		<p class="inner">網址：{$newsList[counter].url}</p>

{/if}



	</td>

</tr>

<!----------------------------END:公告的內容------------------------------------->

{/section}



</table>





{literal}	

<script type="text/javascript">

//滑鼠移過去的特效



var rows = document.getElementsByTagName('tr');

for (var i = 0; i < rows.length; i++)

{

	rows[i].onmouseover = function() {	this.className += ' hilite';	}

	rows[i].onmouseout = function() {	this.className = this.className.replace('hilite', '');	}

}

</script>

{/literal}





</body>

</html>

