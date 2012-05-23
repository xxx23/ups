<?
$n = $_GET['n'];
if(!empty($n)){
	if($n == "0"){
?>
<script>
	window3=window.open('','messageWindow','scrollbars=yes,resize=yes,width=300, height=300');
	window3.document.writeln("未輸入帳號!");
</script>
<?}
	if($n == "1"){?>
<script>
	window3=window.open('','messageWindow','scrollbars=yes,resize=yes,width=300, height=300');
	window3.document.writeln("此帳號已經有使用!");
</script>
<?	}
	if($n == "2"){?>
<script>
	window3=window.open('','messageWindow','scrollbars=yes,resize=yes,width=300, height=300');
	window3.document.writeln("此帳號未使用!");
</script>
<?	}
}
?>
<form name="form1" method="POST" action="checkid.php">
<input type="hidden" name="Courseid_id" value="">
</form>
