<?php 
require_once('../config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" /> 
<link href="css/register.css" rel="stylesheet" type="text/css" /> 
<script>


</script>

<style type="text/css"> 
.mytable th{
	font-size:10pt;
	text-align: center;
 
	border-width: 1px;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;
 
        border-top-color: gray;
        border-right-color: gray;
        border-bottom-color: gray;
        border-left-color: gray;
 
}
.mytable td{
	font-size:10pt;
	text-align: left;
 
	border-width: 1px;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;
 
        border-top-color: gray;
        border-right-color: gray;
        border-bottom-color: gray;
        border-left-color: gray;
 
}

</style> 
</head>

<body>
<p align="center"><img src="../images/registration/step2.jpg" width="475" height="119" /></p>
<table cellspacing="0" cellpadding="0" width="75%" align="center">
  <tbody>
    <tr>
      <td width="23"><img border="0" alt="" src="../images/registration/spacer.gif" width="23" height="1" /></td>
      <td width="899"><img border="0" alt="" src="../images/registration/spacer.gif" width="607" height="1" /></td>
      <td width="10"><img border="0" alt="" src="../images/registration/spacer.gif" width="7" height="1" /></td>
      <td width="22"><img border="0" alt="" src="../images/registration/spacer.gif" width="22" height="1" /></td>
      <td width="4"><img border="0" alt="" src="../images/registration/spacer.gif" width="4" height="1" /></td>
    </tr>
    <tr>
      <td background="images/registration/001_r2_c4.jpg" width="23"><img src="../images/registration/001_r2_c2.jpg" alt="" name="n001_r2_c2" width="23" height="36" border="0" id="n001_r2_c2" /></td>
      <td background="../images/registration/001_r2_c4.jpg" width="100%" colspan="2"><img src="../images/registration/003_r2_c3.jpg" alt="" name="n001_r2_c3" width="607" height="36" border="0" id="n001_r2_c3" /></td>
      <td><img src="../images/registration/001_r2_c5.jpg" alt="" name="n001_r2_c5" width="22" height="36" border="0" id="n001_r2_c5" /></td>
      <td><img src="../images/registration/001_r2_c6.jpg" alt="" name="n001_r2_c6" width="4" height="36" border="0" id="n001_r2_c6" /></td>
    </tr>
    <tr>
      <td background="../images/registration/001_r3_c2.jpg" width="23"> </td>
      <td colspan="2"><center>
        <!-- form -->
        <form action="validateProfile.php?validationType=php" method="post" name="frmRegistration" id="frmRegistration" onkeypress=" return disableEnterKey(event);">
          <table class="mytable">
            <!--*姓名 -->
            <tbody>
              <tr>
                <th width="200">*姓名 </th>
                <td><input onblur="validate(this.value, this.id);" id="txtName" name="txtName" />
                </td>
              </tr>
              <!--*身分 -->
              <tr>
                <th>*身分 </th>
                <td><label>
                  <select id="dist_cd" name="dist_cd">
                    <option label="國民中小學教師" value="1">國民中小學教師 </option>
                    <option label="高中職教師" value="2">高中職教師</option>
                    <option label="大專院校教師" value="4">大專院校教師</option>
                    <option label="數位機會中心輔導團隊講師" value="5">數位機會中心輔導團隊講師</option>
                    <option label="縣市政府研習課程老師" value="6">縣市政府研習課程老師</option>
                    <option label="其他" value="7">其他</option>
                  </select>
                </label>
                 </td>
              </tr>
              <!--職稱-->
              <!--暱稱 -->
              <tr>
                <th>暱稱 </th>
                <td><input id="txtNickname" name="txtNickname" />
                </td>
              </tr>
              <!-- *身份證或護照號碼-->
              <tr>
                <th>*身分證字號/護照號碼 </th>
                <td><input id="idorpas1" onclick="checkSelect(this);" value="0" checked="checked" type="radio" name="idorpas" />
                  身分證
                  <input id="idorpas2" onclick="checkSelect(this)" value="1" type="radio" name="idorpas" ; />
                  護照號碼
                  <!--要是身份證顯示-->
                  <input onblur="validate(this.value, this.id);" id="txtID" name="txtID" />
                  <!--要是護照號碼顯示--></td>
              </tr>
              <!-- *教師證號 -->
              <!--*性別 -->
              <tr>
                <th>*性別</th>
                <td><input id="selGender_male" value="1" type="radio" name="selGender" />
                  男
                  <input id="selGender_female" value="0" checked="checked" type="radio" name="selGender" />
                  女 </td>
              </tr>
              <!--*身分別 -->
              <!--*連絡電話 -->
              <tr>
                <th>*聯絡電話</th>
                <td><input onblur="validate(this.value, this.id);" id="txtTel" name="txtTel" />
                   
                  例:02-27225777-2321</td>
              </tr>
              <!--*電子信箱 -->
              <tr>
                <th>*電子信箱</th>
                <td><input onblur="validate(this.value, this.id);" id="txtEmail" size="52" name="txtEmail" />
                      <br />
                  （為了避免認證信件被阻擋，建議不要使用免費信箱，例如：Yahoo／Hotmail信箱） <span id="txtEmailFailed">格式錯誤或此欄空白</span></td>
              </tr>
              <!--郵遞區號-->
              <tr>
                <th>郵遞區號</th>
                <td><input onblur="validate(this.value, this.id);" id="txtZoneCd" size="8" name="txtZoneCd" />
                      <!--<span id="txtZoneCdFailed" class="hidden" >此欄空白</span> --></td>
              </tr>
              <!-- 通訊地址-->
              <tr>
                <th>通訊地址 </th>
                <td><div>
                  <input onblur="validate(this.value, this.id);" id="txtAddr" size="52" name="txtAddr" autocomplete="off" />
                 </div>
                      <div id="selAddr"></div></td>
              </tr>
              <!-- 所在縣市 -->
              <tr>
                <th>*所在縣市 </th>
                <td><select id="selCity" onchange="checkSelect(this);" name="selCity" onload="checkSelect(this);">
                  <option label="請選擇" selected="selected" value="-1">請選擇</option>
                  <option label="基隆市" value="1">基隆市</option>
                  <option label="台北縣" value="2">台北縣</option>
                  <option label="台北市" value="3">台北市</option>
                  <option label="桃園縣" value="4">桃園縣</option>
                  <option label="新竹縣" value="5">新竹縣</option>
                  <option label="新竹市" value="6">新竹市</option>
                  <option label="苗栗縣" value="7">苗栗縣</option>
                  <option label="台中縣" value="8">台中縣</option>
                  <option label="台中市" value="9">台中市</option>
                  <option label="彰化縣" value="10">彰化縣</option>
                  <option label="雲林縣" value="11">雲林縣</option>
                  <option label="嘉義縣" value="12">嘉義縣</option>
                  <option label="嘉義市" value="13">嘉義市</option>
                  <option label="台南縣" value="14">台南縣</option>
                  <option label="台南市" value="15">台南市</option>
                  <option label="高雄縣" value="16">高雄縣</option>
                  <option label="高雄市" value="17">高雄市</option>
                  <option label="屏東縣" value="18">屏東縣</option>
                  <option label="澎湖縣" value="19">澎湖縣</option>
                  <option label="南投縣" value="20">南投縣</option>
                  <option label="宜蘭縣" value="21">宜蘭縣</option>
                  <option label="花蓮縣" value="22">花蓮縣</option>
                  <option label="台東縣" value="23">台東縣</option>
                  <option label="金門縣" value="24">金門縣</option>
                  <option label="連江縣" value="25">連江縣</option>
                </select>
                      <span id="selCityFailed">請選擇</span> </td>
              </tr>
              <!--*數位機會中心-->
              <!--*各級學校-->
              <!--有選擇角色及是所選擇的角色不等於一般民眾-->
              <!--.職業 -->
              <!-- 當職業選擇一般民眾時，才顯示此項目 -->
              <!--所屬單位 -->
              <!-- 當身分選擇一般民眾時，則自行填寫 -->
              <!--個人學歷-->
              <tr>
                <th>學歷 </th>
                <td><!--當身分選擇一般民眾時,全部可選-->
                   
                  （請勾選與本身學歷相當程度選項）<br />
                  <!--當身分選擇教師及學生時,只有底下可選-->
                  <input value="2" type="radio" name="degree" />
                  高中職 
                  <input value="3" type="radio" name="degree" />
                  專科學校 
                  <input value="4" type="radio" name="degree" />
                  大學 
                  <input value="5" type="radio" name="degree" />
                  研究所以上  </td>
              </tr>
              <!--有興趣課程類別-->
              <tr>
                <th>請勾選您有興趣的課程類別 </th>
                <td><input value="1" type="checkbox" name="interest[0]" />
                  電腦入門課程 <br />
                  <input value="1" type="checkbox" name="interest[1]" />
                  資訊技能課程 <br />
                  <input value="1" type="checkbox" name="interest[2]" />
                  資訊融入教學課程 <br />
                  <input value="1" type="checkbox" name="interest[3]" />
                  資訊倫理課程 <br />
                  <input value="1" type="checkbox" name="interest[4]" />
                  資訊安全課程 <br />
                  <input onclick="checkSelect(this);" value="1" type="checkbox" name="interest[5]" />
                  其他  </td>
              </tr>
              <!-- 23.是否接收最新消息通知-->
              <tr>
                <th>是否接收最新消息通知 </th>
                <td><input value="1" checked="checked" type="radio" name="recnews" />
                  同意  
                  <input value="0" type="radio" name="recnews" />
                  不同意 </td>
              </tr>
            </tbody>
          </table>
          <!-- 按鈕-->
          <div>注意：所有的*號欄位都填了嗎？
            <input value="確定送出" type="submit" name="submitbutton" />
                <br />
            <br />
            <br />
          </div>
        </form>
      </center></td>
      <td background="../images/registration/001_r3_c5.jpg" colspan="2"><img src="../images/registration/001_r3_c6.jpg" alt="" name="n001_r3_c6" width="4" height="7" border="0" id="n001_r3_c6" /></td>
    </tr>
    <tr>
      <td width="23"><img src="../images/registration/001_r5_c2.jpg" alt="" name="n001_r5_c2" width="23" height="21" border="0" id="n001_r5_c2" /></td>
      <td background="../images/registration/001_r5_c4.jpg" colspan="2"><img src="../images/registration/001_r5_c4.jpg" alt="" name="n001_r5_c4" width="7" height="21" border="0" id="n001_r5_c4" /></td>
      <td><img src="../images/registration/001_r5_c5.jpg" alt="" name="n001_r5_c5" width="22" height="21" border="0" id="n001_r5_c5" /></td>
      <td><img src="../images/registration/001_r5_c6.jpg" alt="" name="n001_r5_c6" width="4" height="21" border="0" id="n001_r5_c6" /></td>
    </tr>
  </tbody>
</table>
</body>
</html>
