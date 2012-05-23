<?php
//下面這行就可以使用 cyberccu2 原本的 session
//require('/home/zoe/WWW/session.php');
require('../../../../session.php');
$begin_course_cd_before = $_SESSION['begin_course_cd'];
$personal_id_before = $_SESSION['personal_id'];
//print '<pre>';
//print_r($_SESSION);

//下面這行就會改採用 moodle 的 session
require_once("../../config.php");
require_once('locallib.php');

$_SESSION['begin_course_cd']= $begin_course_cd_before ; 
$_SESSION['personal_id']= $personal_id_before ;
$begin_course_cd=$_SESSION['begin_course_cd'];
$personal_id=$_SESSION['personal_id'];
//從begin_course_cd查content_cd
$sql = "select content_cd  from class_content_current where begin_course_cd = $begin_course_cd";
$content_cd = db_getOne($sql);
//從content_cd查scorm_id
$sql = "select id  from mdl_scorm  where content_cd ='$content_cd'";
$scorm_id= db_getOne($sql);

?>
<html>
<head>
<script type="text/javascript">
function openWin()
  {
    //--------------joyce edit 0501----------------------------- 
    var msg = "以下幾點操作事項請您務必注意：\n\n";
        msg += "1.瀏覽跳出教材時請勿把主視窗關閉，否則會無法紀錄您的時數。\n\n";
        msg += "2.為使您的時數正確紀錄，使用閱讀子視窗在教材播放時，主視窗請不要任意點選其他連結。\n\n";
        msg += "3.為避免閱讀時數無法記錄，請於登出前將閱讀子視窗關閉。";
    alert(msg);
    //---------------------------------------------------------    
	  myWindow=window.open("","","fullscreen=3,resizable=yes,scrollbars=yes,left=1000,top=0");
      myWindow.location='./view.php?a=<?php echo $scorm_id?>';
  }
</script>
</head>
<body>

<input type="button" value="按此開啟&nbsp;&nbsp;scorm教材閱讀視窗" onclick="openWin()" />
<br /><br />
</body>
</html>
