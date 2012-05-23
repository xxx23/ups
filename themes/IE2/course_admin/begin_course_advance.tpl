
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>新增課程(教師在職進修)</title>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="../script/prototype.js" type="text/javascript"></script>
<script src="../script/menu.js" type="text/javascript" ></script>
<script src="../script/calendar.js" type="text/javascript" ></script>
	  
<link href="css/course.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table_news.css" rel="stylesheet" type="text/css" /> 
 
<script language=javascript type="text/javascript">
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
<body class="ifr" >	
<!-- 標題 -->
開設課程(教師在職進修)
<!-- 內容說明 -->
<!--<div>
<br />
操作說明：<br />
	<font color="#FF0000">1. 先填好下列欄位，填好按送出。</font><br />
	<font color="#FF0000">2. 教師在職進修，所有的欄位請皆填寫正確，以便作業。</font><br />	
	<font color="#FF0000">3. 送出之後可以選擇授課教師。</font><br />
	<font color="#FF0000">注意；每一門課只有一個主要的填寫者。</font><br />
	<br />
</div>
<!--功能部分 -->
<form  method="post" action="{$actionPage}" onkeypress=" disableEnterKey(event);">
<!-- name -->
<table class="datatable">
<tr>
	<th>開課名稱</th>
	<td>
	<input id="begin_course_name" name="begin_course_name" type="text" value="{$ValueOfBegin_course_name}" onblur="validate(this.value, this.id);">	
		<span id="begin_course_nameFailed" class="{$begin_course_nameFailed}">格式錯誤或此欄空白</span>	
	</td>
</tr>	
<tr>
	<th>開課單位</th>
	<td>
	<!--<input id="begin_unit_cd" name="begin_unit_cd" type="text" value="{$ValueOfBegin_unit_cd}">-->
	<select name="begin_unit_cd">
	{html_options values=$begin_unit_cd_ids selected=$begin_unit_cd_id output=$begin_unit_cd_names}
	</select>
		<!--<div id="begin_unit_cdFailed" class="{$begin_unit_cdFailed}" >格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<th>對應內部課程號</th>
	<td>
	<input id="inner_course_cd" name="inner_course_cd" type="text" value="{$ValueOfInner_course_cd}">
		<!--<div id="inner_course_cdFailed" class="{$inner_course_cdFailed}" >格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<th>開課開始日期</th>
	<td>
	  	<input type='text' name='d_course_begin' />		
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_course_begin';  
		  myDate.display();
		-->
		</script>
		<!--<div id="d_course_beginFailed" class="{$d_course_beginFailed}" >格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<th>開課結束日期</th>
	<td>
	  <input type='text' name='d_course_end' />
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_course_end';  
		  myDate.display();
		-->
		</script>
		<!--<div id="d_course_endFailed" class="{$d_course_endFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<th>開課公開日期</th>
	<td>
	  <input type='text' name='d_public_day' />
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_public_day';  
		  myDate.display();
		-->
		</script>
		<!--<div id="d_public_dayFailed" class="{$d_public_dayFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<th>選課開始日期</th>
	<td>
	  <input type='text' name='d_select_begin' />
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_select_begin';  
		  myDate.display();
		-->
		</script>
		<!--<div id="d_select_beginFailed" class="{$d_select_beginFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<th>選課結束日期</th>
	<td>
	  <input type='text' name='d_select_end' />
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_select_end';  
		  myDate.display();
		-->
		</script>
		<!--<div id="d_select_endFailed" class="{$d_select_endFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<th>開課所屬的學年</th>
	<td>
	<input id="course_year" name="course_year" type="text" value="{$valueOfCourse_year}" maxlength="2" size="2" />學年

		<!--<div id="course_yearFailed" class="{$course_yearFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>		
<tr>
	<th>開課所屬的學期</th>
	<td>
<input id="course_session" name="course_session" type="text" value="{$valueOfCourse_session}" maxlength="2" size="2" />學期

		<!--<div id="course_sessionFailed" class="{$course_sessionFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<th>認證表示</th>
	<td>
	<select name="certify_type">
		<option value="1">學分</option>
		<option value="2">等級</option>
		<option value="3">時</option>
		<option value="4">過or不過</option>
	</select>
	</td>
</tr>
<tr>
	<th>課程性質</th>
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
	<th>招收名額</th>
	<td>
	<input type="text" name="quantity" />
	</td>
</tr>
<tr>
	<th>限定機關報名上課</th>
	<td>
	<input type="radio" name="locally" value="y" />是
	<input type="radio" name="locally" value="n" checked />否
	</td>
</tr>
<tr>
	<th>班別性質</th>
	<td>	
		<select name="coursekind">
		{html_options values=$coursekind_ids selected=$coursekind_id output=$coursekind_names}
		</select>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<th>課程時段</th>
	<td>
		{html_checkboxes name="timeSet" values=$timeSet_ids checked=$timeSet_id output=$timeSet_names separator=" "}		
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<th>學員繳費方式</th>
	<td>
		<select name="charge_type">
		{html_options values=$charge_type_ids selected=$charge_type_id output=$charge_type_names}
		</select>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<th>補助單位</th>
	<td>
		<select name="subsidizeid">
		{html_options values=$subsidizeid_ids selected=$subsidizeid_id output=$subsidizeid_names}
		</select>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<th>補助費用</th>
	<td>
		<input type="text" name="subsidize_money"  />
	</td>
</tr>
<tr>
	<th>學習費用</th>
	<td>
	<input type="text" name="charge" /> (如教師無須繳費，請填 0 。)
	</td>
</tr>
			
</table>	
<input type="submit" name="submitbutton" value="確定送出" class="left button" />
</form>
<br/><br/><br/>		
</body>
</html>
