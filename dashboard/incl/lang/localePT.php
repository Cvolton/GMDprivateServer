<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Início";
$string["welcome"] = "Bem-vindo ao ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Aviso!</b> Você não instalou completamente o dashboard! Clique no texto para fazer isso.</div>";
$string["levelsWeek"] = "Níveis enviados em uma semana";
$string["levels3Months"] = "Níveis enviados em 3 meses";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Bem-vindo ao Dashboard! Damos algumas dicas após a instalação:<br>
1. Parece que novas permissões apareceram no SQL na tabela 'roles'! Você deve verificar...<br>
2. Se você colocar 'icon.png' na pasta 'dashboard', o ícone do seu GDPS aparecerá no canto superior esquerdo!<br>
3. Você deve configurar config/dashboard.php!";
$string["wwygdt"] = "O que você vai fazer hoje?";
$string["game"] = "Jogo";
$string["guest"] = "convidado";
$string["account"] = "Conta";
$string["levelsOptDesc"] = "Visualizar lista de níveis";
$string["songsOptDesc"] = "Visualizar lista de músicas";
$string["yourClanOptDesc"] = "Ver clã \"%s\"";
$string["clanOptDesc"] = "Ver lista de clãs";
$string["yourProfile"] = "Seu perfil";
$string["profileOptDesc"] = "Visualizar seu perfil";
$string["messengerOptDesc"] ="Abrir messenger";
$string["addSongOptDesc"] = "Adicionar música ao servidor";
$string["loginOptDesc"] = "Entrar na conta";
$string["createAcc"] = "Criar uma conta";
$string["registerOptDesc"] = "Registrar-se em %s";
$string["downloadOptDesc"] = "Baixar %s";

$string["tryCron"] = "Executar Cron";
$string["cronSuccess"] = "Sucesso!";
$string["cronError"] = "Erro!";

$string["profile"] = "Perfil";
$string["empty"] = "Vazio...";
$string["writeSomething"] = "Escreva algo!";
$string["replies"] = "Respostas";
$string["replyToComment"] = "Responder a um comentário";
$string["settings"] = "Configurações";
$string["allowMessagesFrom"] = "Permitir mensagens de...";
$string["allowFriendReqsFrom"] = "Permitir solicitações de amizade de...";
$string["showCommentHistory"] = "Mostrar histórico de comentários...";
$string["timezoneChoose"] = "Escolher fuso horário";
$string["yourYouTube"] = "Seu canal no YouTube";
$string["yourVK"] = "Sua página no VK";
$string["yourTwitter"] = "Sua página no Twitter";
$string["yourTwitch"] = "Seu canal no Twitch";
$string["saveSettings"] = "Salvar configurações";
$string["all"] = "Todos";
$string["friends"] = "Amigos";
$string["none"] = "Nenhum";
$string["youBlocked"] = "Este jogador bloqueou você!";
$string["cantMessage"] = "Você não pode enviar mensagens para este jogador!";

$string["accountManagement"] = "Gerenciamento de conta";
$string["changePassword"] = "Mudar senha";
$string["changeUsername"] = "Mudar nome de usuário";
$string["unlistedLevels"] = "Seus níveis não listados";

$string["manageSongs"] = "Gerenciar músicas";
$string["gauntletManage"] = "Gerenciar Gauntlets";
$string["suggestLevels"] = "Níveis sugeridos";

$string["modTools"] = "Ferramentas de mod";
$string["leaderboardBan"] = "Banir um usuário";
$string["unlistedMod"] = "Níveis não listados";

$string["reuploadSection"] = "Recarregar";
$string["songAdd"] = "Adicionar uma música";
$string["songLink"] = "Adicionar uma música por link";
$string["packManage"] = "Gerenciar Map Packs";

$string["browse"] = "Navegar";
$string["statsSection"] = "Estatísticas";
$string["dailyTable"] = "Níveis diários";
$string["modActionsList"] = "Ações de mod";
$string["modActions"] = "Moderadores do servidor";
$string["gauntletTable"] = "Lista de Gauntlets";
$string["packTable"] = "Lista de Map Packs";
$string["leaderboardTime"] = "Progresso das tabelas de classificação";

$string["download"] = "Baixar";
$string["forwindows"] = "Para Windows";
$string["forandroid"] = "Para Android";
$string["formac"] = "Para Mac";
$string["forios"] = "Para iOS";
$string["third-party"] = "Terceiros";
$string["thanks"] = "Obrigado a essas pessoas!";
$string["language"] = "Idioma";

$string["loginHeader"] = "Bem-vindo, %s!";
$string["logout"] = "Sair";
$string["login"] = "Entrar";
$string["wrongNickOrPass"] = "Nome de usuário ou senha incorretos!";
$string["invalidid"] = "ID inválido!";
$string["loginBox"] = "Entrar na conta";
$string["loginSuccess"] = "Você entrou na sua conta com sucesso!";
$string["loginAlready"] = "Você já está logado!";
$string["clickHere"] = "Painel de Controle";
$string["enterUsername"] = "Digite o nome de usuário";
$string["enterPassword"] = "Digite a senha";
$string["loginDesc"] = "Aqui você pode entrar na sua conta!";

$string["register"] = "Registrar";
$string["registerAcc"] = "Registro de conta";
$string["registerDesc"] = "Registre a sua conta!";
$string["repeatpassword"] = "Repetir senha";
$string["email"] = "Email";
$string["repeatemail"] = "Repetir email";
$string["smallNick"] = "Nome de usuário muito curto!";
$string["smallPass"] = "Senha muito curta!";
$string["passDontMatch"] = "Senhas não coincidem!";
$string["emailDontMatch"] = "Emails não coincidem";
$string["registered"] = "Você registrou uma conta com sucesso!";
$string["bigNick"] = "Nome de usuário muito longo!";
$string["mailExists"] = "Já existe uma conta registrada com este email!";
$string["badUsername"] = "Por favor, escolha outro nome de usuário.";

$string["changePassTitle"] = "Mudar senha";
$string["changedPass"] = "Senha alterada com sucesso! Você precisa entrar na sua conta novamente.";
$string["wrongPass"] = "Senha incorreta!";
$string["samePass"] = "As senhas que você digitou são iguais!";
$string["changePassDesc"] = "Aqui você pode mudar sua senha!";
$string["oldPassword"] = "Senha antiga";
$string["newPassword"] = "Nova senha";
$string["confirmNew"] = "Confirmar senha";

$string["forcePassword"] = "Forçar mudança de senha";
$string["forcePasswordDesc"] = "Aqui você pode forçar a mudança de senha de um jogador!";
$string["forceNick"] = "Forçar mudança de nome de usuário";
$string["forceNickDesc"] = "Aqui você pode forçar a mudança de nome de usuário de um jogador!";
$string["forceChangedPass"] = "A senha de <b>%s</b> foi alterada com sucesso!";
$string["forceChangedNick"] = "O nome de usuário de <b>%s</b> foi alterado com sucesso!";
$string["changePassOrNick"] = "Mudar nome de usuário ou senha do jogador";

$string["changeNickTitle"] = "Mudar nome de usuário";
$string["changedNick"] = "Nome de usuário alterado com sucesso! Você precisa entrar na sua conta novamente.";
$string["wrongNick"] = "Nome de usuário incorreto!";
$string["sameNick"] = "Os nomes de usuário que você digitou são iguais!";
$string["alreadyUsedNick"] = "O nome de usuário que você digitou já está em uso!";
$string["changeNickDesc"] = "Aqui você pode mudar seu nome de usuário!";
$string["oldNick"] = "Nome de usuário antigo";
$string["newNick"] = "Novo nome de usuário";
$string["password"] = "Senha";

$string["packCreate"] = "Criar um Pacote de Mapas";
$string["packCreateTitle"] = "Criar um Pacote de Mapas";
$string["packCreateDesc"] = "Aqui você pode criar um Pacote de Mapas!";
$string["packCreateSuccess"] = "Você criou com sucesso um Pacote de Mapas chamado";
$string["packCreateOneMore"] = "Mais um Pacote de Mapas?";
$string["packName"] = "Nome do Pacote de Mapas";
$string["color"] = "Cor";
$string["sameLevels"] = "Você escolheu os mesmos níveis!";
$string["show"] = "Mostrar";
$string["packChange"] = "Mudar Pacote de Mapas";
$string["createNewPack"] = "Crie um novo Pacote de Mapas!";

$string["gauntletCreate"] = "Criar Gauntlet";
$string["gauntletCreateTitle"] = "Criar Gauntlet";
$string["gauntletCreateDesc"] = "Aqui você pode criar um Gauntlet!";
$string["gauntletCreateSuccess"] = "Você criou um Gauntlet com sucesso!";
$string["gauntletCreateOneMore"] = "Mais um Gauntlet?";
$string["chooseLevels"] = "Escolher níveis!";
$string["checkbox"] = "Confirmar";
$string["level1"] = "1º nível";
$string["level2"] = "2º nível";
$string["level3"] = "3º nível";
$string["level4"] = "4º nível";
$string["level5"] = "5º nível";
$string["gauntletChange"] = "Mudar Gauntlet";
$string["createNewGauntlet"] = "Crie um novo Gauntlet!";
$string["gauntletCreateSuccessNew"] = 'Você criou com sucesso <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Escolher Gauntlet automaticamente";

$string["addQuest"] = "Adicionar missão";
$string["addQuestDesc"] = "Aqui você pode criar uma missão!";
$string["questName"] = "Nome da missão";
$string["questAmount"] = "Quantidade necessária";
$string["questReward"] = "Recompensa";
$string["questCreate"] = "Criar uma missão";
$string["questsSuccess"] = "Você criou uma missão com sucesso";
$string["invalidPost"] = "Dados inválidos!";
$string["fewMoreQuests"] = "Recomendamos criar mais algumas missões.";
$string["oneMoreQuest?"] = "Mais uma missão?";
$string["changeQuest"] = "Mudar missão";
$string["createNewQuest"] = "Crie uma nova missão!";

$string["levelReupload"] = "Reenviar nível";
$string["levelReuploadDesc"] = "Aqui você pode reenviar um nível de qualquer servidor!";
$string["advanced"] = "Opções avançadas";
$string["errorConnection"] = "Erro de conexão!";
$string["levelNotFound"] = "Este nível não existe!";
$string["robtopLol"] = "RobTop não gosta de você :c";
$string["sameServers"] = "O servidor de origem e o servidor de destino são os mesmos!";
$string["levelReuploaded"] = "Nível reenviado! ID do nível:";
$string["oneMoreLevel?"] = "Mais um nível?";
$string["levelAlreadyReuploaded"] = "Nível já reenviado!";
$string["server"] = "Servidor";
$string["levelID"] = "ID do nível";
$string["pageDisabled"] = "Esta página está desativada!";
$string["levelUploadBanned"] = "Você está banido de enviar níveis!";

$string["activateAccount"] = "Ativação de conta";
$string["activateDesc"] = "Ative sua conta!";
$string["activated"] = "Sua conta foi ativada com sucesso!";
$string["alreadyActivated"] = "Sua conta já está ativada";
$string["maybeActivate"] = "Talvez você ainda não tenha ativado sua conta.";
$string["activate"] = "Ativar";
$string["activateDisabled"] = "A ativação de conta está desativada!";

$string["addMod"] = "Adicionar moderador";
$string["addModDesc"] = "Aqui você pode promover alguém a Moderador!";
$string["modYourself"] = "Você não pode se tornar Moderador!";
$string["alreadyMod"] = "Este jogador já é Moderador!";
$string["addedMod"] = "Você promoveu um jogador a Moderador com sucesso";
$string["addModOneMore"] = "Mais um moderador?";
$string["modAboveYourRole"] = "Você está tentando atribuir um cargo acima do seu!";
$string["makeNewMod"] = "Tornar alguém moderador!";
$string["reassignMod"] = "Reatribuir moderador";
$string["reassign"] = "Reatribuir";
$string['demotePlayer'] = "Rebaixar jogador";
$string['demotedPlayer'] = "Você rebaixou <b>%s</b> com sucesso!";
$string['addedModNew'] = "Você promoveu <b>%s</b> a Moderador com sucesso!";
$string['demoted'] = 'Rebaixado';

$string["shareCPTitle"] = "Compartilhar Pontos de Criador";
$string["shareCPDesc"] = "Aqui você pode compartilhar Pontos de Criador com um jogador!";
$string["shareCP"] = "Compartilhar";
$string["alreadyShared"] = "Este nível já compartilhou Pontos de Criador com este jogador!";
$string["shareToAuthor"] = "Você tentou compartilhar Pontos de Criador com o autor do nível!";
$string["userIsBanned"] = "Este jogador está banido!";
$string["shareCPSuccess"] = "Você compartilhou com sucesso Pontos de Criador do nível";
$string["shareCPSuccess2"] = "com o jogador";
$string["updateCron"] = "Talvez você deva atualizar os Pontos de Criador.";
$string["shareCPOneMore"] = "Mais um compartilhamento?";
$string['shareCPSuccessNew'] = 'Você compartilhou com sucesso Pontos de Criador do nível <b>%1$s</b> com o jogador <b>%2$s</b>!';

$string["messenger"] = "Mensageiro";
$string["write"] = "Escrever";
$string["send"] = "Enviar";
$string["noMsgs"] = "Comece o diálogo!";
$string["subject"] = "Assunto";
$string["msg"] = "Mensagem";
$string["tooFast"] = "Você está digitando muito rápido!";

$string["levelToGD"] = "Reenviar nível para o servidor de destino";
$string["levelToGDDesc"] = "Aqui você pode reenviar seu nível para o servidor de destino!";
$string["usernameTarget"] = "Nome de usuário para o servidor de destino";
$string["passwordTarget"] = "Senha para o servidor de destino";
$string["notYourLevel"] = "Este não é seu nível!";
$string["reuploadFailed"] = "Erro ao reenviar o nível!";

$string["search"] = "Pesquisar...";
$string["searchCancel"] = "Cancelar pesquisa";
$string["emptySearch"] = "Nada encontrado!";

$string["demonlist"] = 'Lista de Demônios';
$string["demonlistRecord"] = 'Recorde de <b>%s</b>';
$string["alreadyApproved"] = 'Já aprovado!';
$string["alreadyDenied"] = 'Já negado!';
$string["approveSuccess"] = 'Você aprovou com sucesso o recorde de <b>%s</b>!';
$string["denySuccess"] = 'Você negou com sucesso o recorde de <b>%s</b>!';
$string["recordParameters"] = '<b>%s</b> completou <b>%s</b> em <b>%d</b> tentativas';
$string["approve"] = 'Aprovar';
$string["deny"] = 'Negar';
$string["submitRecord"] = 'Enviar recorde';
$string["submitRecordForLevel"] = 'Enviar recorde para <b>%s</b>';
$string["alreadySubmitted"] = 'Você já enviou um recorde para <b>%s</b>!';
$string["submitSuccess"] = 'Você enviou com sucesso um recorde para <b>%s</b>!';
$string["submitRecordDesc"] = 'Envie recordes apenas se você completou o nível!';
$string["atts"] = 'Tentativas';
$string["ytlink"] = 'ID do vídeo do YouTube (dQw4w9WgXcQ)';
$string["submit"] = 'Enviar';
$string["addDemonTitle"] = 'Adicionar demônio';
$string["addDemon"] = 'Adicionar demônio à lista de demônios';
$string["addedDemon"] = 'Você adicionou <b>%s</b> à <b>%d</b> posição!';
$string["addDemonDesc"] = 'Aqui você pode adicionar um demônio à lista de demônios!';
$string["place"] = 'Posição';
$string["giveablePoints"] = 'Pontos atribuíveis';
$string["add"] = 'Adicionar';
$string["recordApproved"] = 'Recorde aprovado!';
$string["recordDenied"] = 'Recorde negado!';
$string["recordSubmitted"] = 'Recorde enviado!';
$string["nooneBeat"] = 'ninguém completou'; //let it be lowercase
$string["oneBeat"] = '1 jogador completou';
$string["lower5Beat"] = '%d jogadores completaram'; // russian syntax, sorry
$string["above5Beat"] = '%d jogadores completaram';
$string["demonlistLevel"] = '%s <text class="dltext">por <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button></text>';
$string["noDemons"] = 'Parece que sua lista de demônios não tem nenhum demônio...';
$string["addSomeDemons"] = 'Adicione alguns demônios para preencher a lista de demônios!';
$string["askForDemons"] = 'Peça ao administrador do servidor para adicionar alguns!';
$string["recordList"] = 'Lista de recordes';
$string["status"] = 'Status';
$string["checkRecord"] = 'Verificar recorde';
$string["record"] = 'Recorde';
$string["recordDeleted"] = 'Recorde foi deletado!';
$string["changeDemon"] = 'Mudar demônio';
$string["demonDeleted"] = 'Demônio foi deletado!';
$string["changedDemon"] = 'Você substituiu <b>%s</b> pela <b>%d</b> posição!';
$string["changeDemonDesc"] = 'Aqui você pode mudar um demônio!<br>Se você quiser deletar o demônio, defina a posição como 0.';

$string["didntActivatedEmail"] = 'Você não ativou sua conta através do email!';
$string["checkMail"] = 'Você deve verificar seu email...';

$string["likeSong"] = "Adicionar música aos favoritos";
$string["dislikeSong"] = "Remover música dos favoritos";
$string["favouriteSongs"] = "Músicas favoritas";
$string["howMuchLiked"] = "Quantos gostaram?";
$string["nooneLiked"] = "Ninguém gostou";

$string["clan"] = "Clã";
$string["joinedAt"] = "Entrou no clã em: <b>%s</b>";
$string["createdAt"] = "Criou o clã em: <b>%s</b>";
$string["clanMembers"] = "Membros do clã";
$string["noMembers"] = "Sem membros";
$string["clanOwner"] = "Dono do clã";
$string["noClanDesc"] = "<i>Sem descrição</i>";
$string["noClan"] = "Este clã não existe!";
$string["clanName"] = "Nome do clã";
$string["clanTag"] = "Tag do clã (3-5 caracteres)";
$string["clanDesc"] = "Descrição do clã";
$string["clanColor"] = "Cor do clã";
$string["dangerZone"] = "Zona de perigo";
$string["giveClan"] = "Transferir clã";
$string["deleteClan"] = "Deletar clã";
$string["goBack"] = "Voltar";
$string["areYouSure"] = "Você tem certeza?";
$string["giveClanDesc"] = "Aqui você pode transferir seu clã para um jogador.";
$string["notInYourClan"] = "Este jogador não está no seu clã!";
$string["givedClan"] = "Você transferiu com sucesso seu clã para <b>%s</b>!";
$string["deletedClan"] = "Você deletou o clã <b>%s</b>.";
$string["deleteClanDesc"] = "Aqui você pode deletar seu clã.";
$string["yourClan"] = "Seu clã";
$string["members0"] = "<b>1</b> membro";
$string["members1"] = "<b>%d</b> membros";
$string["members2"] = "<b>%d</b> membros";
$string["noRequests"] = "Não há solicitações. Relaxe!";
$string["pendingRequests"] = "Solicitações do clã";
$string["closedClan"] = "Clã fechado";
$string["kickMember"] = "Expulsar membro";
$string["leaveFromClan"] = "Sair do clã";
$string["askToJoin"] = "Enviar solicitação de entrada";
$string["removeClanRequest"] = "Deletar solicitação de entrada";
$string["joinClan"] = "Entrar no clã";
$string["noClans"] = "Não há clãs";
$string["clans"] = "Clãs";
$string["alreadyInClan"] = "Você já está em um clã!";
$string["createClan"] = "Criar clã";
$string["createdClan"] = "Você criou com sucesso o clã <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Aqui você pode criar um clã!";
$string["create"] = "Criar";
$string["mainSettings"] = "Configurações principais";
$string["takenClanName"] = "Este nome de clã já foi tomado!";
$string["takenClanTag"] = "Esta tag de clã já foi tomada!";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> sugeriu <b>%4$s%3$s</b> para</text><text class="levelname">%2$s</text>'; // %1$s - Nome do Moderador, %2$s - nome do nível, %3$s - x estrelas, %4$s - Destacado/Épico (%4$s%3$s - Destacado, x estrelas)
$string["reportedName"] = '%1$s<text class="dltext"> foi relatado</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Listas";
$string['listTableMod'] = "Listas não listadas";
$string['listTableYour'] = "Suas listas não listadas";

$string['forgotPasswordChangeTitle'] = "Alterar senha";
$string["successfullyChangedPass"] = "A senha foi alterada com sucesso!";
$string['forgotPasswordTitle'] = "Esqueceu a senha?";
$string['maybeSentAMessage'] = "Vamos enviar uma mensagem se esta conta existir.";
$string['forgotPasswordDesc'] = "Aqui você pode solicitar um link para alterar a senha se você esqueceu!";
$string['forgotPasswordButton'] = "Solicitar link";

$string['sfxAdd'] = "Adicionar SFX";
$string["sfxAddError-5"] = "O tamanho do SFX é maior que $sfxSize megabytes!";
$string["sfxAddError-6"] = "Algo deu errado ao carregar o SFX!";
$string["sfxAddError-7"] = "Você só pode carregar áudio!";
$string['sfxAdded'] = 'SFX adicionado';
$string['yourNewSFX'] = "Dê uma olhada no seu novo SFX!";
$string["sfxAddAnotherBTN"] = "Mais um SFX?";
$string["sfxAddDesc"] = "Aqui você pode adicionar o seu SFX!";
$string["chooseSFX"] = "Escolher SFX";
$string["sfxAddNameFieldPlaceholder"] = "Nome";
$string['sfxs'] = 'SFXs';
$string['sfxID'] = 'ID do SFX';
$string['manageSFX'] = 'Gerenciar SFXs';

$string['featureLevel'] = 'Nível em destaque';

$string['banList'] = 'Lista de pessoas banidas';
$string['expires'] = 'Expira';
$string['unbanPerson'] = 'Desbanir';
$string['IP'] = 'Endereço IP';
$string['noBanInPast'] = 'Você não pode banir até o passado!';
$string['banSuccess'] = 'Você baniu com sucesso <b>%1$s</b> até <b>%3$s</b> em «<b>%2$s</b>»!';
$string['person'] = 'Pessoa';
$string['youAreBanned'] = 'Você foi banido até <b>%2$s</b> por motivo:<br><b>%1$s</b>';
$string['banChange'] = 'Alterar';
$string['system'] = 'Sistema';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Recarregar";
$string["errorGeneric"] = "Ocorreu um erro!";
$string["smthWentWrong"] = "Algo deu errado!";
$string["tryAgainBTN"] = "Tente novamente";
//songAdd.php
$string["songAddDesc"] = "Aqui você pode adicionar sua música!";
$string["songAddUrlFieldLabel"] = "URL da música: (Somente links diretos ou Dropbox)";
$string["songAddUrlFieldPlaceholder"] = "URL da música";
$string["songAddNameFieldPlaceholder"] = "Nome";
$string["songAddAuthorFieldPlaceholder"] = "Autor";
$string["songAddButton"] = "Escolher música";
$string["songAddAnotherBTN"] = "Outra música?";
$string["songAdded"] = "Música adicionada";
$string["deletedSong"] = "Você excluiu a música com sucesso";
$string["renamedSong"] = "Você renomeou a música para";
$string["songID"] = "ID da Música: ";
$string["songIDw"] = "ID da Música";
$string["songAuthor"] = "Autor";
$string["size"] = "Tamanho";
$string["delete"] = "Excluir";
$string["change"] = "Alterar";
$string["chooseFile"] = "Escolher uma música";
$string['yourNewSong'] = "Dê uma olhada na sua nova música!";
///errors
$string["songAddError-2"] = "URL inválida";
$string["songAddError-3"] = "Esta música já foi recarregada com ID:";
$string["songAddError-4"] = "Esta música não é recarregável";
$string["songAddError-5"] = "O tamanho da música é maior que $songSize megabytes";
$string["songAddError-6"] = "Algo deu errado ao fazer o upload da música!";
$string["songAddError-7"] = "Você só pode fazer upload de áudio!";

$string[400] = "Requisição inválida!";
$string["400!"] = "Verifique os drivers do seu hardware de rede.";
$string[403] = "Proibido!";
$string["403!"] = "Você não tem acesso a esta página!";
$string[404] = "Página não encontrada!";
$string["404!"] = "Tem certeza de que digitou o endereço corretamente?";
$string[500] = "Erro interno do servidor!";
$string["500!"] = "O programador cometeu um erro no código,</br>
por favor, reporte este problema aqui:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Servidor está fora do ar!";
$string["502!"] = "A carga no servidor é muito alta.</br>
Volte mais tarde dentro de algumas horas!";

$string["invalidCaptcha"] = "Resposta inválida do captcha!";
$string["page"] = "Página";
$string["emptyPage"] = "Esta página está vazia!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Orbes";
$string["stars"] = "Estrelas";
$string["coins"] = "Moedas";
$string["accounts"] = "Contas";
$string["levels"] = "Níveis";
$string["songs"] = "Músicas";
$string["author"] = "Criador";
$string["name"] = "Nome";
$string["date"] = "Data";
$string["type"] = "Tipo";
$string["reportCount"] = "Contagem de relatórios";
$string["reportMod"] = "Relatórios";
$string["username"] = "Nome de usuário";
$string["accountID"] = "ID da conta";
$string["registerDate"] = "Data de registro";
$string["levelAuthor"] = "Autor do nível";
$string["isAdmin"] = "Função no servidor";
$string["isAdminYes"] = "Sim";
$string["isAdminNo"] = "Não";
$string["userCoins"] = "Moedas do usuário";
$string["time"] = "Tempo";
$string["deletedLevel"] = "Nível excluído";
$string["mod"] = "Moderador";
$string["count"] = "Quantidade de ações";
$string["ratedLevels"] = "Níveis avaliados";
$string["lastSeen"] = "Última vez online";
$string["level"] = "Nível";
$string["pageInfo"] = "Mostrando página %s de %s";
$string["first"] = "Primeira";
$string["previous"] = "Anterior";
$string["next"] = "Próxima";
$string["never"] = "Nunca";
$string["last"] = "Última";
$string["go"] = "Ir";
$string["levelid"] = "ID do Nível";
$string["levelname"] = "Nome do Nível";
$string["leveldesc"] = "Descrição do Nível";
$string["noDesc"] = "Sem descrição";
$string["levelpass"] = "Senha";
$string["nopass"] = "Sem senha";
$string["unrated"] = "Não avaliado";
$string["rate"] = "Avaliar";
$string["stats"] = "Estatísticas";
$string["suggestFeatured"] = "Destacado?";
$string["whoAdded"] = "Quem adicionou?";
$string["moons"] = "Luas";
//modActionsList
$string["banDesc"] = "Aqui você pode banir um jogador!";
$string["playerTop"] = 'Top de jogadores';
$string["creatorTop"] = 'Top de criadores';
$string["levelUploading"] = 'Fazendo upload de níveis';
$string["successfullyBanned"] = 'Jogador <b>%1$s</b> com ID da conta <b>%2$s</b> foi banido com sucesso!';
$string["successfullyUnbanned"] = 'Jogador <b>%1$s</b> com ID da conta <b>%2$s</b> foi desbanido com sucesso!';
$string["commentBan"] = 'Comentando';

$string["admin"] = "Administrador";
$string["elder"] = "Moderador sênior";
$string["moder"] = "Moderador";
$string["player"] = "Jogador";

$string["starsLevel2"] = "estrelas";
$string["starsLevel1"] = "estrela";
$string["starsLevel0"] = "estrela";
$string["coins2"] = "moedas";
$string["coins1"] = "moeda";
$string["coins0"] = "moeda";
$string["time0"] = "vez";
$string["time1"] = "vezes";
$string["times"] = "vezes";
$string["action0"] = "ação";
$string["action1"] = "ações";
$string["action2"] = "ações";
$string["lvl0"] = "nível";
$string["lvl1"] = "níveis";
$string["lvl2"] = "níveis";
$string["player0"] = "jogador";
$string["player1"] = "jogadores";
$string["player2"] = "jogadores";
$string["unban"] = "Desbanir";
$string["isBan"] = "Banir";

$string["noCoins"] = "Sem moedas";
$string["noReason"] = "Sem motivo";
$string["noActions"] = "Sem ações";
$string["noRates"] = "Sem avaliações";

$string["future"] = "Futuro";

$string["spoiler"] = "Spoiler";
$string["accid"] = "com ID da conta";
$string["banned"] = "foi banido com sucesso!";
$string["unbanned"] = "foi desbanido com sucesso!";
$string["ban"] = "Banir";
$string["nothingFound"] = "Este jogador não existe!";
$string["banUserID"] = "Nome de usuário ou ID da conta";
$string["banUserPlace"] = "Banir um usuário";
$string["banYourself"] = "Você não pode se banir!";
$string["banYourSelfBtn!"] = "Banir outra pessoa";
$string["banReason"] = "Motivo do banimento";
$string["action"] = "Ação";
$string["value"] = "1º valor";
$string["value2"] = "2º valor";
$string["value3"] = "3º valor";
$string["modAction1"] = "Avaliou um nível";
$string["modAction2"] = "Destaque/Não destaque de um nível";
$string["modAction3"] = "Verificou/Não verificou moedas";
$string["modAction4"] = "Epiquou/Não epiquou um nível";
$string["modAction5"] = "Definido como recurso diário";
$string["modAction6"] = "Deletou um nível";
$string["modAction7"] = "Mudança de criador";
$string["modAction8"] = "Renomeou um nível";
$string["modAction9"] = "Alterou a senha do nível";
$string["modAction10"] = "Alterou a dificuldade do demon";
$string["modAction11"] = "Compartilhou CP";
$string["modAction12"] = "Publicou/Despublicou nível";
$string["modAction13"] = "Alterou a descrição do nível";
$string["modAction14"] = "Habilitou/Desabilitou LDM";
$string["modAction15"] = "Desbanido/Banido da tabela de líderes";
$string["modAction16"] = "Mudança de ID da música";
$string["modAction17"] = "Criou um Pacote de Mapas";
$string["modAction18"] = "Criou um Desafio";
$string["modAction19"] = "Alterou a música";
$string["modAction20"] = "Concedeu um moderador ao jogador";
$string["modAction21"] = "Alterou o Pacote de Mapas";
$string["modAction22"] = "Alterou o Desafio";
$string["modAction23"] = "Alterou a missão";
$string["modAction24"] = "Reatribuído um jogador";
$string["modAction25"] = "Criou uma missão";
$string["modAction26"] = "Alterou o nome de usuário/senha do jogador";
$string["modAction27"] = "Alterou os efeitos sonoros";
$string["modAction28"] = "Baniu uma pessoa";
$string["modAction30"] = "Avaliou lista";
$string["modAction31"] = "Enviou lista";
$string["modAction32"] = "Destaque/Não destaque da lista";
$string["modAction33"] = "Publicou/Despublicou lista";
$string["modAction34"] = "Deletou lista";
$string["modAction35"] = "Alterado o criador da lista";
$string["modAction36"] = "Alterado o nome da lista";
$string["modAction37"] = "Alterada a descrição da lista";
$string["everyActions"] = "Qualquer ação";
$string["everyMod"] = "Todos os moderadores";
$string["Kish!"] = "Vai embora!";
$string["noPermission"] = "Você não tem permissão!";
$string["noLogin?"] = "Você não está logado na sua conta!";
$string["LoginBtn"] = "Entrar na conta";
$string["dashboard"] = "Painel";
$string["userID"] = 'ID do Usuário';
//errors
$string["errorNoAccWithPerm"] = "Erro: Nenhuma conta com a permissão '%s' foi encontrada";