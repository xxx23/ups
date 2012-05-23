<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>啟用帳號</title>
<meta http-equiv="refresh" content="3; url=../index.php">
</head>
<body>
   {if $validateUser eq 0}
     帳號啟動失敗，請確定您是依正常的程序啟動帳號!
   {elseif $validateUser eq 1}
    恭喜您! 帳號已啟用成功!!<br>
    您可以由本平台首頁登入本系統!<br>
    本頁將在3秒後，自動轉向平台首頁<br>
    如3秒後沒轉向本台首頁，請點選下方開始使用按鈕<br>
    <input type="button" value="開始使用" onClick="document.location.href='../index.php'">
   {/if}
</body>
</html>
