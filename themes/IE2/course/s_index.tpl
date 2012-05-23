<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教育部數位學習平台</title>
<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/course.js"></script>
<link href="../css/teach/index.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
    init();
</script>

</head>

<body>
<div class="outerContainer">

	<div class="bannerContainer">
		<div class="leftbanner">
			<div class="linkitem">
				{if $role != 4}
				<a href="{$webroot}Teaching_Material/textbook_preview.php" target="information"><span class="linkitem_pic">課程教材</span></a>
				<a href="{$webroot}Teaching_Material/textbook_download.php" target="information"><span class="linkitem_pic">教材下載</span></a>
				<a href="{$webroot}Examine/stu_view.php" target="information"><span class="linkitem_pic">線上測驗</span></a>
				<a href="{$webroot}Survey/stu_view.php" target="information"><span class="linkitem_pic">線上問卷</span></a>
				<a  href="{$webroot}Learning_Tracking/showStudentCourseUseLogAction.php" target="information"><span class="linkitem_pic">使用紀錄</span></a>
                {*<a href="{$webroot}Discuss_Area/showDiscussAreaList.php?behavior=student&showType=Course" target="information"><span class="linkitem_pic">社群分享</span></a>*}
				{/if}
			</div>
		</div>
		<div class="rightbanner">
			<div class="welcome_banner">
				<span>Hi!&nbsp;{$name}
				<a href="../Personal_Page/index.php"><img border="0" src="../images/teach/homepage.gif"/></a>
				<a href="../logout.php"><img border="0" src="../images/teach/logout.gif"/></a>
				</span>
			</div>
			<a class="none_a" href="../Online/online.php" target="_blank">
			<div class="online_people">
				<div>系統：<span id="sysPersons"></span>人 &nbsp;同學：<span id="classPersons"></span>人</div> 
			</div>
			</a>
		</div>

		<div class="changeCourse">
			<select  onchange="changeCourse(this)">
				<option value="-1">課程快速選單</option>
                <option value="-2">課程總覽頁面</option>                
				{foreach from=$all_course item=course}
                                   {if $begin_course_cd==$course.begin_course_cd}
                                          <option value="{$course.begin_course_cd}" selected>{$course.begin_course_name}</option>
			           {else}
                                          <option value="{$course.begin_course_cd}">{$course.begin_course_name}</option>
                                   {/if}
           			{/foreach}
	    	</select>
		</div>
		<div class="clear"> </div>

		<div class="qklink">
			<li id="news"><a href="../System_News/systemNews_CourseNews.php" target="information">最新公告<a></li>
            </div>
		<div class="clear"> </div>
	
		

	</div>
	<div class="mainContainer">
		<iframe  id="information" name= "information" frameborder="0" height="700" width="100%"  
		src="{$webroot}Teaching_Material/textbook_preview.php" style="border:none" width="100%" height="100%" onload="ResizeIframe(this)" ></iframe>

	</div>

  <div class="footer">
		<hr/>
		2009 c 網站內容為教育部所有 未經許可 請勿任意轉載｜最佳瀏覽解析度 1024 x 768<br>
		有任何問題請洽教育部｜聯絡專線：05-2720411 分機：33131 ｜E-mail：ups_moe@mail.moe.gov.tw

  </div>
</div>
</body>
</html>
