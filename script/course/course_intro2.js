/*author: lunsrot
 *date: 2007/10/11
 *ps: 這支程式仍一個很重大的問題，當innerHTML在textarea與div之間作轉換時，會有問題產生
 */
window.onload = init;
var tmp_content, tmp_button;

function init(){
	var btn = new Array("_introduction","_audience","_outline","_goal","_prepare_course", "_mster_book", "_ref_book", "_ref_url","_note");

	for(var i = 0 ; i < btn.length ; i++){
        
        if($(btn[i]) != null)
        {
		    $(btn[i]).onclick = open_edit;
		    Element.hide("img" + btn[i]);
        }
	}
}

//將畫面轉為可編輯
function open_edit(en){
	en = en || window.event;
	var src = Event.element(en);
	tmp_button = src;
	Element.hide(src);
	var div = $("edit" + src.id);
	var cpy = div.innerHTML;
	while(div.hasChildNodes() == true)
		div.removeChild(div.firstChild);
	div.appendChild(createTextarea(cpy, 55, 15));
	tinyMCE.execCommand('mceAddControl', false, 'content_area');
	stop_button("編輯");
	var submit = addButton(div, "確定送出");
	submit.onclick = _send;
	var cancal = addButton(div, "放棄修改");
	cancal.onclick = _reset;
}

//產生textarea
function createTextarea(str, w, h){
	var area = document.createElement("textarea");
	area.cols = w;
	area.rows = h;
	area.id = "content_area";
	area.appendChild(document.createTextNode(str));
	tmp_content = str;
	return area;
}

//新增按鈕，用於產生確定送出和放棄修改兩個按鈕
function addButton(div, str){
	var par = div.parentNode;
	var i = document.createElement("input");
	i.type = "button";
	i.value = str;
	i.className = "btn";
	par.appendChild(i);
	return i;
}

//ajax，將資訊送往CGI
function _send(en){
	en = en || window.event;
	var div = Event.element(en).parentNode.getElementsByTagName("div")[0];
	var cpy = tinyMCE.getContent();//div.getElementsByTagName("textarea")[0].innerHTML;
	_update_div(div, cpy);
	Element.show("img" + div.id.slice("edit".length));

	var _url = "tea_course_intro2.php";
	var _parm = "updatefield=" + div.id.slice("edit_".length) + "&updatetext=" + encodeURIComponent(cpy);
	var _course_cd = GetQueryString('course_cd');
	if(_course_cd != null)
		_parm += "&course_cd=" + _course_cd;
	var ajax = new Ajax.Request(_url, 
	{method:'POST',
	 parameters: _parm,
	 onSuccess: show_result
	});
	stop_button(-1);
}

//放棄修改
function _reset(en){
	if(!confirm("你剛剛所編寫的資料，將不會寫入，你確定放棄嗎？"))
		return false;
	en = en || window.event;
	var par = Event.element(en).parentNode;
	var div = par.getElementsByTagName("div")[0];
	var t_area = div.getElementsByTagName("textarea")[0];
	_update_div(div, tmp_content);
	_deleteButton(div.parentNode);
	Element.show(tmp_button);
	tmp_button = null;
	start_button();
}

//將div的內容更新，確定送出和放棄修改都會用到
function _update_div(div, content){
	while(div.hasChildNodes() == true)
		div.removeChild(div.firstChild);
	div.innerHTML = content;
}

//ajax的結果
function show_result(reqObj){
	_deleteButton(tmp_button.parentNode);
	Element.show(tmp_button);
	Element.hide("img" + tmp_button.id);
	tmp_button = null;
	start_button();
}

//將確定送出和放棄修改兩個按鈕移除
function _deleteButton(tar){
	tar.removeChild(tar.lastChild);
	tar.removeChild(tar.lastChild);
}

function stop_button(str){
	var btn = document.getElementsByTagName("input");
	for(var i = 0 ; i < btn.length ; i++){
		if(str == -1 && btn[i].type.toLowerCase() == "button")
			btn[i].disabled = true;
		else(btn[i].type.toLowerCase()  == "button" && str == "編輯")
			btn[i].disabled = true;
	}
}

function start_button(){
	var btn = document.getElementsByTagName("input");
	for(var i = 0 ; i < btn.length ; i++){
		if(btn[i].type.toLowerCase() == "button")
			btn[i].disabled = false;
	}
}

function GetQueryString(name)
{
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null)
                return unescape(r[2]);
        else
                return   null;
}

