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

$txt[0] = "Ingresar";
$txt[1] = "Por favor ingresa tu usuario y password para poder accesar";
$txt[2] = "Usuario";
$txt[3] = "Contraseña";
$txt[4] = "&nbsp;&nbsp; Entrar &nbsp;&nbsp;";	// "&nbsp;" is the same as a blank space
$txt[5] = "Recuperar Contraseña";
$txt[6] = "Registrate";
$txt[7] = "Estadisticas";
$txt[8] = "Usuarios en línea";
$txt[9] = "Total de Salas";
$txt[10] = "Usuarios Registrados";
$txt[11] = "Usuarios Online";
$txt[12] = "Proximos eventos en el chat";
$txt[13] = "El usuario o contraseña que escibiste son incorrectos";
$txt[14] = "Error";

$txt[15] = "Lo sentimos, el administrador de este servidor ha deshabilitado el registro";
$txt[16] = "Salir";
$txt[17] = "Saliste del sistema.";
$txt[18] = "Registro";
$txt[19] = "Ingresa los datos solicitados, todos los campos son requeridos.";
$txt[20] = "E-Mail";
$txt[21] = "Confirmar contraseña";
$txt[22] = "Una ves ingresando al sistema tendras más opciones para modificar tu perfil dentro del sistema del chat.";
$txt[23] = "Usuario no valido, tu nombre de usuario puede contener numeros y letras pero no espacios, comas, tabs, apostrofes, comillas simples o dobles.  Tu usuario debe tener menos de  _n caracteres de largo.";		// _n is the number of charcters your username must be under
$txt[24] = "Por favor proporciona un e-mail valido.";
$txt[25] = "Por favor proporciona una contraseña.";
$txt[26] = "Las contraseñas no son iguales.";
$txt[27] = "UPSSS!!!, el usuario que eligiste ya esta en uso, regresa y proporciona uno diferente.";
$txt[28] = "Tu cuenta ha sido activada, <a href=\"./index.php\">Click Aquí</a> para ingresar.";

$txt[29] = "Lista de salas";
$txt[30] = "Usuarios";
$txt[31] = "Nombre";
$txt[32] = "Titulo";

$txt[34] = "Ayuda";
$txt[35] = "Detalles Usuario";
$txt[36] = "Estilos Instalados";
$txt[37] = "Admin CP";

$txt[38] = "Sorry, unknown frame!";
$txt[39] = "Lo sentimos, el administrador deshabilito la sala de charla!";

$txt[40] = "Estado";
$txt[41] = "Room CP";

$txt[42] = "No puedes enviar mensajes en esta sala hasta que el operador te de la palabra.";
$txt[43] = "Estas dentro de la Sala";
$txt[44] = "Has salido de la Sala";

$txt[45] = "No se puede accesar la pagina, no existe la pagina.";
$txt[55] = "Default";
$txt[56] = "Mas";
$txt[57] = "Selecciona una fuente:";

$txt[58] = "Que tamaño de fuente deseas?";
$txt[59] = "Crear Sala";
$txt[60] = "No dispones de permisos para crear una nueva sala.";
$txt[61] = "Nombre de la sala";
$txt[62] = "Completa esta forma para crear una nueva sala de chat";
$txt[63] = "Crear";
$txt[64] = "Tipo de Sala";
$txt[65] = "Titulo";
$txt[66] = "Saludos";
$txt[67] = "Max Usuarios";
$txt[68] = "Publica";
$txt[69] = "Privada";
$txt[70] = "Moderada";
$txt[71] = "Nunca expira";
$txt[72] = "Nombre invalido , la sala puede contener letras y numeros pero no comas, apostrofes, asteriscos o comillas.";
$txt[73] = "Sala de tipo desconocido";
$txt[74] = "No puedes crear salas privadas";
$txt[75] = "Tu Sala ha sido creada";
$txt[76] = "El nombre de la sala esta en uso, crea una con un nombre diferente";
$txt[77] = "Volver";
$txt[78] = "Contraseña Requerida";
$txt[79] = "Esta sala esta protegida con contraseña.  Escribela si dispones de ella.";
$txt[80] = "Esta sala esta llena, por favor selecciona una diferente";
$txt[81] = "Salas llenas no han sido mostradas";
$txt[82] = "Mostrar salas llenas";
$txt[83] = "Salas llenas se han mostrado";
$txt[84] = "Ocultar salas llenas";
$txt[85] = "Perfil";
$txt[86] = "Accion";
$txt[87] = "Perfil Completo";
$txt[88] = "Charla privada";
$txt[89] = "Enviar e-mail";
$txt[90] = "Actualizando....";

$txt[91] = "Ignorar";
$txt[92] = "Permitir";
$txt[93] = "Silenciar";
$txt[94] = "Dar Ops";
$txt[95] = "Tomar Ops";
$txt[96] = "Hablar";
$txt[97] = "Eliminar";
$txt[98] = "Ver IP";
$txt[99] = "Dar Voz";
$txt[100] = "Tomar Voz";

$txt[101] = "El Usuario esta ignorado.";
$txt[102] = "El Usuario no esta ignorado.";
$txt[103] = "Seleccione un usuario";
$txt[104] = "No tienes permisos para completar esta accion";
$txt[105] = "Se te ha asignado como Operador al usuario";
$txt[106] = "El estatus de operador se ha descativado";
$txt[107] = "La IP de este usuario es: ";
$txt[108] = "Por favor escribe la razon para eliminar ha este usuario:";
$txt[109] = "El usuario ha sido eliminado de esta sala, podra accesar dentro de  60 segundos.";
$txt[110] = "_u ha sido kicked por _r";	// _u will be replaced with username and _r will be replaced with reason

$txt[111] = "Este usuario ha sido silenciado.";
$txt[112] = "Este usuario se le ha dado voz.";
$txt[113] = "Este usuario se le dio voz.";
$txt[114] = "Este usuario con voz esta en espera.";

$txt[115] = "Usted ha sido elimando de esta sala por _r";	// _r will be replaced with the reason for the kick
$txt[116] = "Usted ha sido baneado de esta sala por _r";	// _r will be replaced with the reason for the ban
$txt[117] = "Usted ha sido baneado de este servidor por _r";	// _r will be replaced with the reason for the ban
$txt[118] = "Usted ha sido removido de esta sala, por favor de <a href='./index.php'>click aqui</a> para regresar a la lista de salas y seleccionar una diferente.";

$txt[119] = "Ver Perfil";
$txt[120] = "(oculto)";
$txt[121] = "Lugar";
$txt[122] = "Pasatiempos";
$txt[123] = "Grupo_de_Usuario";
$txt[124] = "Bio";
$txt[125] = "Imagen";

$txt[126] = "_u es un operador de esta sala de CHAT";		// _u will print the username of the person who the action is preformed one.
$txt[127] = "_u is no longer a Chat Room Operator";		// _u will print the username of the person who the action is preformed one.
$txt[128] = "Seleccione un color";
$txt[129] = "_u le han dado voz";		// _u will print the username of the person who the action is preformed one.
$txt[130] = "_us ha tomado voz";		// _u will print the username of the person who the action is preformed one.
$txt[131] = "_u le silenciaron";		// _u will print the username of the person who the action is preformed one.
$txt[132] = "_u le han quitado la voz";		// _u will print the username of the person who the action is preformed one.
$txt[133] = "Cerrar";
$txt[134] = "El color de tu mensaje se actualizo.";
$txt[135] = "Control Panel de Usuario";
$txt[136] = "Bienvenido a tu Panel de Control.  Aqui puedes cambiar tus preferencias, enviar mensajes y configurar caracteristicas de este CHAT.";

$txt[137] = "Inicio";
$txt[138] = "Perfil";
$txt[139] = "Ajustes";
$txt[140] = "Status";
$txt[141] = "Block list";
$txt[142] = "Msgs Offline";
$txt[143] = "Filtro de palabras";
$txt[144] = "Palabras calve";
$txt[145] = "Las siguientes palabras estan filtradas, click en alguna para removerla.";

$txt[146] = "Tu estado actual";
$txt[147] = "Establecer estado";
$txt[148] = "Tu estado cambio a ";
$txt[149] = "Ausente";
$txt[150] = "Disponible";
$txt[151] = "Vuelvo enseguida";
$txt[152] = "Vuelvo mas tarde";
$txt[153] = "Personalizar";
$txt[154] = "Cambiar";
$txt[155] = "Letras Max";
$txt[156] = "Los siguientes usuarios han sido ignorados, click en uno para desbloquear.";
$txt[158] = "_u ha sido removido de tu lista de ignorados.";	// _u is replaced with the person usersname
$txt[159] = "Ignorar usuario";
$txt[160] = "Agregar";
$txt[161] = "_u ha sido agragado a tu lista de ignorados.";	// _u is replaced with the person usersname
$txt[162] = "_w se filtro.";		// _w is replaced with the word that was filtered
$txt[163] = "_w no se filtro.";		// _w is replaced with the word that was unfiltered
$txt[164] = "Filtrar Palabra";
$txt[165] = "Texto";
$txt[166] = "Replazar";
$txt[167] = "Los parametros de las palabras claves se actualizaron";
$txt[168] = "Las palabras claves son palabras especiales que seran automaticamente asignadas dentro de los links de este chat.<Br><Br>Las siguientes son Palabras claves, da click en alguna para quitarla.";		// <br> means it goes onto a new line, same as an enter or return key does
$txt[169] = "Agregar Palabra Clave";
$txt[170] = "URL";
$txt[171] = "Tu mensaje ha sido enviado.";
$txt[172] = "Debajo son todos los mensajes que has recibido.";
$txt[173] = "[None]";
$txt[174] = "------- Mensaje Original -------";
$txt[175] = "Borrar";
$txt[176] = "RE: ";
$txt[177] = "El mensaje ha sido borrado";
$txt[178] = "Asunto";
$txt[179] = "De";
$txt[180] = "Fecha";
$txt[181] = "Enviar";
$txt[182] = "Enviar a";
$txt[183] = "Asunto";
$txt[184] = "Tu mensaje no se pudo enviar debido a que el buzon del usuario esta lleno.";
$txt[185] = "Estas usando el _p de tu espacio en tu correo.  Tienes _n mensajes mas.";	// _p is the precentage of used space and _n is the number of messages you have room for
$txt[186] = "Sexo";
$txt[187] = "Actualizar";
$txt[188] = "Tu perfil se actualizo.";


$txt[189] = "Hombre";
$txt[190] = "Mujer";
$txt[191] = "Pareja";

$txt[192] = "Cargar";
$txt[193] = "Debes usar esta forma para cargar tu foto.  Solo puedes subir una imagen a la ves.
Tu foto debe ser en formato .gif, .png o .jpeg y debe ser menor de _b bytes de tamaño.  Tu foto debe ser de _d px.";		// _b is replaced with the byte limit and _d is replaced with the size limit that the admin has specified

$txt[194] = "Tu foto subio correctamente al servidor y tu perfil se actualizo.";
$txt[195] = "La opción de subir una foto fue deshabilitada.";
$txt[196] = "Tu foto es muy grande.";
$txt[197] = "El formato de tu foto no es valido.  Por favor usa formatos PNG, GIF o JPEG.";
$txt[198] = "La opcion de subir tu foto esta disponible , solo que el administrador no ha dado permisos de escribir en la carpeta seleccionada.  Por favor contactanos y reporta el problema.  Tu foto no fue enviada al servidor.";


$txt[199] = "Tiempo de Acceso (horas)";
$txt[200] = "Tiempo de actualizacion (segundos)";
$txt[201] = "Impresion de tiempo (horas)";
$txt[202] = "Impresion de tiempo (minutos)";
$txt[203] = "Diseño";
$txt[204] = "Lenguaje";
$txt[205] = "Desabilitar Estilos";
$txt[206] = "Desabilitar Sonrisas";
$txt[207] = "Desabilitar Sonidos";
$txt[208] = "Desabilitar Impresion de tiempo";
$txt[209] = "Ocultar E-Mail";
$txt[210] = "Tus preferencias se actualizaron";

$txt[211] = "Comando desconocido";
$txt[212] = "_u rolls _d _s-sided dice.";		// _u become username, _d is the number of dice and _s is the number of sides
$txt[213] = "Los resultados son:";
$txt[214] = "Los resultados fueron modificados por _a.";	// _a is a number they are modified by

$txt[215] = "Acceso Denegado";
$txt[216] = "No tienes permisos para accesar a esta seccion.";
$txt[217] = "Este panel te permite ajustar algunos parametros de la sala del CHAT.";
$txt[218] = "Parametros Generales";
$txt[219] = "Lista de Op";
$txt[220] = "Lista de Voz";
$txt[221] = "Lista de Mute";
$txt[222] = "Nuevo Ban";
$txt[223] = "Razon";
$txt[224] = "Usuario / IP / E-Mail";
$txt[225] = "Longitud";
$txt[226] = "Siempre";
$txt[227] = "O";
$txt[228] = "Minutos";
$txt[229] = "Horas";
$txt[230] = "Dias";
$txt[231] = "Semanas";
$txt[232] = "Meses";
$txt[233] = "Click en un usuario, IP o E-Mail para unban";
$txt[234] = "El nuevo ban si aplico.";
$txt[235] = "El ban se removio.";
$txt[236] = "Los siguientes usuarios tienen OP en esta sala.  Click en alguno para quitarle el OP.";
$txt[237] = "Los siguientes usuarios tienen Voz en esta sala.  Click en alguno para quitarle la voz.";
$txt[238] = "Los siguientes usuarios estan en estado muted.  Click en alguno para unmute.";
$txt[239] = "Unable to find user by that username.";
$txt[240] = "Logs";
$txt[241] = "Log Menssajes Privados";
$txt[242] = "Logging esta activo";
$txt[243] = "Logging esta inactivo";
$txt[244] = "Logging Habilitado";
$txt[245] = "Logging Deshabilitado";
$txt[246] = "Tamaño del archivo Log: _s kb (_p)";		// _s is the size,_p is the percentage
$txt[247] = "Espacio disponible: _s kb (_p)";		// _s is the remain free space, _p is the percentage
$txt[248] = "sin limite";
$txt[249] = "Abajo esta el contenido del log.";
$txt[250] = "Borrar Log";
$txt[251] = "Selecciona un log de abajo para verlo.";
$txt[252] = "Tu mensaje no fue enviado, es muy largo.";
$txt[253] = "Imagen de fondo";
$txt[254] = "Imagen de Logo";
$txt[255] = "Recordar Contraseña";
$txt[256] = "Hola _u,\n\nUn visitante con IP address _i ha solicitado que su  contraseña sea cambiada _s Chat.\n\nTu nueva contraseña es _p.\n\nGracias,\n_s El Administrador";			// Us "\n" for return/enter/new lines, _u for the username, _i for IP, _s forsitename, _p for new password
$txt[257] = "Teclea tu usuario o e-mail para enviarte una nueva contraseña.  La nueva contraseña te sera enviada por email a tu email que tienes registrado con nosotros..";
$txt[258] = "Tu nueva contraseña se te ha enviado.";
$txt[259] = "Tu nueva contraseña no se ha enviado.  No pudimos localizar una cuenta en nuestra base de datos con el usuario o email que nos proporcionaste.";
$txt[260] = "Tu nueva contraseña no se ha enviado.  Localizamos la cuenta correcta sin embargo ninguna Dirección de correo electrónico estaba en la base de datos.";
$txt[261] = "El Administrador desactivo la opcion de recuperar conraseñas.";
$txt[262] = "Noticias";
$txt[263] = "Lo sentimos , no hay ningun topic para este asunto.";
$txt[264] = "Las salas se desactivan automaticamente en : _t";		// _t is the time after which they expire
$txt[265] = "Nunca";
$txt[266] = "";
$txt[267] = "No tienes permisos para usar este comando.";
$txt[268] = "Imposible completar la accion en el usuario seleccionado.";
$txt[269] = "<b>Sintaxis:</b> /kick <i>usuario</i> <i>razon</i><Br>Este comenado sacara la usuario del chat.";
$txt[270] = "<b>Sintaxis:</b> /ban <i>usuario</i> <i>razon</i><Br>Este comando removera al usuario de la sala de chat y no permitira que vuelva a entrar.";
$txt[271] = "<b>Sintaxis:</b> /unban <i>usuario</i> <Br>Este comando permite que un usuario expulsado pueda volver a ingresar a la sala del Chat.";
$txt[272] = "<b>Sintaxis:</b> /op <i>usuario</i> <Br>Este comando dara funcion de OP al usuario.";
$txt[273] = "<b>Sintaxis:</b> /deop <i>usuario</i> <Br>Este comando quitara la función de OP al usuario.";
$txt[274] = "<b>Sintaxis:</b> /ignore <i>usuario</i> <Br>Este comando bloqueara todos los mensajes de este usuario para cualquiera.";
$txt[275] = "<b>Sintaxis:</b> /unignore <i>usuario</i> <Br>Este comando permite al usuario nuevamente enviar mensajes.";
$txt[276] = "La siguiente gente esta en el chat contigo: ";
$txt[277] = "<b>Sintaxis:</b> /me <i>accion</i> <Br>Este comando dara dira a los usuarios lo que quieres con tu <i>accion</i>.";
$txt[278] = "<b>Sintaxis:</b> /admin <i>usuario</i> <Br>Este comando dara privilegios de Administrador al usuario seleccionado.";
$txt[279] = "_u esta como administrador en la sala de chat";	// _u is the username
$txt[280] = "_u is no longer a chat room administrator";	// _u is the username
$txt[281] = "<b>HEY!!</b>, Estas tratando de ser Administrador por tu propia cuenta!  Si quieres continuar tratando de hacerlo, teclea /deadmin <i>your_username</i> 1";
$txt[282] = "<b>Sintaxis:</b> /voice <i>usuario</i> <Br>Este comando dara voz a un usuario y oermitora ser moderador de la sala.";
$txt[283] = "<b>Sintaxis:</b> /devoice <i>usuario</i> <Br>Este comando quitara la voz al usuario seleccionado.";
$txt[284] = "<b>Sintaxis:</b> /mute <i>usuario</i> <Br>Este comando no permite enviar mensajes a la sala al usuario seleccionado.";
$txt[285] = "<b>Sintaxis:</b> /unmute <i>usuario</i> <Br>Este comando le permite al usuario nuevamente enviar mensajes a la sala.";
$txt[286] = "<b>Sintaxis:</b> /wallchan <i>mensaje</i> <Br>Este comando envia un mensaje a todas las salas.";
$txt[287] = "<a>[Click Aqui]</a> para abrir el panel de control de la sala en una nueva ventana.";		// Leave the <a> and </a> tags alone
$txt[288] = "<b>Sintaxis:</b> /log <i>accion</i> <Br>Este comando te permite detener, ver tamaño, iniciar y limpiar el archivo de log.  <i>Action</i> can be:<Br><b>Detener</b>: Deneter logging<Br><b>Iniciar</b>: Iniciar logging<br><b>Limpiar</b>: Limpiar el log actual<Br><b>Tamaño</b>: Muestra el tamaño del archivo de LOG";
$txt[289] = "Se esta usando _s KB de _m KB espacio de log.";	// _s is what you have used and _m is how much you can use
$txt[290] = "Usaste de manera incorrecta el comando.  Por favor da <a>Click Aqui</a> para aprender como usarlo de manera correcta.";
$txt[291] = "";
$txt[292] = "interrumpir chat.";
$txt[293] = "_u ha tomado el estado de operador de todos los operadores.";		// _u is the username
$txt[294] = "El MOTD esta vacio.";	// (MOTD stands for Message Of The Day)
$txt[295] = "<b>Sintaxis:</b> /userip <i>usuario</i> <Br>Este comando te mostrara la IP de <i>username</i>.";
$txt[296] = "_u te esta invitando a que ingreses a la sala _r";	// _u is the inviting username and _r is the room
$txt[297] = "<b>Sintaxis:</b> /invite <i>usuario</i> <Br>Este comando invitara a otro usuario a entrar a la sala donde estas tu.";
$txt[298] = "<b>Sintaxis:</b> /join <i>room</i> <Br>Este comando te permitira ingresar a una nueva sala de CHAT.";
$txt[299] = "<a>[Click Aqui]</a> para ingresar a  _r";	// leave <a> and </a> alone, _r is the room
$txt[300] = "La sala no existe.";
$txt[301] = "<a>[Click Aqui]</a> para crearla.";	// leave <a> and </a> alone
$txt[302] = "<b>Sintaxis:</b> /msg <i>usuario</i> <Br>Este comando enviara un mensaje privado al usuario seleccionado.";
$txt[303] = "<a>[Click Aqui]</a> para enviar un mensaje a _u";	// _u is the reciever's username, leave <a> and </a> alone
$txt[304] = "<b>Sintaxis:</b> /wallchop <i>mensaje</i> <Br>Este comando enviara un mensaje a todos los operadores en las salas de chat.";
$txt[305] = "(Message to _r Operators From _u)";	// _r is the room, _u is the person sending it



$txt[306] = "Este es el panel de control de Administrador.  Desde aqui puedes configurar preferencias, instalar mods, actualizar estilos, y manejar mas aspectos del CHAT.";
$txt[307] = "Noticias para nosotros";
$txt[308] = "Estilos";
$txt[309] = "Grupo de usuarios";
$txt[310] = "Admin. de Usuarios";
$txt[311] = "Admin. de Salas";
$txt[312] = "Lista de Ban";
$txt[313] = "Ancho de Banda";
$txt[314] = "Admin. de Logs";
$txt[315] = "Calendario";
$txt[316] = "Mail Masivo";
$txt[317] = "Sonrisas";
$txt[318] = "Mods";
$txt[319] = "El XUpdater no esta disponible.  Este modulo es requerido si quieres usar esta caracteristica.  Puedes activarlo editando el config.php.";
$txt[320] = "No hay noticias disponibles.";
$txt[321] = "Por favor selecciona una seccion para actualizar tus preferencias.";
$txt[322] = "Tiempo y Dia";
$txt[323] = "Tiempos de Expiracions";
$txt[324] = "URL de banner";
$txt[325] = "Estilos y Mensajes";
$txt[326] = "Fotos";
$txt[327] = "Pagina de acceso";
$txt[328] = "Avanzado";
$txt[329] = "Desactivar Chat";
$txt[330] = "Permitir Registro";
$txt[331] = "Permitir Invitados";
$txt[332] = "Nombre del Sitio";
$txt[333] = "Admin E-Mail";
$txt[334] = "Pagina de Salida";
$txt[335] = "Max Caracteres en Estatus";
$txt[336] = "Max caracteres en Mensaje";
$txt[337] = "Max mensaje en offline";
$txt[338] = "Minimo tiempo de Refresh";
$txt[339] = "Maximo tiempo de Refresh";
$txt[340] = "Puedes seleccionar con 0 para que no tenga limite.";
$txt[341] = "Lenguaje por Default";
$txt[342] = "Estilo por Default";
$txt[343] = "Sus preferencias se actualizaron.  <a>Click Aqui</a> para regresar a panel de preferencias.";		// Leave <a> and </a>
$txt[344] = "El rango minimo no puede ser mas grande que el maximo, duh.";
$txt[345] = "Log Path";
$txt[346] = "Tamaño maximo de log para la sala (KB)";
$txt[347] = "Tamaño maximo de log para el usuario (KB)";
$txt[348] = "Formato de Tiempo";
$txt[349] = "Formato de Dia";
$txt[350] = "Fecha Completa/Tiempo Completo";
$txt[351] = "en segundos";
$txt[352] = "Tiempo maximo de Idle";
$txt[353] = "Mensajes Expiran Despues";
$txt[354] = "Salas Expiran Despues";
$txt[355] = "Cuantas de Invitados Expiran Despues";
$txt[356] = "en minutos";
$txt[357] = "Tiempo de Cookie";
$txt[358] = "Imagen de Fondo";
$txt[359] = "Permitir Personalizar Fondo de Sala";
$txt[360] = "Permitir Personalizar Logos de Sala";
$txt[361] = "Default Fuente";
$txt[362] = "Default Tamaño";
$txt[363] = "Default Color";
$txt[364] = "Minimo tamaño de fuente";
$txt[365] = "Maximo tamaño de fuente";
$txt[366] = "Disabilitar Sonrisas";
$txt[367] = "Disabilitar Estilo de Mensajes";
$txt[368] = "Disable Auto-Linking";
$txt[369] = "Color de mensajes del sistema";
$txt[370] = "Permitir Fuentes*";
$txt[371] = "Separados(as) por comas";
$txt[372] = "Habilitado Uploads de fotos";
$txt[373] = "Auto-Resize Fotos Pequeñas";
$txt[374] = "Max Uploaded tamaño de foto (en bytes)";
$txt[375] = "Max Tamaño de foto (ancho y alto)";
$txt[376] = "Agregar Path";
$txt[377] = "Agregar URL";
$txt[378] = "Mostrar eventos de Calendario";
$txt[379] = "Mostrar Estadisticas";



$txt[380] = "Recuperación de Contraseña Disponible";
$txt[381] = "Dias para mostrar diariamente en Calendario (1-3)";
$txt[382] = "Mostrar Calendario Mensual";
$txt[383] = "Mostrar Calendario Diario";
$txt[384] = "Desactivado el uso de GD Library";	// GD Info: http://www.boutell.com/gd/
$txt[385] = "Si no sabes que es esto, no lo desabilites.  Si tu sistema no lo soporta, este se desactivara automaticamente.";
$txt[386] = "Una sala con ese nombre no existe.";
$txt[387] = "Tu puedes <a>dar click aqui</a> para pedir ingresar a la sala.";		// Leave <a> and </a> alone
$txt[388] = "Ingresar a Sala Privada";
$txt[389] = "Ingresar";
$txt[390] = "Nombre de Estilo";
$txt[391] = "Estas seguro de borrar este Estilo?";
$txt[392] = "Si";
$txt[393] = "No";
$txt[394] = "El Tema seleccionado ha sido borrado.";
$txt[395] = "No se pudo remover el estilo seleccionado.  Por favor borra el folder _d (este se encuentra en el folder de themes) puedes hacerlo a traves de tu conexion por FTP.";		//_d will be replaced with the directory name
$txt[396] = "If you did a CHMOD 777 on the themes directory, it highly recommend that you CHMOD your themes directory to whatever it was at before.  (Usually 755)";
$txt[397] = "Por favor pon en modo CHMOD 777 el directorio de themes.";
$txt[398] = "CHMOD Completado";
$txt[399] = "El siguiente estilo ha sido detectado.";
$txt[400] = "Instalar";
$txt[401] = "Error: Por favor pon  CHMOD 777 el directorio mods.";
$txt[402] = "El estilo seleccionado ha sido instalado.";
$txt[403] = "Liberado";
$txt[404] = "Autor";
$txt[405] = "Descripcion";
$txt[406] = "Descargar nuevos Estilos";
$txt[407] = "Ahora eres un operador de sala, para accesar al panel de control de la sala teclea /roomcp";
$txt[408] = "Default Grupos";
$txt[409] = "Nuevo Miembro";
$txt[410] = "Invitado";
$txt[411] = "Administrador";
$txt[412] = "Las opciones de tu grupo han sido actualizadas.";
$txt[413] = "Miembros";
$txt[414] = "Nuevo Grupo";
$txt[415] = "El cambio del grupo ha sido actualizado correctamente.";
$txt[416] = "Cambiar Grupo";
$txt[417] = "Con lo seleccionado, Cambia el grupo a";
$txt[418] = "Los siguientes usuarios estan en este grupo";
$txt[419] = "Marcar/Desmarcar Todo";
$txt[420] = "Por favor borra todos los usuarios desde grupo de usuarios antes de borrarlo.";
$txt[421] = "El grupo de usuarios ha sido borrado.";
$txt[422] = "Puedes crear Salas";
$txt[423] = "Puedes crear Salas Privadas";
$txt[424] = "Aqui puedes cambiar las cosas que este grupo de usuarios puede hacer.";
$txt[425] = "Puedes marcar esta sala para que nunca expire";
$txt[426] = "Puedes marcar esta sala para que sea Moderada";
$txt[427] = "Puedes ver IP";
$txt[428] = "Puedes dar Kick a Usuarios";
$txt[429] = "No puedes Banear o dar Kick a usuarios";
$txt[430] = "Tienes estatus de operador en todas las salas del CHAT";
$txt[431] = "Tienes voz en todas las salas";
$txt[432] = "Puedes ver los E-Mail ocultos";
$txt[433] = "Puedes seleccionar/borrar Palabras";
$txt[434] = "Puedes controlar el logging de la sala";
$txt[435] = "Puedes hacer log de mensajes privados";
$txt[436] = "Puedes seleccionar fondos en la sala";
$txt[437] = "Puedes seleccionar logos en la sala";
$txt[438] = "Puede conceder acceso de Administrador";
$txt[439] = "Puedes enviar mensajes de servidor";
$txt[440] = "Puedes usar el comando /mdeop ";
$txt[441] = "Puedes usar el comando /mkick ";
$txt[442] = "Puedes accesar al Panel de Admin : Preferencias";
$txt[443] = "Puedes accesar al Panel de Admin : Estilos";
$txt[444] = "Puedes accesar al Panel de Admin : Filtro de palabras";
$txt[445] = "Puedes accesar al Panel de Admin : Grupo de Usuarios";
$txt[446] = "Puedes accesar al Panel de Admin : Admin. de Usuarios";
$txt[447] = "Puedes accesar al Panel de Admin : Lista de Ban";
$txt[448] = "Puedes accesar al Panel de Admin : Ancho de Banda";
$txt[449] = "Puedes accesar al Panel de Admin : Admin. de Log";
$txt[450] = "Puedes accesar al Panel de Admin : Mail Masivo";
$txt[451] = "Puedes accesar al Panel de Admin : Mods";
$txt[452] = "Puedes accesar al Panel de Admin : Sonrisas";
$txt[453] = "Puedes accesar al Panel de Admin : Salas";


$txt[454] = "Puedes tener acceso a la sala del chat cuando esta desactivado";
$txt[455] = "El usuario debe tener privilegios de OP para usar esta funcion";
$txt[456] = "El usuario debe tener privilegios de OP y esta funcion debe de estar disponible en la seccion del Panel de Control del Admin.";
$txt[457] = "Puedes accesar al panel de Admin : Calendario";
$txt[458] = "Los permisos para este grupo de usuarios se actualizo.";
$txt[459] = "Editar";
$txt[460] = "Edicion rapida";
$txt[461] = "Estas seguro de remover esta cuenta de usuario?";
$txt[462] = "El usuario solicitado fue removido.";
$txt[463] = "Cuenta de usuario no encontrada.";
$txt[464] = "La cuenta del usuario se actualizo.";
$txt[465] = "Estas seguro de querer borrar esta sala de chat?";
$txt[466] = "La sala de chat seleccionada se ha borrado.";
$txt[467] = "Esta sala se ha borrado.";
$txt[468] = "Log de Ancho de Banda usada";
$txt[469] = "Logging de Ancho de Banda esta desactivado.  <a>Click aqui</a> para activarlo.";	// Leave <a> and </a> alone
$txt[470] = "Logging de Ancho de Banda esta activado.  <a>Click aqui</a> para desactivarlo.";	// Leave <a> and </a> alone
$txt[471] = "Limite de Ancho de Banda por Default (en MegaBytes)";
$txt[472] = "Limit users to <i>x</i> MBs per _t";	//  _t will be a drop down menu with Month or Day in it
$txt[473] = "Mes";	// Yes you have seen this before, this time its not plural
$txt[474] = "Dia";	// Yes you have seen this before, this time its not plural
$txt[475] = "Usado";
$txt[476] = "Max (MB)";
$txt[477] = "Values for used bandwidth only count on 'in chat' pages and does not include the transmission header.  Bandwidth for other pages is not counted.";
$txt[478] = "Puedes seleccionar 0 para estar sin limite o -1 por default";
$txt[479] = "Ancho de Banda Total";
$txt[480] = "Excendiste el ancho de banda permitido por dia.  Por favor regresa mañana.";
$txt[481] = "Excediste el anchod e banda permitido por mes.  Por favor regresa el proximo mes.";
$txt[482] = "Logged";
$txt[483] = "Manejar/Ver";
$txt[484] = "Logging esta desactivado, <a>Click Aqui</a> para activarlo.";	// Leave <a> and </a> alone
$txt[485] = "Logging esta activado, <a>Click Aqui</a> para desactivarlo.";	// Leave <a> and </a> alone
$txt[486] = "Editar configuracion de log";
$txt[487] = "Editar Evento";
$txt[488] = "Evento";
$txt[489] = "Agregar Evento";
$txt[490] = "Tiempo (HH:MM)";
$txt[491] = "Por favor usa 24-horas en el formato del tiempo";
$txt[492] = "Dia (MM/DD/AAAA)";
$txt[493] = "Puedes escribir un e-mail aqui y enviarlo a todos los usuarios registrados.";
$txt[494] = "El E-Mail sera enviado a todos los usuarios registrados.";
$txt[495] = "Agregar Sonrisa";
$txt[496] = "Codigo";
$txt[497] = "URL de imagen";
$txt[498] = "Las siguientes sonrisas se han instalado.";
$txt[499] = "Los siguientes archivos de sonrisas fueron encontrados en el directorio de sonrisas y no estan configurados para ser usados.";
$txt[500] = "Tu puedes agregar muchas sonrisas, oslo tienes que subirlas al directorio de sonrisas.";
$txt[501] = "Sonrisas";
$txt[502] = "Please visit <a href=\"http://x7chat.com/support.php\" target=\"_blank\">our support page</a> to view the X7 Chat Administrator documentation, and get technical support.<Br><br>User end documentation is included with X7 Chat and is available <a href=\"./help/\" target=\"_blank\">here</a>.";		// This one doesn't necessarily need to be translated
$txt[503] = "<a>[Click Aqui]</a> para accesar a la documentacion";	// Leave <a> and </a> alone
$txt[504] = "<a>[Click Aqui]</a> para abrir el Panel de Control de Admin en una nueva ventana.";		// Leave the <a> and </a> tags alone
$txt[505] = "Ser Invisible";
$txt[506] = "Ver a usuarios Invisibles";
$txt[507] = "No tienes permisos para ser invisible";
$txt[508] = "Ahora eres invisible en esta sala";
$txt[509] = "No eres invisible en esta sala";
$txt[510] = "Entrar a todas las salas en modo invisible";
$txt[511] = "Acabas de recibir un mensaje privado.  Si no se abre una nueva ventana automaticamente, <a>[Click Aqui]</a>";		// Leave <a> and </a> alone
$txt[512] = "_u ha sido baneado de la sala por _r.";	// _u is replaced with the username, _r is the reason
$txt[513] = "_u le han quitado el baneo de la sala.";
$txt[514] = "Mail sin leer";
$txt[515] = "Max caracteres en Nombre de Usuario";
$txt[516] = "Al entrar al chat significa que estas de acuerdo en cumplir los <a>Acuerdos de Uso</a>.";	// Leave <a> and </a> alone
$txt[517] = "Acuerdo de usuario";
$txt[518] = "Si quieres desactivar los acuerdos de uso debes dejar este en blanco.  Puedes usar codigo HTML.";
$txt[519] = "Consultar Direccion IP";
$txt[520] = "Consulta";
$txt[521] = "Puedes borrar lineas extras dando click en <a>Clean Up</a>";	// Leave <a> and </a> alone
$txt[522] = "Debes poner  CHMOD 777 este directorio anres de que el logging pueda trabajar.";
$txt[523] = "Ser Invisible";
$txt[524] = "Ser Visible";
$txt[525] = "Para crear o editar un estilo debes poner en modo CHMOD 777 el directorio 'themes'.  <Br><Br><b>SI ESTAS EDITANDO UN ESTILO</b><Br> Si esta editando un estilo existente entonces pon en modo CHMOD 777 el directorio del estilo que estas editando y todos los archivos que estan dentro de el.  Si tu no realizas estos cambios puede que falle la actualizacion.";
$txt[526] = "Crear nuevo tema";
$txt[527] = "Color de fondo de la ventana";
$txt[528] = "Color principal del cuerpo del fondo";
$txt[529] = "Color secundario del cuerpo del fondo";
$txt[530] = "Color de fuente";
$txt[531] = "Color de fuente del menu de botones";
$txt[532] = "Color de fuente de la cabecera";
$txt[533] = "Familia de Fuentes";
$txt[534] = "Tamaño de fuente Pequeña";
$txt[535] = "Tamaño de fuente Regular";
$txt[536] = "Tamaño de fuente Grande";
$txt[537] = "Tamaño de fuente Extragrande";
$txt[538] = "Color de Borde";
$txt[539] = "Color Alternativo de Boder";
$txt[540] = "Color de Link";
$txt[541] = "Color de Link hover";
$txt[542] = "Color de Link Activo";




$txt[543] = "Color de fondo de la caja de texto";
$txt[544] = "Color de borde de caja de texto";
$txt[545] = "Tamaño de fuente de caja de texto";
$txt[546] = "Color de fuente de caja de texto";
$txt[547] = "Color del nombre de otra persona";
$txt[548] = "Color de tu nombre";
$txt[549] = "Color de fondo de la ventana de chat";
$txt[550] = "Color del borde de la ventana de mensajes privados";
$txt[551] = "Home Website URL";
$txt[552] = "Nombre de Estilo";
$txt[553] = "Table header background";
$txt[554] = "Autor de Estilo";
$txt[555] = "Descripcion de Estilo";
$txt[556] = "Version de Estilo";
$txt[557] = "Imposible localizar el directorio del template del estilo.";
$txt[558] = "Tu estilo se actualizo.";
$txt[559] = "Debes de ingresar un nombre a tu estilo.";
$txt[560] = "Chatenado en..";
$txt[561] = "Lista de Miembros";
$txt[562] = "Fondo de Cabecera";
$txt[563] = "Color de fuente para Calendario";
$txt[564] = "<b>Sintaxis:</b> /mkick <i>razon</i> <Br>Este comando dara kick a todos los que esten en el sala de chat.";
$txt[565] = "Por favor pon en modo CHMOD 777 el directorio mods .";
$txt[566] = "Descargar Mods";
$txt[567] = "Mods Instalados";
$txt[568] = "Desinstalar";
$txt[569] = "Nuevos Mods";
$txt[570] = "Nombre de Mod";
$txt[571] = "Por favor cambia los permisos a CHMOD 777 a los siguientes archivos y directorios:";
$txt[572] = "Iniciar Instalación";
$txt[573] = "Respaldo de Archivos & Inicio";
$txt[574] = "Proceso de instalacion finalizado, puedes regresar al modo CHMOD anterior.";
$txt[575] = "Iniciar Desinstalacion";
$txt[576] = "Proceso de desinstalacion completado, puedes regresar al modo CHMOD anterior..";
$txt[577] = "Puedes accesar al Panel de Admin : Keywords";
$txt[578] = "Informacion de Estilos";
$txt[579] = "Fuentes de estilo";
$txt[580] = "Fondos de estilo";
$txt[581] = "Bordes de Estilo";
$txt[582] = "Links de Estilo";
$txt[583] = "Estilo de los Input Boxes";
$txt[584] = "Colores Misc de estilo";
$txt[585] = "Color de fondo 4";
$txt[586] = "Estilo de Borde";
$txt[587] = "Tamaño de Borde";
$txt[588] = "Estilo de borde para caja de texto";
$txt[589] = "Tamaño de borde de caja de texto";
$txt[590] = "Tipo de Server Room";
$txt[591] = "Modo Multisala";
$txt[592] = "Sala Sencilla";
$txt[593] = "Cuando seleccionas el modo de Single Room los usuarios se ven forzados a entrar a la sala por default.";
$txt[594] = "Esta sala esta siendo usada en modo Single Room, no puedes borrarla.  Por favor desactiva el modo Single Room en la configuracion General de configuración.";
$txt[595] = "* New Client Support Session *";
$txt[596] = "Por favor espera, alguien estara contigo en unos momentos.";
$txt[597] = "Un error falta ha ocurrido.  Por favor contacta al administrador del CHAT.  Copia el error y por favor envianolo, gracias..";
$txt[598] = "Cargando ...";
$txt[599] = "Centro de Soporte";
$txt[600] = "La nueva cuenta de usuario se creo.";
$txt[601] = "Crear cuenta de Usuario";
$txt[602] = "Salas protegidas con Contraseña de Acceso W/O Password";
$txt[603] = "Debes dejar esta ventana abierta, la solicitud de soporte aparecera automaticamente en una nueva ventana.  Si tienes algun bloqueador de POPUP por favor desactivalo.";
$txt[604] = "Este panel te permite ajustar carateriticas para usar el X7 Chat , espesificamente como un soporte de las salas de chat.  Es altamente recomendado que leas la documentacion para entender las opciones de este apartado.";
$txt[605] = "Cuentas de Soporte";
$txt[606] = "Mensaje para ser mostrado cuando el soporte no este disponible";
$txt[607] = "Imagen valida o disponible";
$txt[608] = "Imagen no valida o disponible";
$txt[609] = "Listar nombre de usuarios seperados por punto y coma (;), esos usuarios tendran acceso al centro de soporte";
$txt[610] = "La cuenta a la cual estas tratando de enviar mensaje no existe.";
$txt[611] = "Valor personalizado RGB ";
$txt[612] = "No puedes borar el Theme por default.";

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
$txt['Monday'] = "Lunes";
$txt['Tuesday'] = "Martes";
$txt['Wednesday'] = "Miercoles";
$txt['Thursday'] = "Jueves";
$txt['Friday'] = "Viernes";
$txt['Saturday'] = "Sabado";
$txt['January'] = "Enero";
$txt['February'] = "Febrero";
$txt['March'] = "Marzo";
$txt['April'] = "Abril";
$txt['May'] = "Mayo";
$txt['June'] = "Junio";
$txt['July'] = "Julio";
$txt['August'] = "Augosto";
$txt['September'] = "Septiembre";
$txt['October'] = "Octubre";
$txt['November'] = "Noviembre";
$txt['December'] = "Diciembre";

?>
