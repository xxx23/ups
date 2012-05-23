<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>筆記本頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<link rel="StyleSheet" href="{$tpl_path}/script/nlstree/nlsctxmenu.css" type="text/css" />
<link rel="StyleSheet" href="{$tpl_path}/script/nlstree/nlstree.css" type="text/css" />

<script language="javascript" src="{$webroot}script/nlstree/nlstree.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlsctxmenu.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_ctx.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_sel.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlsconnection.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/reorder.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_dd.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_state.js"></script>

<!--resize iframe-->
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script> 


<script> 
	var tree = new NlsTree("tree");
	var ctx = new NlsCtxMenu("ctx");
	var ctx2 = new NlsCtxMenu("Ctx2");
	var node_id; //node_id用來記錄return_id.php傳回來的id值(目前要insert的id數值)
	var notebook_cd = {$Notebook_cd};

{literal}	
	//======================= callback =======================//
	
	//ajax callback function取得id值
	function callBack(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				node_id = xmlHttp.responseText;
			}
		}
	}

	function MODIFY_TITLE(xmlHttp, node){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				var result = xmlHttp.responseText;
				var tmp_str = result.split(";");
				if(tmp_str[0] == -1)
					alert("同資料夾下已有名稱重複的情形，請重新命名!");
				else{
					document.getElementById("textbook").src = "notebook_content.php?notebook_cd="+notebook_cd+"&menu_id="+node.orgId;
				}
				node.capt = tmp_str[1];
				tree.reloadNode(node.orgId, true);
			}
		}
	}	
	//======================= ~callback =======================//
	
	
	//新增一個node, modified by hushpuppy 2007/3/2
	NLSTREE.ctx_liveAdd = function (prId) {
	  	var selNode=this.nLst[this.genIntId(prId)];
		
	  	//透過ajax去server取出id值
	  	if(window.ActiveXObject){
		  	xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	  	}else if(window.XMLHttpRequest){
		  	xmlHttp = new XMLHttpRequest();
	  	}
	  	xmlHttp.open("GET","./ajax/return_id.php?parent_id="+selNode.orgId,false); //等待server傳回給node_id後，才往下執行
	  	xmlHttp.onReadyStateChange = callBack;
	  	xmlHttp.send(null); 
	 	//alert(node_id); 
	  	if(node_id == -1){
		  	alert("\"New Node\"名稱重複，請重新命名!");
		  	return -1;
		}
		
		else{
	  		url = "notebook_content.php?notebook_cd="+notebook_cd+"&menu_id="+node_id;
{/literal}	  
			var newNode = this.append(
	      		node_id,		//若不指定目前id數值，onNodeChange事件無法擷取到新增的node的id
			selNode.orgId,
		        "New Node",
	      		url,
		        "{$tpl_path}/script/nlstree/img/folder.gif",
	      		false
	  		);
{literal}
	 	//	alert(newNode.id); 
	  		this.expandNode(selNode.orgId);
	  		this.selectNode(newNode.id);
			this.liveNodeEditStart(newNode.id);
			return 1;
		}
	}	

	function globalCtxMenu(selNode, menuId, itemId) {
 		switch (itemId) {
    		case "1": //insert nodes
    			result = tree.ctx_liveAdd(tree.getSelNode().orgId);
				if(result == 1){
					var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
				    frm.location.href="addNode.php"+"?refid="+selNode.orgId+"&notebook_cd="+notebook_cd;
				}
	      		break;
		    case "2":	//delete nodes
    		  	if (confirm("確定要刪除此筆記本目錄(包含其下所有目錄與檔案)?")) {
        			tree.removeSelected();
				//var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
				var frm=document.getElementById("frmBuilder");
			    frm.src = "deleteNode.php"+"?refid="+selNode.orgId;
				document.location.reload();
				}
	    	  	break;
    		case "3":	//edit nodes
	      		tree.liveNodeEditStart(tree.getSelNode().id);
		    	break;
			case "4":
				tree.expandNode(tree.getSelNode().orgId);
		 	    break;
			case "5":
				tree.collapseNode(tree.getSelNode().orgId);
			    break;
			case "6": //move up
      			moveUp(tree.getSelNodes());
		        break;
		    case "7": //move down
      			moveDown(tree.getSelNodes());
		        break;
	  	}
	}
	
	function rootCtxMenu(selNode, menuId, itemId) {
  		switch (itemId) {
			case "1":	//insert nodes
		    	result = tree.ctx_liveAdd(tree.getSelNode().orgId);
			if(result == 1){
			  //var frm= (document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
			  var frm=document.getElementById("frmBuilder");
			  //frm.location.href="addNode.php"+"?refid="+selNode.orgId+"&notebook_cd="+notebook_cd;

			  frm.src="addNode.php"+"?refid="+selNode.orgId+"&notebook_cd="+notebook_cd;

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
		var xmlHttp = createXMLHttpRequest();

		xmlHttp.onreadystatechange = function(){MODIFY_TITLE(xmlHttp,node);};
		xmlHttp.open("GET","saveNodeCaption.php?notebook_cd="+notebook_cd +"&nid="+node.orgId+"&caption="+encodeURIComponent(node.capt), false);
		xmlHttp.send(null);
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
{/literal}

{literal}
	//初使化tree
	function init(){
{/literal}
		tree.opt.mntState = true;
		tree.opt.selRow = true;
		
		//======= build tree =========
		{$addNode} 
		//======== build tree ========

		
		
		tree.opt.editable = true ;
		tree.opt.sort = "desc" ;
		ctx.absWidth = 150;
		ctx.add("1", "新增一個筆記本目錄", "", "{$tpl_path}/script/nlstree/img/newnode.gif");
		ctx.add("2", "刪除此筆記本目錄", "", "{$tpl_path}/script/nlstree/img/nodrop.gif");
		ctx.add("3", "編輯此筆記本目錄名稱", "", "{$tpl_path}/script/nlstree/img/config.gif");
		ctx.addSeparator();
		ctx.add("4", "全部展開", "", "{$tpl_path}/script/nlstree/img/arrowdown.gif");
	    ctx.add("5", "全部縮緊", "", "{$tpl_path}/script/nlstree/img/arrowright.gif");
		ctx.addSeparator();
		ctx.add("6", "上移", "");
	    ctx.add("7", "下移", "");
	
		tree.opt.icAsSel = false;
		tree.opt.trg = "textbook";
		ctx.menuOnClick = globalCtxMenu;
		tree.setGlobalCtxMenu(ctx);
		
		ctx2.add("1", "新增一個筆記本目錄", "", "{$tpl_path}/script/nlstree/img/newnode.gif");
		ctx2.add("2", "全部展開", "", "{$tpl_path}/script/nlstree/img/arrowdown.gif");
	    ctx2.add("3", "全部縮緊", "", "{$tpl_path}/script/nlstree/img/arrowright.gif");
		
		ctx2.menuOnClick = rootCtxMenu;
		
	}
	
</script>
</head>

<body class="ifr">

{literal}
<script>
  init();
  tree.treeOnNodeChange = function(id){changeNode(id)};
  tree.renderAttributes();
</script>
{/literal}

<div id="contents" width="300" height="300">
	<div id="nav" style="float:left;width:20%;height:100%;">
		<div><img width="125px" src="./img/notebook-2.png"></div>
   	    <div class="area_title" id ="message_title">
			<h1>筆記本目錄</h1>
			<a href="notebook_mgt.php">返回筆記本管理頁面</a>
		</div>
	    <!---    main tree   -->
		<div class="area" id="message"><script>tree.render();</script></div>
		<!---    main tree   -->
	</div>
	<div id="content" style="float:left;width:75%;height:100%;">
		<iframe id="frmBuilder" name="textbook" style="width:100%;" frameborder="0" src="./nb_start.php" onload="ResizeIframe(this);" ></iframe>
	</div>
</div>


{*  
<div id="bdPanel" class="builderPanel">
<iframe id="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</div>
*}


</body>
</html>
