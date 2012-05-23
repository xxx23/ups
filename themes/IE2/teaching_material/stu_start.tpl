<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<script language="JavaScript">
<!--
function calcHeight()
{
  //find the height of the internal pages
  var the_height=document.getElementById('test').contentWindow.document.body.scrollHeight;
  var the_width=document.getElementById('test').contentWindow.document.body.scrollWidth;
  //change the height of the iframe
  document.getElementById('test').height= the_height+30;
  document.getElementById('test').Width = the_width+10;
}
//-->
</script>
{/literal}

{literal}
<style type="text/css">
li.tabA	{cursor:pointer;}
li.tabB	{cursor:pointer;}
li.tabC	{cursor:pointer;}
</style>

<script type="text/javascript">
function display(option){
	//alert(option);
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else{
		document.getElementById("inner_contentB").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
}
</script>
{/literal}
</head>

<body class="ifr" id="tabA">
<h1>教材導覽頁面</h1>
<span class="imp">上次累積時數:</span><strong>{$ReadTextTime}</strong>
<br><br>

		  {if $index_show == 1}
		  	<iframe id ="test"  onLoad="calcHeight();" height="600" width="100%" src="{$current_path}/index.html" style="border:1px solid #CCCCCC;">
			</iframe>
		  {elseif $index_show == 2}<!--700,650-->
		  	<iframe id = "test" onLoad="calcHeight();" height="600" width="100%" src="{$current_path}/index.htm" style="border:1px solid #CCCCCC;">
			</iframe>
		  {elseif $index_show == 3}
		  	<iframe id = "test" onLoad="calcHeight();" height="600" width="100%" src="{$current_path}/index.swf" style="border:1px solid #CCCCCC;">
			</iframe>
		  {else}
          請點選左方單元目錄，即可進入閱讀課程教材。
          {/if}

</div>


</body>
</html>
