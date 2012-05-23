window.onload = init;

function init(){
	var str_hide = new Array("p_ex", "p_im", "form_import", "span_export");
	for(var i = 0 ; i < str_hide.length ; i++)
		Element.hide(str_hide[i]);
	$("import").onclick = import_show;
	$("form_import").onsubmit = set_submit;
}

function import_show(){
	Element.show("form_import");
	Element.hide("span_export");
}

function _export(no){
	var url = "port.php";
	var par = "option=export&bankno=" + no;
	Element.show("p_ex");
	Element.hide("form_import");
	var ajax = new Ajax.Request(url,
	{
		method: 'GET',
		parameters: par,
		onComplete: show_export
	});
}

function show_export(){
	Element.show("span_export");
	Element.hide("p_ex");
}

function set_submit(){
	var tmp = document.getElementsByTagName("input");
	for(var i = 0 ; i < tmp.length ; i++)
		if(tmp[i].type == "button" || tmp[i].type == "submit")
			tmp[i].disabled = "true";
	Element.show("p_im");
	return true;
}
