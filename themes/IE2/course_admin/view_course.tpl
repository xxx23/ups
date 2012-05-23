{config_load file='course_admin/view_course.lang'}
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="{$tpl_path}/css/table_news.css" rel="stylesheet" type="text/css">



<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
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
<script language="javascript">
<!--
{literal}

var serverAddress="validate_begin_course_advance.php";

function showSelect(req){
	var responseXML,xmlDoc, select_g,option_g, a_select, a_option, i, j, cd , name;
	var tmp_select, tmp_option, tmp_text;
	responseXML = req.responseXML;
	xmlDoc = responseXML.documentElement;
	select_g = xmlDoc.getElementsByTagName('select');
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
		//Element.show('loadingGif');
        $.ajax({
            type: 'get',
            url: serverAddress,
            dataType: 'xml',
            data: parms,
            success: showSelect
            });

	}
}

function checkSelect(obj){
	var myForm=document.forms['modify_course'];
	myForm.action = 'view_course.php';
	myForm.method = 'POST';
	myForm.submit();
	return ;
}

/*function modifyDate(d)
{
    document.getElementById('DS_' + d.name).value = d.value;
}*/

{/literal}
-->
</script>
<title>{#edit_course#}</title>
</head>

<body class="ifr" bgcolor="#E3F1FD">
<!-- 標題 -->
<h1>{#edit_course#}</h1>
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
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#course_type#}</th>
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
    <br/>{#attention#}
	</td>
</tr>
<tr>
	<th width="300"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#send_or_not#}</th>
	<td>
	<input type="radio" name="deliver" id="deliver" value="1" {if $deliver eq 1} checked {/if} onclick="checkSelect(this);"/>{#yes#}
	<input type="radio" name="deliver" id="deliver" value="0" {if $deliver eq 0} checked {/if} onclick="checkSelect(this);"/>{#no#}
	</td>
</tr>
<tr>
	<th width="300"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#open_or_not#}</th>
	<td>
	<input type="radio" name="guest_allowed" id="guest_allowed" value="1" {if $guest_allowed eq 1} checked {/if}/>{#yes#}
	<input type="radio" name="guest_allowed" id="guest_allowed" value="0" {if $guest_allowed eq 0} checked {/if}/>{#no#}
	</td>
</tr>
{if $deliver == 1}
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#allowno#}</th>
	<td>
		<input id="article_number" name="article_number" autocomplete="off" type="text" value="{$article_number}" class="required validate-alphanum" title="請輸入文號">
	</td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#level#}</th>
	<td>
        <input type="hidden" name="post_state" value="1">
        <input type="checkbox" name="course_stage_option1" value=10 {if $check_stage1} checked {/if}>{#senior#}</input>
        <input type="checkbox" name="course_stage_option2" value=23 {if $check_stage2} checked {/if}>{#vocational#}</input>
        <input type="checkbox" name="course_stage_option3" value=30 {if $check_stage3} checked {/if}>{#junior#}</input>
        <input type="checkbox" name="course_stage_option4" value=40 {if $check_stage4} checked {/if}>{#elementary#}</input>
    </td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#identity#}</th>
	<td>
	<select name="career_stage">
	<option value="無" {if $career_stage eq "{#none#}"} selected {/if}>{#select_stage#}</option>
	<option value="校長" {if $career_stage eq "{#president#}"} selected {/if}>{#president#}</option>
	<option value="主任" {if $career_stage eq "{#director#}"} selected {/if}>{#director#}</option>
	<option value="一般教師" {if $career_stage eq "{#teacher#}"} selected {/if}>{#teacher#}</option>
	</select>
	</td>
</tr>
{/if}
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#course_name#}</th>
	<td>
	<input type="text" name="begin_course_name" value="{$begin_course_name}" class="required validation-failed" />
	</td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#course_no#}</th>
	<td><input name="inner_course_cd" id="inner_course_cd" type="hidden" value="{$inner_course_cd}">{$inner_course_cd}</td>
</tr>
{if $attribute == 1}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#course_time#}</th>
	<td>
	<input type="text" name="take_hour" value="{$take_hour}" />
	</td>
</tr>
{/if}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#certification#}</th>
	<td>
	<input type="text" name="certify" value="{$certify}" class="required validate-number "/>
	</td>			
</tr>
{if $attribute == 1}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#open#}</th>
	<td>
	{if $is_preview == 1}
	<input type="radio" name="is_preview" id="is_preview" value="1" checked>  {#yes#}
	<input type="radio" name="is_preview" id="is_preview" value="0">  {#no#}
	{else}
	<input type="radio" name="is_preview" id="is_preview" value="1">  {#yes#}
	<input type="radio" name="is_preview" id="is_preview" value="0" checked>  {#no#}
	{/if}
	</td>				
</tr>
{/if}
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#course_category#}</th>
	<td>
	<select name="course_unit" length="30" onchange="checkSelect(this);">
	{section name=counter loop=$total_course_unit}
		<option value="{$total_course_unit[counter].unit_cd}" {if $upper_course_type eq $total_course_unit[counter].unit_cd} selected {/if}>{$total_course_unit[counter].unit_name}</option>
	{/section}
	</td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#category#}</th>
        <td>
        <select name="begin_unit_cd" length="30">
        {section name=counter loop=$total_course_subunit}
		<option value="{$total_course_subunit[counter].unit_cd}" {if $begin_unit_cd eq $total_course_subunit[counter].unit_cd} selected {/if}>{$total_course_subunit[counter].unit_name}</option>
	{/section}
	</select>
        </td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>修課期限</th>
	<td>
	<select name="course_duration" length="30">
    <option value="1" {if $course_duration eq 1} selected {/if}>{#one#}</option>
    <option value="2" {if $course_duration eq 2} selected {/if}>{#two#}</option>
    <option value="3" {if $course_duration eq 3} selected {/if}>{#three#}</option>
    <option value="4" {if $course_duration eq 4} selected {/if}>{#four#}</option>
    <option value="5" {if $course_duration eq 5} selected {/if}>{#five#}</option>
    <option value="6" {if $course_duration eq 6} selected {/if}>{#six#}</option>
    <option value="7" {if $course_duration eq 7} selected {/if}>{#seven#}</option>
    <option value="8" {if $course_duration eq 8} selected {/if}>{#eight#}</option>
    <option value="9" {if $course_duration eq 9} selected {/if}>{#nine#}</option>
    <option value="10" {if $course_duration eq 10} selected {/if}>{#ten#}</option>
    <option value="11" {if $course_duration eq 11} selected {/if}>{#eleven#}</option>
    <option value="12" {if $course_duration eq 12} selected {/if}>{#twelve#}</option>
	</select>
    </td>
</tr>

{if $attribute == 1}
<tr>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#start_date#}</th>
	<td>
	<input type='text' id='d_course_begin' name='d_course_begin' value="{$d_course_begin}" class="required validate-date-cn" readonly='readonly'/>
	</td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#end_date#}</th>	
	<td>
	<input class="required validate-date-cn" type='text' id='d_course_end' name='d_course_end' value="{$d_course_end}" readonly='readonly' />
	</td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#public_date#}</th>
	<td>
	  <input class="required validate-date-cn"  type='text' id='d_public_day' name='d_public_day' value="{$d_public_day}" readonly='readonly' />
	</td>	
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#select_start#}</th>
	<td>
	<input class="required validate-date-cn" type='text' id='d_select_begin' name='d_select_begin' value="{$d_select_begin}" readonly='readonly' />
	</td>
</tr>
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#select_end#}</th>
	<td>	
	<input class="required validate-date-cn" type='text' id='d_select_end' name='d_select_end' value="{$d_course_end}" readonly='readonly' />
	</td>
</tr>
{/if}
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#beyond_year#}</th>
	<td>
	<input id="course_year" name="course_year" type="text" value="{$course_year}" maxlength="2" size="2" />{#year#}
		<!--<div id="course_yearFailed" class="{$course_yearFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>		
{if $attribute == 1}
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#session#}</th>
	<td>
<input id="course_session" name="course_session" type="text" value="{$course_session}" maxlength="2" size="2" />{#year#}
		<!--<div id="course_sessionFailed" class="{$course_sessionFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#head#}</th>
        <td>
        <input type="text" name="quantity" value="{$quantity}" />{#person#}
        </td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#charge#}</th>
        <td>
        {#price#} <input type="text" name="charge" value="{$charge}" /> {#dollar#}
        <font color="red">*{#sale#}</font> <input type="text" name="charge_discount" value="{$charge_discount}">{#dollar#}
        </td>
	</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#course_city#}</th>
        <td>
        <input type="text" name="class_city" value="{$class_city}" />{#city#}
        </td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#place#}</th>
        <td>
        <input type="text" name="class_place" value="{$class_place}" />
        </td>
</tr>
{/if}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#total_score#}</th>
        <td>
        <input type="text" name="criteria_total" value="{$criteria_total}" class="required max-value-100" />{#under#}100
        </td>
</tr>
{if $attribute == 1}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#score#}</th>
        <td>
        <input type="text" name="criteria_score" value="{$criteria_score}" />
        </td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#percentage#}</th>
        <td>
        <input type="text" name="criteria_score_pstg" value="{$criteria_score_pstg}" />%
        </td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#teacher_score#}</th>
        <td>
        <input type="text" name="criteria_tea_score" value="{$criteria_tea_score}" />
        </td>	
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#teacher_percentage#}</th>
        <td>
        <input type="text" name="criteria_tea_score_pstg" value="{$criteria_tea_score_pstg}" />%
        </td>
</tr>
{/if}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#hours#}</th>
        <td>
        <input type="text" name="criteria_content_hour_1" value="{$criteria_content_hour_1}" size="5" class="required min-value-0" />{#hour#}
        <input type="text" name="criteria_content_hour_2" value="{$criteria_content_hour_2}" size="5" class="required min-value-0" />{#minute#}
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
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#questionnaire#}</th>
        <td>
        <input type="text" name="criteria_finish_survey" value="{$criteria_finish_survey}" />%
</td>
</tr>
{/if}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#director_name#}</th>
        <td>
        <input type="text" name="director_name" value="{$director_name}" />
        </td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#director_tel#}</th>
        <td>
        區碼<input type="text" name="director_tel_area" value="{$director_tel_area}" size="2" maxlength="4" class="validate-number  max-length-4"/>
        -<input type="text" name="director_tel_left" value="{$director_tel_left}" size="5" maxlength="8" class="validate-number   max-length-8"/>
        #<input type="text" name="director_tel_ext" value="{$director_tel_ext}" size="2" class="validate-number max-length-4">{#ext#}
        <br/>
        區碼 手機號碼請填四碼(09xx)
        </td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#director_mail#}</th>
        <td>
        <input type="text" name="director_email" value="{$director_email}" class="required validate-email"/>
        </td>
</tr>
{if $attribute == 1}
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#auto#}</th>
<td>	
	{if $auto_admission == 1}
        <input type="radio" name="auto_admission" value="1" checked>{#yes#}
        <input type="radio" name="auto_admission" value="0">{#no#}
	{else}
        <input type="radio" name="auto_admission" value="1">{#yes#}
        <input type="radio" name="auto_admission" value="0" checked>{#no#}
	{/if}
        </td>
</tr>
<tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>{#note#}</th>
        <td>
        <input type="text" name="note" value="{$note}" />
        </td>
</tr>
{/if}
</table>
<input class="btn" type="submit" value="{#enter#}" />
<input class="btn" type="button" value="{#back#}" onClick="location.href='show_all_begin_course.php';" />
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
