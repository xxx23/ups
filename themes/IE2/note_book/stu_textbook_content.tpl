<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<!--<link href="/css/v2/table.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/css/v2/navigation.css" rel="stylesheet" type="text/css" />-->
{literal}
<script type="text/JavaScript">
function tracking(Menu_id)
{
	//alert(Menu_id);
	if(window.ActiveXObject){
	  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
	  xmlHttp = new XMLHttpRequest();
    }
	
    //等待server傳回給node_id後，才往下執行
{/literal}
	xmlHttp.open("GET","{$webroot}Teaching_Material/ajax/learning_tracking.php?Menu_id="+Menu_id,false);
{literal}
    //xmlHttp.onReadyStateChange = callBack;
    xmlHttp.send(null);
}

function callBack()
{
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			echo_str = xmlHttp.responseText;
			alert(echo_str);
		}
	}
}
{/literal}
</script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="./script/tinyMCE.js"></script>

</head>
<script type="text/javascript" src="./script/upload.js"></script>
<body onUnload="tracking({$Menu_id});">
	<p class="address">目前所在位置:
	{foreach from = $content item=element}
	{$element} <!--&gt;&gt;-->
	{/foreach}</p>
	  <div id="inner_contentC">
		  {if $index_show == 0}
		  <table width="100%" border="1" class="datatable">
            	<caption>
              		此目錄下的檔案
	            </caption>
    	        <tr>
        	    	<th>檔名 </th>
              		<th>檔案大小 </th>
		            <th>最後修改日期 </th>
            	</tr>
				{foreach from = $content2 item = element name=content2loop}
            	<tr  class="{cycle values=" ,tr2"}">
		{if $element.dir == 0}
              		<td><a href="{$webroot}Teaching_Material/redirect_file.php?file_name={$element.file_name_encode}"><img src="{$tpl_path}/images/icon/download.gif">{$element.content_name}</a> </td>
		{else}
		<td><img src="{$webroot}images/folderopen.gif">{$element.content_name} </td>
		{/if}
              		<td align="center">{$element.file_size} </td>
              		<td align="center">{$element.file_time} </td>
            	</tr>
				{foreachelse}
				此目錄下沒有任何檔案。
				{/foreach}
          </table>
		  {elseif $index_show == 1} 
		  <div>
		  <iframe id = "test" width="870" height="850" src="{$current_path}/index.html">
		  </iframe>
		  </div>
{else}
<div>
<iframe id = "test" width="870" height="850" src="{$current_path}/index.htm">
</iframe>
						                        </div>
          {/if}
      </div>
</div>

<div id="bdPanel" class="builderPanel">
  <iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</body>
</html>
