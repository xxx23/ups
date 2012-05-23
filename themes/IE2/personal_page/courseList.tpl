{*
role_cd 角色
0 管理者
1 教師
2 助教
3 學生
4 訪客
5 測試人員
6 教務管理者
*}
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>課程列表</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$webroot}script/jquery-1.3.2.min.js"></script> 
<script type="text/javascript"><!--
{literal}


function allow_apply_btn(btn) {
	$(btn).removeAttr("disabled");
	$(btn).css('color','') ;
	alert('您已指定教材，可進行開課審核。');
}
function deny_apply_btn(btn) {
	$(btn).attr('disabled','disabled') ; 
	$(btn).css('color', 'grey');
}

function setting_content(this_select, begin_course_cd) {

	var btn = $(this_select).parent().next().find(":input"); //透過<select>找到同<tr>的<button>
	var content_cd = $(this_select).children('option:selected').val();
	
	//尚未選擇教材，lock申請按鈕
	if( content_cd == -1) {
		deny_apply_btn( btn ) ;
		return ;
	}
	$.post('ajax_set_course_content.php' , 
		{begin_course_cd:begin_course_cd, content_cd:content_cd},  
		function (data) {
			if(data == 'ok')
				allow_apply_btn( btn );
			if(data == 'failed') {
				deny_apply_btn( btn ) ;
				alert('設定有誤');
			}
		}
	);

}

function verfiyBeginCourse(this_btn, begin_course_cd){
	var btn = $(this_btn);
	if(confirm("是否[申請審核課程]，課程審核過程您不能更動此課程之教材。")) {
		$.post( 'ajax_set_to_verify_course.php', 
			{begin_course_cd:begin_course_cd}, 
			function(data) {
				if(data=='ok') {
					alert("課程已經審核中，結果出來會通知您");
					$(btn).parent().prev().children('select').attr('disabled', 'disabled') ; //鎖住選取教材
                    $("input[name='upload_SCORM']").attr('disabled', 'disabled') ; //鎖住選取教材
					$(btn).parent().html('等待審核中...'); 
				}
			}
		)//end $.post
	}
}

function send_form(obj) {
	var myForm=document.forms['guest_course_list'];
	myForm.action = 'courseList.php';
	myForm.method = 'POST';
	myForm.submit();
	return;
}

function show_reason(begin_course_cd) {
	$.post("ajax_course_nopassed_reason.php" ,
		{begin_course_cd:begin_course_cd} , 
		function (data){alert(data) ; }
	)
}

function courseEndRemind() {
{/literal}
	{if $alert_msg != NULL}
		alert("{$alert_msg}");
	{/if}
{literal}
}
{/literal}
--></script>
</head>
<body bgcolor="#FFFFFF" style="text-align:center;" onload="courseEndRemind()">
{if $role_cd != 4}
{if $role_cd == 3}
<h1>我的課表</h1>
{else}
<h1>課程列表</h1>
{/if}
<table class="datatable">
<tr>
	{if $role_cd != 4}
	<th style="text-align:center;" width="9%">課程編號</th>
	{/if}
	<th style="text-align:center;" width="14%">子類別</th>
	<th style="text-align:center;">課程名稱</th>
	<th style="text-align:center;" width="10%">課程屬性</th>
	<th style="text-align:center;" width="10%">認證時數</th>
	<th style="text-align:center;" width="10%">課程時數</th>
    {if $role_cd  != 1}
    <th style="text-align:center;" width="10%">授課教師</th>
    {/if}
	{if $role_cd == 1}
    <th style="text-align:center;">課程期間</th>
    {else}
    <th style="text-align:center;">修課期間</th>
    {/if}
	{if $role_cd != 4 && $role_cd != 1} <!-- guest visit -->
	<th style="text-align:center;" width="5%">退選</th>
	{/if}
	{if $role_cd == '1' && 1 != 1}
	<th style="text-align:center;">是否開放旁聽</th>
	{/if}
</tr>
<!-------------------------------課程列表----------------------------------->
{section name=counter loop=$courseList}
<tr>
	{if $role_cd != 4}
	<td style="text-align:center;">
  		{$courseList[counter].inner_course_cd}
	</td>
	{/if}
	<td style="text-align:center;">
		{$courseList[counter].unit_name}
	</td>
	<td>
	<a href="courseList_intoClass.php?begin_course_cd={$courseList[counter].begin_course_cd}" target="_top">{$courseList[counter].begin_course_name}</a>
	</td>
	<td style="text-align:center;">
		{if $courseList[counter].attribute == 0 } 自學 {else} 教導 {/if}
	</td>
	<td style="text-align:center;">
		{$courseList[counter].certify}小時
	</td>
    <td style="text-align:center;">
        {$courseList[counter].criteria_content_hour}
    </td>
    {if $role_cd != 1}
	<td style="text-align:center;">
		{if $courseList[counter].attribute == 1}
		{section name=num loop=$courseList[counter].personal_id}
			<a href="{$webroot}Learner_Profile/queryTeacher.php?p={$courseList[counter].personal_id[num]}" target="_blank">{$courseList[counter].personal_name[num]}</a><br/>
		{/section}<center>
		{else}---{/if}</center>
	</td>
    {/if}
    
    <!-- 設定修課期間 -->
    {if $courseList[counter].attribute == 1}
	<td style="text-align:center;">
		{$courseList[counter].course_period}
	</td>
    {else}
    <td style="text-align:center;">
		{$courseList[counter].course_period}
    </td>
    {/if}

	{if $role_cd != 4 && $role_cd != 1}
	<td style="text-align:center;">
        {if $courseList[counter].pass == 1}課程已通過
		{else}
        {if $courseList[counter].is_allow_drop == 1}
		<a href="./courseList.php?action=drop&begin_course_cd={$courseList[counter].begin_course_cd}" onclick="return confirm('您確定要退選此課程？請注意，退選後該課程之記錄紀錄會被刪除，請小心！')"><img src="../images/257.gif" alt="退選"></a>
		{else $courseList[counter].is_allow_drop == 0 }
		選課時間已過
		{/if}{/if}
	</td>
	{/if}
	{if $role_cd == '1' && 1 != 1}
	<td style="text-align:center;">
		<a href='./courseList.php?action=select&course_cd={$courseList[counter].course_cd}&need_validate_select={$courseList[counter].need_validate_select}'>{$courseList[counter].select}</a>
	</td>
	{/if}
</tr>
{/section}
</table>
<br/>

    <h1>修課使用說明手冊</h1>
    <div align="left">
    <a target="_blank" href= "{$webroot}manual/20101110take_course.pdf">
    <img src= "{$webroot}images/download_take_course.gif"/>
    </a>
    </div>
    <div class="describe">為保障您的權益使時數正確紀錄，修課前請詳閱修課使用說明。
    </div>
    

<hr/>



{if $role_cd == '3'}
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">

<!--<input type="button" value="觀看所有課程" onClick="javascript:location.href='../Course_Admin/stu_show_all_course.php'" /> -->
{/if}
{if $role_cd == '1' && $num != 0}
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">

{***************** 待審課程 *********************}

<h2>待審核課程</h2>
<p class="intro">
操作說明：<br />
<span class="imp">待審核課程</span>：剛透過開課帳號新增之課程，開設通過審核之課程。<br />
按下申請審核後通過後才可使用課程。
</p>

<table class="datatable">
<tr>
	<th style="text-align:center">課程編號</th>
	<th style="text-align:center">開課單位</th>
	<th style="text-align:center">開課名稱</th>
	<th style="text-align:center">授課教師</th>
	<th style="text-align:center">指定審核教材</th>
	<th style="text-align:center">開課審核申請</th>
</tr>

{foreach from=$new_course_data item=course}
<tr>
	<td style="text-align:center;">{$course.inner_course_cd}</td>
	<td style="text-align:center;">{$course.unit_name}</td>
	<td style="text-align:center;">
		<a target="_blank" href="{$webroot}Apply_Course/view_course_detail.php?begin_course_cd={$course.begin_course_cd}">{$course.begin_course_name}</a>
	</td>
	<td style="text-align:center;">{$course.personal_name}</td>
	<!--<td><a href="{$course.code_path}?begin_course_cd={$course.begin_course_cd}">確認</a></td>-->
	<td style="text-align:center;">
		{if $course.begin_coursestate == 'p'}
			{assign var='if_lock_content' value='disabled="disabled"'}
		{else}
			{assign var='if_lock_content' value=''}
		{/if}
		
		<select onchange="setting_content(this, {$course.begin_course_cd});" {$if_lock_content}>
		<option value='-1'>請指定審核教材</option>
			{foreach from=$contents item=row} 
				<option value="{$row.content_cd}" {if $row.content_cd==$course.content_cd}selected{/if}>{$row.content_name} </option>
			{/foreach}
		</select>
        <br/>
        <input type=button name="upload_SCORM" onClick="location.href='{$webroot}Teaching_Material/textbook_scorm.php?begin_course_cd={$course.begin_course_cd}'" {$if_lock_content} value='上傳SCORM教材'>
	</td>
	<td style="text-align:center;">
		{if $course.begin_coursestate == '0'}{* 未通過審核，要指定完教材才能按審核鈕 *}
			{if $course.content_cd == -1 || empty($course.content_cd)} 
				{assign var='if_can_apply' value='disabled="disabled" style="color:grey"'}
			{else}
				{assign var='if_can_apply' value=''}
			{/if}
			<input class="btn" type="button" name="checkButton" value="申請審核" {$if_can_apply} onClick="verfiyBeginCourse(this, {$course.begin_course_cd});">
		{/if}
		{if $course.begin_coursestate == 'n'}
			<sapn style="cursor:hand" title="觀看審核未通過原因" onclick="show_reason({$course.begin_course_cd})">審核未通過</a> <input class="btn" type="button" name="checkButton" value="重新提出審核" onClick="verfiyBeginCourse(this, {$course.begin_course_cd});">
		{/if}
		{if $course.begin_coursestate == 'p'}
			等待審核中...
		{/if}
	</td>
</tr>	

{foreachelse}

<tr>
	<td colspan="6" style="text-align:center;">目前沒有課程需要確認</td>
</tr>

{/foreach}
</table>

{***************** end 待審課程 *********************}





{/if}
{if $role_cd != 4}
<div class="button001"><a href="{$WEBROOT}Weboffice/my_reservation_list.php">預約會議清單</a></div><br/>
{/if}
<br/>


{if $role_cd == '1'}
<h1>我的教材</h1>
<p align="left"><span>教師個人教材管理頁面，包含教材之新增、修改、刪除、進入編輯、匯出等功能。</span>
<div class="button001" style="float:left;"><a href="{$WEBROOT}Teaching_Material/textbook_manage.php?person=1">按此進入</a></div><br/>

</p>
<br/>

<h1>我的課程大綱</h1>
<p align="left"><span>教師課程管理頁面，包含課程大綱及選課須知之新增、修改、刪除、進入編輯等功能。</span>
</span><div class="button001" style="float:left;"><a href="{$WEBROOT}Course/course_manage_personal.php">按此進入</a></div>
</p>
{/if}
{elseif $role_cd == 4}
<H1>課程總覽</H1>
<div class="describe"> 小提示：觀看全部課程，或選擇課程性質看該性質所有課程。<br>
也可進入&quot;課程搜尋&quot;，搜尋您想找的課程。</div>
<form id="guest_course_list" name="guest_course_list" method="post" action="courseList.php">
<div class="searchbar" style="margin:auto auto" ><span>
<form id="guest_course_list"  name="guest_course_list" method="post" action="courseList.php">
      <input type="hidden" value="{$or_type}" name="or_type">
      </input>
      <input type="hidden" value="{$or_sub_type}" name="or_sub_type">
      </input>
      <div class="searchlist"><select id="coursetype" name="coursetype" onChange="send_form(this);">
	    <option value="0" {if $coursetype eq 0} selected {/if}>(全部課程)</option>
	    <option value="1" {if $coursetype eq 1} selected {/if}>依身份類別</option>
	    <option value="2" {if $coursetype eq 2} selected {/if}>依課程性質</option>
      </select>
  　{if $coursetype != 0}
  <select id="sub_coursetype" name="sub_coursetype" onChange="send_form(this);">
    
	{section name=counter loop=$all}
		
    <option value="{$all[counter].number}" {if $sub_coursetype eq $all[counter].number}selected{/if}>{$all[counter].type_name}</option>
    
	{/section}

  </select>
  {/if}</div>
  一共{$all_course_number}筆
  <select name="page_number" length="30" onChange="send_form(this);">
	{section name=counter loop=$total_page_index}
		<option value="{$total_page_index[counter].count}" {if $page_number eq $total_page_index[counter].count}selected{/if}>{$total_page_index[counter].index}</option>
    {/section}
  </select>
  / {$total_page_number}
  {if $before_current_page_yes == 1}
  <a href="courseList.php?coursetype={$coursetype}&sub_coursetype={$sub_coursetype}&p={$awaypage}&or_type={$coursetype}&or_sub_type={$sub_coursetype}">上一頁</a>
  {/if}
  {if $after_current_page_yes == 1}
  <a href="courseList.php?coursetype={$coursetype}&sub_coursetype={$sub_coursetype}&p={$nextpage}&or_type={$coursetype}&or_sub_type={$sub_coursetype}">下一頁</a>
  {/if}
  <div class="button001"><a href="./courseSearch.php">課程搜尋</a></div>
</form></div>
<br/>
<hr width="90%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">
<br/>
<table class="datatable" style="width:90%">
<tr>
    {if $coursetype != 0}
    <th width="12%" style="text-align:center;">{if $coursetype eq 1}子類別{elseif $coursetype eq 2}課程性質{/if}</th>
    {/if}
	<th style="text-align:center;">課程名稱</th>
	<th width="12%" style="text-align:center;">課程屬性</th>
	<th width="12%" style="text-align:center;">認證時數</th>
	<th width="12%" style="text-align:center;">授課教師</th>
	<th width="12%" style="text-align:center;">修課期間</th>
</tr>
{section name=counter loop=$all_course}
<tr>
        {if $coursetype != 0}
        <td style="text-align:center;">{$all_course[counter].begin_unit_name}</td>
        {/if}
        <td><a href="courseList_intoClass.php?begin_course_cd={$all_course[counter].begin_course_cd}" target="_top">{$all_course[counter].begin_course_name}</a></td>
        <td style="text-align:center;">{if $all_course[counter].attribute == 0}自學{elseif $all_course[counter].attribute == 1}教導{/if}</td>
        <td style="text-align:center;">{$all_course[counter].certify}</td>
        <td style="text-align:center;">{if $all_course[counter].attribute == 0} --- {elseif $all_course[counter].attribute == 1}{/if}</td>
        <td style="text-align:center;">---</td>
</tr>
{/section}
</table>
{/if}
</body>
</html>
