<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>已申請通過課程</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
<link href="css/course.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>已申請通過課程</h1>

<form action="delete_course.php" method="POST" name="delete_course">
  <table class="datatable" style="width:95%">
    <tr>
      <th width="8%"> <div align="center">課程編號</div></th>
      <th width="12%"> <div align="center">課程性質</div></th>
      <th width="30%"> <div align="center">課開課名稱</th>
      <th width="9%"> <div align="center">授課教師</div></th>
{*<!-- th width="5%"> <div align="center">證書</div></th --> *}
      <th width="9%"> <div align="center">詳細資訊</div></th>

    </tr>
    {foreach from=$course_data item=course}
    <tr>
      <td>{$course.inner_course_cd}</td>
      <td><div align="center">{$course.unit_name}</div></td>
      <td>{$course.begin_course_name|escape}</td>
      <td><div align="center">{$course.personal_name}</div></td>
{*<td> <div align="center"><a href="../Certificate/certificateManagement.php?begin_course_cd={$course.begin_course_cd}&incomingPage=../Course_Admin/show_all_begin_course.php" >設定</a></div></td> *}
      <td><div align="center"><a href="./view_course_detail.php?begin_course_cd={$course.begin_course_cd}" ><img src="{$tpl_path}/images/apply_course/30.gif" alt="修改" border="0px"></a>&nbsp;</div></td>


    </tr>
	{/foreach}
  </table>

</form>



</body>
</html>
