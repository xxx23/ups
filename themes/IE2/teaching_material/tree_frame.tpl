<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<link rel="StyleSheet" href="{$script_path}nlstree/nlsctxmenu.css" type="text/css" />
<link rel="StyleSheet" href="{$script_path}nlstree/nlstree.css" type="text/css" />
<script language="javascript" src="{$script_path}nlstree/nlstree.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlsctxmenu.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_ctx.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_sel.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlsconnection.js"></script>
<script language="javascript" src="{$script_path}nlstree/reorder.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_dd.js"></script>
<script language="javascript" src="{$script_path}nlstree/nlstreeext_state.js"></script>

<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>

{literal}
<script> 
	var tree = new NlsTree("tree");
	var ctx = new NlsCtxMenu("ctx");
	var ctx2 = new NlsCtxMenu("Ctx2");
	var content_cd;

	function globalCtxMenu(selNode, menuId, itemId) {
 		switch (itemId) {
			case "1":
				tree.expandNode(tree.getSelNode().orgId);
		 	    break;
			case "2":
				tree.collapseNode(tree.getSelNode().orgId);
			    break;
			case "3": //move up
      			moveUp(tree.getSelNodes());
		        break;
		    case "4": //move down
      			moveDown(tree.getSelNodes());
		        break;
	  	}
	}
	
	function rootCtxMenu(selNode, menuId, itemId) {
  		switch (itemId) {
    		case "1":
		      	tree.expandNode(selNode.orgId);
	      		break;
		    case "2":
			    tree.collapseNode(selNode.orgId);
			    break;
  		}
	}
	
	function moveUp(selNodes) {
  		//move before previous node of selected node.
  		var prev=(selNodes[0]?selNodes[0].pv:null);
	  	if (!prev) return;
  		tree.ctx_moveChild(selNodes, prev, 2);
	  	tree.selectNodeById(selNodes[0].orgId);
	}

	function moveDown(selNodes) {
		//move after next node of selected node.
	  	var next=(selNodes[0]?selNodes[0].nx:null);
  		if (!next) return;
  		tree.ctx_moveChild(selNodes, next, 3);
  		tree.selectNodeById(selNodes[0].orgId);
}

//joyce add show_error btn 0324
function textbook_errortable_page(content_cd)
{
    var url = "textbook_error_content.php?content_cd="+content_cd;
        window.open(url,"教材內容錯誤列表","scrollbars=yes,resizable=yes,toolbar=no,location=no,status=yes");
}
	
	//初始化tree
	function init(){
		
		tree.opt.mntState = true;
		tree.opt.icAsSel = false;
		tree.opt.trg = "textbook_frame";
		//tree.treeOnNodeChange = function(node){changeNode(node)};

		tree.opt.sort = "no" ;
		tree.opt.selRow = true;
		
    {/literal}
        {$addNode} //build tree		
		content_cd = {$Content_cd};
    {literal}

		tree.opt.editable = false;
		tree.opt.sort = "desc" ;
		ctx.absWidth = 150;
		
		ctx.add("1", "全部展開", "", "{$script_path}nlstree/img/arrowdown.gif");
	    ctx.add("2", "全部縮緊", "", "{$script_path}nlstree/img/arrowright.gif");
		ctx.addSeparator();
		//ctx.add("3", "上移", "");
	    //ctx.add("4", "下移", "");
	
		ctx.menuOnClick = globalCtxMenu;
		tree.setGlobalCtxMenu(ctx);
		
		ctx2.add("1", "全部展開", "", "{$script_path}nlstree/img/arrowdown.gif");
	    ctx2.add("2", "全部縮緊", "", "{$script_path}nlstree/img/arrowright.gif");
		
		ctx2.menuOnClick = rootCtxMenu;
	}
</script>
{/literal}
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
<div id="contents" >
	<div id="nav" style="float:left;width:20%;height:100%;">
        <div class="area" id="message">
            <script>tree.render();</script>
        </div>
        <!-- joyce add show_error btn 0324 -->
            <br>
            <table> 
                <tr>
                  <td width="20%"></td>
                  <td width="80%" align="left">
                    <input class="btn" type="button" value="教材勘誤表" onclick="textbook_errortable_page({$Content_cd});">
                  </td>
                </tr>
            </table>
        <!------------------------------------>
    </div>
</div>


</body>
</html>
