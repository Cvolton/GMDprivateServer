<?php
/*
	Welcome to webhooks translation file!
	You're currently at Spanish (Español) language
	Credits: @Neejik / Nejik.✦
	
	If you see array instead of simple string, that means you can add as many variations of translation as you want and they will be picked randomly
*/
$webhookLang['rateSuccessTitle'] = ['Un nivel ha sido rateado', '¡Nuevo nivel rateado!', 'Alguien le dió rate a un nivel']; // This one is array
$webhookLang['rateSuccessTitleDM'] = ['¡Tu nivel ha sido rateado!', '¡Alguien le dió rate tu nivel!'];
$webhookLang['rateSuccessDesc'] = '%1$s le dió rate a un nivel'; // And this one is string
$webhookLang['rateSuccessDescDM'] = '¡%1$s le dió rate a tu nivel! %2$s';
$webhookLang['rateFailTitle'] = ['Un nivel ha sido unrateado', 'Alguien le quitó el rate a un nivel'];
$webhookLang['rateFailTitleDM'] = ['Tu nivel ha sido unrateado...', 'Alguien le quitó el rate a tu nivel...'];
$webhookLang['rateFailDesc'] = '%1$s le quitó el rate a un nivel';
$webhookLang['rateFailDescDM'] = '%1$s le quitó el rate a tu nivel %2$s...';

$webhookLang['levelTitle'] = 'Nivel';
$webhookLang['levelDesc'] = '%1$s por %2$s'; // Name by Creator
$webhookLang['levelIDTitle'] = 'ID del Nivel';
$webhookLang['difficultyTitle'] = 'Dificultad';
$webhookLang['difficultyDesc0'] = '%1$s, %2$s estrella'; // Auto, 1 star
$webhookLang['difficultyDesc1'] = '%1$s, %2$s estrellas'; // Easy, 2 stars
$webhookLang['difficultyDesc2'] = '%1$s, %2$s estrellas'; // Hard, 5 stars
$webhookLang['difficultyDescMoon0'] = '%1$s, %2$s luna'; // Auto, 1 moon (Platformer)
$webhookLang['difficultyDescMoon1'] = '%1$s, %2$s lunas'; // Easy, 2 moons (Platformer)
$webhookLang['difficultyDescMoon2'] = '%1$s, %2$s lunas'; // Hard, 5 moons (Platformer)
$webhookLang['statsTitle'] = 'Estadísticas';
$webhookLang['requestedTitle'] = 'Rate pedido';
$webhookLang['requestedDesc0'] = '%1$s estrella'; // 1 star
$webhookLang['requestedDesc1'] = '%1$s estrellas'; // 2 stars
$webhookLang['requestedDesc2'] = '%1$s estrellas'; // 5 stars
$webhookLang['requestedDescMoon0'] = '%1$s luna'; // 1 moon (Platformer)
$webhookLang['requestedDescMoon1'] = '%1$s lunas'; // 2 moons (Platformer)
$webhookLang['requestedDescMoon2'] = '%1$s lunas'; // 5 moons (Platformer)
$webhookLang['descTitle'] = 'Descripción';
$webhookLang['descDesc'] = '*Sin descripción*';
$webhookLang['footer'] = '¡Gracias por jugar, %1$s!';

$webhookLang['suggestTitle'] = ['Echa un vistazo a este nivel', 'Un nivel ha sido enviado para rate', 'Alguien envió un nivel para rate'];
$webhookLang['suggestDesc'] = '%1$s envió un nivel para rate';
$webhookLang['footerSuggest'] = '¡Gracias por moderar, %1$s!';

$webhookLang['demonlistTitle'] = ['Nuevo récord', 'Alguien envió un nuevo récord'];
$webhookLang['demonlistDesc'] = '%1$s envió su %2$s compleción. Enlace de prueba: ||%3$s||';
$webhookLang['recordAuthorTitle'] = 'Autor del récord';
$webhookLang['recordAttemptsTitle'] = 'Intentos';
$webhookLang['recordAttemptsDesc0'] = '%1$s intento'; // 1 attempt
$webhookLang['recordAttemptsDesc1'] = '%1$s intentos'; // 2 attempts
$webhookLang['recordAttemptsDesc2'] = '%1$s intentos'; // 5 attempts
$webhookLang['recordProofTitle'] = 'Prueba';
$webhookLang['demonlistApproveTitle'] = ['El récord ha sido aprobado', 'Alguien aprobó un récord'];
$webhookLang['demonlistApproveTitleDM'] = ['¡Tu récord ha sido aprobado!', '¡Alguien aprobó tu récord!'];
$webhookLang['demonlistApproveDesc'] = '%1$s aprobó el récord de %2$s del nivel %3$s';
$webhookLang['demonlistApproveDescDM'] = '¡%1$s aprobó tu récord del nivel %2$s!';
$webhookLang['demonlistDenyTitle'] = ['El récord ha sido rechazado', 'Alguien rechazó un récord'];
$webhookLang['demonlistDenyTitleDM'] = ['Tu récord ha sido rechazado...', 'Alguien rechazó tu récord...'];
$webhookLang['demonlistDenyDesc'] = '%1$s rechazó el récord de %2$s del nivel %3$s';
$webhookLang['demonlistDenyDescDM'] = '%1$s rechazó tu récord del nivel %2$s...';

$webhookLang['accountLinkTitle'] = ['Sincronización de cuenta', 'Alguien quiere sincronizar una cuenta'];
$webhookLang['accountLinkDesc'] = '%1$s quiere sincronizar su cuenta del juego a tu cuenta de Discord. Publica **!discord accept *code*** en tu perfil del juego para aceptar. Si no eres tú - **ignora** este mensaje';
$webhookLang['accountCodeFirst'] = 'Primer número';
$webhookLang['accountCodeSecond'] = 'Segundo número';
$webhookLang['accountCodeThird'] = 'Tercer número';
$webhookLang['accountCodeFourth'] = 'Cuarto número';
$webhookLang['accountUnlinkTitle'] = ['Cuenta desincronizada', 'Tu cuenta ha sido desvinculada'];
$webhookLang['accountUnlinkDesc'] = 'Has desvinculado %1$s de tu cuenta de Discord exitosamente';
$webhookLang['accountAcceptTitle'] = ['Cuenta sincronizada', 'Tu cuenta ha sido vinculada'];
$webhookLang['accountAcceptDesc'] = 'Has sincronizado %1$s a tu cuenta de Discord exitosamente';

$webhookLang['playerBanTitle'] = ['Un usuario ha sido baneado', 'Alguien ha baneado un usuario', 'Ban'];
$webhookLang['playerBanTitleDM'] = ['Has sido baneado...', 'Alguien te ha baneado...', '¡Ban!'];
$webhookLang['playerUnbanTitle'] = ['Un usuario ha sido desbaneado', 'Alguien ha desbaneado un usuario', 'Desbaneo'];
$webhookLang['playerUnbanTitleDM'] = ['¡Has sido desbaneado!', '¡Alguien te ha desbaneado!', '¡Desbaneado!'];
$webhookLang['playerBanTopDesc'] = '%1$s ha baneado a %2$s del top de jugadores';
$webhookLang['playerBanTopDescDM'] = '%1$s te ha baneado del top de jugadores...';
$webhookLang['playerUnbanTopDesc'] = '%1$s ha desbaneado a %2$s del top de jugadores';
$webhookLang['playerUnbanTopDescDM'] = '¡%1$s te ha desbaneado del top de jugadores!';
$webhookLang['playerBanCreatorDesc'] = '%1$s ha baneado a %2$s del top de creadores';
$webhookLang['playerBanCreatorDescDM'] = '%1$s te ha baneado del top de creadores...';
$webhookLang['playerUnbanCreatorDesc'] = '%1$s ha desbaneado a %2$s del top de creadores';
$webhookLang['playerUnbanCreatorDescDM'] = '¡%1$s te ha desbaneado del top de creadores!';
$webhookLang['playerBanUploadDesc'] = '%1$s ha baneado a %2$s de subir niveles';
$webhookLang['playerBanUploadDescDM'] = '%1$s te ha baneado de subir niveles...';
$webhookLang['playerUnbanUploadDesc'] = '%1$s ha desbaneado a %2$s de subir niveles';
$webhookLang['playerUnbanUploadDescDM'] = '¡%1$s te ha desbaneado de subir niveles!';
$webhookLang['playerModTitle'] = 'Moderador';
$webhookLang['playerReasonTitle'] = 'Razón';
$webhookLang['playerBanReason'] = '*Sin razón*';
$webhookLang['footerBan'] = '%1$s.';
$webhookLang['playerBanCommentDesc'] = '%1$s ha baneado a %2$s de los comentarios';
$webhookLang['playerBanCommentDescDM'] = '%1$s te ha baneado de los comentarios...';
$webhookLang['playerUnbanCommentDesc'] = '%1$s ha desbaneado a %2$s de los comentarios';
$webhookLang['playerUnbanCommentDescDM'] = '¡%1$s te ha desbaneado de los comentarios!';
$webhookLang['playerBanAccountDesc'] = '%1$s ha baneado la cuenta de %2$s';
$webhookLang['playerBanAccountDescDM'] = '%1$s ha baneado tu cuenta...';
$webhookLang['playerUnbanAccountDesc'] = '%1$s ha desbaneado la cuenta de %2$s';
$webhookLang['playerUnbanAccountDescDM'] = '¡%1$s ha desbaneado tu cuenta!';
$webhookLang['playerExpiresTitle'] = 'Expira en';
$webhookLang['playerTypeTitle'] = 'Tipo de usuario';
$webhookLang['playerTypeName0'] = 'ID de cuenta';
$webhookLang['playerTypeName1'] = 'ID de usuario';
$webhookLang['playerTypeName2'] = 'Dirección IP';

$webhookLang['dailyTitle'] = 'Nuevo Daily';
$webhookLang['dailyTitleDM'] = '¡Tu nivel es Daily!';
$webhookLang['dailyDesc'] = 'Este nivel ahora es un daily';
$webhookLang['dailyDescDM'] = '%1$s, hoy tu nivel es un daily';
$webhookLang['weeklyTitle'] = 'Nuevo Weekly';
$webhookLang['weeklyTitleDM'] = '¡Tu nivel es Weekly!';
$webhookLang['weeklyDesc'] = 'Este nivel ahora es un weekly';
$webhookLang['weeklyDescDM'] = '%1$s, esta semana tu nivel es un weekly';
$webhookLang['eventTitle'] = 'Nuevo Event';
$webhookLang['eventTitleDM'] = '¡Tu nivel es Event!';
$webhookLang['eventDesc'] = 'Este nivel ahora es un evento';
$webhookLang['eventDescDM'] = '%1$s, actualmente tu nivel es un evento';
?>