<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>課程管理頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
{literal}
<script type="text/JavaScript">
<!--
function display(option){
	document.getElementById("inner_contentA").style.display="none";
	//document.getElementById("inner_contentB").style.display="none";
	//document.getElementById("inner_contentC").style.display="none";
	//document.getElementById("inner_contentD").style.display="none";
	//document.getElementById("inner_contentE").style.display="none";
	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	//else if(option == 2){
	//	document.getElementById("inner_contentB").style.display = "";
	//	document.getElementsByTagName("body")[0].id = "tabB";
	//}
	//else if(option == 3){
	//	document.getElementById("inner_contentC").style.display = "";
	//	document.getElementsByTagName("body")[0].id = "tabC";
	//}
	//else if(option == 4){
	//	document.getElementById("inner_contentD").style.display = "";
	//	document.getElementsByTagName("body")[0].id = "tabD";
	//}
	//else{
	//	document.getElementById("inner_contentE").style.display = "";
	//	document.getElementsByTagName("body")[0].id = "tabE";
	//}
}

//ajax callback function取得id值
var content_name;
var degree;
var content_type;
var is_public;
var Content_cd;
function callBack(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			echo_str = xmlHttp.responseText;
			//alert(echo_str);
			split_str = echo_str.split(";");
			tmp_str = split_str[0].split(":");
			content_name = tmp_str[1]; //get content_name
			
			tmp_str = split_str[1].split(":");
			degree = tmp_str[1];	//get degree
			
			tmp_str = split_str[2].split(":");
			content_type = tmp_str[1];	//get content_type
			
			tmp_str = split_str[3].split(":");
			is_public = tmp_str[1];		//get is_public
			display_content();
		}
	}
}

function display_content()
{
	document.getElementById("textbook_name_mod").setAttribute("value", content_name);
	document.getElementById("modify_difficulty").childNodes.item(degree*2+1).setAttribute("selected", "selected");
	document.getElementById("modify_attributes").childNodes.item(content_type*2+1).setAttribute("selected", "selected");
	document.getElementById("modify_isPublic").childNodes.item(is_public*2+1).setAttribute("selected", "selected");
	document.getElementById("modify_content_cd").setAttribute("value", Content_cd);
	if(Content_cd == 0)
		document.getElementById("modify").style.display = "none";
	else
		document.getElementById("modify").style.display = "";
}

function lookup_textbook(index)
{
	if(window.ActiveXObject){
	  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
	  xmlHttp = new XMLHttpRequest();
    }
	Content_cd = document.getElementById("mod_textbook_this").item(index).getAttribute("value");
	//alert(Content_cd);
    //等待server傳回給node_id後，才往下執行
	xmlHttp.open("GET","/Teaching_Material/ajax/ret_textbook_attr.php?content_cd="+Content_cd,false);
    xmlHttp.onReadyStateChange = callBack;
    xmlHttp.send(null);
	//alert(echo_str);
}

function Check_create()
{	
	if(document.getElementById("textbook_name").value == ""){
		alert("請輸入教材名稱!");
		return false;
	}
}
function Check_modify()
{	
	if(document.getElementById("textbook_name_mod").value == ""){
		alert("請輸入教材名稱!");
		return false;
	}
}

function export_textbook(index){
	Content_cd = document.getElementById("export_textbook_this").item(index).getAttribute("value");
	document.getElementById("show_export").src = "export_textbook.php?content_cd="+Content_cd;
	document.getElementById("show_export").style.display = "";
}

function delete_confirm(){
	if(confirm("確定要刪除整份教材(包含本教材其下所有目錄與檔案)?"))
		return true;
	else
		return false;
}

//-->{literal}
</script>
{/literal}
</head>
<body id="tabA">
<h1>課程管理工具</h1>


<div class="tab">
  <ul id="tabnav">
    <li class="tabA" onClick="display(1)">目前課程</li>
    <!--
    <li class="tabB" onClick="display(2)">教材新增</li>
    <li class="tabC" onClick="display(3)">教材修改</li>
    <li class="tabD" onClick="display(4)">教材刪除</li>
    <li class="tabE" onClick="display(5)">教材匯出</li>
    -->		
  </ul>
</div>
<div id="inner_contentA">
  <p class="intro">目前本課程所用的課程為：<span class="imp">{$course_name}</span><br/>
  這份課程的作者為：<span class="imp">{$teacher_name}</span></p>

  <form name="update_course" action="course_manage.php{$op_begin_course_cd}" method="post">
    <fieldset>
    <legend>修改本課程所用的課程</legend>
    <p>請選擇課程：
      {html_options name = course_cd id = course_cd values=$course_list_options_values selected=$course_list_options_selected output=$course_list_options_output}
      <input class="btn" type="submit" name="submit_update" value="確定更新"><span class="msg">{$update_status}</span>
      </br>
    (列表為您的個人課程列表) </p>  <p>.</p></fieldset>

  </form>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>



<!--
<div class="inner_contentB" id="inner_contentB" style="display:none;">
    <fieldset><form name="create_textbook" action="textbook_manage.php" method="post">
      <legend>手動新增教材</legend>
      <table width="200" border="1" class="form">
		<caption>      請輸入以下資料</caption>
        <tr>
          <th>教材名稱：(中間勿有空格)</th>
          <td><input type="text" name="textbook_name" id="textbook_name" /></td>
        </tr>
        <tr>
          <th>教材屬性：</th>
          <td><select name="select" id="create_attributes">
            <option>scorm 1.2</option>
            <option>scorm 2004</option>
            <option>其它</option>
          </select></td>
        </tr>
        <tr>
          <th>難易度：</th>
          <td><select name="select2" id="create_difficulty">
            <option value="0">未知</option>
            <option value="1">易</option>
            <option value="2">中</option>
            <option value="3">難</option>
          </select></td>
        </tr>
        <tr>
          <th>是否公開：</th>
          <td><select name="select3" id="create_isPublic">
            <option>否</option>
            <option>是</option>
          </select></td>
        </tr>
      </table>
      <div class="buttons">
         <input name="submit_create" type="submit" class="btn" onClick="return Check_create();" value="新增教材">  
	     <input type="submit" class="btn" name="create_and_edit" value="新增並進入編輯" onClick="return Check_create();">
         <input type="hidden" name="submit_content_cd" id="create_content_cd"value=""></div>
    </form></fieldset>

    <fieldset><legend>匯入外部檔案做為教材 </legend>
    <table width="200" border="1" class="form">
      <tr>
        <td><form action="import_material.php" enctype="multipart/form-data" method="POST" name="upload_import" id="upload_import">
      匯入此平台匯出的檔案格式：
      <input type="hidden" name="content_type" value="0"/>
      <input type="file" name="material" class="btn"/>
      <input class="btn" type="submit" value="確定上傳" />
    </form></td>
      </tr>
      <tr>
        <td><form action="import_material.php" method="POST" enctype="multipart/form-data" name="upload_import" id="upload_import">
          匯入scorm 1.2 教材格式：
	  <input type="hidden" name="content_type" value="1"/>
          <input type="file" name="material" class="btn"/>
      <input class="btn" type="submit" value="確定上傳" />
        </form></td>
      </tr>
      <tr>
        <td><form action="import_material.php" method="POST" enctype="multipart/form-data" name="upload_import" id="upload_import">
          匯入scorm 2004 教材格式：
	  <input type="hidden" name="content_type" value="2"/>
          <input type="file" name="material" class="btn"/>
      <input class="btn" type="submit" value="確定上傳" />
        </form></td>
      </tr>
    </table>
    </fieldset>
</div>




<div class="inner_contentC" id="inner_contentC" style="display:none;">
  <form name="modify_textbook" action="textbook_manage.php" method="post">
    <fieldset><legend>修改教材名稱、屬性</legend>
	 <p class="intro">欲修改的教材：
    <select name="mod_textbook_this" id="mod_textbook_this" onChange="lookup_textbook(this.selectedIndex)">
	{foreach from=$tbArray key=k item=i}
      <option id="{$k}" value="{$k}">{$i}</option>
	{/foreach}
    </select></p>
    <div id="modify" style="display:none;">
      <table width="200" border="1" class="form">
        <tr>
          <th>教材名稱：</th>
          <td><input type="text" name="textbook_name" id="textbook_name_mod" value="{$mod_textbook_name}"/></td>
        </tr>
        <tr>
          <th>難易度： </th>
          <td><select name="difficulty" id="modify_difficulty">
            <option value="0">未知</option>
            <option value="1">易</option>
            <option value="2">中</option>
            <option value="3">難</option>
          </select></td>
        </tr>
        <tr>
          <th>教材屬性：</th>
          <td><select name="attributes" id="modify_attributes">
            <option>scorm 1.2</option>
            <option>scorm 2004</option>
            <option>其它</option>
          </select></td>
        </tr>
        <tr>
          <th>是否公開： </th>
          <td><select name="isPublic" id="modify_isPublic">
            <option>否</option>
            <option>是</option>
          </select></td>
        </tr>
      </table>
      <div class="buttons">
        <input type="hidden" name="modify_content_cd" id="modify_content_cd" value=""><br />
        <input type="submit" name="modify_and_edit" id="modify_and_edit" class="btn" value="編輯教材詳細內容" onClick="return Check_modify();">
		<input class="btn" type="submit" name="submit_modify" value="確定修改" onClick="return Check_modify();">
        </div>
    </div>
  </form>
</div>



<div class="inner_contentD" id="inner_contentD" style="display:none;">
  <form name="delete_textbook" action="textbook_manage.php" method="post">
    <fieldset><legend>刪除整份教材</legend>
    <p class="intro">欲刪除的教材：
    {html_options name = del_textbook_this options=$textbook_opt selected=$textbook_slt}
    <input type="submit" name="del_textbook" id="del_textbook" class="btn" value="確定刪除" onClick="return delete_confirm();"></p>
  </form>
</div>


<div class="inner_contentE" id="inner_contentE" style="display:none;">
  <fieldset><legend>匯出整份教材</legend>
  <p class="intro">欲匯出的教材：
  <select name="export_textbook_this" id="export_textbook_this" onChange="export_textbook(this.selectedIndex)">
				{foreach from=$tbArray key=k item=i}
    <option id="{$k}" value="{$k}">{$i}</option>
				{/foreach}
  </select></p>
  
  <iframe name="show_export" id = "show_export" onload="ResizeIframe(this);" src="./export_textbook.php?" style="display:none; "> </iframe></fieldset>
</div>
-->
<!--</div>-->
</body>
</html>
