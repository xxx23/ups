<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<link rel="StyleSheet" href="{$webroot}script/nlstree/nlsctxmenu.css" type="text/css" />
<link rel="StyleSheet" href="{$webroot}script/nlstree/nlstree.css" type="text/css" />
<script language="javascript" src="{$webroot}script/nlstree/nlstree.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlsctxmenu.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_ctx.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_sel.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlsconnection.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/reorder.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_dd.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_state.js"></script>

<script type="text/javascript" src="{$tpl_path}/script/default.js"></script> <!--resize iframe-->

{literal}
<script> 
	var tree = new NlsTree("tree");
	var content_cd;

	//初使化tree
	function init(){
		tree.opt.mntState = true;
		//tree.treeOnNodeChange = function(node){changeNode(node)};
		{/literal}
		tree.opt.selRow = true;
		tree.opt.sort = "no" ;
		tree.opt.trg = "textbook";
		{$addNode} //build tree
		content_cd = {$Content_cd};
		{literal}
	}
{/literal}

</script>
</head>

<body class="ifr">
<script>
  init();
  tree.renderAttributes();
</script>
<div id="contents" width="300" height="300">
	<div id="nav" style="float:left;width:20%;height:100%;">
   	    <div class="area_title" id ="message_title">教材目錄 </div>
		<div class="area" id="message"><script>tree.render();</script></div>
    </div>
	<div id="content" style="float:left;height:100%;">
		<iframe id="textbook" name="textbook" frameborder="0" onload="ResizeIframe(this);" src="tea_node_seq_content.php?content_cd={$Content_cd}"></iframe>
	</div>
</div>
  	<div id="bdPanel" class="builderPanel">
	<iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</div>
</body>
</html>
