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

<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>

{literal}
<script> 
	var tree = new NlsTree("tree");
	var content_cd;
	
	//初始化tree
	function init(){
		
		tree.opt.mntState = true;
		//tree.treeOnNodeChange = function(node){changeNode(node)};
		{/literal}
		tree.opt.sort = "no" ;
		tree.opt.selRow = true;
		{$addNode} //build tree
		
		content_cd = {$Content_cd};
		{literal}
		tree.opt.editable = false;
		ctx.absWidth = 150;
		
		tree.opt.icAsSel = false;
		tree.opt.trg = "textbook";
		
	}
{/literal}

</script>
</head>

<body>
<script>
  init();
  //tree.treeOnNodeChange=onNodeChange;
  {literal}
  tree.treeOnNodeChange = function(id){changeNode(id)};
  {/literal}
  tree.renderAttributes();
</script>
<!--<div id="contents" width="300" height="300">
	<div id="nav" style="float:left;width:20%;height:100%;">
   	    <div class="area_title" style="none;cursor:pointer" id ="message_title" onClick="disappear();">教材目錄 </div>-->
		<div><h1>本課程教材點閱紀錄：</h1></div>
		<div class="area" id="message"><script>tree.render();</script></div>
    <!--</div>
	<div id="content" style="float:left;height:100%;">
		<iframe id="textbook" name="textbook" frameborder="0" height="300" width="300" src="stu_start.php?content_cd={$Content_cd}"></iframe>
	</div>-->
</div>
<div>
{literal}
<script type="text/javascript">
function openWin()
  {
       myWindow=window.open("","","fullscreen=3,resizable=yes,scrollbar=yes,  left=1000,top=0");
      myWindow.location.href('./scorm/mod/scorm/report.php');
  }
</script>
{/literal}
    {if $IS_SCORM }

        <input type="button" value="Open " onclick=openWin()>
    {else}

    {/if}


</div>

</body>
</html>
