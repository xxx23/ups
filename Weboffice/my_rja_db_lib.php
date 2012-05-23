<?PHP
/*
	author: rja
	這支程式是一些我自己在用的 db library 
	需要注意到的是，在使用 query_db_xxx 系列的 function 時，要注意給的 global $DB 值
*/

function getAIDFromUserID($user_id ){
$getUserID ="select a_id from user where id = '$user_id'";
$a_id = query_db_to_value($getUserID);
return $a_id;


}

function flatArray ($arr)
{
    if (empty($arr))return Array();
    $returnArray = Array();
    foreach( $arr as $key => $value ) {
        foreach( $value as $innerKey => $innerValue ) {
            $returnArray[] =  $innerValue ;
        }
    }

    return $returnArray;

}

function getOne ($arr)
{
    foreach( $arr as $key => $value ) {
        foreach( $value as $innerKey => $innerValue ) {
            return  $innerValue ;
        }
    }


}

function query_db_to_array($query) {

    global $DB;
    if ( $result = mysql_db_query( $DB, $query) ) {
        while($row= mysql_fetch_assoc( $result )){
            $row_result[]=$row;
        }

        if ( !isset($row_result)){
            return ;
        }
        else
            return  $row_result;
    }
    else
        echo $_SERVER['PHP_SELF'] . ': '. $query; //$result->getDebugInfo();


    return;

}


function query_db_to_value($query, $thisDB ='') {

	global $DB;
	if (empty($thisDB))
		$thisDB = $DB;
	if ( $result = mysql_db_query( $thisDB, $query) ) {
		$row_result= mysql_fetch_row( $result );
		return  $row_result[0];
	}
	else
		echo $_SERVER['PHP_SELF'] . ': '. $query; //$result->getDebugInfo();


	return;

}


function query_db($query, $thisDB = '') {

	global $DB;
	if (empty($thisDB))
		$thisDB = $DB;

	$result = mysql_db_query( $thisDB, $query);
	return  $_SERVER['PHP_SELF'] . ': '. mysql_error();

}

?>
