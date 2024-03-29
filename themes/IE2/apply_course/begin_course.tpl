<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>開課申請</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />

<link href="css/course.css" rel="stylesheet" type="text/css" />

<script src="../script/prototype.js" type="text/javascript"></script>
<script src="../script/effects.js" type="text/javascript"></script>
<script type="text/javascript" src="../script/validation_cn.js"></script>
<link href="{$tpl_path}/css/prototype.validation.css" rel="stylesheet" type="text/css" />
<!--<script src="../script/menu.js" type="text/javascript" ></script>-->
<script src="../script/calendar.js" type="text/javascript" ></script>
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
	var response = req.responseText;
	
	if (response.indexOf("ERRNO") >= 0 || response.indexOf("error:") >= 0|| response.length == 0)
		throw(response.length == 0 ? "Server error." : response);
	responseXml = req.responseXML;

    xmlDoc = responseXml.documentElement;
	
	result = xmlDoc.getElementsByTagName("result")[0].firstChild.data;
	
	fieldID = xmlDoc.getElementsByTagName("fieldid")[0].firstChild.data;
	if(fieldID.indexOf('course_stage')==0)
        fieldID='course_stage';
    errorMsg = xmlDoc.getElementsByTagName("msg")[0].firstChild.data;
	message = $(fieldID + "Failed");
	message.className = (result == "0") ? "error" : "hidden";
	message.innerHTML = errorMsg; 

	setTimeout("validate();", 500);
}

function displayError($message)
{
  if (showErrors) {
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
 <h1>開設申請</h1>
<!-- 內容說明 -->
<h2>操作說明：</h2>
<div style="text-align:center;">
<div class="intro">
  <ol>
    <li>請先選擇課程屬性：自學式或是教導式 </li>
    <li>先填好下列欄位，填好按送出。 </li>
    <li>送出之後，開課單位必須指定授課教師帳號，（所以您需要有授課教師帳號）。 </li>
    <li>被指定之教師帳號需建置教材，建置完畢後提出開課審核申請，審核通過即可開課。</li>
　</ol>
<span class="imp">注意：請謹慎填寫。 </span>
</div></div>
<h2>填寫開課申請資料</h2>
<!--功能部分 -->
<!--{$actionPage}-->
<form id="create_course" name="create_course" method="post" action="{$actionPage}&attribute={$attribute}" onkeypress="disableEnterKey(event);">
  <!-- name -->
  <div class="searchbar" style="margin-left:50px;width:95%;"><div class="describe" style="margin-bottom:6px;">step1:請選擇您欲開設課程為"自學式"或"教導式"。</div>
  <select name="attribute" onChange="checkSelect(this);" length="30">
    <option value="2" {if $attribute eq 2} selected {/if}>請選擇自學式課程或教導式課程</option>
    <option value="0" {if $attribute eq 0} selected {/if}>自學式 </option>
    <option value="1" {if $attribute eq 1} selected {/if}>教導式 </option>
  </select>


{if $attribute != 2}
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #aaa; border-style: none none dotted;">
<div class="describe" style="margin-bottom:6px">step2:請填寫開課欄位。<br/>按確認送出之後，如仍有紅字，請填寫正確格式再按送出即可。</div>
  <table class="datatable">
    <tr>
    	<th width="30%">課程性質</th>
	<td>
	<select name="course_property" id="course_property" length="30" onChange="validate(this.value, this.id);">
    <option value="-1" {if $course_property eq -1} selected {/if}>請選擇</option>
	{section name=counter loop=$total_course_property}
		<option value="{$total_course_property[counter].property_cd}" {if $course_property eq $total_course_property[counter].property_cd} selected {/if}>{$total_course_property[counter].property_name}</option>
	{/section}
	</select>
        <span id="course_propertyFailed" class="{$course_propertyFailed}">*課程性質尚未選擇。</span>
	</td>
    </tr>
    <tr>
    <th width="300">傳送高師大申請研習時數</th>
    <td>
    <input type="radio" name="deliver" id="deliver" value="1" {if $deliver eq 1} checked {/if} onclick="checkSelect(this);">是
    <input type="radio" name="deliver" id="deliver" value="0" {if $deliver eq 0} checked {/if} onclick="checkSelect(this);">否
    本課程是否傳送高師大『全國教師在職進修網』申請研習時數？</td>
    </tr>
    <tr>
    <th width="300">本課程是否開放給訪客閱讀</th>
    <td>
    <input type="radio" name="guest_allowed" id="guest_allowed" value="1" {if $guest_allowed eq 1} checked {/if}>是
    <input type="radio" name="guest_allowed" id="guest_allowed" value="0" {if $guest_allowed eq 0} checked {/if}>否
    </td>
    </tr>

    <tr>
      <th>課程名稱</th>
      <td>
	  <input id="begin_course_name" name="begin_course_name" autocomplete="off" type="text" value="{$begin_course_name}" onblur="validate(this.value, this.id);"/>
        <span id="begin_course_nameFailed" class="{$begin_course_nameFailed}">*課程名稱未填或是格式錯誤。</span>
      </td>
    </tr>
    {if $deliver == 1}
    <tr>
      <th>依據文號</th>
      <td>
	  <input id="article_number" name="article_number" autocomplete="off" type="text" value="{$article_number}" onblur="validate(this.value,this.id);">
       若無則填"無文號"。 <span id="article_numberFailed" class="{$article_numberFailed}">*依據文號尚未填入或格式錯誤。</span></td>
    </tr>
    <tr>
      <th>課程研習對象階段</th>
      <td>
      <input type="checkbox" name="course_stage_option1" id="course_stage_option1" {if $course_stage_option1 != NULL} checked {/if} value=10 onchange="validate(this.value,this.id);">高中</input>
      <input type="checkbox" name="course_stage_option2" id="course_stage_option2" {if $course_stage_option2 != NULL} checked {/if} value=20 onchange="validate(this.value,this.id);">高職</input>
      <input type="checkbox" name="course_stage_option3" id="course_stage_option3" {if $course_stage_option3 != NULL} checked {/if} value=30 onchange="validate(this.value,this.id);">國中</input>
      <input type="checkbox" name="course_stage_option4" id="course_stage_option4" {if $course_stage_option4 != NULL} checked {/if} value=40 onchange="validate(this.value,this.id);">國小</input>
        <span id="course_stageFailed" class="{$course_stageFailed}">*課程研習對象階段不可為空</span>
      </td>
    </tr>
    <tr>
      <th>課程研習對象身分</th>
      <td>
      <select name="career_stage" id="career_stage" onChange="validate(this.value,this.id);">
      <option value="-1" {if $career_stage eq "-1"} selected {/if}>請選擇職位</option>
      <option value="校長" {if $career_stage eq "校長"} selected {/if}>校長</option>
      <option value="主任" {if $career_stage eq "主任"} selected {/if}>主任</option>
      <option value="一般教師" {if $career_stage eq "一般教師"} selected {/if}>一般教師</option>
      </select>
        <span id="career_stageFailed" class="{$career_stageFailed}">*課程研習對象身分尚未選擇</span>
      </td>
    </tr>
    {/if}
    
    {if $attribute == 1}
    <tr>
      <th>課程時數</th>
      <td><input id="take_hour" name="take_hour" autocomplete="off" type="text" size="2" value="{$take_hour}" class="required validate-number min-value-0">  小時
      <!--<span id="take_hourFailed" class="{$take_hourFailed}">*課程時數尚未選擇</span>-->
      </td>
    </tr>
    {/if}

    <tr>
      <th>認證時數</th>
      <td><input id="certify" name="certify" autocomplete="off" type={if $deliver eq 1}"text"{else}"hidden"{/if} size="2" value={if $deliver eq 1}"{$certify}"{else}"0"{/if} onblur="validate(this.value,this.id);"{if $deliver eq 0} readonly{/if}>  小時 (時數需傳送至全國教師在職進修網才需填寫)
      <span id="certifyFailed" class="{$certifyFailed}">*認證時數尚未填寫或是格式錯誤。</span>
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
    	<th>課程類別</th>
	<td>
	<select name="course_unit" length="30" onChange="checkSelect(this); validate(this.value,this.id);">
	<option value="-1" {if $course_unit eq -1} selected {/if}>請選擇</option>
    {section name=counter loop=$total_course_unit}
		<option value="{$total_course_unit[counter].unit_cd}" {if $course_unit eq $total_course_unit[counter].unit_cd} selected {/if}>{$total_course_unit[counter].unit_name}</option>
	{/section}
	</select>
	<span id="course_unitFailed" class="{$course_unitFailed}">*課程類別尚末選擇</span>
    </td>
    </tr>
    {if $department > -1}
    <tr>
    	<th>課程子類別</th>
	<td>
	<select name="begin_unit_cd" id="begin_unit_cd" length="30" onChange="validate(this.value,this.id);">
    <option value="-1" {if $begin_unit_cd eq -1} selected {/if}>請選擇</option>
	{section name=counter loop=$total_course_subunit}
		<option value="{$total_course_subunit[counter].unit_cd}" {if $begin_unit_cd eq $total_course_subunit[counter].unit_cd} selected {/if}>{$total_course_subunit[counter].unit_name}</option>
	{/section}
	</select>
    <span id="begin_unit_cdFailed" class="{$begin_unit_cdFailed}">課程子類別選項尚未選擇。</span>
	</td>
    </tr>
    {/if}
    {if $attribute == 0}
    <tr>
    	<th>修課期限
        <br/>
        </th>
	<td>
	<select name="course_duration" id="course_duration" length="30" onChange="validate(this.value, this.id);">
	<option value="0" {if $course_duration eq 0} selected {/if}>請選擇</option>
    <option value="1" {if $course_duration eq 1} selected {/if}>一個月</option>
	<option value="2" {if $course_duration eq 2} selected {/if}>二個月</option>
	<option value="3" {if $course_duration eq 3} selected {/if}>三個月</option>
	<option value="4" {if $course_duration eq 4} selected {/if}>四個月</option>
	<option value="5" {if $course_duration eq 5} selected {/if}>五個月</option>
	<option value="6" {if $course_duration eq 6} selected {/if}>六個月</option>
	<option value="7" {if $course_duration eq 7} selected {/if}>七個月</option>
	<option value="8" {if $course_duration eq 8} selected {/if}>八個月</option>
	<option value="9" {if $course_duration eq 9} selected {/if}>九個月</option>
	<option value="10" {if $course_duration eq 10} selected {/if}>十個月</option>
	<option value="11" {if $course_duration eq 11} selected {/if}>十一個月</option>
	<option value="12" {if $course_duration eq 12} selected {/if}>十二個月</option>
	</select>
    </br>*開課完成後，如再修改會影響學員的修課期間，請謹慎選擇。
    <span id="course_durationFailed" class="{$course_durationFailed}"></br>*修課期限尚未選擇</span>
	</td>
    </tr>
    {/if}
    
    <tr>
      <th>課程開始日期</th>
      <td>
	  	<input type='text' name='d_course_begin' value="{$d_course_begin}" class="required validate-date-cn"/>
		
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_course_begin';  
		  myDate.display();
		-->
		</script>		</td>
    </tr>
    <tr>
      <th>課程結束日期</th>
      <td>
	  <input class="required validate-date-cn" type='text' name='d_course_end' value="{$d_course_end}"/>
		<script language=javascript type="text/javascript">

		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_course_end';  
		  myDate.display();
		-->
		</script>	   </td>
    </tr>
    <tr>
      <th>課程公開日期</th>
      <td>
	  <input class="required validate-date-cn"  type='text' name='d_public_day' value="{$d_public_day}"/>
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_public_day';  
		  myDate.display();
		-->
		</script>		</td>
    </tr>
 {if $attribute == 1}	
    <tr>
      <th>選課開始日期</th>
      <td>
	  <input class="required validate-date-cn" type='text' name='d_select_begin' value="{$d_select_begin}"/>
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_select_begin';  
		  myDate.display();
		-->
		</script>		</td>
    </tr>
    <tr>
      <th>選課結束日期</th>
      <td>
	  <input class="required validate-date-cn" type='text' name='d_select_end' value="{$d_course_end}"/>
		<script language=javascript type="text/javascript">
		<!--
		  var myDate=new dateSelector();
		  myDate.year;
		  myDate.inputName='d_select_end';  
		  myDate.display();
		-->
		</script>	  </td>
    </tr>
 {/if}	
	 {if $attribute == 1}
    <tr>
      <th>課程所屬的學年</th>
      <td>
		<input class="required validate-number" id="course_year" autocomplete="off" name="course_year" type="text" value="{$valueOfCourse_year}" maxlength="2" size="2"/>學年        
        <!--<div id="course_yearFailed" class="{$course_yearFailed}">格式錯誤或此欄空白</div>-->	  </td>
    </tr>
    <tr>
      <th>課程所屬的學期</th>
      <td>
		<input id="course_session" name="course_session" class="required validate-number max-length-2"type="text" value="{$valueOfCourse_session}" maxlength="2"  size="2"/>學期
        <!--<div id="course_sessionFailed" class="{$course_sessionFailed}">格式錯誤或此欄空白</div>-->      </td>
    </tr>
    {/if}
    {if $attribute == 1}
    <tr>
      <th>招收名額</th>
      <td><input id="quantity" name="quantity" type="text" autocomplete="off" size="2" value="{$quantity}" onblur="validate(this.value,this.id);">人
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
      <th>評量標準(總分) </br><font color="red">如果課程沒有測驗請設0</font>
      </th>
      <td><input id="criteria_total" name="criteria_total" autocomplete="off" type="text" size="2" value="{$criteria_total}"onblur="validate(this.value,this.id);">(不超過100)
      <span id="criteria_totalFailed" class="{$criteria_totalFailed}">*評量標準(總分)尚未填寫或是格式錯誤</span>
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
      <th>教材閱讀時數</th>
      <td>
      <input type="text" name="criteria_content_hour_1" id="criteria_content_hour_1" autocomplete="off" size="2" value="{$criteria_content_hour_1}" onblur="validate(this.value,this.id);">時
      <span id="criteria_content_hour_1Failed" class="{$criteria_content_hour_1Failed}">時間格式錯誤。</span>
      <input type="text" name="criteria_content_hour_2" id="criteria_content_hour_2" autocomplete="off" size="2" value="{$criteria_content_hour_2}" onblur="validate(this.value,this.id);">分
      <span id="criteria_content_hour_2Failed" class="{$criteria_content_hour_2Failed}">時間格式錯誤。</span>
      <br/> 請填入正確格式
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
{if $is_doc_instructor}{* 如果是輔導團開課 *}
    <tr>
      <th>課程所屬DOC</th>
      <td>	
		<select name="doc">
		{html_options options=$doc_options}
		</select>
      </td>
    </tr>
{/if}
    <tr>
      <th>承辦人</th>
      <td><input autocomplete="off" type="text" id="director_name" name="director_name" value="{$director_name}" onblur="validate(this.value, this.id);">
      <span id="director_nameFailed" class="{$director_nameFailed}">*承辦人尚未填寫或是格式錯誤</span>
      </td>
    </tr>
    <tr>
      <th>承辦人電話</th>
      <td>(區碼)<input autocomplete="off" type="text" size="2" id="director_tel_area" name="director_tel_area" value="{$director_tel_area}" maxlength="4">
      -<input autocomplete="off" type="text" size="5" id="director_tel_left" name="director_tel_left" value="{$director_tel_left}" maxlength="8"onblur="validate(this.value, this.id);">
      #<input autocomplete="off" type="text" size="1" id="director_tel_ext" name="director_tel_ext" value="{$director_tel_ext}">(分機)
      <br/>區碼為二碼或三碼 手機區碼請填四碼(09xx)
      <span id="director_telFailed" class="{$director_telFailed}">承辦人電話有欄位空白或是格式錯誤。</span>
      </td>
    </tr>
    <tr>
      <th>承辦人電子信箱</th>
      <td><input autocomplete="off" type="text" id="director_email" name="director_email" value="{$director_email}"onblur="validate(this.value, this.id);">
      <span id="director_emailFailed" class="{$director_emailFailed}">*承辦人信箱尚未填入或是格式錯誤</span>
      </td>
    </tr>
    {if $attribute == 1}
    <tr>
      <th>選課自動審查</th>
      <td><input type="radio" name="auto_admission" id="auto_admission" value="0"{if $auto_admission eq 0}checked{/if}>是
          <input type="radio" name="auto_admission" id="auto_admission" value="1"{if $auto_admission eq 1}checked{/if}>否<br/>
      </td>
    </tr>
    {/if}
    <tr>
      <th>備註</th>
      <td><input id="note" name="note" autocomplete="off" type="text"></td>
    </tr>
    <tr>
      <th>指定授課教師帳號</th>
      <td><input id="teacher" name="teacher" autocomplete="off" type="text"  value="{$teacher}" onblur="validate(this.value, this.id);"/> 
	  <span id="teacherFailed" class="{$teacherFailed}">*教師帳號有誤，此人不存在</span>
	  </td>
    </tr>
    </table>
<!-- 按鈕-->
      <p align="center">  <input type="submit"  value="確定送出" class="btn" /></p>

  {/if}</div> 
</form>


<script type="text/javascript">
{literal}
	function formCallback(result, form) {
		window.status = "valiation callback for form '" + form.id + "': result = " + result;
	}
	
	var valid = new Validation('create_course', {immediate : true, onFormValidate : formCallback});
{/literal}
</script>

<br/>
<br/>
<br/>
<br/>
</body>
</html>
