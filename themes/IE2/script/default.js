var myI, myW, myH;
var left = 1, right = 1

function ResizeIframe(i) {
  //http://www.frontpagewebmaster.com/m-89000/tm.htm  有一段code 看起來對resize不錯
  //需要找時間處理一下 
  	i.height = "100%" ; 
  	i.width = "100%";    
  	var b = i.contentWindow.document.body;
  	myI = i; 
  	myW = b.scrollWidth;
  	myH = b.scrollHeight;
	//alert(1);
	//alert(i.contentWindow.parent);
	//alert(i.contentWindow.parent == i);
	//alert(parent == i);
	//alert(parent.document.getElementById('content').style.height);
	setTimeout("ResizeIframe2(myI,myW,myH)",600); 
}                                                                               

function $(id){
	return document.getElementById(id);
}

function ResizeIframe2(i,w,h) {                                                 
	if(h < 400)
		h = 400;
	i.height = h + 30; 
	i.width = w;
}

function hiddenMenuLeft(block, path){
  if(left == 1){
    left = 0;
    var div = document.getElementById("columnleft");
    div.setAttribute("id", "columnleft-close");
    
    div = document.getElementById("menu_left");
    div.style.display = "none";

    block.firstChild.setAttribute("src", path + "/images/index-2_r15_c10.jpg");

    if(right == 1)
      document.getElementById("columnmiddle").setAttribute("id", "columnmiddle-close-left");
    else
      document.getElementById("columnmiddle-close-right").setAttribute("id", "columnmiddle-close-all");
  }else{
    left = 1;
    var div = document.getElementById("columnleft-close");
    div.setAttribute("id", "columnleft");

    div = document.getElementById("menu_left");
    div.style.display = "";

    block.firstChild.setAttribute("src", path + "/images/index-2_r11_c6.jpg");

    if(right == 1)
      document.getElementById("columnmiddle-close-left").setAttribute("id", "columnmiddle");
    else
      document.getElementById("columnmiddle-close-all").setAttribute("id", "columnmiddle-close-right");
  }

  reload();
}

function hiddenMenuRight(block, path){
  if(right == 1){
    right = 0;
    var div = document.getElementById("columnright");
    div.setAttribute("id", "columnright-close");
    
    div = document.getElementById("menu_right");
    div.style.display = "none";

    block.firstChild.setAttribute("src", path + "/images/index-2_r11_c6.jpg");

    if(left == 1)
      document.getElementById("columnmiddle").setAttribute("id", "columnmiddle-close-right");
    else
      document.getElementById("columnmiddle-close-left").setAttribute("id", "columnmiddle-close-all");
  }else{
    right = 1;
    var div = document.getElementById("columnright-close");
    div.setAttribute("id", "columnright");
    
    div = document.getElementById("menu_right");
    div.style.display = "";

    block.firstChild.setAttribute("src", path + "/images/index-2_r15_c10.jpg");

    if(left == 1)
      document.getElementById("columnmiddle-close-right").setAttribute("id", "columnmiddle");
    else
      document.getElementById("columnmiddle-close-all").setAttribute("id", "columnmiddle-close-left");
  }
  
  reload();
}

function reload(){
  var tmp = document.getElementsByName("information");
  var div = tmp[0];
  
  ResizeIframe(div);
}

function checkAll(str, flag){
	var tmp = document.getElementsByName(str);
	tmp = tmp[0];
	list = tmp.getElementsByTagName("input");
	var i;
	for(i = 0 ; i < list.length ; i++){
		if(list[i].getAttribute("type") == "checkbox")
			list[i].checked = flag;
	}
}

function changeCourse(_self){
	location.href = "../Personal_Page/courseList_intoClass.php?begin_course_cd=" + _self.value;
}
