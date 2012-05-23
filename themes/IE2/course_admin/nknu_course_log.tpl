<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html > 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <link href="../css/font_style.css" rel="stylesheet" type="text/css" /> 
    <link href="../css/table.css" rel="stylesheet" type="text/css" /> 
    <link href="../css/form.css" rel="stylesheet" type="text/css" /> 
    <link href="../css/tabs.css" rel="stylesheet" type="text/css" /> 
    <link href="../css/content.css" rel="stylesheet" type="text/css" /> 
<link type="text/css" href="../css/jquery/jquery-ui-1.7.2.custom_1.css" rel="stylesheet" /> 
<script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script> 
<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script> 
<title>認證時數傳送管理</title>
<script type="text/javascript">
{literal}
    $(document).ready(function(){

        $('.control').bind('click',function(){
            if($(this).next().css('display')=='none')
                $(this).next().show();
            else
                $(this).next().hide();
            });
        $('.control').bind('mouseenter',function(){
                $(this).css('background-color','aliceblue');
            });
        $('.control').bind('mouseleave',function(){
            $(this).css('background-color','#f4f4f4');
            });
		$('.control').bind('click',function(){
		    resizeParentIframe();
         });
		$('#date_start').datepicker({dateFormat:'yy-mm-dd',
                                     monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                     monthNamesShort:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                     changeMonth:true,
                                     changeYear:true
        });

        $('#date_end').datepicker({dateFormat:'yy-mm-dd',
                                   monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                   monthNamesShort:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                   changeMonth:true,
                                   changeYear:true
        });

		 setTimeout(function(){resizeParentIframe();},200);
    });
	function resizeParentIframe()
	{
	//	alert("resizing..."+$(document.body).height());
        var theFrame = $('#course_log', window.parent.document.body);
		if($(document.body).height()!=0)
            theFrame.height($(document.body).height());
        else setTimeout(function(){resizeParentIframe();},200);
	}
    function changePage(page)
    {	
        var myForm=document.forms['timeSearch'];
        var num = document.getElementsByName('page')[0].value=page;
        myForm.submit();
    }
    function clearSubmit()
    {
        document.getElementsByName('page')[0].value=1;
        var myForm=document.forms['timeSearch'];
        myForm.submit();
    }
{/literal}
</script>
</head>
<body>
<div class="searchbar" style="width:80%;margin:auto auto;">
    <form id="timeSearch" name="timeSearch" action="nknu_course_log.php" method="POST">
        <div class="searchlist" style="margin:auto auto">
            <form id="timeSearch" name="timeSearch" action="nknu_course_log.php" method="POST">
            依時間搜尋:
            自<input type="text" id="date_start" size=7 name="date_start" value="{$date_start|escape}">
            至<input type="text" id="date_end" size=7 name="date_end" value="{$date_end|escape}">
            <input type="button" onclick ="clearSubmit();" name="search" value="搜尋">
        </div>
        <div align"center">
            <a href="javascript:changePage({$previousPage})">上一頁</a>
            <a href="javascript:changePage({$nextPage})">下一頁</a>
            第
            <select name="page" onchange="changePage(this.value)">
            {html_options   output=$page_names values=$page_ids selected=$page_sel }
            </select>
            頁<p>
        </div>
    </form>
	<div class="describe">點選各筆資料可看記錄內容</div>
	
    <table class="datatable" style="width:80%">
	<tr>
		<th>時間</th>
		<th>課程</th>
        <th>課程編號</th>
        <th>狀態</th>
	</tr>
	<!-- TRANSFER LOG DESPLAY -->
    {if $course_logs ne null}
	{foreach from=$course_logs item=log}
		<tr class="control">
		<td>{$log.log_time|escape}</td>
		<td>{$log.course_name|escape}</td>
		<td>{$log.begin_course_cd|escape}</td>
		<td>{$log.log_type|escape}</td>
		</tr>
		<tr class="content" style="background-color:white;display:none;">
		<td colspan="4">
            
        {$log.log_info}
            
        </td>
		</tr>
	{/foreach}
    {else}
        <td colspan="4"><center>無資料</center></td>
    {/if}
	</table>
</div>
</body>
</html>
