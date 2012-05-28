<?php /* Smarty version 2.6.14, created on 2012-05-28 20:43:28
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>教育部數位學習服務平台</title>
<link href="css/index/homepage.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="script/swfobject.js"></script>

<script type="text/javascript" src="script/personal.js"></script>

<script>
<!--
<?php echo '



function doSubmit(){

   if(check())

      document.login_form.submit();

}


function doClear(){

   document.login_form.reset();

}

function entsub(myform) {

  if (window.event && window.event.keyCode == 13)

      doSubmit();      

  else

    return true;

  }

//檢查空白

function check(){

   if(trim(document.getElementsByName("login_id")[0].value) == "" || trim(document.getElementsByName("password")[0].value) == ""){

   	alert("帳號或密碼不可以為空白");

	return false;

   }

   else{

     return true;

   }

}



function trim(stringToTrim){

 return stringToTrim.replace(/^\\s+|\\s+$/g,"");

}

window.onload = function()
{
}

var _gaq = _gaq || [];

_gaq.push([\'_setAccount\', \'UA-26308145-1\']);

_gaq.push([\'_trackPageview\']);



(function() {

 var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;

 ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';

 var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);

 })();
'; ?>

//-->
</script>

</head>
<body>
<div class="outerContainer"> 

	<div class="bannerContainer">

	<div class="outersitelink">

		　<a target="main_info" href="./Other/software_download.php" alt="下載區">下載區</a>　|　　<a target="_blank" href="http://www.edu.tw" alt="教育部">教育部</a> 　| 　<a target="main_info" href="./Other/site_view.html" alt="網站導覽">網站導覽</a></div>



	<div id="flashBanner"> </div>

	<script type="text/javascript">

		swfobject.embedSWF("images/index_top1.swf", "flashBanner", "970", "115", "9.0.0", "script/expressInstall.swf");	

	</script>
	
	</div>

	<div class="mainContainer">
	<div class="leftContainer">
		<div class="welcomeContainer">

		<div class="login_form">

		<div><form name="login_form" action="login_check.php" method="POST">

		<br><br><br>

					<div>帳號：<input name="login_id" style="width:60%;" type="text" value="" onkeypress="return entsub(this.form)"/></div>

					<div style="height:2px; font-size:2px"></div>

					<div>密碼：<input name="password" style="width:60%;" type="password" value="" onkeypress="return entsub(this.form)"/></div>

					<div style="font-size:2px !important; height:3px; font-size:3px;">&nbsp;</div>

					<div>

						<input class="input_48" type="button" onClick="doSubmit();"  value="登入" size="15">

						<input class="input_48" type="button" onClick="doClear();"   value="清除">		

					</div>

					<div style="height:3px; font-size:3px !important; height:5px; font-size:5px;"></div>

					<div>

						<input class="input_48" type="button" onclick="window.open('Registration/joinArticle.php?t=0');"  value="加入會員">

						<input class="input_48" type="button" onclick="window.open('Registration/forgetpasswd.php');" value="查詢密碼">

					</div>

					<div style="height:3px; font-size:3px !important; height:5px; font-size:5px;"></div>

						<input class="input_96" type="button" onclick="javascript:location='guestLogin.php'" value="以訪客身份登入">

					</div></form>
		  </div>
	  </div>	
			<div class="menubar">
				<div class="linkcontainer">
							<img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/menubar_top.gif" border="0" />

				  <div class="linkitemleft"><a href="mix_news_popCourse.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon001.gif" alt="最新消息" border="0" /></a></div>
				  <div class="linkitemleft"><a href="./courseSearch.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon002.gif" alt="課程總覽" border="0" /></a></div>
				  <div class="linkitemleft"><a href="./front_popular_course.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon005.gif" alt="熱門課程" border="0" /></a></div>
				  <div class="linkitemleft"><a href="./manual/MainPage_Member1118.pdf" target="_blank"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon004.gif" alt="操作手冊" border="0" /></a></div>
				  <div class="linkitemleft"><a href="./Other/q_and_a.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon003.gif" alt="常見問題" border="0" /></a></div>
				  <div class="linkitemleft"><a href="./Other/service.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon006.gif" alt="聯絡我們" border="0" /></a></div>
                  <?php if ($this->_tpl_vars['UPS_ONLY'] == true): ?>
                  <div class="linkitemleft"><a href="./Other/relatedOutcomes.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon007.gif" alt="相關成果" border="0" /></a></div>
                  <?php endif; ?>
				  </br>
							</div>
							<img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/menubar_down.gif" border="0" /></br></br>

			</div>

	  </div>

		<div class="contentContainer">
       
		 <iframe name="main_info" style="border:none;" onload="ResizeIframe(this);" frameborder="no" src="mix_news_popCourse.php" height="2000" scrolling="no"></iframe>
      </div>

 <div class="rightContainer"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/right_top.gif" border="0" />


  <div class="menubar">
   <div class="linkcontainer1"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/rightlink_top.gif" border="0" />

	  <div align="center"><font size="2">

	     <table width="140" bgcolor="#ffffff" ><tr><td> <img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon.gif" /></span> 今日人氣:共 <font color="#FF6600"><?php echo $this->_tpl_vars['p_today']; ?>
</font>人</td></tr>

	      <tr><td><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon.gif" /></span> 本月人氣:共 <font color="#FF6600"><?php echo $this->_tpl_vars['p_month']; ?>
</font>人</td></tr>

	      <tr><td><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/icon.gif" /></span> 累計人氣:共 <font color="#FF6600"><?php echo $this->_tpl_vars['p_total']; ?>
</font>人</td></tr></table>

	      </font></div><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/rightlink_down.gif" border="0" /></div>
		   <div class="linkcontainer1"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/rightlink_top.gif" border="0" />
	    <div class="linkitemright"><a href="./Other/about.html" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item001.gif" alt="關於本站" border="0" width="160px" /></a>
	    </div>
	  	<div class="linkitemright"><a href="Guest_Book/index.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item002.gif" alt="留言版" border="0" width="160px" /></a>
	  	</div>
        <div class="linkitemright"><a href="./Other/teacher.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item009.gif" alt="教師社群專區" border="0" width="160px" /></a>
	  	</div>
		<div class="linkitemright"><a href="./Other/links.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item005.gif" alt="網站連結" border="0" width="160px" /></a>
	    </div>
	  	<div class="linkitemright"><a href="Other/suggest.php" target="main_info"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item003.gif" alt="瀏覽建議" border="0" width="160px" /></a>
	  	</div>
        <?php if ($this->_tpl_vars['UPS_ONLY'] == true): ?>
        <div class="linkitemright"><a href="/project_home/Install_Service/" target="_blank"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item006.gif" alt="平台安裝服務" border="0" width="160px" /></a>
        </div>
        <div class="linkitemright"><a href="/project_home" target="_blank"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item007.gif" alt="原始碼下載" border="0" width="160px"></a>
	  	</div>
        <?php endif; ?>
        <div class="linkitemright"><a href="Apply_Course/index.php" target="_blank"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item008.gif" alt="課程管理系統" border="0" width="160px"></a>
	  	</div>
        <?php if ($this->_tpl_vars['UPS_ONLY'] == true): ?>
        <div class="linkitemright"><a href="Registration/joinArticle.php?t=1" target="_blank"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item010.gif" alt="教師帳號註冊" border="0" width="160px"></a>
        </div>
        <?php endif; ?>
	  	<!--<div class="linkitemright"><a href="management.pdf" target="_blank"><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/item004.gif" alt="管理要點" border="0" width="160px" /></a>
	  	</div>-->
    
	 
    </div><div><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/rightlink_down.gif" border="0" /></div>
    <div><img src="<?php echo $this->_tpl_vars['webroot']; ?>
images/index/right_down.gif" border="0" /></div>

   </div>
 </div>

		<div class="clear"></div>


	</div> <!-- mainContainerEnd -->
  <div class="footer">

      <hr/>2009 © 網站內容為教育部所有 未經許可 請勿任意轉載｜最佳瀏覽解析度 1024 x 768<br/>
        有任何問題請洽教育部｜聯絡專線：05-2720411 分機：33131 或 23141(週一至週五 9:00~12:00 13:30~17:30)<br/>
        註冊帳號無收到認證信，請點選<a href="http://ups.moe.edu.tw/report/">未收到認證信</a>回報，以便快速為您處理。
        E-mail：ups_moe@mail.moe.gov.tw</div>
  </div>


</body>

</html>
