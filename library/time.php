<?php	
	//榡:yyyy
	function TIME_year()
	{
		return date('Y');
	}
	
	//榡:mm
	function TIME_month()
	{
		return date('m');
	}
	
	//NƦrmmন^²gmmm
	function Time_month_format($month)
	{
		$result = "";
	
		switch($month)
		{
		case 1:	$result = "Jan";	break;
		case 2:	$result = "Feb";	break;
		case 3:	$result = "Mar";	break;
		case 4:	$result = "Apr";	break;
		case 5:	$result = "May";	break;
		case 6:	$result = "Jun";	break;
		case 7:	$result = "Jul";	break;
		case 8:	$result = "Aug";	break;
		case 9:	$result = "Sep";	break;
		case 10:$result = "Oct";	break;
		case 11:$result = "Nov";	break;
		case 12:$result = "Dec";	break;
		default:echo "Time_month_format Error";	break;
		}
	
		return $result;
	}
	
	//榡:dd
	function TIME_day()
	{
		return date('d');
	}
	
	function TIME_week()
	{
		return date('N');
	}
	
	//榡1:yyyymmdd
	//榡2:yyyy-mm-dd
	function TIME_date($choose)
	{
		switch($choose)
		{
		case 1:
				//year
				$date = TIME_year();
		
				//month
				$date = $date . TIME_month();
		
				//day
				$date = $date . TIME_day();
				
				break;
		case 2:
				//year
				$date = TIME_year();
				$date = $date . "-";
		
				//month
				$date = $date . TIME_month();
				$date = $date . "-";
		
				//day
				$date = $date . TIME_day();
				
				break;
		}
		
		return $date;
	}
	
	//榡1:hhmmss
	//榡2:hh:mm:ss
	function TIME_time($choose)
	{
		$time = '';
		switch($choose)
		{
		case 1:
				//hour
				$time = $time . date('H');
		
				//minute
				$time = $time . date('i');
		
				//second
				$time = $time . date('s');
				
				break;
		case 2:
				//hour
				$time = $time . date('H');
				$time = $time . ":";
		
				//minute
				$time = $time . date('i');
				$time = $time . ":";
		
				//second
				$time = $time . date('s');
		}
		
		return $time;
	}

	//formate 1 to 2
	//1.2007-03-25 00:00:00
	//2.Tue, 03 Jun 2003 09:39:21 GMT
	function Time_format($date)
	{

		
		$result = 	"Tue, " . substr($date, 8, 2) . 
					" " . Time_month_format(substr($date, 5, 2)) . 
					" " . substr($date, 0, 4) . 
					" " . substr($date, 11, 8) . 
					" GMT";
		
		return $result;
	}
	
	


?>
