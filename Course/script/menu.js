function hide(){
	document.getElementById("multimenu").style.display="none";
	document.getElementById("multimenu2").style.display="";
}

function display(){
	document.getElementById("multimenu").style.display="";
	document.getElementById("multimenu2").style.display="none";
}

function display_div(tag){
	var tmp = tag.parentNode.nextSibling;
	if(tmp.style.display == ""){
		tmp.style.display="none";
		tag.setAttribute("src", "../images/small/pic1w.gif");
	}else{
		tmp.style.display="";
		tag.setAttribute("src", "../images/small/pic2w.gif");
	}
}
