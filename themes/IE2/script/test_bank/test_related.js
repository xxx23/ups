/* $Id:test_related.js v1.0  2006/11/25 by hushpuppy Exp. $ */

//依選擇題型結果，傳回題目編輯頁面
function selectTestType(location)
{
	tmp = document.getElementById("edit_content");
	if(location == 0);
	else if(location == 1){	//選擇題
	  window.location.href = "question.php?type=choosing";
//	  window.location.href = "choosing.html";
	}
	else if(location == 2){ //是非題
	  window.location.href = "question.php?type=YorN";
//	  window.location.href = "YorN.html";
	}
	else if(location == 3){ //填充題
	  window.location.href = "question.php?type=cram";
//	  window.location.href = "cram.html";
	}
	else{ //簡答題
	  window.location.href = "question.php?type=QA";
//	  window.location.href = "QA.html";
	}
}

//刪除題目動作
function delete_test(test_bankno) {
	if( confirm('確定要刪除此題目？') ) {
		location.href = "test_bank_content.php?delete_test_bankno="+test_bankno;
		return true;
	}
	else
		return false;
}

//刪除整份題庫動作
function delete_test_bank(content_cd, test_bank_id) {
	if( confirm('這個動作會刪除題庫內的所有題目，確定要刪除？') ) {
		location.href = "test_bank.php?delete_flag=1&content_cd="+ content_cd + "&test_bank_id="+test_bank_id;
		return true;
	}
	else
		return false;
}

//選擇題頁面使用的innerHTML
function ans_num(option)
{
	tmp = document.getElementById("ans_list");
	/*if(modify == 2)
		tmp.innerHTML = "<input type = \"hidden\" name = \"modify\" value = \"modify\">";*/

    if(option == 0){ //三個選項
		str = "\
		<span class='required'>*</span>請輸入第一選項：<input type = \"text\" name = \"select_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第二選項：<input type = \"text\" name = \"select_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第三選項：<input type = \"text\" name = \"select_3\" size = \"60\" value=\"\"><br><br>\
		<span class='required'>*</span>請選擇答案:<input type = \"checkbox\" name = \"check_array[]\" id = \"check_1\" value = \"1\" CHECK1>1&nbsp;&nbsp;&nbsp;&nbsp;\
		   	      <input type = \"checkbox\" name = \"check_array[]\" id = \"check_2\" value = \"2\" CHECK2>2&nbsp;&nbsp;&nbsp;&nbsp;\
	   	          <input type = \"checkbox\" name = \"check_array[]\" id = \"check_3\" value = \"3\" CHECK3>3&nbsp;&nbsp;&nbsp;&nbsp;<br>\
		";
		tmp.innerHTML = str;
	
    }
	else if(option == 1){	//四個選項
		str = "\
		<span class='required'>*</span>請輸入第一選項：<input type = \"text\" name = \"select_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第二選項：<input type = \"text\" name = \"select_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第三選項：<input type = \"text\" name = \"select_3\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第四選項：<input type = \"text\" name = \"select_4\" size = \"60\" value=\"\"><br><br>\
		<span class='required'>*</span>請選擇答案：<input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"1\" CHECK1>1&nbsp;&nbsp;&nbsp;&nbsp;\
		   	      <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"2\" CHECK2>2&nbsp;&nbsp;&nbsp;&nbsp;\
	   	          <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"3\" CHECK3>3&nbsp;&nbsp;&nbsp;&nbsp;\
				  <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"4\" CHECK3>4&nbsp;&nbsp;&nbsp;&nbsp;<br>\
		";
		tmp.innerHTML = str;
	}
	else if(option == 2){ //五個選項
        str = "\
		<span class='required'>*</span>請輸入第一選項：<input type = \"text\" name = \"select_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第二選項：<input type = \"text\" name = \"select_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第三選項：<input type = \"text\" name = \"select_3\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第四選項：<input type = \"text\" name = \"select_4\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第五選項：<input type = \"text\" name = \"select_5\" size = \"60\" value=\"\"><br><br>\
		<span class='required'>*</span>請選擇答案：<input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"1\" CHECK1>1&nbsp;&nbsp;&nbsp;&nbsp;\
		   	      <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"2\" CHECK2>2&nbsp;&nbsp;&nbsp;&nbsp;\
	   	          <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"3\" CHECK3>3&nbsp;&nbsp;&nbsp;&nbsp;\
				  <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"4\" CHECK3>4&nbsp;&nbsp;&nbsp;&nbsp;\
				  <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"5\" CHECK3>5&nbsp;&nbsp;&nbsp;&nbsp;<br>\
		";
		tmp.innerHTML = str;
    }
	else if(option == 3){ //六個選項
        str = "\
		<span class='required'>*</span>請輸入第一選項：<input type = \"text\" name = \"select_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第二選項：<input type = \"text\" name = \"select_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第三選項：<input type = \"text\" name = \"select_3\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第四選項：<input type = \"text\" name = \"select_4\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第五選項：<input type = \"text\" name = \"select_5\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>請輸入第六選項：<input type = \"text\" name = \"select_6\" size = \"60\" value=\"\"><br><br>\
		<span class='required'>*</span>請選擇答案：<input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"1\" CHECK1>1&nbsp;&nbsp;&nbsp;&nbsp;\
		   	      <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"2\" CHECK2>2&nbsp;&nbsp;&nbsp;&nbsp;\
	   	          <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"3\" CHECK3>3&nbsp;&nbsp;&nbsp;&nbsp;\
				  <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"4\" CHECK3>4&nbsp;&nbsp;&nbsp;&nbsp;\
				  <input type = \"checkbox\" name = \"check_array[]\" id = \"check_array[]\" value = \"5\" CHECK3>5&nbsp;&nbsp;&nbsp;&nbsp;\
				  <input type = \"checkbox\" name = \"check_6\" id = \"check_array[]\" value = \"6\" CHECK3>6&nbsp;&nbsp;&nbsp;&nbsp;<br>\
		";
		//alert(str);
		tmp.innerHTML = str;
    }
}

//填充題頁面
function cram_num(option){
	tmp = document.getElementById("cram_list");	
	if(option == 0){ //ㄧ個空格
		str = "\
		<span class='required'>*</span>第一格：<input type = \"text\" name = \"cram_1\" size = \"60\" value=\"\"><br><br>\
		";
		tmp.innerHTML = str;
	}
	else if(option == 1){ //兩個空格
		str = "\
		<span class='required'>*</span>第一格：<input type = \"text\" name = \"cram_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第二格：<input type = \"text\" name = \"cram_2\" size = \"60\" value=\"\"><br><br>\
		";
		tmp.innerHTML = str;
	}
	else if(option == 2){ //三個空格
		str = "\
		<span class='required'>*</span>第一格：<input type = \"text\" name = \"cram_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第二格：<input type = \"text\" name = \"cram_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第三格：<input type = \"text\" name = \"cram_3\" size = \"60\" value=\"\"><br><br>\
		";
		tmp.innerHTML = str;
	}
	else if(option == 3){ //四個空格
		str = "\
		<span class='required'>*</span>第一格：<input type = \"text\" name = \"cram_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第二格：<input type = \"text\" name = \"cram_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第三格：<input type = \"text\" name = \"cram_3\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第四格：<input type = \"text\" name = \"cram_4\" size = \"60\" value=\"\"><br><br>\
		";
		tmp.innerHTML = str;
	}
	else if(option == 4){ //五個空格
		str = "\
		<span class='required'>*</span>第一格：<input type = \"text\" name = \"cram_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第二格：<input type = \"text\" name = \"cram_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第三格：<input type = \"text\" name = \"cram_3\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第四格：<input type = \"text\" name = \"cram_4\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第五格：<input type = \"text\" name = \"cram_5\" size = \"60\" value=\"\"><br><br>\
		";
		tmp.innerHTML = str;
	}
	else{ //六個空格
		str = "\
		<span class='required'>*</span>第一格：<input type = \"text\" name = \"cram_1\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第二格：<input type = \"text\" name = \"cram_2\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第三格：<input type = \"text\" name = \"cram_3\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第四格：<input type = \"text\" name = \"cram_4\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第五格：<input type = \"text\" name = \"cram_5\" size = \"60\" value=\"\"><br>\
		<span class='required'>*</span>第六格：<input type = \"text\" name = \"cram_6\" size = \"60\" value=\"\"><br><br>\
		";
		tmp.innerHTML = str;
	}
}
/*
function Check() {
	if ( document.getElementById("test_title").value == "" ) {
		alert("請輸入題目!");
		return false;
	}
}*/
