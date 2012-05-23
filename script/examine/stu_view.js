function enterExamine(test_no){
	location.href = "stu_examine.php?option=view&test_no=" + test_no;
}

function viewAnswer(test_no){
	location.href = "viewAnswer.php?test_no=" + test_no;
}
