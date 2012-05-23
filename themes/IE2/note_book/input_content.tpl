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
</script>
<link rel="StyleSheet" href="style.css" type="text/css" />

</head>
<body id="tabA">
<div id="contents">
<div id="content">
	<p class="address">目前所在位置:
	{foreach from = $content item=element}
	{$element} <!--&gt;&gt;-->
	{/foreach}</p>
	  <div class="inner_contentA" id="inner_contentA">
          <h1>本頁筆記本內容</h1>
		  <form method="post" action="tea_textbook_content.php"> 
	          <textarea name="index_content" id="index_content" cols="80" rows="17" style="width:700">{$index_content}</textarea>
			  <input type="hidden" name="action" value="index">
			  <center><input type="submit" class="btn" name="submit" value="更新內容" /></center>
          </form>
      </div>
</div>

<div id="bdPanel" class="builderPanel">
  <iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</body>
</html>
