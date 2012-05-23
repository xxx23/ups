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
//		Translated to Croatian by Milan.K (http://www.crolinks.net)
//	v1.1	Corrected bugged Croatian version of Milan.K By Dejan.K 31/August/2005
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

$txt[0] = "Prikljucak na Chat www.CroLinks.Net";
$txt[1] = "CroLinks CHAT: UPOZORENJE 
  
Crolinks.Net štiti anonimnost korisnika svojeg chat-a. U slucajevima incidenata na ili povezanih sa chatom, a koji predstavljaju teže kršenje pravila ponašanja na chatu i/ili kršenje hrvatskih zakona, CroLinks.Net ima pravo i može ustanoviti identitet pocinitelja, te poduzeti adekvatne mjere.  
CroLinks.Net ne provjerava niti direktno kontrolira sadržaj koji se distribuira putem chat-a, te za isti nije odgovoran. CroLinks.Net je ovlašten za arhiviranje sadržaja koji se distribuiraju i objavljuju putem chata. Za eventualne štete nastale korištenjem istog, CroLinks.net ne snosi odgovornost. 
. Molimo vas da unesete ime Korisnika i Lozinku za prikljucak na chat";
$txt[2] = "Pseudo";
$txt[3] = "Lozinka";
$txt[4] = "&nbsp;&nbsp; Potvrdi &nbsp;&nbsp;";	
$txt[5] = "Zaboravljena Lozinka";
$txt[6] = "Registriraj se";
$txt[7] = "Statistike";
$txt[8] = "Korisnika prikljuceni";
$txt[9] = "Total Salona";
$txt[10] = "Registrirani Korisnika";
$txt[11] = "Clanova prikljuceni";
$txt[12] = "Zadnji dogadaji";
$txt[13] = "Psodo ili lozinku sto ste ubacili je nevazeca!";
$txt[14] = "Greska";

$txt[15] = "Izvinite, Administrator je ponistio vase registriranje ili upis na chat.";
$txt[16] = "Napusti";
$txt[17] = "Iskljuceni ste.";
$txt[18] = "Registracija";
$txt[19] = "Molimo vas da ispunite sve prostore.";
$txt[20] = "E-Mail";
$txt[21] = "Ponovi Lozinku";
$txt[22] = "Plus de détails pourront être rajouté à votre profil après votre enregistrement.";
$txt[23] = "Ime Korisnika nevazece, votre pseudo doit contenir des caractères alphanumériques (a-Z et 1-xxx) , sans accents, sans espaces.  Votre pseudo doit contenir au moins _n caractères.";		// _n is the number of charcters your username must be under
$txt[24] = "Unestie vazeci E-mail.";
$txt[25] = "Unesite izabranu Lozinku.";
$txt[26] = "Greska Lozinke su razlicite .";
$txt[27] = "Izvinite, izabrani korisnik vec postoji, vratite se unazad izaberite drugo ime.";
$txt[28] = "Vase ime clana je stvoreno, <a href=\"./index.php\">Cliknite za ulaz</a> na chat.";

$txt[29] = "SALONI";
$txt[30] = "KORISNIKA";
$txt[31] = "IME FORUMA";
$txt[32] = "TEMA";

$txt[34] = "Pomoc";
$txt[35] = "Profil";
$txt[36] = "Instalirane Theme";
$txt[37] = "Admin";

$txt[38] = "Izvinite, tabla nepostojeca!";
$txt[39] = "Izvinite, administrator je zabranio taj salon";

$txt[40] = "Status";
$txt[41] = "Konfig.. salona";

$txt[42] = "Zabranjeno vam je poslati posiljku sve dok vam administrator ne dozvoli.";
$txt[43] = "Uso u salon";
$txt[44] = "Izasao iz salona";

$txt[45] = "Nemoguce prikazati ovu stranicu, nepostoji.";
$txt[55] = "Greska";
$txt[56] = "Vise";
$txt[57] = "Izaberite jednu fonte :";

$txt[58] = "Izaberite velicinu fonte ?";
$txt[59] = "Stvorite salon";
$txt[60] = "Nemate dozvolu za stvorit novi salona.";
$txt[61] = "Ime salona";
$txt[62] = "Za stvaraje novog salona potrebno je ispuniti sve ove prostore";
$txt[63] = "Stvorite salon";
$txt[64] = "Typa salona";
$txt[65] = "Tema";
$txt[66] = "Msg Dobrodoslica";
$txt[67] = "Nb Max Korisnika";
$txt[68] = "Javni Prikaz";
$txt[69] = "Privatni Prikaz";
$txt[70] = "Moderiraj";
$txt[71] = "Neograniceno vrjeme salona";
$txt[72] = "Ime Salona nevaco (uniquement des caractères alphanumériques et sans espaces).";
$txt[73] = "Typa salona nepostojeca";
$txt[74] = "Nije vam dozvoljeno stvarati privatne salone!";
$txt[75] = "Vas salon je stvoren";
$txt[76] = "Izabrani salon vec postoji, izaberite drugo ime";
$txt[77] = "Povratak u nazad";
$txt[78] = "Potrebna je lozinka";
$txt[79] = "Za ulaz u ovaj salon potrebna je lozinka. Unesi lozinku za ulaz.";
$txt[80] = "Ovaj salon je potpuno ispunjen, Izaberite drugi salon";
$txt[81] = "Saloni nisu prikazani kliknite na";
$txt[82] = "Prikazi Salone";
$txt[83] = "Saloni su vidljivi";
$txt[84] = "Sakriti salone";
$txt[85] = "Profil";
$txt[86] = "Akcija";
$txt[87] = "Viditi Profil";
$txt[88] = "<B>Privatni Chat<B>";
$txt[89] = "Posaljite jedan Email";
$txt[90] = "Azuriranje....";

$txt[91] = "Ignoriraj";
$txt[92] = "Iskljuci ignorriranje";
$txt[93] = "Iskljuci zvuk";
$txt[94] = "Promociraj";
$txt[95] = "Dati Ops";
$txt[96] = "Aktiviraj zvuk";
$txt[97] = "Kicker";
$txt[98] = "vidi @ IP";
$txt[99] = "Dozvoliti razgovor";
$txt[100] = "Zabraniti razgovor";

$txt[101] = "Utilisateur ignoré maintenant.";
$txt[102] = "Utilisateur non ignoré maintenant.";
$txt[103] = "Kliknite na korisnika i ...";
$txt[104] = "Nemate dosvolu za upotrebu te operacije";
$txt[105] = "Korisnik je promjenio status da postane operatorr";
$txt[106] = "Status operatora je skinut";
$txt[107] = "Adresa IP zatrazenog Korisnika je: ";
$txt[108] = "Zbog kojeg razloga izbacujete Korisnika:";
$txt[109] = "Cet utilisateur a été jeté de ce salon. Il ne pourra plus revenir avant 60 secondes.";
$txt[110] = "_u a été jeté pour la raison suivante : _r";	

$txt[111] = "Cet utilisateur a été rendu mué.";
$txt[112] = "Cet utilisateur n`est plus mué.";
$txt[113] = "Cet utilisateur a obtenu la parole.";
$txt[114] = "Cet utilisateur n`a plus la parole.";

$txt[115] = "Vous avez été jeté(e) de ce salon pour la raison suivante : _r";	// _r will be replaced with the reason for the kick
$txt[116] = "Vous avez été banni(e) de ce salon pour la raison suivante : _r";	// _r will be replaced with the reason for the ban
$txt[117] = "Vous avez été banni(e) du chat pour la raison suivante : _r";	// _r will be replaced with the reason for the ban
$txt[118] = "Vous avez été supprimé du salon. Veuillez <a href='./index.php'>cliquer ici</a> pour retourner à la page principale des salons.";

$txt[119] = "Prikaz Profila";
$txt[120] = "(sariti)";
$txt[121] = "Grad";
$txt[122] = "Vjera";
$txt[123] = "Grupa";
$txt[124] = "Blabla";
$txt[125] = "Avatar";

$txt[126] = "_u est maintenant Opérateur de salons";		// _u will print the username of the person who the action is preformed one.
$txt[127] = "_u n`est plus Opérateur de salons";		// _u will print the username of the person who the action is preformed one.
$txt[128] = "Izaberite jednu boju";		
$txt[129] = "_u a la parole";		// _u will print the username of the person who the action is preformed one.
$txt[130] = "_u n`a plus la parole";		// _u will print the username of the person who the action is preformed one.
$txt[131] = "_u  a été rendu mué.";		// _u will print the username of the person who the action is preformed one.
$txt[132] = "_u n`est plus mué.";		// _u will print the username of the person who the action is preformed one.
$txt[133] = "Zatvori";		
$txt[134] = "Boja vase poste je azurirana.";		
$txt[135] = "Kontrolna Ploca Korisnikar";
$txt[136] = "Dobro dosli na vasu plocu Kontrole. Vasu menu vam omogucava konfiguraciju profila, posiljka privatne poste i konfiguraciju vasih zahtjeva ...";

$txt[137] = "Menu";
$txt[138] = "Profil";
$txt[139] = "Konfiguracija";
$txt[140] = "Status";
$txt[141] = "Lista zabranjenih";
$txt[142] = "Posiljka va prikljucka";
$txt[143] = "Filtriranje rjeci";
$txt[144] = "Kljucne rijeci";
$txt[145] = "Les mots ci-dessous ont été filtrés, Cliquez sur celui à enlever.";

$txt[146] = "Vas sadasnji status";
$txt[147] = "Configuracija vaseg statusa klikni dva puta ili idite dolje  ";
$txt[148] = "Vas status ce biti promljenjen";
$txt[149] = "Prisutan";
$txt[150] = "Odsutan";
$txt[151] = "Pauza café";
$txt[152] = "Na telefonu";
$txt[153] = "Ubacite va status";
$txt[154] = "Promjeni";
$txt[155] = "Max karaktera";
$txt[156] = "Liste des utilisateurs que vous avez ignoré, cliquer sur un pseudo pour ne plus l`ignorer.";
$txt[158] = "_u a été supprimé de votre liste des gens ignoré.";	
$txt[159] = "Ignoriraj korisnika";
$txt[160] = "Dodaj";
$txt[161] = "_u na vasu listu korisnika ignorirani.";
$txt[162] = "_w je filtriran.";		
$txt[163] = "_w nije vise filtriran.";	
$txt[164] = "Filtriranje rjeci";
$txt[165] = "Text";
$txt[166] = "Zamjeni rjec";
$txt[167] = "Votre configuration de vos mots clés a été mise à jour";
$txt[168] = "Les mots-clés sont des mots spéciaux qui seront automatiquement transformés en liens lors de la discussion dans le salon.<Br><Br>Ci dessous la liste des mots clés. Cliquez sur celui que vous désirez supprimer.";		// <br> means it goes onto a new line, same as an enter or return key does
$txt[169] = "Ubacite kljucnu rjec";
$txt[170] = "URL";
$txt[171] = "Vasa posiljka je poslana.";
$txt[172] = "Voici ci-dessous vos messages reçus.";
$txt[173] = "[Aucun]";
$txt[174] = "------- Orginal Posta/Message Original -------";	
$txt[175] = "Izbrisi";
$txt[176] = "RE: ";
$txt[177] = "Posiljka je ponistena";
$txt[178] = "Tema";
$txt[179] = "Od";
$txt[180] = "Datum";
$txt[181] = "Posalji";
$txt[182] = "Posalji";
$txt[183] = "Tema";
$txt[184] = "Votre message n`a pas été envoyé car la boite aux lettres de l`utilisateur est pleine.";
$txt[185] = "Vous avez utilisé _p de votre espace messagerie.  Vous pouvez encore recevoir _n autres messages.";	// _p is the precentage of used space and _n is the number of messages you have room for
$txt[186] = "Sex";
$txt[187] = "Azuriraj";
$txt[188] = "Vas profil je azuriran.";

$txt[189] = "Musko";
$txt[190] = "Zensko";
$txt[191] = "------";

$txt[192] = "Prebaci na";
$txt[193] = "Vous ne pouvez transférer qu`un seul avatar directement sur notre serveur. celui-ci doit être un fichier image .gif, .png ou .jpeg et ne doit pas dépasser _b octets. Sa résolution doit être de_d pixels.";		// _b is replaced with the byte limit and _d is replaced with the size limit that the admin has specified

$txt[194] = "Votre avatar a été transféré avec succès sur notre serveur.";
$txt[195] = "Transfert d`avatars désactivé.";
$txt[196] = "La taille de votre avatar est trop importante.";
$txt[197] = "Le format de l`image de votre avatar n`est pas reconnu.  Uniquement des fichiers PNG, GIF ou JPEG.";
$txt[198] = "Le mode transfert d`avatars est disponible mais le répertoire qui contient les avatars est interdit. Veuillez prendre contact avec l`adminsitrateur du site pour le lui signaler.";

$txt[199] = "Vrjeme konekcije (Sati)";
$txt[200] = "Taux Refrech (secunde)";
$txt[201] = "Décalage (Sati)";
$txt[202] = "Décalage (minute)";
$txt[203] = "Theme";
$txt[204] = "Jezik";
$txt[205] = "Dezaktiviranje Stylova";
$txt[206] = "Désactiver Smilies";
$txt[207] = "Désactiver Sons";
$txt[208] = "Désactiver Timestamps";
$txt[209] = "Sakrijte E-Mail-e";
$txt[210] = "Vasa Konfiguracija je ajurirana";

$txt[211] = "Zahtjev nepoznat?";
$txt[212] = "_u rolls _d _s-sided dice.";	
$txt[213] = "Rezultat je:";
$txt[214] = "Le résultat a été modifié par _a.";

$txt[215] = "Zabranjen Pristup";
$txt[216] = "Vous n`avez pas la permission pour accèder a cette section.";
$txt[217] = "Ce panneau vous permet d`ajuster plusieurs changements au salon.";
$txt[218] = "Generalna Konfiguracija datuma";
$txt[219] = "Lista Operatora";
$txt[220] = "Lista glasova";
$txt[221] = "Lista gluhi";
$txt[222] = "Novi Korisnik Izbacen";
$txt[223] = "Razlog";
$txt[224] = "Korisnik / IP / E-Mail";
$txt[225] = "Vrjeme";
$txt[226] = "ZA uvjek";
$txt[227] = "gdje";
$txt[228] = "Minute";
$txt[229] = "Sati";
$txt[230] = "Dana";
$txt[231] = "Nedjelja";
$txt[232] = "Mjesec";
$txt[233] = "Cliquez sur l`adresse IP, l`utilisateur ou Email pour qu`il ne soit plus banni";
$txt[234] = "Le nouveau BAN viens d`être executé";
$txt[235] = "Le BAN a été enlevé.";
$txt[236] = "Les utilisateurs suivants ont le statut d`opérateur dans se salon.  Cliquez sur celui que vous désirez révoquer.";
$txt[237] = "Les utilisateurs suivants ont les voix dans se salon.  Cliquez sur celui que vous désirez révoquer.";
$txt[238] = "Les utilisateurs suivants sont mués dans se salon.  Cliquez sur celui que vous désirez révoquer.";
$txt[239] = "Impossible de trouver un utilisateur portant ce pseudo.";
$txt[240] = "Logs";
$txt[241] = "Log des messagers privés";
$txt[242] = "Logs en fonction";
$txt[243] = "Logs désactivés";
$txt[244] = "Aktivacija svi Logo";
$txt[245] = "Désactiver les Logs";
$txt[246] = "Taille des logs: _s Ko (_p)";	
$txt[247] = "Espace libre restants des logs: _s Ko (_p)";	
$txt[248] = "Neograniceno";
$txt[249] = "Ci-dessous le contenu des logs.";
$txt[250] = "Effacer les logs";
$txt[251] = "Cliquez sur un log pour le visualiser.";
$txt[252] = "Votre message n`a pas été envoyé. Il est trop long.";
$txt[253] = "Image de fond";
$txt[254] = "Image de Logo";
$txt[255] = "Rappel du mot de passe";
$txt[256] = "Bonjour _u,\n\nUne personne avec l`adresse IP _i a demandé a ce que votre mot de passe soit changé par _s .\n\nVotre nouveau mot de passe est _p.\n\nMerci,\n_s (Administration)";			// Us "\n" for return/enter/new lines, _u for the username, _i for IP, _s for sitename, _p for new password
$txt[257] = "Unesite vas Ime Korisnika ili mail za posiljku nove lozinke. Lozinka je poslana na adresu e-mail (vase prve registracije).";
$txt[258] = "Vasa nova lozinka je poslana.";
$txt[259] = "Vasa nova lozinka nije poslana!. Adresa e-mail i Ime Korisnika se ne nalazi u nasoj bazi .";
$txt[260] = "Votre nouveau mot de passe n`a pas été envoyé!. L`adresse Email n`a pas été renseigné dans notre base de données .";
$txt[261] = "L`administrateur a désactivé le rappel du mot de passe.";
$txt[262] = "Nouvelles";
$txt[263] = "Désolé, il n`y a pas d`aide pour ce sujet.";
$txt[264] = "Vrijeme isteka privatnog salona : _t ";	
$txt[265] = "jamais";
$txt[266] = "";
$txt[267] = "Vous n`avez pas l`autorisation d`effectuer cette commande.";
$txt[268] = "Impossible d`accomplir l`action sur l`utilisateur indiqué.";
$txt[269] = "<b>Syntaxe:</b> /kick <i>pseudo</i> <i>raison</i><Br>Cette commande EJECTE un utilisateur du salon.";
$txt[270] = "<b>Syntaxe:</b> /ban <i>pseudo</i> <i>raison</i><Br>Cette commande EJECTE et BANNI un utilisateur du salon.";
$txt[271] = "<b>Syntaxe:</b> /unban <i>pseudo</i> <Br>Cette commande autorise l`utilisateur BANNI à revenir dans le salon.";
$txt[272] = "<b>Syntaxe:</b> /op <i>pseudo</i> <Br>Cette commande donne les droits opérateur à l`utilisateur.";
$txt[273] = "<b>Syntaxe:</b> /deop <i>pseudo</i> <Br>Cette commande enléve les droits opérateur à l`utilisateur.";
$txt[274] = "<b>Syntaxe:</b> /ignore <i>pseudo</i> <Br>Cette commande bloque tous les messages de l`utilisateur.";
$txt[275] = "<b>Syntaxe:</b> /unignore <i>pseudo</i> <Br>Cette commande autorise tous les messages de l`utilisateur.";
$txt[276] = "Les utilisateurs suivants sont dans le salon avec vous: ";
$txt[277] = "<b>Syntaxe:</b> /me <i>action</i> <Br>Cette commande indiquera à d`autres utilisateurs que vous faites <i>action</i>.";
$txt[278] = "<b>Syntaxe:</b> /admin <i>pseudo</i> <Br>Cette commande donnera les accès administrateur à l`utilisateur.";
$txt[279] = "_u est maintenat administrateur de ce salon";	
$txt[280] = "_u n`est plus administrateur de ce salon";	
$txt[281] = "<b>HEY!!</b>, Vous avez juste essayé de prendre le statut d`admin pour vous-même!  Si vous voulez continuer cette action, tapez /deadmin <i>votre_pseudo</i> 1";
$txt[282] = "<b>Syntaxe:</b> /voice <i>pseudo</i> <Br>Cette commande donnera à l`utilisateur une voix et lui permettra de parler dans les salons modérés.";
$txt[283] = "<b>Syntaxe:</b> /devoice <i>pseudo</i> <Br>Cette commande enlevera l`utilisateur sa voix et ne pourra plus parler dans les salons modérés.";
$txt[284] = "<b>Syntaxe:</b> /mute <i>pseudo</i> <Br>Cette commande interdit à l`utilisateur d`envoyer des messages dans le salon.";
$txt[285] = "<b>Syntaxe:</b> /unmute <i>pseudo</i> <Br>Cette commande autorise l`utilisateur à envoyer des messages dans le salon.";
$txt[286] = "<b>Syntaxe:</b> /wallchan <i>message</i> <Br>Cette commande envoi un message dans tous les salons.";
$txt[287] = "<a>[Cliquez ici]</a> pour ouvrir le panneau de configuration dans une nouvelle fenêtre.";		
$txt[288] = "<b>Syntaxe:</b> /log <i>action</i> <Br>Cette commande vous permet d`arrêter, de voir la taille, de lancer et d`effacer les logs.  <i>Les actions</i> peuvent être:<Br><b>Stop</b>: Stops logging<Br><b>Start</b>: Starts logging<br><b>Clear</b>: Clears the existing log<Br><b>Size</b>: Tells you how much of the log is used";
$txt[289] = "Vous avez utilisé _s Ko sur _m Ko d`espace de logs.";	
$txt[290] = "Cette commande est incorrecte. Veuillez <a>cliquer ici</a> pour connaître comment l`utiliser.";
$txt[291] = "";
$txt[292] = "Pertubation du Chat.";
$txt[293] = "_u> a pris le statut d`opérateur de tous les opérateurs.";		
$txt[294] = "Le MOTD est vide.";	
$txt[295] = "<b>Syntaxe:</b> /userip <i>pseudo</i> <Br>Cette commande affichera l`adresse IP de l`utilisateur <i>pseudo</i>.";
$txt[296] = "_u vous invite à rejoindre le salon _r";	
$txt[297] = "<b>Syntaxe:</b> /invite <i>pseudo</i> <Br>Cette commande invite un utilisateur à vous rejoindre dans votre salon.";
$txt[298] = "<b>Syntaxe:</b> /join <i>salon</i> <Br>Cette commande demande de rejoindre un nouveau salon.";
$txt[299] = "<a>[Cliquez ici]</a> pour aller dans le salon _r";	
$txt[300] = "Ce salon n`existe pas.";
$txt[301] = "<a>[Cliquez ici]</a> pour le créer.";	
$txt[302] = "<b>Syntaxe:</b> /msg <i>pseudo</i> <Br>Cette commande va envoyer un message privé a cet utilisteur.";
$txt[303] = "<a>[Cliquez ici]</a> pour envoyer un message à _u";	
$txt[304] = "<b>Syntaxe:</b> /wallchop <i>message</i> <Br>Cette commande enverra votre message aux opérateurs de ce salon uniquement.";
$txt[305] = "(Message de _u pour les opérateurs de _r)";	

$txt[306] = "Panneau de contrôle Administrateur. Ici vous pouvez configurer votre chat, installer des modules, mettre à jour les thèmes, et gérer l`ensemble des fonctions de votre chat.";
$txt[307] = "Les News";
$txt[308] = "Thèmes";
$txt[309] = "Groupe des Utilisateurs";
$txt[310] = "Gestion des Utilisateurs";
$txt[311] = "Gestion des salons";
$txt[312] = "Liste des Banni(e)s";
$txt[313] = "Bande passante";
$txt[314] = "Gestion des Logs";
$txt[315] = "Kalendar";
$txt[316] = "Messages aux membres";
$txt[317] = "Smilies";
$txt[318] = "Moduli";
$txt[319] = "XUpdater est désactivé. Ce module est necessaire pour la mise à jour. Vous pouvez le mettre en fonction en éditant votre fichier config.php.";
$txt[320] = "Il n`y a aucune NEWS pour le moment.";
$txt[321] = "Veuillez sélectionner une fonction à mettre a jour.";
$txt[322] = "Heure et Date";
$txt[323] = "Temps d`expiration";
$txt[324] = "URL de la Bannière";
$txt[325] = "Styles et Messages";
$txt[326] = "Avatars";
$txt[327] = "Page de Connexion";
$txt[328] = "Menu Avancé";
$txt[329] = "Désactiver le Chat";
$txt[330] = "Autoriser les inscriptions";
$txt[331] = "Autoriser les invités";
$txt[332] = "Nom du site";
$txt[333] = "E-mail Admin";
$txt[334] = "Page de sortie";
$txt[335] = "Nb Max Charactères dans le Status";
$txt[336] = "Nb Max Charactères dans les messages";
$txt[337] = "Nb Max Messages dans la noite aux lettre";
$txt[338] = "Temps Min pour rafraîchir la page";
$txt[339] = "Temps Max pour rafraîchir la page";
$txt[340] = "Mettre 0 pour aucune limite.";
$txt[341] = "Langue par défaut";
$txt[342] = "Thème par défaut";
$txt[343] = "Votre configuration a été mise à jour. <a>Cliquez ici</a> pour revenir au panneau de contrôle.";	
$txt[344] = "Le temps minimum de rafraîchissement de page ne peut pas être plus grand que le maximum ! ! !";
$txt[345] = "Répertoire des logs";
$txt[346] = "Taille Max LOG Salon (Ko)";
$txt[347] = "Taille Max LOG Utilisateur (Ko)";
$txt[348] = "Format Heure";
$txt[349] = "Format Date";
$txt[350] = "Format complet Date/Heure ";
$txt[351] = "en secondes";
$txt[352] = "Max temps idéal";
$txt[353] = "Messages Expirent après";
$txt[354] = "Salons Expirent après";
$txt[355] = "Comptes invités Expirent après";
$txt[356] = "en minutes";
$txt[357] = "Temps des Cookies";
$txt[358] = "Image de fond d`écran";
$txt[359] = "Autorise le changement du fond d`écran dans le salon";
$txt[360] = "Autorise le changement du logo dans le salon";
$txt[361] = "Fonte par défaut";
$txt[362] = "Taille par défaut";
$txt[363] = "Couleur par défaut";
$txt[364] = "Taille Minimum des fontes";
$txt[365] = "Taille Maximum des fontes";
$txt[366] = "Désactiver les Smilies";
$txt[367] = "Désactiver les styles dans les messages";
$txt[368] = "Désactiver les Liens automatiques";
$txt[369] = "Couleur du message système";
$txt[370] = "Fontes autorisées*";
$txt[371] = "Séparées par des virgules";
$txt[372] = "Valider le transfert d`avatars";
$txt[373] = "Redimensionner automatiquement les avatars";
$txt[374] = "Taille max de l`avatar (en octets)";
$txt[375] = "Hauteur/Largeur max de l`avatar";
$txt[376] = "Répertoire avatars";
$txt[377] = "Répertoire URL";
$txt[378] = "Afficher les évènements du calendrier";
$txt[379] = "Afficher les statistiques";
$txt[380] = "Valider le rappel du mot de passe";
$txt[381] = "Jours à voir dans le calendrier (1-3)";
$txt[382] = "Afficher le calendrier memsuel";
$txt[383] = "Afficher le calendrier journalier";
$txt[384] = "Désactiver la librairie GD";
$txt[385] = "Si vous ne savez pas ce que c`est, ne l`annulez  pas.  Si votre système ne le supporte pas, il sera désactivé automatiquement.";
$txt[386] = "Un salon avec ce nom n`existe pas.";
$txt[387] = "Mozete <a>kliknite ovdje</a> za uci u zatrazeni salon.";	
$txt[388] = "Udite u privatni salon";
$txt[389] = "Udi";
$txt[390] = "Ime theme";
$txt[391] = "Jeste li sigurni da zelite ponistiti tu temu?";
$txt[392] = "Da";
$txt[393] = "Ne";
$txt[394] = "Selekcijonirana Tema je izbrisana.";
$txt[395] = "Nous ne pouvons pas enlever le thème choisi.  Veuillez supprimer le répertoire _ d avec votre client FTP .";
$txt[396] = "Vous devez faire un CHMOD 777 sur le répertoire des thèmes, il est recommandé de forcer l`ancien CHMOD (habituellement 755)";
$txt[397] = "Veuillez faire un CHMOD 777 sur le répertoire des thémes.";
$txt[398] = "CHMOD je uspio";
$txt[399] = "Sljedece Teme su prinadene i detektirane.";
$txt[400] = "Instalacija";
$txt[401] = "Greska: Uraditejedan CHMOD 777 u repertuaru MODS.";
$txt[402] = "Izabrana Thema je instalirana.";
$txt[403] = "Verzija";
$txt[404] = "Autor";
$txt[405] = "Opis stranice";
$txt[406] = "Uplodirajte Novi Tema za vasu chat";
$txt[407] = "Vous êtes maintenant Opérateur de Salons, pour accéder au panneau de contrôle, tapez /roomcp";
$txt[408] = "Groupes par défaut";
$txt[409] = "Novi Clan";
$txt[410] = "Invité";
$txt[411] = "Administrator";
$txt[412] = "Votre configuration de groupes a été mise à jour.";
$txt[413] = "Clanovi";
$txt[414] = "Nova Grupa";
$txt[415] = "Le groupe a été modifié.";
$txt[416] = "Azuriraj Grupu";
$txt[417] = "Avec la sélection, Changer le groupe pour";
$txt[418] = "Les utilisateurs suivants sont dans ce groupe";
$txt[419] = "Potvrdi/Skini sve potvrde";
$txt[420] = "Veuillez enlever tous les utilisateurs du groupe avant de le supprimer.";
$txt[421] = "Le groupe a été supprimé.";
$txt[422] = "Peut créer des salons";
$txt[423] = "Peut créer des salons privés";
$txt[424] = "Ici vous pouvez changer les choses que peut faire ce groupe d`utilisateurs.";
$txt[425] = "Peut positionner ce salon en non-expiration";
$txt[426] = "Peut positionner ce salon en modération";
$txt[427] = "Peut voir les IP";
$txt[428] = "Peut jeter les utilisateurs";
$txt[429] = "Ne peut pas être banni(e) ou jeté(e)";
$txt[430] = "A le status d`Opérateur dans tous les salons";
$txt[431] = "A la fonction Voix dans tous les salons";
$txt[432] = "Peut voir les adresse email cachées";
$txt[433] = "Peut ajouter/enlever les mots clés";
$txt[434] = "Peut contrôler les connexions du salon";
$txt[435] = "Peut loguer des messages privés";
$txt[436] = "Peut choisir un fond d`écran dans le salon";
$txt[437] = "Peut choisir un logo dans le salon";
$txt[438] = "Peut donner le droit d`Administrateur";
$txt[439] = "Peut envoyer des messages serveur";
$txt[440] = "Peut utiliser la commande /mdeop";
$txt[441] = "Peut utiliser la commande /mkick";
$txt[442] = "Peut accéder au Panneau de Configuration Admin: Configuration";
$txt[443] = "Peut accéder au PC Admin : Thèmes";
$txt[444] = "Peut accéder au PC Admin : Filtrer les mots";
$txt[445] = "Peut accéder au PC Admin : Groupes Utilisateurs";
$txt[446] = "Peut accéder au PC Admin : Gestion Utilisateurs";
$txt[447] = "Peut accéder au PC Admin : Liste des Bannis";
$txt[448] = "Peut accéder au PC Admin : Bande Passante";
$txt[449] = "Peut accéder au PC Admin : Gestion des Logs";
$txt[450] = "Peut accéder au PC Admin : Messages aux utilisateurs";
$txt[451] = "Peut accéder au PC Admin : Modules";
$txt[452] = "Peut accéder au PC Admin : Smilies";
$txt[453] = "Peut accéder au PC Admin : Gestion des Salons";
$txt[454] = "Peut accéder au Chat même si il est désactivé";
$txt[455] = "L`utilisateur doit avoir le statut d`opérateur pour employer cette fonction";
$txt[456] = "L`utilisateur doit avoir le statut d`opérateur et cette fonction doit être permise dans la section de réglage du panneau de contrôle Admin.";
$txt[457] = "Peut accéder au PC Admin : Calendrier";
$txt[458] = "Les permissions de ce groupe ont été mises à jour.";
$txt[459] = "Obnovi";
$txt[460] = "Brza obnova";
$txt[461] = "Êtes-vous sûr de vouloir supprimer ce compte utilisateur ?";
$txt[462] = "Le compte utilisateur a été supprimé.";
$txt[463] = "Compte d`utilisteur introuvable.";
$txt[464] = "Le compte utilisateur a été mis à jour.";
$txt[465] = "Êtes-vous sûr de vouloir supprimer ce salon ?";
$txt[466] = "Les salons sélectionnés ont été supprimés.";
$txt[467] = "Le salon a été supprimé.";
$txt[468] = "Log de la bande passante";
$txt[469] = "Log de la Bande Passante désactivé.  <a>Cliquez ici</a> pour l`activer.";	// Leave <a> and </a> alone
$txt[470] = "Log de la Bande Passante activé.  <a>Cliquez ici</a> pour la desactiver.";	// Leave <a> and </a> alone
$txt[471] = "Limite de la bande passante par défaut (en MegaOctets)";
$txt[472] = "Limite utilisateur à <i>x</b> Mo par _t";	//  _t will be a drop down menu with Month or Day in it
$txt[473] = "Mjesec";	// Yes you have seen this before, this time its not plural
$txt[474] = "Dan";	// Yes you have seen this before, this time its not plural
$txt[475] = "Utilisé";
$txt[476] = "Max (Mo)";
$txt[477] = "Les valeurs pour le compte utilisé de la largeur de la bande passante `dans le salon` n`inclut pas l`en-tête de transmission.  La largeur de bande pour les autres pages n`est pas prise en compte.";
$txt[478] = "Mettre la valeur à 0 pour illimité ou -1 par défaut";
$txt[479] = "Total Bande Passante";
$txt[480] = "Vous avez dépassé la largeur de bande passante permise pour aujourd`hui. Veuillez revenir demain.";
$txt[481] = "Vous avez dépassé la largeur de bande passante permise pour le mois. Veuillez revenir le mois prochain.";
$txt[482] = "Logué";
$txt[483] = "Gerer/Visualiser";
$txt[484] = "Les Logs sont désactivés, <a>Cliquez ici</a> pour les activer.";	// Leave <a> and </a> alone
$txt[485] = "Les Logs sont activés, <a>Clqiuez ici</a> pour les desactiver.";	// Leave <a> and </a> alone
$txt[486] = "Editer la configuration des logs";
$txt[487] = "Editer les évènements";
$txt[488] = "Evènements";
$txt[489] = "Ajouter un évènement";
$txt[490] = "Sat (HH:MM)";
$txt[491] = "Veuillez utiliser le format 24-heures";
$txt[492] = "Date (MM/DD/YYYY)";
$txt[493] = "Vous pouvez entrer un message qui sera envoyé à tous les membres enregistrés.";
$txt[494] = "Votre message a été envoyé à tous les membres enregistrés.";
$txt[495] = "Ajouter un Smile";
$txt[496] = "Code";
$txt[497] = "URL slike";
$txt[498] = "Les Smilies suivants ont été installés.";
$txt[499] = "Les Smilies suivants trouvés dans le répertoire n`ont pas été encore utilisés.";
$txt[500] = "Vous pouvez ajouter plus de smilies en même temps en les transférant dans le répertoire Smilies.";
$txt[501] = "Smiley";
$txt[502] = "Veuillez visiter le <a href=\"http://x7chat.com/support.php\" target=\"_blank\">support technique</a> pour lire la documentation technique, et avoir un appui technique.<Br><br>La documentation utilisateur est incluse dans le salon en mode Aide <a href=\"./help/\" target=\"_blank\">Cliquez ici</a>.";		// This one doesn`t necessarily need to be translated
$txt[503] = "<a>[Cliquez ici]</a> pour accéder à la documentation";	// Leave <a> and </a> alone
$txt[504] = "<a>[Cliquez ici]</a> pour ouvrir le panneau de contrôle Admin dans une autre fenêtre.";		// Leave the <a> and </a> tags alone
$txt[505] = "Postani Nevidljiv";
$txt[506] = "Voir les utilisateurs invisibles";
$txt[507] = "Vous n`avez pas la permission de devenir invisible";
$txt[508] = "Vous êtes maintenant invisible dans ce salon";
$txt[509] = "Vous n`êtes plus invisible dans ce salon";
$txt[510] = "Entrer dans les salons en mode invisible";
$txt[511] = "Vous avez eu un message privé. Si la fenêtre ne s`ouvre pas automatiquement, <a>[Cliquez ici]</a>";		// Leave <a> and </a> alone
$txt[512] = "_u a été banni de ce salon pour la raison suivante <b>_r</b>.";	// _u is replaced with the username, _r is the reason
$txt[513] = "_u n`est plus banni du salon.";
$txt[514] = "Ne procitane Poste";
$txt[515] = "Nb Max de caractères par pseudo";
$txt[516] = "Si vous entrez dans le chat c`est que vous acceptez les <a>conditions d`utilisation</a>.";	// Leave <a> and </a> alone
$txt[517] = "Conditions d`utilisation";
$txt[518] = "Si vous souhaitez désactiver les conditions d`utilisations, laissez vide.  Vous pouvez employer des balises HTML.";
$txt[519] = "Voir l`adresse IP d`un utilisateur";
$txt[520] = "prikazi";
$txt[521] = "Vous pouvez effacer les lignes par la commande <a>Clean Up</a>";	// Leave <a> and </a> alone
$txt[522] = "Vous devez faire un CHMOD 777 sur ce répertoire pour que les logs fonctionnent.";
$txt[523] = "Postati Nevidljiv";
$txt[524] = "Postati Vidljiv";
$txt[525] = "Avant de créer ou d`éditer un thème vous devez faire un CHMOD 777 du répertoire `thèmes`.< Br><Br><b>SI VOUS ÉDITEZ UN THEME</b><Br>Si vos changements ne peuvent pas se mettre à jour.  Veuillez visiter le site X7 CHAT.";
$txt[526] = "Créer un nouveau Thème";
$txt[527] = "Couleur de la fenêtre du fond";
$txt[528] = "Fond d`écran de la page principale";
$txt[529] = "2eme Fond d`écran de la page principale";
$txt[530] = "Couleur des caractères";
$txt[531] = "Couleur du bouton";
$txt[532] = "Couleur caractère du Haut";
$txt[533] = "Famille des fontes";
$txt[534] = "Petite taille";
$txt[535] = "taille normale";
$txt[536] = "Grande taille";
$txt[537] = "Très grande taille";
$txt[538] = "Couleur bordure";
$txt[539] = "Couleur alternative de bordure";
$txt[540] = "Couleur des liens";
$txt[541] = "Couleur des liens (over)";
$txt[542] = "Couleur des liens (actif)";
$txt[543] = "Couleur de fond de la boîte textes";
$txt[544] = "Couleur de bordure de la boîte textes";
$txt[545] = "Taille de la fonte de la boîte des textes";
$txt[546] = "Couleur de la fonte de la boîte des textes";
$txt[547] = "Couleur des autres pseudos utilisateurs";
$txt[548] = "Couleur de votre pseudo";
$txt[549] = "Couleur du font d`écran de la fenêtre du chat";
$txt[550] = "Couleur de bordure des fenêtres des messages privés";
$txt[551] = "URL stranice ";
$txt[552] = "Nom du Thème";
$txt[553] = "Font de tête de table";
$txt[554] = "Auteur du Thème ";
$txt[555] = "Description du Thème";
$txt[556] = "Verzija Theme";
$txt[557] = "Impossible de localiser le répertoire des thèmes.";
$txt[558] = "Votre thème a été mis à jour.";
$txt[559] = "Vous devez donner un nom à votre thème.";
$txt[560] = "Razgovaraju na..";
$txt[561] = "Lista registriranih clanova";
$txt[562] = "Fond d`écran du Haut";
$txt[563] = "Boja Kalendara ";
$txt[564] = "<b>Syntaxe:</b> /mkick <i>raison</i> <Br>Cette commande Ejecte l`ensemble des utilisateurs des salons.";
$txt[565] = "Veuillez modifier l`accès du répertoire des modules (777).";
$txt[566] = "Télécharger des modules";
$txt[567] = "Installer des modules";
$txt[568] = "Désinstaller";
$txt[569] = "Nouveau Module";
$txt[570] = "Nom du Module";
$txt[571] = "Veuillez modifier les accès (777) des répertoire et des fichiers suivants:";
$txt[572] = "Démarre l`Installation";
$txt[573] = "Backup fichiers & démarrage";
$txt[574] = "L`installation est finie, vous pouvez faire n`importe quel CHMOD que vous voulez.";
$txt[575] = "Début de la désintallation";
$txt[576] = "Le procédé de désinstallation a été accompli, vous pouvez refaire n`importe quel CHMOD que vous voulez.";
$txt[577] = "Peut accéder au PC Admin : Mots-clés";
$txt[578] = "Thème Information";
$txt[579] = "Thème Fontes";
$txt[580] = "Thème Fonds d`écrans";
$txt[581] = "Thème Bordures";
$txt[582] = "Thème Liens";
$txt[583] = "Thème Boîte de dialogue";
$txt[584] = "Thème couleurs";
$txt[585] = "Fonds Couleur 4";
$txt[586] = "Bordure Style";
$txt[587] = "Bordure Taille";
$txt[588] = "Bordure Boite de dialogue";
$txt[589] = "Taille Boite de dialogue";
$txt[590] = "Mode salons";
$txt[591] = "Mode Multi Salons";
$txt[592] = "Salon unique";
$txt[593] = "Si vous sélectionnez le mode <b>Salon unique</b>, l`utilisateur entrera directement dans celui-ci lors de sa connexion.";
$txt[594] = "Ce salon est utilisé dans le mode <b>Salon unique</b>, vous ne pouvez pas le supprimer.  Veuillez annuler le mode <b>Salon unique</b> dans la configuration des salons.";
$txt[595] = "* Support Session Nouveau Client *";
$txt[596] = "Patientez, quelqu`un va venir rapidement.";
$txt[597] = "Une erreur vient de se produire. Veuillez prendre contact avec l`adminsitrateur du Chat. Copiee l`erreur ci-dessous et transmettez-lui.";
$txt[598] = "Chargement ...";
$txt[599] = "Support Technique";
$txt[600] = "Le nouveau compte utilisateur a été créé.";
$txt[601] = "Créer un compte utilisateur";
$txt[602] = "Accès au mot de passe de protection des salons W/O";
$txt[603] = "Vous devez laisser cette fenétre ouverte. Le support demandé va apparraitre dans une nouvelle fenétre. Désactivez votre bloqueur de popup si vous en avez un !";
$txt[604] = "Ce panneau de contrôle affiche le support technique pour les salons. Veuillez lire les informations pour sa création.";
$txt[605] = "Comptes (Support Techique)";
$txt[606] = "Message a afficher si le support n`est pas disponible";
$txt[607] = "(Support technique Disponible) Image";
$txt[608] = "(Support technique Non Disponible) Image";
$txt[609] = "Liste des utilisateurs séparés par des ponts virgules , Ces utilisateurs doivent avoir l`accès au <b>Support Technique</b>";
$txt[610] = "Le compte a qui vous voulez envoyer ce message n`existe pas.";
$txt[611] = "Définissez votre valeur RGB";
$txt[612] = "Vous ne pouvez pas supprimer le thème par défaut.";

/** Special strings **/

// Days of the week and months, these are simply easier and more efficient to do this way
$txt['Sunday'] = "Dimanche";
$txt['Monday'] = "Lundi";
$txt['Tuesday'] = "Mardi";
$txt['Wednesday'] = "Mercredi";
$txt['Thursday'] = "Jeudi";
$txt['Friday'] = "Vendredi";
$txt['Saturday'] = "Samedi";
$txt['January'] = "Sijecanj";
$txt['February'] = "Veljaca";
$txt['March'] = "Ozujak";
$txt['April'] = "Travanj";
$txt['May'] = "Svibanj";
$txt['June'] = "Lipanj";
$txt['July'] = "Srpanj";
$txt['August'] = "Kolovoz";
$txt['September'] = "Rujan";
$txt['October'] = "Listopad";
$txt['November'] = "Studeni";
$txt['December'] = "Prosinac";

?>
