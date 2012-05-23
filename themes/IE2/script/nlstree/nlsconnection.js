//------------------------------------------------------------
//NlsTree connection to server using XHTMLHttpRequest
//------------------------------------------------------------

//create XMLHttpRequest object to communicate to server
function createXMLHttpRequest() {
  if (typeof XMLHttpRequest != "undefined") { //for mozilla
    var httpReq=new XMLHttpRequest();
    return httpReq;
  } else {
    var arrObj=["MSXML2.XMLHttp.5.0", "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp", "Microsoft.XMHttp"];
    var oXml=null;
    for (var i=0; i<arrObj.length; i++) {
      try {
        oXml=new ActiveXObject(arrObj[i]);
        return oXml;
      } catch (e) { }     
    }
  }
}

//create temporary iframe to execute from XHTMLHttpRequest object
function nlsCreateExeFrame(id) {
  var frm=document.getElementById("exefrm_" + id);
  if (!frm) frm=document.createElement("iframe");
  frm.width=0; frm.height=0; frm.frameBorder=0;
  frm.name="exefrm_" + id;
  frm.id="exefrm_" + id;
  document.body.appendChild(frm);
  if (document.frames) {
    return document.frames["exefrm_" + id];
  } else {
    return frm.contentWindow;    
  }
}

//remove the temporary frame
function nlsRemoveExeFrame(id) {
  var frm = document.getElementById("exefrm_" + id);
  if (frm) document.body.removeChild(frm);
}

function NlsXMLHttpHandler() {
  this.tId=null;
  this.id=null;
  this.inId=null;
  this.xmlReq=null;
  this.anim=null;
  
  var me=this;
  this.init=function(mth, url, async) {
    this.xmlReq=createXMLHttpRequest();
    this.xmlReq.open(mth, url, true);
    this.xmlReq.onreadystatechange=me.readystatechange;
  }

  function executeResult(frm) {
      frm.document.open();
	  //alert(me.xmlReq.responseText);
      frm.document.write(me.xmlReq.responseText);
      frm.document.close();
      
      nlsRemoveExeFrame(me.id);
      if (me.inId) { clearInterval(me.inId); me.inId=null; if (me.anim!=null) me.anim.stop(); }
      if (me.xmlReq.status==200) {
        me.resultReady_Callback(me.tId, me.id);
      } else {
        alert("Error occur.");
      }    
  }
  
  this.readystatechange = function() {
    if (me.xmlReq.readyState==4) {
      var frm=nlsCreateExeFrame(me.id);
      window.setTimeout(function() {executeResult(frm);}, 10);
      
    } else {}
  }
  
  this.send=function(p) {
    if (this.anim!=null) this.inId=setInterval(me.anim.start, 1000);
    this.xmlReq.send(p);
  }
  
  this.resultReady_Callback=function() {return;}
}