{include file="$HOME_PATH/themes/IE2/header.tpl"}

<link href="../css/teach/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="../script/jdmenu/jquery.js"></script>
<script type="text/javascript" src="../script/jdmenu/jquery.dimensions.js"></script>
<script type="text/javascript" src="../script/jdmenu/jquery.positionBy.js"></script>
<script type="text/javascript" src="../script/jdmenu/jquery.bgiframe.js"></script>
<script type="text/javascript" src="../script/jdmenu/jquery.jdMenu.js"></script>

<script type="text/javascript" src="{$tpl_path}/script/course.js"></script>
<link rel="stylesheet" href="../css/teach/jquery.jdMenu.css" type="text/css" />
{literal}
<script language="JavaScript">
    init();

function isWorking()
{
    alert("個人筆記本維護中...");
}
//---joyce edit 0305 --------------
function tologout()
{
    if(confirm('為使您的時數正確紀錄\n\n請問是否所有子式窗已全數關閉?'))
        location.href = "../logout.php"
}
//--------------------------------

</script>
{/literal}
</head>

<body>
<div class="outerContainer">

	<div class="bannerContainer">
		<div class="leftbanner">
			<div class="linkitem">
				<ul class="jd_menu">
					{foreach from=$level_0 item=fun_0}
					<li><a href="#">{$fun_0.menu_name}</a>
						{if !empty($fun_0.next)}<ul>
						{foreach from=$fun_0.next item=fun_1}<li><a target="information" href="{if $webroot ne '/'}{$webroot}{/if}{$fun_1.menu_link}">{$fun_1.menu_name}{if !empty($fun_1.next)}&nbsp;<img border="0" src="../images/submenu.gif"/>{/if}</a>
								{if !empty($fun_1.next)}<ul>{foreach from=$fun_1.next item=fun_2}<li><a target="information" href="{if $webroot ne '/'}{$webroot}{/if}{$fun_2.menu_link}">{$fun_2.menu_name}</a></li>{/foreach}</ul>{/if}
						</li>
						{/foreach}</ul>{/if}
					</li>
					{/foreach}
					<li style="display:none"><a href="#"><!--for ie6,7 disappear --></a></li>
				<ul>
				
			</div>
		</div>
		<div class="changeCourse">
			<select  onchange="changeCourse(this)">
				<option value="-1">{#quick_course_menu#}</option>
				{foreach from=$all_course item=course}
				   {if $begin_course_cd==$course.begin_course_cd}
					<option value="{$course.begin_course_cd}" selected>{$course.begin_course_name}</option>
				   {else}
					<option value="{$course.begin_course_cd}">{$course.begin_course_name}</option>
				   {/if}
				{/foreach}
		    </select>
		</div>
		<div class="qklink">
			<li id="news"><a href="../System_News/systemNews_CourseNews.php" target="information">{#latest_news#}</a></li>
			<li id="thermometer"><a href="course_learn_schedule.php" target="information">{#elearning_gradient#}</a></li>
			<li id="calendar"><a href="../Calendar/month.php" target="information">{#calendar#}</a></li>
			<!--<li id="notebook"><a href="../Note_Book/notebook_mgt.php" target="information">{#notebook#}</a></li>-->
			<li id="notebook"><a href="#" onclick="isWorking();">{#notebook#}</a></li>

            {if $role == 1} 
			   <li id="help"><a target="_blank" href="../manual/Teacher1118.pdf">{#instruction#}</a></li>
            {elseif $role == 2}
			   <li id="help"><a target="_blank"  href="../manual/Teacher1118.pdf">{#instruction#}</a></li>
            {elseif $role == 3}
			   <li id="help"><a target="_blank" href="../manual/MainPage_Member1118.pdf">{#instruction#}</a></li>
            {/if}
			&nbsp;&nbsp;
		</div>
		<div class="rightbanner">
			<div class="welcome_banner">
				<span>hi&nbsp;{$name}! 
					<a href="../Personal_Page/index.php"><img border="0" src="../images/teach/homepage.gif"/></a>
				<!--	<a href="../logout.php"><img border="0" src="../images/teach/logout.gif"/></a> -->
                    <!---joyce edit 0305 -->
                    <a href="#2" onclick="tologout();">
                        <img border="0" src="../images/teach/logout.gif"/>
                    </a>
				</span><br/>
                {$sudo_admin_back_url}
			</div>
			<a href="../Online/online.php" target="_blank">
			<div class="online_people">
				<div>{#system_people#}:<span iD="sysPersons" name="sysPersons"></span>人
				&nbsp;{#classmate#}:<span id="classPersons"></span>人</div>
			</div>
<script language="JavaScript">
//alert(sysPersons.innerHTML);
</script>
			</a>
		</div>
		<div class="clear"> </div>
		

	</div>
	<div class="mainContainer">
    <!--非訪客一進課程顯示課程訊息-->
    {if $role != 4 }
		<iframe id="information" name="information" onload="ResizeIframe(this);" 
			width="100%" height="600px" frameborder="0" style="border:none" 
			src="../System_News/systemNews_CourseNews.php"></iframe>
    <!--訪客一進課程顯示教材-->        
    {else}
		<iframe id="information" name="information" onload="ResizeIframe(this);" 
			width="100%" height="600px" frameborder="0" style="border:none" 
			src="../Teaching_Material/textbook_preview.php"></iframe>
    {/if}
	</div>

  <div class="footer">
	{include file="$HOME_PATH/themes/IE2/footer.tpl"}
  </div>
</div>
</body>
</html>
