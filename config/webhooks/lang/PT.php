<?php
/*
	Welcome to webhooks translation file!
	You're currently at Portuguese (Português) language
	Credits: OmgRod
	
	If you see array instead of simple string, that means you can add as many variations of translation as you want and they will be picked randomly
*/
$webhookLang['rateSuccessTitle'] = ['Novo nível foi avaliado!', 'Novo nível avaliado!', 'Alguém avaliou um nível!']; // This one is array
$webhookLang['rateSuccessTitleDM'] = ['Seu nível foi avaliado!', 'Alguém avaliou seu nível!'];
$webhookLang['rateSuccessDesc'] = '%1$s avaliou um nível!'; // And this one is string
$webhookLang['rateSuccessDescDM'] = '%1$s avaliou seu nível! %2$s';
$webhookLang['rateFailTitle'] = ['Nível foi desavaliado!', 'Alguém desavaliou um nível!'];
$webhookLang['rateFailTitleDM'] = ['Seu nível foi desavaliado!', 'Alguém desavaliou seu nível!'];
$webhookLang['rateFailDesc'] = '%1$s desavaliou um nível!';
$webhookLang['rateFailDescDM'] = '%1$s desavaliou seu nível! %2$s';

$webhookLang['levelTitle'] = 'Nível';
$webhookLang['levelDesc'] = '%1$s por %2$s'; // Name by Creator
$webhookLang['levelIDTitle'] = 'ID do Nível';
$webhookLang['difficultyTitle'] = 'Dificuldade';
$webhookLang['difficultyDesc0'] = '%1$s, %2$s estrela'; // Auto, 1 star
$webhookLang['difficultyDesc1'] = '%1$s, %2$s estrelas'; // Fácil, 2 stars
$webhookLang['difficultyDesc2'] = '%1$s, %2$s estrelas'; // Difícil, 5 stars
$webhookLang['difficultyDescMoon0'] = '%1$s, %2$s lua'; // Auto, 1 moon (Plataforma)
$webhookLang['difficultyDescMoon1'] = '%1$s, %2$s luas'; // Fácil, 2 moons (Plataforma)
$webhookLang['difficultyDescMoon2'] = '%1$s, %2$s luas'; // Difícil, 5 moons (Plataforma)
$webhookLang['statsTitle'] = 'Estatísticas';
$webhookLang['requestedTitle'] = 'Criador solicitado';
$webhookLang['requestedDesc0'] = '%1$s estrela'; // 1 star
$webhookLang['requestedDesc1'] = '%1$s estrelas'; // 2 stars
$webhookLang['requestedDesc2'] = '%1$s estrelas'; // 5 stars
$webhookLang['requestedDescMoon0'] = '%1$s lua'; // 1 moon (Plataforma)
$webhookLang['requestedDescMoon1'] = '%1$s luas'; // 2 moons (Plataforma)
$webhookLang['requestedDescMoon2'] = '%1$s luas'; // 5 moons (Plataforma)
$webhookLang['descTitle'] = 'Descrição';
$webhookLang['descDesc'] = '*Sem descrição*';
$webhookLang['footer'] = '%1$s, obrigado por jogar!';

$webhookLang['suggestTitle'] = ['Confira este nível!', 'Nível foi sugerido!', 'Alguém sugeriu um nível!'];
$webhookLang['suggestDesc'] = '%1$s sugeriu um nível para avaliar!';
$webhookLang['footerSuggest'] = '%1$s, obrigado por moderar!';

$webhookLang['demonlistTitle'] = ['Novo recorde!', 'Alguém postou novo recorde!'];
$webhookLang['demonlistDesc'] = '%1$s postou sua conclusão de %2$s! Link para aprovar: ||%3$s||';
$webhookLang['recordAuthorTitle'] = 'Autor do Recorde';
$webhookLang['recordAttemptsTitle'] = 'Tentativas';
$webhookLang['recordAttemptsDesc0'] = '%1$s tentativa'; // 1 attempt
$webhookLang['recordAttemptsDesc1'] = '%1$s tentativas'; // 2 attempts
$webhookLang['recordAttemptsDesc2'] = '%1$s tentativas'; // 5 attempts
$webhookLang['recordProofTitle'] = 'Prova';
$webhookLang['demonlistApproveTitle'] = ['Recorde foi aprovado!', 'Alguém aprovou um recorde!'];
$webhookLang['demonlistApproveTitleDM'] = ['Seu recorde foi aprovado!', 'Alguém aprovou seu recorde!'];
$webhookLang['demonlistApproveDesc'] = '%1$s aprovou o recorde de %2$s do nível %3$s!';
$webhookLang['demonlistApproveDescDM'] = '%1$s aprovou seu recorde do nível %2$s!';
$webhookLang['demonlistDenyTitle'] = ['Recorde foi negado!', 'Alguém negou um recorde!'];
$webhookLang['demonlistDenyTitleDM'] = ['Seu recorde foi negado!', 'Alguém negou seu recorde!'];
$webhookLang['demonlistDenyDesc'] = '%1$s negou o recorde de %2$s do nível %3$s!';
$webhookLang['demonlistDenyDescDM'] = '%1$s negou seu recorde do nível %2$s!';

$webhookLang['accountLinkTitle'] = ['Vinculação de Conta!', 'Alguém quer vincular a conta!'];
$webhookLang['accountLinkDesc'] = 'Parece que %1$s quer vincular sua conta do jogo à sua conta do Discord. Envie **!discord aceitar *código*** em seu perfil do jogo para fazer isso. Se não for você - **ignore** esta mensagem!';
$webhookLang['accountCodeFirst'] = 'Primeiro número';
$webhookLang['accountCodeSecond'] = 'Segundo número';
$webhookLang['accountCodeThird'] = 'Terceiro número';
$webhookLang['accountCodeFourth'] = 'Quarto número';
$webhookLang['accountUnlinkTitle'] = ['Desvinculação de Conta!', 'Você desvinculou sua conta!'];
$webhookLang['accountUnlinkDesc'] = 'Você desvinculou com sucesso %1$s de sua conta do Discord!';
$webhookLang['accountAcceptTitle'] = ['Vinculação de Conta!', 'Você vinculou sua conta!'];
$webhookLang['accountAcceptDesc'] = 'Você vinculou com sucesso %1$s à sua conta do Discord!';

$webhookLang['playerBanTitle'] = ['Jogador foi banido!', 'Alguém baniu alguém!', 'Banimento!'];
$webhookLang['playerBanTitleDM'] = ['Você foi banido!', 'Alguém baniu você!', 'Banimento!'];
$webhookLang['playerUnbanTitle'] = ['Jogador foi desbanido!', 'Alguém desbaniu alguém!', 'Desbanimento!'];
$webhookLang['playerUnbanTitleDM'] = ['Você foi desbanido!', 'Alguém desbaniu você!', 'Desbanimento!'];
$webhookLang['playerBanTopDesc'] = '%1$s baniu %2$s do topo de jogadores!';
$webhookLang['playerBanTopDescDM'] = '%1$s baniu você do topo de jogadores.';
$webhookLang['playerUnbanTopDesc'] = '%1$s desbaniu %2$s do topo de jogadores!';
$webhookLang['playerUnbanTopDescDM'] = '%1$s desbaniu você do topo de jogadores.';
$webhookLang['playerBanCreatorDesc'] = '%1$s baniu %2$s do topo de criadores!';
$webhookLang['playerBanCreatorDescDM'] = '%1$s baniu você do topo de criadores.';
$webhookLang['playerUnbanCreatorDesc'] = '%1$s desbaniu %2$s do topo de criadores!';
$webhookLang['playerUnbanCreatorDescDM'] = '%1$s desbaniu você do topo de criadores.';
$webhookLang['playerBanUploadDesc'] = '%1$s baniu %2$s de enviar níveis!';
$webhookLang['playerBanUploadDescDM'] = '%1$s baniu você de enviar níveis.';
$webhookLang['playerUnbanUploadDesc'] = '%1$s desbaniu %2$s de enviar níveis!';
$webhookLang['playerUnbanUploadDescDM'] = '%1$s desbaniu você de enviar níveis.';
$webhookLang['playerModTitle'] = 'Moderador';
$webhookLang['playerReasonTitle'] = 'Motivo';
$webhookLang['playerBanReason'] = '*Sem motivo*';
$webhookLang['footerBan'] = '%1$s.';
$webhookLang['playerBanCommentDesc'] = '%1$s baniu a capacidade de comentar de %2$s!';
$webhookLang['playerBanCommentDescDM'] = '%1$s baniu sua capacidade de comentar.';
$webhookLang['playerUnbanCommentDesc'] = '%1$s desbaniu a capacidade de comentar de %2$s!';
$webhookLang['playerUnbanCommentDescDM'] = '%1$s desbaniu sua capacidade de comentar.';
$webhookLang['playerBanAccountDesc'] = '%1$s baniu a conta de %2$s!';
$webhookLang['playerBanAccountDescDM'] = '%1$s baniu sua conta.';
$webhookLang['playerUnbanAccountDesc'] = '%1$s desbaniu a conta de %2$s!';
$webhookLang['playerUnbanAccountDescDM'] = '%1$s desbaniu sua conta.';
$webhookLang['playerExpiresTitle'] = 'Expira';
$webhookLang['playerTypeTitle'] = 'Tipo de pessoa';
$webhookLang['playerTypeName0'] = 'ID da Conta';
$webhookLang['playerTypeName1'] = 'ID de Usuário';
$webhookLang['playerTypeName2'] = 'Endereço IP';

$webhookLang['dailyTitle'] = 'Novo nível diário!';
$webhookLang['dailyTitleDM'] = 'Seu nível é diário!';
$webhookLang['dailyDesc'] = 'Este nível agora é diário!';
$webhookLang['dailyDescDM'] = 'Seu nível tornou-se diário! %1$s';
$webhookLang['weeklyTitle'] = 'Novo nível semanal!';
$webhookLang['weeklyTitleDM'] = 'Seu nível é semanal!';
$webhookLang['weeklyDesc'] = 'Este nível agora é semanal!';
$webhookLang['weeklyDescDM'] = 'Seu nível tornou-se semanal! %1$s';
$webhookLang['eventTitle'] = 'Novo nível de evento!';
$webhookLang['eventTitleDM'] = 'Seu nível é nível de evento!';
$webhookLang['eventDesc'] = 'Este nível agora é nível de evento!';
$webhookLang['eventDescDM'] = 'Seu nível foi usado em um evento! %1$s';
?>