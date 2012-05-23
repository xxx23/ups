<?php
// 新增開課帳號
require_once('../config.php');
require_once('../library/filter.php');

$input = array(
	'category' => array('must', PARAM_INT), 
	'account'  => array('must', PARAM_TEXT), 
	'password' => array('must', PARAM_TEXT), 
	'org_title' => array('must', PARAM_TEXT), 
	'undertaker' => array('must', PARAM_TEXT), 
	'title'		=> array('must', PARAM_TEXT), 
	'tel'		=> array('must', PARAM_TEXT), 
	'email'		=> array('must', PARAM_TEXT), 
	'usage_note' => array('must', PARAM_TEXT)
); 


foreach($input as $k => $v){
	if( $v[0] == 'must')
		${$k} = required_param($k, $v[1]) ;	
}


//這兩個欄位跟category有關 需要另外判斷
 $city_cd = '';
 $school = '';
 if($category == '1' or $category == '2')
     $city_cd =  required_param('city_cd', PARAM_TEXT) ;

 if($category == '2')
     $school_cd = required_param('school_cd', PARAM_TEXT) ;

$sql = "insert into register_applycourse ( category, account, password, city_cd, school_cd, org_title, undertaker, identify, title, tel, email, usage_note)  "
	." values ( '$category', '$account', md5('$password'), '$city_cd','$school_cd','$org_title', '$undertaker', '', '$title','$tel','$email', '$usage_note')";
$result = db_query($sql);

//well_print($sql); 

if(!PEAR::isError($result)) { ?>
	<center><br/><B>已成功申請 <?php echo $account ?>  此帳號!</B><p>
	帳號審核需1~3個工作天,待平台管理員審核通過,會e-mail通知您!!
	若有任何疑問,請連絡我們!
	</center>

<?php	
}else{
?>
	<center><br/><B>申請 <?php echo $account?> 此帳號失敗!</B><p>
	若有任何疑問,請連絡我們!
	</center>
<?php
}
?>
<script>
function redirect() {
	location = "apply_begincourse_account.php"; 
}

setTimeout(redirect, 5000) ;
</script>
