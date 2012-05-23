function check_id(Courseid_id){
	if(Courseid_id.value == ""){
		alert("注意!! 您未輸入帳號");
	}
	else{
		window.sendid.form1.Courseid_id.value = Courseid_id.value;
		window.sendid.form1.submit();
	}
	return true;
}

function checkID(control){
	if (control.value == "") {
		validatePrompt(control, "請輸入帳號！");
		return (false);
	} else
		return (true);
}

function checkPassword1(control) {
	if (control.value == ""){
		validatePrompt(control, "請輸入密碼！");
		return (false);
	}
	if (control.value.length <= 5) {
		validatePrompt(control, "密碼欄請輸入6~15位數的英文或數字");
		return (false);
	} else
		return (true);
}

function checkPassword2(Courseid_password, Courseid_password2) {
	if (Courseid_password.value != Courseid_password2.value) {
		validatePrompt(Courseid_password2, "兩次密碼輸入不一樣哦！");
		return (false);
	} else
		return (true);
}

function checkPerson(control) {
	if (control.value == "") {
		validatePrompt(control, "請輸入電話號碼！");
		return (false);
	} else
		return (true);
}

function checkTel(control) {
	if (control.value == "") {
		validatePrompt(control, "請輸入電話號碼！");
		return (false);
	} else
		return (true);
}

function checkEmail(control) {
	re = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;

	if (control.value == "") {
		validatePrompt(control, "請輸入E-mail！");
		return (false);
	} else{
		if (re.test(control.value)){
			return (true);
		}
		else{
			validatePrompt(control, "E-mail格式錯誤！");
			return (false);
		}
	}
}


function checkReason(control) {
	if (control.value == "") {
		validatePrompt(control, "請輸入帳號申用途！");
		return (false);
	} else
		return (true);
}


function validateForm(form1) {
	if (!checkOrg(form1.Courseid_org)) return;
	if (!check_id(form1.Courseid_id)) return;
	if (!checkID(form1.Courseid_id)) return;
	if (!checkPassword1(form1.Courseid_password)) return;
	if (!checkPassword2(form1.Courseid_password, form.Courseid_password)) return;
	if (!checkPerson(for1m.Courseid_person)) return;
	if (!checkTitle(form1.Courseid_title)) return;
	if (!checkTel(form1.Courseid_tel)) return;
	if (!checkEmail(form1.Courseid_email)) return;
	if (!checkReason(form1.Courseid_reason)) return;

	document.form1.submit();	// Submit form
}

function validatePrompt(control, promptStr) {
	alert(promptStr);
	control.focus();
	return;
}

function checkcity1(control) {
	if (control.value != "") return(true);
	alert ("請選擇縣市區域！");
	return (false);
}


function modifyForm(form) {
	if (!checkEmail(form.email)) return;
	if (!checkcity1(form.subtype)) return;
	if (!checkadd(form.address)) return;
	if (!checkHnumber(form.hnumber)) return;
	if (!checkCnumber(form.cnumber)) return;
	document.form1.submit();	// Submit form
}
