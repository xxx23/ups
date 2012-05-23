<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>學生成績列表</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

</head>

<body>
<h1>學生成績列表</h1>
<table class="datatable">
<tr>
	<th><div align="center">排名</div></th>
	<th><div align="center">姓名</div></th>
{if $gradeNum>0}
{assign var=grade_counter value=1}

{section name=counter loop=$gradeList[1]}
	<th><a href="showStudentGradeList.php?grade_counter={$grade_counter++}">{$gradeList[1][counter].name}({$gradeList[1][counter].percentage}%)</a></th>
{/section}
{section name=counter loop=$gradeList[2]}
	<th><a href="showStudentGradeList.php?grade_counter={$grade_counter++}"><div align="center">{$gradeList[2][counter].name}({$gradeList[2][counter].percentage}%)</a></th>
{/section}
{section name=counter loop=$gradeList[3]}
	<th><a href="showStudentGradeList.php?grade_counter={$grade_counter++}"><div align="center">{$gradeList[3][counter].name}({$gradeList[3][counter].percentage}%)</a></th>
{/section}
{section name=counter loop=$gradeList[4]}
	<th><a href="showStudentGradeList.php?grade_counter={$grade_counter++}"><div align="center">{$gradeList[4][counter].name}({$gradeList[4][counter].percentage}%)</a></th>
{/section}
{section name=counter loop=$gradeList[5]}
	<th><a href="showStudentGradeList.php?grade_counter={$grade_counter++}"><div align="center">{$gradeList[5][counter].name}({$gradeList[5][counter].percentage}%)</a></th>
{/section}
{section name=counter loop=$gradeList[9]}
	<th><a href="showStudentGradeList.php?grade_counter={$grade_counter++}"><div align="center">{$gradeList[9][counter].name}({$gradeList[9][counter].percentage}%)</a></th>
{/section}

{/if}
	<th><a href="showStudentGradeList.php?grade_counter=0"><div align="center">總成績</a></th>
</tr>

{if $studentNum>0}
{section name=counter loop=$studentList}
<tr class="{cycle values=",tr2"}">	
  <td><div align="center">{$studentList[counter].rank}</div></td>
  <td><div align="center">{$studentList[counter].name}</div></td>
  
{if $gradeNum>0}  
  {section name=counter2 loop=$studentGradeList[counter]}
  <td><div align="center">{$studentGradeList[counter][counter2]}</div></td>
  {/section}
{/if}

  <td><div align="center">{$studentList[counter].totalGrade} </div></td>
</tr>
{/section}
{/if}

<tr>
	<th colspan="2">最高分</th>
{section name=counter loop=$maxGradeList}
	<td><div align="center">{$maxGradeList[counter]}</div></td>
{/section}
</tr>
<tr>
	<th colspan="2">最低分</th>
{section name=counter loop=$minGradeList}
	<td><div align="center">{$minGradeList[counter]}</div></td>
{/section}
</tr>
<tr>
	<th colspan="2">平均</th>
{section name=counter loop=$avgGradeList}
	<td><div align="center">{$avgGradeList[counter]}</div></td>
{/section}
</tr>
</table>

<p class="al-left"><a href="createStudentGradeListPDF.php"><img src="{$tpl_path}/images/icon/print.gif" />成績列印(pdf)</a> <a href="createStudentGradeListExcel.php"><img src="{$tpl_path}/images/icon/download.gif" />成績下載(excel)</a>
</p>
</body>
</html>
