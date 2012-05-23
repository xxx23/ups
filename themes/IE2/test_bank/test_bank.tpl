<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>題庫管理頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/test_bank/import.js"></script>
<script type="text/javascript" src="{$webroot}script/test_bank/test_related.js"></script>

<script type="text/JavaScript">
<!--
{literal}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
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
}
{/literal}
-->
</script>
<link rel="StyleSheet" href="style.css" type="text/css" />
<style type="text/css">
{literal}
li.tabA	{cursor:pointer;}
li.tabB	{cursor:pointer;}
{/literal}
</style>

</head>
<body class="ifr" id="tabA">
	[題庫管理工具]
{if $hasTestBank == 0 }
	<div class="imp"><p>沒有選擇教材，請先至教材管理選取選擇教材，或者由下面直接指定教材</p></div>
{else}
	<br/><br/><span class="imp">※目前教材：{$current_content_name}</span>
	<div class="tab">
		<ul id="tabnav">
	        <li class="tabA" onClick="display(1)">題庫選擇</li>
	    	<li class="tabB" onClick="display(2)">新增題庫</li>
   	    </ul>
	</div>

	<div class="inner_contentA" id="inner_contentA" style="display:none;">
		<form method="POST" action="">
			<h1>系統共存在<span class="imp">{$bank_num}</span>筆題庫如下：</h1>
					<p class=intro>
					註：每一份教材對應到多份題庫，若無教材請先新增教材。<br/>
					註：匯出題庫時並無同時將圖片及影音檔匯出，請另行下載並於匯入時重新上傳。<br/>
					註：系統提供匯入範例請點以下連結觀看 <a href="./export_example.php">匯入範例</a>
                    </p></br>
				{if $import_success == 1}
				<p class=intro style="color:red;text-align:center;">題庫匯入成功</p>
				{/if}
				<table class="datatable" id="list">
				<tr>
					<th width="10%">題庫索引</th> <th width="18%">題庫名稱</td>
					 <th width="12%">是否存在題目</th><th> 編輯題庫 </th> <th> 匯出題庫 </th><th>匯入題庫</th> <th> 刪除題庫 </th>
				</tr>
				{foreach from = $content item = element name=contentloop}
				<tr class="{cycle values=" ,tr2"}">
					<td>{$smarty.foreach.contentloop.index+1}</td>
					<td>{$element.test_bank_name|escape}</td>
					<td>{$element.exist} ({$element.numRows})</td>
					<td><a href="./test_bank_content.php?content_cd={$element.content_cd}&test_bank_id={$element.test_bank_id}"><img src="{$tpl_path}/images/icon/edit.gif"></a></td>
					<td><a href="./export_test_bank.php?content_cd={$element.content_cd}&test_bank_id={$element.test_bank_id}"><img src="{$tpl_path}/images/icon/export.gif"></a></td>
					<td><a href="import_test_bank.php?content_cd={$element.content_cd}&test_bank_id={$element.test_bank_id}"><img src="{$tpl_path}/images/icon/import.gif"/></a></td>
					<td>
					<img src="{$tpl_path}/images/icon/delete.gif" width="19" height="19" border="0" onClick="return delete_test_bank({$element.content_cd}, {$element.test_bank_id})" style="cursor:hand;"/>
					</td>
				</tr>
				{/foreach}
				</table>
				<br>
			</form>
			
	</div>
	<div class="inner_contentB" id="inner_contentB" style="display:none;">
			<form action="" method="POST" target="_self">
			{if $insert_name_duplicate == 1}
			<div class="imp">題庫:{$duplicate_name}未新增 (題庫名稱重複，請取不一樣的名稱)</div>
			{/if}
			<table class="datatable" id="list">
				<tr>
					<th>新增題庫名稱</th>
				</tr>
				<tr><td><input type="text" name="test_bank_name">
						<input type="hidden" name="content_cd" value="{$content_cd}">
						<input type="hidden" name="insert_flag" value="1">
						<input type="submit" value="送出">
					</td>
				</tr>
			</table>	
			</form>
	</div>		
{/if}
<br/>
<br/>
<hr>
	<span class="imp">※快速選取教材<br/>(方便快速跳至某教材，並不會使這堂課使用選定的教材)</span>
	<br/>
	<br/>
	<div style="width:250px">
		<table class="datatable" id="list" >
			<tr>
				<th width="80px">教材索引</th>
				<th>教材名稱</th>
			</tr>
		{foreach from=$all_contents item=element name=allcontentloop}
			<tr>
				<td>{$smarty.foreach.allcontentloop.index+1}</td>
				<td><a href="test_bank.php?content_cd={$element.content_cd}">{$element.content_name}</a></td>
			</tr>
		{/foreach}
		</table>
	</div>
<script type="text/javascript">
{if $insert_name_duplicate == 1}
	display(2);
{else}
	display(1);
{/if}	
</script>
</body>
</html>
