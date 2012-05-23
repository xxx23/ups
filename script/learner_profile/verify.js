var block_v, block_s;
var url = "ajax/verify.php";

function verify(input){
	set_student.flag.value = input;
	set_student.submit();
}

function verify_single(pid, b){
	var par = "option=allow&pid=" + pid;
	block_v = b;
	var ajax = new Ajax.Request(url,
	{
		method: 'POST',
		parameters: par,
		onComplete: reset_verify
	});
}

function reset_verify(obj){
	block_v.firstChild.src = obj.responseText;
}

function status_single(pid, b){
	var par = "option=status&pid=" + pid;
	block_s = b;
	var ajax = new Ajax.Request(url,
	{
		method: 'POST',
		parameters: par,
		onComplete: reset_status
	});
}

function reset_status(obj){
	block_s.firstChild.src = obj.responseText;
}
