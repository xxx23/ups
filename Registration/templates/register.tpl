<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="css/register.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script/validate.js"></script>
<title>註冊帳號</title>	
</head>
<body bgcolor="#ffffff">
<p align="center"><img src="../images/registration/step1.jpg" width="475" height="119"></p>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="¥¼©R¦W" fwbase="001.jpg" fwstyle="Dreamweaver" fwdocid = "2142844055" fwnested="0" -->
  <tr>
   <td width="23"><img src="../images/registration/spacer.gif" width="23" height="1" border="0" alt=""></td>
   <td width="899"><img src="../images/registration/spacer.gif" width="607" height="1" border="0" alt=""></td>
   <td width="10"><img src="../images/registration/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td width="22"><img src="../images/registration/spacer.gif" width="22" height="1" border="0" alt=""></td>
   <td width="4"><img src="../images/registration/spacer.gif" width="4" height="1" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23"><img name="n001_r2_c2" src="../images/registration/001_r2_c2.jpg" width="23" height="36" border="0" alt=""></td>
   <td colspan="2" background="../images/registration/001_r2_c4.jpg"><img name="n001_r2_c3" src="../images/registration/002_r2_c3.jpg" width="607" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c5" src="../images/registration/001_r2_c5.jpg" width="22" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c6" src="../images/registration/001_r2_c6.jpg" width="4" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23" background="../images/registration/001_r3_c2.jpg"><div style="width:21px"> </div></td>
   <td colspan="2" width="99%"><center>
   <form name="frmRegistration" method="post" action="validate.php?validationType=php">
  <table class="datatable">
  <tr>
    <th width="120"><img src="../themes/IE2/images/th_head.png" width="12" height="54" align="absmiddle"/>帳號</th>
	  <td>
	    <input id="txtUsername" name="txtUsername" type="text" onBlur="validate(this.value, this.id);"  value="{$valueOfUsername}" maxlength="20" />
	    <span id="txtUsernameFailed" class="{$txtUsernameFailed}" >*已經被使用，或是空白，或是含有特殊字元*</span>      </td>
  </tr>
  <tr>
    <th width="120"><img src="../themes/IE2/images/th_head.png" width="12" height="54" align="absmiddle"/>密碼</th>
	  <td nowrap>
	  	<div style="position:relative">
	    <input id="txtPassword" name="txtPassword" type="password" onBlur="validate(this.value, this.id);" value="{$valueOfPassword}" />
	    (8碼以上之英數字，切勿用全形，英文有大小寫之分，避免用生日)&nbsp;&nbsp;&nbsp;&nbsp;
	    <span id="txtPasswordFailed" class="{$txtPasswordFailed}" >*密碼請輸入超過 8 碼*</span>      
	    <span style="position:absolute; left:600px; top:0px"></span>
  		</div>
	  </td>
  </tr>
  <tr>
    <th width="120"><img src="../themes/IE2/images/th_head.png" width="12" height="54" align="absmiddle"/>再次確認</th>
	  <td>
	    <input id="txtCkPassword" name="txtCkPassword" type="password" onBlur="validate2(this.value , document.getElementById('txtPassword').value , this.id);" value="{$valueOfCkPassword}" />
	    <span>(請再輸入一次密碼加以確認)</span>
	    <span id="txtCkPasswordFailed" class="{$txtCkPasswordFailed}" >*與密碼不同，或是空白*</span>      </td>
  </tr>
  <tr>
    <th width="120"><img src="../themes/IE2/images/th_head.png" width="12" height="54" align="absmiddle"/>密碼提示</th>
	  <td>
	    <input id="txtPasswordInfo" name="txtPasswordInfo" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfPasswordInfo}" />
	    <span>(請填寫與密碼相關內容，幫助自己聯想。如：我的英文名字，身高等)</span>
	    <span id="txtPasswordInfoFailed" class="{$txtPasswordInfoFailed}" >*密碼提示尚未填入*<!--此欄空白--></span>      </td>
  </tr>
  </table>
  <p class="al-left"><span class="txtSmall">注意：所有的欄位都填了嗎？</span>
  <input type="submit" name="submitbutton" value="註冊"/></p>
</form>
   </center></td>
   <td colspan="2" background="../images/registration/001_r3_c5.jpg"><img name="n001_r3_c6" src="../images/registration/001_r3_c6.jpg" width="4" height="7" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23"><img name="n001_r5_c2" src="../images/registration/001_r5_c2.jpg" width="23" height="21" border="0" alt=""></td>
   <td colspan="2" background="../images/registration/001_r5_c4.jpg"><img name="n001_r5_c4" src="../images/registration/001_r5_c4.jpg" width="7" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c5" src="../images/registration/001_r5_c5.jpg" width="22" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c6" src="../images/registration/001_r5_c6.jpg" width="4" height="21" border="0" alt=""></td>
  </tr>
</table>
</body>
</html>

