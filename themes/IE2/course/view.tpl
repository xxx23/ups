<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="../css/table.css" rel="stylesheet" type="text/css" />
<head>

<body bgcolor="#E6E6E6">
<center><table width="90%" class="functable">
  <tr>
    <th><img src="{$tpl_path}/images/function/icon-s-2.gif" width="16" height="18"></th>
    <th><a href="display.php?option=exam" target="information">已/未結束測驗</a></th>
    <th>{$exam_outdeadline}/{$exam_indeadline}</th>
  </tr>
  <tr>
    <td colspan="2"><div style="width:100%; padding:2px; border:1px solid #CCCCCC; text-align:left;"><img src="{$tpl_path}/images/function/icon-s-3.gif" width="6" height="6" style="width:{$exam_percentage}%;"/></div></td>
    <td>{$exam_percentage}%</td>
  </tr>
  <tr>
    <th><img src="{$tpl_path}/images/function/icon-s-2.gif" width="16" height="18"></th>
    <th><a href="display.php?option=assign" target="information">已/未結束作業</a></th>
    <th>{$assign_outdeadline}/{$assign_indeadline}</th>
  </tr>
  <tr>
    <td colspan="2"><div style="width:100%; padding:2px; border:1px solid #CCCCCC; text-align:left;"><img src="{$tpl_path}/images/function/icon-s-3.gif" width="6" height="6" style="width:{$assign_percentage}%;"/></div></td>
    <td>{$assign_percentage}%</td>
  </tr>
  <tr>
    <th><img src="{$tpl_path}/images/function/icon-s-2.gif" width="16" height="18"></th>
    <th><a href="display.php?option=survey" target="information">已/未結束問卷</a></th>
    <th>{$survey_outdeadline}/{$survey_indeadline}</th>
  </tr>
  <tr>
    <td colspan="2"><div style="width:100%; padding:2px; border:1px solid #CCCCCC; text-align:left;"><img src="{$tpl_path}/images/function/icon-s-3.gif" width="6" height="6" style="width:{$exam_percentage}%;"/></div></td>
    <td>{$survey_percentage}%</td>
  </tr>
</table>
</center>
</body>
</html>
