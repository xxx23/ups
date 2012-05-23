<html xmlns="http://www.w3.org/1999/xhtml">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<base target="_blank" />-->
<title>公告</title>
    <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/jquery-1.3.2.js"></script>






{literal}

<style>

.news_subject{

cursor: hand;

}

.style2 {
font-size: 12px;

}

</style>

<script type="text/javascript">

	$(document).ready(function(){

	$(".tr3").find('a').attr('target', '_blank');

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

			$('.viewNum_'+news_cd).text(data.viewNum);
			$('.viewNum_'+news_cd).css('text-align','center');


		}, 

		"json"

	);	

}





function downloadRSS() {

	window.remoteWindow = window.open('http://www.google.com.tw/search?q=rss+reader','remoteWindow','width=550,height=400,scrollbars,resizable');

	window.remoteWindow.window.focus();

}



</script>

{/literal}

</head>

<body>

<h1>

{if $show_title == 1}最新消息{else}課程公告{/if}

</h1>

<div class="describe"> 小提示：選擇公告類別可以瀏覽該類別公告。</div>
{if $displayType != 'smallwindow'}

  {if $isNewOn == 1}

  <div class="al-left"><a href="systemNews_new.php?behavior={$behavior}&incomingPage={$currentPage}&finishPage={$finishPage}">

  <div class="button001"><img src="{$tpl_path}/images/icon/add.gif" height="12">新增公告　</a></div>

  <p></div>{/if}
  
{/if} 
  

</p>
<table  width="222" height="28" border="0" cellpadding="0" cellspacing="0">
    <tr height="27px">
      <td width="74" background="../images/button002.gif" class="style2"><div align="center" font-size="10px">{if $news_type == 'system'}<img src="../images/arrow1_018.gif">{/if} <a href="{$currentPage}?news_type=system">系統</a> </div></td>
      <td width="74" background="../images/button002.gif" class="style2"><div align="center">{if $is_sys_course_news == 1}<img src="../images/arrow1_018.gif">{/if} <a href="{$currentPage}?news_type=course-all">課程</a></div></td>
      <td width="74" background="../images/button002.gif" class="style2"> <div align="center">{if $news_type == 'other'}<img src="../images/arrow1_018.gif">{/if} <a href="{$currentPage}?news_type=other">其他</a></div></td>
    </tr>
  </table>
  <span class="style2">

{if $is_sys_course_news == 1 }
  </span>
<table width="440" height="27" border="0" cellspacing="0" cellpadding="0">
  <tr>
	 <td width="25%" class="style2" background="../images/button003.gif"><div align="center" margin-top="10px">{if $news_type == 'course-6'}<img src="../images/arrow_149.gif">{/if} <a href="{$currentPage}?news_type=course-6">課程公告</a></div></td>
    <td width="25%" class="style2" background="../images/button003.gif"><div align="center" margin-top="10px">{if $news_type == 'course-1'}<img src="../images/arrow_149.gif">{/if} <a href="{$currentPage}?news_type=course-1">一般民眾課程</a></div></td>
    <td width="25%" class="style2" background="../images/button003.gif"><div align="center">{if $news_type == 'course-2'}<img src="../images/arrow_149.gif">{/if} <a href="{$currentPage}?news_type=course-2">中小學教師課程</a></div></td>
{*
他們不要這個選項了 Q^Q 
<td width="25%" class="style2" background="../images/button003.gif"><div align="center">{if $news_type == 'course-3'}<img src="../images/arrow_149.gif">{/if} <a href="{$currentPage}?news_type=course-3">高中職課程</a></div></td> 
*}
    <td width="25%%" class="style2" background="../images/button003.gif"> <div align="center">{if $news_type == 'course-4'}<img src="../images/arrow_149.gif">{/if} <a href="{$currentPage}?news_type=course-4">大專院校課程</a></div></td>
  </tr>
</table>
  {/if}
  <hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">
  <br/>
  

  
{* 公告列表 *}
  
</blockquote>
<div> 



<table class="datatable" width="90%">

<tr>

{if $displayType != 'smallwindow'}

    <th width="9%" align="center"><div align="center">公告日期</div></th>

	{if $isShowCourse == 1}

		<th>課程名稱</th>

	{/if}

{/if}

    <th width="50%">標　題</th>

{if $displayType != 'smallwindow'}

    <th width="6%" align="center"><div align="center">點閱數</div></th>

	

	{if $isModifyOn == 1}

		<th width="6%"><div align="center">修改</div></th>

    {/if}

    

	{if $isDeleteOn == 1}

		<th width="6%"><div align="center">刪除</div></th>

    {/if} 

{/if}

</tr>



{section name=counter loop=$newsList}<!--BEGIN:公告的標頭-->

<tr> 

{if $displayType != 'smallwindow'}

    <td width="9%"><div align="center">{$newsList[counter].date}</div></td>

	{if $isShowCourse == 1}

		<td width="60%">{$newsList[counter].courseName}</td>

	{/if}

{/if}



	<td id="news_content_tr-{$newsList[counter].news_cd}" class="news_subject"><b>{$newsList[counter].subject|escape:'html'}</b>{if $newsList[counter].new == 1}<img src="{$tpl_path}/images/icon/new.gif">{/if}</td>

{if $displayType != 'smallwindow'}

	<td class="viewNum_{$newsList[counter].news_cd}"><div align="center">{$newsList[counter].viewNum}</div></td>

      

	{if $isModifyOn == 1}

		<td><div align="center"><a href="systemNews_modify.php?news_cd={$newsList[counter].news_cd}&behavior={$behavior}&incomingPage={$currentPage}&finishPage={$finishPage}"><img src="{$tpl_path}/images/icon/edit.gif" alt="修改"></a></div></td>

	{/if}

	

	{if $isDeleteOn == 1}

		<td><div align="center"><a href="systemNews_delete.php?news_cd={$newsList[counter].news_cd}&behavior={$behavior}&incomingPage={$currentPage}&finishPage={$finishPage}" onClick="return confirm('確定要刪除此公告嗎?')"><img src="{$tpl_path}/images/icon/delete.gif" alt="刪除"></a></div></td>

	{/if} 

{/if}

</tr>

    <!--			END:公告的標頭				-->

    <!--			BEGIN:公告的內容			-->

<tr class="tr3" style="display:none;" id="news_detail_content_tr-{$newsList[counter].news_cd}"> 

{if $displayType == 'smallwindow'}

	  <td>

        <div align="center">{else}
  
	{if $isShowCourse == 0}
  
      	{if $isModifyOn == 0 && $isDeleteOn == 0} </div>
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

        	{$newsList[counter].content|escape:''|nl2br}

        {/if}

	</p>

	<br/>

		{section name=file_index loop=$newsList[counter].file_list}

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
</div>



<blockquote>
  <p>{if $newsNum > 9 && $showAll == 0} </p>
  <p class="al-left"> <div class="button001"><a href="{$currentPage}?news_type={$news_type}&showAll=1">顯示全部公告</a></div> </p>
  <p>{elseif $newsNum > 10 && $showAll == 1} </p>
  <p class="al-left"><div class="button001"><a href="{$currentPage}?news_type={$news_type}&showAll=0">隱藏部份公告</a></div></p>
  <p>{/if}
    
{if $displayType != 'smallwindow' && $showRss == 1}
<br />
  <div align="right">

		<a  title="Link to the RSS 2.0 feed." href="{$rssPage}" target="_blank"><img src="{$webroot}images/rss20_logo.gif" style="border:0px;" alt="RSS 2.0" /></a>　

		<input type="button" onClick="downloadRSS()" value="下載RSS Reader" class="btn">

  </div>

{/if}
    
  
    

    

    

    

    

    
</p>
</blockquote>
</body>

</html>

