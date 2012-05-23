//----------------------------------------------------------------
//Update Node Text/Caption
//----------------------------------------------------------------
var MOVE_TREE_NODE_URL="movenode.php";

function saveMovedNode(c, ddss, type) {
  c.setTimeout(CONNECTION_TIMEOUT);
  c.win.location.href=MOVE_TREE_NODE_URL+"?srctid=" + ddss.srcObj.tId + "&srcnid=" + ddss.srcData.orgId + "&dsttid=" + ddss.destObj.tId + "&dstnid=" + ddss.destData.orgId + "&mtype=" + type;
}

function onNodeDropForUpdate(e) {
  //process
  if (!nlsddSession) return;
  if(!nlsddSession.action) return;

  if (nlsddSession.srcObj.tId==nlsddSession.destObj.tId) { //drag drop in a tree
    switch (nlsddSession.action) {
      case NlsDDAction.DD_INSERT:
        
        var ddss=new NlsDDSession(nlsddSession.srcObj, nlsddSession.srcData);
        ddss.destObj=nlsddSession.destObj;
        ddss.destData=nlsddSession.destData;
        
        if (!ddss.srcData || ddss.srcData.length!=1) return;
        if (ddss.srcObj.isSelected(ddss.destData.orgId)) return;
        if (ddss.destData.equals(ddss.srcObj.rt)) return;
        if (ddss.srcData[0].nx && ddss.destData.equals(ddss.srcData[0].nx)) return;

        var c=new NlsXMLHttpHandler();
        c.tId=nlsddSession.srcObj.tId;
        c.id=nlsddSession.srcData[0].orgId;

        c.anim=new AnimateSave();
        c.anim.tree=nlsddSession.srcObj;
        c.anim.nId=nlsddSession.srcData[0].orgId;  

        c.init("get", MOVE_TREE_NODE_URL + "?srctid=" + ddss.srcObj.tId + "&srcnid=" + ddss.srcData[0].orgId + "&dsttid=" + ddss.destObj.tId + "&dstnid=" + ddss.destData.orgId + "&mtype=" + 2, true);    
        c.send(null);
      
        this.tree.moveChild(nlsddSession.srcData, nlsddSession.destData, 2);        
        break;
      case NlsDDAction.DD_APPEND: 
        var ddss=new NlsDDSession(nlsddSession.srcObj, nlsddSession.srcData);
        ddss.destObj=nlsddSession.destObj;
        ddss.destData=nlsddSession.destData;

        if (!ddss.srcData || ddss.srcData.length!=1) return;
        if (ddss.srcObj.isSelected(ddss.destData.orgId)) return;
        if (ddss.srcData[0].equals(ddss.srcObj.rt)) return;
        if (ddss.srcData[0].pr.equals(ddss.destData)) return;

        if (!ddss.destData.xtra || ddss.destData.xtra.loaded) {

          var c=new NlsXMLHttpHandler();
          c.tId=ddss.srcObj.tId;
          c.id=ddss.srcData[0].orgId;
          
          c.anim=new AnimateSave();
          c.anim.tree=ddss.srcObj;
          c.anim.nId=ddss.srcData[0].orgId;           
          
          c.init("get", MOVE_TREE_NODE_URL + "?srctid=" + ddss.srcObj.tId + "&srcnid=" + ddss.srcData[0].orgId + "&dsttid=" + ddss.destObj.tId + "&dstnid=" + ddss.destData.orgId + "&mtype=" + 1, true);    
          c.send(null);
          
          this.tree.moveChild(ddss.srcData, ddss.destData, 1);
        } else {
          alert("Please expand the target node first.");
        }
        break;
    }
  }
}

//----------------------------------------------------------------
//Update Node Text/Caption
//----------------------------------------------------------------
var SAVE_NODE_CAPT_URL="saveNodeCaption.php";

function onNodeChange(id) {
  var c=new NlsXMLHttpHandler();
  c.tId=this.tId;
  c.id=id;
  c.anim=new AnimateSave();
  c.anim.tree=this;
  c.anim.nId=id;  
  
  var nd=this.getNodeById(id);
  //alert(nd.capt);
  c.init("get", SAVE_NODE_CAPT_URL+"?nid=" + id + "&caption=" + encodeURIComponent(nd.capt), true); //將字串轉成uri，否則IE中文字有問題
  c.send(null);
};

//animate tree node while loading.
function AnimateSave() {
  this.tree=null;
  this.nId=null;
  this.count=1;
  
  var me=this;
  
  this.start=function() {
    var animDiv=NlsGetElementById("utilDiv");
    animDiv.innerHTML="Saving...(" + me.count++ + ")";
    animDiv.style.display="block";
  };
  this.stop=function() { 
    var animDiv=NlsGetElementById("utilDiv");
    //animDiv.style.display="none";
    me.count=1; 
    return; 
  };
};

