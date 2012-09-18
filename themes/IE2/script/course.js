var menu_name = new Array("課程說明", "教材", "學習活動", "討論區", "電子報", "系統工具", "公告", "成績簿", "學生管理");
var ori_image = new Array("information.jpg", "textbook.jpg", "action.jpg", "talk.jpg", "newspaper.jpg", "system.jpg", "announce.jpg", "score.jpg", "stu_manager.jpg");
var new_image = new Array("informationv2.jpg", "textbookv2.jpg", "actionv2.jpg", "talkv2.jpg", "newspaperv2.jpg", "systemv2.jpg", "announce_b.jpg", "score_b.jpg", "stu_manager_b.jpg");
var button_list_main = [];
var button_list_sub = [];
var button_list_last = [];
var flag = 0;
var delay = 600;

function getObject(id){
	if(document.all)
		return document.all(id);
	return document.getElementById(id);
}

function PXtoInt(str){
	return parseInt(str.substr(0, str.length - 2))
}

function createMenu_0(name, path){
	var button = createButton_0(name, path);
	var tmp = document.getElementById("function_list");
	tmp.appendChild(button);
	button.style.height = button.firstChild.height;
	button.style.width = button.firstChild.width;
	var container = createContainer(button, "v");
	button.setAttribute("container", container);
}

function createButton_0(name, path){
	var num = button_list_main.length;
	var img_num = getImage(name); 
	var button_td = document.createElement("td"); 
	var button_img = document.createElement("img");
	button_img.setAttribute("src", path + "/images/" + ori_image[img_num]);
	button_img.setAttribute("src.bak", path + "/images/" + new_image[img_num]);
	button_img.height = 65;
	button_td.appendChild(button_img);
	button_td.setAttribute("id", "main_" + num);

	button_td.onmouseover = function(){
		flag = 0;
		replaceImage(button_td);
		hiddenAllMain();
		showContainer(button_td);
	};
	button_td.onmouseout = function(){
		flag = 1; 
		replaceImage(button_td);
		hiddenContainer(button_td); 
	}; 
	button_list_main[num] = button_td.getAttribute("id"); 
	return button_td; 
}

function addButton(name, link, str, path){
	var list = "";
	if(str == "main")
		list = button_list_main;
	else
		list = button_list_sub;

	var tmp = getObject(list[list.length - 1]);
	var cont = getObject(tmp.getAttribute("container"));

	var button = createButton(name, link, path, str);
	cont.appendChild(button);

	if(str == "main") {
		var cont_id = createContainer(button, "h");
		var tmp2 = document.getElementById(cont_id);
		button.setAttribute("container", cont_id); 
	}
} 

function createButton(name, link, path, str){ 
	var button = document.createElement("div"); 
	var list = "";
	if(str == "main") list = button_list_sub;
	else list = button_list_last;
	var num = list.length;
	if(str == "main") button.setAttribute("id", "sub_" + num);
	else button.setAttribute("id", "last_" + num);
	list[num] = button.getAttribute("id"); 
	button.style.cursor = "pointer";
	button.className = "v1sub";
	if(link.match(/.php/i) == null){ 
		var tmp = document.createElement("div");
		tmp2 = document.createElement("div");
		tmp2.className = "v1sub";
		tmp2.appendChild(document.createTextNode(">>"));
		tmp2.className = "v1arrow";
		tmp.appendChild(tmp2);
		tmp3 = document.createElement("a");
		tmp3.setAttribute("herf", "#");
		tmp3.appendChild(document.createTextNode(name));
		tmp.appendChild(tmp3);
		button.appendChild(tmp);

		button.onmouseover = function(){
			flag = 0;
			hiddenAllSub();
			var cont = getObject(button.getAttribute("container"));
			cont.style.top = getTop(button);
			showContainer(button);
		};
		button.onmouseout = function(){
			flag = 1;
			hiddenContainer(button);
		};
	}else{
		var tmp = document.createElement("a");
		tmp.setAttribute("href", ".." + link);
		tmp.setAttribute("target", "information");
		tmp.appendChild(document.createTextNode(name));
		button.appendChild(tmp);
		button.onmouseover = function(){
			if(button.id.match(/sub/i) != null)
				setTimeout("hiddenAllSub()", delay);
		};
	}
	return button;
}

function replaceImage(button){
	var img = button.firstChild;
	var tmp = img.getAttribute("src");
	img.setAttribute("src", img.getAttribute("src.bak"));
	img.setAttribute("src.bak", tmp);
}

function createContainer(button, c){
	var cont = document.createElement("div");
	var tmp = document.getElementsByTagName("body");
	cont.setAttribute("id", button.getAttribute("id") + "_container");
	cont.className = "v1main"; 
	cont.style.display = "none";
	cont.style.position = "absolute";
	cont.style.width = "125px";//button.style.width;

	cont.onmouseover = function(){flag = 0;}
	cont.onmouseout = function(){
		flag = 1;
		setTimeout("hidden()", delay);
	}

	tmp[0].appendChild(cont);
	setLocation(button, cont, c);
	return cont.getAttribute("id");
}

function hiddenAllMain(){
	for(var i = 0 ; i < button_list_main.length ; i++){
		button = document.getElementById(button_list_main[i])
			document.getElementById(button.getAttribute("container")).style.display = "none";
	}
	hiddenAllSub();
}

function hiddenAllSub(){
	for(var i = 0 ; i < button_list_sub.length ; i++){
		button = getObject(button_list_sub[i])
			if(button.getAttribute("container") != null)
				document.getElementById(button.getAttribute("container")).style.display = "none";
	}
}

function showContainer(button){
	var id = button.getAttribute("container");
	var tmp = document.getElementById(id);
	tmp.style.display = "";
}

function all(tmp){
	var out = "";
	for(i in tmp){
		if(tmp[i] == null || tmp[i] == "" || typeof(tmp[i]) == "object")
			continue;
		out = out + i + ": " + tmp[i] + "\n";
	}
	alert(out);
}

function hiddenContainer(button){
	var id = button.getAttribute("container");
	var tmp = document.getElementById(id);
	setTimeout("hidden();", delay);
}

function hidden(){
	if(flag == 0)
		return ;
	hiddenAllMain();
}

function setLocation(button, cont, c){
	var x;
	var y;
	if(c == "v"){
		x = getLeft(button);
		y = getTop(button);
		cont.style.left = x;
	//	alert("first: " + y + "     height: " + button.style.height);
		cont.style.top = y + parseInt(button.style.height.substr(0, button.style.height.length - 2));
	//	alert("last: " + cont.style.top);
	}else{
		/*    x = button.parentNode.style.left;
		      y = button.parentNode.style.top;*/
		//    if(button.getAttribute("id") == "sub_7")
		//      alert(button.style.position);
		var par = button.parentNode;
		x = parseInt(par.style.left.substr(0, par.style.left.length - 2));
		y = parseInt(par.style.top.substr(0, par.style.top.length - 2));
		cont.style.left = x + parseInt(par.style.width.substr(0, par.style.width.length - 2));
		cont.style.top = y;
	}
}

function getImage(str){
	var i = 0;
	for(i = 0 ; i < menu_name.length ; i++){
		if(str == menu_name[i])
			return i;
	}
	return -1;
}

function getLeft(obj){
	var x = 0;
	do{ x += obj.offsetLeft;
		obj = obj.offsetParent;
	}while(obj);
	return x;
}

function getTop(obj){
	var y = 0;
	do{
		y += obj.offsetTop;
		obj = obj.offsetParent;
	}while(obj); 
	return y;
}

function init(){
	// var url = "../Online/online.php";
	var url = "../Online/online2.php";
	var ajax = new Ajax.Request(url,
	{
		method: "POST",
		parameters: "",
		// onComplete: compiler_online
		onComplete: read_online
	});

}


function read_online(obj)
{
	var body = obj.responseText;
	var list = body.split(",");

	var sysPersons =  document.getElementById('sysPersons');
	var classPersons = document.getElementById('classPersons');
	sysPersons.innerHTML = list[0];
	classPersons.innerHTML = list[1];
	setTimeout("init()","60000");
	if(hasmsg)
	{
		window.open('../Online/messager.php?action=receive','','resizable=1,scrollbars=1,width=350,height=290');
	}
}

/* 分析從online.php來的訊息，找出系統人數跟同學人數 */
function compiler_online(obj){
  var r_sys = /gif.*[0-9]+/i;
  var body = obj.responseText;
  var msg = body.match("(window.open\\('\\./messager\\.php\\?action=receive'[^;]*)");
  var hasmsg = body.substr(msg.index-2,2) != "//";
  var ret = body.match("images/function/icon-s-2.gif\">\([^<]*\)");
  body = body.substr(ret.index+100);
  var ret2 = body.match("images/function/icon-s-2.gif\">\([^<]*\)");

  var num_sysPersons = ret[1].match("[0-9]+");
  var num_classPersons = ret2[1].match("[0-9]+");	
  //為了解決套件衝突 所以改用getElementById by tgbsa
  var sysPersons =  document.getElementById('sysPersons');
  var classPersons = document.getElementById('classPersons');
  //if(sysPersons.innerHTML == "")
  //{
  sysPersons.innerHTML = num_sysPersons;
  classPersons.innerHTML = num_classPersons;
  //}
  setTimeout("init()","60000");
  if(hasmsg)
  {
    window.open('../Online/messager.php?action=receive','','resizable=1,scrollbars=1,width=350,height=290');
  }
}


//快速課程選單
function changeCourse(select_node)
{
    var change_course_url = '../Personal_Page/courseList_intoClass.php?begin_course_cd=';
    
    if( select_node.options[select_node.options.selectedIndex].value == -1 ){
        return ;
    }

    if( select_node.options[select_node.options.selectedIndex].value == -2) {
        window.location= jumpURL;
    }else {
        window.location = change_course_url + select_node.options[select_node.options.selectedIndex].value ;
    }
}


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
  if(h < 650) {
    i.height = 650;
  }else {
    i.height = h;
  }
  i.width = w;
}

