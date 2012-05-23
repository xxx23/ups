<?PHP
/////////////////////////////////////////////////////////////// 
//
//		X7 Chat Version 2.0.0
//		Released July 27, 2005
//		Copyright (c) 2004-2005 By the X7 Group
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

$language_iso = "iso-8859-1";	// If you need help with this one e-mail webmaster@x7chat.com and i'll give you the correct value for your language

// Notes:
//	If you need help translating something please E-Mail me and I will do my best.  I would
//	rather have you E-Mail me then guess what it is.
//
//	"<br>" will insert a enter/return/start on the next line.  You may add <br>'s but please leave the ones already there in place.
//	"<b>" will make text turn bold until it reaches a "</b>" which stops text from being bold.
//	"<i>" will make text turn italic until it reaches a "</i>" which stops text from being italic.

$txt[0] = "Logga in";
$txt[1] = "Ange ditt lösen och nick för att logga in";
$txt[2] = "Nick";
$txt[3] = "Lösen";
$txt[4] = "&nbsp;&nbsp; Login &nbsp;&nbsp;";	// "&nbsp;" is the same as a blank space
$txt[5] = "Glömt lösen";
$txt[6] = "Rigestrera";
$txt[7] = "Stats";
$txt[8] = "Användare online";
$txt[9] = "Alla rum";
$txt[10] = "Användare rigestrerade";
$txt[11] = "Användare online";
$txt[12] = "Upcoming Events";
$txt[13] = "Lösenordet eller ditt nick du angav var inte rätt";
$txt[14] = "Fel";

$txt[15] = "Sorry, the administrator of this server has disabled registration";
$txt[16] = "Logga ut";
$txt[17] = "Du har loggat ut.";
$txt[18] = "Rigestrera";
$txt[19] = "Fyll i alla fällt för att kunna rigestrera dig.";
$txt[20] = "E-Mail";
$txt[21] = "Lösen igen";
$txt[22] = "Mer detaljer kan ändras efter rigestreringen";
$txt[23] = "Fel nick endast bokstäver och nummer men inga mellanrum, komma, bindesträck, punkter eller andra tecken.  Ditt nick måste vara kortare än _n rader långt.";		// _n is the number of charcters your username must be under
$txt[24] = "Fyll i en giltlig email adress.";
$txt[25] = "Fyll i ett lösen.";
$txt[26] = "Lösenorden du angav var inte lika.";
$txt[27] = "Tyvärr det namnet var redan taget gå tillbaks och ta ett annat.";
$txt[28] = "Ditt konta har blivit skapat , <a href=\"./index.php\">Klicka här</a> för att logga in.";

$txt[29] = "Rum listan";
$txt[30] = "Användare";
$txt[31] = "Namn";
$txt[32] = "Topic";

$txt[34] = "Hjälp";
$txt[35] = "User CP";
$txt[36] = "Installerade teman";
$txt[37] = "Admin CP";

$txt[38] = "Sorry, unknown frame!";
$txt[39] = "Tyvärr adminen har blockerat detta chat rum !";

$txt[40] = "Status";
$txt[41] = "Rum CP";

$txt[42] = "You may not send messages to this room unless the Operator gives you a voice.";
$txt[43] = "Har kommit till rummet";
$txt[44] = "Har gått från rummet";

$txt[45] = "Kan inte ladda sidan, sidan existerar inte.";
$txt[55] = "Normal";
$txt[56] = "Mer";
$txt[57] = "Välj ett teckensnitt:";

$txt[58] = "Vilken storlek på texten vill du ha?";
$txt[59] = "Skapa rum";
$txt[60] = "Du har inte tillåtelse att skapa ett nytt rum.";
$txt[61] = "Rummets namn";
$txt[62] = "Gör klart den här formen för att skapa ett chat rum";
$txt[63] = "Skapa";
$txt[64] = "Rum Typ";
$txt[65] = "Topic";
$txt[66] = "Kommentar";
$txt[67] = "Max med användare";
$txt[68] = "Publik";
$txt[69] = "Privat";
$txt[70] = "Moderated";
$txt[71] = "Never Expire";
$txt[72] = "Fel rum namn , ditt rum namn kan innehålla bokstver och nummer men inte komma, bindesträck, punkter, tecken.";
$txt[73] = "okänd rum typ";
$txt[74] = "Du bör inte skapa privata rum";
$txt[75] = "Ditt rum har blivit skapat";
$txt[76] = "Det rummet är redan skapat ta ett annat namn till ditt rum";
$txt[77] = "Tillbaka";
$txt[78] = "Lösenord";
$txt[79] = "Det här rummet är skyddat av ett lösenord skriv in det nu.";
$txt[80] = "Det här rummet är fullt ta ett annat rum";
$txt[81] = "Fulla rum visas inte";
$txt[82] = "Visa fulla rum";
$txt[83] = "Full rooms are being shown";
$txt[84] = "Göm fulla rum";
$txt[85] = "Profil";
$txt[86] = "Aktiviteter";
$txt[87] = "Full profil";
$txt[88] = "Privat Chat";
$txt[89] = "Sänd Mail";
$txt[90] = "Uppdaterar....";

$txt[91] = "Blockera";
$txt[92] = "Tillåt";
$txt[93] = "Tyst";
$txt[94] = "Give Ops";
$txt[95] = "Take Ops";
$txt[96] = "PÅ";
$txt[97] = "Kicka";
$txt[98] = "Se IP";
$txt[99] = "   ";
$txt[100] = "   ";

$txt[101] = "Användaren är nu ignorerad.";
$txt[102] = "Användaren är INTE ignorerad längre.";
$txt[103] = "Välj ett nick";
$txt[104] = "Du har inte tillåtelse att göra denna aktivitet";
$txt[105] = "User has been granted Operator Status";
$txt[106] = "Users Operator Status has been revoked";
$txt[107] = "Den här användarens ip är: ";
$txt[108] = "Ange varför du vill kicka den här användaren:";
$txt[109] = "Användaren har blivit kickad, han kan inte komma in igen dom närmsta 60 sekunderna.";
$txt[110] = "_u har blivit kickat för att _r";	// _u will be replaced with username and _r will be replaced with reason

$txt[111] = "This user has been muted.";
$txt[112] = "This user is no longer muted.";
$txt[113] = "This user has been given a voice.";
$txt[114] = "This users voice has been taken away.";

$txt[115] = "Du har blivit kickas från rummet för att _r";	// _r will be replaced with the reason for the kick
$txt[116] = "Du har blivit avsrängd från rummet för att _r";	// _r will be replaced with the reason for the ban
$txt[117] = "DU har blivit avstängd från chatten för att _r";	// _r will be replaced with the reason for the ban
$txt[118] = "Du har blivit bortförd från deet här rummet,  <a href='./index.php'>Klicka här</a> för att gå tillbaks till rum listen och välja ett annat.";

$txt[119] = "Se Profil";
$txt[120] = "(Dåld)";
$txt[121] = "Stad";
$txt[122] = "Hobby";
$txt[123] = "Grupp";
$txt[124] = "Bio";
$txt[125] = "Avatar";

$txt[126] = "_u is now a Chat Room Operator";		// _u will print the username of the person who the action is preformed one.
$txt[127] = "_u is no longer a Chat Room Operator";		// _u will print the username of the person who the action is preformed one.
$txt[128] = "Choose a Color";		
$txt[129] = "_u has been given a voice";		// _u will print the username of the person who the action is preformed one.
$txt[130] = "_us voice has been taken";		// _u will print the username of the person who the action is preformed one.
$txt[131] = "_u has been muted";		// _u will print the username of the person who the action is preformed one.
$txt[132] = "_u is no longer muted";		// _u will print the username of the person who the action is preformed one.
$txt[133] = "Stäng";		
$txt[134] = "Din meddelande färg har blivit uppdaterad.";		
$txt[135] = "Kontroll Panel";
$txt[136] = "Välkommen till din kontroll panel.  Här kan du ändra dina inställningar, sända medelanden och ändra många andra saker.";

$txt[137] = "Hem";
$txt[138] = "Profil";
$txt[139] = "Inställningar";
$txt[140] = "Status";
$txt[141] = "Blockarade";
$txt[142] = "Offline Msgs";
$txt[143] = "Ord filter";
$txt[144] = "Snabblänkar";
$txt[145] = "Följande ord är filtrerande, klicka på dom för att ta bort dom.";

$txt[146] = "Your current Status";
$txt[147] = "Ändra Status";
$txt[148] = "Din status är ändrad till";
$txt[149] = "Borta";
$txt[150] = "Online";
$txt[151] = "Strax tillbacka";
$txt[152] = "Kommer senare";
$txt[153] = "Egen";
$txt[154] = "Ändra";
$txt[155] = "Max bokstäver";
$txt[156] = "Följande användare är blockerande klick på namnen för att ta bort dom.";
$txt[158] = "_u har tagits bort från din blockerings lista.";	// _u is replaced with the person usersname
$txt[159] = "Ignorera en användare";
$txt[160] = "Lägg till";
$txt[161] = "_u har lagts till i din blockerings lista.";	// _u is replaced with the person usersname
$txt[162] = "_w har blivit filtrerat.";		// _w is replaced with the word that was filtered
$txt[163] = "_w är INTE längre filtrerat.";		// _w is replaced with the word that was unfiltered
$txt[164] = "Fult ord";
$txt[165] = "Text";
$txt[166] = "Istället";
$txt[167] = "Dina snabblänkar har blivit uppdaterade";
$txt[168] = "Snabblänkar är följande vanliga ord som blir till länkar när man skriver in det i chatten.<Br><Br>Följande orden är snabblänkar klicka på dom för att ta bort dom.";		// <br> means it goes onto a new line, same as an enter or return key does
$txt[169] = "Lägg till snabblänk";
$txt[170] = "URL";
$txt[171] = "Ditt meddelande har blivit sänt.";
$txt[172] = "Här under är alla meddelanden då fått.";
$txt[173] = "[Inga]";
$txt[174] = "------- Ursprungligt meddelande -------";	
$txt[175] = "Ta bort";
$txt[176] = "RE: ";
$txt[177] = "Meddelandet har tagits bort";
$txt[178] = "Ämne";
$txt[179] = "Från";
$txt[180] = "Datum";
$txt[181] = "Sänd";
$txt[182] = "Sänd till";
$txt[183] = "Ämne";
$txt[184] = "Ditt meddelande kunde inte sändas för den andra användarens inbox är full.";
$txt[185] = "Du använder _p av ditt utrymme.  Du har plats för _n mer meddelanden.";	// _p is the precentage of used space and _n is the number of messages you have room for
$txt[186] = "Ålder";
$txt[187] = "Uppdatera";
$txt[188] = "Din profil har blivit uppdaterad.";

$txt[189] = "Man";
$txt[190] = "Kvinna";
$txt[191] = "------";

$txt[192] = "Ladda upp";
$txt[193] = "Du kan använda den här formen för att ladda upp en avatar.  You may only have one avatar stored on the server at a time.
Your avatar must be a .gif, .png or .jpeg image file and must be under _b bytes large.  Your avatar must be _d px.";		// _b is replaced with the byte limit and _d is replaced with the size limit that the admin has specified

$txt[194] = "Din avatar uppladdades och din profil är nu uppdaterad.";
$txt[195] = "Avatar uploads have been disabled.";
$txt[196] = "Your avatar file is to large.";
$txt[197] = "Din avatars filformat kändes inte igen.  Använd PNG, GIF eller JPEG.";
$txt[198] = "Avatar uploading is enabled but the administrator has not made the uploads directory writeable.  Please contact them and report this problem.  Your avatar was not uploaded.";

$txt[199] = "Login Time (hours)";
$txt[200] = "Refresh Rate (seconds)";
$txt[201] = "Time offset (hours)";
$txt[202] = "Time offset (minutes)";
$txt[203] = "Skin";
$txt[204] = "Språk";
$txt[205] = "Disable Styles";
$txt[206] = "Disable Smilies";
$txt[207] = "Disable Sounds";
$txt[208] = "Disable Timestamps";
$txt[209] = "Hide E-Mail";
$txt[210] = "Dina inställningar har blivit uppdaterade";

$txt[211] = "Unknown Command";
$txt[212] = "_u rolls _d _s-sided dice.";		// _u become username, _d is the number of dice and _s is the number of sides
$txt[213] = "The results are:";
$txt[214] = "The results are modified by _a.";	// _a is a number they are modified by

$txt[215] = "Access Denied";
$txt[216] = "You do not have permission to access this section.";
$txt[217] = "This panel allows you to adjust many settings of your chat room.";
$txt[218] = "Enkla inställningar";
$txt[219] = "Op List";
$txt[220] = "Voice List";
$txt[221] = "Mute List";
$txt[222] = "New Ban";
$txt[223] = "Reason";
$txt[224] = "User / IP / E-Mail";
$txt[225] = "Length";
$txt[226] = "För alltid";
$txt[227] = "OR";
$txt[228] = "Minuter";
$txt[229] = "Timmar";
$txt[230] = "Dagar";
$txt[231] = "Veckor";
$txt[232] = "Månader";
$txt[233] = "Click on a User, IP or E-Mail address to unban it";
$txt[234] = "The new ban has been applied.";
$txt[235] = "The ban has been removed.";
$txt[236] = "The following users have operator status in this room.  Click on one to revoke its operator status.";
$txt[237] = "The following users have a voice in this room.  Click on one to revoke their voice.";
$txt[238] = "The following users are muted.  Click on one to unmute them.";
$txt[239] = "Unable to find user by that username.";
$txt[240] = "Logs";
$txt[241] = "Log Private Messages";
$txt[242] = "Logging is enabled";
$txt[243] = "Logging is disabled";
$txt[244] = "Enable Logging";
$txt[245] = "Disable Logging";
$txt[246] = "Log file size: _s kb (_p)";		// _s is the size,_p is the percentage
$txt[247] = "Free space remaining: _s kb (_p)";		// _s is the remain free space, _p is the percentage
$txt[248] = "unlimited";
$txt[249] = "Below is the contents of the log.";
$txt[250] = "Delete Log";
$txt[251] = "Select a log from below to view it.";
$txt[252] = "Your message was not sent, it was to long.";
$txt[253] = "Background Image";
$txt[254] = "Logo Image";
$txt[255] = "Password Reminder";
$txt[256] = "Hello _u,\n\nA visitor with ip address _i has requested that your password be changed at _s Chat.\n\nYour new password is _p.\n\nThanks,\n_s Support Team";			// Us "\n" for return/enter/new lines, _u for the username, _i for IP, _s for sitename, _p for new password
$txt[257] = "Enter your Username or E-Mail address to recieve a new password.  The new password will be emailed to the E-Mail address we have on file.";
$txt[258] = "Ditt nya lösenord har sänts.";
$txt[259] = "Ditt lösenord sändes inte.  Vi kunde hitta ett konta med den email addressen.";
$txt[260] = "Your new password has not been sent.  We located the correct account however no E-Mail address was in the database.";
$txt[261] = "The administrator has disabled password reminders.";
$txt[262] = "Nyheter";
$txt[263] = "Sorry, there is no help topic for that subject.";
$txt[264] = "Rummen försvinner automatiskt om: _t";		// _t is the time after which they expire
$txt[265] = "Alldrig";
$txt[266] = "";
$txt[267] = "Du har inte tillåtelse att använda detta kommando.";
$txt[268] = "Unable to complete action on specified user.";
$txt[269] = "<b>Syntax:</b> /kick <i>username</i> <i>reason</i><Br>This command will remove a user from the chat room.";
$txt[270] = "<b>Syntax:</b> /ban <i>username</i> <i>reason</i><Br>This command will remove a user from the chat room and prevent them from entering again.";
$txt[271] = "<b>Syntax:</b> /unban <i>username</i> <Br>This command will allow a banned user to enter the chat room again.";
$txt[272] = "<b>Syntax:</b> /op <i>username</i> <Br>This command will give operator access to a user.";
$txt[273] = "<b>Syntax:</b> /deop <i>username</i> <Br>This command will take away operator power from someone.";
$txt[274] = "<b>Syntax:</b> /ignore <i>username</i> <Br>This command will block all messages from someone.";
$txt[275] = "<b>Syntax:</b> /unignore <i>username</i> <Br>This command will unblock all messages from someone.";
$txt[276] = "The following people are in chat with you: ";
$txt[277] = "<b>Syntax:</b> /me <i>action</i> <Br>This command will tell other users that you do the <i>action</i>.";
$txt[278] = "<b>Syntax:</b> /admin <i>username</i> <Br>This command will give the user administrator access.";
$txt[279] = "_u is now a chat room administrator";	// _u is the username
$txt[280] = "_u is no longer a chat room administrator";	// _u is the username
$txt[281] = "<b>HEY!!</b>, You just tried to take admin status from yourself!  If you want to continue with this action, type /deadmin <i>your_username</i> 1";
$txt[282] = "<b>Syntax:</b> /voice <i>username</i> <Br>This command will give the user a voice and allow them to speak in moderated rooms.";
$txt[283] = "<b>Syntax:</b> /devoice <i>username</i> <Br>This command will take the users voice so they can no longer speak in moderated rooms.";
$txt[284] = "<b>Syntax:</b> /mute <i>username</i> <Br>This command will disallow the user from sending messages to the room.";
$txt[285] = "<b>Syntax:</b> /unmute <i>username</i> <Br>This command will allow a muted user to send messages to the room.";
$txt[286] = "<b>Syntax:</b> /wallchan <i>message</i> <Br>This command will send a message to all rooms.";
$txt[287] = "<a>[Click here]</a> to open the room control panel in a new window.";		// Leave the <a> and </a> tags alone
$txt[288] = "<b>Syntax:</b> /log <i>action</i> <Br>This command allows you to stop, view size, start and clear the log.  <i>Action</i> can be:<Br><b>Stop</b>: Stops logging<Br><b>Start</b>: Starts logging<br><b>Clear</b>: Clears the existing log<Br><b>Size</b>: Tells you how much of the log is used";
$txt[289] = "You have used _s KB out of _m KB of log space.";	// _s is what you have used and _m is how much you can use
$txt[290] = "You used the mode command incorrect.  Please <a>Click Here</a> to learn how to use it.";
$txt[291] = "";
$txt[292] = "disrupting chat.";
$txt[293] = "_u has taken operator status from all operators.";		// _u is the username
$txt[294] = "The MOTD is blank.";	// (MOTD stands for Message Of The Day)
$txt[295] = "<b>Syntax:</b> /userip <i>username</i> <Br>This command will show you the Ip Address of <i>username</i>.";
$txt[296] = "_u has invited you to join the room _r";	// _u is the inviting username and _r is the room
$txt[297] = "<b>Syntax:</b> /invite <i>username</i> <Br>This command will invite the user to join the room you are in.";
$txt[298] = "<b>Syntax:</b> /join <i>room</i> <Br>This command will let you to join a new room.";
$txt[299] = "<a>[Click Here]</a> to join _r";	// leave <a> and </a> alone, _r is the room
$txt[300] = "That room does not exist.";
$txt[301] = "<a>[Click Here]</a> to create it.";	// leave <a> and </a> alone
$txt[302] = "<b>Syntax:</b> /msg <i>username</i> <Br>This command will let you send a private message to a user.";
$txt[303] = "<a>[Click Here]</a> to send a message to _u";	// _u is the reciever's username, leave <a> and </a> alone
$txt[304] = "<b>Syntax:</b> /wallchop <i>message</i> <Br>This command will send your message to all the chat room operators.";
$txt[305] = "(Message to _r Operators From _u)";	// _r is the room, _u is the person sending it

$txt[306] = "This is your Administrator Control Panel.  From here you can configure settings, install mods, update themes, and manage the many other aspects of your chat room.";
$txt[307] = "News From Us";
$txt[308] = "Themes";
$txt[309] = "User Groups";
$txt[310] = "Manage Users";
$txt[311] = "Manage Rooms";
$txt[312] = "Blockerade";
$txt[313] = "Bandbredd";
$txt[314] = "Log";
$txt[315] = "Kalender";
$txt[316] = "Mass Mail";
$txt[317] = "Smilies";
$txt[318] = "Mods";
$txt[319] = "The XUpdater is disabled.  This module is required if you want to use this feature.  You can enable it by editing config.php.";
$txt[320] = "There is no news available at this time.";
$txt[321] = "Please pick a section of settings to update.";
$txt[322] = "Time and Date";
$txt[323] = "Expiration Times";
$txt[324] = "Banner URL";
$txt[325] = "Styles and Messages";
$txt[326] = "Avatars";
$txt[327] = "Login Page";
$txt[328] = "Advanced";
$txt[329] = "Disable Chat";
$txt[330] = "Allow Registration";
$txt[331] = "Allow Guests";
$txt[332] = "Site Name";
$txt[333] = "Admin E-Mail";
$txt[334] = "Logout Page";
$txt[335] = "Max Characters in Status";
$txt[336] = "Max Characters in Message";
$txt[337] = "Max offline Messages";
$txt[338] = "Minimum Refresh Time";
$txt[339] = "Maximum Refresh Time";
$txt[340] = "May be set to 0 for no limit.";
$txt[341] = "Default Langauge";
$txt[342] = "Default Theme";
$txt[343] = "Your settings have been updated.  <a>Click Here</a> to return to the Setting panel.";		// Leave <a> and </a>
$txt[344] = "The minimum refresh rate cannot be greater then the maximum one, duh.";
$txt[345] = "Log Path";
$txt[346] = "Max Room Log Size (KB)";
$txt[347] = "Max User Log Size (KB)";
$txt[348] = "Time Format";
$txt[349] = "Date Format";
$txt[350] = "Full Date/Time Format";
$txt[351] = "in seconds";
$txt[352] = "Max Idle Time";
$txt[353] = "Messages Expire After";
$txt[354] = "Rooms Expire After";
$txt[355] = "Guest Accounts Expire After";
$txt[356] = "in minutes";
$txt[357] = "Cookie Time";
$txt[358] = "Background Image";
$txt[359] = "Allow Custom Room Background";
$txt[360] = "Allow Custom Room Logos";
$txt[361] = "Default Font";
$txt[362] = "Default Size";
$txt[363] = "Default Color";
$txt[364] = "Minimum Font Size";
$txt[365] = "Maximum Font Size";
$txt[366] = "Disable Smilies";
$txt[367] = "Disable Message Styles";
$txt[368] = "Disable Auto-Linking";
$txt[369] = "System Message Color";
$txt[370] = "Allowed Fonts*";
$txt[371] = "Seperated by commas";
$txt[372] = "Enable Avatar Uploads";
$txt[373] = "Auto-Resize Smaller Avatars";
$txt[374] = "Max Uploaded Avatar Size (in bytes)";
$txt[375] = "Max Avatar Size (width by height)";
$txt[376] = "Upload Path";
$txt[377] = "Upload URL";
$txt[378] = "Show Event Calendar";
$txt[379] = "Show Stats";
$txt[380] = "Enable Password Reminder";
$txt[381] = "Days to show in Daily Calendar (1-3)";
$txt[382] = "Show Monthly Calendar";
$txt[383] = "Show Daily Calendar";
$txt[384] = "Disable use of the GD Library";	// GD Info: http://www.boutell.com/gd/
$txt[385] = "If you don't know what it is, don't disable it.  If your system doesn't support it, it will be disabled automatically.";
$txt[386] = "A room with that name does not exist.";
$txt[387] = "You may <a>click here</a> to join the requested room.";		// Leave <a> and </a> alone
$txt[388] = "Join a private room";
$txt[389] = "Join";
$txt[390] = "Theme Name";
$txt[391] = "Are you sure that you want to delete this theme?";
$txt[392] = "Yes";
$txt[393] = "No";
$txt[394] = "The selected theme has been deleted.";
$txt[395] = "We were unable to remove the selected theme.  Please delete the folder _d (it is inside the themes folder) in your FTP program.";		//_d will be replaced with the directory name
$txt[396] = "If you did a CHMOD 777 on the themes directory, it highly recommend that you CHMOD your themes directory to whatever it was at before.  (Usually 755)";
$txt[397] = "Please CHMOD 777 the themes directory.";
$txt[398] = "CHMOD Complete";
$txt[399] = "The following new themes have been detected.";
$txt[400] = "Install";
$txt[401] = "Error: Please CHMOD 777 the mods directory.";
$txt[402] = "The selected theme has been installed.";
$txt[403] = "Released";
$txt[404] = "Skapare";
$txt[405] = "Description";
$txt[406] = "Download New Themes";
$txt[407] = "You are now a room operator, to access the room control panel type /roomcp";
$txt[408] = "Default Groups";
$txt[409] = "Ny medlem";
$txt[410] = "Gäst";
$txt[411] = "Administratör";
$txt[412] = "Your group settings have been updated.";
$txt[413] = "Members";
$txt[414] = "New Group";
$txt[415] = "The group change was successful.";
$txt[416] = "Change Group";
$txt[417] = "With Selected, Change group to";
$txt[418] = "The following users are in this group";
$txt[419] = "Check/Uncheck all";
$txt[420] = "Please remove all users from the usergroup before you delete it.";
$txt[421] = "The usergroup has been deleted.";
$txt[422] = "Kan skapa rum";
$txt[423] = "Can Create Private Room";
$txt[424] = "Here you can change the things that this user group can do.";
$txt[425] = "Can Set Room to Never Expire";
$txt[426] = "Can Set Room to Moderated";
$txt[427] = "Can View IP";
$txt[428] = "Can Kick Users";
$txt[429] = "Cannot be banned or kicked";
$txt[430] = "Has operator status in all rooms";
$txt[431] = "Has a voice in all rooms";
$txt[432] = "Can see hidden E-Mail addresses";
$txt[433] = "Can set/delete Keywords";
$txt[434] = "Can control room logging";
$txt[435] = "Can log private messages";
$txt[436] = "Can set room backgrounds";
$txt[437] = "Can set room logos";
$txt[438] = "Can grant Administrator access";
$txt[439] = "Can send server messages";
$txt[440] = "Can use the /mdeop command";
$txt[441] = "Can use the /mkick command";
$txt[442] = "Can access Admin Panel : Settings";
$txt[443] = "Can access Admin Panel : Themes";
$txt[444] = "Can access Admin Panel : Word Filter";
$txt[445] = "Can access Admin Panel : User Groups";
$txt[446] = "Can access Admin Panel : Manage Users";
$txt[447] = "Can access Admin Panel : Ban List";
$txt[448] = "Can access Admin Panel : Bandwidth";
$txt[449] = "Can access Admin Panel : Log Manager";
$txt[450] = "Can access Admin Panel : Mass Mail";
$txt[451] = "Can access Admin Panel : Mods";
$txt[452] = "Can access Admin Panel : Smilies";
$txt[453] = "Can access Admin Panel : Rooms";
$txt[454] = "Can access chat room when disabled";
$txt[455] = "User must have operator status to use this feature";
$txt[456] = "User must have operator status and this feature must be enabled in the setting section of the admin panel.";
$txt[457] = "Can access Admin Panel : Calendar";
$txt[458] = "The permissions for this usergroup have been updated.";
$txt[459] = "Edit";
$txt[460] = "Quick Edit";
$txt[461] = "Are you sure you want to remove this user account?";
$txt[462] = "The requested user account has been removed.";
$txt[463] = "User account not found.";
$txt[464] = "The user account has been updated.";
$txt[465] = "Are you sure you want to delete this room?";
$txt[466] = "The selected room has been deleted.";
$txt[467] = "This room has been deleted.";
$txt[468] = "Log bandwidth usage";
$txt[469] = "Bandwidth logging is disabled.  <a>Click here</a> to enable it.";	// Leave <a> and </a> alone
$txt[470] = "Bandwidth logging is enabled.  <a>Click here</a> to disable it.";	// Leave <a> and </a> alone
$txt[471] = "Default Bandwidth Limit (in MegaBytes)";
$txt[472] = "Limit users to <i>x</i> MBs per _t";	//  _t will be a drop down menu with Month or Day in it
$txt[473] = "Month";	// Yes you have seen this before, this time its not plural
$txt[474] = "Day";	// Yes you have seen this before, this time its not plural
$txt[475] = "Used";
$txt[476] = "Max (MB)";
$txt[477] = "Values for used bandwidth only count on 'in chat' pages and does not include the transmission header.  Bandwidth for other pages is not counted.";
$txt[478] = "May be set to 0 for unlimited or -1 for default";
$txt[479] = "Total Bandwidth";
$txt[480] = "You have exceeded the maximum allowed bandwidth for today.  Please check back tomarrow.";
$txt[481] = "You have exceeded the maximum allowed bandwidth for this month.  Please check back next month.";
$txt[482] = "Logged";
$txt[483] = "Manage/View";
$txt[484] = "Logging is currently disabled, <a>Click Here</a> to enable it.";	// Leave <a> and </a> alone
$txt[485] = "Logging is currently enabled, <a>Click Here</a> to disable it.";	// Leave <a> and </a> alone
$txt[486] = "Edit log settings";
$txt[487] = "Edit Event";
$txt[488] = "Event";
$txt[489] = "Add Event";
$txt[490] = "Time (HH:MM)";
$txt[491] = "Please use 24-hour time format";
$txt[492] = "Date (MM/DD/YYYY)";
$txt[493] = "You may enter an E-Mail message here and send it to all of your registered members.";
$txt[494] = "The E-Mail has been sent to all of your registered members.";
$txt[495] = "Lägg till Smiley";
$txt[496] = "Code";
$txt[497] = "Bild URL";
$txt[498] = "The following smilies have been installed.";
$txt[499] = "The following smiley files were found in the Smiley directory and are not currently being used.";
$txt[500] = "You can add many smilies at one time by uploading all the images you want to use into the smilies directory.";
$txt[501] = "Smiley";
$txt[502] = "Please visit <a href=\"http://x7chat.com/support.php\" target=\"_blank\">our support page</a> to view the X7 Chat Administrator documentation, and get technical support.<Br><br>User end documentation is included with X7 Chat and is available <a href=\"./help/\" target=\"_blank\">here</a>.";		// This one doesn't necessarily need to be translated
$txt[503] = "<a>[Click Here]</a> to access the documentation";	// Leave <a> and </a> alone
$txt[504] = "<a>[Click here]</a> to open the admin control panel in a new window.";		// Leave the <a> and </a> tags alone
$txt[505] = "Bli onsynlig";
$txt[506] = "Se onsynliga nick";
$txt[507] = "You do not have permission to become invisible";
$txt[508] = "Du är nu onsynlig i detta rum";
$txt[509] = "You are no longer invisible in this room";
$txt[510] = "Gå in i alla rum i onsynligt läge";
$txt[511] = "Du har fått ett privat meddelande.  Om det inte öppnas automatiskt, <a>[KLicka här]</a>";		// Leave <a> and </a> alone
$txt[512] = "_u has been banned from the room for _r.";	// _u is replaced with the username, _r is the reason
$txt[513] = "_u has been unbanned from this room.";
$txt[514] = "Olästa mail";
$txt[515] = "Max bokstäver i nick";
$txt[516] = "Regler som du ska följa <a>Regler</a>.";	// Leave <a> and </a> alone
$txt[517] = "Avtal/regler";
$txt[518] = "If you wish to disable the user agreement you may leave this blank.  You may use HTML.";
$txt[519] = "Lookup IP Address";
$txt[520] = "Lås upp";
$txt[521] = "You can clear extra rows by running <a>Clean Up</a>";	// Leave <a> and </a> alone
$txt[522] = "You must CHMOD 777 this directory before logging will work.";
$txt[523] = "Bli onsynlig";
$txt[524] = "Bli synlig";
$txt[525] = "In order to create or edit a theme you must CHMOD 777 the directory 'themes'.  <Br><Br><b>IF YOU ARE EDITING A THEME</b><Br> If you are editing an existing theme please CHMOD 777 the directory of the theme that you are editing and all the files in that directory also.  If you do not then your changes may fail to update.  For help please visit the X7 Chat website.";
$txt[526] = "Create New Theme";
$txt[527] = "Window Background Color";
$txt[528] = "Main Body Background Color";
$txt[529] = "Secondary Body Background Color";
$txt[530] = "Font Color";
$txt[531] = "Menu button font color";
$txt[532] = "Header font color";
$txt[533] = "Font Family";
$txt[534] = "Small Font Size";
$txt[535] = "Regular Font Size";
$txt[536] = "Big Font Size";
$txt[537] = "Bigger Font Size";
$txt[538] = "Border Color";
$txt[539] = "Alternate Border Color";
$txt[540] = "Link color";
$txt[541] = "Link hover color";
$txt[542] = "Active link color";
$txt[543] = "Text box background color";
$txt[544] = "Text box border color";
$txt[545] = "Text box font size";
$txt[546] = "Text box font color";
$txt[547] = "Color of other persons's name";
$txt[548] = "Color of your name";
$txt[549] = "Background color of chat window";
$txt[550] = "Border color of private message window";
$txt[551] = "Hemsida";
$txt[552] = "Theme Name";
$txt[553] = "Table header background";
$txt[554] = "Theme Author";
$txt[555] = "Theme Description";
$txt[556] = "Theme Version";
$txt[557] = "Unable to locate template theme directory.";
$txt[558] = "Your theme has been updated.";
$txt[559] = "You must enter a name for your theme.";
$txt[560] = "Chatting in..";
$txt[561] = "Memberlist";
$txt[562] = "Header background";
$txt[563] = "Calender font color";
$txt[564] = "<b>Syntax:</b> /mkick <i>reason</i> <Br>This command will kick everybody in the room.";
$txt[565] = "Please CHMOD 777 the mods directory.  For help with CHMODing please visit our website.";
$txt[566] = "Download Mods";
$txt[567] = "Installed Mods";
$txt[568] = "Avinstallera";
$txt[569] = "New Mods";
$txt[570] = "Mod Name";
$txt[571] = "Please CHMOD 777 the following files and directories:";
$txt[572] = "Start Installation";
$txt[573] = "Backup Files & Start";
$txt[574] = "Installation process completed, you may undo any CHMOD commands that you did.";
$txt[575] = "Start Uninstallation";
$txt[576] = "Uninstallation process completed, you may undo any CHMOD commands that you did.";
$txt[577] = "Can access Admin Panel : Keywords";
$txt[578] = "Theme Information";
$txt[579] = "Theme Fonts";
$txt[580] = "Theme Backgrounds";
$txt[581] = "Theme Borders";
$txt[582] = "Theme Links";
$txt[583] = "Theme Input Boxes";
$txt[584] = "Misc Theme Colors";
$txt[585] = "Background Color 4";
$txt[586] = "Border Style";
$txt[587] = "Border Size";
$txt[588] = "Textbox Border Style";
$txt[589] = "Textbox Border Size";
$txt[590] = "Server Room Type";
$txt[591] = "Multiroom Mode";
$txt[592] = "Single Room";
$txt[593] = "When set to Single Room mode users will be forced to enter the selected room when they login and cannot switch out of it.";
$txt[594] = "This room is being used by Single Room Mode, you may not delete it.  Please disable Single Room Mode in the General Settings section of the Settings tab.";
$txt[595] = "* New Client Support Session *";
$txt[596] = "Please wait, someone will be with you soon.";
$txt[597] = "A fatal error has occured.  Please contact the chat room administrator.  Copy the error dump from below and send it to them.";
$txt[598] = "Laddar ...";
$txt[599] = "Support Center";
$txt[600] = "Det nya kontot har blivit skapat.";
$txt[601] = "Skapa ett konto";
$txt[602] = "Access Password Protected Rooms W/O Password";
$txt[603] = "You must leave this window open, support requests will appear automatically in a new window.  If you have a popup blocker turned on you MUST disabled it.";
$txt[604] = "This panel allows you to adjust settings for using X7 Chat specifically as a support chat room.  It is highly recommend that you read the documentation in order to understand the following options.";
$txt[605] = "Support Accounts";
$txt[606] = "Message to be displayed if support is unavailable";
$txt[607] = "Support Available Image";
$txt[608] = "Support Unavailable Image";
$txt[609] = "List usernames seperated by semi-colins (;), these users will have access to the support center";
$txt[610] = "The account you are attempting to send this message to does not exist.";
$txt[611] = "Custom RGB Value";
$txt[612] = "You cannot delete the default theme.";

/* Added in 2.0.1 */
$txt[613] = "This chat room requires E-Mail activation before you can use your account.  Please check the inbox of the E-Mail account that you registered with.";
$txt[614] = "Thank you, your account has been activated.";
$txt[615] = "Unable to activate account, the activation code you entered was not found.";
$txt[616] = "Require Account Activation";
$txt[617] = "Please visit this URL to activate your chatroom account: ";
$txt[618] = "Chatroom Account Activation";

/** Special strings **/

// Days of the week and months, these are simply easier and more efficient to do this way
$txt['Sunday'] = "Söndag";
$txt['Monday'] = "Mondag";
$txt['Tuesday'] = "Tisdag";
$txt['Wednesday'] = "Onsdag";
$txt['Thursday'] = "Torsdag";
$txt['Friday'] = "Fredag";
$txt['Saturday'] = "Lördag";
$txt['January'] = "Januari";
$txt['February'] = "Februari";
$txt['March'] = "Mars";
$txt['April'] = "April";
$txt['May'] = "Maj";
$txt['June'] = "Juni";
$txt['July'] = "Juli";
$txt['August'] = "Augusti";
$txt['September'] = "September";
$txt['October'] = "Oktober";
$txt['November'] = "November";
$txt['December'] = "December";

?>
