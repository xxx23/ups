<html xmlns="http://www.w3.org/1999/xhtml">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>公告</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<link type="text/css" href="{$webroot}css/ui.core.css" rel="stylesheet" />

<link type="text/css" href="{$webroot}css/ui.tabs.css" rel="stylesheet" />

<link type="text/css" href="{$webroot}css/ui.theme.css" rel="stylesheet" />

<script type="text/javascript" src="{$webroot}script/jquery-1.3.2.js"></script>

<script type="text/javascript" src="{$webroot}script/ui.core.js"></script>

<script type="text/javascript" src="{$webroot}script/ui.tabs.js"></script>



{literal}

<style>

.news_subject{

cursor: hand;

}

</style>

<script type="text/javascript">

	$(document).ready(function(){

		$("#tabs").tabs();



		//bind click event 

		$(".news_subject").bind("click", function(e){

			var news_cd_arr = this.id.split('-');

			var news_cd = news_cd_arr[1];

			var course_type_id = null ;

			if( news_cd_arr[2] != null) { 

			// 主要是因為有一個所有課程裡面的公告會跟各種纇混雜在一起所以 id用後面再用 - course_type分開

			// 所以index的時候要注意 

				course_type_id = '-' + news_cd_arr[2];

			}else{

				course_type_id = '';

			}

			if(	$('#news_detail_content_tr-'+ news_cd + course_type_id ).css('display') == 'none'){

				$('#news_detail_content_tr-'+ news_cd + course_type_id ).css('display','');

				updateViewNum(news_cd);

			}else {

				$('#news_detail_content_tr-'+ news_cd + course_type_id ).css('display', 'none');

			}

		});

	});





//增加瀏覽次數Request

function updateViewNum(news_cd)

{

	$.post(

		'ajax_showList_updateViewNum.php',

		{news_cd:news_cd},

		function(data){//增加瀏覽次數Reponse

			$('.viewNum_'+news_cd).html(data.viewNum);

		}, 

		"json"

	);	

}



/*

function downloadRSS() {

	window.remoteWindow = window.open('http://toget.pchome.com.tw/search/more_s.php?&searchterm=rss','remoteWindow','width=550,height=400,scrollbars,resizable');

	window.remoteWindow.window.focus();

}

*/

</script>

{/literal}

</head>

<body>

<h1>

{if $show_title == 1}最新消息{else}課程公告{/if}

</h1>







{if $displayType != 'smallwindow'}

  {if $isNewOn == 1}

  <div class="al-left"><a href="systemNews_new.php?behavior={$behavior}&incomingPage={$currentPage}&finishPage={$finishPage}">

  <img src="{$tpl_path}/images/icon/add.gif">新增公告</a>

  </div>

  {/if}

{/if} 





<br/>



<table class="datatable">

<tr>

{if $displayType != 'smallwindow'}

    <th width="15%">公告日期</th>

	{if $isShowCourse == 1}

		<th>課程名稱</th>

	{/if}

{/if}

    <th width="50%">標題</th>

{if $displayType != 'smallwindow'}

    <th width="15%">瀏覽次數</th>

	

	{if $isModifyOn == 1}

		<th>修改</th>

    {/if}

    

	{if $isDeleteOn == 1}

		<th>刪除</th>

    {/if} 

{/if}

</tr>

{section name=counter loop=$newsList}<!--BEGIN:公告的標頭-->

<tr> 

{ if $displayType != 'smallwindow'}

    <td width="20%">{$newsList[counter].date}</td>

	{if $isShowCourse == 1}

		<td width="60%">{$newsList[counter].courseName}</td>

	{/if}

{/if}



	<td id="news_content_tr-{$newsList[counter].news_cd}" class="news_subject"><b>{$newsList[counter].subject}</b>{if $newsList[counter].new == 1}<img src="{$tpl_path}/images/icon/new.gif">{/if}</td>

{if $displayType != 'smallwindow'}

	<td class="viewNum_{$newsList[counter].news_cd}">{$newsList[counter].viewNum}</td>

      

	{if $isModifyOn == 1}

		<td><a href="systemNews_modify.php?news_cd={$newsList[counter].news_cd}&behavior={$behavior}&incomingPage={$currentPage}&finishPage={$finishPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></td>

	{/if}

	

	{if $isDeleteOn == 1}

		<td><a href="systemNews_delete.php?news_cd={$newsList[counter].news_cd}&behavior={$behavior}&incomingPage={$currentPage}&finishPage={$finishPage}" onClick="return confirm('確定要刪除此公告嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></td>

	{/if} 

{/if}

</tr>

    <!--			END:公告的標頭				-->

    <!--			BEGIN:公告的內容			-->

<tr class="tr3" style="display:none;" id="news_detail_content_tr-{$newsList[counter].news_cd}"> 

{if $displayType == 'smallwindow'}

	  <td>

{else}

	{if $isShowCourse == 0}

      	{if $isModifyOn == 0 && $isDeleteOn == 0}

      <td colspan="3"> {elseif $isModifyOn == 1 && $isDeleteOn == 1}

      <td colspan="5"> {else}

      <td colspan="4"> {/if}

	{else}

        {if $isModifyOn == 0 && $isDeleteOn == 0}

      <td colspan="3"> {elseif $isModifyOn == 1 && $isDeleteOn == 1}

      <td colspan="5"> {else}

      <td colspan="4"> {/if}

	{/if}

{/if}

	<p>

	<strong>公告發佈者：{$newsList[counter].personal_name}</strong><br/>

        {if $newsList[counter].showContent == 1}

        	{$newsList[counter].content}

        {/if}

	</p>

	<br/>

		{ section name=file_index loop=$newsList[counter].file_list}

        {if $newsList[counter].file_list[file_index].showFile == 1}

			附加檔案：<a href="{$newsList[counter].file_list[file_index].file_url}"  target="_blank">

			{$newsList[counter].file_list[file_index].file_name} </a><br />

        {/if}

		

        {if $newsList[counter].file_list[file_index].showUrl == 1}

			外部網址：<a href="{$newsList[counter].file_list[file_index].file_url}" target="_blank">

			{$newsList[counter].file_list[file_index].file_url}</a><br />

        {/if}

		{/section}	

	</td>

</tr><!--END:公告的內容-->

{/section}

</table>

{if $newsNum > 10 && $showAll == 0}

	<p class="al-left"> <a href="{$currentPage}?showAll=1">顯示全部公告</a> </p>

{elseif $newsNum > 10 && $showAll == 1}

	<p class="al-left"><a href="{$currentPage}?showAll=0">隱藏部份公告</a></p>

{/if}



</div>





  





{* if $displayType != 'smallwindow'}  

	{ if $showRss == 1}

	

	<p class="al-left"> 

		<a  title="Link to the RSS 2.0 feed." href="{$rssPage}"><img src="{$imagePath}rss20_logo.gif" style="border:0px;" alt="RSS 2.0" /></a><br />

		<input type="button" onClick="downloadRSS()" value="下載RSS Reader" class="btn">

	</p>

	{/if}

{/if *}



</body>

</html>

