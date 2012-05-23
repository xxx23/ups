<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>課程列表</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"><!--
{literal}

{/literal}
--></script>
</head>

<body bgcolor="#FFFFFF" style="text-align:center;">
<h1>選課結果</h1>
<!------------------------------審核通過-課程列表----------------------------------->
<h2>審核通過</h2>
{if $passExamineCourses ne NULL}
<table class="datatable">
    <tr>
      <th>課程編號</th>
      <th>子類別</th>
      <th>課程名稱</th>
      <th>課程屬性</th>
      <th>認證時數</th>
      <th>課程時數</th>
      <th>選課時間</th>	
    </tr>
    {foreach from=$passExamineCourses item=course}
    <tr>
      <td>{$course.inner_course_cd}</td>
      <td>{$course.unit_name}</td>
      <td>{$course.begin_course_name}</td>
      
      {if $course.attribute == 0 }
      <td>自學課程</td>
      {else if $course.attribute == 1}
	  <td>教導課程</td>
	  {/if}
	  <td>{$course.certify}</td>
	  {if $course.attribute == 1}
	  <td>{$course.criteria_content_hour}</td> 
      {else}
      <td>{$course.criteria_content_hour}</td>
	  {/if}
{if $course.attribute == 0} <td> --- </td> {elseif $course.attribute ==1}<td>{$course.select_date}</td> {/if}
    </tr>
	{/foreach}
  </table>
  {else}
  無
  {/if}
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">

<!------------------------------審核中-課程列表----------------------------------->
<h2>審核中</h2>
{if $examineCourses ne NULL}
<table class="datatable">
    <tr>
      <th>課程編號</th>
      <th>子類別</th>
      <th>課程名稱</th>
      <th>課程屬性</th>
      <th>認證時數</th>
      <th>課程時數</th>
      <th>選課時間</th>	
    </tr>
    {foreach from=$examineCourses item=course}
    <tr>
      <td>{$course.inner_course_cd}</td>
      <td>{$course.unit_name}</td>
      <td>{$course.begin_course_name}</td>
      
      {if $course.attribute == 0 }
		<td>自學課程</td>
      {else if $course.attribute == 1}
		<td>教導課程</td>
	  {/if}
	  <td>{$course.certify}</td>
	  {if $course.attribute == 1 }
	  <td>{$course.criteria_content_hour}</td> 
      {else}
      <td>{$course.criteria_content_hour}</td>
	  {/if}
	{if $course.attribute == 0 } <td>---</td> {elseif $course.attribute == 1} <td>{$course.select_date}</td> {/if}
    </tr>
	{/foreach}
  </table>
  {else}
  無
  {/if}
<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">
<!-------------------------------審核未通過課程列表----------------------------------->
<h2>審核未通過</h2>
{if $failExamineCourses ne NULL}
<table class="datatable">
    <tr height="35">
      <th>課程編號</th>
      <th>子類別</th>
      <th>課程名稱</th>
      <th>課程屬性</th>
      <th>認證時數</th>
      <th>課程時數</th>
      <th>未通過原因</th>	
    </tr>
    {foreach from=$failExamineCourses item=course}
    <tr>
      <td>{$course.inner_course_cd}</td>
      <td>{$course.unit_name}</td>
      <td>{$course.begin_course_name}</td>
      
      {if $course.attribute == 0 }
      <td>自學課程</td>
      {else if $course.attribute == 1}
	  <td>教導課程</td>
	  {/if}
	  <td>{$course.certify}</td>
	  {if $course.attribute == 1}
	  <td>{$course.criteria_content_hour}</td> 
      {else}
      <td>{$course.criteria_content_hour}</td>
	  {/if}
      <td>{$course.fail_reason}</td>
    </tr>
	{/foreach}
  </table>
{else}
無
{/if}

</body>
</html>
