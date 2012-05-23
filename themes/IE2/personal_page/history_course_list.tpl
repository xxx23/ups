<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>學習紀錄</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="../css/jquery/jquery-ui-1.7.2.custom_1.css" rel="stylesheet" />
<script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
        

<script type="text/javascript">
{literal}
    $(document).ready(function(){
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
    });
    function alertCriteriaSelf(score,time){
        alert("通過條件:\n-課程測驗:   "+score+"  分(含)以上\n-閱讀時數:   "+time+"  (含)以上");
    }
    
    function alertCriteriaTeach(score){
        alert("通過條件:\n-課程成績:   "+score+"  分(含)以上\n");
    }

{/literal}
</script>

</head>
<body>

<!----------------------------選擇顯示方式-------------------------------->
<h1>學習紀錄</h1>
<form id="showOptForm" name="showOptForm" action="history_course_list.php" method="POST">

<table width="730" align="right" cellpadding="0" cellspacing="0" style="margin:5px;padding:2px;font-size:12px; background-color: #eee; border: 1px dotted #666;">
  <tr>
    <td>
        <b>期間</b>: 從
        <input type="text" id ="date_start" size="7" name="date_start" value="{$date_start}"/>
       到 
        <input type="text" id="date_end" size ="7" name="date_end" value="{$date_end}"/>
        
    </td>
    <td>
        <label>
        <b>課程屬性：</b> 
        <select id="showType" name="showType" >
        {html_options values=$showType_ids output=$showType_names selected=$showType_sel}
        </select>
        </label>
    </td>
    <td>
        <b>通過狀態:</b>
        <select id="isPass" name="isPass" >
        {html_options values=$isPass_ids output=$isPass_names selected=$isPass_sel}
        </select>
    </td>
    <td>
        <label>
        <b>課程名稱:</b>
        <input type="text" id="course_search_name" size="10" name="course_search_name" value = "{$course_search_name|escape}" />
        </label>
    </td>
    <td>
        <input type="submit" class="button" name="search" value="搜尋" />
    </td>
  </tr>
</table>
</form>
<p>
&nbsp; 
</p>
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;"/>
<div class="describe">請注意! 當課程滿足通過條件後，系統會於每日自動判斷及傳送資料至高師大，通常需1~2個工作天，請耐心等待。 </div>   
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;"/>
{if $selfFlag == '1'}
<!----------------------------自學式課程-------------------------------->
    <h2>自學式課程</h2>
	{if $selfCourseList}
	<table class="datatable" style="margin:auto auto" align="center">
    <tr>
      <th>課程編號</th>
      <th>課程名稱</th>
      <th>閱讀時數</th>
	  <th>課程測驗</th>
	  <th>通過條件</th>
	  <th>通過/未通過</th>
	  <th>認證時數</th>
	  {if $sendTimeFlag == '1'}
	  <th>認證傳送<br/>高師大時間</th>
	  {/if}
	  </tr>
	{foreach from=$selfCourseList item=course}
	<tr>
      <td valign= "center">{$course.inner_course_cd}</td>
	  <td>
	  {if $course.pass==0}
		{$course.begin_course_name}
	  {else}
		<a href="courseList_intoClass.php?begin_course_cd={$course.begin_course_cd}" target="_top">{$course.begin_course_name}</a>
	  {/if}
	  </td>
	  <td>{$course.readTime}</td>
      <td>{$course.score}</td>
	  <td><a href="javascript:alertCriteriaSelf({$course.criteria_total},'{$course.criteria_content_hour}')">檢視</a></td>
	  <td>
        {$course.ifpass}
        {if $course.ifpass == '未通過'}
        /<a href="history_course_list.php?action=drop&begin_course_cd={$course.begin_course_cd}">退選</a>
        {/if}
      </td>
	  {if $course.pass == 1}
	  <td>{$course.certify}</td>
	  {else}
	  <td>---</td>
	  {/if}
	  {if $sendTimeFlag == '1'}
	  <td>{$course.sendTime}</td>
	  {/if}
    </tr>
	{/foreach}
	<tr>
		<td style="text-align: center; font-weight: bold;" colspan="9">總通過認證時數：{$selfTotalCertify}</td>
	  </tr>
  </table>
	<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">
  {else}
  
      <img src="../images/no.gif" alt="抱歉,您目前仍無紀錄">{/if}
{/if}
	

{if $teachFlag == '1'}
<!---------------------教師導引式課程課程-------------------------------->
	<h2>教導式課程</h2>
	{if $teachCourseList }
	<table class="datatable">
    <tr>
      <th>課程編號</th>
      <th>課程名稱</th>
      <th>閱讀時數</th>
	  <th>課程成績</th>
	  <th>通過條件</th> 
	  <th>通過/未通過</th>
	  <th>認證時數</th>
	  {if $sendTimeFlag == '1'}
	  <th> 認證傳送<br/>高師大時間</th>
	  {/if}
	  </tr>
	{foreach from=$teachCourseList item=course}
    <tr>
      <td>{$course.inner_course_cd}</td>
	  <td>{$course.begin_course_name}</td>
	  <td>{$course.readTime}</td>
	  <td>{$course.score}</td>
	  <td><a href="javascript:alertCriteriaTeach({$course.criteria_total})">檢視</a></td>
	  <td>
        {$course.ifpass}
        {if $course.ifpass == '未通過'}
        /<a href="history_course_list.php?action=drop&begin_course_cd={$course.begin_course_cd}">退選</a>
        {/if}
      </td>
	  <td>{$course.certify}</td>
	  {if $sendTimeFlag =='1'}
	  <td>{$course.sendTime}</td>
	  {/if}
	</tr>
	{/foreach}
	<tr>
		<td style="text-align: center; font-weight: bold;" colspan="8">總通過認證時數：{$teachTotalCertify}</td>
	  </tr>
  </table>
    {else}
      <img src="../images/no.gif" alt="抱歉,您目前仍無紀錄">{/if}
{/if}

</body></html>
