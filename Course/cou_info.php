<?php
	/*author: lunsrot
	 * date: 2007/08/02
	 */
	/*角色分成測驗、作業、問卷的製作者和回答者和其他*/
	function returnRole($role_cd){
		if(!is_numeric($role_cd)) return -1;
		else if($role_cd == 3) return 2;
		else if($role_cd == 1 || $role_cd == 2) return 1;
		else return 3;
	}

?>
