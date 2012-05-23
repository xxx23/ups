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
//	"<br>" will insert a enter/return/start on the next line.  You may add <br>'s but please leave the ones already tAqui in place.
//	"<b>" will make text turn bold until it reaches a "</b>" which stops text from being bold.
//	"<i>" will make text turn italic until it reaches a "</i>" which stops text from being italic.

$txt[0] = "Login";
$txt[1] = "Por Favor insira o seu Nome de User e Password";
$txt[2] = "User";
$txt[3] = "Senha";
$txt[4] = "&nbsp;&nbsp; Login &nbsp;&nbsp;";	// "&nbsp;" is the same as a blank space
$txt[5] = "Enviar Senha";
$txt[6] = "Registar";
$txt[7] = "Status";
$txt[8] = "Número de Users OnLine";
$txt[9] = "Total Salas de conversa";
$txt[10] = "Users Registados";
$txt[11] = "Users Online";
$txt[12] = "Evento Entrando";
$txt[13] = "O User ou a senha estão incorrectos";
$txt[14] = "Erro";

$txt[15] = "Lamentamos, mas um Admin desactivou os registos novos";
$txt[16] = "Sair";
$txt[17] = "Acabou de Sair.";
$txt[18] = "Registar";
$txt[19] = "Preencha este formulários, todos os campos são obrigatórios.";
$txt[20] = "E-Mail";
$txt[21] = "Re-escreva a senha";
$txt[22] = "Pode acrescentar mais detalhes depois de ser um user registado";
$txt[23] = "User Inválido, o seu nome de user pode conter letras mas nao espaços, commas, períodos, apostrofes, semicolons.  O seu user deve ter _n caracteres de comprimento.";		// _n is the number of charcters your User must be under
$txt[24] = "Por favor entre um email correcto.";
$txt[25] = "Por favor entre uma senha.";
$txt[26] = "As senhas introduzidas não correspondem.";
$txt[27] = "Desculpe, mas este nome de user já está em uso, por favor recue e escolha um diferente.";
$txt[28] = "A sua conta foi criada, <a href=\"./index.php\">Click aqui</a> para entrar.";

$txt[29] = "Lista de Salas de Conversa";
$txt[30] = "Users";
$txt[31] = "Nome";
$txt[32] = "Tópico";

$txt[34] = "Ajuda";
$txt[35] = "Users CP";
$txt[36] = "Temas instalados";
$txt[37] = "Admin CP";

$txt[38] = "Desculpe Frame desconhecida!";
$txt[39] = "Desculpe, mas um Admin cancelou esta sala de conversa!";

$txt[40] = "Status";
$txt[41] = "Sala CP";

$txt[42] = "Não pode usar esta sala a não ser que o Admin ou o operador lhe dê esta possibilidade.";
$txt[43] = "Entrou na sala";
$txt[44] = "Saiu da sala";

$txt[45] = "Impossivel carregar a página, esta página não existe existe.";
$txt[55] = "Default";
$txt[56] = "Mais";
$txt[57] = "Escolha um tipo de letra:";

$txt[58] = "De que tamanho prefere a Letra?";
$txt[59] = "Criar Sala";
$txt[60] = "Não tempermissões para criar uma sala nova, só os Admin o podem fazer.";
$txt[61] = "Nome da Sala";
$txt[62] = "Preencha o formulario para criar uma nova sala";
$txt[63] = "Criar";
$txt[64] = "Tipo de sala";
$txt[65] = "Tópico";
$txt[66] = "Saudações";
$txt[67] = "Maximo de Users";
$txt[68] = "Publico";
$txt[69] = "Privado";
$txt[70] = "Moderado";
$txt[71] = "Nunca expira";
$txt[72] = "Nome de sala Invalido, o nome pode conter letras e Números mas não commas, períodos, apostrofes, asteriscos e semicolons.";
$txt[73] = "Tipo de sala desconhecido";
$txt[74] = "Não está autorizado a criar salas de conversa";
$txt[75] = "A sua Sala foi criada";
$txt[76] = "Nome da sala já em uso, escolha uma diferente";
$txt[77] = "Recuar";
$txt[78] = "Necessita de Senha";
$txt[79] = "Esta Sala precisa de uma senha, por favor escreva a senha agora.";
$txt[80] = "Esta sala está cheia por favor escolha uma diferente";
$txt[81] = "Salas cheias nao serão mostradas";
$txt[82] = "Mostrar salas cheias";
$txt[83] = "Salas Cheias serão mostradas";
$txt[84] = "esconder salas cheias";
$txt[85] = "Perfil";
$txt[86] = "Acção";
$txt[87] = "Perfil total";
$txt[88] = "Conversa privada";
$txt[89] = "Enviando email";
$txt[90] = "Actualizando....";

$txt[91] = "Ignorar";
$txt[92] = "Parar de Ignorar";
$txt[93] = "Calar";
$txt[94] = "Dar Ops";
$txt[95] = "Receber Ops";
$txt[96] = "fazer unmute";
$txt[97] = "Chutar";
$txt[98] = "Ver IP";
$txt[99] = "Dar Voz";
$txt[100] = "Receber Voz";

$txt[101] = "User ignorado.";
$txt[102] = "User deixou de estar ignorado.";
$txt[103] = "Seleccionar user";
$txt[104] = "Não tem permissão para esta operação";
$txt[105] = "User garantiu o status de Operador";
$txt[106] = "User foi desqualificado de Operador";
$txt[107] = "Endereço IP do User: ";
$txt[108] = "Razão para chutar este user?:";
$txt[109] = "O User foi chutado da sala de conversa, não poderá entrar nos próximos 60 segundos.";
$txt[110] = "_u foi chutado por _r";	// _u will be replaced with User and _r will be replaced with reason

$txt[111] = "Este User foi impedido de Conversar.";
$txt[112] = "Este User já pode Conversar.";
$txt[113] = "Este User recebeu autorização para falar.";
$txt[114] = "Foi retirada Autorização ao user para falar na sala.";

$txt[115] = "Foi chutado da sala por  _r";	// _r will be replaced with the reason for the kick
$txt[116] = "Foi Banido da sala porque _r";	// _r will be replaced with the reason for the ban
$txt[117] = "Foi Banido do Servidor porque _r";	// _r will be replaced with the reason for the ban
$txt[118] = "Foi Removido desta sala de conversa, por favor <a href='./index.php'>click aqui</a> para retornar á lista de salas e selecionar uma diferente.";

$txt[119] = "Ver perfil";
$txt[120] = "(Invisivel)";
$txt[121] = "Localidade";
$txt[122] = "Interessas";
$txt[123] = "Grupo de Users";
$txt[124] = "Biografia";
$txt[125] = "Avatar";

$txt[126] = "_u é um Operador de sala";		// _u will print the User of the person who the acção is preformed one.
$txt[127] = "_u já não é um operador de sala";		// _u will print the User of the person who the acção is preformed one.
$txt[128] = "Escolher Cor";		
$txt[129] = "_u recebeu autorização para falar";		// _u will print the User of the person who the acção is preformed one.
$txt[130] = "_us Recebeu autorização para falar";		// _u will print the User of the person who the acção is preformed one.
$txt[131] = "_u Foi impedido de falar";		// _u will print the User of the person who the acção is preformed one.
$txt[132] = "_u já nao esta impedido de falar";		// _u will print the User of the person who the acção is preformed one.
$txt[133] = "Fechar";		
$txt[134] = "A Cor da sua mensagem foi actualizada.";		
$txt[135] = "Painel de controle do User";
$txt[136] = "Bem Vindo ao seu painel de controle de user. Aquipode mudar as suas preferências, enviar mensagens, e configurar muitas opções da sala.";

$txt[137] = "Home";
$txt[138] = "Perfil";
$txt[139] = "Configurações";
$txt[140] = "Status";
$txt[141] = "Lista de Bloqueados";
$txt[142] = "Offline Msgs";
$txt[143] = "Filtro de palavras";
$txt[144] = "Palavras chave";
$txt[145] = "Estas palavras serão filtradas, click em uma para remover da lista.";

$txt[146] = "Status actual";
$txt[147] = "Definir Status";
$txt[148] = "O seu Status foi mudado para:";
$txt[149] = "Ausente";
$txt[150] = "Disponivel";
$txt[151] = "Já volto";
$txt[152] = "Volto mais tarde";
$txt[153] = "Personalizado";
$txt[154] = "Mudar";
$txt[155] = "Maximo de Letras";
$txt[156] = "Os seguintes Users foram ignorados, click um para retirar da lista.";
$txt[158] = "_u foi removido da sua lista de ignorados.";	// _u is replaced with the person usersname
$txt[159] = "Ignorar um user";
$txt[160] = "Adicionar";
$txt[161] = "_u foi adicionado à sua lisa de ignorados.";	// _u is replaced with the person usersname
$txt[162] = "_w foi filtrado.";		// _w is replaced with the word that was filtered
$txt[163] = "_w não será mais filtrado.";		// _w is replaced with the word that was unfiltered
$txt[164] = "Filtrar palavra";
$txt[165] = "Texto";
$txt[166] = "Substituir por";
$txt[167] = "As suas palavras chave foram substituidas";
$txt[168] = "Palavras chave são palavras que sao automaticamente transformadas em links quando inseridas numa sala de conversa.<Br><Br>As Seguintes são palavras chave, click numa para remover.";		// <br> means it goes onto a new line, same as an enter or return key does
$txt[169] = "Adicionar palavra chave";
$txt[170] = "URL";
$txt[171] = "A sua mensagem seguiu.";
$txt[172] = "Em baixo estão as mensagens recebidas.";
$txt[173] = "[Nenhum]";
$txt[174] = "------- Mensagem Original -------";	
$txt[175] = "Apagar";
$txt[176] = "RE: ";
$txt[177] = "A mensagem foi apagada";
$txt[178] = "Assunto";
$txt[179] = "De";
$txt[180] = "Data";
$txt[181] = "Enviar";
$txt[182] = "Enviado para";
$txt[183] = "Assunto";
$txt[184] = "A sua mensagem nao foi enviada porque a caixa de correio do user esta cheia.";
$txt[185] = "Está a usar _p da sua caixa de entrada.  Tem espaço para _n mais mensagens.";	// _p is the precentage of used space and _n is the number of messages you have room for
$txt[186] = "Genero";
$txt[187] = "Actualizar";
$txt[188] = "O seu perfil Foi actualizado.";

$txt[189] = "Homem";
$txt[190] = "Mulher";
$txt[191] = "------";

$txt[192] = "Enviar";
$txt[193] = "Pode usar este form para enviar um Avatar.  Só pode ter um avatar de cada vez no servidor.
O seu avatar tem que ser uma imagem .gif, .png or .jpeg e ter menos de _b bytes de tamanho. O Avatar deve ter  _d pixels.";		// _b is replaced with the byte limit and _d is replaced with the size limit that the admin has specified

$txt[194] = "O seu avatar foi enviado com sucesso e actualizado no seu perfil.";
$txt[195] = "O Envio de avatars foi desactivado.";
$txt[196] = "O avatar é demasiado grande.";
$txt[197] = "O Formato do avatar nao foi reconhecido.  Por favor use PNG, GIF or JPEG.";
$txt[198] = "O envio de avatares esta habilitado mas o Admin nao deixou a pasta de avatares com possibilidade de escrita, contacte um Admin e reporte o problema. O avatar nao foi enviado";
$txt[199] = "Hora de entrada (hours)";
$txt[200] = "Taxa de reload (seconds)";
$txt[201] = "Time offset (hours)";
$txt[202] = "Time offset (minutes)";
$txt[203] = "Tema";
$txt[204] = "Linguagem";
$txt[205] = "Desabilitar estilos";
$txt[206] = "Desabilitar Smilies";
$txt[207] = "Desabilitar sons";
$txt[208] = "Desabilitar afixação de hora";
$txt[209] = "Esconder E-Mail";
$txt[210] = "Configuraçoes guardadas";

$txt[211] = "Comando desconhecido";
$txt[212] = "_u rolar _d _s-lado do dado.";		// _u become User, _d is the number of dice and _s is the number of sides
$txt[213] = "os resultados são:";
$txt[214] = "O resultado foi modificado por _a.";	// _a is a number they are modified by

$txt[215] = "Acesso interdito";
$txt[216] = "Não está autorizado a entrar nesta secção.";
$txt[217] = "Este painiel serve para ajustar mitas coisas na sala de conversa.";
$txt[218] = "Ajustes Gerais";
$txt[219] = "Lista de Ops";
$txt[220] = "Lista de Voices";
$txt[221] = "Lista de Mutes";
$txt[222] = "Novo Banido";
$txt[223] = "Razão";
$txt[224] = "User / IP / E-Mail";
$txt[225] = "Tamanho";
$txt[226] = "Para sempre";
$txt[227] = "OU";
$txt[228] = "Minutos";
$txt[229] = "Horas";
$txt[230] = "Dias";
$txt[231] = "Semanas";
$txt[232] = "Meses";
$txt[233] = "Click no User, IP ou E-Mail address tirar o Ban";
$txt[234] = "Aplicado o comando Ban, a pessoa foi banida.";
$txt[235] = "O Ban foi removido.";
$txt[236] = "O seguinte user tem status de operador.  Click no user para remosver o status de operador.";
$txt[237] = "O seguinte user tem voz na sala. Click para retirar a voz.";
$txt[238] = "O User seguinte foi calado.  Click ono nome para retirar.";
$txt[239] = "impossivel de encontrar esse User.";
$txt[240] = "Logs";
$txt[241] = "Log mensagens privadas";
$txt[242] = "Logging activado";
$txt[243] = "Logging desactivado";
$txt[244] = "Activar Logging";
$txt[245] = "Desactivar Logging";
$txt[246] = "Tamanhodo LOG: _s kb (_p)";		// _s is the size,_p is the percentage
$txt[247] = "Espaço livre restante: _s kb (_p)";		// _s is the remain free space, _p is the percentage
$txt[248] = "Ilimitado";
$txt[249] = "Conteúdo do LOG.";
$txt[250] = "Apagar Log";
$txt[251] = "Selecionar um log para ver.";
$txt[252] = "Mensagem demasiado longa, não enviada.";
$txt[253] = "Imagem de fundo";
$txt[254] = "Imagem de LOGO";
$txt[255] = "Lembrete de senha";
$txt[256] = "Olá _u,\n\nO visitante com ip address _i pediu que a sua senha seja mudada na _s sala.\n\nA sua nova senha é: _p.\n\nobrigados,\n_s Admin";			// Us "\n" for return/enter/new lines, _u for the User, _i for IP, _s for sitename, _p for new password
$txt[257] = "Escreva o seu nome de user ou o seu email para receber uma nova senha.  Anova senha será enviada para o seu .";
$txt[258] = "A nova senha foi enviada.";
$txt[259] = "A nova senha nao foi enviada. Não foi possivel identificar e localizar uma conta com esse nome de user ou endereço de email.";
$txt[260] = "A nova senha nao foi enviada.  Foi localizado o user, mas nao tem email associado.";
$txt[261] = "O Admin desabilitou o lembrete de passwords.";
$txt[262] = "Novidades";
$txt[263] = "Desculpe, mas não há ajuda para este tópico.";
$txt[264] = "As salas expiram depois de: _t";		// _t is the time after which they expire
$txt[265] = "Nunca";
$txt[266] = "";
$txt[267] = "Não tem permissão para usar este comando.";
$txt[268] = "Não foi possivel completar a acção no user.";
$txt[269] = "<b>Sintaxe:</b> /kick <i>User</i> <i>Motivo</i><Br>Este comando remove um user da sala.";
$txt[270] = "<b>Sintaxe:</b> /ban <i>User</i> <i>Motivo</i><Br>Este Comando remove um user da sala e previne que ele volte a entrar..";
$txt[271] = "<b>Sintaxe:</b> /unban <i>User</i> <Br>Este Comando permite que um user banido volte a entrar de novo na sala.";
$txt[272] = "<b>Sintaxe:</b> /op <i>User</i> <Br>Este Comando dá estatuto de operador a um user.";
$txt[273] = "<b>Sintaxe:</b> /deop <i>User</i> <Br>Este Comando tira operador do estatuto do user.";
$txt[274] = "<b>Sintaxe:</b> /ignore <i>User</i> <Br>Este Comando bloqueia todas as mensagens de um determinado user.";
$txt[275] = "<b>Sintaxe:</b> /unignore <i>User</i> <Br>Este Comando deixa de ignoara as mensagens de um determinado user (bloqueado com o comando /ignore).";
$txt[276] = "Os seguintes utilzadoresestão em conversa consigo: ";
$txt[277] = "<b>Sintaxe:</b> /me <i>acção</i> <Br>Este Comando comunica aos outros que vc fez <i>acção</i>.";
$txt[278] = "<b>Sintaxe:</b> /admin <i>User</i> <Br>Este Comando dá ao user estatuto de Admin.";
$txt[279] = "_u é agora um Admin da sala de conversa";	// _u é o User
$txt[280] = "_u deixou de ser Admin da sala de conversa";	// _u é o User
$txt[281] = "<b>HEY!!</b>, Voce tentou retirar o estatuto de Admin de si próprio!  se quer continuar com esta acçao, escreva /deadmin <i>seu_nome_user</i> 1";
$txt[282] = "<b>Sintaxe:</b> /voice <i>User</i> <Br>Este Comando dará o estatuto de poder falar em salas moderadas ao user a quem aplicamos.";
$txt[283] = "<b>Sintaxe:</b> /devoice <i>User</i> <Br>Este Comando retira a possibilidade de um user poder falar numa sala moderada.";
$txt[284] = "<b>Sintaxe:</b> /mute <i>User</i> <Br>Este Comando torna o user mudo por momentos enquanto o admin entender, não poderá escrever frases na sala.";
$txt[285] = "<b>Sintaxe:</b> /unmute <i>User</i> <Br>Este Comando desactiva o comando /mute e faz o user poder screver frses de novo na sala.";
$txt[286] = "<b>Sintaxe:</b> /wallchan <i>message</i> <Br>Este Comando manda uma mensagem para todas as salas de conversa.";
$txt[287] = "<a>[Click aqui]</a> para abrir o painel de controlo da sala numa nova janela.";		// Leave the <a> and </a> tags alone
$txt[288] = "<b>Sintaxe:</b> /log <i>acção</i> <Br>Este Comando permite-lhe parar, ver tamanho, iniciar e limpar o log.  <i>acção</i> a acção pode ser:<Br><b>Stop</b>: Para de registar no log<Br><b>Start</b>: Inicia a gravaçao do log<br><b>Clear</b>: limpa os registo existentes no log<Br><b>Size</b>: Diz quanto tamanho do log esta ja usados.";
$txt[289] = "Voce já usou _s KB de _m KB de log total.";	// _s is what you have used and _m is how much you can use
$txt[290] = "Usou o comando mode de uma forma incorrecta.  Por Favor <a>Click aqui</a> para aprender como se usa.";
$txt[291] = "";
$txt[292] = "disrupting chat.";
$txt[293] = "_u retirou estatuto de operador de todos os operadores.";		// _u is the User
$txt[294] = "O MOTD( Mensagem do Dia ) está vazio.";	// (MOTD stands for Message Of The Day)
$txt[295] = "<b>Sintaxe:</b> /userip <i>User</i> <Br>Este Comando mosra o endereço IP de <i>User</i>.";
$txt[296] = "_u convidou-o a entrar a sala de conversa _r";	// _u is the inviting User and _r is the room
$txt[297] = "<b>Sintaxe:</b> /invite <i>User</i> <Br>Este Comando envia um convite ao user para entrar na sala que esta neste momento.";
$txt[298] = "<b>Sintaxe:</b> /join <i>sala</i> <Br>Este Comando permite entrar numa nova sala de conversa.";
$txt[299] = "<a>[Click Aqui]</a> para entrar em _r";	// leave <a> and </a> alone, _r is the room
$txt[300] = "Essa sala de conversa não existe.";
$txt[301] = "<a>[Click Aqui]</a> para criar a sala.";	// leave <a> and </a> alone
$txt[302] = "<b>Sintaxe:</b> /msg <i>User</i> <Br>Este Comando permmite enviar uma mensagem privada para um user.";
$txt[303] = "<a>[Click Aqui]</a> para enviar uma mensagem para _u";	// _u is the reciever's User, leave <a> and </a> alone
$txt[304] = "<b>Sintaxe:</b> /wallchop <i>mensagem</i> <Br>Este Comando envia uma mensagem para todos os operadores de salas.";
$txt[305] = "(mensagem para _r Operators De _u)";	// _r is the room, _u is the person sending it

$txt[306] = "Este é o seu Painel de Controle de Admin. Aqui pode configurar settings, instalar mods, update themas, e gerir muitos outros aspectos da sua sala de conversa.";
$txt[307] = "Novidades nossas";
$txt[308] = "Temas";
$txt[309] = "Grupos de Users";
$txt[310] = "Gerir Users";
$txt[311] = "Gerir Salas";
$txt[312] = "Lista de Banidos";
$txt[313] = "Largura de Banda";
$txt[314] = "Gerir Logs";
$txt[315] = "Calendário";
$txt[316] = "Mail maciço";
$txt[317] = "Smiles";
$txt[318] = "Mods";
$txt[319] = "O XUpdater está desactivaado. Este módulo é requerido para usar esta utilidade.  Pode ser activado editando config.php.";
$txt[320] = "Não há novidades.";
$txt[321] = "por favor escolha uma secçao para actualizar.";
$txt[322] = "Hora e Data";
$txt[323] = "empo para expirar";
$txt[324] = "URL's Banidos";
$txt[325] = "Estilos e Mensagens";
$txt[326] = "Avatars";
$txt[327] = "Página de Login";
$txt[328] = "Avançado";
$txt[329] = "Desactivar sala";
$txt[330] = "Permitir Registo";
$txt[331] = "Permitir Convidados (guests)";
$txt[332] = "Nome do Site";
$txt[333] = "E-Mail do Admin";
$txt[334] = "Página de Logout";
$txt[335] = "Max caracteres no Status";
$txt[336] = "Max caracteres na Mensagem";
$txt[337] = "Max mensagens Offline";
$txt[338] = "Tempo minimo refresh";
$txt[339] = "Tempo máximo de refresh";
$txt[340] = "Coloque 0(zero) para ilimitado.";
$txt[341] = "Linguagem Base";
$txt[342] = "Tema base";
$txt[343] = "As suas configurações foram alteradas.  <a>Click Aqui</a> par avoltar para o painel de configurações.";		// Leave <a> and </a>
$txt[344] = "A minima taxa não pode ser mair que a Máxima taxa de refresh da sala, daaaaaaah.";
$txt[345] = "Log Path";
$txt[346] = "Tamanho Max do log da sala (KB)";
$txt[347] = "MTamanho Max do log do user (KB)";
$txt[348] = "Formato da hora";
$txt[349] = "Formato da data";
$txt[350] = "Data/Hora completos";
$txt[351] = "em segundos";
$txt[352] = "Max tempo de espera";
$txt[353] = "Messages Expira depois de";
$txt[354] = "Rooms Expira depois de";
$txt[355] = "Contas de convidados expiram depois de";
$txt[356] = "em minutos";
$txt[357] = "Duração do Cookie";
$txt[358] = "Imagem de fundo";
$txt[359] = "Permitir modificações no fundo da sala";
$txt[360] = "Permitir modificaçoes nos Logos";
$txt[361] = "Default Fonte";
$txt[362] = "Default Tamanho";
$txt[363] = "Default Cor";
$txt[364] = "Tamanho minimo da Fonte";
$txt[365] = "Tamanho Máximo da Fonte";
$txt[366] = "Desactivar Smiles";
$txt[367] = "Desactivar esilos em mensagens";
$txt[368] = "Desactivar auto-linking";
$txt[369] = "Cor das mensagens do systema";
$txt[370] = "Fontes permitidas*";
$txt[371] = "Separadas por comas";
$txt[372] = "permitir Upload de Avatares";
$txt[373] = "mudar automaticamente o tamanho de Avatars pequenos";
$txt[374] = "Tamanho máximo par upload de Avatares (em bytes)";
$txt[375] = "Tamanhomáximo do avatar (largura X altura)";
$txt[376] = "Caminho dos Uploads";
$txt[377] = "URL de Upload";
$txt[378] = "Mostrar calendário de eventos";
$txt[379] = "Mostrar Status";
$txt[380] = "Activar o lembrete de password";
$txt[381] = "Dias a mostra no calendario diário (1-3)";
$txt[382] = "Mostrar calendário Mensal";
$txt[383] = "Mostrar calendário Diário";
$txt[384] = "Desactivar o uso da GD Library";	// GD Info: http://www.boutell.com/gd/
$txt[385] = "Se não sabe o que é não desactive. Se o seu sistema não o suportar, ele será automaticamente desactivado.";
$txt[386] = "Não existe uma sala com esse nome.";
$txt[387] = "Voce pode <a>Click Aqui</a> para entrar na sala pretendida.";		// Leave <a> and </a> alone
$txt[388] = "Entrar numa sala privada";
$txt[389] = "Entrando";
$txt[390] = "Nome do Tema";
$txt[391] = "Tem a certeza que deseja apagar este tema?";
$txt[392] = "Sim";
$txt[393] = "Não";
$txt[394] = "O tema seleccionado foi apagado.";
$txt[395] = "Não foi possivel apagar o tema seleccionado. Por favor apague a pasta _d (dentro da pasta themes) através de FTP.";		//_d will be replaced with the directory name
$txt[396] = "Se usou um CHMOD 777 na pasta de Tema, é extremamente recomendável que volte a usar o comando para as autorizaçõs que tinha antes.  (Normalmente 755)";
$txt[397] = "Por favor usar CHMOD 777 na pasta de Temas.";
$txt[398] = "CHMOD Completo";
$txt[399] = "Os Seguintes novos temas foram apagados.";
$txt[400] = "Instalar";
$txt[401] = "Erro: Por favor CHMOD 777 a pasta de mods.";
$txt[402] = "O tema seleccionado foi instalado.";
$txt[403] = "Nova versão";
$txt[404] = "Autor";
$txt[405] = "Descrição";
$txt[406] = "Download novos Temas";
$txt[407] = "Voce é agora um operador de sala, para acessar o painel de controle da sala escreva o comando /roomcp";
$txt[408] = "Grupo Geral";
$txt[409] = "Novo Membro";
$txt[410] = "Convidado";
$txt[411] = "Admin";
$txt[412] = "As configurações do seu grupo foram actualizadas.";
$txt[413] = "Membros";
$txt[414] = "Novo Grupo";
$txt[415] = "O grupo foi mudado com sucesso.";
$txt[416] = "Mudando o Grupo";
$txt[417] = "Com Selecção, Grupo Mudado para";
$txt[418] = "Os seguintes Users pertencem a este grupo";
$txt[419] = "Checar/deschecar todos";
$txt[420] = "Por Favor retire todos os Users do grupo antes de o apagar.";
$txt[421] = "O grupo foi apagado.";
$txt[422] = "Pode Criar sala de conversa";
$txt[423] = "Pode criar sala de conversa privada";
$txt[424] = "Aqui pode modificar o que este grupo pode fazer.";
$txt[425] = "Pode definir que a sala nunca expira";
$txt[426] = "Pode definir a sala para moderada";
$txt[427] = "Pode ver IP's";
$txt[428] = "pode chutar Users";
$txt[429] = "Não pode ser Banido ou chutado";
$txt[430] = "Tem estatuto de operador em todas as salas";
$txt[431] = "Tem Voice em todas as salas";
$txt[432] = "Pode Ver Endereços de E-mail invisiveis";
$txt[433] = "Pode definir ou apagar palavras chave";
$txt[434] = "Pode controlar o registo de conversas da sala";
$txt[435] = "Pode registar a conversa em salas privadas";
$txt[436] = "Pode definir o fundo da sala";
$txt[437] = "Pode Definir os logos da sala";
$txt[438] = "Pode ter estatuto de Admin";
$txt[439] = "Pode mandar mensagens via servidor";
$txt[440] = "Pode usar o comando /mdeop ";
$txt[441] = "Pode usar o /mkick ";
$txt[442] = "Tem Acesso ao painel de Admin : Settings";
$txt[443] = "Tem Acesso ao painel de Admin : Themes";
$txt[444] = "Tem Acesso ao painel de Admin : Word Filter";
$txt[445] = "Tem Acesso ao painel de Admin : User Groups";
$txt[446] = "Tem Acesso ao painel de Admin : Manage Users";
$txt[447] = "Tem Acesso ao painel de Admin : Ban List";
$txt[448] = "Tem Acesso ao painel de Admin : Bandwidth";
$txt[449] = "Tem Acesso ao painel de Admin : Log Manager";
$txt[450] = "Tem Acesso ao painel de Admin : Mass Mail";
$txt[451] = "Tem Acesso ao painel de Admin : Mods";
$txt[452] = "Tem Acesso ao painel de Admin : Smilies";
$txt[453] = "Tem Acesso ao painel de Admin : Rooms";
$txt[454] = "Can access chat room when disabled";
$txt[455] = "User must have operator status to use this feature";
$txt[456] = "User must have operator status and this feature must be enabled in the setting section of the admin panel.";
$txt[457] = "Tem Acesso ao painel de Admin : Calendar";
$txt[458] = "The permissions for this usergroup have been updated.";
$txt[459] = "Editar";
$txt[460] = "Editar rápido";
$txt[461] = "Tem a certeza que deseja eliminar esta Conta de User?";
$txt[462] = "A Conta de user foi eliminada.";
$txt[463] = "Conta de user não encontrada.";
$txt[464] = "A Conta de user foi actualizada.";
$txt[465] = "Tem a certeza que deseja apagar esta Sala?";
$txt[466] = "A Sala seleccioada foi apagada.";
$txt[467] = "Esta Sala foi apagada.";
$txt[468] = "Registar a largura de banda usada.";
$txt[469] = "O registo de largura de banda usada esta desligado.  <a>Click Aqui</a> para activar.";	// Leave <a> and </a> alone
$txt[470] = "O registo de largura de banda usada esta ligado.  <a>Click Aqui</a> para descativar.";	// Leave <a> and </a> alone
$txt[471] = "Largura de banda default (em MegaBytes)";
$txt[472] = "Limitar Users a <i>x</i> MBs por _t";	//  _t will be a drop down menu with Month or Day in it
$txt[473] = "Mês";	// Yes you have seen this before, this time its not plural
$txt[474] = "Dia";	// Yes you have seen this before, this time its not plural
$txt[475] = "Usados";
$txt[476] = "Maximo (MB)";
$txt[477] = "Os valores para a contagem de largura de banda, só contam em páginas de salas, e não contem a cabeça de trasnmissão (transmission header).Largura de banda para outro tipo de paginas não é contabilizado.";
$txt[478] = "Pode ser definido 0(zero) par ailimitado ou -1 para tipico(default)";
$txt[479] = "Largura de banda total";
$txt[480] = "Voce excedeu o máximo de largura de banda aribuida para hoje. Por favor volte amanhã.";
$txt[481] = "Voce excedeu o limite de banda permitida para este mês, Por favor volte no próximo mês.";
$txt[482] = "Registado";
$txt[483] = "Gerir/Ver";
$txt[484] = "O registo está desactivado, <a>Click Aqui</a> para activar.";	// Leave <a> and </a> alone
$txt[485] = "O registo está activado, <a>Click Aqui</a> Para descativar.";	// Leave <a> and </a> alone
$txt[486] = "Editar as preferencias para logs";
$txt[487] = "Editar Evento";
$txt[488] = "Evento";
$txt[489] = "Adicionar evento";
$txt[490] = "Hora (HH:MM)";
$txt[491] = "por favor utilize o formato de 24 horas";
$txt[492] = "Data (MM/DD/AAAA)";
$txt[493] = "Voce pode escrever uma mensagem de email aqui, e enviar para todos os membros registados.";
$txt[494] = "O E-Mail foi enviado a todos os Uilizadores registados.";
$txt[495] = "Adicionar Smiley";
$txt[496] = "Código";
$txt[497] = "Endereço URL da imagem";
$txt[498] = "Foram instalados os seguintes Smileys.";
$txt[499] = "Os Smileys seguintes estão na pasta Smileys e nao estão a ser usados neste momento.";
$txt[500] = "Pode adicionar os smileys que quiser de uma só vez, fazendo o upload de todas as imagens que quer usar para a pasta de smileys.";
$txt[501] = "Smiley";
$txt[502] = "Please visit <a href=\"http://x7chat.com/support.php\" target=\"_blank\">our support page</a> to view the X7 Chat Admin documentation, and get technical support.<Br><br>User end documentation is included with X7 Chat and is available <a href=\"./help/\" target=\"_blank\">Aqui</a>.";		// This one doesn't necessarily need to be translated
$txt[503] = "<a>[Click Aqui]</a> para acessar a documentação";	// Leave <a> and </a> alone
$txt[504] = "<a>[Click Aqui]</a> para abrir o painel de controlo noma nova janela.";		// Leave the <a> and </a> tags alone
$txt[505] = "Tornar-se invisivel.";
$txt[506] = "Ver Users invisiveis.";
$txt[507] = "Voce não tem permissão para se tornar invisivel.";
$txt[508] = "Voce está invisivel nesta sala.";
$txt[509] = "Voce deixou de estar invisivel nesta sala.";
$txt[510] = "Entrar em todos as salas em modo invisivel";
$txt[511] = "Voce recebeu uma mensagem privada. Se não abrir numa janela automáticamente por favor, <a>[Click Aqui]</a> para  a ver";		// Leave <a> and </a> alone
$txt[512] = "_u Foi banido da sala porque _r.";	// _u is replaced with the User, _r is the reason
$txt[513] = "_u Foi-lhe retirado o estatuto de banido nesta sala.";
$txt[514] = "Mail por ler";
$txt[515] = "Max de caracteres em User";
$txt[516] = "Entrar na sala de conversa significa que voce concorda com as regras de conduta <a>Regras de conduta para Users</a>.";	// Leave <a> and </a> alone
$txt[517] = "Regras de conduta para Users";
$txt[518] = "Se quiser desactivar as regras de conduta pode deixar isto em branco. Pode usar HTML.";
$txt[519] = "Procurando Endereço IP.";
$txt[520] = "Procurando";
$txt[521] = "Pode apagar linhas extra correndo o <a>Limpeza</a>";	// Leave <a> and </a> alone
$txt[522] = "Deve colocar CHMOD 777 esta pasta antes do registo de qualquer funcione ( permissoes totais de escrita).";
$txt[523] = "Tornar-se Invisivel";
$txt[524] = "Tornar-se Visivel";
$txt[525] = "Para criar ou editar um Tema deve usar o comando CHMOD 777 na pasta 'themes'.  <Br><Br><b>SE ESTIVER EDITANDO UM TEMA</b><Br> Se esiver a editar um tema por favor use o comando CHMOD 777 na pasta do tema que está a editar e todos os ficheiros nesta pasta. Se nao o fizer as alteraçoes podem nao ser enviadas ao servidor (upload).  For help please visit the X7 Chat website.";
$txt[526] = "Criar um Tema Novo";
$txt[527] = "Cor de fundo da Janela";
$txt[528] = "Cor de Fundo do Corpo Principal";
$txt[529] = "Cor Secundária do Fundo do corpo principal";
$txt[530] = "Cor da Fonte";
$txt[531] = "Cor da fonte dos botoes do menú";
$txt[532] = "Cor da fonte do cabeçalho.";
$txt[533] = "Familia da Fonte";
$txt[534] = "Tamanho Minimo da Fonte";
$txt[535] = "Tamanho Regular da Fonte";
$txt[536] = "Tamanho Grande da Fonte";
$txt[537] = "O Maior Tamanho de Fonte";
$txt[538] = "Cor da Borda";
$txt[539] = "Cor Alternativa da BordaAlternate Border Color";
$txt[540] = "Cor para os LINKS";
$txt[541] = "Cor para sobreposiçao nos Links";
$txt[542] = "Cor para o Link Activo";
$txt[543] = "Cor de Fundo para o Texto";
$txt[544] = "Cor da Borda da Caixa de Texto";
$txt[545] = "Tamanho do Texto da Caixa de Texto";
$txt[546] = "Cor do Texto da Caixa de Texto";
$txt[547] = "Cor do nome da outra pessoa";
$txt[548] = "Cor do SEU nome";
$txt[549] = "Cor de Fundo da Janela da sala";
$txt[550] = "Cor da Borda da Janela da Mensagem Privada";
$txt[551] = "URL da home page";
$txt[552] = "Nome do Tema";
$txt[553] = "Fundo do Cabeçalho da Tabela";
$txt[554] = "Autor do Tema";
$txt[555] = "Descrição do Tema";
$txt[556] = "Versão do Tema";
$txt[557] = "Não foi possivel localizar a pasta dos templates do Tema.";
$txt[558] = "O Tema foi Actualizado.";
$txt[559] = "Tem que introduzir um nome par ao seu Tema.";
$txt[560] = "Conversando em....";
$txt[561] = "Lista de Membros";
$txt[562] = "Fundo do cabeçalho";
$txt[563] = "Cor da Fonte do Calendário";
$txt[564] = "<b>Sintaxe:</b> /mkick <i>Motivo</i> <Br>Este Comando Atira toda a gente para fora da sala.";
$txt[565] = "Por Favor apliquei o comando CHMOD 777 na pasta das mods.  Para auxilio com o comando CHMOD por favor visite o nosso website.";
$txt[566] = "Puxando Mods";
$txt[567] = "Mods Instaladas";
$txt[568] = "Desistalar";
$txt[569] = "Novas Mods";
$txt[570] = "Nome da Mod";
$txt[571] = "por Favor CHMOD 777 os seguintes ficheiros e pastas:";
$txt[572] = "Iniciando a instalação";
$txt[573] = "Backup ficheiros & iniciar..";
$txt[574] = "Processo de instalação completo, deve reverter todos os comandos CHMOD usados(muito importante).";
$txt[575] = "Iniciar desinstalação";
$txt[576] = "Processo de Desinstalação completo, deve reverter todos os comandos CHMOD usados.(muito importante";
$txt[577] = "Tem Acesso ao painel de Admin : Keywords";
$txt[578] = "Informação sobre o Tema";
$txt[579] = "Fontes do Tema";
$txt[580] = "Fundos do Tema";
$txt[581] = "Borders do Tema";
$txt[582] = "Links do Tema";
$txt[583] = "Caixas de Inserçao de Texto do Tema.";
$txt[584] = "Cores Misc do Tema";
$txt[585] = "Cor de Fundo nº4";
$txt[586] = "Estilo da Borda";
$txt[587] = "Tamanho da Borda";
$txt[588] = "Estilo da Borda das Caixas de Texto";
$txt[589] = "Tamanho da Borda das Caixas de Texto";
$txt[590] = "Tipo de servidor de salas";
$txt[591] = "Modo Multisala";
$txt[592] = "Sala única";
$txt[593] = "Quando se usa o comando sala única os Users são forçados a entrar na sala seleccionada pelo Admin e não podem mudar ou criar uma sala.";
$txt[594] = "Esta Sala esta a ser usada pelo modo Sala única e não pode ser apagada. Para apagar, precisa desligar este modono painel de configurações gerais.";
$txt[595] = "* Sessão de Suporte Para Um Novo Cliente *";
$txt[596] = "Por Favor espere um pouco, alguém virá em breve.";
$txt[597] = "Ocorreu um erro Grave.  Por favor contacte o Admin dos servidores.  Copie a mensagem de erro e envie-o a ele por email.";
$txt[598] = "Carregando ...";
$txt[599] = "Centro de Suporte";
$txt[600] = "A conta do novo user foi criada.";
$txt[601] = "Criar uma nova conta de User";
$txt[602] = "Salas com acesso reservado ao conhecedor de senha.";
$txt[603] = "Deve deixar esta janela aberta, os pedidos do suporte aparecem automaticamente numa nova janela.  Se estiver com o bloqueador de popups DESLIGUE-O agora.";
$txt[604] = "Este painel permite ajustar as definições para usar o X7 como sala de suporte.  É altamente recomendável que leia a documentação para que entenda as seguintes opções.";
$txt[605] = "Contas de Suporte";
$txt[606] = "Mensagem para apresentar quando o suporte estiver inacessivel.";
$txt[607] = "Imagem de suporte disponivel";
$txt[608] = "Imagem de suporte indisponivel";
$txt[609] = "Listar os UsersList Users seperated by semi-colins (;), these users will have access to the support center";
$txt[610] = "The account you are attempting to send this message to does not exist.";
$txt[611] = "Custom RGB Value";
$txt[612] = "Não pode apagar o Tema principal.";

/** Special strings **/

// Days of the week and months, these are simply easier and more efficient to do this way
$txt['Sunday'] = "Domingo";
$txt['Monday'] = "Segunda";
$txt['Tuesday'] = "Terça";
$txt['Wednesday'] = "Quarta";
$txt['Thursday'] = "Quinta";
$txt['Friday'] = "Sexta";
$txt['Saturday'] = "Sábado";
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

