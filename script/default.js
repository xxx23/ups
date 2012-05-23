var myI, myW, myH;
var left = 1, right = 1

function ResizeIframe(i) {
  i.height = "" ;
  i.width = "100%";
  var b = i.contentWindow.document.body;
  myI = i;
  myW = b.scrollWidth;
  myH = b.scrollHeight;
  setTimeout("ResizeIframe2(myI,myW,myH)",0);
}

function ResizeIframe2(i,w,h) {
  i.height = h + 10;
  i.width = w;
}

function clickAll(str, box){
	var tmp = document.getElementsByName(str);
	tmp = tmp[0];
	list = tmp.getElementsByTagName("input");
	var i;
	for(i = 0 ; i < list.length ; i++){
		if(list[i].getAttribute("type") == "checkbox" && list[i] != box)
			list[i].checked = box.checked;
	}
}
