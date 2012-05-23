<!-- 作者：吳朋憲 
	在這裡應得到課程的ID 教師的ID
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title></title>
<head>

<style type="text/css">
<!--
@import url(css/newExam.css);
-->
</style>

<script type="text/javascript" charset="utf-8" src="script/exam_main.js">
<!--
{literal}
if(document.layers){
	document.write('<LAYER visibility="hide" bgcolor="#ffffcc"></LAYER>');
}else if(document.all){
	document.write('<DIV id="lay" style="position:absolute;background-color:#ffffcc"></DIV>');
}

hide();
{/literal}
-->
</script>
</head>

<body>
<center>
  <p align="left"><a href="create_exam.php"> 新增測驗</a></p>
  <form name="form1" method="post" action="">
    <div align="justify">
      <p>瀏覽設定：
        <select name="select">
			{html_options options=$display_str}
        </select>
        排序依據：
        <select name="order">
			{html_options options=$display_order}
        </select>    
      </p>
    </div>
  </form>
  <table width="717" border=1>
	<tr>
		<td width="70">測驗名稱</td><td width="54">類型</td><td width="61">配分</td><td width="70">瀏覽測驗</td><td width="123">修改名稱與比例</td>
		<td width="52">成績</td>
		<td width="62">設定發佈</td><td width="51">狀態</td><td width="40">刪除</td><td width="70">公布成績</td>
	</tr>
	{foreach from=$exam_data item=exam}
	<tr>
		<td>{$exam.test_name}</td><td>{$exam.test_type_str}</td><td>{$exam.percentage}</td>
		<td><a href="display_exam.php?test_no={$exam.test_no}">瀏覽測驗</a></td><td><a href="modify_exam.php?test_no={$exam.test_no}">修改測驗</a></td>
		<td><a href="#">成績</a></td>
		<td><a href="../Publish_Exam/set_publish.php?test_no={$exam.test_no}">發佈設定</a></td>
		<td><span onMouseOver="show(event,'{$exam.string}')" onMouseOut="hide()">{$exam.state}</span></td>
		<td><input type="button" value="刪除" onClick="return delete_exam({$exam.test_no})"/></td><td>公布</td>
	</tr>
	{/foreach}
</table>
</center>
<LAYER visibility="hide" bgcolor="#ffffcc"/>
<DIV id="lay" style="position:absolute;background-color:#ffffcc"/></div></body>
</body>

</html>