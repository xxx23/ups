<?PHP

/*
利用 phpmailer 做的 mail API
以 140.123.5.151 為例，API 本身呼叫的 library 放在 /home/WWW/library/phpmailer 下
如果需要把這套 mail 程式複製到別台機器，只要把 /home/WWW/library/phpmailer 這個資料夾
還有 /home/WWW/library/mail.php 這支程式，複製過去即可使用

使用前請 require_once( $PATH . 'library/mail.php');  
$PATH是縣市網的 DocumentRoot，請只使用相對路徑，而非絕對路徑

API 的函數是: 

bool mailto ( string $from, string $fromName, string $to, string $subject, string $message )


參數:
編碼一律採 UTF-8 ，傳入的參數也請用 UTF-8

$from: 信件中顯示寄件人的 email address ，這個部份未必要填正確的 email address，可自訂任何 email

$fromName: 信件中顯示的寄件人名稱，可自訂名稱

$to: 收件人的 email address 

  如果寄件者很多人，請存成字串陣列
  範例：
  $to[] = 'study1@gmail.com';
  $to[] = 'study2@test2.cs.ccu.edu.tw';


$subject: 信件顯示的標題主旨

$message: 信件內文
  內文採 text/html 格式，一律採用 UTF-8 編碼，API 會自動幫你在 $message 前面加上 <html><body>....</html>

使用範例:


*/

require_once("../config.php") ;
require_once("phpmailer/class.phpmailer.php");

$from= $MAIL_ADMIN_EMAIL;
echo "mailfrom:".$from."\n" ; 
echo "SMTP HOST:" ."$MAIL_SMTP_HOST \n" ;
$fromName= '學習平台';
$to = 'lcn96m@cs.ccu.edu.tw';
//$to[] = 'study1@test1.cs.ccu.edu.tw';
//$to[] = 'study2@test2.cs.ccu.edu.tw';
$subject = "系統測試信件";
$message = <<<CODE
同學您好,
\n\n..................................\n\n
這是系統自動發出的信件，請勿回覆。
CODE;

mailto($from , $fromName, $to, $subject, $message );


/*

doc by ISeekU 2008.1.126

利用 phpmailer 做的 mail API
以 140.123.5.151 為例，API 本身呼叫的 library 放在 /home/WWW/library/phpmailer 下
如果需要把這套 mail 程式複製到別台機器，只要把 /home/WWW/library/phpmailer 這個資料夾
還有 /home/WWW/library/mail.php 這支程式，複製過去即可使用

使用前請 require_once( $PATH . 'library/mail.php');  
$PATH是縣市網的 DocumentRoot，請只使用相對路徑，而非絕對路徑

API 的函數是: 

bool mailto ( string $from, string $fromName, string $to, string $subject, string $message )


參數:
編碼一律採 UTF-8 ，傳入的參數也請用 UTF-8

$from: 信件中顯示寄件人的 email address ，這個部份未必要填正確的 email address，可自訂任何 email

$fromName: 信件中顯示的寄件人名稱，可自訂名稱

$to: 收件人的 email address 

  如果寄件者很多人，請存成字串陣列
  範例：
  $to[] = 'study1@gmail.com';
  $to[] = 'study2@test2.cs.ccu.edu.tw';


$subject: 信件顯示的標題主旨

$message: 信件內文
  內文採 text/html 格式，一律採用 UTF-8 編碼，API 會自動幫你在 $message 前面加上 <html><body>....</html>

使用範例:

$PATH = '../';
require_once( $PATH . 'library/mail.php');

$from= 'elearning@hsng.cs.ccu.edu.tw';
$fromName= '學習平台';
$to = 'study@test.cs.ccu.edu.tw';

//多個寄件人的用法
//$to[] = 'study1@test1.cs.ccu.edu.tw';
//$to[] = 'study2@test2.cs.ccu.edu.tw';

$subject = "系統測試信件";
$message = <<<CODE
同學您好,
\n\n..................................\n\n
這是系統自動發出的信件，請勿回覆。
CODE;

mailto($from , $fromName, $to, $subject, $message );

 */

require_once("phpmailer/class.phpmailer.php");

//email validate function，若不符 email regex ，則回傳 false
function emailValidate($field)
{
	if(!preg_match('/^(\w([-._\w]*\w)*@(\w[-_\w]*\w\.)+\w{2,9})$/', $field)) {
		return FALSE;
	} else {
		return TRUE;
	}
}


function mailto($from, $fromName, $to, $subject, $message )
{
	global $MAIL_SMTP_HOST;
	global $MAIL_SMTP_HOST_PORT;
	global $MAIL_ADMIN_USER; // default empty  , mean no need authorized 
	global $MAIL_ADMIN_PASSWROD;
	global $MAIL_ADMIN_EMAIL;
	global $MAIL_ADMIN_EMAIL_NICK;
	//宣告一個PHPMailer物件
	$mail = new PHPMailer();

	//設定使用 Sendmail 發送
	//$mail->IsSendmail();


	//設定使用SMTP發送
	$mail->IsSMTP();

	//指定SMTP的服務器位址
	$mail->Host = $MAIL_SMTP_HOST;
	//設定SMTP服務的PORT
	$mail->Port = $MAIL_SMTP_HOST_PORT;

	if( !empty($MAIL_ADMIN_USER) && !empty($MAIL_ADMIN_PASSWROD) ) {
		//設定為安全驗證方式
		$mail->SMTPAuth = true;
		//SMTP 帳號及寄件人 email 待改
		//SMTP的帳號
		$mail->Username = $MAIL_ADMIN_USER;
		//SMTP的密碼
		$mail->assword = $MAIL_ADMIN_PASSWROD;
	}
	//寄件人Email
	if( !empty($MAIL_ADMIN_EMAIL) || empty($from) ) {
		$mail->From = $MAIL_ADMIN_EMAIL;
	}else {
		$mail->From = $from;
	}

	//寄件人名稱
	if( (empty($fromName) || !empty($MAIL_ADMIN_EMAIL_NICK)) && $fromName != "教育部數位學習平台留言版"){
		$mail->FromName = $MAIL_ADMIN_EMAIL_NICK;
	}else {
		$mail->FromName = $fromName;
	}

    // 帳號開通確認 寄件備份
    if($subject == "帳號開通確認") {
        $mail->AddBCC("upsmoe@gmail.com");
    }


	//如果收件人是一個陣列(收件人很多)，利用 foreach 函式寄，若只有一人則直接寄
	if ( is_array($to) ) {
		foreach( $to as $value) {
			if (!empty($value) and emailValidate($value))
				$mail->AddAddress($value);
		}
	}else if(is_string($to) and emailValidate($to)){
		$mail->AddAddress($to);
	}else
		return false;


	//收件人Email格式
	//$mail->AddAddress("rja@exodus.cs.ccu.edu.tw");

	//設定收件人的另一種格式("Email","收件人名稱")
	//$mail->AddAddress("rja@exodus.cs.ccu.edu.tw","昌先生");

	//設定密件副本
	//$mail->AddBCC("bignostriltao@gmail.com");

	//回信Email及名稱
	//$mail->AddReplyTo("xuhao@so-net.net.tw", "大鼻子");

	//設定信件字元編碼
	$mail->CharSet="utf-8";
	//設定信件編碼，大部分郵件工具都支援此編碼方式
	$mail->Encoding = "base64";
	//設置郵件格式為HTML
	$mail->IsHTML(true);
	//每50自斷行
	//$mail->WordWrap = 50;

	//傳送附檔
	//$mail->AddAttachment("upload/temp/filename.zip");
	//傳送附檔的另一種格式，可替附檔重新命名
	//$mail->AddAttachment("upload/temp/filename.zip", "newname.zip");

	//郵件標題
	$mail->Subject= $subject;


	//  nl2br 是 php function ，會在全部的 newline 前加上 <br />
	// 請call 這個function 的user 自己處理
	//$message=nl2br($message);

	//郵件內容
	$mail->Body ="
		<html>
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
		</head>
		<body>
		$message
		</body>
		</html>
		";

	//附加內容
	//$mail->AltBody = '這是附加的信件內容';

	//寄送郵件
	if(!$mail->Send())
	{
		echo "\n郵件無法順利寄出.\n";
		echo "Mailer Error: " . $mail->ErrorInfo . "\n";
		return false;
	}
	//echo "郵件已經順利寄出.\n";

	return true;

}
?>
