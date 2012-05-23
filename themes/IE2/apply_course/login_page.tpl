<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教育部數位學習服務平台課程管理系統</title>
<!--<link rel="stylesheet" type="text/css" href="../css/apply_course.css" /> -->
<link rel="stylesheet" type="text/css" href="{$tpl_path}/css/apply_course.css" />

<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->

{literal}

<script type="text/javascript">
function resizeFrame() {
  // Get height of iframe once it has loaded content and then
  // use this for the iframe height in parent doc
  var addictional_height = 150;
  var f = document.getElementById('content');
  var left_div = document.getElementById('left_content');
  f.style.height = (f.contentWindow.document.body.scrollHeight + addictional_height )+ "px";
  left_div.style.height = f.style.height ;
  //alert("123");
}
</script>
{/literal}


</head>
<body>

<div id="main_container2">
	<div id="header2">
		<div id="logo"><a href="index.php"><img src="{$tpl_path}/images/apply_course/logo.png" alt="" title="" border="0" width="250" height="61" /></a></div>
		<div class="top_phone">
			<img src="{$tpl_path}/images/apply_course/phone_arrows.png" alt="" title="" class="left" width="49" height="32" />
			<div class="phone_text">
			  <p>hi 您好,您已登入　<input name="" type="button" onClick="javascript:location.href='login_check.php?logout=true'" value="登出"/></p>
			  <p>&nbsp;</p>
			  <p>單位:{$org_title}</p>
			  <p>帳號: {$account} <br/>
			  </p>
			  
			</div>
		</div>
	</div>
	
	<!--左邊欄-->
	<div name="big_content">
		<div id="left_content"> 
			<dl>
			{foreach from=$menu_ctrl key=group_title item=row_data}
				<dt>{$group_title}</dt>
				{foreach from=$row_data key=url item=url_name}
				<dd> <a href="{$url}" target="content">{$url_name}</a> 	</dd>
				{/foreach}
				<br/>
			{/foreach}
			</dl>
		<!-- main_content-->
		</div> 
		<div id="main_content2">
			<iframe id="content" name="content" frameborder="0" scrolling="auto"  src="{$default_page}" onload="resizeFrame()" style="border:0; width:99%; height:99%"></iframe>
		</div>		
	</div> 
	
	<div id="footer2">
	   <div class="left_footer">
		 <p>2009 © 網站內容為教育部所有 未經許可 請勿任意轉載｜最佳瀏覽解析度 1024 x 768 </p>
		 <p>有任何問題請洽教育部｜聯絡專線：05-2720411#33131｜E-mail：ups_moe@mail.moe.gov.tw</p>
	   </div>
	   <div class="right_footer"> <a href="http://www.edu.tw" target="_blank">教育部</a> <a href="http://ups.moe.edu.tw" target="_blank">教育部數位學習服務平台</a> </div>
	</div>
</div> 

</body>
</html>
