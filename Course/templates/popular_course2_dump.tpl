<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>課程訊息</title>
<!--edit by aeil-->
 	<link rel="stylesheet" href="../css/sort.css" type="text/css" /> 
	<link href="../css/table_popular_course.css" rel="stylesheet" type="text/css" />
	<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="../script/jquery-1.2.6.pack.js"></script> 
  <script type="text/javascript" src="../script/tablesorter/jquery.tablesorter.js"></script> 
  <script type="text/javascript" src="../script/json.js"></script> 
  <script type="text/javascript" >
  var a = "sortColumn: 'NEW',sortClassAsc: 'headerSortUp',sortClassDesc: 'headerSortDown',headerClass: 'header'";
  </script>

<!--end-->
</head>

<body onload="$('#simple').tableSorter(a.toJSONString);">
　<h1>課程總覽</h1>
</blockquote>
<table class="datatable" style="width:70%" align="center"> 
    <tr>
      <th></th>
      <th>排序</th>
      <th>課程名稱</th>
      <th>屬性</th>
    </tr>
  	{assign var="count" value=1}
	{foreach from=$popular_course item=dep}
	<tr>
	<!-- <td width="300">{$dep.begin_course_name}</td> -->
	<td style="text-align:center">{$dep.d_course_end}</td>
	<td style="text-align:center">{$count++}</td>
	<td><a href="std_course_intro2.php?begin_course_cd={$dep.begin_course_cd}" target="_blank">{$dep.begin_course_name}</a></td>
	<td style="text-align:center">{if $dep.attribute == 0}自學{else}教導{/if}</td>
	</tr>
	{/foreach}
</table>
<div align="center">
	{foreach from=$page_index item=dep}
	{$dep.link}
	{/foreach}
</div>
<br/>
<div align="center"><a href="popular_course2.php">回上層</a></div>
</center>
</body>
</html>
