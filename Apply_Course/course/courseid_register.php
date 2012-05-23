<? 
require_once("config.php");

$type = $_POST['type']; 
$org = $_POST['Courseid_org']; 
$id = $_POST['Courseid_id']; 
$password = $_POST['Courseid_password'];
$person = $_POST['Courseid_person'];  
$title = $_POST['Courseid_title']; 
$tel = $_POST['Courseid_tel']; 
$email = $_POST['Courseid_email']; 
$reason = $_POST['Courseid_reason']; 

$sql = "insert into register_course_id ( courseid_org, type, courseid_person, courseid_title, courseid_tel, courseid_email, courseid_id, courseid_password, courseid_reason) values ( '$org', '$type', '$person', '$title', '$tel','$email', '$id', '$password', '$reason' )";
$result = mysql_query($sql);

if($result){
echo "<center><B><br>已成功申請  ".$id."  此帳號!</B><center><p>";
echo "帳號審核需1~3個工作天,待平台管理員審核通過,會e-mail通知您!!";
echo "若有任何疑問,請連絡我們!";
}else{
echo "<center><B><br>申請  ".$id."  此帳號失敗!</B><center><p>";
echo "若有任何疑問,請連絡我們!";
}	

?>
<script>
	parent.location = "courseid_sucess.php";
</script>

<body>
</body>
</html>
