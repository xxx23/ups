<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

 <script src="{$webroot}script/prototype.js" type="text/javascript"></script>

 <script src="{$webroot}script/list_unit.js" type="text/javascript"></script>



<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

<link href="css/course.css" rel="stylesheet" type="text/css" />



<script type="text/javascript">

	{literal}

	function confirm_delete(unit_cd)

	{

		var r=confirm("您確認要刪除此類別嗎？");

		if(r == true)

		{

			window.location="dep_delete?del="+unit_cd;

		}

	}

	{/literal}

</script>



<title>TEST</title>

</head>

<body class="ifr">
<h1>所有開課類別</h1>
<FORM NAME="show_list">

<center>

<table class="datatable"><tbody>

	<tr>

	<!--	<th>類別編號</th> -->

		<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>類別名稱</th>

	<!--	<th>所屬類別</th> -->

		<th>修改</th>

		<th>刪除</th>

	</tr>

	

	{foreach from=$Department item=dep}

	<tr>

	<!--	<td>{$dep.unit_cd}</td>-->

		<td>

		{if $dep.under == 1}

			<a href=dep_list.php?cd={$dep.unit_cd}>{$dep.unit_name}</a>

		{else}

			{$dep.unit_name}

		{/if}

		</td>

		<!--<td>

		{if $dep.department != -1}{$dep.department}{/if}

		</td>

		-->

		<td><a href=dep_edit.php?ed={$dep.unit_cd}>修改</a></td>

		<td><input type="button" name="submitbutton" value="刪除" onclick="cfm('dep_delete.php?del={$dep.unit_cd}')" /></td>

	</tr>

	{/foreach}

<tbody></table>

<a href=dep_list.php?cd={$pre}>回上層</a>



{if $show_search == 1}

<h1>查詢結果</h1>

<form action="delete_course.php" method="POST" name="delete_course">

  <table class="datatable">

    <tr>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 

        <input type="checkbox" name="checkAll" onClick="doCheckAll('check[]');" />

        </th>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 課程編號</th>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 開課單位</th>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 開課名稱</th>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 授課教師</th>

	  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 證書</th>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 課程資訊</th>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 授課教師</th>

      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/> 重置課程</th>

    </tr>

    {foreach from=$course_data item=course}

    <tr>

      <td><input type="checkbox" name="check[]" value="{$course.begin_course_cd}" /></td>

      <td>{$course.inner_course_cd}</td>

      <td>{$course.unit_name}</td>

      <td>{$course.begin_course_name}</td>

      <td>{$course.personal_name}</td>

	  <td><a href="../Certificate/certificateManagement.php?begin_course_cd={$course.begin_course_cd}&incomingPage=../Course_Admin/show_all_begin_course.php" >設定</a></td>

      <td><a href="./view_course.php?begin_course_cd={$course.begin_course_cd}" >修改</a></td>

      <td><a href="./add_teacher_to_course.php?begin_course_cd={$course.begin_course_cd}" >修改</a></td>

      <td><a href="reset_course.php?begin_course_cd={$course.begin_course_cd}">重置</a></td>

    </tr>

	{/foreach}

    <tr>

      <td colspan="9"><p class="al-left">

      	<input type="hidden" id="option" name="option" value=""/>

	<input id="_delete_course" type="button" value="刪除課程"/></p></td>

    </tr>

 </table>



</form>

{/if}



</center>

</FORM>

</body>

</html>

