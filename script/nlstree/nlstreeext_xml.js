/**
* nlstreeext_xml.js v2.2
* NlsTree Extension : XML
* This file is property of addobject.com
* You are not allowed to use this script or 
* part of this script indepently without any interaction 
* with NLSTree Professional.
* Copyright 2005-2006, addobject.com. All Rights Reserved
* Author Jack Hermanto, www.addobject.com
*/

//NlsNode extension functions for XML
NlsNode.prototype.xmlOpn=function() {
  return "<node id=\""+this.orgId+"\" caption=\""+this.capt+"\" url=\""+this.url+"\" ic=\""+(this.ic==null?"":this.ic)+"\" exp=\""+this.exp+"\" chk=\""+this.chk+"\" cststyle=\""+this.cstStyle+"\" target=\""+this.trg+"\" title=\""+this.title+"\">";
};

NlsNode.prototype.xmlCls=function() { return "</node>"; };

//StdOpt extension function for XML
StdOpt.prototype.toXML=function() {
  var optXml="<options>\n";
  optXml+="  <opt name=\"target\" value=\""+this.trg+"\"></opt>\n";
  optXml+="  <opt name=\"stlprf\" value=\""+this.stlprf+"\"></opt>\n";
  optXml+="  <opt name=\"sort\" value=\""+this.sort+"\"></opt>\n";
  optXml+="  <opt name=\"icon\" value=\""+this.icon+"\"></opt>\n";
  optXml+="  <opt name=\"check\" value=\""+this.check+"\"></opt>\n";
  optXml+="  <opt name=\"editable\" value=\""+this.editable+"\"></opt>\n";
  optXml+="  <opt name=\"selrow\" value=\""+this.selRow+"\"></opt>\n";
  optXml+="  <opt name=\"editkey\" value=\""+this.editKey+"\"></opt>\n";
  optXml+="  <opt name=\"oneexp\" value=\""+this.oneExp+"\"></opt>\n";
  optXml+="  <opt name=\"enablectx\" value=\""+this.enableCtx+"\"></opt>\n";
  optXml+="  <opt name=\"oneclick\" value=\""+this.oneClick+"\"></opt>\n";
  optXml+="  <opt name=\"mntstate\" value=\""+this.mntState+"\"></opt>\n";
  optXml+="  <opt name=\"icassel\" value=\""+this.icAsSel+"\"></opt>\n";
  optXml+="  <opt name=\"checkincsub\" value=\""+this.checkIncSub+"\"></opt>\n";
  optXml+="  <opt name=\"checkonleaf\" value=\""+this.checkOnLeaf+"\"></opt>\n";
  optXml+="  <opt name=\"hideroot\" value=\""+this.hideRoot+"\"></opt>\n";
  optXml+="  <opt name=\"indent\" value=\""+this.indent+"\"></opt>\n";

  optXml+="  <opt name=\"evdblclick\" value=\""+this.evDblClick+"\"></opt>\n";
  optXml+="  <opt name=\"evctxmenu\" value=\""+this.evCtxMenu+"\"></opt>\n";
  optXml+="  <opt name=\"evmouseup\" value=\""+this.evMouseUp+"\"></opt>\n";
  optXml+="  <opt name=\"evmousedown\" value=\""+this.evMouseDown+"\"></opt>\n";
  optXml+="  <opt name=\"evmousemove\" value=\""+this.evMouseMove+"\"></opt>\n";
  optXml+="  <opt name=\"evmouseout\" value=\""+this.evMouseOut+"\"></opt>\n";
  optXml+="  <opt name=\"evmouseover\" value=\""+this.evMouseOver+"\"></opt>\n";
  
  optXml+="</options>\n";
  return optXml;
};

//StdIco extension function for XML
StdIco.prototype.toXML=function() {
  var icoXml="<icons>\n";
  icoXml+="  <ico name=\"pnb\" value=\""+this.pnb+"\"></ico>\n";
  icoXml+="  <ico name=\"pb\" value=\""+this.pb+"\"></ico>\n";
  icoXml+="  <ico name=\"mnb\" value=\""+this.mnb+"\"></ico>\n";
  icoXml+="  <ico name=\"mb\" value=\""+this.mb+"\"></ico>\n";
  icoXml+="  <ico name=\"opf\" value=\""+this.opf+"\"></ico>\n";
  icoXml+="  <ico name=\"clf\" value=\""+this.clf+"\"></ico>\n";
  icoXml+="  <ico name=\"chd\" value=\""+this.chd+"\"></ico>\n";
  icoXml+="  <ico name=\"rot\" value=\""+this.rot+"\"></ico>\n";
  icoXml+="  <ico name=\"lnb\" value=\""+this.lnb+"\"></ico>\n";
  icoXml+="  <ico name=\"lb\" value=\""+this.lb+"\"></ico>\n";
  icoXml+="  <ico name=\"lin\" value=\""+this.lin+"\"></ico>\n";
  icoXml+="  <ico name=\"bln\" value=\""+this.bln+"\"></ico>\n";
  icoXml+="</icons>\n";
  return icoXml;
};

//NlsTree extension functions for XML
NlsTree.prototype.nodeXML = function(sNd) {
  sNd=(sNd==null?this.rt:sNd);
  var n=sNd; var spc="";
  while (n != null && !n.equals(this.rt)) { spc+="  "; n=n.pr;}    
  var s=(spc+sNd.xmlOpn()+"\n");
  if (sNd.fc !=null) {
      var chNode = sNd.fc;
      do {
          s+=this.nodeXML(chNode);
          chNode = chNode.nx;
      } while (chNode != null)
  }
  s+=(spc+sNd.xmlCls()+"\n");
  return s;
};

NlsTree.prototype.toXML=function() {
  return "<tree id=\""+this.tId+"\">\n" + this.opt.toXML() + this.ico.toXML() + this.nodeXML(this.rt) + "</tree>";
};

function nls_addNodeXML(tree, prnId, xnd) {
  for (var i=0; i<xnd.childNodes.length; i++) {
    var nd=xnd.childNodes[i];
    if (nd.nodeType!=1) continue;
    var newNd=tree.add(nd.getAttribute("id"), prnId, nd.getAttribute("caption"), nd.getAttribute("url"), nd.getAttribute("ic"), nd.getAttribute("exp")=="true", nd.getAttribute("chk")=="true", null, nd.getAttribute("title"));
    newNd.cstStyle=nd.getAttribute("cststyle");
    newNd.trg=nd.getAttribute("target");
    if (nd.firstChild!=null) nls_addNodeXML(tree, newNd.orgId, nd);
  }
};

NlsTree.prototype.addNodesXML=function(prn, rn, reload) {
  if (rn==null) return;
  var newNd=this.add(rn.getAttribute("id"), prn, rn.getAttribute("caption"), rn.getAttribute("url"), rn.getAttribute("ic"), rn.getAttribute("exp")=="true", rn.getAttribute("chk")=="true", null, rn.getAttribute("title"));
  newNd.cstStyle=rn.getAttribute("cststyle");
  newNd.trg=rn.getAttribute("target");
  
  nls_addNodeXML(this, newNd.orgId, rn);
  if (reload) {
    this.reloadNode(prn);
  }
};

NlsTree.prototype.addNodesXMLString=function(prn, xml, reload) {
  var xmlDom=nls_createXMLDom(xml);
  if (xmlDom) this.addNodesXML(prn, xmlDom.documentElement, reload);
};

NlsTree.prototype.addChildNodesXML=function(rn, reload, updateParent) {
  if (rn==null) return;
  if (updateParent) {
    var nd=this.getNodeById(rn.getAttribute("id"));
    nd.capt=rn.getAttribute("caption");
    nd.url=rn.getAttribute("url");
    nd.ic=rn.getAttribute("ic")==""?null:rn.getAttribute("ic").split(",");
    nd.exp=rn.getAttribute("exp")=="true";;
    nd.chk=rn.getAttribute("chk")=="true";
    nd.cstStyle=rn.getAttribute("cststyle");
    nd.trg=rn.getAttribute("target")=="null"?null:rn.getAttribute("target");
    nd.title=rn.getAttribute("title");
  }
  nls_addNodeXML(this, rn.getAttribute("id"), rn);
  if (reload) {
    this.reloadNode(rn.getAttribute("id"));
  }
};

NlsTree.prototype.addChildNodesXMLString=function(xml, reload, updateParent) {
  var xmlDom=nls_createXMLDom(xml);
  if (xmlDom) this.addChildNodesXML(xmlDom.documentElement, reload, updateParent);
};

NlsTree.prototype.setOptionsByXML=function(xopt) {
  var o=this.opt;
  for (var i=0; i<xopt.childNodes.length; i++) {
    var n=xopt.childNodes[i];
    if (n.nodeType!=1) continue;
    var v=n.getAttribute("value");
    switch (n.getAttribute("name")) {
      case "target": o.trg=v; break;
      case "stlprf": o.stlprf=v; break;
      case "sort": o.sort=v; break;
      case "icon": o.icon=(v=="true"); break;
      case "check": o.check=(v=="true"); break;
      case "editable": o.editable=(v=="true"); break;
      case "selrow": o.selRow=(v=="true"); break;
      case "editkey": o.editKey=v; break;
      case "oneexp": o.oneExp=(v=="true"); break;
      case "enablectx": o.enableCtx=(v=="true"); break;
      case "oneclick": o.oneClick=(v=="true"); break;
      case "mntstate": o.mnState=(v=="true"); break;
      case "icassel": o.icAsSel=(v=="true"); break;
      case "checkincsub": o.checkIncSub=(v=="true"); break;
      case "checkonleaf": o.checkOnLeaf=(v=="true"); break;
      case "hideroot": o.hideRoot=(v=="true"); break;
      case "indent": o.indent=(v=="true"); break;
      case "evdblclick": o.evDblClick=(v=="true"); break;
      case "evctxmenu": o.evCtxMenu=(v=="true"); break;
      case "evmouseup": o.evMouseUp=(v=="true"); break;
      case "evmousedown": o.evMouseDown=(v=="true"); break;
      case "evmousemove": o.evMouseMove=(v=="true"); break;
      case "evmouseout": o.evMouseOut=(v=="true"); break;
      case "evmouseover": o.evMouseOver=(v=="true"); break; 
    }
  }
}

NlsTree.prototype.setIconsByXML=function(xico) {
  var c=this.ico;
  for (var i=0; i<xico.childNodes.length; i++) {
    var n=xico.childNodes[i];
    if (n.nodeType!=1) continue;
    var v=n.getAttribute("value");
    switch (n.getAttribute("name")) {
      case "pnb": c.pnb=v; break;
      case "pb": c.pb=v; break;
      case "mnb": c.mnb=v; break;
      case "mb": c.mb=v; break;
      case "opf": c.opf=v; break;
      case "clf": c.clf=v; break;
      case "chd": c.chd=v; break;
      case "rot": c.rot=v; break;
      case "lnb": c.lnb=v; break;
      case "lb": c.lb=v; break;
      case "lin": c.lin=v; break;
      case "bln": c.bln=v; break;
    }
  }
  this.useIconSet(c);
}

//load tree from XML.
NlsTree.prototype.loadFromXML=function(xml) {

  var txml=nls_createXMLDom(xml);
  var rt=txml.documentElement;
  
  //set tree options
  for (var i=0; i<rt.childNodes.length; i++) {
    var n=rt.childNodes[i];
    if (n.nodeType==1) {
      if (n.nodeName=="options") {
        this.setOptionsByXML(n);
      } else
      if (n.nodeName=="icons") {
        this.setIconsByXML(n);
      } else 
      if (n.nodeName=="node") {
        //add root node
        this.addNodesXML("root", n, false);
      }
    }
  }
}

function nls_createXMLDom(xml) {
  var ieXML=["MSXML2.DOMDocument.5.0", "MSXML2.DOMDocument.4.0", "MSXML2.DOMDocument.3.0", "MSXML2.DOMDocument", "Microsoft.XmlDom"];
  var xmlDom=null;
  if (typeof DOMParser != "undefined") {
    //gecko browser xml dom
    var parser=new DOMParser();
    xmlDom = parser.parseFromString(xml, "text/xml");
  } else {
    for (var i=0; i<ieXML.length; i++) {
      try {
        xmlDom=new ActiveXObject(ieXML[i]);
        xmlDom.loadXML(xml);
      } catch (e) {
      }
    }
  }
  return xmlDom;
};