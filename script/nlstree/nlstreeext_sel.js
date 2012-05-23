/**
* nlstreeext_sel.js v2.2
* NlsTree Extension : Multiple selection
* This file is property of AddObject.com
* You are not allowed to use this script or 
* part of this script indepently without any interaction 
* with NLSTree Professional.
* Copyright 2005-2006, addObject.com. All Rights Reserved
* Author Jack Hermanto, www.addobject.com
*/

StdOpt.prototype.multiSel=true;

//NLSTREE.msNds=new Object();

NLSTREE.treeOnSelectionAdd = function(id) { return true; };

NLSTREE.msToggle=function(nd) {  
  if (this.msNds[nd.id]!=null || (this.selNd!=null && this.selNd.equals(nd))) {
    this.msRemove(nd.orgId);
  } else {
    this.msAdd(nd);
  }
};

NLSTREE.msAdd=function(nd) {
  if (!this.treeOnSelectionAdd(nd.orgId)) {return;}
  /*remove selected not in the same hierarchy.*/
  if (this.getSelNodes().length==0) { this.selNd=nd; this.selElm=NlsGetElementById(nd.id);}
  var tmp=null;
  for (it in this.msNds) {
    tmp=this.msNds[it].pr;
    while (tmp!=null) {if (tmp.equals(nd)) {this.msRemove(this.msNds[it].orgId);break;} tmp=tmp.pr;}
  }
  tmp=nd.pr;
  while (tmp!=null) {if (this.isSelected(tmp.orgId)) this.msRemove(tmp.orgId); tmp=tmp.pr;}
  /*---*/
  this.msNds[nd.id]=nd;
  nls_setStyle(this, nd, NlsGetElementById(nd.id), true);
};

NLSTREE.msRemove=function(orgId) {
  var nd=this.getNodeById(orgId);
  if (this.selNd!=null && this.selNd.equals(nd)) {
    if (this.opt.icAsSel) nls_setNodeIcon(this, nd, NlsGetElementById(nd.id), false);
    if (this.opt.mntState && nls_setCookie) nls_removeCookie(this.tId+"_selnd");    
    this.selNd=null; this.selElm=null;
  }
  nls_setStyle(this, nd, NlsGetElementById(nd.id), false);
  delete this.msNds[nd.id];
};

NLSTREE.msRemoveAll=function() {
  var nd=null;
  for (var it in this.msNds) {
    nd=this.msNds[it];
    if (this.selNd==null || !this.selNd.equals(nd)) {
      nls_setStyle(this, nd, NlsGetElementById(nd.id), false);
      delete this.msNds[it];
    }
  }
  if (this.selNd!=null) this.msRemove(this.selNd.orgId);
  //this.msNds=new Object();
};

function nlsStopEvent(e) {
  if (e.cancelBubble) e.cancelBubble=false;
  if (e.stopPropagation) e.stopPropagation();
}

function nls_msTreeOnClick(e, tId, nId) {
  var t=nlsTree[tId]; var nd=t.nLst[nId];
  if (e.ctrlKey) { t.msToggle(nd); nlsStopEvent(e); return false; } 
  if (e.shiftKey) { 
    nlsStopEvent(e);
    //get start point.
    var sp=t.getSelNode();
    var sps = t.getSelNodes();
    if (sps.length==1) { sp=sps[0]; }
    if (sp && sp.pr && nd.pr && nd.pr.equals(sp.pr) && !nd.equals(sp)) {
      t.msRemoveAll();
      var tmp=sp.pr.fc; var flag=false;
      while(tmp) {
        if (tmp.equals(sp) || tmp.equals(nd)) {t.msAdd(tmp);flag=!flag;}
        if (flag) t.msAdd(tmp);
        tmp=tmp.nx
      }
    }
    return false; 
  }
  return true;
}