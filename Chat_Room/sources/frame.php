<?PHP
///////////////////////////////////////////////////////////////
//
//		X7 Chat Version 2.0.5
//		Released Jan 6, 2007
//		Copyright (c) 2004-2006 By the X7 Group
//		Website: http://www.x7chat.com
//
//		This program is free software.  You may
//		modify and/or redistribute it under the
//		terms of the included license as written
//		and published by the X7 Group.
//
//		By using this software you agree to the
//		terms and conditions set forth in the
//		enclosed file "license.txt".  If you did
//		not recieve the file "license.txt" please
//		visit our website and obtain an official
//		copy of X7 Chat.
//
//		Removing this copyright and/or any other
//		X7 Group or X7 Chat copyright from any
//		of the files included in this distribution
//		is forbidden and doing so will terminate
//		your right to use this software.
//
////////////////////////////////////////////////////////////////EOH
?><?PHP

// changing this to false will display all previous messages upon entering a chat room
$x7c->settings['use_old_sessionmsg_mode'] = true;

// changing this to true will cause enter messages for every other user currently in the room
// to be shown to the user who is entering
$x7c->settings['use_old_sessionentermsg_mode'] = false;

if(!isset($_GET['frame']))
  $_GET['frame'] = 'main';

if(!isset($_GET['room']))
  die("Fatal error, room name not set.");

switch($_GET['frame']){
case "update":

  // Make sure they are not trying to cache this page
  header("Content-type: text/plain; charset=UTF-8");
  header("Cache-Control: no-cache");
  header("Expires: Thu, 1 Jan 1970 0:00:00 GMT");

  // This is the update frame, output raw data with no standard HTML code
  if(!isset($_GET['listhash']))
    $_GET['listhash'] = '';
  if(!isset($_GET['startfrom']))
    $_GET['startfrom'] = 0;
  else
    $_GET['startfrom'] = intval($_GET['startfrom']);
  $endon = $_GET['startfrom'];

  // See if the room is being loaded for the first time (create a new session)
  if($_GET['startfrom'] == 0){
    $db->DoQuery("DELETE FROM {$prefix}online WHERE name='$x7s->username' AND room='$_GET[room]'");

    $endon = -1;

    $x7c->room_data['greeting'] = preg_replace("/@/","74ce61f75c75b155ea7280778d6e8183",$x7c->room_data['greeting']);
    $x7c->room_data['greeting'] = preg_replace("/\|/","74ce61f75c75b155ea7280778d6e8181",$x7c->room_data['greeting']);
    $x7c->room_data['greeting'] = preg_replace("/;/","74ce61f75c75b155ea7280778d6e8182",$x7c->room_data['greeting']);

    echo ("8;<b><font color=\"{$x7c->settings['system_message_color']}\">{$x7c->room_data['greeting']}</font></b><br>|");
    $x7c->room_data['greeting'] = eregi_replace("'","\\'",$x7c->room_data['greeting']);
  }

  // Include some libaries
  //include("./lib/online.php");
  //include("./lib/message.php");
  // nevermind these libraries are shit reprogram them here:
  function format_timestamp($time){
    global $x7c;
    $time = $time+(($x7c->settings['time_offset_hours']*3600)+($x7c->settings['time_offset_mins']*60));
    return date("[".$x7c->settings['date_format']."]",$time);
  }

  // Are you allowed to see invisible users?
  if($x7c->permissions['c_invisible'] == 1)
    $invis = "";
  else
    $invis = "AND invisible<>'1' ";

  // Force online_time to be above the max refresh rate
  if($x7c->settings['online_time']*1000 < $x7c->settings['max_refresh'])
    $x7c->settings['online_time'] = ceil($x7c->settings['max_refresh']/1000)+5;

  $exp_time = time() - $x7c->settings['online_time'];
  $room_ops = explode(";",$x7c->room_data['ops']);
  $no_repeat_check = array();

  $listhash = '';
  $ops = '';
  $users = '';
  $total = 0;
  $your_record = array();
  $qitu = array();
  $oldlisthash = $_GET['listhash'];
  $_GET['listhash'] = explode(",",$_GET['listhash']);

  $query = $db->DoQuery("SELECT o.*,u.id FROM {$prefix}online o, {$prefix}users u WHERE o.room='$_GET[room]' AND u.username=o.name {$invis}ORDER BY o.name ASC");

  while($row = $db->Do_Fetch_Row($query)){

    if(isset($no_repeat_check[$row[7]]))
      continue;
    else
      $no_repeat_check[$row[7]] = true;
    $qitu[$row[7]] = $row[1];

    if($row[5] < $exp_time)
      continue;

    if($row[1] == $x7s->username){
      // This is you
      $your_record = $row;
    }

    if(in_array($row[7],$room_ops))
      // Add to op list
      $list_2_add =& $ops;
    else
      // Add to user list
      $list_2_add =& $users;

    $row[1] = preg_replace("/,/","74ce61f75c75b155ea7280778d6e8180",$row[1]);
    $list_2_add .= "$row[1],";
    $listhash .= "$row[7],";
    $total++;

    // Check to see if this user is entering/leaving/staying in place
    if(!in_array($row[7],$_GET['listhash'])){
      if($row[1] != '' && ($x7c->settings['use_old_sessionentermsg_mode'] == true || $_GET['startfrom'] != 0))
	echo ("8;" . preg_replace("/;/","74ce61f75c75b155ea7280778d6e8182","<span style=\"color: {$x7c->settings['system_message_color']};font-size: {$x7c->settings['sys_default_size']}; font-family: {$x7c->settings['sys_default_font']};\"><b>$row[1] $txt[43]</b></span><Br>") . "|");
    }else{
      unset($_GET['listhash'][array_search($row[7],$_GET['listhash'])]);
    }
  }

  if(count($your_record) == 0){
    // Test if the room is full
    if($total >= $x7c->room_data['maxusers'])
      echo "9;;./index.php?act=overload|";

    // Create a new record for you
    $time = time();
    $ip = $_SERVER['REMOTE_ADDR'];
    $db->DoQuery("INSERT INTO {$prefix}online VALUES('0','$x7s->username','$ip','$_GET[room]','','$time','{$x7c->settings['auto_inv']}')");

  }else{
    // Update an old record
    $time = time();
    $db->DoQuery("UPDATE {$prefix}online SET time='$time' WHERE name='$x7s->username' AND room='$_GET[room]'");
  }

  // Handle leave messages
  foreach($_GET['listhash'] as $key=>$val){
    if($val != ''){
      echo ("8;" . preg_replace("/;/","74ce61f75c75b155ea7280778d6e8182","<span style=\"color: {$x7c->settings['system_message_color']};font-size: {$x7c->settings['sys_default_size']}; font-family: {$x7c->settings['sys_default_font']};\"><b>$qitu[$val] $txt[44]</b></span><Br>") . "|");
    }
  }

  // Export stuff if needed
  if($oldlisthash != $listhash){
    $ops = preg_replace("/\|/","74ce61f75c75b155ea7280778d6e8181",$ops);
    $users = preg_replace("/\|/","74ce61f75c75b155ea7280778d6e8181",$users);
    $ops = preg_replace("/;/","74ce61f75c75b155ea7280778d6e8182",$ops);
    $users = preg_replace("/;/","74ce61f75c75b155ea7280778d6e8182",$users);
    echo ("2;$ops|");
    echo ("3;$users|");
    echo ("4;$listhash|");
  }

  $offline_msgs = 0;
  $pm_time = time()-2*($x7c->settings['refresh_rate']/1000);
  $pm_etime = time()-4*($x7c->settings['refresh_rate']/1000);
  $private_msgs = 0;

  $query = $db->DoQuery("SELECT user,type,body_parsed,time,id FROM {$prefix}messages WHERE
    user<>'$x7s->username'
    AND (
      (id>'$_GET[startfrom]'
      AND (
	(room='$_GET[room]' AND (type='1' OR type='4')) OR
	(room='$x7s->username' AND type='3') OR
	(type='2') OR
	(room='$x7s->username:0' AND type='5' AND time<$pm_time)
      )
    )
    OR (room='$x7s->username' AND type='6' AND time='0')
  )
  ORDER BY id ASC");

  if($db->error == 4){
    $query = eregi_replace("'","\\'",$query);
    $query = eregi_replace("[\n\r]","",$query);
    echo "9;;./index.php?act=panic&dump=$query&source=/sources/frame.php:155";
  }

  while($row = $db->Do_Fetch_Row($query)){

    $endon = $row[4];

    if($x7c->settings['use_old_sessionmsg_mode'] && $_GET['startfrom'] == 0)
      continue;

    if(!in_array($row[0],$x7c->profile['ignored'])){
      if(isset($toout))
	unset($toout);
      //$row[2] = eregi_replace("'","\\'",$row[2]);

      if($row[1] == 1){
	// See if they want a timestamp
	if($x7c->settings['disble_timestamp'] != 1)
	  $timestamp = format_timestamp($row[3]);
	else
	  $timestamp = "";

	$toout = "<span class=\"other_persons\"><a class=\"other_persons\" onClick=\"javascript: window.open(\'index.php?act=pm&send_to=$row[0]\',\'Pm$row[0]\',\'location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}\');\">$row[0]</a>$timestamp:</span> $row[2]";
      }elseif($row[1] == 2 || $row[1] == 3 || $row[1] == 4){
	$toout = "$row[2]";
      }elseif($row[1] == 6){
	$offline_msgs++;
      }elseif($row[1] == 5){
	$row[0] = preg_replace("/@/","74ce61f75c75b155ea7280778d6e8183",$row[0]);
	$row[0] = preg_replace("/\|/","74ce61f75c75b155ea7280778d6e8181",$row[0]);
	$row[0] = preg_replace("/;/","74ce61f75c75b155ea7280778d6e8182",$row[0]);
	echo ("7;$row[0]|");
	$db->DoQuery("UPDATE {$prefix}messages SET time='$pm_etime' WHERE id='$row[4]'");
      }

      if(isset($toout)){
	$toout = preg_replace("/\|/","74ce61f75c75b155ea7280778d6e8181",$toout);
	$toout = preg_replace("/;/","74ce61f75c75b155ea7280778d6e8182",$toout);
	echo ("8;$toout<br>|");
      }

    }
  }

  echo ("5;$endon|");
  echo ("6;$offline_msgs|");

  // Check bans
  $bans = $x7p->bans_on_you;

  foreach($bans as $key=>$row){

    // If a row returned and they don't have immunity then thrown them out the door and lock up
    if($row != "" && $x7c->permissions['ban_kick_imm'] != 1){
      if($row[1] == "*"){
	// They are banned from the server
	$txt[117] = eregi_replace("_r",$row[5],$txt[117]);
	echo ("9;$txt[117];./index.php|");
      }elseif($row[1] == $x7c->room_data['id'] && $row[4] == 60){
	// They are kicked from this room
	$txt[115] = eregi_replace("_r",$row[5],$txt[115]);
	echo ("9;$txt[115];./index.php?act=kicked|");
	$db->DoQuery("DELETE FROM {$prefix}online WHERE name='$x7s->username' AND room='$_GET[room]'");
      }elseif($row[1] == $x7c->room_data['id']){
	// They are banned from this room
	$txt[116] = eregi_replace("_r",$row[5],$txt[116]);
	echo ("9;$txt[116];./index.php?act=kicked|");
	$db->DoQuery("DELETE FROM {$prefix}online WHERE name='$x7s->username' AND room='$_GET[room]'");
      }
    }
  }

  // See if they have used up all their allowed bandwidth
  if($x7c->settings['log_bandwidth'] == 1){
    if($BW_CHECK){
      echo "9;;./index.php|";
    }
  }

  break;
case "send":
  // Include the message library
  include("./lib/message.php");

  // Make sure the message isn't null
  if(@$_GET['msg'] != "" && !eregi("^/",@$_GET['msg'])){

    // Save the style settings they used for next time
    $x7c->edit_user_settings("default_font",$_GET['curfont']);
    $x7c->edit_user_settings("default_size",$_GET['cursize']);
    $x7c->edit_user_settings("default_color",$_GET['curcolor']);

    // Get the styles
    $starttags = "";
    $endtags = "";
    $color = $_GET['curcolor'];
    $size = eregi_replace(" Pt","pt",$_GET['cursize']);
    $font = $_GET['curfont'];

    // Make sure incoming values are safe
    $_GET['msg'] = eregi_replace("<","&lt;",$_GET['msg']);
    $color = eregi_replace("<","&lt;",$color);
    $size = eregi_replace("<","&lt;",$size);
    $font = eregi_replace("<","&lt;",$font);

    $starttags .= "[color=$color][size=$size][font=$font]";

    // Add the styles
    if($_GET['bold'] == 1){
      $starttags .= "[b]";
      $endtags .= "[/b]";
    }
    if($_GET['italic'] == 1){
      $starttags .= "[i]";
      $endtags .= "[/i]";
    }
    if($_GET['under'] == 1){
      $starttags .= "[u]";
      $endtags .= "[/u]";
    }

    $endtags .= "[/color][/size][/font]";

    $parsed_msg = $starttags.$_GET['msg'].$endtags;

    // Make sure the user has a voice
    if($x7c->permissions['room_voice'] == 1){
      send_message($parsed_msg,$x7c->room_name);

    }else{
      // The user doesn't have a voice, alert them
      alert_user($x7s->username,$txt[42]);
    }

  }elseif(eregi("^/",@$_GET['msg'])){
    // User has done a command
    include("./lib/irc.php");
    parse_irc_command(@$_GET['msg']);
  }

  break;
case "profile":

  if(!isset($_GET['user']) || !isset($_GET['room'])){
    echo "<html>&nbsp;</html>";
  }else{

    // Include the needed user control library
    include("./lib/usercontrol.php");

    // Get profile info on this user
    $user_info = new user_control($_GET['user']);
    $ui = $user_info->generate_profile_tab();
    $status = $ui['status'];
    $ug = $ui['group'];

    // Get action info on this user
    // This information is in the pattern of (by indexes)
    // 0: label
    // 1: action
    // 2: label
    // 3: action
    // ect. up to 9 (last action)
    $user_action = $user_info->generate_action_tab();

    while(count($user_action) < 10){
      $user_action[count($user_action)] = "";
    }

    if(!isset($_GET['tto']))
      $tto = "openActionBox();";
    else
      $tto = "openProfileBox();";

    // Convert to javascript and send to user
    echo "<script language=\"javascript\" type=\"text/javascript\">

      with(window.parent){\n
      userInfo['username'] = '$_GET[user]';\n
      userInfo['status'] = '$status';\n
      userInfo['usergroup'] = '$ug';\n

      userInfo['label1'] = '$user_action[0]';\n
      userInfo['label2'] = '$user_action[2]';\n
      userInfo['label3'] = '$user_action[4]';\n
      userInfo['label4'] = '$user_action[6]';\n
      userInfo['label5'] = '$user_action[8]';\n

      userInfo['action1'] = '$user_action[1]';\n
      userInfo['action2'] = '$user_action[3]';\n
      userInfo['action3'] = '$user_action[5]';\n
      userInfo['action4'] = '$user_action[7]';\n
      userInfo['action5'] = '$user_action[9]';\n

    {$tto}
  }\n
				</script>";
			}
		break;
		default:
			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
			echo "<html dir=\"$print->direction\"><head><title>{$x7c->settings['site_name']} -- $_GET[room]</title>";
			echo $print->style_sheet;
			echo $print->ss_mini;
			echo $print->ss_chatinput;
			echo $print->ss_uc;

			?>
				</head>
					<body onload="javascript: do_initial_refresh();openActionBox();">
					<iframe style='position: absolute;visibility: hidden;' src="index.php?act=frame&frame=send&room=<?PHP echo $x7c->room_name; ?>" name="send" frameborder="0" scrolling="no" marginwidth="0" marginheight="0" noresize="true"></iframe>
					<iframe style='position: absolute;visibility: hidden;' src="index.php?act=frame&frame=profile" name="profile" frameborder="0" scrolling="no" marginwidth="0" marginheight="0" noresize="true"></iframe>
			<script langauge="javascript" type="text/javascript">
			listhash = '';
			startfrom = 0;

			function do_initial_refresh(){
			  // Create object
			  chatRefresh = setInterval('do_refresh()','<?PHP echo $x7c->settings['refresh_rate']; ?>');
			  do_refresh();
			}

			function requestReady_channel1(){
			  if(httpReq1){
			    if(httpReq1.readyState == 4){
			      if(httpReq1.status == 200){

				// Request is all ready to go

				document.getElementById('debug').innerHTML = httpReq1.responseText.replace(/</g,'&lt;');
				playSound = 0;

				var dataArray = httpReq1.responseText.split("|");
				for(x = 0;x < dataArray.length;x++){
				  var dataSubArray = dataArray[x].split(";");
				  if(dataSubArray[0] == '2'){
				    // Operators for userlist
				    document.getElementById("onlinelist").innerHTML = '';

				    var dataSubArray2 = dataSubArray[1].split(",");
				    for(x2 = 0;x2 < dataSubArray2.length;x2++){
				      if(dataSubArray2[x2] != ''){
					dataSubArray2[x2] = restoreText(dataSubArray2[x2]);
					document.getElementById("onlinelist").innerHTML += "<img src=\"<?php echo $print->image_path; ?>/op_icon.gif\"> <a style=\"cursor: pointer;\" onClick=\"javascript: frames[\'profile\'].document.location=\'./index.php?act=frame&frame=profile&room=<?PHP echo $_GET['room']; ?>&user=" + dataSubArray2[x2] + "\';clearTheWay();\">" + dataSubArray2[x2] + "</a><br>";
				      }
				    }

				    playSound = 2;

				  }else if(dataSubArray[0] == '3'){
				    // Users for userlist

				    var dataSubArray2 = dataSubArray[1].split(",");
				    for(x2 = 0;x2 < dataSubArray2.length;x2++){
				      if(dataSubArray2[x2] != ''){
					dataSubArray2[x2] = restoreText(dataSubArray2[x2]);
					document.getElementById("onlinelist").innerHTML += "<a style=\"cursor: pointer;\" onClick=\"javascript: frames[\'profile\'].document.location=\'./index.php?act=frame&frame=profile&room=<?PHP echo $_GET['room']; ?>&user=" + dataSubArray2[x2] + "\';clearTheWay();\">" + dataSubArray2[x2] + "</a><br>";
				      }
				    }

				    playSound = 2;

				  }else if(dataSubArray[0] == '4'){
				    // Listhash update
				    listhash = dataSubArray[1];
				  }else if(dataSubArray[0] == '5'){
				    // Endon update
				    startfrom = dataSubArray[1];
				  }else if(dataSubArray[0] == '6'){
				    // Number of offline messages update
				    document.getElementById('numpms').innerHTML = dataSubArray[1];
				  }else if(dataSubArray[0] == '7'){
				    // Private message
				    dataSubArray[1] = restoreText(dataSubArray[1]);
				    window.open('index.php?act=pm&send_to=' + dataSubArray[1],'Pm' + dataSubArray[1],'location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');

				    alertText = '<?PHP echo $txt[511]; ?>';
				    alertText = alertText.replace('<a>',"<a style=\"cursor: pointer;\" onClick=\"window.open('index.php?act=pm&send_to=" + dataSubArray[1] + "','Pm" + dataSubArray[1] + "','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');\">");
				    document.getElementById('message_window').innerHTML += "<span style=\"color: <?PHP echo $x7c->settings['system_message_color']; ?>;font-size: <?PHP echo $x7c->settings['sys_default_size']; ?>; font-family: <?PHP echo $x7c->settings['sys_default_font']; ?>;\"><b>" + alertText + "</b></span><Br>";

				    if(playSound == 0)
				      playSound = 1;

				  }else if(dataSubArray[0] == '8'){
				    // Message
				    dataSubArray[1] = restoreText(dataSubArray[1]);
				    document.getElementById('message_window').innerHTML += dataSubArray[1];

				    if(playSound == 0)
				      playSound = 1;

				  }else if(dataSubArray[0] == '9'){
				    // Redirect w/ error msg
				    dataSubArray[1] = restoreText(dataSubArray[1]);
				    if(dataSubArray[1] != '')
				      alert(dataSubArray[1]);
				    document.location = dataSubArray[2];
				  }

				  // Scroll to bottom
				  document.getElementById('message_window').scrollTop = 65000;

				}

				if(<?PHP echo $x7c->settings['disable_sounds']; ?> != 1 && playSound != 0){

				  if(playSound == 1){
				    try { document.snd_msg.Play(); } catch(e) {}
				  }else{
				    try { document.snd_enter.Play(); } catch(e) {}
				  }

				}
			      }
			    }
			  }
			}

			function restoreText(torestore){
			  torestore = torestore.replace(/74ce61f75c75b155ea7280778d6e8183/g,"@");
			  torestore = torestore.replace(/74ce61f75c75b155ea7280778d6e8181/g,"|");
			  torestore = torestore.replace(/74ce61f75c75b155ea7280778d6e8182/g,";");
			  torestore = torestore.replace(/74ce61f75c75b155ea7280778d6e8180/g,",");
			  return torestore;
			}

			function do_refresh(){
			  jd=new Date();
			  nocache = jd.getTime();
			  //changed
			  url = './index.php?act=frame&frame=update&room=<?PHP echo urlencode($x7c->room_name); ?>&listhash=' + listhash + '&startfrom=' + startfrom + '&nc=' + nocache;							if(window.XMLHttpRequest){
			    try {
			      httpReq1 = new XMLHttpRequest();
			    } catch(e) {
			      httpReq1 = false;
			    }
			  }else if(window.ActiveXObject){
			    try{
			      httpReq1 = new ActiveXObject("Msxml2.XMLHTTP");
			    }catch(e){
			      try{
				httpReq1 = new ActiveXObject("Microsoft.XMLHTTP");
			      }catch(e){
				httpReq1 = false;
			      }
			    }
			  }
			  httpReq1.onreadystatechange = requestReady_channel1;
			  httpReq1.open("GET", url, true);
			  httpReq1.send("");
			}

			</script>
					<table border="0" cellspacing="0" cellpadding="0" width="525" align="center" height="22%">
						<tr valign="top">
<!--
							<td colspan="3" height="30" width="225">
								<?PHP if($x7c->settings['banner_link'] != "") echo "<a href=\"{$x7c->settings['banner_link']}\" target=\"_blank\">"; ?><img src="<?PHP echo $x7c->settings['banner_url']; ?>" align="middle" border="0"><?PHP if($x7c->settings['banner_link'] != "") echo "</a>"; ?>
								&nbsp; &nbsp;
							</td>
--!>
							<td colspan="4" class="infobar">
								<table height="30" border="0" cellspacing="0" cellpadding="0" class="infobar">
									<tr valign="top">
										<td width="160">
											<form name="pm_form">
											<b><?PHP echo $x7s->username; ?></b><Br>
											<?PHP echo $_GET['room']; ?><Br>
											<a style="cursor: pointer;" onClick="window.open('index.php?act=userpanel&cp_page=msgcenter','MsgCenter','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');"><?PHP echo $txt[514]; ?>: <div class="infobar" style="background: transparent;border: 0px;cursor: pointer;display: inline;" name="numpms" id="numpms">-</div></a>
											</form>
										</td>
										<td width="140" rowspan="4" style="text-align: right">
											<form name="inis_form">
<?PHP
			//**************************************************************//
			//	This is my copyright.  I ask you very kindly not to			//
			//	remove it.  I've spent over 300 hours of my life working
			//      on this one script and I am not getting school			//
			//	or work credit, nor am I going to get much money, if any,	//
			//	from it.  So if you don't want to pay for it the least you 	//
			//	can do is give me one line of credit.						//
			//**************************************************************//
			//
			print("<!----><div align=\"center\" style=\"font-size: 9px;\">Powered By X7 Chat $X7CHATVERSION &copy; 2004 By The X7 Group</div>");
			//
			//**************************************************************//
			//	Should you decide that you want to steal my work anyway, I 	//
			//	must inform you that removal of this copyright without 		//
			//	permission voids your right to use this software and you	//
			//	be required to cease all use of it immediatly.				//
			//**************************************************************//

			// Invisibility Button
			/* Test and see if they are allowed to be invisible, if they are then check if they currently care invisible or not and give them a button		. */
			if($x7c->permissions['b_invisible'] == 1){
			  echo "
			    <script language=\"javascript\" type=\"text/javascript\">
			function changeMsg(object){
			  if(object.value == \"$txt[523]\"){
			    object.value = \"$txt[524]\";
			}else{
			  object.value = \"$txt[523]\";
			}
			}
													</script>
													";
													if($x7c->settings['invisible'] == 1 || $x7c->settings['auto_inv'] == 1)
														echo "<input type=\"button\" readonly=\"true\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=invis&room=$_GET[room]','Invis','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');changeMsg(this);\" name=\"invis_tog\" value=\"$txt[524]\" class=\"button\">";
													else
														echo "<input type=\"button\" readonly=\"true\" onClick=\"javascript: window.open('./index.php?act=sm_window&page=invis&room=$_GET[room]','Invis','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_small_width']},height={$x7c->settings['tweak_window_small_height']}');changeMsg(this);\" name=\"invis_tog\" value=\"$txt[523]\" class=\"button\">";
												}
											?>
											</form>
										</td>
									</tr>
								</table>
							</td>
						</tr>
							<td colspan="7">
								<table border="0" align="center" cellspacing="0" cellpadding="0">
									<tr>
										<?PHP if($x7c->settings['single_room_mode'] == "") echo "<td class=\"menubar\" onMouseOver=\"javascript: this.className='menubar_hover'\" onMouseOut=\"javascript: this.className='menubar'\" height=\"30\" width=\"75\" onClick=\"javascript: window.open('index.php','RoomList','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">$txt[29]</td>";?>

										<td class="menubar" onMouseOver="javascript: this.className='menubar_hover'" onMouseOut="javascript: this.className='menubar'" height="30" width="75" onClick="javascript: window.open('index.php?act=userpanel','UserCP','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');"><?PHP echo $txt[35]; ?></td>
										<td class="menubar" onMouseOver="javascript: this.className='menubar_hover'" onMouseOut="javascript: this.className='menubar'" height="30" width="75" onClick="javascript: window.open('index.php?act=userpanel&cp_page=status','Status','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');"><?PHP echo $txt[40]; ?></td>
										<?PHP #<td class="menubar" onMouseOver="javascript: this.className='menubar_hover'" onMouseOut="javascript: this.className='menubar'" height="30" width="75" onClick="javscript: window.open('./help/','Help');">?><?PHP #echo $txt[34]; ?><?PHP #</td>?>
										<td class="menubar" onMouseOver="javascript: this.className='menubar_hover'" onMouseOut="javascript: this.className='menubar'" height="30" width="75"  onClick="javascript: document.location='./index.php?act=logout';"><?PHP echo $txt[16]; ?></td>
										<?PHP if($x7c->permissions['room_operator'] == 1){ echo "<td class=\"menubar\" onMouseOver=\"javascript: this.className='menubar_hover'\" onMouseOut=\"javascript: this.className='menubar'\" height=\"30\" width=\"75\" onClick=\"javascript: window.open('index.php?act=roomcp&room=$_GET[room]','RoomCP','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">$txt[41]</td>"; } ?>
										<?PHP if($x7c->permissions['admin_access'] == 1){ echo "<td class=\"menubar\" onMouseOver=\"javascript: this.className='menubar_hover'\" onMouseOut=\"javascript: this.className='menubar'\" height=\"30\" width=\"75\" onClick=\"javascript: window.open('index.php?act=adminpanel','AdminCP','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width={$x7c->settings['tweak_window_large_width']},height={$x7c->settings['tweak_window_large_height']}');\">".$txt[37].'</td>'; } ?>
									</tr>
								</table>
							</td>
						</tr>
					</table>

<?PHP
			$background = "";
			if($x7c->settings['background_image'] != "")
			  $background = "background-attachment: fixed;background-image: url({$x7c->settings['background_image']});";
?>
					<div id="message_window" style='width: 75%;height: 53%;float: left;<?PHP echo "$background"; ?>'></div>
&nbsp;&nbsp;目前線上使用人數: 
					<div class="online_list" style='width: 18%;float: left;height: 50%;text-align: center;'><div id="onlinelist" style='overflow: scroll;height: 100%;'><?PHP echo $txt[90]; ?></div></div>
					<div style='clear: both;'></div>
					<div style='float: left;height: 25%;width: 75%;text-align: center;margin-right: 5px;margin-left: 5px;padding-left: 5px;padding-right: 5px;'>
			<script langauge="javascript" type="text/javascript">
			SelectorMenu = new Array();
			SelectorMenu['fontselector'] = 0;
			SelectorMenu['sizeselector'] = 0;
			fontTimeout = "";
			sizeTimeout = "";

			function doSelect(object){
			  object.className = 'selected';
			}
			function doDeSelect(object){
			  object.className = '';
			}

			function ClickedSelector(menu){
			  popUpAddr = document.getElementById(menu).style
			    if(SelectorMenu[menu] == 0){
			      popUpAddr.visibility='visible';
			      SelectorMenu[menu] = 1;
			    }else{
			      popUpAddr.visibility='hidden';
			      SelectorMenu[menu] = 0;
			    }
			}

			function closeMenu(menu){
			  popUpAddr = document.getElementById(menu).style
			    popUpAddr.visibility='hidden';
			  SelectorMenu[menu] = 0;
			}

			function doClickFont(font){
			  ClickedSelector('fontselector');
			  document.chatIn.curfont.value=font;
			  document.getElementById('curfontd').innerHTML=font;
			}

			function DoClickSize(in_font){
			  ClickedSelector('sizeselector');

			  in_font = in_font.replace(/[a-z]*$/i,"");

			  if(in_font < <?PHP echo $x7c->settings['style_min_size']; ?>){
			    in_font = "<?PHP echo $x7c->settings['style_min_size']; ?>";
			  }

<?PHP
			$max_size = $x7c->settings['style_max_size'];
			if($max_size != 0){
			  echo "if(in_font > $max_size){\n
			    in_font = \"$max_size\";\n
			}\n";
			}
?>

			document.chatIn.cursize.value=in_font+" Pt";
			document.getElementById('cursized').innerHTML=in_font+" Pt";
			}

			function styleOut(object,name){
			  ref = "itemh = document.chatIn."+name;
			  eval(ref);
			  if(itemh.value == 0){
			    object.className='boldtxt';
			  }
			}

			function styleClicked(object,name){
			  ref = "itemh = document.chatIn."+name;
			  eval(ref);
			  if(itemh.value == 0){
			    object.className='boldtxtdown';
			    itemh.value = 1;
			  }else{
			    object.className='boldtxt';
			    itemh.value = 0;
			  }
			}

			function styleOver(object,name){
			  ref = "itemh = document.chatIn."+name;
			  eval(ref);
			  if(itemh.value == 0){
			    object.className='boldtxtover';
			  }
			}

			function msgSent(){
			  message = document.chatIn.msgi.value;
			  message = message.replace(/\+/gi,"%2B");
			  document.chatIn.msg.value=message;
			  cache.unshift(message);
			  message = message.replace(/%2B/gi,"+");
			  if(message != ""){
			    document.chatIn.msgi.value=''
			      document.chatIn.msgi.focus();

			    // Some special things
			    if(message.match(/^\/clear/)){
			      document.getElementById('message_window').innerHTML = '';
			      document.chatIn.msg.value='';
			    }
			    if(message.match(/^\/debug_on/)){
			      document.getElementById('debug').style.display = 'block';
			      document.chatIn.msg.value='';
			    }
			    if(message.match(/^\/debug_off/)){
			      document.getElementById('debug').style.display = 'none';
			      document.chatIn.msg.value='';
			    }

			    // Parse/Add styles
			    color = document.chatIn.curcolor.value;
			    size = document.chatIn.cursize.value;
			    size = size.replace(" Pt","pt");
			    font = document.chatIn.curfont.value;
			    starttags = "<span style=\"font-family:"+font+"; color:"+color+"; font-size:"+size+"\">";
			    endtags = "</span>";

			    if(document.chatIn.bold.value == 1){
			      starttags = starttags+"<b>";
			      endtags = endtags+"</b>";
			    }

			    if(document.chatIn.italic.value == 1){
			      starttags = starttags+"<i>";
			      endtags = endtags+"</i>";
			    }

			    if(document.chatIn.under.value == 1){
			      starttags = starttags+"<u>";
			      endtags = endtags+"</u>";
			    }

			    // Inline styles
			    // replace < tags
			    message = message.replace(/</gi,"&lt;");

			    // Match Size Tags
			    while(message.match(/\[size=[^\]]*\][^\]]*\[\/size\]/i)){
			      temp = message.match(/\[size=[^\]]*\]/i);
			      temps = ""+temp;	// Convert to string
			      temps = temps.replace(/\[size=/i,"");
			      temps = temps.replace("]","");
			      message = message.replace(/\[size=[^\]]*\]/i,"<span style=\"font-size: "+temps+"\">");
			      message = message.replace(/\[\/size\]/i,"</span>");
			    }

			    // Match Color Tags
			    while(message.match(/\[color=[^\]]*\][^\]]*\[\/color\]/i)){
			      temp = message.match(/\[color=[^\]]*\]/i);
			      temps = ""+temp;	// Convert to string
			      temps = temps.replace(/\[color=/i,"");
			      temps = temps.replace("]","");
			      message = message.replace(/\[color=[^\]]*\]/i,"<span style=\"color: "+temps+"\">");
			      message = message.replace(/\[\/color\]/i,"</span>");
			    }

			    // Match font Tags
			    while(message.match(/\[font=[^\]]*\][^\]]*\[\/font\]/i)){
			      temp = message.match(/\[font=[^\]]*\]/i);
			      temps = ""+temp;	// Convert to string
			      temps = temps.replace(/\[font=/i,"");
			      temps = temps.replace("]","");
			      message = message.replace(/\[font=[^\]]*\]/i,"<span style=\"font-family: "+temps+"\">");
			      message = message.replace(/\[\/font\]/i,"</span>");
			    }

			    // Bold Italic and Unerline
			    while(message.match(/\[b\][^\]]*\[\/b\]/i)){
			      message = message.replace(/\[b\]/i,"<b>");
			      message = message.replace(/\[\/b\]/i,"</b>");
			    }

			    while(message.match(/\[i\][^\]]*\[\/i\]/i)){
			      message = message.replace(/\[i\]/i,"<i>");
			      message = message.replace(/\[\/i\]/i,"</i>");
			    }

			    while(message.match(/\[u\][^\]]*\[\/u\]/i)){
			      message = message.replace(/\[u\]/i,"<u>");
			      message = message.replace(/\[\/u\]/i,"</u>");
			    }

<?PHP
			// Do Keyword parsing, Smilie parsing and filter parsing
			include("./lib/filter.php");
			$msg_filter = new filters($_GET['room']);
			echo $msg_filter->filter_javascript();
?>

			// Add styles to message
			message = starttags+message+endtags;

			timestamp = '';
			// Do timestamp
<?PHP
			if($x7c->settings['disble_timestamp'] != 1){
?>
			  d = new Date();

			  hours = ""+d.getHours();
			  mins = ""+d.getMinutes();
			  secs = ""+d.getSeconds();

<?PHP
			  // The following is a bunch of javascript that emulates the PHP's date() function to a small extent
			  //  PHP date |	JAVASCRIPT variable
			  $dc['a'] = "if(hours > 12)\njva = 'pm';\nelse\njva = 'am';\n\n";
			  $dc['A'] = "if(hours > 12)\njvA = 'PM';\nelse\njvA = 'AM';\n\n";
			  $dc['g'] = "if(hours > 12)\njvg = hours-12;\nelse\njvg = hours;\n\n";
			  $dc['G'] = "jvG = hours;";
			  $dc['h'] = "if(hours > 12)\njvh = ''+(hours-12);\nelse\njvh = ''+hours;\nif(jvh.length == 1)\njvh = '0'+jvh;\n\n";
			  $dc['H'] = "jvH = hours;\nif(jvH.length == 1)\njvH = '0'+jvH;\n\n";
			  $dc['i'] = "jvi = ''+mins;\nif(jvi.length == 1)\njvi = '0'+jvi;\n\n";
			  $dc['s'] = "jvs = ''+secs;\nif(jvs.length == 1)\njvs = '0'+jvs;\n\n";
			  $dc['U'] = "jvU = d.getTime()/1000;\n\n";

			  // The dateformat (Using PHP syntax only a,A,g,G,h,H,i,s and U are supported)
			  $df = $x7c->settings['date_format'];

			  // THis will be printed, only the needed javascript from above will be added
			  $script = "";

			  // replace the PHP symbols in $df with the javascript counterpart
			  foreach($dc as $phps=>$js){
			    $olddf = $df;

			    // Preserve any special characters that are back slashed
			    $df = ereg_replace("\\\\$phps","o_2R\n08_f",$df);

			    // DO the switch
			    $df = ereg_replace("$phps","\"+jv{$phps}+\"",$df);

			    // Restore those characters who were preserved
			    $df = ereg_replace("o_2R\n08_f","$phps",$df);

			    // If there was a change then we need this javascript printed
			    if($olddf != $df)
			      $script .= $js;
			  }
?>
			  <?PHP echo $script; ?>
			  timestamp = "[<?PHP echo $df; ?>]";
<?PHP
			}
?>

			// Put it into screen
			document.getElementById('message_window').innerHTML += '<span class="you"><?PHP echo $x7s->username; ?>'+timestamp+':</span> '+message+'<Br>';

			// Scroll the screen
			document.getElementById('message_window').scrollTop = 65000;
			  }
			}

			// This function reads key presses
			document.onkeydown = kp;
			consec = -1;
			function kp(evt){
			  if(evt)
			    thisKey = evt.which
			  else
			    thisKey = window.event.keyCode

			    // Up arrow key pressed
			    if(thisKey == 38 || thisKey == 40){
			      if(thisKey == 38)
				consec = consec+1;
			      if(thisKey == 40)
				consec = consec-1;
			      arrow();
			    }else{
			      consec = -1;
			    }

			}

			// This is code for handing the up arrow
			cache = new Array();
			function arrow(){

			  if(consec > cache.length-1)
			    consec = cache.length-1;
			  if(consec < -1)
			    consec = -1;

			  if(consec != -1)
			    document.chatIn.msgi.value = cache[consec];
			  else
			    document.chatIn.msgi.value = "";
			}

			</script>
						<form name="chatIn" method="get" action="index.php" target="send" onSubmit="msgSent();">
						<div id='debug' style='display: none;'>

						</div>
						<input type="hidden" name="act" value="frame">
						<input type="hidden" name="frame" value="send">
						<input type="hidden" name="room" value="<?PHP echo $_GET['room']; ?>">
						<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td height="10" colspan="11" width="10"><img src="<?PHP echo $print->image_path; ?>spacer.gif"></td>
							</tr>
							<tr valign="top">
								<td width="10">&nbsp;</td>
								<td width="95">
									<!-- Begin Select Area for Font -->
										<table border="0" cellspacing="0" cellpadding="0" class="nonSelected" onMouseOver="javascript: clearTimeout(fontTimeout);" onMouseOut="javascript: fontTimeout = setTimeout('closeMenu(\'fontselector\');',750);">
											<tr valign="middle">
												<td height="17" width="60" class="selectbar" onClick="javascript: ClickedSelector('fontselector');" onMouseOver="javascript: document.font_selector.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: document.font_selector.src='<?PHP echo $print->image_path; ?>selectarrow.gif'">&nbsp;<input type="hidden" name="curfont" value="<?PHP echo $x7c->settings['default_font']; ?>" class="curfont"><div id="curfontd" name="curfontd" style="display: inline;text-align: left;width: 65px;" width="65px"><?PHP echo $x7c->settings['default_font']; ?></div></td>
												<td height="17" class="arrow_box" onClick="javascript: ClickedSelector('fontselector');" width="17"><img name="font_selector" src="<?PHP echo $print->image_path; ?>selectarrow.gif" onMouseOver="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow.gif'"></td>
											</tr>
										</table>
										<div id="fontselector" style="visibility: hidden;z-Index: 3;position: relative;top: 0px;left:0px;">
											<table border="0" cellspacing="0" cellpadding="0" class="nonSelected" onMouseOver="javascript: clearTimeout(fontTimeout);" onMouseOut="javascript: fontTimeout = setTimeout('closeMenu(\'fontselector\');',750);">
												<tr>
													<td height="15" width="81" onClick="javascript: doClickFont('<?PHP echo $txt[55]; ?>');" onMouseOver="javascript: doSelect(this);" onMouseOut="javascript: doDeSelect(this);">&nbsp;<?PHP echo $txt[55]; ?> &nbsp;</td>
												</tr>
												<tr>
													<td height="15" width="81" onClick="javascript: doClickFont('<?PHP echo $x7c->settings['default_font']; ?>');" onMouseOver="javascript: doSelect(this);" onMouseOut="javascript: doDeSelect(this)">&nbsp;<?PHP echo $x7c->settings['default_font']; ?></td>
												</tr>
												<tr>
													<td height="15" width="81" onClick="javascript: window.open('./index.php?act=sm_window&page=fonts','Fonts','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" onMouseOver="javascript: doSelect(this);" onMouseOut="javascript: doDeSelect(this)">&nbsp;<?PHP echo $txt[56]; ?></td>
												</tr>
											</table>
										</div>
									<!-- End Select Area for Font -->
								</td>

								<td width="75">
									<!-- Begin Select Area for Size -->
										<table border="0" cellspacing="0" cellpadding="0" class="nonSelected"   onMouseOver="javascript: clearTimeout(sizeTimeout);" onMouseOut="javascript: sizeTimeout = setTimeout('closeMenu(\'sizeselector\');',750);">
											<tr valign="middle">
												<td height="17" width="40" class="selectbar" onClick="javascript: ClickedSelector('sizeselector');" onMouseOver="javascript: document.size_selector.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: document.size_selector.src='<?PHP echo $print->image_path; ?>selectarrow.gif'">&nbsp;<input type="hidden" name="cursize" value="<?PHP echo $x7c->settings['default_size']; ?>" class="cursize"><div name="cursized" id="cursized" style="display: inline;" width="40px"><?PHP echo $x7c->settings['default_size']; ?></div></td>
												<td height="17" class="arrow_box" onClick="javascript: ClickedSelector('sizeselector');" width="17"><img name="size_selector" src="<?PHP echo $print->image_path; ?>selectarrow.gif" onMouseOver="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow.gif'"></td>
											</tr>
										</table>

										<div id="sizeselector" style="visibility: hidden;z-Index: 3;position: relative;top: 0px;left:0px;">
											<table border="0" cellspacing="0" cellpadding="0" class="nonSelected"   onMouseOver="javascript: clearTimeout(sizeTimeout);" onMouseOut="javascript: sizeTimeout = setTimeout('closeMenu(\'sizeselector\');',750);">
												<tr>
													<td height="15" width="61" onClick="javascript: DoClickSize('10 Pt');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this);">&nbsp;10 Pt</td>
												</tr>
												<tr>
													<td height="15" width="61" onClick="javascript: DoClickSize('12 Pt');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this);">&nbsp;12 Pt</td>
												</tr>
												<tr>
													<td height="15" width="61" onClick="javascript: DoClickSize('14 Pt');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this)">&nbsp;14 Pt</td>
												</tr>
												<tr>
													<td height="15" width="61" onClick="javascript: fontsize = prompt('<?PHP echo $txt[58]; ?>','');DoClickSize(fontsize);closeMenu('sizeselector');" onMouseOver="javascript: doSelect(this)" onMouseOut="javascript: doDeSelect(this)">&nbsp;<?PHP echo $txt[56]; ?></td>
												</tr>
											</table>
										</div>
									<!-- End Select Area for Size -->
								</td>

								<td width="92">
									<!-- Begin Select Area for Color -->
										<table border="0" cellspacing="0" cellpadding="0" class="nonSelected">
											<tr valign="middle">
												<td height="17" width="55" class="selectbar" onClick="javascript: window.open('./index.php?act=sm_window&page=colors&extra=1','Colors','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" onMouseOver="javascript: document.color_selector.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: document.color_selector.src='<?PHP echo $print->image_path; ?>selectarrow.gif'">&nbsp;<input type="hidden" name="curcolor" value="<?PHP echo $x7c->settings['default_color']; ?>" class="curcolor"><div id="curcolord" name="curcolord" style="display: inline;color: <?PHP echo $x7c->settings['default_color']; ?>"><?PHP echo $x7c->settings['default_color']; ?></div></td>
												<td height="17" class="arrow_box" onClick="javascript: window.open('./index.php?act=sm_window&page=colors&extra=1','Colors','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" width="17"><img name="color_selector" src="<?PHP echo $print->image_path; ?>selectarrow.gif" onMouseOver="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow_over.gif'" onMouseOut="javascript: this.src='<?PHP echo $print->image_path; ?>selectarrow.gif'"></td>
											</tr>
										</table>

									<!-- End Select Area for Color -->
								</td>

								<td width="20">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20" class="boldtxt" height="19" onClick="javascript: styleClicked(this,'bold')" onMouseOver="javascript: styleOver(this,'bold');" onMouseOut="javascript: styleOut(this,'bold');">
												<input type="hidden" name="bold" value="0"><b>B</b>
											</td>
										</tr>
									</table>
								</td>

								<td width="8">&nbsp;</td>

								<td width="20">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20" class="boldtxt" height="19" onClick="javascript: styleClicked(this,'italic')" onMouseOver="javascript: styleOver(this,'italic');" onMouseOut="javascript: styleOut(this,'italic');">
												<input type="hidden" name="italic" value="0"><i>I</i>
											</td>
										</tr>
									</table>
								</td>

								<td width="8">&nbsp;</td>

								<td width="20">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20" class="boldtxt" height="19" onClick="javascript: styleClicked(this,'under')" onMouseOver="javascript: styleOver(this,'under');" onMouseOut="javascript: styleOut(this,'under');">
												<input type="hidden" name="under" value="0"><u>U</u>
											</td>
										</tr>
									</table>
								</td>

								<td width="10">&nbsp;</td>

								<td width="21" height="17"><img src="<?PHP echo $print->image_path; ?>blanksmile.gif" class="smileybutton" onClick="javascript: window.open('./index.php?act=sm_window&page=smile','Smile','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');" onMouseOver="javascript: this.className='smileybuttonOver'" onMouseOut="javascript: this.className='smileybutton'"></td>

							</tr>
							<tr>
								<td width="10">&nbsp;</td>
								<td colspan="10">
									<div style="position: relative; top: -50px;z-index: 2;">
										<table border="0" cellspacing="0" cellpadding="0">
											<tr valign="middle">
												<td width="315" height="25" class="msginput_bg">
													<div align="center">
														<input type="text" name="msgi" class="msginput" autocomplete="off">
														<input type="hidden" name="msg" value="">
													</div>
												</td>
												<td width="5">&nbsp;</td>
												<td><input type="submit" class="send_button" style="cursor: pointer;background: url(<?PHP echo $print->image_path; ?>send.gif);border: none;height: 25px;width: 55px;text-align: center;font-weight: bold;" onMouseOut="this.style.background='url(<?PHP echo $print->image_path; ?>send.gif)'" onMouseOver="this.style.background='url(<?PHP echo $print->image_path; ?>send_over.gif)'" value="<?PHP echo $txt[181]; ?>"></td>
											</tr>
										</table><Br>
									</div>
								</td>
							</tr>
						</table>
						</form>
<?PHP
			if($x7c->settings['disable_sounds'] != 1){

			  echo "<embed src='./sounds/msg.mid' autostart='false' enablejavascript='true' width='0' height='0' controls='false' volume='100' name='snd_msg'></embed>";
			  echo "<embed src='./sounds/enter.mid' autostart='false' enablejavascript='true' width='0' height='0' controls='false' volume='100' name='snd_enter'></embed>";
			}
?>
					</div>
					<div style='float: left;height: 25%;width: 18%;text-align: center;margin-right: 5px;margin-left: 5px;'>
			<script language="javascript" type="text/javascript">
			// Handle the Profile and Action boxes
			var userInfo = new Array();
			userInfo['username'] = "";
			userInfo['usergroup'] = "";
			userInfo['status'] = "";

			userInfo['action1'] = "";
			userInfo['action2'] = "";
			userInfo['action3'] = "";
			userInfo['action4'] = "";
			userInfo['action5'] = "";

			userInfo['label1'] = "";
			userInfo['label2'] = "";
			userInfo['label3'] = "";
			userInfo['label4'] = "";
			userInfo['label5'] = "";

			var activeTab = 1;
			var filledBlocks = 0;

			function clearTheWay(){
			  document.getElementById('ap1').innerHTML = '';
			  document.getElementById('ap2').innerHTML = '<?PHP echo $txt[90]; ?>';
			  document.getElementById('ap3').innerHTML = '';
			  document.getElementById('ap4').innerHTML = '';
			  document.getElementById('ap5').innerHTML = '';
			  document.getElementById('ap6').innerHTML = '';
			  userInfo['username'] = "";
			  openActionBox();
			}

			// Actually opens the profile tab
			function openActionBox(){
			  document.getElementById('pro').className='uc_header_selected';
			  document.getElementById('act').className='uc_header_text';
			  activeTab = 1;
			  filledBlocks = 6;
			  if(userInfo['username'] != ""){
			    document.getElementById('ap1').innerHTML = userInfo['username'];
			    document.getElementById('ap2').innerHTML = userInfo['usergroup'];
			    document.getElementById('ap3').innerHTML = userInfo['status'];
			    document.getElementById('ap4').innerHTML = '<?PHP echo $txt[87]; ?>';
			    document.getElementById('ap5').innerHTML = '<?PHP echo $txt[88]; ?>';
			    document.getElementById('ap6').innerHTML = '<?PHP echo $txt[89]; ?>';

			    document.getElementById('ap1').style.fontWeight = 'bold';
			    document.getElementById('ap3').style.fontStyle = 'italic';
			  }
			}

			// Actually opens the Action tab
			function openProfileBox(){
			  document.getElementById('pro').className='uc_header_text';
			  document.getElementById('act').className='uc_header_selected';
			  activeTab = 2;
			  filledBlocks = 1;
			  while(filledBlocks <= 5){
			    if(userInfo['label'+filledBlocks] == "")
			      break;
			    filledBlocks++;
			  }
			  filledBlocks--;

			  if(userInfo['username'] != ""){
			    document.getElementById('ap1').innerHTML = userInfo['label1'];
			    document.getElementById('ap2').innerHTML = userInfo['label2'];
			    document.getElementById('ap3').innerHTML = userInfo['label3'];
			    document.getElementById('ap4').innerHTML = userInfo['label4'];
			    document.getElementById('ap5').innerHTML = userInfo['label5'];
			    document.getElementById('ap6').innerHTML = '';

			    document.getElementById('ap1').style.fontWeight = 'normal';
			    document.getElementById('ap3').style.fontStyle = 'normal';
			  }
			}

			function rollOver(obj,over){
			  if(userInfo['username'] == "")
			    return;

			  if((obj.id == "ap1" || obj.id == "ap2" || obj.id == "ap3") && activeTab == 1)
			    return;

			  if(parseInt(obj.id.replace("ap","")) > filledBlocks)
			    return;

			  if(over)
			    obj.className = "uc_item_over";
			  else
			    obj.className = "uc_item";
			}

			function apa1(){
			  if(activeTab != 1 && userInfo['action1'] != "")
			    window.open('./index.php?act=usr_action&action='+userInfo['action1']+'&user='+userInfo['username']+'&room=<?PHP echo $_GET['room']; ?>','UsrAction','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');
			}

			function apa2(){
			  if(activeTab != 1 && userInfo['action2'] != "")
			    window.open('./index.php?act=usr_action&action='+userInfo['action2']+'&user='+userInfo['username']+'&room=<?PHP echo $_GET['room']; ?>','UsrAction','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');
			}

			function apa3(){
			  if(activeTab != 1 && userInfo['action3'] != "")
			    window.open('./index.php?act=usr_action&action='+userInfo['action3']+'&user='+userInfo['username']+'&room=<?PHP echo $_GET['room']; ?>','UsrAction','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');
			}

			function apa4(){
			  if(activeTab == 1 && userInfo['username'] != "")
			    window.open('./index.php?act=view_profile&user='+userInfo['username'],'Profile','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');
			  else if(activeTab == 2 && userInfo['action4'] != "")
			    window.open('./index.php?act=usr_action&action='+userInfo['action4']+'&user='+userInfo['username']+'&room=<?PHP echo $_GET['room']; ?>','UsrAction','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');
			}

			function apa5(){
			  if(activeTab == 1 && userInfo['username'] != "")
			    window.open('./index.php?act=pm&send_to='+userInfo['username'],'Pm'+userInfo['username'],'location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');
			  else if(activeTab == 2 && userInfo['action5'] != "")
			    window.open('./index.php?act=usr_action&action='+userInfo['action5']+'&user='+userInfo['username']+'&room=<?PHP echo $_GET['room']; ?>','UsrAction','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_small_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_small_height']; ?>');
			}

			function apa6(){
			  if(activeTab != 2 && userInfo['username'] != "")
			    window.open('./index.php?act=userpanel&cp_page=msgcenter&to='+userInfo['username'],'Mail','location=no,menubar=no,resizable=no,status=no,toolbar=no,scrollbars=yes,width=<?PHP echo $x7c->settings['tweak_window_large_width']; ?>,height=<?PHP echo $x7c->settings['tweak_window_large_height']; ?>');
			}
			</script>
						<table align="center" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="100" height="25" class="uc_header">
									<table align="center" border="0" width="100" height="25" cellspacing="0" cellpadding="0" name="mytable">
										<tr>
											<td width="50" height="25" id="pro" onClick="openActionBox()" class="uc_header_selected"><?PHP echo $txt[85]; ?></td>
											<td width="50" height="25" id="act" onClick="openProfileBox()" class="uc_header_text"><?PHP echo $txt[86]; ?></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table border="0" cellspacing="0" cellspading="0" width="100" align="center" class="uc_item_box">
							<tr>
								</tr>
									<td class="uc_item" onMouseOver="javascript: rollOver(this,1)" id="ap1" onMouseOut="rollOver(this,0)"  onClick="javascript: apa1();">&nbsp;</td>
								</tr>
								</tr>
									<td class="uc_item" onMouseOver="javascript: rollOver(this,1)" id="ap2" onMouseOut="rollOver(this,0)"  onClick="javascript: apa2();">&nbsp;</td>
								</tr>
								</tr>
									<td class="uc_item" onMouseOver="javascript: rollOver(this,1)" id="ap3" onMouseOut="rollOver(this,0)"  onClick="javascript: apa3();">&nbsp;</td>
								</tr>
								</tr>
									<td class="uc_item" onMouseOver="javascript: rollOver(this,1)" id="ap4" onMouseOut="rollOver(this,0)"  onClick="javascript: apa4();">&nbsp;</td>
								</tr>
								</tr>
									<td class="uc_item" onMouseOver="javascript: rollOver(this,1)" id="ap5" onMouseOut="rollOver(this,0)"  onClick="javascript: apa5();">&nbsp;</td>
								</tr>
								</tr>
									<td class="uc_item" onMouseOver="javascript: rollOver(this,1)" id="ap6" onMouseOut="rollOver(this,0)"  onClick="javascript: apa6();">&nbsp;</td>
								</tr>
							</tr>
						</table>
					</div>
<?PHP
			break;

}
?>
