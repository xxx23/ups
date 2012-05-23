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

$txt[0] = "Login";
$txt[1] = "Escreva o seu nome de usuário e palavra Passe";
$txt[2] = "Usuário";
$txt[3] = "Passe";
$txt[4] = "&nbsp;&nbsp; Login &nbsp;&nbsp;";	// "&nbsp;" is the same as a blank space
$txt[5] = "Reenviar palavra Passe";
$txt[6] = "Registar";
$txt[7] = "Status";
$txt[8] = "Usuários Online";
$txt[9] = "Total Salas";
$txt[10] = "Usuários registados";
$txt[11] = "Usuários Online";
$txt[12] = "Entrada Eventos";
$txt[13] = "Usuário ou palavra passe incorrectos";
$txt[14] = "Erro";

$txt[15] = "Sorry, the administrator of this server has disabled registration";
$txt[16] = "Sair";
$txt[17] = "Saiu com exito.";
$txt[18] = "Registar";
$txt[19] = "Preencha este formulário para se registar, todos os campos são obrigatórios.";
$txt[20] = "E-Mail";
$txt[21] = "Escreva palavra Passe novamente";
$txt[22] = "Mais detalhes sobre si podem ser editados depois de fazer o registo";
$txt[23] = "Nome de usuário incorrecto, o seu nome de usuário não pode conter espaços, comas, etc...";		// _n is the number of charcters your username must be under
$txt[24] = "Escreva uma direcção de E-Mail válido.";
$txt[25] = "Escreva uma palavra Passe.";
$txt[26] = "Palavra Passe incorecta.";
$txt[27] = "Nome de usuário já registado, volte atras e tente outro.";
$txt[28] = "A sua conta foi criada, <a href=\"./index.php\">Clique aqui</a> para fazer Login.";

$txt[29] = "Lista de Salas";
$txt[30] = "Usuários";
$txt[31] = "Nome";
$txt[32] = "Topico";

$txt[34] = "Ajuda";
$txt[35] = "Usuário Control";
$txt[36] = "Temas instalados";
$txt[37] = "Admin Control";

$txt[38] = "Frame desconhecida!";
$txt[39] = "Sorry, the administrator has disabled the chat room!";

$txt[40] = "Status";
$txt[41] = "P.C.Salas";

$txt[42] = "Não pode mandar mensagens para esta Sala enquanto um Operador não der autorização.";
$txt[43] = "Entro na Sala";
$txt[44] = "Saio da Sala";

$txt[45] = "Não é possivel carregar a página, a mesma não existe.";
$txt[55] = "Default";
$txt[56] = "Mais";
$txt[57] = "Escolha uma fonte:";

$txt[58] = "Que tamanho de fonte quere utilizar?";
$txt[59] = "Criar uma Sala";
$txt[60] = "Não tem autorização para criar uma Sala.";
$txt[61] = "Nome da Sala";
$txt[62] = "Preencha este formulário para criar uma Sala";
$txt[63] = "Criada";
$txt[64] = "Tipo de Sala";
$txt[65] = "Topico";
$txt[66] = "Bem vinda";
$txt[67] = "Max Usuários";
$txt[68] = "Publica";
$txt[69] = "Privada";
$txt[70] = "Moderada";
$txt[71] = "Nunca expira";
$txt[72] = "Nome de Sala inválido, o mesmo não pode conter, comas, ou caracteres especiais.";
$txt[73] = "Tipo de Sala desconhecida";
$txt[74] = "Vc. não está autorizado a criar salas";
$txt[75] = "A sua Sala foi criada com exito";
$txt[76] = "Este nome de Sala já existe, escolha um nome diferente";
$txt[77] = "Voltar";
$txt[78] = "Sala com palavra Passe";
$txt[79] = "Esta Sala esta protegida com palavra Passe. Entrar agora.";
$txt[80] = "Sala cheia, por favor escolha outra";
$txt[81] = "Salas cheias não estão mostradas";
$txt[82] = "Ver Salas cheias";
$txt[83] = "Esta a visualizar Salas cheias";
$txt[84] = "Esconder Salas cheias";
$txt[85] = "Perfil";
$txt[86] = "Acção";
$txt[87] = "Perfil completo";
$txt[88] = "Chat privado";
$txt[89] = "Enviar E-mail";
$txt[90] = "Actualizar....";

$txt[91] = "Ignorar";
$txt[92] = "Não ignorar";
$txt[93] = "Sem som";
$txt[94] = "Dar Ops";
$txt[95] = "Tirar Ops";
$txt[96] = "Som";
$txt[97] = "Kick";
$txt[98] = "Ver IP";
$txt[99] = "Dar Voice";
$txt[100] = "Tirar Voice";

$txt[101] = "Ignorar Usuário.";
$txt[102] = "Usuário já não está ignorado.";
$txt[103] = "Seleccionar Usuário";
$txt[104] = "Não tem autorização para completar esta acção";
$txt[105] = "Usuário passou ao estado de Operator";
$txt[106] = "Usuário já não é Operador";
$txt[107] = "A IP deste usuário é: ";
$txt[108] = "Escreva um comentário para Kikar este usuário:";
$txt[109] = "Usuário Kikado da Sala, não pode entrar durante 60 segundos.";
$txt[110] = "_u foi Kikado por _r";	// _u will be replaced with username and _r will be replaced with reason

$txt[111] = "This user has been muted.";
$txt[112] = "This user is no longer muted.";
$txt[113] = "This user has been given a voice.";
$txt[114] = "This users voice has been taken away.";

$txt[115] = "Foi Kikado desta Sala por _r";	// _r will be replaced with the reason for the kick
$txt[116] = "Foi Banido desta Sala por _r";	// _r will be replaced with the reason for the ban
$txt[117] = "Foi Banido deste servidor por for _r";	// _r will be replaced with the reason for the ban
$txt[118] = "Foi removido desta Sala, por favor <a href='./index.php'>clique aqui</a> para voltar à lista de Salas e escolher outra.";

$txt[119] = "Ver perfil";
$txt[120] = "(esconder)";
$txt[121] = "Localização";
$txt[122] = "Hobbies";
$txt[123] = "Grupo Usuários";
$txt[124] = "Descrição";
$txt[125] = "Foto";

$txt[126] = "_u agora é Operador da Sala";		// _u will print the username of the person who the action is preformed one.
$txt[127] = "_u já não é Operador da Sala";		// _u will print the username of the person who the action is preformed one.
$txt[128] = "Escolha uma cor";
$txt[129] = "_u foi dado voice";		// _u will print the username of the person who the action is preformed one.
$txt[130] = "_us foi retirado voice";		// _u will print the username of the person who the action is preformed one.
$txt[131] = "_u foi desligado";		// _u will print the username of the person who the action is preformed one.
$txt[132] = "_u já não está desligado";		// _u will print the username of the person who the action is preformed one.
$txt[133] = "Fechar";
$txt[134] = "Cor actualizada.";
$txt[135] = "Usuário C.P.";
$txt[136] = "Bem vindo ao Painel de Control de Usuário. Aqui pode actualizar o seu perfil, enviar mensagens, etc....";

$txt[137] = "Home";
$txt[138] = "Perfil";
$txt[139] = "Ajustes";
$txt[140] = "Status";
$txt[141] = "Lista de bloqueados";
$txt[142] = "Mensagens Offline";
$txt[143] = "Filtro de palavras";
$txt[144] = "Palavras";
$txt[145] = "As seguintes palavras estão bloqueadas, faça clique numa palavra para desbloquear.";

$txt[146] = "O se Status actual";
$txt[147] = "Mudar Status";
$txt[148] = "O seu status foi mudado para";
$txt[149] = "Não estou";
$txt[150] = "Activo";
$txt[151] = "Volto já";
$txt[152] = "Volto mais tarde";
$txt[153] = "Ajustar";
$txt[154] = "Mudar";
$txt[155] = "Max. Palavras";
$txt[156] = "Os eguintes usuários foram bloqueados, faça clique no usuário para desbloquear.";
$txt[158] = "_u foi removido da lista de usuários bloqueados.";	// _u is replaced with the person usersname
$txt[159] = "Ignorar usuário";
$txt[160] = "Adicionar";
$txt[161] = "_u foi adicionado à lista de ingnorados.";	// _u is replaced with the person usersname
$txt[162] = "_w foi filtrado.";		// _w is replaced with the word that was filtered
$txt[163] = "_w já não está filtrado.";		// _w is replaced with the word that was unfiltered
$txt[164] = "Filtro Palavras";
$txt[165] = "Texto";
$txt[166] = "Mudar";
$txt[167] = "As suas palavras chave foram mudadas";
$txt[168] = "Keywords are special words that will automatically be turned into links when sent to a chat room.<Br><Br>The following are keywords, click on one to remove it.";		// <br> means it goes onto a new line, same as an enter or return key does
$txt[169] = "Add Keyword";
$txt[170] = "URL";
$txt[171] = "Mensagem enviada.";
$txt[172] = "Segue uma lista de todas as mensagens recebidas.";
$txt[173] = "[None]";
$txt[174] = "------- Mensagem original -------";
$txt[175] = "Apagar";
$txt[176] = "RE: ";
$txt[177] = "Mensagem apagada";
$txt[178] = "Descrição";
$txt[179] = "De";
$txt[180] = "Data";
$txt[181] = "Enviar";
$txt[182] = "Enviar para";
$txt[183] = "Descrição";
$txt[184] = "A sua mensagem não pode ser enviada porque a caixa de entrada deste usuário está cheia.";
$txt[185] = "Está a usar um total de _p do seu espaço.  Tem espaço para mais _n mensagens.";	// _p is the precentage of used space and _n is the number of messages you have room for
$txt[186] = "Sexo";
$txt[187] = "Actualizar";
$txt[188] = "O seu pefil foi actualizado.";

$txt[189] = "Masculino";
$txt[190] = "Femenino";
$txt[191] = "------";

$txt[192] = "Enviar";
$txt[193] = "Use este formulário para enviar uma foto.  Só pode enviar uma fotografia de cada vez.
O formato da foto deve de ser em .gif, .png ou .jpeg e tem de ser _b bytes.  E com o tamanho _d px.";		// _b is replaced with the byte limit and _d is replaced with the size limit that the admin has specified

$txt[194] = "A sua foto foi enviada com sucesso e o seu perfil actualizado.";
$txt[195] = "Vc. não têm autorização para enviar uma foto.";
$txt[196] = "Foto demasiado grande.";
$txt[197] = "O formato da imagem não foi reconhecido.  Use só PNG, GIF ou JPEG.";
$txt[198] = "Avatar uploading is enabled but the administrator has not made the uploads directory writeable.  Please contact them and report this problem.  Your avatar was not uploaded.";

$txt[199] = "Hora de entrada (horas)";
$txt[200] = "Actualização (segundos)";
$txt[201] = "Tempo desligado (horas)";
$txt[202] = "Tempo desligado (minutos)";
$txt[203] = "Skin";
$txt[204] = "Idioma";
$txt[205] = "Desligar estilos";
$txt[206] = "Desligar Smilies";
$txt[207] = "Desligar Sons";
$txt[208] = "Desligar Timestamps";
$txt[209] = "Esconder E-Mail";
$txt[210] = "Ajustes actualizados";

$txt[211] = "Comando desconhecido";
$txt[212] = "_u rolls _d _s-sided dice.";		// _u become username, _d is the number of dice and _s is the number of sides
$txt[213] = "Estes são os resultados:";
$txt[214] = "Resultados modificados por _a.";	// _a is a number they are modified by

$txt[215] = "Acesso negado";
$txt[216] = "Não tem autorização para entrar nesta secção.";
$txt[217] = "Painel de ajustes do Chat.";
$txt[218] = "Ajustes gerais";
$txt[219] = "Op Lista";
$txt[220] = "Voice Lista";
$txt[221] = "Mute Lista";
$txt[222] = "Novo Ban";
$txt[223] = "Razão";
$txt[224] = "Usuário / IP / E-Mail";
$txt[225] = "Longitude";
$txt[226] = "Sempre";
$txt[227] = "OU";
$txt[228] = "Minutos";
$txt[229] = "Horas";
$txt[230] = "Dias";
$txt[231] = "Semanas";
$txt[232] = "Meses";
$txt[233] = "Clique no, IP ou E-Mail para activar novamente";
$txt[234] = "O novo ban foi aplicado.";
$txt[235] = "O ban foi removido.";
$txt[236] = "Os seguintes usuários tem o estado de Operadores nesta Sala.  Click on one to revoke its operator status.";
$txt[237] = "Os seguintes usuários tem voice nesta Sala.  Click on one to revoke their voice.";
$txt[238] = "Os seguintes usuários tem mute.  Clique no usuário para unmute.";
$txt[239] = "Não foi possivel encontrar um usuário com esse nome.";
$txt[240] = "Registos";
$txt[241] = "Registo de mensagens privadas";
$txt[242] = "Logging activado";
$txt[243] = "Logging desactivado";
$txt[244] = "Activar Logging";
$txt[245] = "Desactivar Logging";
$txt[246] = "Tamanho do arquivo: _s kb (_p)";		// _s is the size,_p is the percentage
$txt[247] = "Espaço livre restante: _s kb (_p)";		// _s is the remain free space, _p is the percentage
$txt[248] = "Ilimitado";
$txt[249] = "Abaixo estão os índices do registro.";
$txt[250] = "Apagar registos";
$txt[251] = "Seleccione um registro abaixo para vê-lo.";
$txt[252] = "A sua mensagem não foi enviada, demasiado extença.";
$txt[253] = "Imagem de fundo";
$txt[254] = "Imagem Logo";
$txt[255] = "Lembrar palavra Passe";
$txt[256] = "Olá _u,\n\nA o visitante com ip _i pedio para mudar a palavra Passe _s Chat.\n\nA nova palavra Passe é _p.\n\nObrigada,\n_s Suporte VipPt.com";			// Us "\n" for return/enter/new lines, _u for the username, _i for IP, _s for sitename, _p for new password
$txt[257] = "Escreva o seu nome de Usuário ou E-Mail para receber a sua palavra Passe.  A nova palvara Passe foi enviad para o E-Mail que temos registado.";
$txt[258] = "A sua nova palavra Passe foi enviada.";
$txt[259] = "A sua nova palavra Passe não foi enviada.  Não encontramos um Usuário ou E-Mail na nossa base de dados.";
$txt[260] = "A sua nova palavra Passe não foi enviada.  O E-Mail que nos indicou não consta na nossa base de dados.";
$txt[261] = "O administrador desligou o reenvio de palavras Passe.";
$txt[262] = "Novidades";
$txt[263] = "Não há ajuda para este topico.";
$txt[264] = "Salas expiram automaticamente: _t";		// _t is the time after which they expire
$txt[265] = "Nunca";
$txt[266] = "";
$txt[267] = "Não tem autorização para utilizar este comenado.";
$txt[268] = "Incapaz de terminar a acção no usuário especificado.";
$txt[269] = "<b>Syntax:</b> /kick <i>username</i> <i>motivo</i><Br>Este comando vai eliminar o usuário da Sala de Chat.";
$txt[270] = "<b>Syntax:</b> /ban <i>username</i> <i>motivo</i><Br>This command will remove a user from the chat room and prevent them from entering again.";
$txt[271] = "<b>Syntax:</b> /unban <i>username</i> <Br>Este comando permitirá que um usuário proibido entre na Sala de Chat novamente.";
$txt[272] = "<b>Syntax:</b> /op <i>username</i> <Br>Este comando dá Op a um usuário.";
$txt[273] = "<b>Syntax:</b> /deop <i>username</i> <Br>Este comando retira Op de um usuário.";
$txt[274] = "<b>Syntax:</b> /ignore <i>username</i> <Br>Este comando ignora as mensagens de um usuário.";
$txt[275] = "<b>Syntax:</b> /unignore <i>username</i> <Br>Este comando reactiva as mensagens de um usuário.";
$txt[276] = "As seguintes pessoas estão em Chat com você: ";
$txt[277] = "<b>Syntax:</b> /eu <i>action</i> <Br>Este comando dirá a outros usuários que você faz <i>action</i>.";
$txt[278] = "<b>Syntax:</b> /admin <i>username</i> <Br>Este comando fará o usuário administrador.";
$txt[279] = "_u é agora administrador";	// _u is the username
$txt[280] = "_u já não é mais administrador";	// _u is the username
$txt[281] = "<b>HEY!!</b>, You just tried to take admin status from yourself!  If you want to continue with this action, type /deadmin <i>your_username</i> 1";
$txt[282] = "<b>Syntax:</b> /voice <i>username</i> <Br>Este comando dará ao usuário voice e permitirá que fale em Salas moderadas.";
$txt[283] = "<b>Syntax:</b> /devoice <i>username</i> <Br>Este comando tira voice de usuário e não poderá mais falar em Salas moderadas.";
$txt[284] = "<b>Syntax:</b> /mute <i>username</i> <Br>Este comando não permite o usuário falar na Sala.";
$txt[285] = "<b>Syntax:</b> /unmute <i>username</i> <Br>Este comando permite um usuário voltar a falar em uma Sala.";
$txt[286] = "<b>Syntax:</b> /wallchan <i>mesagem</i> <Br>Este comando envia uma mensagem para todas as Salas.";
$txt[287] = "<a>[Clique aqui]</a> para abrir o painel de control de uma Sala em nova janela.";		// Leave the <a> and </a> tags alone
$txt[288] = "<b>Syntax:</b> /log <i>action</i> <Br>Este comando permite que você pare, veja o tamanho, o começo e o espaço livre o registro.  <i>Acção</i> pode ser:<Br><b>Stop</b>: Stops logging<Br><b>Start</b>: Starts logging<br><b>Clear</b>: Clears the existing log<Br><b>Size</b>: Tells you how much of the log is used";
$txt[289] = "You have used _s KB out of _m KB of log space.";	// _s is what you have used and _m is how much you can use
$txt[290] = "Usou um comando incorrecto.  Por favor <a>Clique aqui</a> para aprender como se usa.";
$txt[291] = "";
$txt[292] = "disrupting chat.";
$txt[293] = "_u fêz exame do status de todos os operadores.";		// _u is the username
$txt[294] = "The MOTD is blank.";	// (MOTD stands for Message Of The Day)
$txt[295] = "<b>Syntax:</b> /userip <i>username</i> <Br>Este comando é para ver Ip de <i>username</i>.";
$txt[296] = "_u convidou-o para entrar na Sala _r";	// _u is the inviting username and _r is the room
$txt[297] = "<b>Syntax:</b> /invite <i>username</i> <Br>Este comando convidará o usuário a entrar na Sla que você se encontra.";
$txt[298] = "<b>Syntax:</b> /join <i>room</i> <Br>Este comando permite que Vc. entre em um quarto.";
$txt[299] = "<a>[Clique aqui]</a> para entrar _r";	// leave <a> and </a> alone, _r is the room
$txt[300] = "Esta Sala não existe.";
$txt[301] = "<a>[Clique aqui]</a> para criar uma Sala.";	// leave <a> and </a> alone
$txt[302] = "<b>Syntax:</b> /msg <i>username</i> <Br>Este comando deixá-lo-á emitir uma mensagem confidencial a um usuário.";
$txt[303] = "<a>[Clique aqui]</a> para enviar uma mensagem para _u";	// _u is the reciever's username, leave <a> and </a> alone
$txt[304] = "<b>Syntax:</b> /wallchop <i>message</i> <Br>Este comando emitirá a sua mensagem a todos os operadores da Sala.";
$txt[305] = "(Message to _r Operators From _u)";	// _r is the room, _u is the person sending it

$txt[306] = "Este é seu painel de controle de administrador.  Aqui você pode configurarar ajustes, instalar mods, actualizar temas, e controlar os muitos outros aspectos da sua Sala.";
$txt[307] = "Nossas Notícia";
$txt[308] = "Temas";
$txt[309] = "Grupos De Usuário";
$txt[310] = "Controle Usuários";
$txt[311] = "Controle Salas";
$txt[312] = "Lista Ban";
$txt[313] = "Lagura de Banda";
$txt[314] = "Controle registos";
$txt[315] = "Calendário";
$txt[316] = "E-mail massivo";
$txt[317] = "Smilies";
$txt[318] = "Mods";
$txt[319] = "The XUpdater is disabled.  This module is required if you want to use this feature.  You can enable it by editing config.php.";
$txt[320] = "Não há nenhuma notícia disponível neste momento.";
$txt[321] = "Escolha por favor uma secção dos ajustes para actualizar.";
$txt[322] = "Hora e data";
$txt[323] = "Tempos de Expiração";
$txt[324] = "Banner URL";
$txt[325] = "Estilos e mensagens";
$txt[326] = "Fotos";
$txt[327] = "Login Page";
$txt[328] = "Avançado";
$txt[329] = "Desactivar Chat";
$txt[330] = "Permitir Registos";
$txt[331] = "Permitir Convidados";
$txt[332] = "Site Name";
$txt[333] = "Admin E-Mail";
$txt[334] = "Logout Page";
$txt[335] = "Caráteres máximos no status";
$txt[336] = "Caráteres máximos na mensagem";
$txt[337] = "Max offline Messages";
$txt[338] = "Minimum Refresh Time";
$txt[339] = "Maximum Refresh Time";
$txt[340] = "May be set to 0 for no limit.";
$txt[341] = "Default Langauge";
$txt[342] = "Default Theme";
$txt[343] = "Seus ajustes foram actualizados.  <a>Clique aqui</a> para retornar ao painel de ajuste.";		// Leave <a> and </a>
$txt[344] = "The minimum refresh rate cannot be greater then the maximum one, duh.";
$txt[345] = "Trajeto Do Registro";
$txt[346] = "Tamanho Máximo do Registo da sala (KB)";
$txt[347] = "Tamanho Máximo Do Registo do Usuário (KB)";
$txt[348] = "Formato hora";
$txt[349] = "Formato data";
$txt[350] = "Full Date/Time Format";
$txt[351] = "in seconds";
$txt[352] = "Tempo Máx inactivo";
$txt[353] = "Mensagens Expiram depois de";
$txt[354] = "Salas Expiram depois de";
$txt[355] = "Convidados expiram depois de";
$txt[356] = "em minutos";
$txt[357] = "Cookie Time";
$txt[358] = "Imagem de fundo";
$txt[359] = "Permitir mudar o fundo da Sala";
$txt[360] = "Pemitir mudar Logos";
$txt[361] = "Default Font";
$txt[362] = "Default Size";
$txt[363] = "Default Color";
$txt[364] = "Minimum Font Size";
$txt[365] = "Maximum Font Size";
$txt[366] = "Desactivar Smilies";
$txt[367] = "Desactivar estilos de mensagens";
$txt[368] = "Disable Auto-Linking";
$txt[369] = "Cor de mensagens";
$txt[370] = "Permitir fontes*";
$txt[371] = "Separadas com comas";
$txt[372] = "Permitir subir Fotos";
$txt[373] = "Auto-Resize Smaller Avatars";
$txt[374] = "Tamanho Max. de Fotos (in bytes)";
$txt[375] = "Tamanho Max. (width by height)";
$txt[376] = "Caminho do Upload";
$txt[377] = "Upload URL";
$txt[378] = "Mostrar Calendário de eventos";
$txt[379] = "Mostrar estatiscas";
$txt[380] = "Permitir lembrar Passe";
$txt[381] = "Dias a mostrar no calendário diário (1-3)";
$txt[382] = "Mostrare Calendário mensal";
$txt[383] = "Mostare Calendário Diário";
$txt[384] = "Desactivar a biblioteca de GD";	// GD Info: http://www.boutell.com/gd/
$txt[385] = "Se Vc. não souber o que é isto, não desactive.  Se seu sistema não o suportar, será desactivado automaticamente.";
$txt[386] = "A Sala com esse nome não existe.";
$txt[387] = "Vc. pode <a>clicar aqui</a> para criar a Sala.";		// Leave <a> and </a> alone
$txt[388] = "Entrar Sala Privada";
$txt[389] = "Entrar";
$txt[390] = "Nome Sala";
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
$txt[404] = "Author";
$txt[405] = "Description";
$txt[406] = "Download New Themes";
$txt[407] = "Você é agora um operador da Sala, para entrar no painel de control escreva /roomcp";
$txt[408] = "Grupos por defeito";
$txt[409] = "Novo membro";
$txt[410] = "Convidado";
$txt[411] = "Administrador";
$txt[412] = "Os ajustes do grupo foram realizados.";
$txt[413] = "Membros";
$txt[414] = "Novo grupo";
$txt[415] = "Alterações efectuadas.";
$txt[416] = "Alterar grupo";
$txt[417] = "Seleccionado muda o grupo para";
$txt[418] = "Os seguintes usuários estam neste grupo";
$txt[419] = "Seleccionar/Deseleccionar todos";
$txt[420] = "Apague todos os usuários antes de apagar o grupo.";
$txt[421] = "Grupo de usuários apagado.";
$txt[422] = "Pode criar uma Sala";
$txt[423] = "Pode criar uma Sala Privada";
$txt[424] = "Aqui pode mudar as caracteristicas do que este gurpo de usuários pode fazer.";
$txt[425] = "Pode ajustar para nunca expirar";
$txt[426] = "Pode ajustar a Sala para moderado";
$txt[427] = "Pode ver IP";
$txt[428] = "Pode Kickar Usuários";
$txt[429] = "Não pode ser banido ou kickado";
$txt[430] = "Tem o estatus de Operador em todas as Salas";
$txt[431] = "Tem voice em todas as Salas";
$txt[432] = "Pode ver esconder o E-Mail";
$txt[433] = "Pode ajustar/apagar palavras chave.";
$txt[434] = "Can control room logging";
$txt[435] = "Pode registar mensagens Privadas";
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
$txt[455] = "Para usuar este serviço, deve de ser um Operador";
$txt[456] = "User must have operator status and this feature must be enabled in the setting section of the admin panel.";
$txt[457] = "Can access Admin Panel : Calendar";
$txt[458] = "The permissions for this usergroup have been updated.";
$txt[459] = "Edit";
$txt[460] = "Quick Edit";
$txt[461] = "Tem a certeza de que quer apagar este usuário?";
$txt[462] = "A conta do usuário foi removida.";
$txt[463] = "Conta de usuário não encontrada.";
$txt[464] = "A conta do usuário foi actualizada.";
$txt[465] = "Tem a certeza de que quere apagar esta Sala?";
$txt[466] = "A Sala seleccionada foi apagada.";
$txt[467] = "Esta Sala foi apagada.";
$txt[468] = "Uso bandwidth";
$txt[469] = "Bandwidth logging is disabled.  <a>Click here</a> to enable it.";	// Leave <a> and </a> alone
$txt[470] = "Bandwidth logging is enabled.  <a>Click here</a> to disable it.";	// Leave <a> and </a> alone
$txt[471] = "Default Bandwidth Limit (in MegaBytes)";
$txt[472] = "Limite de usuários por <i>x</i> MBs _t";	//  _t will be a drop down menu with Month or Day in it
$txt[473] = "Mes";	// Yes you have seen this before, this time its not plural
$txt[474] = "Dia";	// Yes you have seen this before, this time its not plural
$txt[475] = "Usado";
$txt[476] = "Max (MB)";
$txt[477] = "Values for used bandwidth only count on 'in chat' pages and does not include the transmission header.  Bandwidth for other pages is not counted.";
$txt[478] = "May be set to 0 for unlimited or -1 for default";
$txt[479] = "Total Bandwidth";
$txt[480] = "You have exceeded the maximum allowed bandwidth for today.  Please check back tomarrow.";
$txt[481] = "You have exceeded the maximum allowed bandwidth for this month.  Please check back next month.";
$txt[482] = "Registado";
$txt[483] = "Ajustar/Ver";
$txt[484] = "Logging is currently disabled, <a>Click Here</a> to enable it.";	// Leave <a> and </a> alone
$txt[485] = "Logging is currently enabled, <a>Click Here</a> to disable it.";	// Leave <a> and </a> alone
$txt[486] = "Edit log settings";
$txt[487] = "Editar evento";
$txt[488] = "Evento";
$txt[489] = "Adicionar evento";
$txt[490] = "Hora (HH:MM)";
$txt[491] = "Please use 24-hour time format";
$txt[492] = "Data (MM/DD/YYYY)";
$txt[493] = "You may enter an E-Mail message here and send it to all of your registered members.";
$txt[494] = "The E-Mail has been sent to all of your registered members.";
$txt[495] = "Add Smiley";
$txt[496] = "Code";
$txt[497] = "Image URL";
$txt[498] = "The following smilies have been installed.";
$txt[499] = "The following smiley files were found in the Smiley directory and are not currently being used.";
$txt[500] = "You can add many smilies at one time by uploading all the images you want to use into the smilies directory.";
$txt[501] = "Smiley";
$txt[502] = "Please visit <a href=\"http://x7chat.com/support.php\" target=\"_blank\">our support page</a> to view the X7 Chat Administrator documentation, and get technical support.<Br><br>User end documentation is included with X7 Chat and is available <a href=\"./help/\" target=\"_blank\">here</a>.";		// This one doesn't necessarily need to be translated
$txt[503] = "<a>[Click Here]</a> to access the documentation";	// Leave <a> and </a> alone
$txt[504] = "<a>[Click here]</a> to open the admin control panel in a new window.";		// Leave the <a> and </a> tags alone
$txt[505] = "Ficae invisivel";
$txt[506] = "Ver usuários invisiveis";
$txt[507] = "Não tem autorização para ficar invisivel";
$txt[508] = "Não está invisivel nesta Sala";
$txt[509] = "Já não está invisivel nesta Sala";
$txt[510] = "Entar em todas as Salas invisivel";
$txt[511] = "Recebeu uma mensagens privada.  Se não abrir em uma janela nova automaticamente, <a>[Clique aqui]</a>";		// Leave <a> and </a> alone
$txt[512] = "_u foi banido desta Sala por _r.";	// _u is replaced with the username, _r is the reason
$txt[513] = "_u já não está banido desta Sala.";
$txt[514] = "Unread Mail";
$txt[515] = "Max caracteres de nome usuário";
$txt[516] = "Entering chat signifies that you agree to abide by the <a>User Agreement</a>.";	// Leave <a> and </a> alone
$txt[517] = "User Agreement";
$txt[518] = "If you wish to disable the user agreement you may leave this blank.  You may use HTML.";
$txt[519] = "Lookup IP Address";
$txt[520] = "Lookup";
$txt[521] = "You can clear extra rows by running <a>Clean Up</a>";	// Leave <a> and </a> alone
$txt[522] = "You must CHMOD 777 this directory before logging will work.";
$txt[523] = "Fique invisivel";
$txt[524] = "Fique visivel";
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
$txt[551] = "Home Website URL";
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
$txt[568] = "Uninstall";
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
$txt[598] = "Loading ...";
$txt[599] = "Support Center";
$txt[600] = "The new user account has been created.";
$txt[601] = "Create User Account";
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
$txt['Sunday'] = "Domingo";
$txt['Monday'] = "Segunda";
$txt['Tuesday'] = "Terça";
$txt['Wednesday'] = "Quarta";
$txt['Thursday'] = "Quinta";
$txt['Friday'] = "Sexta";
$txt['Saturday'] = "Sabado";
$txt['January'] = "Janeiro";
$txt['February'] = "Fevereiro";
$txt['March'] = "Março";
$txt['April'] = "Abril";
$txt['May'] = "Maio";
$txt['June'] = "Junho";
$txt['July'] = "Julho";
$txt['August'] = "Agosto";
$txt['September'] = "Setembro";
$txt['October'] = "Outubro";
$txt['November'] = "Novembro";
$txt['December'] = "Dezembro";

?>
