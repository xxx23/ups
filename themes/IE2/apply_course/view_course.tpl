<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
<script src="../script/prototype.js" type="text/javascript" ></script>
<script src="../script/effects.js" type="text/javascript"></script>
<script type="text/javascript" src="../script/validation_cn.js"></script>
<script src="../script/calendar.js" type="text/javascript" ></script>
<script language="javascript">
<!--
{literal}

var serverAddress="validate_begin_course_advance.php";

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

function checkSelect(obj){
	var myForm=document.forms['modify_course'];
	myForm.action = 'view_course.php';
	myForm.method = 'POST';
	myForm.submit();
	return ;
}

//add by aeik

//end

{/literal}
-->
</script>
<title>修改課程資訊</title>
</head>
<body><!-- 標題 -->
<h1>修改課程資訊</h1>
<!-- 內容說明 -->
<!--
<div>
<br />
操作說明：<br />
	<font color="#FF0000">尚無</font><br />
	<br />
</div>-->
<!--功能部分 -->
<form id="modify_course" name="modify_course" method="post" action="view_course.php?action=modify">
<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}"/>
<input type="hidden" name="course_cd" value="{$course_cd}"/>
<input type="hidden" name="attribute" value="{$attribute}"/>
<table class="datatable">
<tr>
	<th width="27%">課程性質</th>
	<td>
    <!--
    {section name=counter loop=$total_course_property}
        {if $course_property == $total_course_property[counter].property_cd}{$total_course_property[counter].property_name}{/if}
    {/section}
    -->
	<select name="course_property" length="30" onchange="checkSelect(this);">
	{section name=counter loop=$total_course_property}
		<option value="{$total_course_property[counter].property_cd}" {if $course_property eq $total_course_property[counter].property_cd} selected {/if}>{$total_course_property[counter].property_name}</option>
	{/section}
	</select>
    <br/>請注意，變更課程性質會使課程編號也做改變。使用過的課程編號即不能再度使用。
	</td>
</tr>
<tr>
	<th width="300">傳送高師大研習時數</th>
	<td>
	<input type="radio" name="deliver" id="deliver" value="1" {if $deliver eq 1} checked {/if} onclick="checkSelect(this);"/>是
	<input type="radio" name="deliver" id="deliver" value="0" {if $deliver eq 0} checked {/if} onclick="checkSelect(this);"/>否
	　（本課程是否傳送高師大『全國教師在職進修網』申請研習時數）</td>
</tr>
<tr>
	<th width="300">本課程是否開放給訪客閱讀</th>
	<td>
	<input type="radio" name="guest_allowed" id="guest_allowed" value="1" {if $guest_allowed eq 1} checked {/if}/>是
	<input type="radio" name="guest_allowed" id="guest_allowed" value="0" {if $guest_allowed eq 0} checked {/if}/>否
	</td>
</tr>
{if $deliver == 1}
<tr>
	<th>依據文號</th>
	<td>
		<input id="article_number" name="article_number" autocomplete="off" type="text" value="{$article_number}" class="required validate-alphanum" title="請輸入文號">
        若無則填"無文號"。
    </td>
</tr>
<tr>
	<th>課程研習對象階段</th>
	<td>
        <input type="hidden" name="post_state" value="1">
        <input type="checkbox" name="course_stage_option1" value=10 {if $check_stage1} checked {/if}>高中</input>
        <input type="checkbox" name="course_stage_option2" value=23 {if $check_stage2} checked {/if}>高職</input>
        <input type="checkbox" name="course_stage_option3" value=30 {if $check_stage3} checked {/if}>國中</input>
        <input type="checkbox" name="course_stage_option4" value=40 {if $check_stage4} checked {/if}>國小</input>
    </td>
</tr>
<tr>
	<th>課程研習對象身分</th>
	<td>
	<select name="career_stage">
	<option value="無" {if $career_stage eq "無"} selected {/if}>請選擇職位</option>
	<option value="校長" {if $career_stage eq "校長"} selected {/if}>校長</option>
	<option value="主任" {if $career_stage eq "主任"} selected {/if}>主任</option>
	<option value="一般教師" {if $career_stage eq "一般教師"} selected {/if}>一般教師</option>
	</select>
	</td>
</tr>
{/if}
<tr>
	<th>課程名稱</th>
	<td>
	<input type="text" name="begin_course_name" value="{$begin_course_name}" class="required validation-failed" />
	</td>
</tr>
<tr>
	<th>課程編號</th>
	<td><input name="inner_course_cd" id="inner_course_cd" type="hidden" value="{$inner_course_cd}">{$inner_course_cd}</td>
</tr>
{if $attribute == 1}
<tr>
    <th>課程時數</th>
	<td>
	<input type="text" name="take_hour" value="{$take_hour}" />
	</td>
</tr>
{/if}
<tr>
    <th>認証時數</th>
	<td>
	<input type="text" name="certify" value="{$certify}" class="required validate-number "/>
	</td>			
</tr>
{if $attribute == 1}
<tr>
    <th>教材是否試閱</th>
	<td>
	{if $is_preview == 1}
	<input type="radio" name="is_preview" id="is_preview" value="1" checked>  是
	<input type="radio" name="is_preview" id="is_preview" value="0">  否
	{else}
	<input type="radio" name="is_preview" id="is_preview" value="1">  是
	<input type="radio" name="is_preview" id="is_preview" value="0" checked>  否
	{/if}
	</td>				
</tr>
{/if}
<tr>
	<th>課程類別</th>
	<td>
	<select name="course_unit" length="30" onchange="checkSelect(this);">
	{section name=counter loop=$total_course_unit}
		<option value="{$total_course_unit[counter].unit_cd}" {if $upper_course_type eq $total_course_unit[counter].unit_cd} selected {/if}>{$total_course_unit[counter].unit_name}</option>
	{/section}
	</td>
</tr>
<tr>
    <th>課程子類別</th>
        <td>
        <select name="begin_unit_cd" length="30">
        {section name=counter loop=$total_course_subunit}
		<option value="{$total_course_subunit[counter].unit_cd}" {if $begin_unit_cd eq $total_course_subunit[counter].unit_cd} selected {/if}>{$total_course_subunit[counter].unit_name}</option>
	{/section}
	</select>
        </td>
</tr>
<tr>
	<th>修課期限</th>
	<td>
	<select name="course_duration" length="30">
    <option value="1" {if $course_duration eq 1} selected {/if}>1個月</option>
    <option value="2" {if $course_duration eq 2} selected {/if}>2個月</option>
    <option value="3" {if $course_duration eq 3} selected {/if}>3個月</option>
    <option value="4" {if $course_duration eq 4} selected {/if}>4個月</option>
    <option value="5" {if $course_duration eq 5} selected {/if}>5個月</option>
    <option value="6" {if $course_duration eq 6} selected {/if}>6個月</option>
    <option value="7" {if $course_duration eq 7} selected {/if}>7個月</option>
    <option value="8" {if $course_duration eq 8} selected {/if}>8個月</option>
    <option value="9" {if $course_duration eq 9} selected {/if}>9個月</option>
    <option value="10" {if $course_duration eq 10} selected {/if}>10個月</option>
    <option value="11" {if $course_duration eq 11} selected {/if}>11個月</option>
    <option value="12" {if $course_duration eq 12} selected {/if}>12個月</option>
	</select>
    </td>
</tr>

{if $attribute == 1}
<tr>
    <th>課程開始日期</th>
	<td>
	<input type="text" name="d_course_begin" value="{$d_course_begin}" />		
	<script language=javascript type="text/javascript">
	<!--
	  var myDate=new dateSelector();
	  myDate.year;
	  myDate.inputName='d_course_begin';  
	  myDate.display();
	-->
	</script>
	</td>
</tr>
<tr>
	<th>課程結束日期</th>	
	<td>
	<input type="text" name="d_course_end" value="{$d_course_end}" />		
	<script language=javascript type="text/javascript">
	<!--
	  var myDate=new dateSelector();
	  myDate.year;
	  myDate.inputName='d_course_end';  
	  myDate.display();
	-->
	</script>	
	</td>
</tr>
<tr>
	<th>開課公開日期</th>
	<td>
	  <input type='text' name='d_public_day'  value="{$d_public_day}"  />
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
	<input type="text" name="d_select_begin" value="{$d_select_begin}" />
	<script language=javascript type="text/javascript">
	<!--
	  var myDate=new dateSelector();
	  myDate.year;
	  myDate.inputName='d_select_begin';  
	  myDate.display();
	-->
	</script>			
	</td>
</tr>
<tr>
	<th>選課結束日期</th>
	<td>	
	<input type="text" name="d_select_end" value="{$d_select_end}" />	
	<script language=javascript type="text/javascript">
	<!--
	  var myDate=new dateSelector();
	  myDate.year;
	  myDate.inputName='d_select_end';  
	  myDate.display();
	-->
	</script>	
	</td>
</tr>
<tr>
	<th>開課所屬的學年</th>
	<td>
	<input id="course_year" name="course_year" type="text" value="{$course_year}" maxlength="2" size="2" />學年
		<!--<div id="course_yearFailed" class="{$course_yearFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>		
<tr>
	<th>開課所屬的學期</th>
	<td>
<input id="course_session" name="course_session" type="text" value="{$course_session}" maxlength="2" size="2" />學期
		<!--<div id="course_sessionFailed" class="{$course_sessionFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
        <th>招收名額</th>
        <td>
        <input type="text" name="quantity" value="{$quantity}" />人
        </td>
</tr>
<tr>
        <th>學習費用</th>
        <td>
        定價 <input type="text" name="charge" value="{$charge}" /> 元
        <font color="red">*優惠價</font> <input type="text" name="charge_discount" value="{$charge_discount}">元
        </td>
	</tr>
<tr>
        <th>上課縣市</th>
        <td>
        <input type="text" name="class_city" value="{$class_city}" />縣(市)
        </td>
</tr>
<tr>
        <th>上課地點</th>
        <td>
        <input type="text" name="class_place" value="{$class_place}" />
        </td>
</tr>
{/if}
<tr>
        <th>評量標準(總分)</th>
        <td>
        <input type="text" name="criteria_total" value="{$criteria_total}" class="required max-value-100" />不超過100
        </td>
</tr>
{if $attribute == 1}
<tr>
        <th>評量標準(線上成績)</th>
        <td>
        <input type="text" name="criteria_score" value="{$criteria_score}" />
        </td>
</tr>
<tr>
        <th>評量標準(線上成績比例)</th>
        <td>
        <input type="text" name="criteria_score_pstg" value="{$criteria_score_pstg}" />%
        </td>
</tr>
<tr>
        <th>評量標準(老師成績)</th>
        <td>
        <input type="text" name="criteria_tea_score" value="{$criteria_tea_score}" />
        </td>	
</tr>
<tr>
        <th>評量標準(老師成績比例)</th>
        <td>
        <input type="text" name="criteria_tea_score_pstg" value="{$criteria_tea_score_pstg}" />%
        </td>
</tr>
{/if}
<tr>
        <th>評量標準(觀看教材時間)</th>
        <td>
        <input type="text" name="criteria_content_hour_1" value="{$criteria_content_hour_1}" size="5" class="required min-value-0" />時
        <input type="text" name="criteria_content_hour_2" value="{$criteria_content_hour_2}" size="5" class="required min-value-0" />分
        <!--
        <select name="criteria_content_hour_1" value="{$criteria_content_hour_1}">
	<option value="00" {if $criteria_content_hour_1 eq "00"} selected {/if}>0</option>
	<option value="01" {if $criteria_content_hour_1 eq "01"} selected {/if}>1</option>
	<option value="02" {if $criteria_content_hour_1 eq "02"} selected {/if}>2</option>
	<option value="03" {if $criteria_content_hour_1 eq "03"} selected {/if}>3</option>
	<option value="04" {if $criteria_content_hour_1 eq "04"} selected {/if}>4</option>
	<option value="05" {if $criteria_content_hour_1 eq "05"} selected {/if}>5</option>
	<option value="06" {if $criteria_content_hour_1 eq "06"} selected {/if}>6</option>
	<option value="07" {if $criteria_content_hour_1 eq "07"} selected {/if}>7</option>
	<option value="08" {if $criteria_content_hour_1 eq "08"} selected {/if}>8</option>
	<option value="09" {if $criteria_content_hour_1 eq "09"} selected {/if}>9</option>
	<option value="10" {if $criteria_content_hour_1 eq "10"} selected {/if}>10</option>
	<option value="11" {if $criteria_content_hour_1 eq "11"} selected {/if}>11</option>
	<option value="12" {if $criteria_content_hour_1 eq "12"} selected {/if}>12</option>
	<option value="13" {if $criteria_content_hour_1 eq "13"} selected {/if}>13</option>
	<option value="14" {if $criteria_content_hour_1 eq "14"} selected {/if}>14</option>
	<option value="15" {if $criteria_content_hour_1 eq "15"} selected {/if}>15</option>
	<option value="16" {if $criteria_content_hour_1 eq "16"} selected {/if}>16</option>
	<option value="17" {if $criteria_content_hour_1 eq "17"} selected {/if}>17</option>
	<option value="18" {if $criteria_content_hour_1 eq "18"} selected {/if}>18</option>
	<option value="19" {if $criteria_content_hour_1 eq "19"} selected {/if}>19</option>
	<option value="20" {if $criteria_content_hour_1 eq "20"} selected {/if}>20</option>
	小時
	</select>
	<select name="criteria_content_hour_2" value="{$criteria_content_hour_2}">
	<option value="00" {if $criteria_content_hour_2 eq "00"} selected {/if}>00</option>
	<option value="10" {if $criteria_content_hour_2 eq "10"} selected {/if}>10</option>
	<option value="20" {if $criteria_content_hour_2 eq "20"} selected {/if}>20</option>
	<option value="30" {if $criteria_content_hour_2 eq "30"} selected {/if}>30</option>
	<option value="40" {if $criteria_content_hour_2 eq "40"} selected {/if}>40</option>
	<option value="50" {if $criteria_content_hour_2 eq "50"} selected {/if}>50</option>
	</select>
	分-->
        </td>
</tr>
{if $attribute == 1}
<tr>
        <th>評量標準(問卷填寫)</th>
        <td>
        <input type="text" name="criteria_finish_survey" value="{$criteria_finish_survey}" />%
</td>
</tr>
{/if}

{if $is_doc_instructor}{* 如果是輔導團開課 *}
    <tr>
      <th>課程所屬DOC</th>
      <td>	
		<select name="doc">
		{html_options options=$doc_options selected=$selected_doc}
		</select>
      </td>
    </tr>
{/if}
<tr>
        <th>承辦人</th>
        <td>
        <input type="text" name="director_name" value="{$director_name}" />
        </td>
</tr>
<tr>
        <th>承辦人人電話</th>
        <td>
        區碼<input type="text" name="director_tel_area" value="{$director_tel_area}" size="2" maxlength="4" class="validate-number  max-length-4"/>
        -<input type="text" name="director_tel_left" value="{$director_tel_left}" size="5" maxlength="8" class="validate-number   max-length-8"/>
        #<input type="text" name="director_tel_ext" value="{$director_tel_ext}" size="2" class="validate-number max-length-4">(分機)
        <br/>
        區碼 手機號碼請填四碼(09xx)
        </td>
</tr>
<tr>
        <th>承辦人電子信箱</th>
        <td>
        <input type="text" name="director_email" value="{$director_email}" class="required validate-email"/>
        </td>
</tr>
{if $attribute == 1}
<tr>
        <th>課程自動審查</th>
<td>	
	{if $auto_admission == 1}
        <input type="radio" name="auto_admission" value="1" checked>是
        <input type="radio" name="auto_admission" value="0">否
	{else}
        <input type="radio" name="auto_admission" value="1">是
        <input type="radio" name="auto_admission" value="0" checked>否
	{/if}
        </td>
</tr>
<tr>
        <th>備註</th>
        <td>
        <input type="text" name="note" value="{$note}" />
        </td>
</tr>
{/if}
</table><p align="center">
<input class="btn" type="submit" value="確定修改" />
<input class="btn" type="button" value="返回" onClick="location.href='begin_course_list.php';" /></p>
</form>
					<script type="text/javascript">
{literal}
						function formCallback(result, form) {
							window.status = "valiation callback for form '" + form.id + "': result = " + result;
						}
						
						var valid = new Validation('modify_course', {immediate : true, onFormValidate : formCallback});
{/literal}
					</script>
				</div>
</body>
</html>
