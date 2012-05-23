<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>最新消息</title>
<link href="css/table.css" rel="stylesheet" type="text/css" />
<link href="css/index_news.css" rel="stylesheet" type="text/css" />
<link href="themes/IE2/css/content.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.tip.css" />       

<!-- edit by aeil --> 
<script type='text/javascript' src='script/jquery-1.2.6.pack.js'></script> 
<script src="script/jquery.tip.js" type="text/javascript"></script>   
<!-- END  --> 

</head>

<body backgournd="#FFF">
  <h1>最新消息</h1>
<div class="datatableContainer">

<table class="datatable" >
<tr><th width="20%">公告日期</th><th width="80%">公告標題</th></tr>
{foreach from=$news item=news_item name=news_loop}
<tr class="{cycle values=",tr2"}">
	<td><span class="jTip" jtip_w="400" jtip="{$news_item.content|escape:'html'}"  
		name="{$news_item.date}-{$news_item.subject|escape:'html'}" 
		id="{$smarty.foreach.news_loop.index}"><a>{$news_item.date}</a>
	</span>	
	</td>
	<td>{*
		<!-- 
		<span class="jTip" jtip_w="350" jtip="{$news_item.content|escape:'html'}"  
		name="{$news_item.date}-{$news_item.subject|escape:'html'}" 
		id="{$news_item.date}"><a>{$news_item.subject|escape:'html}</a>
		</span> -->
	    *}
		{$news_item.subject|escape:'html'}
	</td>
</tr>
	{foreachelse}
<tr colspan="2">	
	<td><div style="text-align:center">目前沒有公告</div></td>
</tr>
	{/foreach}
</table>
<p></p>
<div class="describe">欲觀看有對外公開之課程內容，請按左上方訪客進入。</div>

<h1>修課使用說明</h1>
<a href="{$tpl_path}/manual/20101110take_course.pdf" target="_blank"><img src="{$tpl_path}/images/download_take_course.gif" /></a>
<div class="describe">為保障您的權益使時數正確記錄，修課前請詳閱修課使用說明。</div>

</div>


</body>
</html>
