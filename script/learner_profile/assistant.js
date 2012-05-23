function assign_data(block){
	var data = block.value.split(";");
	var form = document.getElementsByName("update")[0];
	form.login_id.value	= data[0];
	form.user_name.value	= data[1];
	form.email.value	= data[2];
	form.phone.value	= data[3];
	form.password.value	= data[4];
}
