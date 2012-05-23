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

$PATH = '../';
require_once( $PATH . 'library/mail.php');

$from= 'elearning@hsng.cs.ccu.edu.tw';
$fromName= '學習平台';
$to = 'wewe0901@gmail.com';
//$to[] = 'study1@test1.cs.ccu.edu.tw';
//$to[] = 'study2@test2.cs.ccu.edu.tw';
$subject = "系統測試信件";
$message = <<<CODE
同學您好,
\n\n..................................\n\n
這是系統自動發出的信件，請勿回覆。
CODE;

mailto($from , $fromName, $to, $subject, $message );


?>
