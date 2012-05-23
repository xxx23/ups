/*author: lunsrot
  date: 2007/04/27
  */
var tree;
var WEBROOT;

function assign(input){
//input的型態為Nlstree
  tree = input;
}

function get_webroot(){
  var tmp = $('information').innerHTML.split("=");
  WEBROOT = tmp[1];
}

function setTree(){
  tree.opt.mntState = true;
  tree.opt.selRow = true;
  tree.opt.enableCtx = true;
  tree.opt.editable = true ;
  tree.opt.sort = "no";
  tree.treeOnNodeChange = function(id){changeNode(id);};
}

function createNewGroup(root_cd){
  var xmlHttp = createXMLHttpRequest();
  var url = "ajax/create_title.php";

  xmlHttp.onreadystatechange = function(){CREATE_TITLE(xmlHttp)};
  xmlHttp.open("GET", url + "?title_name=New_Node", false);
  xmlHttp.send(null);
}

function changeNode(id){
	var node = tree.getNodeById(id);
	var xmlHttp = createXMLHttpRequest();
	var url = "ajax/modify_title.php";
	if(id == "root")
		return -1;

	xmlHttp.onreadystatechange = function(){MODIFY_TITLE(xmlHttp, node);};
	xmlHttp.open("GET", url + "?index=" + id + "&name=" + encodeURIComponent(node.capt));
	xmlHttp.send(null);
}

function editGroup(selNode){
  document.getElementById("question").setAttribute("src", "tea_group_edit.php?survey_cd=" + selNode.orgId);
}

function delete_all(selNode){
  if(confirm("確定要刪除此題組及其下的所有題目？")){
    var xmlHttp = createXMLHttpRequest();
    var url = "ajax/delete_all.php";

    xmlHttp.onreadystatechange = function (){DELETE_ALL(xmlHttp, selNode);};
    xmlHttp.open("GET", url + "?survey_cd=" + selNode.orgId, false);
    xmlHttp.send(null);
  }
}

//ajax
function createXMLHttpRequest(){
  if(window.ActiveXObject)
    return new ActiveXObject("Microsoft.XMLHTTP");
  else if(window.XMLHttpRequest)
    return new XMLHttpRequest();
}

function CREATE_TITLE(xmlHttp){
  if(xmlHttp.readyState == 4){
    if(xmlHttp.status == 200){
      var tmp = xmlHttp.responseText;
      if(tmp == -1){
        alert("New_Node名稱重複");
      }else{
        var str = tmp.split(";");
        tree.append(str[1], "root", str[0], null, WEBROOT+"script/nlstree/img/folder.gif", false);
	document.getElementById("question").setAttribute("src", "tea_group_edit.php?survey_cd=" + str[1]);
      }
    }
  }
}

function MODIFY_TITLE(xmlHttp, node){
  if(xmlHttp.readyState == 4){
    if(xmlHttp.status == 200){
      var tmp = xmlHttp.responseText;
      var str = tmp.split(";");
      if(str[0] == "false")
        alert("名稱重複");
      node.capt = str[1];
      tree.reloadNode(node.orgId, true);
    }
  }
}

function DELETE_ALL(xmlHttp, node){
  if(xmlHttp.readyState == 4){
    if(xmlHttp.status == 200){
      tree.remove(node.orgId, true);
    }
  }
}

//tab控制
function view(str, tab){
  document.getElementById("view").style.display = "none";
  document.getElementById("update").style.display = "none";
  document.getElementById(str).style.display = "";
  var tmp = document.getElementsByTagName("body")[0];
  tmp.setAttribute("id", tab);
}

function _onsubmit(str){
//  if(confirm("是否繼續編輯其他題目？"))
//    document.getElementById("continue_" + str).setAttribute("value", 1);
//  else
    document.getElementById("continue_" + str).setAttribute("value", 0);

  if(str == "add")
    document.form_add.submit();
  else 
    document.form_del.submit();
}

//only for 教師在問卷設定配分用
function calReadOnly(survey_cd){
  var tmp = document.getElementsByName("survey_" + survey_cd + "[]");
  for(var i = 0 ; i < tmp.length ; i++){
   tmp[i].readOnly = false;
  }
}
