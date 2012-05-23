<?php
/*
   author: rja
   用來印出呼叫 my_reservation_list_proc.php 後，得到的會議資訊，再畫出表格

 */

/*
   include 完這隻 my_reservation_list_proc.php ，應該就會拿到一個 $reservation_meeting 變數
   $reservation_meeting  這個變數記著一些 mmc 上的會議資訊 
   (預設是從今天開始到半年內的會議，與教師所開的課名稱相同的預約會議)
 */

include_once("./my_reservation_list_proc.php");
include_once("./my_reservation_list_print_table_lib.php");
?>


<html>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>預約會議列表</title>
</head>

<body>


<?php

//var_dump( $reservation_meeting);

echo '本學期您的所有課程預約會議列表：';
$listTable = editTableContent($reservation_meeting);

printTable($listTable);


?>

</body>
</html>
