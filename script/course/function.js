function $(id){	return document.getElementById(id);	}

function clickChildren(input){
	var name = input.getAttribute("name");
	var value = input.value;
//	var tr = input.parentNode.parentNode.nextSibling;
	var tr = nextSiblingNode(input.parentNode.parentNode);

	while(tr.tagName == "TR"){
		var tmp = tr.getElementsByTagName("input");
		for(i = 0 ; i < tmp.length ; i++){
			if(tmp[i].getAttribute("name").indexOf(value) != -1){
				tmp[i].checked = input.checked;
				continue;
			}
			return ;
		}
//		tr = tr.nextSibling;
		tr = nextSiblingNode(tr);
		if(tr == null)
			return ;
	}
	return ;
}

function nextSiblingNode(input){
	while(input.nextSibling != null){
		if(input.nextSibling.nodeType == 1)
			return input.nextSibling;
		input = input.nextSibling;
	}
	return null;
}
