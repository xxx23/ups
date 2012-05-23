<!-- 作者：吳朋憲 
	在這裡應得到課程的ID 教師的ID
-->
<html>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title></title>
<head>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript" src="../script/default.js"></script>
<script type="text/javascript" charset="utf-8" src="{$webroot}script/examine/exam_main.js"></script>

<script type="text/javascript">
<!--
assign_tpl_path("{$tpl_path}");
-->
</script>
</head>

<body onload="hide();">
<h1>測驗列表</h1>

  <form method="GET" action="deleteExamine.php" name="deleteExam">
  <table class="datatable">
    <tbody>
	<tr>
        {if $attribute eq 1}
	    <th style="text-align:center;"><input type="checkbox" onClick="clickAll('deleteExam', this);"/></th>
        {/if}
        <th>測驗名稱</th>
		<th>類型</th>
		<th>配分</th>
		<th>狀態</th>
		<th>修改名稱<br/>與比例</th>
		<th>學生測驗成績</th>
		<th>填答統計</th>
		<th>發佈時間設定</th>
		<th>手動email催繳</th>
		<th>自動email催繳</th>
		<th>公佈<br/>成績</th>
		<th>公佈<br/>解答</th>
	</tr>
	{foreach from=$exam_data item=exam}
	<tr class="{cycle values=" ,tr2"}">
        {if $attribute eq 1}
        <td style="text-align:center;"><input type="checkbox" name="test_no[]" value="{$exam.test_no}"/></td>
        {/if}
        <td><a href="display_exam.php?test_no={$exam.test_no}">{$exam.test_name}</a>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10px;"><a href="exam_main.php?test_no={$exam.test_no}">(修改題目)</a></span></td>
		<td>{$exam.test_type_str}</td>
		<td>{$exam.percentage}</td>
		<td><span onMouseOver="show(event,'{$exam.string}')" onMouseOut="hide()"><img src="{$tpl_path}/images/examine/{$exam.state}.gif"/></span>			</td>
		<td><a href="modify_exam.php?test_no={$exam.test_no}"><img src="{$tpl_path}/images/icon/edit.gif" /></a></td>
		<td><a href="view_grade.php?test_no={$exam.test_no}"><img src="{$tpl_path}/images/icon/view.gif" /></a></td>
		<td><a href="complie_exam.php?test_no={$exam.test_no}"><img src="{$tpl_path}/images/icon/list.gif" /></a></td>
		<td><a href="set_publish.php?test_no={$exam.test_no}"><img src="{$tpl_path}/images/icon/setup.gif" /></a></td>
		<td><a href="examine_reminder.php?test_no={$exam.test_no}" onclick="return confirm('您確定要立刻email通知測驗嗎？\n\n按確定後會立刻通知一次\n')">手動通知</a></td>
		{if $exam.test_no|in_array:$remind_test}
		<td><a href="tea_view.php?test_no={$exam.test_no}&remind=0">停用催繳</a></td>
		{else}
		<td><a href="tea_view.php?test_no={$exam.test_no}&remind=1">啟用催繳</a></td>
		{/if}
		<!--<td><input type="button" value="刪除" onClick="return delete_exam({$exam.test_no})"/></td>-->
		<td style="cursor:pointer;" onclick="changePublic({$exam.test_no}, this);">
	{if $exam.grade_public == 0}
			<img src="{$tpl_path}/images/examine/red.gif"/>
	{else}
			<img src="{$tpl_path}/images/examine/green.gif"/>
	{/if}
		</td>
		<td style="cursor:pointer;" onClick="changeAnswer({$exam.test_no}, this);"/>
	{if $exam.ans_public ==1}
		<img src="{$tpl_path}/images/examine/green.gif"/>
	{else}
		<img src="{$tpl_path}/images/examine/red.gif"/>
	{/if}
		</td>
	</tr>
	{foreachelse}
	<tr><td colspan="11" style="text-align:center;">本課程無任何測驗</td></tr>
	{/foreach}
  </tbody>
</table>
    {if $attribute eq 1}
     <p class="al-left"><input class="btn" type="button" value="刪除選取測驗" onClick="_delete();"/></p>
    {/if}
</form>
<div class="intro">
圖示說明：<br>  
<img src="{$tpl_path}/images/icon/we1.gif"/>:&nbsp;未設定&nbsp;&nbsp;
<img src="{$tpl_path}/images/icon/we2.gif"/>:&nbsp;未發佈&nbsp;&nbsp;
  <img src="{$tpl_path}/images/icon/yet.gif"/>:&nbsp;未測驗&nbsp;&nbsp;
  <img src="{$tpl_path}/images/icon/proceeding.gif"/>:&nbsp;測驗中&nbsp;&nbsp;
  <img src="{$tpl_path}/images/icon/end.gif"/>:&nbsp;測驗結束<br/>
  <img src="{$tpl_path}/images/icon/release.gif"/>&nbsp;公布&nbsp;&nbsp;
<img src="{$tpl_path}/images/icon/lock.gif"/>&nbsp;不公布</div>

<LAYER visibility="hide" bgcolor="#FFCC00"/>
<div id="lay" style="position:absolute;background-color:#FFCC00"></div>
</body>

</html>
