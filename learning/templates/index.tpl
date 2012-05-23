<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>教育部數位學習服務平台</title>

<link href="css/index/index0.css" rel="stylesheet" type="text/css" />
<link href="css/index/div.table.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/swfobject.js"></script>
<script type="text/javascript" src="scripts/personal.js"></script>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script language="JavaScript" src="scripts/overlib_mini.js"></script>
<script>
{literal}

function doSubmit(){
  document.login_form.submit();
}

function doClear(){
  document.login_form.reset();
}

$(document).ready(function() { 
        var options = { 
                target:'#output2',
                beforeSubmit:  showRequest,
                success:       showResponse
                      }; 
                                     
            $('#myForm').submit(function() { 
                $(this).ajaxSubmit(options); 
                return false; 
                }); 
}); 
function showRequest(formData, jqForm, options) { 
      var queryString = $.param(formData); 
          //alert('About to submit: \n\n' + queryString); 
              return true; 
} 
function showResponse(responseText, statusText)  { 
   
      //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
           //       '\n\nThe output div should have already been updated with the responseText.'); 
} 
function openWin(url,obj,doc)
        {
            obj.target="_blank";
            obj.href = encodeURI(url + doc);
            //obj.href = url + '\'' + escape(doc) + '\'';
            obj.click();
        }
{/literal}
</script>
</head>



<body>
<div class="outerContainer"> 
	<div class="bannerContainer">
<!--	<div class="outersitelink">
		<a target="_blank" href="#">相關網站連結</a>　|　 <a target="_blank" href="http://www.edu.tw">教育部</a>　|　<a target="_blank" href="#">網站導覽　</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</div> -->

	<div id="flashBanner"> </div>
	<script type="text/javascript">
		swfobject.embedSWF("images/index_top3.swf", "flashBanner", "850", "120", "9.0.0", "script/expressInstall.swf");	
	</script>

	</div>


	<div class="mainContainer">
	<div class="leftContainer">

		<!--  <div class="welcomeContainer">
		<div class="login_form">
		<div><form name="login_form" action="login_check.php" method="POST">
		<br><br><br>
					<div>帳號：<input name="login_id" style="width:60%;" type="text" value=""/></div>
					<div style="height:2px; font-size:2px"></div>
					<div>密碼：<input name="password" style="width:60%;" type="password" value="" /></div>
					<div style="font-size:2px !important; height:3px; font-size:3px;">&nbsp;</div>
					<div>
						<input class="input_48" type="button" onClick="doSubmit();"  value="登入" size="15">
						<input class="input_48" type="button" onClick="doClear();"   value="清除">		

					</div>
					<div style="height:3px; font-size:3px !important; height:5px; font-size:5px;"></div>
					<div>
						<input class="input_48" type="button" onclick="window.open('Registration/joinArticle.php');"  value="加入會員">
						<input class="input_48" type="button" onclick="window.open('Registration/forgetpasswd.php');" value="查詢密碼">
					</div>
					<div style="height:3px; font-size:3px !important; height:5px; font-size:5px;"></div>
						<input class="input_96" type="button" onclick="javascript:location='guestLogin.php'" value="以訪客身份登入">
					</div>
				</div>
			</div>	</form>-->
			<div class="menubar">

                        <p><a href="http://140.123.105.16/~phina/learning/webstatis/latest.html" target="_blank"><img src="../learning/images/index/aa001.gif" width="148" height="31" border="0" /></a>
                          <br />
                          <a href="#" onclick="$('div.rightContainer1').empty().append($('[name=main_info]').attr('src','courseSearch.php').height(511).width(540))"><img src="../learning/images/index/aa002.gif" width="148" height="31" border="0" /></a><br />
                        </p>
      </div>
	  </div>
  </div>
	
		<div id="output2" >
		<div class="rightContainer1">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000"></div>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<th scope="col" align="center" valign="top" width="700">
		<img src="images/taiwan.jpg" border="0" usemap="#MapMapMap" />
		
		<map name="MapMapMap" id="MapMapMap">
                  {foreach from=$city item=country }
                  <area shape="poly" coords="{$country.coords}"target="_blank" alt="" href="#" onclick="javascript:void(0)" onmouseover="return overlib('<ul><li><a target=_blank href={$country.url}>{$country.name}教學平台資源網</a></li><li><a target=_blank href={$country.url}>數位機會中心：</a></li>{foreach from=$country.doc item=v key=k}
				  {*<a href=\'angry.php?doc={$v|urlencode}\' target=_blank>{$v}</a><br />{foreachelse}{/foreach}', CAPTION, '所在縣市：{$country.name}',CENTER, WIDTH, 250,TEXTSIZE, 2,CAPTIONSIZE,3,STICKY);"onmouseout="return nd();"/> *}
                  				  <a href=javascript:void(0) onclick=openWin(\'{$country.doc_url[$k]}?banner=1&doc=\',this,\'{$country.doc[$k]}\') target=_blank>{$v}</a><br />{foreachelse}該縣市無任何的DOC單位{/foreach}', CAPTION, '所在縣市：{$country.name}',CENTER, WIDTH, 250,TEXTSIZE, 2,CAPTIONSIZE,3,STICKY);"onmouseout="return nd();"/>
                 
				  
				  {/foreach}
		</map> 
		</th>

	</tr>
</table>


		</div>
			<iframe name="main_info" style="border:none;" onload="" height="0" width="0" frameborder="no" src="#"  scrolling="no"></iframe>
  </div>
		<div class="clear"></div>

</div> <!-- mainContainerEnd -->

	
</div><div class="footer">
	2009 © 網站內容為教育部所有 未經許可 請勿任意轉載｜最佳瀏覽解析度 1024 x 768<br/>
	有任何問題請洽教育部｜客服專線：02-7712-9085｜E-mail：services@mail.moe.gov.tw
	</div>
</body>
</html>
