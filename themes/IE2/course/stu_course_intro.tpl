<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>課程大綱</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<!--<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>-->
<!--
<script language="javascript" type="text/javascript" src="/Teaching_Material/script/tinyMCE.js"></script>
-->

<!--<script src="../script/prototype.js" type="text/javascript" ></script>-->
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}

{/literal}
//-->
</script>
</head>

<body class="ifr">
<!--<p class="address">目前所在位置: <a href="#">首頁</a> &gt;&gt; <a href="#">課程</a> &gt;&gt; <a href="#">課程說明</a> &gt;&gt; <a href="#">課程介紹</a>&gt;&gt;&gt; <a href="#">大綱</a></p>
-->
<h1>課程大綱</h1>
<div class="tab">
  <ul id="tabnav">
    <li class="tabA"><a href="#future">宗旨</a></li>
    <li class="tabA"><a href="#introduction">課程簡介</a></li>
    <li class="tabA"><a href="#goal">教學目標</a></li>
    <li class="tabA"><a href="#person_mention">教授簡介</a></li>
    <li class="tabA"><a href="#course_process">課程進行方式</a></li>
  <!--
  </ul>
  <br />
  <ul id="tabnav">
  -->
	<li class="tabA"><a href="#learning_test">評量標準</a></li>
	<li class="tabA"><a href="#environment">軟硬體與介面說明</a></li>
  </ul>
</div>
<!-- 課程宗旨-->
<div class="form">
	<a name="future"></a>
	<h1>課程宗旨</h1>
	<pre><div id="div_future">{$course_future}</div></pre>
</div>
<br />
<!-- 課程簡介-->

<div  class="form">
	<a name="introduction"></a>
	<h1>課程簡介</h1>
	<pre><div id="div_introduction">{$course_introduction}</div><pre>
</div>
<br />
<!-- 課程目標-->

<div  class="form">
	<a name="goal"></a>
	<h1>課程目標</h1>
	<pre><div id="div_goal">{$course_goal}</div></pre>
</div>
<br />
<!-- 教授簡介-->

<div  class="form">
	<a name="person_mention"></a>
	<h1>教授簡介</h1>
	<pre><div id="div_person_mention">{$person_mention}</div></pre>
</div>
<br />
<!-- 課程進行方式 -->

<div  class="form">
	<a name="course_process"></a>
	<h1>課程進行方式</h1>
	<pre><div id="div_course_process">{$course_process}</div></pre>
</div>
<br />
<!-- 評量標準-->
<div  class="form">
	<a name="learning_test"></a>
	<h1>評量標準</h1>
	<pre><div id="div_learning_test">{$learning_test}</div></pre>
</div>
<br />
<!-- 軟硬體介面說明-->
<div class="form">
	<a name="environment"></a>
	<h1>軟硬體介面說明</h1>
	<pre><div id="div_environment">{$course_environment}</div></pre>
</div>				 
<!--</table>-->
</body>
</html>
