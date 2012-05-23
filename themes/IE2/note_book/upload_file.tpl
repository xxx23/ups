<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>筆記本頁面</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<!--<link href="/css/v2/table.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/css/v2/navigation.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="./script/usable_proprities.js"></script>
<script type="text/javascript" src="./script/progress.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript" src="./script/upload.js"></script>
<script type="text/JavaScript">
{literal}

function delete_file(file_name)
{
	if(confirm("確定刪除此檔案?")){
		location.href="tea_textbook_content.php?delete=true&no="+file_name;
		return true;
	}
	else
		return false;
}
</script>
{/literal}

</head>
<body id="tabA">
<div id="contents">
<div id="content">
	<p class="address">目前所在位置:
	{foreach from = $content item=element}
	{$element} <!--&gt;&gt;-->
	{/foreach}</p>
	<div class="area2_title" id="news_title"> 
	  <h1>筆記本編輯工具 </h1>
	</div>
	  <div class="inner_contentB" id="inner_contentB">
	  <fieldset>
	  <legend>檔案列表</legend>
      		<table class="datatable" width="100%" border="1" class="datatable">
            	<caption>
              		此目錄下的檔案
	            </caption>
    	        <tr>
        	    	<th>檔名 </th>
              		<th>檔案大小 </th>
		            <th>最後修改日期 </th>
              		<th>刪除</th>
            	</tr>
				{foreach from = $content2 item = element name=contentloop}
					<tr  class="{cycle values=" ,tr2"}">
					{if $element.dir == 0}
						<td><a href="{$webroot}Teaching_Material/redirect_file.php?file_name={$element.file_name_encode}"><img src="{$tpl_path}/images/icon/download.gif">{$element.content_name}</a> </td>
					{else}
					<td><img src="{$webroot}images/folderopen.gif">{$element.content_name} </td>
					{/if}
	              		<td>{$element.file_size} </td>
    	          		<td>{$element.file_time} </td>
        	      		{if $element.dir == 0}
				<td><img src="{$tpl_path}/images/icon/delete.gif" onClick="return delete_file('{$element.content_name}')" alt="刪除檔案" width="19" height="19" border="0" style="cursor:hand"/></td>
				{else}
				<td></td>
				{/if}
					</tr>
            	</tr>
				{foreachelse}
				目前此目錄下沒有任何檔案。
				{/foreach}
          </table>
	    </fieldset>
		  <fieldset>
		  <legend>上傳檔案</legend>
          <h1>上傳檔案到 [&nbsp;{$dir_name}&nbsp;]目錄.</h1>
		  <form method="POST" action="tea_textbook_content.php" enctype="multipart/form-data">
		  <table>
	      	<tr>
				<td colspan="4"><input type="file" class="btn" name="new_file[]" /></td>
			</tr>
			<tr id="upload">
		    	<th colspan="1"></th><td colspan="3"><input type="button" class="btn" onClick="addInput();" value="增加檔案個數"/></td>
			</tr>	
		  </table>
		  <br />
		  <input type="submit" class="btn" name="submit" value="上傳檔案" onClick="openWait();" />
		  <input type="hidden" name="action" value="upload" />
		  <!-- waiting bar-->
		<span id="please_wait" style="display:none;position:absolute;">
		<div style="cursor:move;" class="form" onMouseDown="init();"  >
        	<img src="{$tpl_path}/images/icon/proceeding.gif"></img> <br />
        	<span class="imp">處理中請稍後...</span><br />
		</div>
		</span>
		<!-- waiting bar-->
		  </form>
		  </fieldset>
      </div>
</div>

<div id="bdPanel" class="builderPanel">
  <iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</body>
</html>
