window.onload = init;

function init(){
	$("_rule").onchange = change_rule;
	if($("_delete") != null)
		$("_delete").onclick = _delete;
}

function change_rule(en){
	en = en || window.event;
	var value = en.srcElement.value;

	remove_all_child($("_arg"));
	if(value == "all")
		return -1;
	var inp = document.createElement("input");
	inp.type = "text";
	inp.name = "arg";
	$("_arg").appendChild(inp);
}

function remove_all_child(tmp){
	while(tmp.hasChildNodes() == true)
		tmp.removeChild(tmp.firstChild);
}

function _delete(){
	if(confirm("這樣會刪除學生資料(包括選課)，確定要這樣作？") == false)
		return ;
	del_form.submit();
}
