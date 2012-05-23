function changeIframe(url){
  openWait();
  top.frames['index_iframe'].location.href=url;
}

function closeWait(){
  document.getElementById('please_wait').style.display ="none";
}

function openWait(){
  var div = document.getElementById('please_wait');//.style.display ="";
  div.style.left = 300;
  div.style.top = 200;
  div.style.display = "";
}

function init(){
  /*obj_b=event.srcElement.parentNode;     //事件觸發對象
  obj_b.setCapture();            //設置屬於當前對象的鼠標捕捉
  z = obj_b.style.zIndex;          //獲取對象的z軸坐標值
  //設置對象的z軸坐標值為100，確保當前層顯示在最前面
  obj_b.style.zIndex=100;
  x=event.offsetX;   //獲取鼠標指針位置相對於觸發事件的對象的X坐標
  y=event.offsetY;   //獲取鼠標指針位置相對於觸發事件的對象的Y坐標
  down=true;         //布爾值，判斷鼠標是否已按下，true為按下，false為未按下*/
}

