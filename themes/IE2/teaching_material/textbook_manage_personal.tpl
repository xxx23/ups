<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材管理頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" scr="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>

{literal}
<script type="text/JavaScript">
<!--
function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
	document.getElementById("inner_contentF").style.display="none";
	document.getElementById("inner_contentI").style.display="none";
	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else if(option == 2){
		document.getElementById("inner_contentB").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
	else if(option == 6){
		document.getElementById("inner_contentF").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabF";
		}

}


// ************ joyce add for download condiction  ************ ************ ************ 
function choose_license_func(op,option)
{

    if(option==1)//開放自由使用
	{
		document.getElementById(op+"_license_cc").style.display="none";
        document.getElementById(op+"_edusample").style.display="none";
		document.getElementById(op+"_announce").style.display="";
        document.getElementById(op+"_rule").style.display="";
		document.getElementById(op+"_announce_text").value="";
		document.getElementById(op+"_rule_text").value="";
	}	
	else if(option==9)//說明授權情形
	{	
		document.getElementById(op+"_license_cc").style.display="none";
		document.getElementById(op+"_announce").style.display="none";
        document.getElementById(op+"_rule").style.display="none";
        document.getElementById(op+"_edusample").style.display="";
	}	
	else
	{
		if(option == 2 && op==0)
			document.create_textbook.license[2].checked = true;
		else if(option == 2 && op==1)
			document.getElementById("cc_default").checked=true

		document.getElementById(op+"_license_cc").style.display="";
        document.getElementById(op+"_announce").style.display="none";
        document.getElementById(op+"_rule").style.display="none";	
        document.getElementById(op+"_edusample").style.display="none";
	}

}
function isDownload_func(op,option)//joyce add 0330
{
//alert("modify_isDownload_func = " + option);
    if(option==1)
    {
         document.getElementById(op+"_downloadRole").style.display="";
		 document.getElementById(op+"_license").style.display="";
    }     
    else
    {
        document.getElementById(op+"_downloadRole").style.display="none";
		document.getElementById(op+"_license").style.display="none";
    }     
}

// ************ ************ ************ ************ ************ ************ 

//ajax callback function取得id值
var content_name;
var degree;
var content_type;
var is_public;
var Content_cd;
var echo_str;
var edit_new_row_index ;
var total_table_row ;

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
function hidden_export(){
	document.getElementById("show_export").style.display = "none"; 
	document.getElementById("hidden_export").style.display ="none";
}

function display_content()
{
	document.getElementById("textbook_name_mod").setAttribute("value", content_name);
	document.getElementById("modify_difficulty").childNodes.item(degree*2+1).setAttribute("selected", "selected");
	if(content_type == 3 || content_type == 4)
	{
		document.getElementById("modify_attributes").style.display = "none"; 
		document.getElementById("modify_attributes_text").style.display = ""; 
		if(content_type == 3)
			modify_attributes_text ='SCORM_1.2';
		else
			modify_attributes_text ='SCORM_2004';
		document.getElementById("modify_attributes_text").setAttribute("value", modify_attributes_text);
	}
	else
	{
		document.getElementById("modify_attributes").style.display = ""; 
		document.getElementById("modify_attributes_text").style.display = "none"; 
		document.getElementById("modify_attributes").childNodes.item(content_type*2+1).setAttribute("selected", "selected");
	}
	document.getElementById("modify_isPublic").childNodes.item(is_public*2+1).setAttribute("selected", "selected");
	document.getElementById("modify_content_cd").setAttribute("value", Content_cd);

}

function do_delete_textbook(Content_cd, lock_or_not) {
	if(lock_or_not == 1) {
		alert("教材指定使用中，不能刪除");
		return ;
	}else{
		if(confirm("確定要刪除整份教材(包含本教材其下所有目錄與檔案)?")) {
			document.getElementById("del_textbook_this").value= Content_cd;
			document.getElementById("hidden_delete_textbook").submit();
		}
		else{
			return ;// 使用者不要刪除
		}
	}
}

function restore_lock_all(){
	for(var i=1; i<=total_table_row; i++) {
			document.getElementById("edit_bt_" + i).disabled = false;
	}
}

function lock_all(except_index)
{
	for(var i=1; i<=total_table_row; i++) {
		if(i != except_index)
			document.getElementById("edit_bt_" + i).disabled = true;
	}

}

function restore_edit()
{
	document.getElementById("textbook_list").deleteRow(edit_new_row_index+1);
	document.getElementById("edit_bt_" + edit_new_row_index).style.display = "" ;
	document.getElementById("edit_bt2_" + edit_new_row_index).style.display = "none";
	restore_lock_all();
}

function lookup_textbook(this_content_cd, row_index)
{
	var tr = document.getElementById("textbook_list").insertRow(row_index+1);
	var td = tr.insertCell(0);
	td.colSpan = "5";
	edit_new_row_index = row_index;
	td.innerHTML = document.getElementById("modify").innerHTML;
	//document.getElementById("modify").innerHTML ="";
	Content_cd = this_content_cd;
	
	lock_all(row_index) ; 
	
	document.getElementById("edit_bt_" + row_index).style.display = "none" ;
	document.getElementById("edit_bt2_" + row_index).style.display = "";
	
	if(window.ActiveXObject){//IE
	  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	  type = 0;
	}
	else if(window.XMLHttpRequest){// Mozilla, Safari, ...
	  xmlHttp = new XMLHttpRequest();
	  xmlHttp.overrideMimeType('text/xml');
	  type = 1;
    }

	xmlHttp.open("GET","./ajax/ret_textbook_attr.php?content_cd="+this_content_cd,false);
    xmlHttp.onReadyStateChange = (type == 0)?callBack : callBack();
    xmlHttp.send(null);
	xmlHttp.onReadyStateChange = (type == 0)?callBack : callBack();
	//alert(echo_str);
}

function Check_create(frm)
{	
	if(document.getElementById("isDownload").value == 1)
	{
		//var obj=document.getElementsByName("checkbox_0");
        //var len = obj.length;
        var es = frm.elements["checkbox_0"];
        var checked = false;

        for (i = 0; i < 5; i++)
        {
            if (es[i].checked == true)
            {
                checked = true;
                break;
            }
        }
		if(!checked)
		{
			alert("請勾選下載使用者身分!");
            return false;
		}
	}
	if(document.getElementById("textbook_name").value == ""){
		alert("請輸入教材名稱!");
		return false;
	}

    if(document.getElementById("textbook_name").value.match(/<\S[^><]*>/g)!=null){
       alert("輸入含HTML tag");
       document.getElementById("textbook_name").value="";
       return false;
    }
       
}
function Check_modify(frm)
{	
	if(document.getElementById("isDownload").value == 1)
	{
        var es = frm.elements["checkbox_1"];
        var checked = false;

        for (i = 0; i < 5; i++)
        {
            if (es[i].checked == true)
            {
                checked = true;
                break;
            }
        }
		if(!checked)
		{
            alert("請勾選下載使用者身分!");
			return false;
		}
	}
	if(document.getElementById("textbook_name_mod").value == ""){
		alert("請輸入教材名稱!");
        return false;
	}
}

function export_textbook(this_Content_cd){
	document.getElementById("show_export").src = "export_textbook.php?content_cd="+this_Content_cd;
	document.getElementById("show_export").style.display = "";
	document.getElementById("hidden_export").style.display ="";
}


function zip(element_id){
	if(document.getElementById(element_id).style.display==""){
		document.getElementById(element_id).style.display="none";
	}else{
		document.getElementById(element_id).style.display="";
	}
}
//-->
</script>
{/literal}
</head>
<body id="tabA">
<h1>教材管理工具</h1>


<div class="tab">
  <ul id="tabnav">
    <li class="tabA" onClick="display(1)">教材列表</li>
    <li class="tabB" onClick="display(2)">教材新增</li>
    <li class="tabF" onClick="display(6)">教材匯入</li>
  </ul>
</div>
<div id="inner_contentA">
<center><font color="red">{$status}</font></center>
<fieldset><legend>老師的所有教材</legend>
<table id="textbook_list" class="datatable">
<tr>
	<th width="6%" style="text-align:center">索引</th>
	<th style="text-align:center">教材名稱&nbsp;&nbsp;</th>	
	<th style="text-align:center">建立時間</th>	
	<th style="text-align:center">修改教材</th>
	<th style="text-align:center">刪除教材</th>
	<th style="text-align:center">匯出教材</th>
</tr>
{foreach from=$all_textbook key=k item=i name=textbook_loop}
<tr class="{cycle values=",tr2"}">
	<td style="text-align:center">{$smarty.foreach.textbook_loop.iteration}</td>
	<td style="text-align:center">{$i[0]} &nbsp;&nbsp;<a href="textbook_manage.php?choose_textbook_this={$k}&person=1"></a></td>
	<td style="text-align:center">{$i[2]} </td>
	<td style="text-align:center"><input id="edit_bt_{$smarty.foreach.textbook_loop.iteration}" type="button" value="修改" onclick="lookup_textbook({$k}, {$smarty.foreach.textbook_loop.iteration})">
		<input id="edit_bt2_{$smarty.foreach.textbook_loop.iteration}" style="display:none" type="button" value="修改" onclick="restore_edit({$k}, {$smarty.foreach.textbook_loop.iteration})">
	</td>
	<td style="text-align:center"><input type="button" value="刪除" onclick="do_delete_textbook({$k},{$i[1]})"></td>
	<td style="text-align:center"><input type="button" onClick="export_textbook({$k})" value="匯出"></td>
</tr>
{foreachelse}
	<tr><td style="text-align:center" colspan="5">老師您目前沒有教材</td></tr>
{/foreach}
<script type="text/JavaScript">
	total_table_row = {$smarty.foreach.textbook_loop.total};
</script>
</table>
</fieldset>

<input id="hidden_export" type="button" value="隱藏匯出" onclick="hidden_export()" style="display:none;">
<iframe name="show_export" id="show_export" onload="ResizeIframe(this);" src="./export_textbook.php?" style="display:none; "> </iframe>
<br/>
<!--Modified for ticket #117
onclick="zip('ftp_upload_info')"-->
<h1  style="cursor:hand;" >FTP上傳相關資訊</h1><span class="imp">　**注意!若您的檔案為較大或多個檔案，建議您可使用ftp續傳軟體上傳! 路徑請參考下列說明。</span> 
<div id="ftp_upload_info">
	<fieldset><legend>FTP登入資訊</legend>
	    <ul>
            {if $role_cd == 2 }<li>{$msg}</li>{/if} 
			<li>FTP IP:&nbsp;<span class="imp">{$ftp_ip}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PORT:&nbsp;<span class="imp">{$ftp_port}</span>&nbsp;&nbsp;&nbsp; 帳號密碼:<span class="imp">同網頁平台</span></li>
			<li><a href="{$ftp_path}" target="_blank">{$ftp_path}</a> &nbsp;(IE7使用者請將網址貼至檔案總管)</li>
			<li>PS. 使用檔案總管上傳中文檔案，需要重新改名避免亂碼問題，或請參考下列軟體</li>
			<li>FTP帳號密碼同平台上的登入帳號密碼，本系統預設編碼為<span class="imp">utf-8</span>，請使用支援UTF-8編碼的FTP軟體連上系統FTP&nbsp;ex:&nbsp;<a href="http://filezilla-project.org/" target="_blank">FileZilla</a></li>
			<li>經由FTP新增、上傳的資料夾，在教材系統上無法顯現，若欲新增教材目錄，請透過本平台的編輯教材功能新增資料夾節點</li>
	    </ul>	
		<table class="datatable">
			<tr>
				<th>資料夾</th><th>資料夾作用</th><th>詳細說明</th>	
			</tr>
			<tr>
				<td>textbook</td><td>教材目錄</td><td>所有教材放置的目錄</td>
			</tr>	
			<tr class="tr2">
				<td>export_data</td><td>匯出教材目錄</td><td>匯出的資料放置的目錄</td>
			</tr>
			<tr>
				<td>test_bank</td><td>題庫目錄</td><td>題庫資料放置的目錄(一般不會動到)</td>
			</tr>
			<tr class="tr2"><td>video</td><td>視訊目錄</td><td>隨選視訊檔案的目錄</td>
			</tr>
		</table>
	</fieldset>
</div>  
  
</div>




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
          <td><select name="attributes" id="creat_attributes">
            <option>Myscorm 1.2</option>
            <option>Myscorm 2004</option>
            <option>其它</option>
          </select></td>
        </tr>	
		
          <th>難易度： </th>
          <td><select name="difficulty" id="creat_difficulty">
            <option value="0">未知</option>
            <option value="1">易</option>
            <option value="2">中</option>
            <option value="3">難</option>
          </select></td>
        </tr>

        <tr>
          <th>是否公開： </th>
          <td><select name="isPublic" id="creat_isPublic">
            <option>否</option>
            <option>是</option>
          </select></td>
        </tr>
<!-- -----joyce 0328 -->
        <tr>
          <th>是否提供下載：</th>
          <td><select name="select4" id="isDownload" onchange="isDownload_func(0,this.options[this.options.selectedIndex].value)">
             <option value="0" selected >否</option>
             <option value="1">是</option>
          </select></td>
         </tr>
		<tr id="0_downloadRole"  style="display:none;">
          <th>下載使用者身分：</th>
          <td>
			<input type="checkbox" name="downloadRole[]" id="checkbox_0" value="1" checked>開放所有身份
			<input type="checkbox" name="downloadRole[]" id="checkbox_0" value="2">平台教師
			<br>
			<input type="checkbox" name="downloadRole[]" id="checkbox_0" value="3">研習學員(大專院校教師)
			<input type="checkbox" name="downloadRole[]" id="checkbox_0" value="4">研習學員(國民中小教師)
            <input type="checkbox" name="downloadRole[]" id="checkbox_0" value="5">修課學生
          </td>
        </tr>
         <tr id="0_license" style="display:none;">
          <th>授權型態：</th>
          <td>
			<input type="radio" name="license" value="1" onClick="choose_license_func(0,1)" checked>開放自由使用<br>
                <table border="0" class="form">
                <td rowspan=3 align=center> &nbsp;&nbsp; </td>
                <tr id="0_announce">
                  <td>版權聲明：</td>
                  <td>
                  <textarea cols="30" rows="10" name="announce" id="0_announce_text">
                  </textarea>
                  </td>
                </tr>
                <tr id="0_rule">
                  <td>排除條款：</td>
                  <td>
                  <textarea cols="30" rows="10" name="rule" id="0_rule_text">
                  </textarea>
                  </td>
                </tr>
                </table>

			<input type="radio" name="license" value="2" onClick="choose_license_func(0,2)">使用創用CC類型(<a rel="nofollow" href="http://creativecommons.tw/license" target=_blank>創用CC授權條款說明</a>)<br>
			<div id="0_license_cc" style="display:none;">
				<p class="intro">
					<span class="imp">
						<input type="radio" name="license" value="3" onClick="choose_license_func(0,3)">
							<img src="{$webroot}images/download_cc/cc1.png" alt="姓名標示" border="0" />
						<input type="radio" name="license" value="4" onClick="choose_license_func(0,4)">
							<img src="{$webroot}images/download_cc/cc2.png" alt="姓名標示─非商業性" border="0" />
						<input type="radio" name="license" value="5" onClick="choose_license_func(0,5)">
							<img src="{$webroot}images/download_cc/cc3.png" alt="姓名標示─非商業性─相同方式分享" border="0" />
						<br>
						<input type="radio" name="license" value="6" onClick="choose_license_func(0,6)">
							<img src="{$webroot}images/download_cc/cc4.png" alt="姓名標示─禁止改作" border="0" />
						<input type="radio" name="license" value="7" onClick="choose_license_func(0,7)">
							<img src="{$webroot}images/download_cc/cc5.png" alt="姓名標示─非商業性─禁止改作" border="0" />
						<input type="radio" name="license" value="8" onClick="choose_license_func(0,8)">
							<img src="{$webroot}images/download_cc/cc6.png" alt="姓名標示─相同方式分享" border="0" />							
					</span>
				</p>
			</div>
			<input type="radio" name="license" value="9" onClick="choose_license_func(0,9)">教育部提供之聲明範本
          </td>
        </tr>
	
        <tr id="0_edusample" style="display:none;">
          <th></th>
          <td>
          <img src="{$webroot}images/edu_announce.png" border="1" />
          </td>
        </tr>

    <input type="hidden" name="person" value="1" />
<!-- ------------------------  --->		
      </table>
      <div class="buttons">
         <input name="submit_create" type="submit" class="btn" onClick="return Check_create(this.form);" value="新增教材">  
	     <input type="submit" class="btn" name="create_and_edit" value="新增並進入編輯" onClick="return Check_create(this.form);">
         <input type="hidden" name="submit_content_cd" id="create_content_cd"value=""></div>
    </form></fieldset>
</div>
<div class="inner_contentF" id="inner_contentF" style="display:none;">
 <fieldset><legend>匯入外部檔案做為教材 </legend>
     <p class="intro">       <font color="red">注意!此數位學習平台全為utf8編碼<br>RAR教材包內資料夾如有中文時請以utf8編碼!否則請以英文命名，以免不預期的情況發生!</font><br>
    命名規則範例：<br/>
    ◎若您的教材名稱為<font color="red">my_textbook</font>，請以<font color="red">my_textbook</font>為資料夾檔名，用rar壓縮成為<font color="red">my_textbook.rar</font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;系統將解開壓縮檔尋找資料夾名稱<font color="red">my_textbook</font>字串做為教材名稱。
 </p>
    <table width="200" border="1" class="form">
      <tr>
        <td><form action="import_material.php" enctype="multipart/form-data" method="POST" name="upload_import" id="upload_import">
      匯入此平台匯出的檔案格式：
      <input type="hidden" name="content_type" value="0"/>
      <input type="file" name="material" class="btn"/>
      <input type="hidden" name="person" value="1" />
      <input class="btn" type="submit" value="確定上傳" />
    </form></td>
      </tr>
      <tr>
        <td><form action="import_material.php" method="POST" enctype="multipart/form-data" name="upload_import" id="upload_import">
          匯入Myscorm 1.2 教材格式：
	  <input type="hidden" name="content_type" value="1"/>
          <input type="file" name="material" class="btn"/>
          <input type="hidden" name="person" value="1" />
      <input class="btn" type="submit" value="確定上傳" />
        </form></td>
      </tr>
      <tr>
        <td><form action="import_material.php" method="POST" enctype="multipart/form-data" name="upload_import" id="upload_import">
          匯入Myscorm 2004 教材格式：
	  <input type="hidden" name="content_type" value="2"/>
          <input type="file" name="material" class="btn"/>
          <input type="hidden" name="person" value="1" />
      <input class="btn" type="submit" value="確定上傳" />
        </form></td>
      </tr>
    </table>
    </fieldset>
</div>
<form id="hidden_delete_textbook" action="textbook_manage.php" method="post">
<input type="hidden" name="del_textbook_this" id="del_textbook_this" value=""/>
<input type="hidden" name="person" value="1" />
</form>
<div id="modify" style="display:none;">
	<form name="modify_textbook" action="textbook_manage.php" method="post"> 	
      <table width="200" border="1" class="form">
        <tr>
          <th>教材名稱：(中間勿有空格)</th>
          <td><input type="text" name="textbook_name" id="textbook_name_mod" value="{$mod_textbook_name}"/></td>
        </tr>
        <tr>
          <th>教材屬性：</th>
          <td>
		  <select name="attributes" id="modify_attributes" style="display:none;">
            <option>Myscorm 1.2</option>
            <option>Myscorm 2004</option>
            <option>其它</option>
          </select>
		  <input type="text" name="attributes_T" id="modify_attributes_text" value="" style="display:none;" readonly />
		  </td>
		  
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
          <th>是否公開： </th>
          <td><select name="isPublic" id="modify_isPublic">
            <option>否</option>
            <option>是</option>
          </select></td>
        </tr>
<!-- -----joyce 0328 -->
        <tr>
          <th>是否提供下載：</th>
          <td><select name="select4" id="isDownload" onchange="isDownload_func(1,this.options[this.options.selectedIndex].value)">
             <option value="0" selected >否</option>
             <option value="1">是</option>
          </select></td>
         </tr>
		<tr id="1_downloadRole"  style="display:none;">
          <th>下載使用者身分：</th>
          <td>
			<input type="checkbox" name="downloadRole[]" id="checkbox_1" value="1" checked>開放所有身份
			<input type="checkbox" name="downloadRole[]" id="checkbox_1" value="2">平台教師
			<br>
			<input type="checkbox" name="downloadRole[]" id="checkbox_1" value="3">研習學員(大專院校教師)
			<input type="checkbox" name="downloadRole[]" id="checkbox_1" value="4">研習學員(國民中小教師)
            <input type="checkbox" name="downloadRole[]" id="checkbox_1" value="5">修課學生
          </td>
        </tr>
        <tr id="1_license"  style="display:none;">
          <th>授權型態：</th>
          <td>
			<input type="radio" name="license" value="1" onClick="choose_license_func(1,1)" checked>開放自由使用<br>
                <table border="0" class="form">
                <td rowspan=3 align=center> &nbsp;&nbsp; </td>
                    <tr id="1_announce">
                      <td>版權聲明：</td>
                      <td>
                       <textarea cols="30" rows="10" name="announce" id="1_announce_text">
                       </textarea>
                      </td>
                     </tr>
                    <tr id="1_rule">
                      <td>排除條款：</td>
                      <td>
                       <textarea cols="30" rows="10" name="rule" id="1_rule_text">
                       </textarea>
                      </td>
                    </tr>
                </table>

			<input type="radio" name="license" value="2" onClick="choose_license_func(1,2)">使用創用CC類型(<a rel="nofollow" href="http://creativecommons.tw/license" target=_blank>創用CC授權條款說明</a>)<br>
			<div id="1_license_cc" style="display:none;">
				<p class="intro">
					<span class="imp">
						<input type="radio" name="license" value="3" onClick="choose_license_func(1,3)" id="cc_default">
							<img src="{$webroot}images/download_cc/cc1.png" alt="姓名標示" border="0" />
						<input type="radio" name="license" value="4" onClick="choose_license_func(1,4)">
							<img src="{$webroot}images/download_cc/cc2.png" alt="姓名標示─非商業性" border="0" />
						<input type="radio" name="license" value="5" onClick="choose_license_func(1,5)">
							<img src="{$webroot}images/download_cc/cc3.png" alt="姓名標示─非商業性─相同方式分享" border="0" />
						<br>	
						<input type="radio" name="license" value="6" onClick="choose_license_func(1,6)">
							<img src="{$webroot}images/download_cc/cc4.png" alt="姓名標示─禁止改作" border="0" />
						<input type="radio" name="license" value="7" onClick="choose_license_func(1,7)">
							<img src="{$webroot}images/download_cc/cc5.png" alt="姓名標示─非商業性─禁止改作" border="0" />
						<input type="radio" name="license" value="8" onClick="choose_license_func(1,8)">
							<img src="{$webroot}images/download_cc/cc6.png" alt="姓名標示─相同方式分享" border="0" />
					</span>
				</p>
			</div>
			<input type="radio" name="license" value="9" onClick="choose_license_func(1,9)">教育部提供之聲明範本
          </td>
        </tr>	

        <tr id="1_edusample" style="display:none;">
          <th></th>
          <td>
          <img src="{$webroot}images/edu_announce.png" border="1" />
          </td>
        </tr>
	
        <input type="hidden" name="person" value="1" />
<!-- ------------------------  --->	
      </table>
      </table>
      <div class="buttons">
        <input type="hidden" name="modify_content_cd" id="modify_content_cd" value=""><br />
        <input type="submit" name="modify_and_edit" id="modify_and_edit" class="btn" value="編輯教材詳細內容" onClick="return Check_modify(this.form);">
		<input class="btn" type="submit" name="submit_modify" value="確定修改" onClick="return Check_modify(this.form);">
        </div>
		</form>
</div>

<div class="inner_contentI" id="inner_contentI" style="display:none;">
 <fieldset><legend>匯入外部檔案做為教材 </legend>
    </p>
      可接受的檔案格式為<font color="red">zip</font>。
      在此上傳成功後，於教材列表中的顯示為<font color="red">scorm_教材名稱_編號</font>
      <form action="scorm/mod/scorm/scorm_add.php" enctype="multipart/form-data" name="upload_import" id="upload_import" method="post">
    	<p>scorm教材名稱：<input name="scorm_name" type="text" id="scorm_name"></p>
      	匯入scorm 教材包：
      	<input type="file" name="import_file4" id="import_file4" />
      	<input type="hidden" name="teacher_cd" id="teacher_cd" value="{$teacher_cd}" />
      	<input type="hidden" name="begin_course_cd" id="begin_course_cd" value="{$begin_course_cd}" />
      	<input class="btn" type="submit" name="upload4" id="upload4" value="確定上傳" />
      </form>
 </fieldset>
</div>

</body>
</html>
