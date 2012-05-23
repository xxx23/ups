<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<script type="text/javascript" src="script/delete.js"></script>

<link href="../css/v2/style.css" rel="stylesheet" type="text/css" />
<link href="../css/v2/teaching_material.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contents">
<div id="content">
	<div class="area2_title" id="news_title" style="left:0;">
	  <a href="#">- </a>目前所在位置：<a href="../Personal_Page/" target="_top">首頁</a> &gt;&gt;
	  <a href="#" target="_self">課程名稱</a> &gt;&gt;
	  <a href="#" target="_self">線上作業</a> &gt;&gt;
	  <a href="#" target="_self">瀏覽作業</a>
	</div>
	<div class="area2" id="news" style="left:0;"> 
	  <table width="100%" class="datatable" border="1">
        <tbody>
          <tr>
            <th>作業名稱</th>
            <th>繳交期限</th>
            <th>配分</th>
            <th>題目</th>
            <th>修改</th>
            <th>解答</th>
            <th>刪除</th>
          </tr>
	  {foreach from=$ass_data item=ass}
	  <tr>
	    <th>{$ass.homework_name}</th>
	    <th>{$ass.d_dueday|truncate:11:"":true}</th>
	    <th>{$ass.percentage}</th>
            <th><a href="tea_assignment.php?view=true&option=view&homework_no={$ass.homework_no}"><img src="images/question_icon.gif" width="19" height="19" border="0"/></a></th>
            <th><a href="tea_assignment.php?view=true&option=modify&homework_no={$ass.homework_no}"><img src="images/edit_icon.gif" width="19" height="19" border="0"/></a></th>
            <th><a href="tea_answer.php?view=true&homework_no={$ass.homework_no}&option=view"><img src="images/answer_icon.gif" width="19" height="19" border="0"/></a></th>
            <th><img src="images/delete_icon.gif" width="19" height="19" border="0" onClick="return delete_work({$ass.homework_no})" style="cursor:hand;"/></th>
	  </tr>
	  {/foreach}
        </tbody>
      </table>
      <p>&nbsp;</p>
    </div>
</div>
</body>
</html>
