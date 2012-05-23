function check(obj, warn){
	if(obj.value == ""){
		alert(warn);
		return false;
	}
	return true;
}

function checkSubmit(form){
	if(form.action.value == "upload"){
		if(check(form.result_upload, "注意!您尚未選擇上傳的檔案!") == false)
			return false;
	}
	return true;
}
