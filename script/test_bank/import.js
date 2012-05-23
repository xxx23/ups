window.onload = init;

function init(){
	Element.hide("p_im");
	form_import.onsubmit = on_submit;
}

function on_submit(){
	_disabled_button();
	Element.show("p_im");
	return true;
}

function _disabled_button(){
	var tmp = document.getElementsByTagName("input");
	for(var i = 0 ; i < tmp.length ; i++)
		if(tmp[i].type == "button" || tmp[i].type == "submit")
			tmp[i].disabled = "true";
}
