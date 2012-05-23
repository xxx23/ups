function addInput(){
	var upload = document.getElementById("upload");
	var _parent = upload.parentNode;
	var previous = upload.previousSibling;
	var _new = previous.cloneNode(true);
	if(_new.firstChild.hasChildNodes() == true)
		_new.firstChild.firstChild.nodeValue = "";
	_parent.insertBefore(_new, upload);
}

function stu_addInput(id){
	var upload = document.getElementById(id);
	var _parent = upload.parentNode;
	var previous = upload.previousSibling;
	var _new = previous.cloneNode(true);
	if(_new.firstChild.hasChildNodes() == true)
		_new.firstChild.firstChild.nodeValue = "";
	_parent.insertBefore(_new, upload);
}
