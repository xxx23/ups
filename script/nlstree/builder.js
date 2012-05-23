var ADD_NODE_URL="addNode.php"; //or addnode.asp
var EDIT_NODE_URL="editNode.php"; //or editnode.asp
var DELETE_NODE_URL="deleteNode.php"; //or deletenode.asp

function showPropPanel(x, y) {
  var bdPanel=document.getElementById("bdPanel");
  bdPanel.style.left=(x?x:0);
  bdPanel.style.top=(y?y:0);
  bdPanel.style.display="block";
}

function hidePropPanel() {
  var bdPanel=document.getElementById("bdPanel");
  bdPanel.style.display="none";
}

function globalCtxMenu(selNode, menuId, itemId) {
  switch (itemId) {
    case "1":
      var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
      frm.location.href=ADD_NODE_URL+"?refid="+selNode.orgId+"&refpos=u";
      /*showPropPanel(250, 62);*/
      break;
    case "2":
      var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
      frm.location.href=DELETE_NODE_URL+"?refid="+selNode.orgId;
      /*showPropPanel(250, 62);*/
      break;
    case "3":
      var frm=(document.frames ? document.frames["frmBuilder"] : NlsGetElementById("frmBuilder").contentWindow);
      frm.location.href=EDIT_NODE_URL+"?refid="+selNode.orgId;
      /*showPropPanel(250, 62);*/
      break;
    case "9": //expand node
      tree.expandNode(tree.getSelNode().orgId);
      break;
    case "10": //collapse node
      tree.collapseNode(tree.getSelNode().orgId);
      break;
  }  
}

function contextMenuShow(selNode) {
}

function addNode_CALLBACK(id, parentId, caption, url, icon) {
  tree.expandNode(parentId);
  var expNode = tree.getNodeById(parentId);
  if (!expNode.xtra || expNode.xtra.loaded) {
    tree.append(id, parentId, caption, url, icon);
	
  }
  hidePropPanel();
}


function deleteNode_CALLBACK(id) {
  tree.remove(id);
  hidePropPanel();
}

function editNode_CALLBACK(id, caption, url, icon) {
  var expNode = tree.getNodeById(id);
  expNode.capt=caption;
  expNode.url=url;
  expNode.icon=icon.split(",");
  tree.reloadNode(id, false);
  hidePropPanel();
}
