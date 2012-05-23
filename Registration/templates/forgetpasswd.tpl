<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="css/register.css" rel="stylesheet" type="text/css" />
<title>忘記密碼</title>	
<script>alert("若您的帳號還未啟用成功或信箱填寫不正確，請勿點選『系統重設密碼』，避免您的密碼被重新設定後，您的信箱無法收到修改後的密碼。");</script>
</head>
<body>

<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="￥?cR|W" fwbase="001.jpg" fwstyle="Dreamweaver" fwdocid = "2142844055" fwnested="0" -->
  <tr>
   <td width="23"><img src="../images/registration/spacer.gif" width="23" height="1" border="0" alt=""></td>
   <td width="899"><img src="../images/registration/spacer.gif" width="607" height="1" border="0" alt=""></td>
   <td width="10"><img src="../images/registration/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td width="22"><img src="../images/registration/spacer.gif" width="22" height="1" border="0" alt=""></td>
   <td width="4"><img src="../images/registration/spacer.gif" width="4" height="1" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23" background="images/registration/001_r2_c4.jpg"><img name="n001_r2_c2" src="../images/registration/001_r2_c2.jpg" width="23" height="36" border="0" alt=""></td>
   <td colspan="2" background="../images/registration/001_r2_c4.jpg"><img name="n001_r2_c3" src="../images/registration/005_r2_c3.jpg" width="607" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c5" src="../images/registration/001_r2_c5.jpg" width="22" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c6" src="../images/registration/001_r2_c6.jpg" width="4" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23" background="../images/registration/001_r3_c2.jpg">&nbsp;</td>
   <td colspan="2"><div align="center"><img name="registerforget" src="../images/registration/registerforget.jpg"></div>
   <td colspan="2" background="../images/registration/001_r3_c5.jpg"><img name="n001_r3_c6" src="../images/registration/001_r3_c6.jpg" width="4" height="7" border="0" alt=""></td>
   </td>
  </tr>
  <tr>
  <td width="23" background="../images/registration/001_r3_c2.jpg">&nbsp;</td>
   <td colspan="2"><hr style="color:#89aacc"></td>
   <td colspan="2" background="../images/registration/001_r3_c5.jpg"><img name="n001_r3_c6" src="../images/registration/001_r3_c6.jpg" width="4" height="7" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23" background="../images/registration/001_r3_c2.jpg">&nbsp;</td>
   <td colspan="2">
   <table class="datatable" width="550" border=0 align="center">
<form action="{$thisaction}" method="POST" target="_self">
<tr><td colspan="2" style="color:blue">{if isset($hint)}step2{else}step1{/if}</td></tr>
<tr>
    {if isset ($hint) }
    <td width="200">您的帳號為</td>
    <td><input type="hidden" name="id" value="{$id|escape}" readonly />
    <div>{$id}</div></td>
    {else}
    <td width="200">請輸入帳號</td>
    <td ><input type="text" name="id" value="{$id|escape}" {$id_readonly} /><br/><div style="font-size:12px;color:red">{$id_errmsg|escape}</div></td>
    {/if}
</tr>

{if  isset($hint)  }

<tr>
    <td width="200">您的密碼提示為</td>
    <td >{$hint}</td>

<tr><td colspan="2" style="font-size:12px;color:red">
</td></tr>
<tr><td colspan="2" style="color:blue"></td></tr>
<tr><td colspan="2" style="color:blue"></br>＊ 若您還是想不起您的密碼 ...</br>
</td></tr>
{/if}
<tr>
{if  $email_check eq 1 }
    <td>請再次確認所填的E-mail<div style="font-size:12px;color:red"></div></td>
    <td><input type="hidden" name="email" value="{$email|escape}" readonly /><div>{$email}</div></td>
{else}
    <td>請輸入註冊所填的E-mail<div style="font-size:12px;color:red">(若您註冊時所填的email有誤，</br>請與網站管理者聯繫)</div></td>
    <td><input type="text" name="email" value="{$email|escape}" /><div style="font-size:12px;color:red">{$email_errmsg|escape}</div></td>
{/if}
</tr>

<tr>
    <td colspan="2">
	<div style="text-align:center">
    {if isset($hint) }
	<input type="submit" value="系統重設密碼"/>&nbsp;&nbsp;&nbsp;
    {else}
	<input type="submit" value="密碼提示查詢"/>&nbsp;&nbsp;&nbsp;
    {/if}
	<input type="button" value="重填" onclick="window.location.href='forgetpasswd.php'"/>

{if isset($confirm) }
<tr>
    <td colspan="2">
	<div style="font-size:12px; text-align:center">
		{$prompt|escape}按下【系統重設密碼】將會寄出新密碼至您註冊時所填的信箱。
	</div>
	</td>
</tr>
{/if}

	</div>
	</td>
</tr>
<input type="hidden" name="code_state" value="{$code_state}"/>
</form>
</table>
   <p>&nbsp;</p></td>
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
