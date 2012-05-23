function delete_question(survey_cd){
	if(confirm("確定刪除此問題？")){
		location.href = "delete.php?survey_cd=" + survey_cd;
	}
}
