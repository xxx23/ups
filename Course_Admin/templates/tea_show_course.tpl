<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>查看課程內容</title>
</head>

<body>
<!-- 標題 -->
<center>編輯課程大綱</center>
<!-- 內容說明 -->
<div>
<br />
操作說明：<br />
	<font color="#FF0000">普通格式： 如果想修改，更改之後按[確定修改]。</font><br />
	<br />
</div>
<!--功能部分 -->
<form method="post" action="{$actionPage}">
<!-- name -->
<table border="0">
<tr>
	<td>課程科目名稱</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<!--<input id="course_name" name="course_name" type="text" value="{$valueOfCourse_name}" onblur="validate(this.value, this.id);">-->
			{$course_name}
			<input id="course_name" name="course_name" type="hidden" value="{$course_name}" />
		</td>
	</tr>
	</table>	
	<!--<div id="course_nameFailed" class="{$course_nameFailed}">格式錯誤或此欄空白</div>	-->
	</td>
</tr>
<!--          -->
<!--
<tr id="NKNU_format">
<td colspan="2">		
	<table>
		<tr>
			<td>課程性質</td>
			<td>1
			<select name="course_classify_1" id="course_classify_1" onchange="changeSelect(this.selectedIndex, this.id, 1);">
			{html_options values=$course_classify_1_ids selected=$course_classify_1_id output=$course_classify_1_names}
			</select>
			</td>
			<td>2
			<select name="course_classify_2" id="course_classify_2" onchange="changeSelect(this.selectedIndex, this.id, 2);">
			{html_options values=$course_classify_2_ids selected=$course_classify_2_id output=$course_classify_2_names}
			</select>				
			</td>
			<td>3
			<select name="course_classify_3" id="course_classify_3" onchange="changeSelect(this.selectedIndex, this.id, 3);">
			{html_options values=$course_classify_3_ids selected=$course_classify_3_id output=$course_classify_3_names}
			</select>				
			</td>
			<td>4
			<select name="course_classify_4" id="course_classify_4">
			{html_options values=$course_classify_4_ids selected=$course_classify_4_id output=$course_classify_4_names}
			</select>				
			</td>								
		</tr>
	</table>
</td>		
</tr>
-->	
<!--          -->
<!--<tr>
	<td>課程科目收費標準</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="charge" name="charge" type="text" value="{$ValueOfCharge}"></td>
	</tr>
	</table>-->
	<!--<div id="chargeFailed" class="{$chargeFailed}">格式錯誤或此欄空白</div>-->
<!--	</td>	
</tr>
-->	
<tr>
	<td>是否核准選課</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<!--<input id="need_validate_select" name="need_validate_select" type="text" value="{$ValueOfNeed_validate_select}">-->
		{html_radios name="need_validate_select" values=$need_validate_select_ids checked=$need_validate_select_id output=$need_validate_select_names separator=" "}
		</td>
	</tr>
	</table>
	<!--<div id="need_validate_selectFailed" class="{$need_validate_selectFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<tr>
	<td>教材作業是否公開</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<!--<input id="is_public" name="is_public" type="text" value="{$ValueOfIs_public}"> -->
		{html_radios name="is_public" values=$is_public_ids checked=$is_public_id output=$is_public_names separator=" "}
		</td>
	</tr>
	</table>
	<!--<div id="is_publicFailed" class="{$is_publicFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>
<tr>
	<td>課程科目時程單位</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<!--<input id="schedule_unit" name="schedule_unit" type="text" value="{$ValueOfSchedule_unit}">-->
		<select name="schedule_unit">
		{html_options values=$schedule_unit_ids selected=$schedule_unit_id output=$schedule_unit_names}
		</select>
		</td>
	</tr>
	</table>
	<!--<div id="schedule_unitFailed" class="{$schedule_unitFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>	
<!--
<tr>
	<td>課程科目簡介</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="introduction" name="introduction" type="text" value="{$ValueOfIntroduction}"></td>
	</tr>
	</table>
	<div id="introductionFailed" class="{$introductionFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>	
<tr>
	<td>課程科目宗旨</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="future" name="future" type="text" value="{$ValueOfFuture}"></td>
	</tr>
	</table>
	<div id="futureFailed" class="{$futureFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>		
<tr>
	<td>教學目標</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="goal" name="goal" type="text" value="{$ValueOfGoal}"></td>
	</tr>
	</table>
	<div id="goalFailed" class="{$goalFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>		
<tr>
	<td>教學要求</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="reguisition" name="reguisition" type="text" value="{$ValueOfReguisition}"></td>
	</tr>
	</table>
	<div id="reguisitionFailed" class="{$reguisitionFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>		
<tr>
	<td>適合學習對象(資格條件)</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="audience" name="audience" type="text" value="{$ValueOfAudience}"></td>
	</tr>
	</table>
	<div id="audienceFailed" class="{$audienceFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>學習評量方式</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="learning_test" name="learning_test" type="text" value="{$ValueOfLearning_test}"></td>
	</tr>
	</table>
	<div id="learning_testFailed" class="{$learning_testFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>先修課程</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="prepare_course" name="prepare_course" type="text" value="{$ValueOfPrepare_course}"></td>
	</tr>
	</table>
	<div id="prepare_courseFailed" class="{$prepare_courseFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>教科書書目</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="mster_book" name="mster_book" type="text" value="{$ValueOfMster_book}"></td>
	</tr>
	</table>
	<div id="mster_bookFailed" class="{$mster_bookFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>參考書目</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="ref_book" name="ref_book" type="text" value="{$ValueOfRef_book}"></td>
	</tr>
	</table>
	<div id="ref_bookFailed" class="{$ref_bookFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>參考網址</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="ref_url" name="ref_url" type="text" value="{$ValueOfRef_url}"></td>
	</tr>
	</table>
	<div id="ref_urlFailed" class="{$ref_urlFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>課程科目首頁目錄</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="directory" name="directory" type="text" value="{$ValueOfDirectory}"></td>
	</tr>
	</table>
	<div id="directoryFailed" class="{$directoryFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>課程科目首頁檔名</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="index_file" name="index_file" type="text" value="{$ValueOfIndex_file}"></td>
	</tr>
	</table>
	<div id="index_fileFailed" class="{$index_fileFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>
<tr>
	<td>課程科目內容製作權限</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input id="content_maker" name="content_maker" type="text" value="{$ValueOfContent_maker}"></td>
	</tr>
	</table>
	<div id="content_makerFailed" class="{$content_makerFailed}">格式錯誤或此欄空白</div>
	</td>	
</tr>-->
<tr>
	<td>備註</td>
	<td>
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<!--<input id="note" name="note" type="text" value="{$ValueOfNote}"> -->
		<textarea id="note" name="note">{$ValueOfNote}</textarea>
		</td>
	</tr>
	</table>
	<!--<div id="noteFailed" class="{$noteFailed}">格式錯誤或此欄空白</div>-->
	</td>	
</tr>				
</table>
<hr />
<!-- 按鈕--> 
<input type="reset" name="resetbutton" value="清除資料" />	
<input type="submit" name="submitbutton" value="確定送出" />
<input type="button" name="returnbutton" value="返回上一設定" onclick="history.back();" />
</form>	
</body>
</html>
