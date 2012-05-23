var myI, myW, myH;
var tmp_cal;

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
	if(h < 400)
		h = 400;
	i.height = h;                                                           
	i.width = w;
}

function getObject(id){
	if(document.all)
		return document.all[id];
	return document.getElementById(id);
}

function view(str, tab){
	var tmp = getObject("course");
	if(tmp != null)
		tmp.style.display = "none";
	getObject("other").style.display = "none";
	var tmp = getObject(str);
	tmp.style.display = "";
	ResizeIframe(tmp);
	process(tab);
}

function process(tab){
	tmp = document.getElementsByTagName("body")[0];
	tmp.setAttribute("id", tab);
}

function changeview(str, tab, block){
	var tmp = document.getElementsByTagName("body")[0];
	if(tmp.getAttribute("id") != tab){
		tmp.setAttribute("id", tab);
		tmp = getObject("course");
		if(tmp != null)
			tmp.style.display = "none";
		getObject("other").style.display = "none";
		tmp = getObject(str);
		tmp.style.display = "";
	}
	var tmp2 = block.firstChild.cloneNode(true);
	var tmp3 = getObject("other_information");
	tmp3.replaceChild(tmp2, tmp3.firstChild);
}
