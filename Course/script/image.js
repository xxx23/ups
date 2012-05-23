var path = "../images/main_menu/";

var arr_name = new Array("線上作業", "授課教材", "課程公告", "線上測驗", "題庫系統");
var arr_img1 = new Array("online_homework.jpg", "teaching _materials.jpg", "course_information.jpg", "online_test.jpg", "tmp3.gif");
var arr_img2 = new Array("online_homework2.jpg", "teaching _materials2.jpg", "course_information2.jpg", "online_test2.jpg", "tmp3.gif");

function imageChange1(img){
	var value = img.charAt(5);
	document.getElementById(img).setAttribute("src", path+arr_img1[value]);
}

function imageChange2(img){
	var value = img.charAt(5);
	document.getElementById(img).setAttribute("src", path+arr_img2[value]);
}

function submenu(id){
	var node = document.getElementById(id);
	var par = node.parentNode;
	var tmp = par.firstChild;
	while(tmp != null){
		if(tmp.getAttribute("name") == "submenu"){
			tmp.style.display = "none";
		}
		tmp = tmp.nextSibling;
	}
	node.style.display = "";
}

function hyper(name, id){
	for(i = 0 ; i < arr_name.length ; i++){
		if(name == arr_name[i]){
			var img = document.createElement("img");
			img.setAttribute("src", path + arr_img2[i]);
			img.setAttribute("id", "image"+i);
			img.setAttribute("name", id);
			img.setAttribute("value", i);
			img.style.border = "0px";
			img.onmouseover = function (){imageChange1(img.getAttribute("id"))};
			img.onmouseout = function (){imageChange2(img.getAttribute("id"))};
			img.onclick = function (){submenu(img.getAttribute("name"))};
			document.getElementById('mainmenu').appendChild(img);
		}
	}
}
