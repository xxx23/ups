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
function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
//	alert(option);
	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else{
		//document.getElementById("inner_contentB").style.visibility = "visible";
		document.getElementById("inner_contentB").style.display = "";
		//document.getElementById("_content").style.width = "100%";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
}

function delete_file(file_name)
{
	if(confirm("確定刪除此檔案?")){
		location.href="notebook_content.php?delete=true&no="+file_name;
		return true;
	}
	else
		return false;
}
//-->{literal}
function redirect(){
	window.open("./notebook_mgt.php","_parent");
}
</script>

<link rel="StyleSheet" href="style.css" type="text/css" />
<style type="text/css">
li.tabA	{cursor:pointer;}
li.tabB	{cursor:pointer;}
</style>
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
	  <h1>筆記本編輯工具 <span class="imp">{$test}</span></h1>
	</div>
	<div class="tab">
	  <ul id="tabnav">
        <li class="tabA" onClick="display(1)">本頁筆記</li>
	    <li class="tabB" onClick="display(2)">目錄瀏覽</li>
      </ul>
  </div>
  	  <div class="inner_contentA" id="inner_contentA">

          <h1>本頁筆記本內容</h1>
		  <form method="post" action="notebook_content.php"> 
	          <textarea name="index_content" id="index_content" cols="80" rows="17" style="width:700">{$Notebook_Content}</textarea>
			  <input type="hidden" name="action" value="index">
			  <center><input type="submit" class="btn" name="submit" value="更新內容" /></center>
          </form>
      </div>
	  <div class="inner_contentB" id="inner_contentB" style="display:none;">
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
						<td><a href="./redirect_file.php?file_name={$element.file_name_encode}"><img src="{$tpl_path}/images/icon/download.gif">{$element.content_name}</a> </td>
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
	      <!--<p> 如欲覆蓋本目錄首頁內容, 請上傳檔名為 [index.html] 的檔案.<br />-->
	        
		  <form method="POST" action="notebook_content.php" enctype="multipart/form-data">
		  <table>
	      	<tr>
				<td colspan="4"><input type="file" class="btn" name="new_file[]" /></td>
			</tr>
            <!--
			<tr id="upload">
		    	<th colspan="1"></th><td colspan="3"><input type="button" class="btn" onClick="addInput();" value="增加檔案個數"/></td>
			</tr>	
            -->
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
