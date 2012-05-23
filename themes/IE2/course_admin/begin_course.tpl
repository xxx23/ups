{config_load file='common.lang'}
{config_load file='course_admin/begin_course.lang'}

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{#add_course#}</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />

<link href="css/course.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$webroot}script/jquery-ui-1.7.2.custom.min.js"></script>
<link href="{$webroot}css/jquery/jquery-ui-1.7.2.custom_1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
{literal}
$(document).ready(function(){
        var setting = 
        {
            dateFormat:'yy-mm-dd',
            monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
            monthNamesShort:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
            changeMonth:true,
            changeYear:true
        };
        $("#d_course_begin").datepicker(setting);
        $("#d_course_end").datepicker(setting);
        $("#d_public_day").datepicker(setting);
        $("#d_select_begin").datepicker(setting);
        $("#d_select_end").datepicker(setting);

    });
{/literal}
</script>


<script>
{literal}
var MAX_SELECTION = 10;
var serverAddress="validate_begin_course.php";
var showErrors = true; 
var cache = new Array();

function setFocus()    
{
	$('begin_course_name').focus();
}

function readResponse(req)
{
	/*var response = req.responseText;
	if (response.indexOf("ERRNO") >= 0 || response.indexOf("error:") >= 0|| response.length == 0)
		throw(response.length == 0 ? "Server error." : response);*/
	responseXml = req;
    xmlDoc = responseXml.documentElement;
	result = xmlDoc.getElementsByTagName("result")[0].firstChild.data;
	
	fieldID = xmlDoc.getElementsByTagName("fieldid")[0].firstChild.data;
	if(fieldID.indexOf('course_stage')==0)
        fieldID='course_stage';
    errorMsg = xmlDoc.getElementsByTagName("msg")[0].firstChild.data;
	message = $('#' + fieldID + "Failed");
    var className = (result == "0") ? "error" : "hidden";
    message.attr('class', className);
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
			/*var ajaxQ = new Ajax.Request(serverAddress,
										 {method:'post',
										  parameters: cacheEntry,
										  onComplete: readResponse
										 });*/
            $.ajax({
                type: 'post',
                url: serverAddress,
                dataType: 'xml',
                data: cacheEntry,
                success: readResponse
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

function checkSelect(obj){
	var myForm=document.forms['create_course'];
	myForm.action = 'begin_course.php';
	myForm.method = 'POST';
	myForm.submit();
	return ; 
}

function openSelectWin()
{
	var w = window.open("unit_selecter.php","child","width=150,height=200,toolbar=0,location=0");
	w.focus();
}
{/literal}  
</script>
</head>
<body>
<!-- 標題 -->
 <h1>{#new_course#}</h1>
<!-- 內容說明 -->
<h2>{#instruction#}</h2>
<div class="intro" style="margin-left:60px">
  <ol>
    <li>{#instr_type#}</li>
    <li>{#instr_col#}</li>
    <li>{#instr_send#}</li>
  </ol>
<span class="imp">{#instr_caution#}</span></div>
<!--功能部分 -->
<!--{$actionPage}-->
<form id="create_course" name="create_course" method="post" action="{$actionPage}&attribute={$attribute}" onkeypress=" disableEnterKey(event);">
  <!-- name -->
  <div class="searchbar" style="margin-left:50px;width:95%;"><div class="describe" style="margin-bottom:6px;">{#step_one#}</div>
  <select name="attribute" onChange="checkSelect(this);" length="30">
    <option value="2" {if $attribute eq 2} selected {/if}>{#choose_course_type#}</option>
    <option value="0" {if $attribute eq 0} selected {/if}>{#study_by_self#}</option>
    <option value="1" {if $attribute eq 1} selected {/if}>{#study_by_teacher#}</option>
  </select>


{if $attribute != 2}
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">
<div class="describe" style="margin-bottom:6px">{#step_two#}<br/>{#step_two_hint#}</div>
  <table class="datatable">
    <tr>
    	<th>{#course_type#}</th>
	<td>
	<select name="course_property" id="course_property" length="30" onChange="validate(this.value, this.id);">
    <option value="-1" {if $course_property eq -1} selected {/if}>{#please_choose#}</option>
	{section name=counter loop=$total_course_property}
		<option value="{$total_course_property[counter].property_cd}" {if $course_property eq $total_course_property[counter].property_cd} selected {/if}>{$total_course_property[counter].property_name}</option>
	{/section}
	</select>
        <span id="course_propertyFailed" class="{$course_propertyFailed}">{#not_choose_yet#}</span>
	</td>
    </tr>
    <tr>
    <th width="300">{#whether_send_hour#}</th>
    <td>
    <input type="radio" name="deliver" id="deliver" value="1" {if $deliver eq 1} checked {/if} onclick="checkSelect(this);">{#this_yes#}
    <input type="radio" name="deliver" id="deliver" value="0" {if $deliver eq 0} checked {/if} onclick="checkSelect(this);">{#this_no#}
    </td>
    </tr>
    <tr>
    <th width="300">{#can_guest_study#}</th>
    <td>
    <input type="radio" name="guest_allowed" id="guest_allowed" value="1" {if $guest_allowed eq 1} checked {/if}>{#this_yes#}
    <input type="radio" name="guest_allowed" id="guest_allowed" value="0" {if $guest_allowed eq 0} checked {/if}>{#this_no#}
    </td>
    </tr>

    <tr>
      <th>{#course_name#}</th>
      <td>
	  <input id="begin_course_name" name="begin_course_name" autocomplete="off" type="text" value="{$begin_course_name}" onblur="validate(this.value, this.id);"/>
        <span id="begin_course_nameFailed" class="{$begin_course_nameFailed}">{#course_name_error#}</span>
      </td>
    </tr>
    {if $deliver == 1}
    <tr>
      <th>{#according_number#}</th>
      <td>
	  <input id="article_number" name="article_number" autocomplete="off" type="text" value="{$article_number}" onblur="validate(this.value,this.id);">
        <span id="article_numberFailed" class="{$article_numberFailed}">{#according_number_error#}</span></td>
    </tr>
    <tr>
      <th>{#object_stage#}</th>
      <td>
      <input type="checkbox" name="course_stage_option1" id="course_stage_option1" {if $course_stage_option1 != NULL} checked {/if} value=10 onchange="validate(this.value,this.id);">{#senior_high#}</input>
      <input type="checkbox" name="course_stage_option2" id="course_stage_option2" {if $course_stage_option2 != NULL} checked {/if} value=20 onchange="validate(this.value,this.id);">{#senior_vocational#}</input>
      <input type="checkbox" name="course_stage_option3" id="course_stage_option3" {if $course_stage_option3 != NULL} checked {/if} value=30 onchange="validate(this.value,this.id);">{#junior_high#}</input>
      <input type="checkbox" name="course_stage_option4" id="course_stage_option4" {if $course_stage_option4 != NULL} checked {/if} value=40 onchange="validate(this.value,this.id);">{#elementary#}</input>
        <span id="course_stageFailed" class="{$course_stageFailed}">{#stage_error#}</span>
      </td>
    </tr>
    <tr>
      <th>{#object_identity#}</th>
      <td>
      <select name="career_stage" id="career_stage" onChange="validate(this.value,this.id);">
      <option value="-1" {if $career_stage eq "-1"} selected {/if}>{#choose_jobs#}</option>
      <option value="{#president#}" {if $career_stage eq "{#president#}"} selected {/if}>{#president#}</option>
      <option value="{#director#}" {if $career_stage eq "{#director#}"} selected {/if}>{#director#}</option>
      <option value="{#general_teacher#}" {if $career_stage eq "{#general_teacher#}"} selected {/if}>{#general_teacher#}</option>
      </select>
        <span id="career_stageFailed" class="{$career_stageFailed}">{#identity_error#}</span>
      </td>
    </tr>
    {/if}
    
    {if $attribute == 1}
    <tr>
      <th>{#course_hours#}</th>
      <td><input id="take_hour" name="take_hour" autocomplete="off" type="text" size="2" value="{$take_hour}" class="required validate-number min-value-0">  {#hours#}
      <!--<span id="take_hourFailed" class="{$take_hourFailed}">*課程時數尚未選擇</span>-->
      </td>
    </tr>
    {/if}
    <tr>
      <th>{#auth_hours#}</th>
      <td><input id="certify" name="certify" autocomplete="off" type="text" size="2" value="{$certify}" onblur="validate(this.value,this.id);">  {#hours#}
      <span id="certifyFailed" class="{$certifyFailed}">{#auth_hours_error#}</span>
      </td>
    </tr>
    <!--
    {if $attribute == 1} --><!-- 教導式的課程才有教材是否試閱的問題 -->
    <!--
    <tr>
      <th>教材是否試閱</th>
      <td>
      <input type="radio" name="is_preview" id="is_preview" value="1" checked>是
      <input type="radio" name="is_preview" id="is_preview" value="0"/>否
      </td>
    </tr>
    {/if}
    -->

    <tr>
    	<th>{#course_type_two#}</th>
	<td>
	<select name="course_unit" length="30" onChange="checkSelect(this); validate(this.value,this.id);">
	<option value="-1" {if $course_unit eq -1} selected {/if}>{#please_choose#}</option>
    {section name=counter loop=$total_course_unit}
		<option value="{$total_course_unit[counter].unit_cd}" {if $course_unit eq $total_course_unit[counter].unit_cd} selected {/if}>{$total_course_unit[counter].unit_name}</option>
	{/section}
	</select>
	<span id="course_unitFailed" class="{$course_unitFailed}">{#course_type_error#}</span>
    </td>
    </tr>
    {if $department > -1}
    <tr>
    	<th>{#course_subtype#}</th>
	<td>
	<select name="begin_unit_cd" id="begin_unit_cd" length="30" onChange="validate(this.value,this.id);">
    <option value="-1" {if $begin_unit_cd eq -1} selected {/if}>{#please_choose#}</option>
	{section name=counter loop=$total_course_subunit}
		<option value="{$total_course_subunit[counter].unit_cd}" {if $begin_unit_cd eq $total_course_subunit[counter].unit_cd} selected {/if}>{$total_course_subunit[counter].unit_name}</option>
	{/section}
	</select>
    <span id="begin_unit_cdFailed" class="{$begin_unit_cdFailed}">{#course_subtype_error#}</span>
	</td>
    </tr>
    {/if}
    {if $attribute == 0}
    <tr>
    	<th>{#study_duration#}
        <br/>
        <font color="red">{#course_duration_hint#}<br/>{#course_duration_hint_two#}</font>
        </th>
	<td>
	<select name="course_duration" id="course_duration" length="30" onChange="validate(this.value, this.id);">
	<option value="0" {if $course_duration eq 0} selected {/if}>{#please_choose#}</option>
    <option value="1" {if $course_duration eq 1} selected {/if}>{#a_month#}</option>
	<option value="2" {if $course_duration eq 2} selected {/if}>{#two_month#}</option>
	<option value="3" {if $course_duration eq 3} selected {/if}>{#three_month#}</option>
	<option value="4" {if $course_duration eq 4} selected {/if}>{#four_month#}</option>
	<option value="5" {if $course_duration eq 5} selected {/if}>{#five_month#}</option>
	<option value="6" {if $course_duration eq 6} selected {/if}>{#six_month#}</option>
	<option value="7" {if $course_duration eq 7} selected {/if}>{#seven_month#}</option>
	<option value="8" {if $course_duration eq 8} selected {/if}>{#eight_month#}</option>
	<option value="9" {if $course_duration eq 9} selected {/if}>{#nine_month#}</option>
	<option value="10" {if $course_duration eq 10} selected {/if}>{#ten_month#}</option>
	<option value="11" {if $course_duration eq 11} selected {/if}>{#eleven_month#}</option>
	<option value="12" {if $course_duration eq 12} selected {/if}>{#twelve_month#}</option>
	</select>
    <span id="course_durationFailed" class="{$course_durationFailed}">{#course_duration_error#}</span>
	</td>
    </tr>
    {/if}
    {if $attribute == 1}
    <tr>
      <th>{#course_start_date#}</th>
      <td>
	  	<input type='text' id='d_course_begin' name='d_course_begin' value="{$d_course_begin}" class="required validate-date-cn" readonly='readonly'/>
        </td>
    </tr>
    <tr>
      <th>{#course_end_date#}</th>
      <td>
	  <input class="required validate-date-cn" type='text' id='d_course_end' name='d_course_end' value="{$d_course_end}" readonly='readonly' />
      </td>
    </tr>
    <tr>
      <th>{#course_public_date#}</th>
      <td>
	  <input class="required validate-date-cn"  type='text' id='d_public_day' name='d_public_day' value="{$d_public_day}" readonly='readonly' />
      </td>
    </tr>
    <tr>
      <th>{#elective_start_date#}</th>
      <td>
	  <input class="required validate-date-cn" type='text' id='d_select_begin' name='d_select_begin' value="{$d_select_begin}" readonly='readonly' />
      </td>
    </tr>
    <tr>
      <th>{#elective_end_date#}</th>
      <td>
	  <input class="required validate-date-cn" type='text' id='d_select_end' name='d_select_end' value="{$d_course_end}" readonly='readonly' />
      </td>
    </tr>
    {/if}
    <tr>
      <th>{#course_belong_year#}</th>
      <td>
		<input class="required validate-number" id="course_year" autocomplete="off" name="course_year" type="text" value="{$valueOfCourse_year}" maxlength="3" size="3"/>{#school_year#}        
        <!--<div id="course_yearFailed" class="{$course_yearFailed}">格式錯誤或此欄空白</div>-->	  </td>
    </tr>
    {if $attribute == 1}
    <tr>
      <th>{#course_belong_semester#}</th>
      <td>
		<input id="course_session" name="course_session" class="required validate-number max-length-2"type="text" value="{$valueOfCourse_session}" maxlength="2"  size="2"/>{#semester#}
        <!--<div id="course_sessionFailed" class="{$course_sessionFailed}">格式錯誤或此欄空白</div>-->      </td>
    </tr>
    {/if}
    {if $attribute == 1}
    <tr>
      <th>{#recruitment_quota#}</th>
      <td><input id="quantity" name="quantity" type="text" autocomplete="off" size="2" value="{$quantity}" onblur="validate(this.value,this.id);">{#people#}
      <span id="quantityFailed" class="{$quantityFailed}"></span></td>
    </tr>
    {/if}
    <!--
    <tr>
      <th>學習費用</th>
      <td><input id="charge" name="charge" autocomplete="off" type="text" size="2" value="{$ValueOfcharge}"> 元
      </td>
    </tr>
    {if $attribute == 1}
    <tr>
      <th>上課縣市</th>
      <td><input id="class_city" name="class_city" type="text" autocomplete="off" size="3" value="{$ValueOfclass_city}"onblur="validate(this.value,this.id);">縣(市)
      <span id="class_cityFailed" class="{$class_cityFailed}">*上課縣市尚未填寫</span></td>
    </tr>
    <tr>
      <th>上課地點</th>
      <td><input id="class_place" name="class_place" type="text" autocomplete="off" value="{$ValueOfclass_place}"onblur="validate(this.value,this.id);">
      <span id="class_placeFailed" class="{$class_placeFailed}">*上課地點尚未填寫</span></td>
    </tr>
    {/if}
    -->
    <tr>
      <th>{#standard#}<font color="red">{#if_course_no_exam#}</font>
      </th>
      <td><input id="criteria_total" name="criteria_total" autocomplete="off" type="text" size="2" value="{$criteria_total}"onblur="validate(this.value,this.id);">{#not_more_than_100#}
      <span id="criteria_totalFailed" class="{$criteria_totalFailed}">{#standard_error#}</span>
      </td>
    </tr>
    <!--
    {if $attribute == 1}
    <tr>
      <th>評量標準(線上成績)</th>
      <td><input id="criteria_score" name="criteria_score" autocomplete="off" type="text" size="2" value="{$ValueOfcriteria_score}"></td>
    </tr>
    <tr>
      <th>評量標準(線上成績比例)</th>
      <td><input id="criteria_score_pstg" name="criteria_score_pstg" autocomplete="off" type="text" size=2 value="{$ValueOfcriteria_score_pstg}">%</td>
    </tr>
    <tr>
      <th>評量標準(老師成績)</th>
      <td><input id="criteria_tea_score" name="criteria_tea_score" autocomplete="off" type="text" size="2" value="{$ValueOfcriteria_tea_score}"></td>
    </tr>
    <tr>
      <th>評量標準(老師成績比例)</th>
      <td><input id="criteria_tea_score_pstg" name="criteria_tea_score_pstg" autocomplete="off" type="text" size="2" value="{$ValueOfcriteria_tea_score_pstg}">%</td>
    </tr>
    {/if}
    -->
    {if $attribute == 0}
    <tr>
      <th>{#study_hour#}</th>
      <td>
      <input type="text" name="criteria_content_hour_1" id="criteria_content_hour_1" autocomplete="off" size="2" value="{$criteria_content_hour_1}" onblur="validate(this.value,this.id);">{#hour#}
      <span id="criteria_content_hour_1Failed" class="{$criteria_content_hour_1Failed}">{#time_format_error#}</span>
      <input type="text" name="criteria_content_hour_2" id="criteria_content_hour_2" autocomplete="off" size="2" value="{$criteria_content_hour_2}" onblur="validate(this.value,this.id);">{#minute#}
      <span id="criteria_content_hour_2Failed" class="{$criteria_content_hour_2Failed}">{#time_format_error#}</span>
      <br/> {#fill_correct_format#}
      <!--
      <span id="criteria_content_hourFailed" class="{$criteria_content_hourFailed}">課程教材時數尚未選擇完畢</span>
      <select name="criteria_content_hour_1" length="30">
      <option value="-1" {if $criteria_content_hour_1 eq "-1"} selected {/if}>請選擇</option>
      <option value="0" {if $criteria_content_hour_1 eq "0"} selected {/if}>0</option>
      <option value="1"{if $criteria_content_hour_1 eq "1"} selected {/if}>1</option>
      <option value="2"{if $criteria_content_hour_1 eq "2"} selected {/if}>2</option>
      <option value="3"{if $criteria_content_hour_1 eq "3"} selected {/if}>3</option>
      <option value="4"{if $criteria_content_hour_1 eq "4"} selected {/if}>4</option>
      <option value="5"{if $criteria_content_hour_1 eq "5"} selected {/if}>5</option>
      <option value="6"{if $criteria_content_hour_1 eq "6"} selected {/if}>6</option>
      <option value="7"{if $criteria_content_hour_1 eq "7"} selected {/if}>7</option>
      <option value="8"{if $criteria_content_hour_1 eq "8"} selected {/if}>8</option>
      <option value="9"{if $criteria_content_hour_1 eq "9"} selected {/if}>9</option>
      <option value="10"{if $criteria_content_hour_1 eq "10"} selected {/if}>10</option>
      <option value="11"{if $criteria_content_hour_1 eq "11"} selected {/if}>11</option>
      <option value="12"{if $criteria_content_hour_1 eq "12"} selected {/if}>12</option>
      <option value="13"{if $criteria_content_hour_1 eq "13"} selected {/if}>13</option>
      <option value="14"{if $criteria_content_hour_1 eq "14"} selected {/if}>14</option>
      <option value="15"{if $criteria_content_hour_1 eq "15"} selected {/if}>15</option>
      <option value="16"{if $criteria_content_hour_1 eq "16"} selected {/if}>16</option>
      <option value="17"{if $criteria_content_hour_1 eq "17"} selected {/if}>17</option>
      <option value="18"{if $criteria_content_hour_1 eq "18"} selected {/if}>18</option>
      <option value="19"{if $criteria_content_hour_1 eq "19"} selected {/if}>19</option>
      <option value="20"{if $criteria_content_hour_1 eq "20"} selected {/if}>20</option>
      </select>
      小時

      <select name="criteria_content_hour_2" length="30">
      <option value="-1" {if $criteria_content_hour_2 eq "-1"} selected {/if}>請選擇</option>
      <option value="00" {if $criteria_content_hour_2 eq "00"} selected {/if}>0</option>
      <option value="10" {if $criteria_content_hour_2 eq "10"} selected {/if}>10</option>
      <option value="20" {if $criteria_content_hour_2 eq "20"} selected {/if}>20</option>
      <option value="30" {if $criteria_content_hour_2 eq "30"} selected {/if}>30</option>
      <option value="40" {if $criteria_content_hour_2 eq "40"} selected {/if}>40</option>
      <option value="50" {if $criteria_content_hour_2 eq "50"} selected {/if}>50</option>
      </select>
      分
      <span id="criteria_content_hourFailed" class="{$criteria_content_hourFailed}">課程教材時數尚未選擇完畢</span>
      -->
      </td>
    </tr>
    {/if}
    <!--
    {if $attribute == 1}
    <tr>
      <th>評量標準(觀看教材時間)</th>
      <td><input id="criteria_content_hour" name="criteria_content_hour"autocomplete="off" type="text" size="2" value="{$ValueOfcriteria_content_hour}">%</td>
    </tr>
    {/if}
    {if $attribute == 1}
    <tr>
      <th>評量標準(完成問卷)</th>
      <td><input id="criteria_finish_survey" name="criteria_finish_survey" autocomplete="off" type="text" size="2" value="{$ValueOfcriteria_finish_survey}">%</td>
    </tr>
    {/if}
    
-->
    <tr>
      <th>{#undertaker#}</th>
      <td><input autocomplete="off" type="text" id="director_name" name="director_name" value="{$director_name}" onblur="validate(this.value, this.id);">
      <span id="director_nameFailed" class="{$director_nameFailed}">{#undertaker_error#}</span>
      </td>
    </tr>
    <tr>
      <th>{#undertaker_phone#}</th>
      <td>{#region#}<input autocomplete="off" type="text" size="2" id="director_tel_area" name="director_tel_area" value="{$director_tel_area}" maxlength="4">
      -<input autocomplete="off" type="text" size="5" id="director_tel_left" name="director_tel_left" value="{$director_tel_left}" maxlength="8"onblur="validate(this.value, this.id);">
      #<input autocomplete="off" type="text" size="1" id="director_tel_ext" name="director_tel_ext" value="{$director_tel_ext}">{#ext#}
      <br/>{#region_hint#}
      <span id="director_telFailed" class="{$director_telFailed}">{#undertaker_phone_error#}</span>
      </td>
    </tr>
    <tr>
      <th>{#undertaker_email#}</th>
      <td><input autocomplete="off" type="text" id="director_email" name="director_email" value="{$director_email}"onblur="validate(this.value, this.id);">
      <span id="director_emailFailed" class="{$director_emailFailed}">{#undertaker_email_error#}</span>
      </td>
    </tr>
    {if $attribute == 1}
    <tr>
      <th>{#elective_auto_review#}</th>
      <td><input type="radio" name="auto_admission" id="auto_admission" value="1"{if $auto_admission eq 1}checked{/if}>{#this_yes#}
          <input type="radio" name="auto_admission" id="auto_admission" value="0"{if $auto_admission eq 0}checked{/if}>{#this_no#}<br/>
      </td>
    </tr>
    {/if}
    <tr>
      <th>{#remarks#}</th>
      <td><input id="note" name="note" autocomplete="off" type="text"></td>
    </tr>
    <tr>
      <td colspan="2">  
      <p class="al-left">  <input type="submit"  value="{#ok_send#}" class="btn" /></p></td>
    </tr>
  </table>
  {/if}</div> 
</form>
					<script type="text/javascript">
{literal}
function formCallback(result, form) 
{
    window.status = "valiation callback for form '" + form.id + "': result = " + result;
}

var valid = new Validation('create_course', {immediate : true, onFormValidate : formCallback});
{/literal}
					</script>
<br /><br /><br /><br /><br /><br />
</body>
</html>
