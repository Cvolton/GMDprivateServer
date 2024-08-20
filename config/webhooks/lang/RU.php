<?php
/*
	Welcome to webhooks translation file!
	You're currently at Russian (Русский) language
	Credits: *your username*
	
	If you see array instead of simple string, that means you can add as many variations of translation as you want and they will be picked randomly
*/
$webhookLang['rateSuccessTitle'] = ['Новый уровень был оценён!', 'Новый оценённый уровень!', 'Кто-то оценил уровень!']; // This one is array
$webhookLang['rateSuccessTitleDM'] = ['Ваш уровень был оценён!', 'Ваш уровень оценили!', 'Кто-то оценил ваш уровень!'];
$webhookLang['rateSuccessDesc'] = '%1$s оценил(а) уровень!'; // And this one is string
$webhookLang['rateSuccessDescDM'] = '%1$s оценил(а) ваш уровень! %2$s';
$webhookLang['rateFailTitle'] = ['С уровня сняли оценку!', 'Кто-то снял оценку с уровня!'];
$webhookLang['rateFailTitleDM'] = ['С вашего уровня сняли оценку!', 'Кто-то снял оценку с вашего уровня!'];
$webhookLang['rateFailDesc'] = '%1$s снял(а) оценку с уровня!';
$webhookLang['rateFailDescDM'] = '%1$s снял(а) оценку с вашего уровня! %2$s';

$webhookLang['levelTitle'] = 'Уровень';
$webhookLang['levelDesc'] = '%1$s от %2$s'; // Name by Creator
$webhookLang['levelIDTitle'] = 'ID уровня';
$webhookLang['difficultyTitle'] = 'Сложность';
$webhookLang['difficultyDesc0'] = '%1$s, %2$s звезда'; // Auto, 1 star
$webhookLang['difficultyDesc1'] = '%1$s, %2$s звезды'; // Easy, 2 stars
$webhookLang['difficultyDesc2'] = '%1$s, %2$s звёзд'; // Hard, 5 stars
$webhookLang['difficultyDescMoon0'] = '%1$s, %2$s луна'; // Auto, 1 moon (Platformer)
$webhookLang['difficultyDescMoon1'] = '%1$s, %2$s луны'; // Easy, 2 moons (Platformer)
$webhookLang['difficultyDescMoon2'] = '%1$s, %2$s лун'; // Hard, 5 moons (Platformer)
$webhookLang['statsTitle'] = 'Статистика';
$webhookLang['requestedTitle'] = 'Автор запросил';
$webhookLang['requestedDesc0'] = '%1$s звезда'; // 1 star
$webhookLang['requestedDesc1'] = '%1$s звезды'; // 2 stars
$webhookLang['requestedDesc2'] = '%1$s звёзд'; // 5 stars
$webhookLang['requestedDescMoon0'] = '%1$s луна'; // 1 moon (Platformer)
$webhookLang['requestedDescMoon1'] = '%1$s луны'; // 2 moons (Platformer)
$webhookLang['requestedDescMoon2'] = '%1$s лун'; // 5 moons (Platformer)
$webhookLang['descTitle'] = 'Описание';
$webhookLang['descDesc'] = '*Нет описания*';
$webhookLang['footer'] = '%1$s, приятной игры!';

$webhookLang['suggestTitle'] = ['Проверьте уровень!', 'Уровень был отправлен на оценку!', 'Кто-то отправил уровень на оценку!'];
$webhookLang['suggestDesc'] = '%1$s отправил(а) уровень на оценку!';
$webhookLang['footerSuggest'] = '%1$s, приятного модерирования!';

$webhookLang['demonlistTitle'] = ['Новый рекорд!', 'Кто-то опубликовал свой рекорд!'];
$webhookLang['demonlistDesc'] = '%1$s опубликовал(а) своё прохождение на уровень %2$s! Ссылка для подтверждения: ||%3$s||';
$webhookLang['recordAuthorTitle'] = 'Автор рекорда';
$webhookLang['recordAttemptsTitle'] = 'Попытки';
$webhookLang['recordAttemptsDesc0'] = '%1$s попытка'; // 1 attempt
$webhookLang['recordAttemptsDesc1'] = '%1$s попытки'; // 2 attempts
$webhookLang['recordAttemptsDesc2'] = '%1$s попыток'; // 5 attempts
$webhookLang['recordProofTitle'] = 'Доказательство';
$webhookLang['demonlistApproveTitle'] = ['Рекорд был подтверждён!', 'Кто-то подтвердил рекорд!'];
$webhookLang['demonlistApproveTitleDM'] = ['Ваш рекорд был подтверждён!', 'Кто-то подтвердил ваш рекорд!'];
$webhookLang['demonlistApproveDesc'] = '%1$s подтвердил(а) рекорд %2$s на уровень %3$s!';
$webhookLang['demonlistApproveDescDM'] = '%1$s подтвердил(а) ваш рекорд на уровень %2$s!';
$webhookLang['demonlistDenyTitle'] = ['Рекорд был отклонён!', 'Кто-то отклонил рекорд!'];
$webhookLang['demonlistDenyTitleDM'] = ['Ваш рекорд был отклонён!', 'Кто-то отклонил ваш рекорд!'];
$webhookLang['demonlistDenyDesc'] = '%1$s отклонил(а) рекорд %2$s на уровень %3$s!';
$webhookLang['demonlistDenyDescDM'] = '%1$s отклонил(а) ваш рекорд на уровень %2$s!';

$webhookLang['accountLinkTitle'] = ['Привязка аккаунта!', 'Кто-то хочет привязать аккаунт!'];
$webhookLang['accountLinkDesc'] = 'Кажется, что %1$s решил(а) привязать свой игровой аккаунт к вашему Discord аккаунту. Напишите **!discord accept *код*** ниже в сообщения своего профиля, чтобы сделать это. Если это не вы - **игнорируйте** данное сообщение!';
$webhookLang['accountCodeFirst'] = 'Первое число';
$webhookLang['accountCodeSecond'] = 'Второе число';
$webhookLang['accountCodeThird'] = 'Третье число';
$webhookLang['accountCodeFourth'] = 'Четвёртое число';
$webhookLang['accountUnlinkTitle'] = ['Отвязка аккаунта!', 'Вы отвязали аккаунт!'];
$webhookLang['accountUnlinkDesc'] = 'Вы успешно отвязали аккаунт %1$s от вашего Discord аккаунта!';
$webhookLang['accountAcceptTitle'] = ['Привязка аккаунта!', 'Вы привязали аккаунт!'];
$webhookLang['accountAcceptDesc'] = 'Вы успешно привязали аккаунт %1$s к вашему Discord аккаунту!';

$webhookLang['playerBanTitle'] = ['Игрок был забанен!', 'Кто-то забанил кого-то!', 'Бан!'];
$webhookLang['playerBanTitleDM'] = ['Вы были забанены!', 'Кто-то забанил вас!', 'Бан!'];
$webhookLang['playerUnbanTitle'] = ['Игрок был разбанен!', 'Кто-то разбанил кого-то!', 'Разбан!'];
$webhookLang['playerUnbanTitleDM'] = ['Вы были разбанены!', 'Кто-то разбанил вас!', 'Разбан!'];
$webhookLang['playerBanTopDesc'] = '%1$s заблокировал(а) %2$s в топе игроков!';
$webhookLang['playerBanTopDescDM'] = '%1$s заблокировал(а) вас в топе игроков.';
$webhookLang['playerUnbanTopDesc'] = '%1$s разблокировал(а) %2$s в топе игроков!';
$webhookLang['playerUnbanTopDescDM'] = '%1$s разблокировал(а) вас в топе игроков!';
$webhookLang['playerBanCreatorDesc'] = '%1$s заблокировал(а) %2$s в топе строителей!';
$webhookLang['playerBanCreatorDescDM'] = '%1$s заблокировал(а) вас в топе строителей.';
$webhookLang['playerUnbanCreatorDesc'] = '%1$s разблокировал(а) %2$s в топе строителей!';
$webhookLang['playerUnbanCreatorDescDM'] = '%1$s разблокировал(а) вас в топе строителей!';
$webhookLang['playerBanUploadDesc'] = '%1$s заблокировал(а) %2$s возможность выкладывания уровней!';
$webhookLang['playerBanUploadDescDM'] = '%1$s заблокировал(а) вам возможность выкладывания уровней.';
$webhookLang['playerUnbanUploadDesc'] = '%1$s разблокировал(а) %2$s возможность выкладывания уровней!';
$webhookLang['playerUnbanUploadDescDM'] = '%1$s разблокировал(а) вам возможность выкладывания уровней!';
$webhookLang['playerModTitle'] = 'Модератор';
$webhookLang['playerReasonTitle'] = 'Причина';
$webhookLang['playerBanReason'] = '*Без причины*';
$webhookLang['footerBan'] = '%1$s.';
$webhookLang['playerBanCommentDesc'] = '%1$s заблокировал(а) %2$s возможность комментирования!';
$webhookLang['playerBanCommentDescDM'] = '%1$s заблокировал(а) вам возможность комментирования.';
$webhookLang['playerUnbanCommentDesc'] = '%1$s разблокировал(а) %2$s возможность комментирования!';
$webhookLang['playerUnbanCommentDescDM'] = '%1$s разблокировал(а) вам возможность комментирования!';
$webhookLang['playerBanAccountDesc'] = '%1$s заблокировал(а) %2$s аккаунт!';
$webhookLang['playerBanAccountDescDM'] = '%1$s заблокировал(а) вам аккаунт.';
$webhookLang['playerUnbanAccountDesc'] = '%1$s разблокировал(а) %2$s аккаунт!';
$webhookLang['playerUnbanAccountDescDM'] = '%1$s разблокировал(а) вам аккаунт!';
$webhookLang['playerExpiresTitle'] = 'Истекает';
$webhookLang['playerTypeTitle'] = 'Тип пользователя';
$webhookLang['playerTypeName0'] = 'ID аккаунта';
$webhookLang['playerTypeName1'] = 'ID игрока';
$webhookLang['playerTypeName2'] = 'IP адрес';

$webhookLang['dailyTitle'] = 'Новый ежедневный уровень!';
$webhookLang['dailyTitleDM'] = 'Ваш уровень — ежедневный!';
$webhookLang['dailyDesc'] = 'Уровень попал в ежедневные уровни!';
$webhookLang['dailyDescDM'] = 'Ваш уровень попал в ежедневные уровни! %1$s';
$webhookLang['weeklyTitle'] = 'Новый еженедельный уровень!';
$webhookLang['weeklyTitleDM'] = 'Ваш уровень — еженедельный!';
$webhookLang['weeklyDesc'] = 'Уровень попал в еженедельные уровни!';
$webhookLang['weeklyDescDM'] = 'Ваш уровень попал в еженедельные уровни! %1$s';
$webhookLang['eventTitle'] = 'Новый уровень мероприятия!';
$webhookLang['eventTitleDM'] = 'Ваш уровень попал в мероприятие!';
$webhookLang['eventDesc'] = 'Уровень попал в уровни мероприятий!';
$webhookLang['eventDescDM'] = 'Ваш уровень попал в уровни мероприятий! %1$s';
?>