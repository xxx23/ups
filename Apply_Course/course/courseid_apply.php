<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.or/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="./lib/jquery.js" type="text/javascript"></script>
	<script src="./lib/jquery.autocomplete.js" type="text/javascript"></script>
	<link href="css/index.css" rel="stylesheet" type="text/css" />
	<title>開課帳號申請</title>
	<script language="javascript" type="text/javascript">
		/*function login(){formlogin.submit();}*/
	</script>
	<style>
		#d1{display:none;color:#122333;}
		#d2{display:none;color:#122333;}
		#d3{display:none;color:#122333;}
	</style>
    <script src="reg.js"></script>
</head>
<body>
<h1>開課帳號申請</h1>
	<div>
	  <div align="center">step1.請先選擇開課帳號隸屬機構or單位
	    <select name="mySelect" id="mySelect">
	      <option selected>請選擇</option>
	      <option value="1">縣市政府</option>
	      <option value="2">大專院校</option>
	      <option value="3">數位機會中心輔導團隊</option>
        </select>
	    <br>
        <br>
        <br>
        </div>
	  <div id='d1'  class='forms'>
      <form name="form1" action="courseid_register.php" method="post">
		<table id="t1" width="506" border="1" align="center">
    		<caption>縣市政府</caption><input name="type" type="hidden" value="1">
            <tr><td>縣市政府單位名稱</td><td><input type="text" name="Courseid_org" id="Courseid_org" /></td></tr>
            <tr><td>開課帳號</td><td><input type="text" name="Courseid_id" id="Courseid_id" />
            <input type='button' name='submit1' value='是否有重覆帳號' onClick="return check_id(this.form.Courseid_id)">
            <iframe src="sendid.php" name="sendid" width='0%' height='0%'></iframe></td></tr>
			<tr><td>開課帳號密碼</td><td><input type="text" name="Courseid_password" id="Courseid_password" /></td></tr>
    		<tr><td>請確認您的密碼</td><td><input type="text" name="Courseid_password2" id="Courseid_password2" /></td></tr>
    		<tr><td>聯絡人</td><td><label><input type="text" name="Courseid_person" id="Courseid_person" /></label></td></tr>
    		<tr><td>職稱</td><td><input type="text" name="Courseid_title" id="Courseid_title" /></td></tr>
    		<tr><td>聯絡電話</td><td><input type="text" name="Courseid_tel" id="Courseid_tel" /></td></tr>
    		<tr><td>E-mail</td><td><input type="text" name="Courseid_email" id="Courseid_email" /></td></tr>
    		<tr><td><p>帳號申請用途</p><p>(請詳填，供審核人員檢核)</p></td>
    		<td><label><textarea name="Courseid_reason" id="Courseid_reason" cols="45" rows="5"></textarea></label></td> </tr>
	    </table>
		<p align="center"><label><input type="submit" name="button" id="button" value="送出" onClick="validateForm(this.form)"></label></p>
      </form>
	</div>
	
	<div id='d2'  class='forms'>
      <form name="form1">
		<table id="t2" width="506" border="1" align="center">
	   		<caption>大專院校</caption><input name="type" type="hidden" value="3">
            <tr><td>申請單位名稱</td><td><input type="text" name="Courseid_org" id="Courseid_org" /></td></tr>
        	<tr><td>開課帳號</td><td><input type="text" name="Courseid_id" id="Courseid_id" />
            <input type='button' name='submit1' value='是否有重覆帳號' onClick="return check_id(this.form.Courseid_id)">
            <iframe src="sendid.php" name="sendid" width='0%' height='0%'></iframe></td></tr>
			<tr><td>開課帳號密碼</td><td><input type="text" name="Courseid_password" id="Courseid_password" /></td></tr>
    		<tr><td>請確認您的密碼</td><td><input type="text" name="Courseid_password2" id="Courseid_password2" /></td></tr>
    		<tr><td>聯絡人</td><td><label><input type="text" name="Courseid_person" id="Courseid_person" /></label></td></tr>
    		<tr><td>職稱</td><td><input type="text" name="Courseid_title" id="Courseid_title" /></td></tr>
    		<tr><td>聯絡電話</td><td><input type="text" name="Courseid_tel" id="Courseid_tel" /></td></tr>
    		<tr><td>E-mail</td><td><input type="text" name="Courseid_email" id="Courseid_email" /></td></tr>
    		<tr><td><p>帳號申請用途</p><p>(請詳填，供審核人員檢核)</p></td>
    		<td><label><textarea name="Courseid_reason" id="Courseid_reason" cols="45" rows="5"></textarea></label></td> </tr>
	    </table>
		<p align="center"><label><input type="submit" name="button" id="button" value="送出"></label></p>
      </form>
	</div>
    
	<div id='d3'  class='forms'>
      數位機會中心輔導團隊:帳號已核發至各輔導團隊,若有問題請洽該輔導團隊,或與我們連絡。
	</div>
	
	</div>

<script language="javascript">

$("#mySelect").change(function() {
		var n=$("#mySelect").val();
		$('.forms').hide();
		$('#d'+n).show();
});

	
</script>
</body>
</html>
