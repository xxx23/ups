function init(){
	$('_delete_course').onclick = function(){change_option('_delete_course');};
}

function change_option(input){
	if(confirm("此指令將會刪除部份資料，是否繼續執行？") == false)
		return ;
	delete_course.option.value = input;
	delete_course.submit();
}
