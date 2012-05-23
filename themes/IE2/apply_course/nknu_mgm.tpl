<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html > 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <link href="../css/font_style.css" rel="stylesheet" type="text/css" /> 
    <link href="../css/table.css" rel="stylesheet" type="text/css" /> 
    <link href="../css/form.css" rel="stylesheet" type="text/css" />  
    <link href="../css/content.css" rel="stylesheet" type="text/css" /> 
    <link type="text/css" href="../css/jquery/jquery-ui-1.7.2.custom_1.css" rel="stylesheet" /> 
<script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script> 
<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script> 
<title>認證時數傳送管理</title>
<script type="text/javascript">
{literal}
    $(document).ready(function(){
        $('#tabs').tabs();
        $(this).bind('resize',function(){
             setTimeout(function(){resizeParentIframe();},200);
        });
        //resizeParentIframe();
    });
    
    function resizeParentIframe()
	{
	//	alert("resizing..."+$(document.body).height());
        var theFrame = $('#main_info', window.parent.document.body);
		if($(document.body).height()!=0)
            theFrame.height($(document.body).height());
        else setTimeout(function(){resizeParentIframe();},200);
	}

{/literal}
</script>
</head>
<body>
<h1>研習時數傳送管理</h1>
<!-- ACTION MESSAGE-->
<div align="center">{$actionMessage}</div>
<!-- ACTION MENU-->
<div class="searchbar" style="width:80%;margin:auto auto;">
    <div class="searchlist" style="margin:auto auto">
        <div class="button001">
        <a href="nknu_mgm.php?action=resend">傳送認證</a>
        </div>
    </div>
    <div class="searchlist" style="margin:auto auto">
        <div class="button001">
        <a target="_blank"href="http://140.127.49.137">資訊傳報系統</a> 
        </div>
    </div>
    <div class="describe">
    <ol>
         <li>平台研習時數認證資料，每晚會自動傳送至高師大 </li>
         <li>[傳送認證] 按鈕按下，平台會即時傳送時數認證資料至高師大，系統傳送中請，勿離開此頁面</li>
         <li>如果傳送有錯，按下[資訊傳報系統]按鈕，連結至高師大資訊傳報系統，以帳號密碼登入並修改</li>
         <li>下列[研習時數認證記錄]為上傳至高師大研習時數驗證的結果</li>
         <li>下列[傳送記錄]為系統存查的研習時數傳送記錄</li>
    </ol>
    </div>
</div>
<p><hr></p>
<!-- PAGER -->
<div id="tabs">
<ul>
    <li><a href="#tab1">時數資料驗證紀錄</a></li>
    <li><a href="#tab2">傳送紀錄</a></li>
</ul>
<div id="tab1">
	<iframe id="transfer_log" style="border:none;" frameborder="no" src="nknu_transfer_log.php" scrolling="no" width="100%" ></iframe>
</div><!--End fo tab1-->
<!-- COURSE INFO -->
<div id="tab2">
	<iframe id="course_log"  style="border:none;" frameborder="no" src="nknu_course_log.php" scrolling="no" width="100%" height="500"></iframe> 
</div>
<!-- SENDED VERIFY CHECK-->
<!-- RESEND -->

</div><!--end of div id= tabs-->
</body>
</html>
