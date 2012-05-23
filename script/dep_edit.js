
function ylf(element_id, time, cancel){
	var i = time;
	obj = document.getElementById(element_id);
	if(obj != null){
		var dis = 255-25*i;
		var clr = "rgb(255," + dis.toString() + "," + dis.toString() + ")";
                obj.style.color = clr.toString();
	}

	i = i - 1;
	if(i>=0)	setTimeout('ylf("' + element_id + '", ' + i + ', ' + cancel + ');',1000);
}
