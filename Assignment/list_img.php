<?php
	require 'fadmin.php';

	if( session_check_teach( $PHPSESSID ) !=2 &&
	    session_check_teach( $PHPSESSID ) != 3 )
		show_page( "not_access.tpl" ,"權限錯誤");
?>
<html>
<head>
<script language="JavaScript">
var filename = '';
var prevTR = null;

function setImage( fname )
{
	var obj = window.event.srcElement;
	filename = fname;
	
	if( obj == null )
		return false;

	if( obj.parentElement.tagName == 'TR' )
	{
		if( prevTR != null )
			prevTR.style.background = '';
		prevTR = obj.parentElement;
		prevTR.style.background = '#00ff00';
	}
	return false;
}
</script>
</head>
<body topmargin="0" leftmargin="0">

<table width="320" style="font-size:9pt; font-family:新細明體">
	<tr style="background=navy;color=white">
		<th>檔名</th><th>日期</th><th>說明</th>
	</tr>
<?php
	$dp = opendir( "../../$course_id/homework/upload/");
	if( $dp )
	{
		while( ($file = readdir( $dp )) != false )
		{
			if( strncmp( $file, ".", 1 ) == 0 )
				continue;
			$st = lstat( "../../$course_id/homework/upload/$file" );	
			$date = date( "Y/m/d H:i:s", $st[10] );
			$fp = fopen( "../../$course_id/homework/comment/$file.txt", 'r' );
			if( $fp )
			{
				$comment = fgets( $fp, 128 );
				fclose( $fp );
			}
			echo "<tr style='cursor:hand' onclick='return setImage(\"../../../$course_id/homework/upload/$file\");'>\n";
			echo "<td>$file</td><td>$date</td><td>$comment</td><tr>\n";
		}
		closedir( $dp );
	}
?>
</table>

</body>
</html>
