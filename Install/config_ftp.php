<?php 

	if( !file_exists('../config.php') || filesize('../config.php') == 0) {
		header('Location: install2.php');
	}
	include('../config.php');
	$pureftpd_filename = 'pure-ftpd.conf';
	$pureftpd_mysql_filename = 'pureftpd-mysql.conf';
	$current_dir = getcwd();
	
	if( !is_writable('./') ){
		$flag_ftp_conf_cantwrite = true;
	}
	$pure_ftp_conf = create_ftp_config();
	if( file_put_contents($pureftpd_filename, $pure_ftp_conf) > 0 )
		$flag_ftp_conf_write_ok = true;
		
	
//---------------------------------------------------------------------------------------------//	

	if( !is_writable('./') ){
		$flag_ftp_mysql_conf_cantwrite = true;
	}
	$pure_ftp_mysql_conf = create_ftp_mysql_config();
	if( file_put_contents($pureftpd_mysql_filename, $pure_ftp_mysql_conf) > 0)
		$flag_ftp_mysql_conf_write_ok = true;
	

	
	
	$alert_string = '請將' . $current_dir . '改成可寫入';
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FTP configuration</title>
<head>
<style type="text/css">
#ftp_config {
	color: red;
	border: solid 2px;
	border-color: black;
}
#alert {
	background-color: pink;
	color: red
}
</style>
</head>
<body>

<h2>Pure-FTP Install configuration</h2>
<p> tar -zxvf pureftp.tar.gz  </p>
<div id="ftp_config">
./configure --with-rfc2640 --with-mysql \ <br/>
--with-language=traditional-chinese \ <br/>
--with-everything \ <br/>
--with-altlog \ <br/>
--with-virtualchroot \ <br/>
--with-diraliases <br/>
</div>
<p> 
make <br/> make install  <br/>PS.  --with-virtualchroot、--with-diraliases 確保symbolic link work
</p>

<hr/>

<p>
本平台FTP設定檔如下：
</p>


<h2>Pure-FTP startup configuration</h2>
<p>請修改 MySQLConfigFile 參數至指定pureftpd-mysql.conf	位置
</p>
<?php if($flag_ftp_conf_cantwrite){ ?>
<h3 id="alert">檔案無法寫入&nbsp;&nbsp;&nbsp;<?php echo $alert_string?></h3><?php } ?>

<?php if($flag_ftp_conf_write_ok){ ?>
<p>已經將檔案寫入至 <?php echo $current_dir.'/'.$pureftpd_filename;?></p> <?php } ?>

	
<div id="ftp_config">
<?php echo nl2br($pure_ftp_conf);?>
</div>

<hr/>

<h2>Pure-FTP mysql startup configuration</h2>
<?php if($flag_ftp_mysql_conf_cantwrite){ ?>
<h3 id="alert">檔案無法寫入&nbsp;&nbsp;&nbsp;<?php echo $alert_string?></h3><?php } ?>

<?php if($flag_ftp_mysql_conf_write_ok){ ?>
<p>已經將檔案寫入至 <?php echo $current_dir.'/'.$pureftpd_mysql_filename;?></p> <?php } ?>
<div id="ftp_config">
<?php echo nl2br($pure_ftp_mysql_conf);?>
</div>
<br/>

<a href="end.html">返回完成頁面</a>
<br/>
</body>
</html>

<?php 
function create_ftp_config(){
	global $pureftpd_mysql_filename, $current_dir;
	ob_start();
?>
############################################################
#                                                          #
#         Configuration file for pure-ftpd wrappers        #
#                                                          #
############################################################
# Run Pure-ftpd:
# pure-config.pl pure-ftpd.conf
#

ChrootEveryone				yes
MySQLConfigFile				<?php echo $current_dir.'/'.$pureftpd_mysql_filename;?>

Umask                       113:012
FileSystemCharset			utf-8
ClientCharset				big5


DontResolve                 yes
AnonymousOnly               no
NoAnonymous                 yes
AnonymousCanCreateDirs      no
Daemonize                   yes
MaxClientsPerIP				8

#
MinUID						100
AllowUserFXP				no
CustomerProof				yes
<?php
	$buffer = ob_get_contents();
	ob_end_clean();
	return $buffer;
}

function create_ftp_mysql_config()
{
	global $DB_NAME;
	global $DB_USERNAME;
	global $DB_USERPASSWORD;
	
	ob_start();
	//do output to buffer  
?>
MYSQLServer		localhost
MYSQLPort		3306
MYSQLSocket		/tmp/mysql.sock
MYSQLUser		<?php echo $DB_USERNAME;?>

MYSQLPassword	<?php echo $DB_USERPASSWORD;?>

MYSQLDatabase	<?php echo $DB_NAME;?>

MYSQLCrypt		md5
MYSQLGetPW		SELECT Password FROM users WHERE User="\L"
MYSQLGetUID		SELECT Uid FROM users WHERE User="\L"
MYSQLGetDir		SELECT Dir FROM users WHERE User="\L"
<?php
	$buffer = ob_get_contents();
	ob_end_clean();
	return $buffer;
}




?>
