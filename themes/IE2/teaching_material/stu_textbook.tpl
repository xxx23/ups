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
	
	//初始化tree
	function init(){
		
		tree.opt.mntState = true;
		tree.opt.icAsSel = false;
		tree.opt.trg = "textbook";
		//tree.treeOnNodeChange = function(node){changeNode(node)};
		{/literal}
		tree.opt.sort = "no" ;
		tree.opt.selRow = true;
		{$addNode} //build tree
		
		content_cd = {$Content_cd};
		
		tree.opt.editable = false;
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
{literal}	
	function disappear(){
		//alert(document.getElementById("area_title"));
		document.getElementById("nav").style.display = "none";
		document.getElementById("show_button").style.display = "";
		tmp = document.getElementById("textbook");
		tmp.onLoad = ResizeIframe(tmp);
	}
	function appear(){
		document.getElementById("nav").style.display = "";
		document.getElementById("show_button").style.display = "none";
		tmp = document.getElementById("textbook");
		tmp.onLoad = ResizeIframe(tmp);
	}
	function new_textbook_page(content_cd){
      // 避免原始頁面繼續算節點時數
	  document.getElementById("textbook").src = "";

      //--------------joyce edit 0305----------------------------- 
       var msg = "以下幾點操作事項請您務必注意：\n\n";
           msg += "1.瀏覽跳出教材時請勿把主視窗關閉，否則會無法紀錄您的時數。\n\n";
           msg += "2.為使您的時數正確紀錄，使用閱讀子視窗在教材播放時，主視窗請不要任意點選其他連結。\n\n";
           msg += "3.為避免閱讀時數無法記錄，請於登出前將閱讀子視窗關閉。";
       alert(msg);
      //---------------------------------------------------------

      url = "textbook_frame.php?content_cd="+content_cd; 
	  window.open(url,"教材分頁","location=no, toolbar=no, fullscreen=yes,resizable=no, scrollbars=auto");
	}

function ask_open_new_window(the_content_cd){
    if(confirm("是否另開視窗閱讀教材? 視窗有可能會被IE擋住，請自行開啟。") ) {
        new_textbook_page(the_content_cd);
    }

}
//<!-- 重算iframe-test的寬高 (frame撐不開) 要等到frame載入後才知道寬高
function calcHeight()
{
  //find the height of the internal pages
  var the_height=document.getElementById('textbook').contentWindow.document.body.scrollHeight;
  var the_width=document.getElementById('textbook').contentWindow.document.body.scrollWidth;
  //change the height of the iframe
  document.getElementById('content').height= the_height+40;
  document.getElementById('content').width = the_width;
  document.getElementById('textbook').height= the_height+40;
  document.getElementById('textbook').width = the_width;
  //alert(the_height+"=="+the_width);
}
//-->

//joyce add show_error btn 0324
function textbook_errortable_page(content_cd)
{
    var url = "textbook_error_content.php?content_cd="+content_cd;
        window.open(url,"教材內容錯誤列表","scrollbars=yes,resizable=yes,toolbar=no,location=no,status=yes");
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
<div id="contents" width="100%" height="100%">

    <div id="show_button" class="area_title" style="width:200px;display:none;cursor:pointer" onClick="appear();">
        <span class"imp" title="點擊顯示">
           <font size="2" color="#FF6600"><b>※顯示教材目錄</b></font>
        </span>
    </div>


	<div id="nav" style="float:left;width:20%;height:100%; overflow-x:hidden">
        <div class="area_title" style="none;cursor:pointer" id ="message_title" onClick="disappear();">
           <span class="imp" title="點擊隱藏"><font size="2">※教材目錄<BR>(點此隱藏目錄)</font></span>
        </div>

	    <div class="area" id="message" style="width:150px; height:500px; overflow:auto;">
            <script>tree.render();</script>
        <!-- joyce add show_error btn 0324 -->
            <br><br><input class="btn" type="button" value="教材勘誤表" onclick="textbook_errortable_page({$Content_cd});">
        </div>

        <div><br><input class="btn" type="button" value="另開新分頁" onclick="new_textbook_page({$Content_cd});"></div>

	    <div><br/><img src="{$script_path}nlstree/img/folder.gif">：未曾點閱<br/><img src="{$script_path}nlstree/img/mydocopen.gif">：曾經點閱</div>
    	</div>
        <div id="content" style="width:79%;height:500px;margin-top:8px; float:left;">
            <iframe style="width:100%; height:100%" id="textbook" scrolling="yes" onload="calcHeight()" name="textbook"  src="stu_start.php?content_cd={$Content_cd}&frame=0"></iframe>
	    </div>
	<div style="clear:both;"></div>
</div>

<script>
     ask_open_new_window({$Content_cd});
</script>


</body>
</html>
