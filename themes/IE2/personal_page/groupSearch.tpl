<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- author: carlcarl -->
<html>
<head>
    <title>社群專區</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    {literal}
    //兩個都是處理分頁的function
		function changePage(page)
		{
			var myForm=document.forms['searchForm']; 
			if(myForm.page)myForm.page.value =page;
			myForm.submit(); 
			
			return;
		}
		function pageContorlSubmin(form)
		{
			var myForm=document.forms['searchForm'];   
			myForm.submit();   
			return;
		}
        function showReason(id)
        {
            if(document.getElementById(id).style.display == "")
            {
                document.getElementById(id).style.display = "none";
            }
            else
            {
                document.getElementById(id).style.display = "";
            }
        }

    {/literal}
    </script>
</head>
<body>
    <h1>課程搜尋結果</h1>
    <form action="groupSearch.php" method="post">
        <span> 課程搜尋:　<input type="text" name="keyword" maxlength=20 /> <input type="submit" value="搜尋" /> </span>
    </form>
    <form id="searchForm" name="searchForm"  action="group.php" method="post">
        <table class="datatable" style="TABLE-LAYOUT:fixed">
            <tr>
                <th width="220">課程名稱</th>
                <th width="280">加入訊息(討論區主旨)</th>
                <th>討論區數量</th>
                <th width="120">申請</th>
            </tr>
            {foreach from=$all_course item=course}
            <tr>
                <td>{$course.begin_course_name}</td>
                <td></td>
                <td>{$course.discuss_num}</td>
                <td>
                    {if $course.state == 1}
                    <input type="button" value="申請" onclick="window.location.href='inputReason.php?course={$course.begin_course_cd}&name={$course.begin_course_name}'" />
                    {elseif $course.state == 2}
                    申請中
                    {else}
                    不通過 <input type="button" value="觀看失敗理由" onclick="javascript:showReason('not_pass{$course.begin_course_cd}');" />
                    <textarea id="not_pass{$course.begin_course_cd}" rows="5" cols="11" readonly="readonly" style="display:none;">{$course.not_pass_reason}</textarea>
                    <input type="button" value="再次申請" onclick="window.location.href='inputReason.php?course={$course.begin_course_cd}&name={$course.begin_course_name}'" />

                    {/if}
                </td>
            </tr>
            {/foreach}
        </table>

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
    <br />
    <a href="group.php">回社群專區</a>
</body>
</html>

