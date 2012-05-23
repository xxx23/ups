function check(obj, warn){
	if(obj.value == ""){
		alert(warn);
		obj.focus();
		return false;
	}
	return true;
}

function checkSubmit(form){
	if(check(form.name, "請輸入作業名稱") == false)
		return false;
	if(check(form.percentage, "請輸入作業配分") == false)
		return false;
	return true;
}
