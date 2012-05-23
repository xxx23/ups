<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教育部數位學習服務平台 課程管理系統</title>
<link href="{$tpl_path}/css/apply_course.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />

<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
</head>
<body>

<div id="main_container">
	<div id="header">
    	<div id="logo"><a href="index.php"><img src="{$tpl_path}/images/apply_course/logo.png" alt="" title="" border="0" width="250" height="61" /></a></div>
    	<div class="top_phone">
        <img src="{$tpl_path}/images/apply_course/phone_arrows.png" alt="" title="" class="left" width="49" height="32" />
      	<div class="phone_text">	
			<form action="login_check.php" method="POST">
          <p>開課帳號登入</p>
          <p>帳號:
            <input name="account" type="text" id="account" size="15" value=""/>
          </p>
          <p>密碼:
            <input name="password" type="password" id="password" size="15" value="" />
          </p>
          <p>
            <input type="submit" name="button" id="submit" value="登入" />
            <input type="reset" name="button2" id="reset" value="重填" />
            <br/>
            <span><a href="apply_begincourse_account.php">申請開課帳號</a></span>
          </p>
			</form>
          </div>
        
      </div>
        
        </div>
    
  
            
    <div id="main_content">
 		<div class="boxes_tab">
        	<div class="box">
                    <img src="{$tpl_path}/images/apply_course/icon1.png" class="left_img" alt="" title="" width="96" height="99" />
                    <div class="box_text">
                    <h2><a href="#">開課申請</a></h2>
                    <p class="box_text">有開課需求的開課單位可於平台上提出開課申請作業,待審核成功後,即可在教育部教學服務平台上開課完成。</p>
              </div>
            </div>
            
        	<div class="box">
                    <img src="{$tpl_path}/images/apply_course/icon2.png" class="left_img" alt="" title="" width="96" height="99" />
                    <div class="box_text">
                    <h2><a href="#">學習資料統計查詢</a></h2>
                    <p class="box_text">提供有需求單位於系統中管理及查詢該單位或區域的學員修習課程狀況分析及統計。</p>
              </div>
            </div>            
            
        	<div class="box">
                    <img src="{$tpl_path}/images/apply_course/icon3.png" class="left_img" alt="" title="" width="96" height="99" />
                    <div class="box_text">
                    <h2><a href="#">管理作業</a></h2>
                    <p class="box_text">供部內帳號做開課審核作業與學習資料統計查詢功能。</p>
              </div>
            </div>            
            
        </div>
        
      <div class="clear"></div>
    <p>
    		<div class="intro">
        <ol>
<li><a href="../manual/9909apply_course.pdf">申請開課使用說明</a></li>
{*
<li>ccu  (開課帳號) </li>
<li>chaiyi (開課帳號) </li>
<li>taipei (開課帳號) </li>
<li>dpdoc (開課帳號) </li>
<li>moe9056 教育部電算中心-學習組(審核課程) </li>
<li>moe9053 教育部電算中心-資教組(審核課程、統計報表) </li>
<li>moe9081 教育部電算中心-資源組(審核課程、統計報表) </li>
*}
</ol>
</div>
 
    </div><!-- main_content-->  
    
    <div id="footer">
      <div class="left_footer">
          <p>2009 © 網站內容為教育部所有 未經許可 請勿任意轉載｜最佳瀏覽解析度 1024 x 768            </p>
          <p>有任何問題請洽教育部｜聯絡專線：05-2720411#33131｜E-mail：ups_moe@mail.moe.gov.tw</p>
      </div>
      <div class="right_footer">
        <a href="http://www.edu.tw" target="_blank">教育部</a>
        <a href="{$webroot}" target="_blank">教育部數位學習服務平台</a>
        </div>
    </div>

</div>
</body>
</html>
