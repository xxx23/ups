var flag = 0;
var x, y, z, down=false, obj_b;

function init(){
	obj_b = event.srcElement.parentNode;     //事件觸發對象
	obj_b.setCapture();            //設置屬於當前對象的鼠標捕捉
	z = obj_b.style.zIndex;          //獲取對象的z軸坐標值
	obj_b.style.zIndex = 100;
	x = event.offsetX;   //獲取鼠標指針位置相對於觸發事件的對象的X坐標
	y = event.offsetY;   //獲取鼠標指針位置相對於觸發事件的對象的Y坐標
	down = true;         //布爾值，判斷鼠標是否已按下，true為按下，false為未按下
}

function moveit(){
	if(down){
		with(obj_b.style){
			posLeft = document.body.scrollLeft+event.x-x;
			posTop = document.body.scrollTop+event.y-y;
		}
	}
}

function stopdrag(){
	//onmouseup事件觸發時說明鼠標已經鬆開，所以設置down變量值為false
	if(down){
		down=false; 
		obj_b.style.zIndex=z;       //還原對象的Z軸坐標值
		obj_b.releaseCapture(); //釋放當前對象的鼠標捕捉
	}
} 

function createXMLHttpRequest(){
	if(window.ActiveXObject)	return new ActiveXObject("Microsoft.XMLHTTP");
	else if(window.XMLHttpRequest)	return new XMLHttpRequest();
	else				return null;
}

function $(id){
	return document.getElementById(id);
}

function create(tag){
	return document.createElement(tag);
}

function createInput(type){
	var t = create("input");
	t.className = "btn";
	t.type = type;
	return t;
}

function createDiv(id, w, h, style){
	var out = document.createElement("div");
	out.className = style;
	out.style.width = w;
	out.style.height = h;
	return out;
}

function createWindow(id, style){
	var win = createDiv(id, 240, 100, style);
	var h = document.createElement("h1");
	h.appendChild(document.createTextNode("上傳檔案"));
	h.style.cursor = "move";
	h.onmousedown = init;
	win.appendChild(h);
	return win;
}

function createForm(url, name){
	var form = create("form");
	form.action  = url;
	form.enctype = "multipart/form-data";
	form.method  = "POST";

	var file = createInput("file");
	file.name = name;
	form.appendChild(file);
	form.appendChild(create("br"));

	var submit = createInput("button");
	submit.value = "確定送出";
	form.appendChild(submit);

	var close = createInput("button");
	close.value = "取消上傳";
	form.appendChild(close);
	
	return form;
}

function upload_file(url, name){
	flag = flag + 1;

	var win = createWindow(flag, "upload");
	var form = createForm(url, name);

	win.appendChild(form);
	var body = document.getElementsByTagName("body")[0];
	body.appendChild(win);
}
