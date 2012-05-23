    /* author: ghost777
	 * date: 2007/11/23
	 */

var block_v, block_s;
var url = "ajax/register_name.php";

function register_single(survey_no, b){
	var par = "survey_no=" + survey_no;
	block_v = b;
	var ajax = new Ajax.Request(url,
	{
		method: 'POST',
		parameters: par,
		onComplete: complete_register
	});
}

function complete_register(obj){
	block_v.firstChild.src = obj.responseText;
}
