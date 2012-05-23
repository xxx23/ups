<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>熱門課程排行前10名</title>
<!--edit by aeil-->
<script src="../script/jquery-1.2.6.pack.js" type="text/javascript"></script> 
<script src="../script/corners.js"></script> 
<link href="../css/table_popular_course.css" rel="stylesheet" type="text/css" />
<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />

<!--end-->
</head>

<body background="#FFF">
<center>
　<h1 align="left">課程總覽</h1>
  <p>請選擇課程分類觀看課程!!<br>
    <br>
  </p>
  <table class="datatable" width="600px">
	<tr>
	<th>排序</th>
	<th>課程分類</th>
	<th>課程數目</th>
	</tr>
	{assign var="count" value=1}
	{foreach from=$popular_course item=dep}
	<tr>
	<td style="text-align:center">{$count++}</td>
	<td><a href="popular_course2_dump.php?popular_course_cd={$dep.property_cd}&page=1">{$dep.property_name}</a>
	  {if $dep.new > 0}<img src="../images/new.gif">{/if}
	</td>
	<td style="text-align:center">
	{$dep.course_number}
	</td>
	</tr>  </div>
	{/foreach}
</table>

</center>
</body>
</html>
