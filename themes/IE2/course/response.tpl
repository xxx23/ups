<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{$tpl_path}/css/column_set.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
</head>

<body style="background-color:E6E6E6; padding-bottom:10px;">

<center>
<table width="90%" class="functable">
  <tr>
    <th><img src="{$tpl_path}/images/function/icon-s-2.gif" width="16" height="18"></th>
    <th><a href="../Examine/stu_view.php" target="information">已/未填寫測驗</a></th>
    <th>{$exam_outdeadline}/{$exam_indeadline}</th>
  </tr>
  <tr>
    <td colspan="2"><div style="width:100%; padding:2px; border:1px solid #CCCCCC; text-align:left;"><img src="{$tpl_path}/images/function/icon-s-3.gif" width="6" height="6" style="width:{$exam_percentage}%;"/></div></td>
    <td>{$exam_percentage}%</td>
  </tr>
  <tr>
    <th><img src="{$tpl_path}/images/function/icon-s-2.gif" width="16" height="18"></th>
    <th><a href="../Assignment/stu_assign_view.php" target="information">已/未填寫作業</a></th>
    <th>{$assign_outdeadline}/{$assign_indeadline}</th>
  </tr>
  <tr>
    <td colspan="2"><div style="width:100%; padding:2px; border:1px solid #CCCCCC; text-align:left;"><img src="{$tpl_path}/images/function/icon-s-3.gif" width="6" height="6" style="width:{$assign_percentage}%;"/></div></td>
    <td>{$assign_percentage}%</td>
  </tr>
  <tr>
    <th><img src="{$tpl_path}/images/function/icon-s-2.gif" width="16" height="18"></th>
    <th><a href="../Survey/stu_view.php" target="information">已/未填寫問卷</a></th>
    <th>{$survey_outdeadline}/{$survey_indeadline}</th>
  </tr>
  <tr>
    <td colspan="2"><div style="width:100%; padding:2px; border:1px solid #CCCCCC; text-align:left;"><img src="{$tpl_path}/images/function/icon-s-3.gif" width="6" height="6" style="width:{$survey_percentage}%;"/></div></td>
    <td>{$survey_percentage}%</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</center>
</body>
</html>
