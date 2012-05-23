<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$webroot}script/progress.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
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

//-->{literal}
function redirect(){
	window.open("./textbook_manage.php","_parent");
}
</script>

<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce_new/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/editor_simple.js"></script>
<style type="text/css">
li.tabA	{cursor:pointer;}
li.tabB	{cursor:pointer;}
li.tabC	{cursor:pointer;}
</style>
{/literal}

</head>
<script type="text/javascript" src="./script/upload.js"></script>
<body id="tabA">
<div id="contents">
<div id="content">
	<p class="address">目前所在位置:
	{foreach from = $content item=element}
	{$element} <!--&gt;&gt;-->
	{/foreach}</p>
	<div class="tab">
	  <ul id="tabnav">
        <li class="tabA" onClick="display(1)">編輯目錄順序性</li>
      </ul>
	  </div>
	  <div class="inner_contentA" id="inner_contentA">
	  <fieldset>
	  <legend>教材節點列表</legend>
		 重新整理後即生效。 
	     <form method="post" action="tea_node_seq_content.php">
		  <table class="datatable" width="100%" border="1">
                <caption>                       此目錄下的檔案(順序將由小到大排列)              </caption>
                <tr>
                        <th>檔名 </th>
                        <th>順序性</th>
                </tr>
                                {foreach from = $content2 item = element name=contentloop}
                                        <tr  class="{cycle values=" ,tr2"}">
                                        <td><img src="{$webroot}images/folderopen.gif">{$element.caption} </td>
                                <td><input type="text" name="seq_array[]" size="1" value="{$element.seq}"></td>
				<input type="hidden" name="menu_id_array[]" value="{$element.menu_id}">
                                        </tr>
                </tr>
                                {foreachelse}
                                目前此目錄下沒有任何檔案。
                                {/foreach}
          </table>
	  
	     <div>
	     <center>
	        <input type="hidden" name="submit_menu_id" value="{$menu_id}">
	     	<input class="btn" type="submit" name="submit_sequence" value="更新順序">
	     </center>
	     </div> 
	     </form>
      </div>
</div>

<div id="bdPanel" class="builderPanel">
  <iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</body>
</html>
