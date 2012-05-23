{*<!--
  role_cd: 0管理者 , 1老師 , 2助教 , 3學生 , 4訪客 , 5測試人員 , 6教務管理者
-->*}
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>個人化首頁</title>
<link href="../css/index/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$webroot}script/swfobject.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/personal/personal.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/personal/drag.js"></script>
<script type="text/javascript" src="{$webroot}script/jquery-1.3.2.min.js"></script>

<script type="text/javascript" language="JavaScript">
<!--
var tmp = "course";
var tmp2 = "tabA";
var role = {$role_cd};
var aim_url = '{$aim_url}';
var basic_info_id ={$basic_info_id};
var basic_info={$basic_info};
{literal}
if(role == 0){
	tmp = "other";
	tmp2 = "tabB";
}

function start(){
	view(tmp, tmp2);
//	setTimeout("ResizeIframe(document.getElementsByName('calendar')[0])", 100);
}

function changeImg(path, block){
	block.setAttribute("src", path);
}

function frame_redirect(url){
    if(url != '') {
        window.top.frames['main_info'].location = url ; 
    }
}

function isWorking()
{
    alert("個人筆記本維護中...");
}


$(document).ready(function(){
        if(role!=0&&role!=4&&role!=2&& (basic_info_id == 0||basic_info == 0)){
            alert('請至"個人資料"選單中\n填寫個人身份證或護照號碼,Email等相關資料以免您的權益受損!');
            $("#main_info").attr("src","../Learner_Profile/user_profile.php");
            $("a[target='main_info']").attr("href","#").click(function(){
                alert('依教育部電算中心要求，請至"個人資料"選單中\n填寫個人身份證或護照號碼,Email等相關資料，方可正常使用。(填完資料確定送出後請按F5重整頁面)');
                $("#main_info").attr("src","../Learner_Profile/user_profile.php");
                return false;
            });
        }

        });

{/literal}
-->

</script>

</head>
<body class="indx">

<div class="outerContainer" style="relative;"> 
	<div class="bannerContainer">
		<div class="outersitelink"> 　<a target="main_info" href="../Other/software_download.php" alt="下載區">下載區</a> 　|　<a target="_blank" href="http://www.edu.tw" alt="教育部">教育部</a> 　|　　<a target="main_info" href="../Other/site_view.html" alt="網站導覽">網站導覽</a>　　　　 .</div>

	<div id="flashBanner"> </div>
	<script type="text/javascript">
		swfobject.embedSWF("../images/index_top1.swf", "flashBanner", "970", "115", "9.0.0", "../script/expressInstall.swf");	
	</script>


	</div>
	<div class="mainContainer" style="zoom:1;" >
		<div class="leftContainer" style="">
			<div class="welcomeContainer">
				<div class="profile_pic">
					{if $havePhoto == 0}
					<img id="userImage" src="{$tpl_path}/images/edu.jpg" style="width:80px; height:80px; border:0px outset black;" />
					{else}
					<img id="userImage" src="../{$photo}" style="width:80px; height:80px; border:0px outset black;" />
					{/if}
				</div>
				<div class="identify">
					<div>{$name}</div>
					<div style="font-size:12px;font-wegiht:bold;">[{$role_name}]</div>				</div>
			<div class="form_button">
				<input style="width:48%;font-weight: bold; border:1px; border-color:#000;" type="button" onclick="javascript:location='../logout.php'" value="登出" size="15">
                {$sudo_admin_back_url}
			</div>
			</div>	
			<div class="menubar">
			  <div class="linkcontainer">
			      <div class="linkitemleft"><a href="../System_News/systemNews_RoleNews.php" target="main_info"><img src="{$webroot}images/personal_page/icon_a01.gif" alt="最新消息" border="0" /></a></div>
{if $role_cd != 0 and $role_cd != 6}
				  {if $role_cd != 1 && $role_cd != 3}
				  <div class="linkitemleft"><a href="courseSearch.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e03.gif" alt="課程總覽-訪客" border="0" /></a></div>

				  {/if}

				  {if $role_cd != 4}
				  <div class="linkitemleft"><a href="courseList.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e01.gif" alt="我的課表" border="0" /></a></div>

<!-- joyce0808 教材分享  
<div class="linkitemleft"><a href="../Teaching_Material/textbook_general_download.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e11.gif" alt="教材分享" border="0" /></a></div>
-->			  
                  {/if}
				  
				  {if $role_cd != 1}
				  <div class="linkitemleft"><a href="../popular_course.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e02.gif" alt="熱門課程" border="0" /></a></div>
                  {/if}
				  
				  {if $role_cd == 4}
				  <div class="linkitemleft"><a href="../Other/about.html" target="main_info"><img src="{$webroot}images/personal_page/icon_f01.gif" alt="關於本站" border="0" /></a></div>
                  <div class="linkitemleft"><a href="../manual/Guest1118.pdf" target="_blank"><img src="{$webroot}images/personal_page/icon_e08.gif" alt="操作手冊" border="0" /></a></div>
				  <div class="linkitemleft"><a href="../Other/q_and_a.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e09.gif" alt="常見問題" border="0" /></a></div>
				  <div class="linkitemleft"><a href="../Guest_Book/index.php" target="main_info"><img src="{$webroot}images/personal_page/icon_f02.gif" alt="留言板"border="0" /></a></div>
				  <div class="linkitemleft"><a href="../Other/links.php" target="main_info"><img src="{$webroot}images/personal_page/icon_f03.gif" alt="網站連結" border="0" /></a></div>
				  <div class="linkitemleft"><a href="../Other/suggest.php" target="main_info"><img src="{$webroot}images/personal_page/icon_f04.gif" alt="瀏覽建議" border="0" /></a></div>
				  

				  {/if}

				  {if $role_cd == 3}
				  <div class="linkitemleft"><a href="courseSearch.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e03.gif" alt="課程總覽" border="0" /></a></div>
				  <div class="linkitemleft"><a href="select_course_result.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e04.gif" alt="選課結果" border="0" /></a></div>
				  <div class="linkitemleft"><a href="history_course_list.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e05.gif" alt="學習紀錄" border="0" /></a></div>

				  {/if}		
				  			
				  {if $role_cd != 4 && $role_cd != 0}
                    <!-- joyce0808 教材分享 -->
                    <div class="linkitemleft"><a href="../Teaching_Material/textbook_general_download.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e11.gif" alt="教材分享" border="0" /></a></div>
                    
                    <div class="linkitemleft"><a href="../Learner_Profile/user_profile.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e06.gif" alt="個人資料" border="0" /></a></div>

				  {/if}
				  

				  {if $role_cd != 4}
				  <div class="linkitemleft"><a href="../Note_Book/notebook_mgt.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e07.gif" alt="個人筆記本" border="0" /></a></div>
  				  <!--
                     <div class="linkitemleft"><a href="#" onclick="isWorking();"><img src="{$webroot}images/personal_page/icon_e07.gif" alt="個人筆記本" border="0" /></a></div>

                    <div class="linkitemleft"><a href="textbook_general_download.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e11.gi
                  -->

				  {/if}
	              
                  {if $role_cd eq 1}
                      <div class="linkitemleft"><a href="../Personal_Page/group.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e10.gif" alt="社群專區" border="0" /></a></div>
			      {/if}

				  {if $role_cd != 0 && $role_cd != 4}
                    {if $role_cd eq 1}
                    <div class="linkitemleft"><a href="../manual/teacher.pdf" target="_blank"><img src="{$webroot}images/personal_page/icon_e08.gif" alt="操作手冊" border="0" /></a></div>
                    {else}
                    <div class="linkitemleft"><a href="../manual/MainPage_Member1118.pdf" target="_blank"><img src="{$webroot}images/personal_page/icon_e08.gif" alt="操作手冊" border="0" /></a></div>
				    {/if}
                    <div class="linkitemleft"><a href="../Other/q_and_a.php" target="main_info"><img src="{$webroot}images/personal_page/icon_e09.gif" alt="常見問題" border="0" /></a></div>
                    <div class="linkitemleft"><a href="../Guest_Book/index.php" target="main_info"><img src="{$webroot}images/personal_page/icon_message.gif" alt="留言板" border="0" /></a></div>
				  {/if}
				  {/if}

<!--設定Admin有的功能-->
{if $role_cd == '0'}
					<div class="category"><h1>開課管理</h1></div>
					<div class="linkitemleft"><a href="../Course_Admin/begin_course.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b01.gif" alt="開設課程" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Course_Admin/show_all_begin_course.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b02.gif" alt="查詢開課" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Course_Admin/unit_basic.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b03.gif" alt="開課單位" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Course_Admin/course_property.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b04.gif" alt="課程性質管理" border="0" /></a></div>
                    <div class="category"><h1>帳號權限管理</h1></div>
					{* <div class="linkitemleft"><a href="../Learner_Profile/list_academic_admin.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c01.gif" alt="教務管理者帳號管理" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/list_teacher.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c02.gif" alt="教師帳號管理" border="0" /></a></div> *}
					<div class="linkitemleft"><a href="../Jurisdiction/jurisdictionManagement.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c03.gif" alt="系統選單管理" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Jurisdiction/roleManagement.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c04.gif" alt="角色權限管理" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/adm_file_insertStudent.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c05.gif" alt="匯入學生帳號" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/adm_insert_student.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c06.gif" alt="批次建立帳號" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/adm_query_user.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c07.gif" alt="帳號管理" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/adm_check_select.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c08.gif" alt="選課名單列表與核准" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/user_role.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c09.gif" alt="使用者角色管理作業" border="0" /></a></div>
					{* <div class="linkitemleft"><a href="../Learner_Profile/delete_student.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c10.gif" alt="學生帳號刪除" border="0" /></a></div> *}
					<div class="category"><h1>其它</h1></div>
                    {if $UPS_ONLY eq true}
					<div class="linkitemleft"><a href="../Activities/inviteYourFriendsAdmin.php" target="main_info">呼朋引伴活動</a></div>
                    {/if}
					<div class="linkitemleft"><a href="../Guest_Book/login.php" target="main_info"><img src="{$webroot}images/personal_page/icon_d01.gif" alt="留言板管理" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Statistics/people.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b05.gif" alt="查詢報表" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Course_Admin/nknu_mgm.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b06.gif" alt="研習時數傳送管理" border="0" /></a></div>
{*					<div class="linkitemleft"><a href="../Learning_Tracking/learningTrackingManagement.php" target="main_info"><img src="{$webroot}images/personal_page/icon_d02.gif" alt="學習追蹤管理" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/syn_user_dir.php" target="main_info"><img src="{$webroot}images/personal_page/icon_d03.gif" alt="同步帳號資料夾" border="0" /></a></div> *}
<!-- 1215 joyce add -->
<div class="linkitemleft"><a href="../Teaching_Material/textbook_error_check.php" target="main_info"><img src="{$webroot}images/personal_page/icon_f06.gif" alt="{#learning_hour_transfer_management#}" border="0" /></a></div>
<!--  -->
	
{/if}	
<!--設定教務管理者有的功能-->
{if $role_cd == '6'}
					<div class="category"><h1>開課管理</h1></div>
					
					<div class="linkitemleft"><a href="../Course_Admin/begin_course.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b01.gif" alt="開設課程" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Course_Admin/show_all_begin_course.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b02.gif" alt="查詢開課" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Course_Admin/unit_basic.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b03.gif" alt="開課單位" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Course_Admin/course_property.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b04.gif" alt="課程性質管理" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Statistics/people.php" target="main_info"><img src="{$webroot}images/personal_page/icon_b05.gif" alt="查詢報表" border="0" /></a></div>


					<div class="category"><h1>帳號權限管理</h1></div>
					
					<div class="linkitemleft"><a href="../Learner_Profile/adm_file_insertStudent.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c05.gif" alt="匯入學生帳號" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/adm_insert_student.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c06.gif" alt="批次建立帳號" border="0" /></a></div>
					<div class="linkitemleft"><a href="../Learner_Profile/adm_check_select.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c08.gif" alt="選課名單列表與核准" border="0" /></a></div>
{/if}
                    {if $UPS_ONLY eq true}
                    <div class="linkitemleft"><a href="../Other/relatedOutcomes.php" target="main_info"><img src="{$webroot}images/personal_page/icon_c11.gif" alt="{#related_outcomes#}" border="0" /></a></div>
                    {/if}

			  </div>
			</div>
			{if $role_cd != 4}
			<div class="calendarContainer">
				<div class="calendarContent">
					<iframe src="../Calendar/calendar.php" style="width:160px ; height:190px;" frameborder="0" scrolling="no"></iframe>
				</div>
				<div class="calendarToday">
					{$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}
				</div>		
			</div>
			{/if}
		</div>
		
		<div class="rightContainer" >
			<iframe id="main_info" name="main_info" style="border:none; width:750px; height:900px;" onload="ResizeIframe(this);" frameborder="no" src="../System_News/systemNews_RoleNews.php" ></iframe>
		</div>
		<div class="clear"></div>
	</div> <!-- mainContainerEnd -->
	<div class="footer">
		<hr/>
		2009 © 網站內容為教育部所有 未經許可 請勿任意轉載｜最佳瀏覽解析度 1024 x 768<br>
有任何問題請洽教育部｜聯絡專線：05-2720411 分機：33131｜E-mail：ups_moe@mail.moe.gov.tw
	</div>
	
</div>
<script>
    frame_redirect(aim_url) ;
</script>
</body>
</html>
