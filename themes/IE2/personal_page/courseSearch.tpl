<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <title>課程搜尋</title>
    
    <script type="text/javascript">
	{literal}
		function alertCourse(type)
		{
			switch(type)
			{
            case 0://選課成功
                alert("選課成功，請至我的課表觀看教材");
                break;
			case 1://課程已選待審核
				alert("此課程已選-待審核");
				break;
			case 2://課程已通過
				alert("此課程已通過");
				break;
			case 3://課程已選 修課中
				alert("此課程已存在我的課表中");
                break;
            case 4://課程不在選課時間內 (教導)
			    alert("此課程不在選課時間內");
            default: break;
			}
		}
		function pageContorlSubmin(form)
		{
			var myForm=document.forms['searchForm'];   
			myForm.submit();   
			return;
		}
		function searchFormSubmit(form)	
		{
			var myForm=document.forms['searchForm'];
			if(myForm.page)myForm.page.value =1;			
			myForm.submit();   
			return;
		}
		function checkSelect(obj){	
			var   myForm=document.forms['searchForm']; 
			myForm.action='courseSearch.php';	
			myForm.method='POST';
			if(myForm.page)myForm.page.value =1;
			if(myForm.sub_type)myForm.sub_type.value =-1;			
			if(myForm.attribute)myForm.attribute.value =-1;			
			myForm.submit();   
			return;
		}
		function changePage(page)
		{
			var myForm=document.forms['searchForm']; 
			if(myForm.page)myForm.page.value =page;
			myForm.submit(); 
			
			return;
		}
	    function new_window( url )
        {
            window.open(url,"windows","menubar=0,width=510,location=0,scrollbars=1,resizable=1");
        }
{/literal}
    </script>
</head>

<body {if $take_message eq 1}onload="alertCourse(0);"{/if} >
<h1>課程總覽</h1>
<div class="describe"> 小提示：觀看全部課程，或選擇課程性質看該性質所有課程，也可輸入課程名稱進行搜尋。</div>
<div class="searchbar" style="margin:auto auto">
<form id="searchForm" name="searchForm"  action="courseSearch.php?action=search" method="post">
	
	<!--搜尋依據-->
	<div class="searchlist">課程狀態:
    <select name="search_type" onChange="checkSelect(this);">
    {html_options values=$search_type_ids output=$search_type_names  selected=$search_type_sel}
    </select>{if $search_type_sel ne -1}    
    <!--搜尋子項目-->
    子項目:
	<select name="sub_type" onChange="searchFormSubmit(this);">
     {html_options values=$sub_type_ids output=$sub_type_names  selected=$sub_type_sel}
    </select>
	{/if}
    </div>
    <div class="searchlist">
        <!--課程屬性-->
	    課程屬性:
        <select name="attribute" onChange="searchFormSubmit(this);" >
        {html_options values=$attribute_ids output=$attribute_names  selected=$attribute_sel}
        </select>
    
	    課程名稱:
        <input type="text" name="course_name" size="16" value="{$course_name|escape}"/>
    </div>
    <div class="button001">
    <a href="javascript:searchFormSubmit(this);">課程搜尋</a>
	</div>
    <div id="pageControl" >
	{if $page_cnt ne 0}
	<span>第
	 <select name="page" onChange="pageContorlSubmin(this)" >
     {html_options values=$page_ids output=$page_names  selected=$page_sel}
     </select>/{$page_cnt}頁
	 </span>
	 <a href="javascript:changePage({$previous_page})">上一頁</a>
	 <a href="javascript:changePage({$next_page})"  >下一頁</a>
	{/if}
	</div>
	
</form></div><br/><hr width="90%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;"><br/>
{if $action eq 'search'}
<table style="width:90%" class="datatable">
    <tr>
       {if $role_cd < 4} 
	   <th width="10%" style="text-align:center;">課程編號</th>
	   {/if}
       <th width="16%" style="text-align:center;">{if $search_type_sel eq 0}子類別{else}課程性質 {/if}</th>
       <th style="text-align:center;">課程名稱</th>
       <th width="10%" style="text-align:center;">課程屬性</th>
       <th width="10%" style="text-align:center;">認證時數</th>
       <th style="text-align:center;">課程時數</th>
       <th width="10%" style="text-align:center;">授課教師</th>
	   
       {if $role_cd eq 3}<th width="10%" style="text-align:center;">選課需知</th>{/if}
       {if $role_cd eq 3}<th width="10%" style="text-align:center;">選課時間</th>{/if}
	   {if $role_cd >= 4}<th width="10%" style="text-align:center;">修課期間</th>{/if}
       {if $role_cd eq 3} <th width="5%" style="text-align:center;">選課</th>{/if}
    </tr>
    {foreach item=course from=$courseList}
    <tr>
    {if $role_cd < 4}
    <td style="text-align:center;">{$course.inner_course_cd}</th>
    {/if}
    <td style="text-align:center;">{$course.unit}</td>
    <td style="text-align:left;">
        {if $role_cd eq 4}
            {if $course.guest_allowed eq 1}  
            <a target="_top" href="courseList_intoClass.php?begin_course_cd={$course.begin_course_cd}">{$course.begin_course_name}</a>
            {else}
            <a href="javascript:alert('本課程暫不開放試閱，如欲觀看此課程內容，請加入本平台之學員，即可閱讀此課程教材內容!');">{$course.begin_course_name}</a>
            {/if}
        {else}
        {$course.begin_course_name}
        {/if}
    </td>
    <td style="text-align:center;">{if $course.attribute eq 0}自學{elseif $course.attribute eq 1}教導{/if}</td>
    <td style="text-align:center;">{$course.certify}</td>
    <td style="text-align:center;">{$course.criteria_content_hour}</td>
    <td style="text-align:center;">{$course.teacher_name}</td>
    
    {if $role_cd eq 3}
        <td style="text-align:center">
        {if $course.course_cd != NULL}    
        <a href="javascript:new_window('../Course/std_course_intro2.php?begin_course_cd={$course.begin_course_cd}');">選課<br/>須知</a>
        {else}
        <a href="javascript:alert('本課程無相關選課資訊');">選課<br/>須知</a>
        {/if}
        </td>
    {/if}
    {if $role_cd eq 3}<td style="text-align:center;">{$course.select_time}</td>{/if}
    {if $role_cd >= 4}<td style="text-align:center;">{$course.listen_time}</td>{/if}
        {if $role_cd eq 3}
			<td style="text-align:center;">
				{if $course.checkSelect eq 0 }
				<a href ="courseSearch.php?action=take&begin_course_cd={$course.begin_course_cd}">選課</a>
				{else}
				<a href ="javascript:alertCourse({$course.checkSelect})">選課</a>
				{/if}
			</td>
		{/if}
    </tr>
	{/foreach}
</table>
{/if}
</body>
</html>
