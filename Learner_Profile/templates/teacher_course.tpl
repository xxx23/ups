<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>教師<->課程</title>	
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="../script/prototype.js" type="text/javascript"></script>
  <script type="text/javascript" src="../script/menu.js"></script>	 
  <link href="css/course.css" rel="stylesheet" type="text/css" />
<script>
<!--
{literal}
var MAX_SELECTION = 10;
var suggestMenu;
var courseMenu;
var nameQuery;
var courseNameQuery;
var serverAddress="validate_teacher_course.php";
var showErrors = true; 
var cache = new Array();
function init()
{
	courseMenu = new Menu('courseMenu','selCourseName', 'choose_course_name', "son", "soff" );
	suggestMenu = new Menu('suggestMenu','selName', 'choose_name', "son", "soff" );	
	nameQuery ="";
	courseNameQuery ="";
}
function setFocus()    
{
	$('name').focus();
}	
function choose_name(id)
{
	var tmpStr = suggestMenu.get_content(id);
	var tmpArray = tmpStr.split(",");
	if(tmpArray.length >1 ){
		$('name').value = tmpArray[0];
		$('personal_id').value = tmpArray[2];
	}
	else{
		$('name').value = tmpArray[0];
	}	
	Element.hide('selName');
}

function choose_course_name(id)
{
	var tmpStr = courseMenu.get_content(id);
	var tmpArray = tmpStr.split(",");
	if(tmpArray.length >1 ){
		$('course_name').value = tmpArray[0];
		$('course_cd').value = tmpArray[1];
	}
	else{
		$('course_name').value = tmpArray[0];
	}	
	Element.hide('selCourseName');
}

function showResultName(req)
{
	if(req.responseText.length > 0){
		courseMenu.clear(this);
		var addList = req.responseText.split('\n').without('\r','\n','');
		Element.hide('loadingNameGif');
		if(addList.length == 0)
			return;
		Element.show('selName');
		suggestMenu.clear(this);
		for(var w=0; w < Math.min(addList.length, MAX_SELECTION); w++){
				suggestMenu.add_item(addList[w]);
		}
		suggestMenu.highlight(0);
	}
	setTimeout("Element.hide('loadingNameGif');", 10000);
}

function showResultCourseName(req)
{
	if(req.responseText.length > 0){
		suggestMenu.clear(this);
		var addList = req.responseText.split('\n').without('\r','\n','');
		Element.hide('loadingCourseNameGif');
		if(addList.length == 0)
			return;
		Element.show('selCourseName');
		courseMenu.clear();
		for(var w=0; w < Math.min(addList.length, MAX_SELECTION); w++){
				courseMenu.add_item(addList[w]);
		}
		courseMenu.highlight(0);
	}
	setTimeout("Element.hide('loadingCourseNameGif');", 10000);
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

function keySelect(e){
	if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13){
		var sel = suggestMenu.get_current_content();
		if(sel!='')
			$('name').value = sel;
	}else if(e.keyCode == 38){
		suggestMenu.sel_prev();
	}else if(e.keyCode == 40){
		suggestMenu.sel_next();
	}
}


function keySelectCourse(e){
	if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13){
		var sel = courseMenu.get_current_content();
		if(sel!='')
			$('course_name').value = sel;
	}else if(e.keyCode == 38){
		courseMenu.sel_prev();
	}else if(e.keyCode == 40){
		courseMenu.sel_next();
	}
}

function queryTeacherName()
{
	var user_input = $F('name');
	if(user_input.length > 0 && nameQuery != user_input){
		nameQuery = user_input;
		var parms = 'target=name&prefix='+encodeURIComponent(user_input);
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'get',
									  parameters: parms,
									  onComplete: showResultName
									 });
		Element.show('loadingNameGif');
	}
}


function queryCourseName()
{
	var user_input = $F('course_name');
	if(user_input.length > 0 && courseNameQuery != user_input){
		courseNameQuery = user_input;
		var parms = 'target=course_name&prefix='+encodeURIComponent(user_input);
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'get',
									  parameters: parms,
									  onComplete: showResultCourseName
									 });
		Element.show('loadingCourseNameGif');
	}
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
    
{/literal}  
-->
</script>

</head>
<body>
<body onload="init(); setFocus(); ">
	<fieldset>
		<legend class="txtFormLegend">教師<->課程</legend>
	<br />
	<!-- form -->
	<form name="frmRegistration" method="post" action="{$actionPage}" onkeypress=" javascript:return false; " >
	<!-- name -->
	<table border="0">
	<tr>
		<td>教師姓名</td>
		<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td>
		<input id="name" name="name" type="text" value="{$ValueOfName}" autocomplete="off" onkeydown="queryTeacherName(event); keySelect(event);"  onblur="validate(this.value, this.id);" >
		<input id="personal_id" name="personal_id" type="hidden" >
		</td>			
		<td rowspan="2">
		  <div id="loadingNameGif" style="display:none;float:right;">
			<img src="{$loadingGif}">
		  </div>
		</td>			
		</tr>
		<tr>
			<td><div id="selName" style="display:none;"></div></td>
		</tr>
		</table>	
		<div id="nameFailed" class="{$nameFailed}">格式錯誤或此欄空白</div>	
		</td>
	</tr>	
	<tr>
		<td>課程名稱</td>
		<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td><input id="course_name" name="course_name" type="text" value="{$ValueOfCourse_name}"  autocomplete="off" onkeydown="queryCourseName(event); keySelectCourse(event);"  onblur="validate(this.value, this.id);"></td>	
		<td rowspan="2">
		  <div id="loadingCourseNameGif" style="display:none;float:right;">
			<img src="{$loadingGif}">
		  </div>		
		</tr>
		<tr>
			<td><div id="selCourseName" style="display:none;"></div></td>
		</tr>		
		</table>	
		<div id="course_nameFailed" class="{$course_nameFailed}">格式錯誤或此欄空白</div>	
		</td>
	</tr>
	<tr>
		<td>課程編號</td>
		<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td><input id="course_cd" name="course_cd" type="text" value="{$ValueOfCourse_cd}" onblur="validate(this.value, this.id);"></td>	
		</tr>
		</table>	
		<div id="course_cdFailed" class="{$course_cdFailed}">格式錯誤或此欄空白</div>	
		</td>
	</tr>		
	</table>	
	<!-- 按鈕-->
	<hr />
	<input type="submit" name="submitbutton" value="確定送出"  class="left button" />
	</form>	
	</fieldset>
</body>
</html>
