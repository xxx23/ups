function check(obj, warn){
	if(obj.value == ""){
		alert(warn);
		obj.focus();
		return false;
	}
	return true;
}

function checkSubmit(form){
	if(check(form.name, "請輸入測驗名稱") == false)
		return false;
	if( (form.type.value == 2 && check(form.score, "請輸入配分") == false) )
		return false;
	return true;
}
