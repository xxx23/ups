{config_load file='common.lang'}
{config_load file='personal_page/personal_page.lang'}
{config_load file='other/relatedOutcomes.lang'}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <title>{#course_search#}</title>
    
    <script type="text/javascript">
	{literal}
		function alertCourse(type)
		{
			switch(type)
			{
            case 0://選課成功
                {/literal}
                alert("{#select_course_success#}");
                {literal}
                break;
			case 1://課程已選待審核
                {/literal}
				alert("{#course_already_selected#}");
                {literal}
				break;
			case 2://課程已通過
                {/literal}
				alert("{#course_already_pass#}");
                {literal}
				break;
			case 3://課程已選 修課中
                {/literal}
				alert("{#course_exist_in_my_list#}");
                {literal}
                break;
            case 4://課程不在選課時間內 (教導)
                {/literal}
			    alert("{#course_out_of_date#}");
                {literal}
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
			myForm.action='relatedOutcomes.php';	
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
<h1>{#course_overview#}</h1>
<div class="searchbar" style="margin:auto auto">
<form id="searchForm" name="searchForm"  action="relatedOutcomes.php?action=search" method="post">
	
	<!--搜尋依據-->
	<div class="searchlist">
    <!--搜尋子項目-->
    {#plan_type#}:
	<select name="sub_type" onChange="searchFormSubmit(this);">
     {html_options values=$sub_type_ids output=$sub_type_names  selected=$sub_type_sel}
    </select>
    </div>
    <div class="searchlist">
        <!--課程年度-->
	    {#course_year#}:
        <input type="text" name="course_year" size="16" value="{$course_year|escape}"/>
    </div>

    <div class="searchlist">
	    {#course_name#}:
        <input type="text" name="course_name" size="16" value="{$course_name|escape}"/>
    </div>

    <div class="button001">
        <a href="javascript:searchFormSubmit(this);">{#course_search#}</a>
	</div>
    <div id="pageControl" >
	{if $page_cnt ne 0}
	<span>{#the#}
	 <select name="page" onChange="pageContorlSubmin(this)" >
     {html_options values=$page_ids output=$page_names  selected=$page_sel}
     </select>/{$page_cnt}{#page#}
	 </span>
	 <a href="javascript:changePage({$previous_page})">{#page_up#}</a>
	 <a href="javascript:changePage({$next_page})"  >{#page_down#}</a>
	{/if}
	</div>
	
</form></div><br/><hr width="90%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;"><br/>
{if $action eq 'search'}
<table style="width:90%" class="datatable">
    <tr>
       <th width="16%" style="text-align:center;">{if $search_type_sel eq 0}{#subcategory#}{else}{#course_nature#} {/if}</th>
       <th width="16%" style="text-align:center;">{#course_year#}</th>
       <th style="text-align:center;">{#course_name#}</th>
       <th style="width: 10%; text-align:center;">{#enter#}</th>
	   
    </tr>
    {foreach item=course from=$courseList}
    <tr>
    <td style="text-align:center;">{$course.unit}</td>
    <td style="text-align:center;">{$course.course_year}</td>
    <td style="text-align:center;">
        {$course.begin_course_name}
    <td style="text-align:center;">
        {if $course.guest_allowed eq 1}  
        <a target="_top" href="../Personal_Page/courseList_intoClass.php?guest=1&begin_course_cd={$course.begin_course_cd}">{#enter#}</a>
        {else}
        <a href="javascript:alert('{#course_not_open#}');">{#not_permit#}</a>
        {/if}
    </td>
    
    </tr>
	{/foreach}
</table>
{/if}
</body>
</html>
