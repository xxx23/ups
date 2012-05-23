{config_load file='common.lang'}
{config_load file='personal_page/personal_page.lang'}
{config_load file='personal_page/textbook_general_download.lang'}


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <title>教材分享</title>
    
    <script type="text/javascript">
	{literal}
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
			myForm.action='textbook_general_download.php';	
			myForm.method='POST';
			if(myForm.page)myForm.page.value =1;				
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

<body >
<h1>教材分享</h1>

<!--  **************************搜尋條件設定************************ -->

<div class="describe"> 小提示:可輸入教材名稱進行搜尋。 </div>
<div class="searchbar" style="margin:auto auto">
<form id="searchForm" name="searchForm"  action="textbook_general_download.php?action=search" method="post">

    <div class="searchlist">
    
	    &nbsp;&nbsp; 教材名稱:
       <input type="text" name="content_name" size="16" value="{$content_name|escape}"/>
    </div>
	
    <div class="button001">
    <a href="javascript:searchFormSubmit(this);">教材搜尋</a>
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
	
</form>

</div><br/><hr width="90%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;"><br/>


<!--  **************************列表************************ -->
<table style="width:90%" class="datatable">
    <tr>
	   <th width="10%" style="text-align:center;">教材編號</th>
       <th style="text-align:center;">教材名稱</th>
       <th width="15%" style="text-align:center;">歸屬課程</th>
	   <th width="10%" style="text-align:center;">製作教師</th>
	   <!--<th width="10%" style="text-align:center;">下載格式</th>-->
	   <th width="10%" style="text-align:center;">授權型態</th>
	   <th width="20%" style="text-align:center;">下載</th>
	</tr>
  {foreach item=course from=$courseList} 
	<tr>
		<td style="text-align:center;">{$course.content_pad_cd}</th> 
		<td style="text-align:center;">{$course.content_name}</td>
		<td style="text-align:center;">{$course.course_name}</td>
		<td style="text-align:center;">{$course.teacher_name}</td>
		<!--<td style="text-align:center;">{$course.content_type}</td>-->
		<td style="text-align:center;">{$course.content_license}</td>
        <td style="text-align:center;">
        {if $course.content_type eq "rar"}
            <a href='download_reason.php?share=1&content_cd={$course.content_cd}&d_type=0' ><img src="{$webroot}images/down_tpye/0.gif"></a>&nbsp;
            <a href='download_reason.php?share=1&content_cd={$course.content_cd}&d_type=1' ><img src="{$webroot}images/down_tpye/1.gif"></a>&nbsp;
            <a href='download_reason.php?share=1&content_cd={$course.content_cd}&d_type=2' ><img src="{$webroot}images/down_tpye/2.gif"></a>&nbsp;
        {else}
            <a href='download_reason.php?share=1&content_cd={$course.content_cd}&d_type=3'><img src="{$webroot}images/308.gif">(scorm*.zip)</a>
        {/if} 
        </td>
	</tr>
  {/foreach} 
</table>	

</body>
</html>
