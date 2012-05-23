<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>新增課程</title>	
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="../script/prototype.js" type="text/javascript"></script>
  <script type="text/javascript" src="../script/menu.js"></script>	  
  <link href="css/course.css" rel="stylesheet" type="text/css" />
<script>
<!--
{literal}
var MAX_SELECTION = 10;
//var courseNameMenu;
//var courseNameQuery;
var serverAddress="validate_begin_course.php";
var showErrors = true; 
var cache = new Array();
/*function init()
{
	courseNameMenu = new Menu('courseNameMenu','selCourseName', 'choose_course', "son", "soff" );
	courseNameQuery ="";
}*/
function setFocus()    
{
	$('begin_course_name').focus();
}
/*	
function choose_course(id)
{
	var tmpStr = courseNameMenu.get_content(id);
	var tmpArray = tmpStr.split(",");
	if(tmpArray.length > 1){
		$('begin_course_name').value = tmpArray[0];
		//$('course_cd').value = tmpArray[1];
	}else{
		$('begin_course_name').value = tmpStr;
	}
	Element.hide('selCourseName');
}*/
/*
function showResultCourse(req)
{
	if(req.responseText.length > 0){
		var addList = req.responseText.split('\n').without('\r','\n','');
		Element.hide('loadingCourseNameGif');
		if(addList.length == 0)
			return;
		Element.show('selCourseName');
		courseNameMenu.clear();
		for(var w=0; w < Math.min(addList.length, MAX_SELECTION); w++){
				courseNameMenu.add_item(addList[w]);
		}
		courseNameMenu.highlight(0);
	}
	setTimeout("Element.hide('loadingCourseNameGif');", 10000);
}*/

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
/*
function keySelectCourse(e){
	if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13){
		var sel = courseNameMenu.get_current_content();
		if(sel!='')
			$('begin_course_name').value = sel;
	}else if(e.keyCode == 38){
		courseNameMenu.sel_prev();
	}else if(e.keyCode == 40){
		courseNameMenu.sel_next();
	}
}*/
/*
function queryCourseName(e)
{
	var user_input = $F('begin_course_name');
	if(user_input.length > 0 && courseNameQuery != user_input){
		courseNameQuery = user_input;
		var parms = 'target=begin_course_name&prefix='+encodeURIComponent(user_input);
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'get',
									  parameters: parms,
									  onComplete: showResultCourse
									 });
		Element.show('loadingCourseNameGif');
	}
}*/

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
<center>開設課程</center>
<!-- 內容說明 -->
<div>
<br />
操作說明：<br />
	<font color="#FF0000">1. 先填好下列欄位，填好按送出。</font><br />
	<font color="#FF0000">2. 送出之後可以選擇授課教師。</font><br />
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
		<div id="begin_unit_cdFailed" class="{$begin_unit_cdFailed}" >格式錯誤或此欄空白</div>
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
		<div id="inner_course_cdFailed" class="{$inner_course_cdFailed}" >格式錯誤或此欄空白</div>
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
		<div id="d_course_beginFailed" class="{$d_course_beginFailed}" >格式錯誤或此欄空白</div>
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
		<div id="d_course_endFailed" class="{$d_course_endFailed}">格式錯誤或此欄空白</div>
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
		<div id="d_public_dayFailed" class="{$d_public_dayFailed}">格式錯誤或此欄空白</div>
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
		<div id="d_select_beginFailed" class="{$d_select_beginFailed}">格式錯誤或此欄空白</div>
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
		<div id="d_select_endFailed" class="{$d_select_endFailed}">格式錯誤或此欄空白</div>
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
		<div id="course_yearFailed" class="{$course_yearFailed}">格式錯誤或此欄空白</div>
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
		<div id="course_sessionFailed" class="{$course_sessionFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>		
</table>	
<!-- 按鈕-->
<hr />
<input type="submit" name="submitbutton" value="確定送出" class="left button" />
</form>		
</body>
</html>