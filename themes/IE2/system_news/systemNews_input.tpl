<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
{* <!-- /* DATE:   2006/12/13 AUTHOR: 14_不太想玩 */ --> *}

<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新增公告</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='{$webroot}script/jquery-1.2.6.pack.js'></script> 
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/usable_proprities.js"></script>

{literal}
<script language="JavaScript">

	function addUploadFile(){
		var file_id_name = $('#uploadfileTD>div:last').attr('id') ;
		var file_index = parseInt(file_id_name.substr(file_id_name.indexOf('_')+1) );
		file_index = file_index + 1; 
		var inputFilehtml = '<div id="fileuploadinput_'+ file_index +'"><input type="file" name="file['+ file_index +']"></div>';
		$('#uploadfileTD').append(inputFilehtml) ;
		
	}
	
	function delete_attatchment(news_cd, file_cd ) { 
		if( confirm("您確定要刪除檔案?") ) {
			$.post(
				'ajax_deleteNewsFile.php',
				{news_cd:news_cd, file_cd:file_cd},
				function(data){//debuging 
					//alert(data);
				}, 
				"html"
			);
			
			$('#file_'+file_cd).remove();
		}
	}
	
	function formTypeAction()
	{
		document.FORM_type.submit();
		/*
		var startDate_td = document.all.startDate_td;
		var endDate_td = document.all.endDate_td;
		
		if(endDate_td.style.display == 'none')
		{
			startDate_td.setAttribute("colspan", 1);
			endDate_td.style.display = "block";
			window.alert(startDate_td.colspan);	//for test
			
		}
		else
		{
			startDate_td.setAttribute("colspan", 2);
			endDate_td.style.display = "none";
			window.alert("none");	//for test
		}
		*/
	}
	
	function checkContent()
	{	
		if(document.getElementById('subject').value == "")
		{
			document.getElementById('submitButton').disabled = true;
			//FORM_PostNews.submit.disabled = true;
		}
		else
		{
			document.getElementById('submitButton').disabled = false;
			//FORM_PostNews.submit.disabled = false;
		}
	}
	
	function disableSubmit()
	{
		FORM_PostNews.submit.disabled = true;
	}
</script>
{/literal}
</head>
<body>

<h1>
{if $action == "new"}新增公告{elseif $action =="modify"}修改公告{/if}
</h1>


<table class="datatable">
<tr>
	<th width="25%">公告類型</th>
	<td>
		<form name="FORM_type" method="POST" action="{$currentPage|escape}">
		<input type="hidden" name="behavior" value="{$behavior|escape}">
		<input type="hidden" name="incomingPage" value="{$incomingPage|escape}">
		<input type="hidden" name="finishPage" value="{$finishPage|escape}">
		{if $action == "modify"}	
		<input type="hidden" name="news_cd" value="{$news_cd}">
		{/if}
		<select name="formType" onChange="formTypeAction()">
			<option value="1" {if $formType == 1} selected {/if} >ㄧ般性</option>
			<!-- option value="2" {if $formType == 2} selected {/if} >時限性</option>
			<option value="3" {if $formType == 3} selected {/if} >週期性</option -->
		</select>
		</form>
	</td>
	</tr>
</table>
	
<form enctype="multipart/form-data"　name="FORM_PostNews" method="POST" action="{$actionPage|escape}">
<input type="hidden" name="behavior" value="{$behavior|escape}">
<input type="hidden" name="finishPage" value="{$finishPage|escape}">
<input type="hidden" name="formType" value="{$formType}">
{if $action == "modify"}<input type="hidden" name="news_cd" value="{$news_cd}">{/if}

<table class="datatable">

{* //等級不要
<tr>
	<th width="25%">重要等級</th>
	<td>
		<select name="important">
			<option value="2" {if $important == 2} selected {/if}>高</option>
			<option value="1" {if $important == 1} selected {/if}>中</option>
			<option value="0" {if $important == 0} selected {/if}>低</option>
		</select>
	</td>
</tr>
*}




{if $isShowCourse == 1}
<tr>
    <th>課程名稱</th><td>
        <select name="begin_course_cd">
		{section name=counter loop=$courseList}
		<option value="{$courseList[counter].begin_course_cd}" {if $begin_course_cd == $courseList[counter].begin_course_cd} selected {/if} >{$courseList[counter].courseName}</option>
		{/section}
		</select>
     </td>
</tr>
{/if}
	
<tr> 
    <th>起始日期</th>
	<td>
		<select name="startYear">
		{section name=counter loop=$yearScope}
			<option value="{$yearScope[counter]}" {if $startYear == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
		{/section}
		</select>年
          
		<select name="startMonth">
			<option value="01" {if $startMonth == '01'} selected {/if}>1</option>
			<option value="02" {if $startMonth == '02'} selected {/if}>2</option>
			<option value="03" {if $startMonth == '03'} selected {/if}>3</option>
			<option value="04" {if $startMonth == '04'} selected {/if}>4</option>
			<option value="05" {if $startMonth == '05'} selected {/if}>5</option>
			<option value="06" {if $startMonth == '06'} selected {/if}>6</option>
			<option value="07" {if $startMonth == '07'} selected {/if}>7</option>
			<option value="08" {if $startMonth == '08'} selected {/if}>8</option>
			<option value="09" {if $startMonth == '09'} selected {/if}>9</option>
			<option value="10" {if $startMonth == '10'} selected {/if}>10</option>
			<option value="11" {if $startMonth == '11'} selected {/if}>11</option>
			<option value="12" {if $startMonth == '12'} selected {/if}>12</option>
		</select>月
          
		<select name="startDay">
				<option value="01" {if $startDay == '01'} selected {/if}>1</option>
				<option value="02" {if $startDay == '02'} selected {/if}>2</option>
				<option value="03" {if $startDay == '03'} selected {/if}>3</option>
				<option value="04" {if $startDay == '04'} selected {/if}>4</option>
				<option value="05" {if $startDay == '05'} selected {/if}>5</option>
				<option value="06" {if $startDay == '06'} selected {/if}>6</option>
				<option value="07" {if $startDay == '07'} selected {/if}>7</option>
				<option value="08" {if $startDay == '08'} selected {/if}>8</option>
				<option value="09" {if $startDay == '09'} selected {/if}>9</option>
				<option value="10" {if $startDay == '10'} selected {/if}>10</option>
				<option value="11" {if $startDay == '11'} selected {/if}>11</option>
				<option value="12" {if $startDay == '12'} selected {/if}>12</option>
				<option value="13" {if $startDay == '13'} selected {/if}>13</option>
				<option value="14" {if $startDay == '14'} selected {/if}>14</option>
				<option value="15" {if $startDay == '15'} selected {/if}>15</option>
				<option value="16" {if $startDay == '16'} selected {/if}>16</option>
				<option value="17" {if $startDay == '17'} selected {/if}>17</option>
				<option value="18" {if $startDay == '18'} selected {/if}>18</option>
				<option value="19" {if $startDay == '19'} selected {/if}>19</option>
				<option value="20" {if $startDay == '20'} selected {/if}>20</option>
				<option value="21" {if $startDay == '21'} selected {/if}>21</option>
				<option value="22" {if $startDay == '22'} selected {/if}>22</option>
				<option value="23" {if $startDay == '23'} selected {/if}>23</option>
				<option value="24" {if $startDay == '24'} selected {/if}>24</option>
				<option value="25" {if $startDay == '25'} selected {/if}>25</option>
				<option value="26" {if $startDay == '26'} selected {/if}>26</option>
				<option value="27" {if $startDay == '27'} selected {/if}>27</option>
				<option value="28" {if $startDay == '28'} selected {/if}>28</option>
				<option value="29" {if $startDay == '29'} selected {/if}>29</option>
				<option value="30" {if $startDay == '30'} selected {/if}>30</option>
				<option value="31" {if $startDay == '31'} selected {/if}>31</option>
			</select>日
	</td>
</tr> 
 
{if $formType != 1}
<tr>
<th>結束日期</th>

<td>
	<select name="endYear">
	{section name=counter loop=$yearScope}
		<option value="{$yearScope[counter]}" {if $endYear == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
	{/section}
	</select>年
	
	<select name="endMonth">
		<option value="01" {if $endMonth == '01'} selected {/if}>1</option>
		<option value="02" {if $endMonth == '02'} selected {/if}>2</option>
		<option value="03" {if $endMonth == '03'} selected {/if}>3</option>
		<option value="04" {if $endMonth == '04'} selected {/if}>4</option>
		<option value="05" {if $endMonth == '05'} selected {/if}>5</option>
		<option value="06" {if $endMonth == '06'} selected {/if}>6</option>
		<option value="07" {if $endMonth == '07'} selected {/if}>7</option>
		<option value="08" {if $endMonth == '08'} selected {/if}>8</option>
		<option value="09" {if $endMonth == '09'} selected {/if}>9</option>
		<option value="10" {if $endMonth == '10'} selected {/if}>10</option>
		<option value="11" {if $endMonth == '11'} selected {/if}>11</option>
		<option value="12" {if $endMonth == '12'} selected {/if}>12</option>
	</select>月

	<select name="endDay">
		<option value="01" {if $endDay == '01'} selected {/if}>1</option>
		<option value="02" {if $endDay == '02'} selected {/if}>2</option>
		<option value="03" {if $endDay == '03'} selected {/if}>3</option>
		<option value="04" {if $endDay == '04'} selected {/if}>4</option>
		<option value="05" {if $endDay == '05'} selected {/if}>5</option>
		<option value="06" {if $endDay == '06'} selected {/if}>6</option>
		<option value="07" {if $endDay == '07'} selected {/if}>7</option>
		<option value="08" {if $endDay == '08'} selected {/if}>8</option>
		<option value="09" {if $endDay == '09'} selected {/if}>9</option>
		<option value="10" {if $endDay == '10'} selected {/if}>10</option>
		<option value="11" {if $endDay == '11'} selected {/if}>11</option>
		<option value="12" {if $endDay == '12'} selected {/if}>12</option>
		<option value="13" {if $endDay == '13'} selected {/if}>13</option>
		<option value="14" {if $endDay == '14'} selected {/if}>14</option>
		<option value="15" {if $endDay == '15'} selected {/if}>15</option>
		<option value="16" {if $endDay == '16'} selected {/if}>16</option>
		<option value="17" {if $endDay == '17'} selected {/if}>17</option>
		<option value="18" {if $endDay == '18'} selected {/if}>18</option>
		<option value="19" {if $endDay == '19'} selected {/if}>19</option>
		<option value="20" {if $endDay == '20'} selected {/if}>20</option>
		<option value="21" {if $endDay == '21'} selected {/if}>21</option>
		<option value="22" {if $endDay == '22'} selected {/if}>22</option>
		<option value="23" {if $endDay == '23'} selected {/if}>23</option>
		<option value="24" {if $endDay == '24'} selected {/if}>24</option>
		<option value="25" {if $endDay == '25'} selected {/if}>25</option>
		<option value="26" {if $endDay == '26'} selected {/if}>26</option>
		<option value="27" {if $endDay == '27'} selected {/if}>27</option>
		<option value="28" {if $endDay == '28'} selected {/if}>28</option>
		<option value="29" {if $endDay == '29'} selected {/if}>29</option>
		<option value="30" {if $endDay == '30'} selected {/if}>30</option>
		<option value="31" {if $endDay == '31'} selected {/if}>31</option>
	</select>日
</td>
</tr>
{/if}
	  
{if $formType == 3}
<tr>
    <th>週期設定</th>
    <td>
        <!-- select name="cycleYear">
          <option value="0000" {if $cycleYear == '0000'} selected {/if}>每年</option>
		{section name=counter loop=$yearScope}
		<option value="{$yearScope[counter]}" {if $cycleYear == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
		{/section}
		</select -->年
        &nbsp;
        <select name="cycleMonth">
          <option value="00" {if $cycleMonth == '00'} selected {/if}>每月</option>
          <option value="01" {if $cycleMonth == '01'} selected {/if}>1</option>
          <option value="02" {if $cycleMonth == '02'} selected {/if}>2</option>
          <option value="03" {if $cycleMonth == '03'} selected {/if}>3</option>
          <option value="04" {if $cycleMonth == '04'} selected {/if}>4</option>
          <option value="05" {if $cycleMonth == '05'} selected {/if}>5</option>
          <option value="06" {if $cycleMonth == '06'} selected {/if}>6</option>
          <option value="07" {if $cycleMonth == '07'} selected {/if}>7</option>
          <option value="08" {if $cycleMonth == '08'} selected {/if}>8</option>
          <option value="09" {if $cycleMonth == '09'} selected {/if}>9</option>
          <option value="10" {if $cycleMonth == '10'} selected {/if}>10</option>
          <option value="11" {if $cycleMonth == '11'} selected {/if}>11</option>
          <option value="12" {if $cycleMonth == '12'} selected {/if}>12</option>
          </select>月
        &nbsp;
        <select name="cycleDay">
          <option value="00" {if $cycleDay == '00'} selected {/if}>每日</option>
          <option value="01" {if $cycleDay == '01'} selected {/if}>1</option>
          <option value="02" {if $cycleDay == '02'} selected {/if}>2</option>
          <option value="03" {if $cycleDay == '03'} selected {/if}>3</option>
          <option value="04" {if $cycleDay == '04'} selected {/if}>4</option>
          <option value="05" {if $cycleDay == '05'} selected {/if}>5</option>
          <option value="06" {if $cycleDay == '06'} selected {/if}>6</option>
          <option value="07" {if $cycleDay == '07'} selected {/if}>7</option>
          <option value="08" {if $cycleDay == '08'} selected {/if}>8</option>
          <option value="09" {if $cycleDay == '09'} selected {/if}>9</option>
          <option value="10" {if $cycleDay == '10'} selected {/if}>10</option>
          <option value="11" {if $cycleDay == '11'} selected {/if}>11</option>
          <option value="12" {if $cycleDay == '12'} selected {/if}>12</option>
          <option value="13" {if $cycleDay == '13'} selected {/if}>13</option>
          <option value="14" {if $cycleDay == '14'} selected {/if}>14</option>
          <option value="15" {if $cycleDay == '15'} selected {/if}>15</option>
          <option value="16" {if $cycleDay == '16'} selected {/if}>16</option>
          <option value="17" {if $cycleDay == '17'} selected {/if}>17</option>
          <option value="18" {if $cycleDay == '18'} selected {/if}>18</option>
          <option value="19" {if $cycleDay == '19'} selected {/if}>19</option>
          <option value="20" {if $cycleDay == '20'} selected {/if}>20</option>
          <option value="21" {if $cycleDay == '21'} selected {/if}>21</option>
          <option value="22" {if $cycleDay == '22'} selected {/if}>22</option>
          <option value="23" {if $cycleDay == '23'} selected {/if}>23</option>
          <option value="24" {if $cycleDay == '24'} selected {/if}>24</option>
          <option value="25" {if $cycleDay == '25'} selected {/if}>25</option>
          <option value="26" {if $cycleDay == '26'} selected {/if}>26</option>
          <option value="27" {if $cycleDay == '27'} selected {/if}>27</option>
          <option value="28" {if $cycleDay == '28'} selected {/if}>28</option>
          <option value="29" {if $cycleDay == '29'} selected {/if}>29</option>
          <option value="30" {if $cycleDay == '30'} selected {/if}>30</option>
          <option value="31" {if $cycleDay == '31'} selected {/if}>31</option>
          </select>日
        &nbsp;&nbsp;&nbsp;&nbsp;
        <select name="cycleWeek">
          <option value="00" {if $cycleWeek == '00'} selected {/if}>無論星期</option>
          <option value="01" {if $cycleWeek == '01'} selected {/if}>每逢星期一</option>
          <option value="02" {if $cycleWeek == '02'} selected {/if}>每逢星期二</option>
          <option value="03" {if $cycleWeek == '03'} selected {/if}>每逢星期三</option>
          <option value="04" {if $cycleWeek == '04'} selected {/if}>每逢星期四</option>
          <option value="05" {if $cycleWeek == '05'} selected {/if}>每逢星期五</option>
          <option value="06" {if $cycleWeek == '06'} selected {/if}>每逢星期六</option>
          <option value="07" {if $cycleWeek == '07'} selected {/if}>每逢星期日</option>
          </select>
      </td>
  </tr>
{/if}

{* 只給系統管理者或教務管理者用 *}
{if $smarty.session.role_cd == 0 }
<tr>
    <th>公告分類</th>
	<td>{html_options name=news_type options=$news_course_types selected=$news_course_types_selected}</td>
</tr>
{/if}

<tr> 
    <th>公告標題</th>
	<td>
	{if $isAllowPost == 1}
		<input id="subject" name="subject" type="text" maxlength="50" onKeyUp="checkContent()" value="{$subject}">
	{else}
		<input id="subject" name="subject" type="text" maxlength="50" value="{$subject}">
	{/if}
	</td>
</tr>

<tr> 
    <th colspan="2">發佈新消息</th>
</tr>

<tr><td colspan="2"><textarea name="content" rows="10" cols="50">{$content}</textarea></td></tr>



{section name=file_index loop=$file_list}
	{if $file_list[file_index].if_url == 0}
	<tr id="file_{$file_list[file_index].file_cd}"><th>附加檔案</th>
	<td><div><a href="{$file_list[file_index].file_url}"  target="_blank">
	{$file_list[file_index].file_name}</a>
	&nbsp;&nbsp;&nbsp;<a onclick="delete_attatchment({$file_list[file_index].news_cd},{$file_list[file_index].file_cd})">(刪除)</a>
	<br />
	</td>
</tr>
	{/if}

	{if $file_list[file_index].if_url == 1}
		{assign var="url" value=$file_list[file_index].file_url }
	{/if}
{/section}
<tr>
	<th>上傳公告附加檔案 &nbsp;&nbsp;&nbsp;<a id="add_file_btn" onclick="addUploadFile()">(+)</a></th>
	<td id="uploadfileTD">
		<div id="fileuploadinput_0"><input type="file" name="file[0]"></div>
	</td>
</tr>		
<tr> 
	<th>連結網址 (http://)</th><td>  <input type="text" name="url" size="50" maxlength="100" value="{$url}">   (刪除請清空)</td>
</tr>

</table>




<div class="buttons">
	{if $action == "new"}
		<input type="submit" value="發佈" id="submitButton" name="submitButton" disabled class="btn">
	{elseif $action == "modify"}
		<input type="submit" value="修改" id="submitButton" name="submitButton" class="btn">
	{/if}
		<input type="reset"  value="清除" id="reset" name="reset" onClick="disableSubmit()" class="btn">
	{if $isBackOn == 1}
		<input type="button" id="back" name="back" value="回上一頁" onclick="location.href='{$incomingPage}?{$backArgument}'" class="btn">
	{/if}
</div>

</form>

</body>
</HTML>
