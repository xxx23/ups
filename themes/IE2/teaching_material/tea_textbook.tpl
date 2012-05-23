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


<script type="text/javascript">

	var node_id; //node_id用來記錄return_id.php傳回來的id值(目前要insert的id數值)
	var content_cd = {$Content_cd};

	var tree = new NlsTree("tree");
	var ctx = new NlsCtxMenu("ctx");
	var ctx2 = new NlsCtxMenu("Ctx2");	
	
{literal}	
	//============ callback =========================//
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
					alert("教材目錄名稱已更新!");
					document.getElementById("textbook").src = "./tea_textbook_content.php?content_cd="+content_cd+"&menu_id="+node.orgId;
				}
				node.capt = tmp_str[1];
				tree.reloadNode(node.orgId, true);
			}
		}
	}	
	//============ ~callback =========================//
	
	
	
	//新增一個node, modified by hushpuppy 2007/3/2
	NLSTREE.ctx_liveAdd = function (prId) {
	  	var selNode=this.nLst[this.genIntId(prId)];
		 
	  	//透過ajax去server取出id值
	  	if(window.ActiveXObject){
		  	xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	  	}else if(window.XMLHttpRequest){
		  	xmlHttp = new XMLHttpRequest();
	  	}
        
	  	xmlHttp.onreadystatechange = callBack;
	  	xmlHttp.open("GET","./ajax/return_id.php?parent_id="+selNode.orgId,false); //等待server傳回給node_id後，才往下執行
	  	xmlHttp.send(null); 
    
       if(xmlHttp.readyState == 4){
            if(xmlHttp.status == 200){
                node_id = xmlHttp.responseText;
            }
        }
    
 
	  	if(node_id == -1){
		  	alert("\"New Node\"名稱重複，請重新命名!");
		  	return -1;
		}
		else{
	  		url = "tea_textbook_content.php?content_cd="+content_cd+"&menu_id="+node_id;
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
				    frm.location.href="addNode.php"+"?refid="+selNode.orgId+"&content_cd="+content_cd;
				}
	      		break;
		    case "2":	//delete nodes
    		  	if (confirm("確定要刪除此教材目錄(包含其下所有目錄與檔案)?")) {
        			tree.removeSelected();
				var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
			    frm.location.href="deleteNode.php"+"?refid="+selNode.orgId;
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
					var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
			    	frm.location.href="addNode.php"+"?refid="+selNode.orgId+"&content_cd="+content_cd;
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
		//var url = "/Teaching_Material/saveNodeCaption.php";
		var url = "./saveNodeCaption.php";

	    if(!/[\/\\?+#%@|<>]/.test(node.capt)){	
            xmlHttp.onreadystatechange = function(){MODIFY_TITLE(xmlHttp,node);};
            xmlHttp.open("GET",url+"?nid="+node.orgId+"&caption="+encodeURIComponent(node.capt),false);
            xmlHttp.send(null);
        }
        else{
           alert("不可含有特殊字元!");
           location.reload();
           return;
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
		tree.opt.icAsSel = false;
		tree.opt.trg = "textbook";
		//tree.treeOnNodeChange = function(node){changeNode(node)};
		{/literal}
		tree.opt.selRow = true;
		tree.opt.sort = "no";	
		{$addNode} //build tree
		content_cd = {$Content_cd};
		
		tree.opt.editable = true ;
		ctx.absWidth = 150;
		ctx.add("1", "新增一個教材目錄", "", "{$webroot}script/nlstree/img/newnode.gif");
		ctx.add("2", "刪除此教材目錄", "", "{$webroot}script/nlstree/img/nodrop.gif");
		ctx.add("3", "編輯此教材目錄名稱", "", "{$webroot}script/nlstree/img/config.gif");
		ctx.addSeparator();
		ctx.add("4", "全部展開", "", "{$webroot}script/nlstree/img/arrowdown.gif");
	    	ctx.add("5", "全部縮緊", "", "{$webroot}script/nlstree/img/arrowright.gif");
		ctx.addSeparator();
		//ctx.add("6", "上移", "");
	    //ctx.add("7", "下移", "");
	
		ctx.menuOnClick = globalCtxMenu;
		tree.setGlobalCtxMenu(ctx);
		
		ctx2.add("1", "新增一個教材目錄", "", "{$webroot}script/nlstree/img/newnode.gif");
		ctx2.add("2", "全部展開", "", "{$webroot}script/nlstree/img/arrowdown.gif");
		ctx2.add("3", "全部縮緊", "", "{$webroot}script/nlstree/img/arrowright.gif");
		
		ctx2.menuOnClick = rootCtxMenu;
		
	}
{literal}
	function textbook_seq_page(content_cd){
          //document.getElementById("textbook").src = "";
          url = "tea_save_node_seq.php?content_cd="+content_cd;
          window.open(url,"節點順序性分頁","location=no, toolbar=no, resizable=yes,scrollbars=yes");
    }
    function textbook_map_page(content_cd){
       
          url = "tea_save_node_map.php?content_cd="+content_cd+"&action=edit";
          window.open(url,"目錄名稱設定分頁","scrollbars=yes,resizable=yes,toolbar=no,location=no,status=yes");
       
    }
    function textbook_extract_material(content_cd){
          url = "tea_extract_material.php?content_cd="+content_cd+"&action=edit";
          window.open(url,"依檔案建立教材目錄","scrollbars=yes,resizable=yes,toolbar=no,location=no,status=yes");
       
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
<div id="contents">
	<div id="nav" style="float:left; width:24%; overflow-x:hidden">
   	    <div id ="message_title"><span class="imp">※教材目錄</span></div>
	    <div id="message"><script>tree.render();</script></div>
	<div><br><input class="btn" type="button" value="節點順序設定頁面" onclick="textbook_seq_page({$Content_cd});"></div>
	<div><br><input class="btn" type="button" value="目錄名稱對應設定" onclick="textbook_map_page({$Content_cd});"></div>
	<div><br><input class="btn" type="button" value="scorm教材目錄建立" onclick="textbook_extract_material({$Content_cd});"></div>
    </div>
	
	<div id="content" style="float:right; width:74%;">
		<iframe id="textbook" name="textbook" frameborder="0" onload="ResizeIframe(this);" style="width:100%;" src="tea_start.php?content_cd={$Content_cd}"></iframe>
	</div>
</div>

  	<div id="bdPanel" class="builderPanel">
	<iframe id="frmBuilder" name="frmBuilder" frameborder=0 scrolling="no" width="100%" height="100%" src="javascript:void(0)" style="display:none"></iframe>
</div>
</body>
</html>
