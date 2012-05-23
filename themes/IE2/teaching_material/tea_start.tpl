<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
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




{literal}
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

function redirect(){
	window.open("./textbook_manage.php","_parent");
}
</script>
{/literal}
</head>

<body id="tabA">
  <h1>教材編輯工具</h1>
  <div class="tab">
	  <ul id="tabnav">
	    <li class="tabA" onClick="display(1)">編輯教材導覽</li>
	    <li class="tabB" onClick="display(2)">預覽教材導覽</li>
  	  </ul>
  </div>
<!--編輯教材導覽-->
<div id="inner_contentA">
          <p class="intro">你目前所編輯的是本教材導覽頁面&lt;
	  {if $index_show == 1}index.html
	  {elseif $index_show == 2}index.htm
	  {elseif $index_show == 3}index.swf
	  {else}index.html
	  {/if}
	  &gt;</p>
	  {if $index_show != 3}
          <form method="post" action="tea_start.php"> 
	          <textarea name="index_content" class="rte2" id="index_content" cols="40" rows="17" style="width:400px;">{$index_content}</textarea>
			  <input type="hidden" name="action" value="index">
			  <input type="hidden" name="content_cd" value="{$content_cd}">
			  <input type="hidden" name="index_show" value="{$index_show}">
		    <p class="al-left"><input type="submit" class="btn" name="submit" value="更新內容" /></p>
          </form>
	  {else if $index_show == 3} 
	      &nbsp;&nbsp;&nbsp;&nbsp;教材導覽頁面為index.swf不可編輯。
	  {/if}

</div>
<!--預覽教材導覽-->	  
<div class="inner_contentB" id="inner_contentB" style="display:none;">
		 
		  {if $index_show == 1}
		  	<iframe id = "test" height="700" width="650" src="{$current_path}/index.html" >
			</iframe>
		  {elseif $index_show == 2}
		  	<iframe id = "test" height="700" width="650" src="{$current_path}/index.htm" >
			</iframe>
		  {elseif $index_show == 3}
		        <!--id test css中有設定 -->
		  	<iframe id = "test" height="100%" width="100%" src="{$current_path}/index.swf" >
			</iframe>
		  {else}
			請點選左方單元目錄，即可進入閱讀課程教材。
          {/if}
</div>


</div>
</body>
</html>
<!--
<script type="text/javascript">
document.getElementById('test');
</script>
-->
