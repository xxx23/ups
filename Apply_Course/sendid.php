<?
$n = $_GET['n'];
if(!empty($n)){
	if($n == "0"){
?>
<script>
	window3=window.open('','messageWindow','scrollbars=yes,resize=yes,width=300, height=300');
	window3.document.writeln("����J�b��!");
</script>
<?}
	if($n == "1"){?>
<script>
	window3=window.open('','messageWindow','scrollbars=yes,resize=yes,width=300, height=300');
	window3.document.writeln("���b���w�g���ϥ�!");
</script>
<?	}
	if($n == "2"){?>
<script>
	window3=window.open('','messageWindow','scrollbars=yes,resize=yes,width=300, height=300');
	window3.document.writeln("���b�����ϥ�!");
</script>
<?	}
}
?>
<form name="form1" method="POST" action="checkid.php">
<input type="hidden" name="Courseid_id" value="">
</form>
