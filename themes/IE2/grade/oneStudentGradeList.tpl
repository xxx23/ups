<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>
<h1>查詢成績</h1>


<table class="datatable">
<caption>姓名:{$studentName}</caption>
<tr>
	<th colspan="2">考試名稱</th>
	<th>比例</td>
	<th>分數</td>
	<th>排名</td>
</tr>

<!------------------------------------------------------------------------------------->
<!------------------------------------線上測驗------------------------------------------>
<!------------------------------------------------------------------------------------->
{if $onlineTestNum>0}
<tr class="tr2">
	<td colspan="5">線上測驗</td>
</tr>
{section name=counter loop=$studentGradeList[1]}
<tr>
	<td colspan="2">{$studentGradeList[1][counter].name}</td>
	<td>{$studentGradeList[1][counter].percentage}%</td>
	<td>{$studentGradeList[1][counter].concent_grade}</td>
	<td>{$studentGradeList[1][counter].rank}/{$studentNum}</td>
</tr>
{/section}
{/if}


<!------------------------------------------------------------------------------------->
<!-----------------------------------------線上作業------------------------------------->
<!------------------------------------------------------------------------------------->
{if $homeworkNum>0}
<tr class="tr2">
	<td colspan="5">線上作業</thtd
></tr>
{section name=counter loop=$studentGradeList[2]}
<tr>
	<td colspan="2">{$studentGradeList[2][counter].name}</td>
	<td>{$studentGradeList[2][counter].percentage}%</td>
	<td>{$studentGradeList[2][counter].concent_grade}</td>
	<td>{$studentGradeList[2][counter].rank}/{$studentNum}</td>
</tr>
{/section}
{/if}

<!------------------------------------------------------------------------------------->
<!-----------------------------------------點名---------------------------------------->
<!------------------------------------------------------------------------------------->
{if $rollCallNum > 0}
<tr class="tr2">
	<td colspan="5">點名</td>
</tr>
{section name=counter loop=$studentGradeList[3]}
<tr>
	<td colspan="2">{$studentGradeList[3][counter].name}</td>
	<td>{$studentGradeList[3][counter].percentage}%</td>
	<td>{$studentGradeList[3][counter].concent_grade}</td>
	<td>{$studentGradeList[3][counter].rank}/{$studentNum}</td>
</tr>
{/section}
{/if}

<!------------------------------------------------------------------------------------->
<!----------------------------------------一般測驗-------------------------------------->
<!------------------------------------------------------------------------------------->
{if $commTestNum > 0}
<tr class="tr2">
	<td colspan="5">一般測驗</td>
</tr>
{section name=counter loop=$studentGradeList[4]}
<tr>
	<td colspan="2">{$studentGradeList[4][counter].name}</td>
	<td>{$studentGradeList[4][counter].percentage}%</td>
	<td>{$studentGradeList[4][counter].concent_grade}</td>
	<td>{$studentGradeList[4][counter].rank}/{$studentNum}</td>
</tr>
{/section}
{/if}


<!------------------------------------------------------------------------------------->
<!----------------------------------------一般作業-------------------------------------->
<!------------------------------------------------------------------------------------->
{if $commHomeworkNum > 0}
<tr class="tr2">
	<td colspan="5">一般作業</td>
</tr>
{section name=counter loop=$studentGradeList[5]}
<tr>
	<td colspan="2">{$studentGradeList[5][counter].name}</td>
	<td>{$studentGradeList[5][counter].percentage}%</td>
	<td>{$studentGradeList[5][counter].concent_grade}</td>
	<td>{$studentGradeList[5][counter].rank}/{$studentNum}</td>
</tr>
{/section}
{/if}

<!------------------------------------------------------------------------------------->
<!------------------------------------------其他---------------------------------------->
<!------------------------------------------------------------------------------------->
{if $otherNum > 0}
<tr class="tr2">
	<td colspan="5">其他</td>
</tr>
{section name=counter loop=$studentGradeList[9]}
<tr>
	<td colspan="2">{$studentGradeList[9][counter].name}</td>
	<td>{$studentGradeList[9][counter].percentage}%</td>
	<td>{$studentGradeList[9][counter].concent_grade}</td>
	<td>{$studentGradeList[9][counter].rank}/{$studentNum}</td>
</tr>
{/section}
{/if}

{if $showTotalGrade==1}
<tr>
	<th colspan="2">總成績</th>
	<td colspan="3">{$totalGrade}</td>
</tr>
{/if}

<tr>
	<th colspan="2">總排名</th>
	<td colspan="3">{$totalRank}/{$studentNum}</td>
</tr>
</table>

<p class="al-left"><a href="createOneStudentGradeListPDF.php"><img src="{$tpl_path}/images/icon/print.gif" alt="列印"/>列印成績(pdf)</a> <a href="createOneStudentGradeListExcel.php"><img src="{$tpl_path}/images/icon/download.gif" alt="下載"/>下載成績(excel)</a>
</p>


</body>
</html>
