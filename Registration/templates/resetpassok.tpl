<html>
<head>
<script language="Javascript">
{if $check eq 1}
    setTimeout("window.close();",5000);
{elseif $check eq 0}
    setTimeout("forget_jump()",3000);
{else}
    forget1();
{/if}
{literal}
function forget_jump()
{
    window.location.href="forgetpasswd.php";
}
{/literal}
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="css/register.css" rel="stylesheet" type="text/css" />
<title>重設密碼</title>
<body>

<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
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
<tr><td colspan="2" style="color:blue">step3</td></tr>
<tr>
    <td width="2000">
            {if $check eq 1}
            <div style="font-size:16px;color:blue;text-align:center">
                送信中... 請至信箱收取密碼<br/>
                網頁將在5秒後自動關閉...
            </div>
            {elseif $check eq 0}
            <div style="font-size:16px;color:red;text-align:center">
                帳號與申請信箱不符！<br/>
                網頁將在3秒後回到忘記密碼頁面...
            </div>
            {else}
            <div style="font-size:16px;color:red;text-align:center">
                請由正常程序進行流程！
            </div>
            {/if}
    </td>
</tr>

<tr>
    <td width="200"></td>
    <td ></td>

<tr><td colspan="2" style="font-size:12px;color:red">
</td></tr>
<tr><td colspan="2" style="color:blue"></td></tr>
<tr><td colspan="2" style="color:blue"></br></br>
</td></tr>
<tr>
    <td><div style="font-size:12px;color:red"></br></div></td>
    <td><br/><div style="font-size:12px"></div></td>
</tr>

<tr>
    <td colspan="2">
    <div style="text-align:center">
    </div>
<tr>
    <td colspan="2">
    <div style="font-size:12px; text-align:center;color:red">
    </div>
    </td>
</tr>
    </div>
    </td>
</tr>
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
