
function cfm(cmd){
	flag = confirm("確定要刪除這筆資料?");
	if(flag == true){
		location.replace(cmd);
	}
}

