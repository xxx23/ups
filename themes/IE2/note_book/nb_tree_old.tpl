<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>筆記本頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<link rel="StyleSheet" href="style.css" type="text/css" />
<link rel="StyleSheet" href="./script/nlstree/nlsctxmenu.css" type="text/css" />
<link rel="StyleSheet" href="./script/nlstree/nlstree.css" type="text/css" />
<script language="javascript" src="./script/nlstree/nlstree.js"></script>
<script language="javascript" src="./script/nlstree/nlsctxmenu.js"></script>
<script language="javascript" src="./script/nlstree/nlstreeext_ctx.js"></script>
<script language="javascript" src="./script/nlstree/nlstreeext_sel.js"></script>
<script language="javascript" src="./script/nlstree/nlsconnection.js"></script>
<script language="javascript" src="./script/nlstree/reorder.js"></script>
<script language="javascript" src="./script/nlstree/nlstreeext_dd.js"></script>
<script language="javascript" src="./script/nlstree/nlstreeext_state.js"></script>

<script type="text/javascript" src="{$tpl_path}/script/default.js"></script> <!--resize iframe-->

{literal}
<script> 
	var tree = new NlsTree("tree");
	var ctx = new NlsCtxMenu("ctx");
	var ctx2 = new NlsCtxMenu("Ctx2");
	var notebook_cd;

	function globalCtxMenu(selNode, menuId, itemId) {
 		switch (itemId) {
    		case "1": //insert nodes
			//alert(selNode.orgId);
			window.open("./input_content.php?menu_id="+selNode.orgId+"&notebook_cd="+notebook_cd,"newwindow","height=300, width=350, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no");
    			/*result = tree.ctx_liveAdd(tree.getSelNode().orgId);
				//alert("addNode.php"+"?refid="+selNode.orgId+"&notebook_cd="+notebook_cd);
				if(result == 1){
					var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
				    frm.location.href="addNode.php"+"?refid="+selNode.orgId+"&notebook_cd="+notebook_cd;
				}*/

	      		break;
		    case "2":	//delete nodes
		    	//alert(notebook_cd);
			window.open("./upload_file.php?menu_id="+selNode.orgId+"&notebook_cd="+notebook_cd,"newwindow","height=400, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no");
    		  	/*if (confirm("確定要刪除此筆記本目錄(包含其下所有目錄與檔案)?")) {
        			tree.removeSelected();
				var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
			    frm.location.href="deleteNode.php"+"?refid="+selNode.orgId;
				document.location.reload();
				}*/
	    	  	break;
    		/*case "3":	//edit nodes
	      		tree.liveNodeEditStart(tree.getSelNode().id);
		    	break;*/
			case "3":
				tree.expandNode(tree.getSelNode().orgId);
		 	    break;
			case "4":
				tree.collapseNode(tree.getSelNode().orgId);
			    break;
			case "5": //move up
      			moveUp(tree.getSelNodes());
		        break;
		    case "6": //move down
      			moveDown(tree.getSelNodes());
		        break;
	  	}
	}
	
	function rootCtxMenu(selNode, menuId, itemId) {
  		switch (itemId) {
			case "1":	//insert nodes
		    	result = tree.ctx_liveAdd(tree.getSelNode().orgId);
				if(result == 1){
					var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
			    	frm.location.href="addNode.php"+"?refid="+selNode.orgId+"&notebook_cd="+notebook_cd;
				}
      			break;
    		case "2":
		      	tree.expandNode(selNode.orgId);
	      		break;
		    case "3":
			    tree.collapseNode(selNode.orgId);
			    break;
  		}
	}
	
	function createXMLHttpRequest(){
		if(window.ActiveXObject)
			return new ActiveXObject("Microsoft.XMLHTTP");
		else if(window.XMLHttpRequest)
			return new XMLHttpRequest();
	}
	
	function changeNode(id){
		var node = tree.getNodeById(id);
		//alert(node.orgId);
		var xmlHttp = createXMLHttpRequest();
		var url = "saveNodeCaption.php";
		
		xmlHttp.onreadystatechange = function(){MODIFY_TITLE(xmlHttp,node);};
		xmlHttp.open("GET",url+"?nid="+node.orgId+"&caption="+encodeURIComponent(node.capt),false);
		xmlHttp.send(null);
	}
	
	function MODIFY_TITLE(xmlHttp, node){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				var result = xmlHttp.responseText;
				var tmp_str = result.split(";");
				if(tmp_str[0] == -1)
					alert("同資料夾下已有名稱重複的情形，請重新命名!");
				else
					alert("筆記本目錄名稱已更新!");
				node.capt = tmp_str[1];
				tree.reloadNode(node.orgId, true);
			}
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
	
	//初使化tree
	function init(){
		tree.opt.mntState = true;
		//tree.treeOnNodeChange = function(node){changeNode(node)};
		{/literal}
		tree.opt.selRow = true;
		{$addNode} //build tree
		
		notebook_cd = {$Notebook_cd};
		{literal}
		tree.opt.editable = true ;
		ctx.absWidth = 150;
		ctx.add("1", "新增文字內容", "", "/script/nlstree/img/newnode.gif");
		ctx.add("2", "上傳檔案", "", "/script/nlstree/img/config.gif");
		//ctx.add("3", "編輯此筆記本目錄名稱", "", "/script/nlstree/img/config.gif");
		ctx.addSeparator();
		ctx.add("4", "全部展開", "", "/script/nlstree/img/arrowdown.gif");
	    ctx.add("5", "全部縮緊", "", "/script/nlstree/img/arrowright.gif");
		ctx.addSeparator();
		ctx.add("6", "上移", "");
	    ctx.add("7", "下移", "");
	
		tree.opt.icAsSel = false;
		tree.opt.trg = "_blank";
		ctx.menuOnClick = globalCtxMenu;
		tree.setGlobalCtxMenu(ctx);
		
		ctx2.add("1", "新增一個筆記本目錄", "", "/script/nlstree/img/newnode.gif");
		ctx2.add("2", "全部展開", "", "/script/nlstree/img/arrowdown.gif");
	    ctx2.add("3", "全部縮緊", "", "/script/nlstree/img/arrowright.gif");
		
		ctx2.menuOnClick = rootCtxMenu;
		
		//tree.setNodeCtxMenu(1, ctx_root);
		//var treeDD = new NlsTreeDD("tree");
	}

	function change_notebook(option)
	{
	    Notebook_cd = document.getElementById("replace_notebook").item(option).getAttribute("value");
	    //alert(Notebook_cd);
	    location.href = "./nb_tree.php?notebook_cd="+Notebook_cd;
	}
{/literal}

</script>
</head>

<body class="ifr">
<script>
  init();
  //tree.treeOnNodeChange=onNodeChange;
  {literal}
  tree.treeOnNodeChange = function(id){changeNode(id)};
  {/literal}
  tree.renderAttributes();
</script>
<div id="contents" width="300" height="300">
	<div id="nav" style="float:left;width:20%;height:100%;">
   	    <!--<div class="area_title" id ="message_title">筆記本目錄 </div>-->
	    
		<div>
		<!--<a href="/Note_Book/nb_tree.php?notebook_cd=16">test</a>-->
		<select name="replace_notebook" id="replace_notebook" onChange="change_notebook(this.selectedIndex)">
		     {foreach from=$tbArray key=k item=i}
			<option id="{$k}" value="{$k}">{$i}</option>
		     {/foreach}
		</select>
		</div>
		<div class="area" id="message"><script>tree.render();</script></div>
		<br><a href="./notebook_mgt.php" target="_blank">管理頁面</a>
		</br>
    </div>
	
</div>
  	<div id="bdPanel" class="builderPanel">
	<iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</div>
</body>
</html>
