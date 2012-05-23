<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>新增課程(教師在職進修)</title>	
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="../script/prototype.js" type="text/javascript"></script>
  <script type="text/javascript" src="../script/menu.js"></script>	  
  <link href="css/course.css" rel="stylesheet" type="text/css" />
<script>
<!--
{literal}
var MAX_SELECTION = 10;
var serverAddress="validate_begin_course_advance.php";
var showErrors = true; 
var cache = new Array();

function setFocus()    
{
	$('begin_course_name').focus();
}


function readResponse(req)
{
	var response = req.responseText;
	if (response.indexOf("ERRNO") >= 0 || response.indexOf("error:") >= 0|| response.length == 0)
		throw(response.length == 0 ? "Server error." : response);
	responseXml = req.responseXML;
	xmlDoc = responseXml.documentElement;
	result = xmlDoc.getElementsByTagName("result")[0].firstChild.data;
	fieldID = xmlDoc.getElementsByTagName("fieldid")[0].firstChild.data;
	errorMsg = xmlDoc.getElementsByTagName("msg")[0].firstChild.data;
	message = $(fieldID + "Failed");
	message.className = (result == "0") ? "error" : "hidden";
	message.innerHTML = errorMsg; 
	setTimeout("validate();", 500);
}

function displayError($message)
{
  if (showErrors)
  {
    showErrors = false;
    alert("Error encountered: \n" + $message);
    setTimeout("validate();", 10000);
  }
}

function validate(inputValue, fieldID)
{
	if (fieldID)
	{
	  inputValue = encodeURIComponent(inputValue);
	  fieldID = encodeURIComponent(fieldID);
	  cache.push("inputValue=" + inputValue + "&fieldID=" + fieldID);
	}
	try
	{
		if(cache.length > 0){
			var cacheEntry = cache.shift();
			var ajaxQ = new Ajax.Request(serverAddress,
										 {method:'post',
										  parameters: cacheEntry,
										  onComplete: readResponse
										 });
		}
	}
	catch (e)
	{
	  displayError(e.toString());
	}	
} 


function showSelect(req){
	//var response = req.responseText;
	//alert(response);
	var responseXML,xmlDoc, select_g,option_g, a_select, a_option, i, j, cd , name;
	var tmp_select, tmp_option, tmp_text;
	responseXML = req.responseXML;
	//alert(responseXML);
	xmlDoc = responseXML.documentElement;
	//alert(xmlDoc);
	select_g = xmlDoc.getElementsByTagName('select');
	//alert(select_g.length);
	var tmp_v = 5 - select_g.length;
	for(i = 0; i < select_g.length ; i++){
		a_select = select_g.item(i);
		option_g = a_select.getElementsByTagName('option');
		//取得要改變的select位置	
		tmp_select = $('course_classify_' + tmp_v);
		//清空內部
		while(tmp_select.firstChild) tmp_select.removeChild(tmp_select.firstChild);

		for(j = 0; j < option_g.length; j++){
			a_option = option_g.item(j);
			cd = a_option.getElementsByTagName('course_classify_cd')[0].firstChild.data;
			name = a_option.getElementsByTagName('course_classify_name')[0].firstChild.data;
			//alert('<option value='+cd+'>'+name);
			tmp_select.appendChild(document.createTextNode(''));
			tmp_option = document.createElement("option");
			tmp_option.setAttribute("value", cd);
			tmp_option.setAttribute("lebel", name);		
			tmp_option.appendChild(document.createTextNode(name));
			tmp_select.appendChild(tmp_option);				
		}
		tmp_select.appendChild(document.createTextNode(''));		
		tmp_v++;
	}

}

function changeSelect(selectedIndex, fieldID, level){
	var root = document.getElementById(fieldID);
	var nodeValue;
	if( root.firstChild != null){
		nodeValue = root.childNodes.item(selectedIndex*2+1).getAttribute("value");		
		var parms = 'target=course_classify&nodeValue='+encodeURIComponent(nodeValue)+'&level='+encodeURIComponent(level);
		//alert(parms );
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'get',
									  parameters: parms,
									  onComplete: showSelect
									 });
		//Element.show('loadingGif');		
	}
}

function disableEnterKey(e){
	if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13)
		return false;
	else
		return true;	 	
} 
  
{/literal}  
-->
</script>

</head>
<body onload="setFocus();">	
<!-- 標題 -->
<center>開設課程(教師在職進修)</center>
<!-- 內容說明 -->
<div>
<br />
操作說明：<br />
	<font color="#FF0000">1. 先填好下列欄位，填好按送出。</font><br />
	<font color="#FF0000">2. 教師在職進修，所有的欄位請皆填寫正確，以便作業。</font><br />	
	<font color="#FF0000">3. 送出之後可以選擇授課教師。</font><br />
	<font color="#FF0000">注意；每一門課只有一個主要的填寫者。</font><br />
	<br />
</div>
<!--功能部分 -->
<form name="frmRegistration" method="post" action="{$actionPage}" onkeypress=" disableEnterKey(event);">
<!-- name -->
<table border="0">
<tr>
	<td>開課名稱</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0" >
		<tr>
			<td>
			<input id="begin_course_name" name="begin_course_name" type="text" value="{$ValueOfBegin_course_name}" onblur="validate(this.value, this.id);">
			</td>		
		</tr>
		</table>	
		<div id="begin_course_nameFailed" class="{$begin_course_nameFailed}">格式錯誤或此欄空白</div>	
	</td>
</tr>	
<tr>
	<td>開課單位</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
			<!--<input id="begin_unit_cd" name="begin_unit_cd" type="text" value="{$ValueOfBegin_unit_cd}">-->
			<select name="begin_unit_cd">
			{html_options values=$begin_unit_cd_ids selected=$begin_unit_cd_id output=$begin_unit_cd_names}
			</select>
			</td>
		</tr>
		</table>
		<!--<div id="begin_unit_cdFailed" class="{$begin_unit_cdFailed}" >格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<td>對應內部課程號</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><input id="inner_course_cd" name="inner_course_cd" type="text" value="{$ValueOfInner_course_cd}"></td>
		</tr>
		</table>
		<!--<div id="inner_course_cdFailed" class="{$inner_course_cdFailed}" >格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<td>開課開始日期</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				
				<select >
				{html_options  options=$d_course_begin_Y_names}
				</select>
				年　 
				<select >
				{html_options  options=$d_course_begin_M_names}
				</select>
				月　 
				<select >
				{html_options  options=$d_course_begin_D_names}
				</select>
				日　			
			</td>
		</tr>
		</table>
		<!--<div id="d_course_beginFailed" class="{$d_course_beginFailed}" >格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<td>開課結束日期</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				
				<select >
				{html_options  options=$d_course_begin_Y_names}
				</select>
				年　 
				<select >
				{html_options  options=$d_course_begin_M_names}
				</select>
				月　 
				<select >
				{html_options  options=$d_course_begin_D_names} 
				</select>
				日	
			</td>
		</tr>
		</table>
		<!--<div id="d_course_endFailed" class="{$d_course_endFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<td>開課公開日期</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				
				<select >
				{html_options  options=$d_course_begin_Y_names}
				</select>
				年　 
				<select >
				{html_options  options=$d_course_begin_M_names}
				</select>
				月　 
				<select >
				{html_options  options=$d_course_begin_D_names}
				</select>
				日	
			</td>
		</tr>
		</table>
		<!--<div id="d_public_dayFailed" class="{$d_public_dayFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<td>選課開始日期</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				
				<select >
				{html_options  options=$d_course_begin_Y_names}
				</select>
				年　 
				<select >
				{html_options  options=$d_course_begin_M_names}
				</select>
				月　 
				<select >
				{html_options  options=$d_course_begin_D_names}
				</select>
				日	
			</td>
		</tr>
		</table>
		<!--<div id="d_select_beginFailed" class="{$d_select_beginFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<td>選課結束日期</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				
				<select >
				{html_options  options=$d_course_begin_Y_names}
				</select>
				年　 
				<select >
				{html_options  options=$d_course_begin_M_names}
				</select>
				月　 
				<select >
				{html_options  options=$d_course_begin_D_names}
				</select>
				日	
			</td>
		</tr>
		</table>
		<!--<div id="d_select_endFailed" class="{$d_select_endFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<td>開課所屬的學年</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><input id="course_year" name="course_year" type="text" value="{$ValueOfCourse_year}"></td>
		</tr>
		</table>
		<!--<div id="course_yearFailed" class="{$course_yearFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>		
<tr>
	<td>開課所屬的學期</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><input id="course_session" name="course_session" type="text" value="{$ValueOfCourse_session}"></td>
		</tr>
		</table>
		<!--<div id="course_sessionFailed" class="{$course_sessionFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<td>課程性質</td>
	<td>		
	<table>
		<tr>
			<td> 1.
			<select name="course_classify_1" id="course_classify_1" onchange="changeSelect(this.selectedIndex, this.id, 1);">
			{html_options values=$course_classify_1_ids selected=$course_classify_1_id output=$course_classify_1_names}
			</select>
			</td>
			<td> 2.
			<select name="course_classify_2" id="course_classify_2" onchange="changeSelect(this.selectedIndex, this.id, 2);">
			{html_options values=$course_classify_2_ids selected=$course_classify_2_id output=$course_classify_2_names}
			</select>				
			</td>
			<td> 3.
			<select name="course_classify_3" id="course_classify_3" onchange="changeSelect(this.selectedIndex, this.id, 3);">
			{html_options values=$course_classify_3_ids selected=$course_classify_3_id output=$course_classify_3_names}
			</select>				
			</td>
			<td> 4.
			<select name="course_classify_4" id="course_classify_4">
			{html_options values=$course_classify_4_ids selected=$course_classify_4_id output=$course_classify_4_names}
			</select>				
			</td>								
		</tr>
	</table>
	</td>		
</tr>	

<tr>
	<td>班別性質</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>	
		<select name="coursekind">
		{html_options values=$coursekind_ids selected=$coursekind_id output=$coursekind_names}
		</select>
		</td>
	</tr>
	</table>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<td>課程時段</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		{html_checkboxes name="timeSet" values=$timeSet_ids checked=$timeSet_id output=$timeSet_names separator=" "}		
		</td>
	</tr>
	</table>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<td>學員繳費方式</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<select name="charge_type">
		{html_options values=$charge_type_ids selected=$charge_type_id output=$charge_type_names}
		</select>
		</td>
	</tr>
	</table>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<td>補助單位</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<select name="subsidizeid">
		{html_options values=$subsidizeid_ids selected=$subsidizeid_id output=$subsidizeid_names}
		</select>
		</td>
	</tr>
	</table>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>		
		
</table>	
<!-- 按鈕-->
<hr />
<input type="submit" name="submitbutton" value="確定送出" class="left button" />
</form>		
</body>
</html>