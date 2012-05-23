<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<!--<link href="/css/v2/table.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/css/v2/navigation.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="{$webroot}script/progress.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/upload.js"></script>
<script type="text/JavaScript">


{literal}
function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
	document.getElementById("inner_contentC").style.display="none";
//	alert(option);
	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else if(option == 2){
		//document.getElementById("inner_contentB").style.visibility = "visible";
		document.getElementById("inner_contentB").style.display = "";
		//document.getElementById("_content").style.width = "100%";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
	else{
		//document.getElementById("inner_contentB").style.width = "0%";
		document.getElementById("inner_contentC").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabC";
	//alert(option);
	}
}

function delete_file(file_name)
{
	if(confirm("確定刪除此檔案?")){
		location.href="tea_textbook_content.php?delete=true&no="+file_name;
		return true;
	}
	else
		return false;
}
//-->{literal}
function redirect(){
	window.open("./textbook_manage.php","_parent");
}
</script>

{/literal}
<!--
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce_new/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/editor_simple.js"></script>
-->
<!--about editor-->
{literal}
<link type="text/css" rel="stylesheet" href="../library/editor/jquery.rte.css" />
<style type="text/css">
body, textarea {
    font-family:sans-serif;
    font-size:12px;
}
</style>
<script type="text/javascript" src="../library/editor/jquery.js"></script>
<script type="text/javascript" src="../library/editor/jquery.rte.js"></script>
<script type="text/javascript" src="../library/editor/jquery.rte.tb.js"></script>
<script type="text/javascript" src="../library/editor/jquery.ocupload-1.1.4.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        var arr = $('.rte1').rte({
                css: ['default.css'],
                controls_rte: rte_toolbar,
                controls_html: html_toolbar
        });

        $('.rte2').rte({
                css: ['default.css'],
                width: 650,
                height: 400,
                controls_rte: rte_toolbar,
                controls_html: html_toolbar
        }, arr);
});
</script>
{/literal}
<!--end about editor-->



</head>
<script type="text/javascript" src="./script/upload.js"></script>
<body id="tabA">
	  <h1>教材編輯工具 <span class="imp">{$test}</span></h1>
<div id="content">
	<p class="address">目前所在位置:
	{foreach from = $content item=element}
	{$element} <!--&gt;&gt;-->
	{/foreach}</p>
	<div class="tab">
	  <ul id="tabnav">
        <li class="tabA" onClick="display(1)">目錄瀏覽</li>
	    <li class="tabB" onClick="display(2)">目錄首頁編輯</li>
	    <li class="tabC" onClick="display(3)">目錄首頁預覽</li>
      </ul>
  </div>
	  <div class="inner_contentA" id="inner_contentA">
      		<table class="datatable" width="100%" border="1" class="datatable">
            	<caption>              		此目錄下的檔案	            </caption>
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
				<td><img src="{$tpl_path}/images/icon/delete.gif" onClick="return delete_file('{$element.file_name_encode}')" alt="刪除檔案" width="19" height="19" border="0" style="cursor:hand"/></td>
				{else}
				<td></td>
				{/if}
					</tr>
            	</tr>
				{foreachelse}
				目前此目錄下沒有任何檔案。
				{/foreach}
          </table>
<hr size="1" />
		  <form method="POST" action="tea_textbook_content.php" enctype="multipart/form-data">
		  <table class="datatable" width="100%">
	      	<tr><th>上傳檔案到<span class="imp">[&nbsp;{$dir_name}&nbsp;] </span>目錄</th>
			<tr>
				<td><input type="file" class="btn" name="new_file[]" /></td>
			</tr>
			<tr id="upload">
		    	<td>(如欲覆蓋本目錄首頁內容, 請上傳檔名為 [index.html] 的檔案)<br /><p class="al-left"><input type="button" class="btn" onClick="addInput();" value="增加檔案個數"/></p></td>
			</tr>	
		  </table>
		  <p class="al-left"><input type="submit" class="btn" name="submit" value="上傳檔案" onClick="openWait();" />
		  <input type="hidden" name="action" value="upload" /></p>
		  <!-- waiting bar-->
		<span id="please_wait" style="display:none; position:absolute;">
		<div style="cursor:move;" class="form" onMouseDown="init();"  >
        	<img src="{$tpl_path}/images/icon/proceeding.gif"></img> <br />
        	<span class="imp">處理中請稍後...</span><br />
		</div>
		</span>
		<!-- waiting bar-->
		  </form>
			<!--<input type= "button" name = "" value="ㄧ次上傳多個檔案" onClick="window.open('http://140.123.5.151/Teaching_Material/jupload/','_blank')">-->
      </div>
	  <div class="inner_contentB" id="inner_contentB" style="display:none;">

	{if $index_show == 1 || $index_show == 2}
          <p class="intro">你目前所編輯的是本目錄的&lt;index.html&gt;</p>
	{else}
          <p class="intro">你目前所編輯的檔案是&lt;{$file}&gt;</p>
	{/if}
          <form method="post" action="tea_textbook_content.php"> 
	          <textarea name="index_content" class="rte2" id="index_content" cols="50" rows="17" style="width:500px;">{$index_content}</textarea>
			  <input type="hidden" name="action" value="index">
			  <p class="al-left"><input type="submit" class="btn" name="submit" value="更新內容" /></p>
          </form>
  </div>
	  <div class="inner_contentC" id="inner_contentC" style="display:none;">
		  {if $index_show == 0}
		  <table width="100%" class="datatable">
            	<caption>此目錄下的檔案</caption>
    	        <tr>
        	    	<th>檔名 </th>
              		<th>檔案大小 </th>
		        <th>最後修改日期</th>
            	</tr>
				{foreach from = $content2 item = element name=content2loop}
            	<tr class="{cycle values=" ,tr2"}">
	  	        {if $element.dir == 0}
			
              		     <td>
				<!--<a href="{$webroot}Teaching_Material/redirect_file.php?file_name={$element.file_name_encode}">{$element.content_name}</a> -->
				<a href="{$webroot}Teaching_Material/redirect_file.php?file_name={$element.file_name_encode}"><img src="{$tpl_path}/images/icon/download.gif">{$element.content_name}</a>
			     </td>
			{else}
			     <td><img src="{$webroot}images/folderopen.gif">{$element.content_name} </td>
			{/if}
              		<td align="center">{$element.file_size} </td>
              		<td align="center">{$element.file_time} </td>
            	</tr>
				</tr>
				{foreachelse}
				目前此目錄下沒有任何檔案。
				{/foreach}
          </table>
		  {elseif $index_show == 1}
		  	<iframe id = "test" height="600" width="100%" src="{$current_path}/index.html" style="border:1px solid #CCCCCC;">
			</iframe>
		  {elseif $index_show == 2}
		  	<iframe id = "test" height="600" width="100%" src="{$current_path}/index.htm" style="border:1px solid #CCCCCC;">
			</iframe>
		  {elseif $index_show == 3}
		  	<iframe id = "test" height="600" width="100%" src="{$current_path}/index.swf" style="border:1px solid #CCCCCC;">
			</iframe>
		  {elseif $index_show == 4}
		  	<iframe id = "test" height="600" width="100%" src="{$current_path}" style="border:1px solid #CCCCCC;">
			</iframe>
          {/if}
      </div>
	   
</div>

<div id="bdPanel" class="builderPanel">
  <iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
<p class="al-left"><a href="#" onClick="redirect();"><img src="{$tpl_path}/images/icon/return.gif" />返回教材管理工具</a></p>
</body>
</html>
