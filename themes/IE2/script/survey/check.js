function $(id){
	return document.getElementById(id);
}

function check(obj, warn){
	if(obj.value == ""){
		alert(warn);
		obj.focus();
		return false;
	}
	return true;
}

//若前者較小，則回傳1
//若兩者相同，則回傳0
//若後者較大，則回傳-1
function datecmp(pre, next){
	var p = pre.value.split("-");
	var n = next.value.split("-");
	for(i = 0 ; i < 3 ; i++){
		p[i] = parseInt(p[i]);
		n[i] = parseInt(n[i]);
		if(p[i] < n[i])
			return 1;
		if(p[i] > n[i])
			return -1;
	}
	return 0;
}

function modify_view(form){
	var b = document.getElementById("beg");
	var e = document.getElementById("end");
	if(check(form.survey_name, "請輸入問卷名稱") == false)
		return false;
	if(check(b, "請輸入問卷開始時間") == false)
		return false;
	if(check(e, "請輸入問卷結束時間") == false)
		return false;
	if(datecmp(b, e) == -1){
		alert("請確認問卷的開始及結束時間");
		return false;
	}
	return true;
}

function setType(type, num){
	if(type == 2)
		return ;

	$("num").style.display = "";

	if(num < 2) num = 2;
	for(i = 1 ; i <= num ; i++)
		$("opt_" + i).style.display = "";
}

function changeType(){
	var tar = document.getElementsByName("s_type")[0].value;
	if(tar == 2){
		$("num").style.display = "none";
		return ;
	}

	$("num").style.display = "";
	changeNum();
}

function changeNum(){
	var num = document.getElementsByName("s_no")[0].value;
	for(i = 1 ; i <= num ; i++)
		$("opt_" + i).style.display = "";
	for(i ; i <= 6 ; i++)
		$("opt_" + i).style.display = "none";
}
