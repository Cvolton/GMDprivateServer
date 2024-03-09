<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Домой";
$string["welcome"] = "Добро пожаловать на ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Внимание!</b> Вы не до конца установили панель сервера! Нажмите на текст, чтобы это сделать.</div>";
$string["levelsWeek"] = "Выложено уровней за неделю";
$string["levels3Months"] = "Выложено уровней за 3 месяца";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Добро пожаловать в панель сервера! Мы даём вам несколько подсказок после установки:<br>
1. Кажется, в SQL в таблице 'roles' появились новые права! Вам следует это проверить...<br>
2. Если вы поместите icon.png в папку 'dashboard', то слева сверху появится иконка вашего сервера!<br>
3. Нужно настроить config/dashboard.php, без этого никак!";
$string["wwygdt"] = "Чем вы сегодня будете заниматься?";
$string["game"] = "Игра";
$string["guest"] = "гость";
$string["account"] = "Аккаунт";
$string["levelsOptDesc"] = "Посмотреть список уровней";
$string["songsOptDesc"] = "Посмотреть список песен";
$string["yourClanOptDesc"] = "Посмотреть клан \"%s\"";
$string["clanOptDesc"] = "Посмотреть список кланов";
$string["yourProfile"] = "Ваш профиль";
$string["profileOptDesc"] = "Посмотреть ваш профиль";
$string["messengerOptDesc"] = "Зайти в мессенджер";
$string["addSongOptDesc"] = "Добавить песню на сервер";
$string["loginOptDesc"] = "Войти в аккаунт";
$string["createAcc"] = "Создать аккаунт";
$string["registerOptDesc"] = "Зарегистрироваться на %s";
$string["downloadOptDesc"] = "Скачать %s";

$string["tryCron"] = "Выполнить Cron";
$string["cronSuccess"] = "Готово!";
$string["cronError"] = "Ошибка!";

$string["profile"] = "Профиль";
$string["empty"] = "Пустовато...";
$string["writeSomething"] = "Напишите что-нибудь!";
$string["replies"] = "Ответы";
$string["replyToComment"] = "Ответ на комментарий";
$string["settings"] = "Настройки";
$string["allowMessagesFrom"] = "Разрешать сообщения от...";
$string["allowFriendReqsFrom"] = "Разрешать заявки в друзья от...";
$string["showCommentHistory"] = "Показывать историю комментариев...";
$string["yourYouTube"] = "Ваш канал на YouTube";
$string["yourVK"] = "Ваша страница во ВКонтакте";
$string["yourTwitter"] = "Ваша страница в Twitter";
$string["yourTwitch"] = "Ваш канал на Twitch";
$string["saveSettings"] = "Сохранить настройки";
$string["all"] = "Все";
$string["friends"] = "Друзья";
$string["none"] = "Никто";
$string["youBlocked"] = "Этот игрок вас заблокировал!";
$string["cantMessage"] = "Вы не можете написать этому игроку!";

$string["accountManagement"] = "Управление аккаунтом";
$string["changePassword"] = "Сменить пароль";
$string["changeUsername"] = "Сменить никнейм";
$string["unlistedLevels"] = "Ваши скрытые уровни";

$string["manageSongs"] = "Управление песнями";
$string["gauntletManage"] = "Управление Гаунтлетами";
$string["suggestLevels"] = "Предложенные уровни";

$string["modTools"] = "Инструменты модератора";
$string["leaderboardBan"] = "Забанить пользователя";
$string["unlistedMod"] = "Cкрытые уровни";

$string["reuploadSection"] = "Загрузка на сервер";
$string["songAdd"] = "Добавить песню";
$string["songLink"] = "Добавить песню по ссылке";
$string["packManage"] = "Управление Мап-Паками";

$string["browse"] = "Просмотр";
$string["statsSection"] = "Статистика";
$string["dailyTable"] = "Ежедневные уровни";
$string["modActionsList"] = "Действия модераторов";
$string["modActions"] = "Список модераторов";
$string["gauntletTable"] = "Гаунтлеты";
$string["packTable"] = "Мап-Паки";
$string["leaderboardTime"] = "Таблица лидеров за 24 часа";

$string["download"] = "Скачать";
$string["forwindows"] = "Для Windows";
$string["forandroid"] = "Для Android";
$string["formac"] = "Для Mac";
$string["forios"] = "Для iOS";
$string["third-party"] = "Сторонние ресурсы";
$string["thanks"] = "Спасибо этим людям!";
$string["language"] = "Язык";

$string["loginHeader"] = "Здравствуй, %s!";
$string["logout"] = "Выйти";
$string["login"] = "Войти";
$string["wrongNickOrPass"] = "Неверный никнейм или пароль!";
$string["invalidid"] = "Неверный ID!";
$string["loginBox"] = "Вход в аккаунт";
$string["loginSuccess"] = "Вы успешно вошли в аккаунт!";
$string["loginAlready"] = "Вы уже вошли в аккаунт!";
$string["clickHere"] = "Панель сервера";
$string["enterUsername"] = "Введите ваш никнейм";
$string["enterPassword"] = "Введите ваш пароль";
$string["loginDesc"] = "Здесь вы можете войти в ваш аккаунт!";

$string["register"] = "Зарегистрироваться";
$string["registerAcc"] = "Регистрация аккаунта";
$string["registerDesc"] = "Зарегистрируйте свой аккаунт!";
$string["repeatpassword"] = "Повторите пароль";
$string["email"] = "Почта";
$string["repeatemail"] = "Повторите почту";
$string["smallNick"] = "Никнейм слишком короткий!";
$string["smallPass"] = "Пароль слишком короткий!";
$string["passDontMatch"] = "Пароли не совпадают!";
$string["emailDontMatch"] = "Почты не совпадают!";
$string["registered"] = "Вы успешно зарегистрировали аккаунт!";
$string["bigNick"] = "Никнейм слишком длинный!";
$string["mailExists"] = "На этой почте уже зарегистрирован аккаунт!";

$string["changePassTitle"] = "Смена пароля";
$string["changedPass"] = "Пароль успешно сменён! Вам нужно заново войти в ваш аккаунт.";
$string["wrongPass"] = "Неверный пароль!";
$string["samePass"] = "Введённые вами пароли одинаковые!";
$string["changePassDesc"] = "Здесь вы можете сменить свой пароль!";
$string["oldPassword"] = "Старый пароль";
$string["newPassword"] = "Новый пароль";
$string["confirmNew"] = "Подтверждение пароля";

$string["forcePassword"] = "Принудительно сменить пароль";
$string["forcePasswordDesc"] = "Здесь вы можете принудительно сменить пароль игроку!";
$string["forceNick"] = "Принудительно сменить никнейм";
$string["forceNickDesc"] = "Здесь вы можете принудительно сменить никнейм игроку!";
$string["forceChangedPass"] = "Пароль игрока <b>%s</b> успешно сменён!";
$string["forceChangedNick"] = "Никнейм игрока <b>%s</b> успешно сменён!";
$string["changePassOrNick"] = "Сменить никнейм или пароль игроку";

$string["changeNickTitle"] = "Смена никнейма";
$string["changedNick"] = "Никнейм успешно сменён! Вам нужно заново войти в ваш аккаунт.";
$string["wrongNick"] = "Неверный никнейм!";
$string["sameNick"] = "Введённые вами никнеймы одинаковые!";
$string["alreadyUsedNick"] = "Введённый вами никнейм уже занят!";
$string["changeNickDesc"] = "Здесь вы можете сменить свой никнейм!";
$string["oldNick"] = "Старый никнейм";
$string["newNick"] = "Новый никнейм";
$string["password"] = "Пароль";

$string["packCreate"] = "Создать Мап-Пак";
$string["packCreateTitle"] = "Создание Мап-Пака";
$string["packCreateDesc"] = "Здесь вы можете создать Мап-Пак!";
$string["packCreateSuccess"] = "Вы успешно создали Мап-Пак под названием";
$string["packCreateOneMore"] = "Ещё один Мап-Пак?";
$string["packName"] = "Название Мап-Пака";
$string["color"] = "Цвет";
$string["sameLevels"] = "Вы выбрали одинаковые уровни!";
$string["show"] = "Показать";
$string["packChange"] = "Изменить Мап-Пак";
$string["createNewPack"] = "Создайте новый Мап-Пак!";

$string["gauntletCreate"] = "Создать Гаунтлет";
$string["gauntletCreateTitle"] = "Создание Гаунтлета";
$string["gauntletCreateDesc"] = "Здесь вы можете создать Гаунтлет!";
$string["gauntletCreateSuccess"] = "Вы успешно создали Гаунтлет!";
$string["gauntletCreateOneMore"] = "Ещё один Гаунтлет?";
$string["chooseLevels"] = "Выберите уровни!";
$string["checkbox"] = "Подтвердить";
$string["level1"] = "1-ый уровень";
$string["level2"] = "2-ой уровень";
$string["level3"] = "3-ий уровень";
$string["level4"] = "4-ый уровень";
$string["level5"] = "5-ый уровень";
$string["gauntletChange"] = "Изменить Гаунтлет";
$string["createNewGauntlet"] = "Создайте новый Гаунтлет!";
$string["gauntletCreateSuccessNew"] = 'Вы успешно создали <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Выбрать Гаунтлет автоматически";

$string["addQuest"] = "Добавить квест";
$string["addQuestDesc"] = "Здесь вы можете создать квест!";
$string["questName"] = "Название квеста";
$string["questAmount"] = "Необходимое кол-во";
$string["questReward"] = "Награда";
$string["questCreate"] = "Создать квест";
$string["questsSuccess"] = "Вы успешно создали квест";
$string["invalidPost"] = "Неверные данные!";
$string["fewMoreQuests"] = "Советуем вам создать ещё несколько квестов.";
$string["oneMoreQuest?"] = "Ещё один квест?";
$string["changeQuest"] = "Изменить квест";
$string["createNewQuest"] = "Создайте новый квест!";

$string["levelReupload"] = "Перенести уровень";
$string["levelReuploadDesc"] = "Здесь вы можете перенести свой уровень с любого сервера!";
$string["advanced"] = "Дополнительные параметры";
$string["errorConnection"] = "Ошибка соединения с сервером!";
$string["levelNotFound"] = "Такой уровень не найден!";
$string["robtopLol"] = "RobTop тебя не любит :с";
$string["sameServers"] = "Выбранные вами сервера одинаковые!";
$string["levelReuploaded"] = "Уровень перенесён! ID уровня:";
$string["oneMoreLevel?"] = "Ещё один уровень?";
$string["levelAlreadyReuploaded"] = "Уровень уже перенесён!";
$string["server"] = "Сервер";
$string["levelID"] = "ID уровня";
$string["pageDisabled"] = "Эта страница отключена!";

$string["activateAccount"] = "Активация аккаунта";
$string["activateDesc"] = "Активируйте свой аккаунт!";
$string["activated"] = "Ваш аккаунт успешно активирован!";
$string["alreadyActivated"] = "Ваш аккаунт уже активирован!";
$string["maybeActivate"] = "Возможно, вы не активировали свой аккаунт.";
$string["activate"] = "Активировать";
$string["activateDisabled"] = "Активация аккаунта не требуется!";

$string["addMod"] = "Выдать модератора";
$string["addModDesc"] = "Здесь вы можете сделать модератором игрока!";
$string["modYourself"] = "Нельзя назначить себя модератором!";
$string["alreadyMod"] = "Этот игрок уже является модератором!";
$string["addedMod"] = "Вы успешно сделали модератором игрока";
$string["addModOneMore"] = "Ещё один модератор?";
$string["modAboveYourRole"] = "Вы пытаетесь выдать игроку роль выше вашей!";
$string["makeNewMod"] = "Назначьте кого-нибудь модератором!";
$string["reassignMod"] = "Переназначить модератора";
$string["reassign"] = "Переназначить";
$string['demotePlayer'] = "Снять игрока с поста модератора";
$string['demotedPlayer'] = "Вы успешно сняли игрока <b>%s</b> с поста модератора!";
$string['addedModNew'] = "Вы успешно сделали модератором игрока <b>%s</b>!";
$string['demoted'] = 'Снят';

$string["shareCPTitle"] = "Поделиться Креатор Поинтами";
$string["shareCPDesc"] = "Здесь вы можете поделиться Креатор Поинтами c игроком!";
$string["shareCP"] = "Поделиться";
$string["alreadyShared"] = "Этот уровень уже делился Креатор Поинтами с этим игроком!";
$string["shareToAuthor"] = "Вы пытаетесь поделиться Креатор Поинтами с автором этого уровня!";
$string["userIsBanned"] = "Этот игрок заблокирован!";
$string["shareCPSuccess"] = "Вы успешно поделились Креатор Поинтами уровня";
$string["shareCPSuccess2"] = "c игроком";
$string["updateCron"] = "Возможно, вам следует обновить Креатор Поинты.";
$string["shareCPOneMore"] = "Ещё поделиться?";
$string['shareCPSuccessNew'] = 'Вы успешно поделились Креатор Поинтами уровня <b>%1$s</b> с игроком <b>%2$s</b>!';

$string["messenger"] = "Мессенджер";
$string["write"] = "Написать";
$string["send"] = "Отправить";
$string["noMsgs"] = "Начните диалог!";
$string["subject"] = "Тема";
$string["msg"] = "Сообщение";
$string["tooFast"] = "Вы слишком быстро печатаете!";

$string["levelToGD"] = "Перенести уровень на другой сервер";
$string["levelToGDDesc"] = "Здесь вы можете перенести свой уровень на другой сервер!";
$string["usernameTarget"] = "Никнейм для выбранного сервера";
$string["passwordTarget"] = "Пароль для выбранного сервера";
$string["notYourLevel"] = "Это не ваш уровень!";
$string["reuploadFailed"] = "Ошибка переноса уровня!";

$string["search"] = "Поиск...";
$string["searchCancel"] = "Отменить поиск";
$string["emptySearch"] = "Ничего не найдено!";

$string["demonlist"] = 'Топ демонов';
$string["demonlistRecord"] = 'Рекорд <b>%s</b>';
$string["alreadyApproved"] = 'Уже принят!';
$string["alreadyDenied"] = 'Уже отклонён!';
$string["approveSuccess"] = 'Вы успешно приняли рекорд <b>%s</b>!';
$string["denySuccess"] = 'Вы успешно отклонили рекорд <b>%s</b>!';
$string["recordParameters"] = '<b>%s</b> прошёл <b>%s</b> за <b>%d</b> попыток';
$string["approve"] = 'Принять';
$string["deny"] = 'Отклонить';
$string["submitRecord"] = 'Опубликовать рекорд';
$string["submitRecordForLevel"] = 'Опубликовать рекорд для <b>%s</b>';
$string["alreadySubmitted"] = 'Вы уже публиковали рекорд для <b>%s</b>!';
$string["submitSuccess"] = 'Вы успешно опубликовали рекорд для <b>%s</b>!';
$string["submitRecordDesc"] = 'Публикуйте свои рекорды только если вы прошли уровень!';
$string["atts"] = 'Попытки';
$string["ytlink"] = 'ID видео на YouTube (dQw4w9WgXcQ)';
$string["submit"] = 'Опубликовать';
$string["addDemonTitle"] = 'Добавить демон';
$string["addDemon"] = 'Добавить демон в топ демонов';
$string["addedDemon"] = 'Вы добавили <b>%s</b> на <b>%d</b> место!';
$string["addDemonDesc"] = 'Здесь вы можете добавить демон в демонлист!';
$string["place"] = 'Место';
$string["giveablePoints"] = 'Выдаваемые очки';
$string["add"] = 'Добавить';
$string["recordApproved"] = 'Рекорд подтверждён!';
$string["recordDenied"] = 'Рекорд отклонён!';
$string["recordSubmitted"] = 'Рекорд опубликован!';
$string["nooneBeat"] = 'никто не прошёл'; //let it be lowercase
$string["oneBeat"] = 'прошёл 1 игрок'; 
$string["lower5Beat"] = 'прошло %d игрока'; 
$string["above5Beat"] = 'прошло %d игроков'; 
$string["demonlistLevel"] = '%s <text class="dltext">от <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button></text>';
$string["noDemons"] = 'Кажется, в вашем топе демонов нет ни одного демона...';
$string["addSomeDemons"] = 'Добавьте несколько демонов, чтобы заполнить топ!';
$string["askForDemons"] = 'Попросите администратора сервера добавить несколько!';
$string["recordList"] = 'Список рекордов';
$string["status"] = 'Статус';
$string["checkRecord"] = 'Проверить рекорд';
$string["record"] = 'Рекорд';
$string["recordDeleted"] = 'Рекорд был удалён!';
$string["changeDemon"] = 'Изменить демон';
$string["demonDeleted"] = 'Демон был удалён!';
$string["changedDemon"] = 'Вы переставили <b>%s</b> на <b>%d</b> место!';
$string["changeDemonDesc"] = 'Здесь вы можете изменить демон в демонлисте!<br>
Если вы хотите удалить демон, укажите 0 место.';

$string["didntActivatedEmail"] = 'Вы не подтвердили вашу почту!';
$string["checkMail"] = 'Вам следует проверить ваш почтовый ящик...';

$string["likeSong"] = "Добавить песню в любимые";
$string["dislikeSong"] = "Убрать песню из любимых";
$string["favouriteSongs"] = "Любимые песни";
$string["howMuchLiked"] = "Сколько лайкнуло?";
$string["nooneLiked"] = "Никто не лайкнул";

$string["clan"] = "Клан";
$string["joinedAt"] = "Вступил(а) в клан: <b>%s</b>";
$string["createdAt"] = "Создал(а) клан: <b>%s</b>";
$string["clanMembers"] = "Участники клана";
$string["noMembers"] = "Участников нет";
$string["clanOwner"] = "Создатель клана";
$string["noClanDesc"] = "<i>У клана нет описания</i>";
$string["noClan"] = "Такого клана не существует!";
$string["clanName"] = "Название клана";
$string["clanDesc"] = "Описание клана";
$string["clanColor"] = "Цвет клана";
$string["dangerZone"] = "Опасная зона";
$string["giveClan"] = "Передать клан";
$string["deleteClan"] = "Удалить клан";
$string["goBack"] = "Вернуться назад";
$string["areYouSure"] = "Вы уверены?";
$string["giveClanDesc"] = "Здесь вы можете передать клан другому игроку.";
$string["notInYourClan"] = "Этот игрок не состоит в вашем клане!";
$string["givedClan"] = "Вы успешно передали клан игроку <b>%s</b>!";
$string["deletedClan"] = "Вы удалили клан <b>%s</b>.";
$string["deleteClanDesc"] = "Здесь вы можете удалить ваш клан.";
$string["yourClan"] = "Ваш клан";
$string["members0"] = "<b>1</b> участник";
$string["members1"] = "<b>%d</b> участникa"; 
$string["members2"] = "<b>%d</b> участников"; 
$string["noRequests"] = "Заявок нет. Отдыхаем!";
$string["pendingRequests"] = "Заявки в клан";
$string["closedClan"] = "Закрытый клан";
$string["kickMember"] = "Выгнать участника";
$string["leaveFromClan"] = "Выйти из клана";
$string["askToJoin"] = "Отправить заявку в клан";
$string["removeClanRequest"] = "Удалить заявку в клан";
$string["joinClan"] = "Присоединиться к клану";
$string["noClans"] = "Пока кланов нет";
$string["clans"] = "Кланы";
$string["alreadyInClan"] = "Вы уже в клане!";
$string["createClan"] = "Создать клан";
$string["createdClan"] = "Вы успешно создали клан <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Здесь вы можете создать клан!";
$string["create"] = "Создать";
$string["mainSettings"] = "Основные настройки";
$string["takenClanName"] = "Данное название клана уже занято!";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> предложил оценить </text><text class="levelname">%2$s</text><text class="dltext"> на <b>%4$s%3$s</b></text>';
$string["reportedName"] = '%1$s<text class="dltext"> зарепортили</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Списки уровней";
$string['listTableMod'] = "Скрытые списки уровней";
$string['listTableYour'] = "Ваши cкрытые списки уровней";

$string['forgotPasswordChangeTitle'] = "Изменить пароль";
$string["successfullyChangedPass"] = "Пароль успешно сменён!";
$string['forgotPasswordTitle'] = "Забыли пароль?";
$string['maybeSentAMessage'] = "Мы отправим вам сообщение на почту, если данный аккаунт существует.";
$string['forgotPasswordDesc'] = "Здесь вы можете запросить ссылку на изменение пароля, если его забыли!";
$string['forgotPasswordButton'] = "Запросить ссылку";

$string['sfxAdd'] = "Добавить звуковой эффект";
$string["sfxAddError-5"] = "Звуковой эффект весит больше $SFXsize мегабайт!";
$string["sfxAddError-6"] = "Что-то случилось при загрузке звукового эффекта!";
$string["sfxAddError-7"] = "Загружать можно только аудиофайлы!";
$string['sfxAdded'] = 'Звуковой эффект загружен';
$string['yourNewSFX'] = "Взгляните на ваш новоиспечённый звуковой эффект!";
$string["sfxAddAnotherBTN"] = "Ещё один эффектик?";
$string["sfxAddDesc"] = "Здесь вы можете добавить звуковой эффект на сервер!";
$string["chooseSFX"] = "Выберите звуковой эффект";
$string["sfxAddNameFieldPlaceholder"] = "Название звукового эффекта";
$string['sfxs'] = 'Звуковые эффекты';
$string['sfxID'] = 'ID звукового эффекта';
$string['manageSFX'] = 'Управление звуковыми эффектами';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Загрузить";
$string["errorGeneric"] = "Произошла ошибка!";
$string["smthWentWrong"] = "Что-то пошло не так!";
$string["tryAgainBTN"] = "Попробуйте ещё раз";
//songAdd.php
$string["songAddDesc"] = "Здесь вы можете добавить свою песню!";
$string["songAddUrlFieldLabel"] = "Ссылка на песню. (Прямая, Dropbox. YouTube не работает)";
$string["songAddUrlFieldPlaceholder"] = "Ссылка на песню";
$string["songAddNameFieldPlaceholder"] = "Название песни";
$string["songAddAuthorFieldPlaceholder"] = "Автор песни";
$string["songAddButton"] = "Выбрать песню";
$string["songAddAnotherBTN"] = "Ещё одну песню?";
$string["songAdded"] = "Песня загружена";
$string["songID"] = "ID вашей песни: ";
$string["songIDw"] = "ID песни";
$string["songAuthor"] = "Автор";
$string["deletedSong"] = "Вы успешно удалили песню";
$string["renamedSong"] = "Вы успешно переименовали песню в";
$string["size"] = "Размер";
$string["delete"] = "Удалить";
$string["change"] = "Изменить";
$string["chooseFile"] = "Выберите песню";
$string['yourNewSong'] = "Взгляните на вашу новоиспечённую песню!";
///errors
$string["songAddError-2"] = "Неправильный URL (возможно, ссылка не прямая).";
$string["songAddError-3"] = "Песня уже загружена под ID:";
$string["songAddError-4"] = "Эту песню нельзя загрузить :с";
$string["songAddError-5"] = "Песня весит больше $songSize мегабайт!";
$string["songAddError-6"] = "Что-то случилось при загрузке песни! :с";
$string["songAddError-7"] = "Загружать можно только аудиофайлы!";

$string[400] = "Плохой запрос!";
$string["400!"] = "Проверьте драйвера вашего сетевого оборудования.";
$string[403] = "Доступ запрещён!";
$string["403!"] = "У вас нет прав на просмотр данной страницы.";
$string[404] = "Страница не найдена!";
$string["404!"] = "Вы уверены, что вы правильно написали адрес страницы?";
$string[500] = "Внутренняя ошибка сервера!";
$string["500!"] = "Кодер допустил ошибку при написании данной страницы,</br>
сообщите ему об этом здесь:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Сервер лёг!";
$string["502!"] = "Сейчас нагрузка на сервер слишком большая, хостинг не может справиться с ней.</br>
Попробуйте зайти сюда через несколько часов!";

$string["invalidCaptcha"] = "Неверный ответ от капчи!";
$string["page"] = "Страница";
$string["emptyPage"] = "Эта страница пуста!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Орбы";
$string["stars"] = "Звёзды";
$string["coins"] = "Монеты";
$string["accounts"] = "Аккаунты";
$string["levels"] = "Уровни";
$string["songs"] = "Песни";
$string["author"] = "Автор";
$string["name"] = "Название";
$string["date"] = "Дата";
$string["type"] = "Тип";
$string["reportCount"] = "Количество репортов";
$string["reportMod"] = "Репорты";
$string["username"] = "Никнейм";
$string["accountID"] = "ID аккаунта";
$string["registerDate"] = "Дата регистрации";
$string["levelAuthor"] = "Автор уровня";
$string["isAdmin"] = "Роль на сервере";
$string["isAdminYes"] = "Да";
$string["isAdminNo"] = "Нет";
$string["userCoins"] = "Пользовательские монеты";
$string["time"] = "Время";
$string["deletedLevel"] = "Удалённый уровень";
$string["mod"] = "Модератор";
$string["count"] = "Количество действий";
$string["ratedLevels"] = "Оценённые уровни";
$string["lastSeen"] = "Последний раз был онлайн";
$string["level"] = "Уровень";
$string["pageInfo"] = "Страница %s из %s";
$string["first"] = "Первая страница";
$string["previous"] = "Назад";
$string["next"] = "Вперёд";
$string["never"] = "Никогда";
$string["last"] = "Последняя страница";
$string["go"] = "Вперёд";
$string["levelid"] = "ID уровня";
$string["levelname"] = "Название уровня";
$string["leveldesc"] = "Описание уровня";
$string["noDesc"] = "Без описания";
$string["levelpass"] = "Пароль";
$string["nopass"] = "Без пароля";
$string["unrated"] = "Не оценён";
$string["rate"] = "Оценка";
$string["stats"] = "Статистика";
$string["suggestFeatured"] = "Featured?";
$string["whoAdded"] = "Кто добавил?";
//modActionsList
$string["banDesc"] = "Здесь вы можете забанить игрока из лидерборда!";
$string["playerTop"] = 'Топ игроков';
$string["creatorTop"] = 'Топ строителей';

$string["admin"] = "Администратор";
$string["elder"] = "Старший модератор";
$string["moder"] = "Модератор";
$string["player"] = "Игрок";

$string["starsLevel2"] = "звёзд";
$string["starsLevel1"] = "звезды";
$string["starsLevel0"] = "звезда";
$string["coins2"] = "монет";
$string["coins1"] = "монеты";
$string["coins0"] = "монета";
$string["time0"] = "раз";
$string["time1"] = "раза";
$string["times"] = "раз";
$string["action0"] = "действие";
$string["action1"] = "действия";
$string["action2"] = "действий";
$string["lvl0"] = "уровень";
$string["lvl1"] = "уровня";
$string["lvl2"] = "уровней";
$string["player0"] = "игрок";
$string["player1"] = "игрока";
$string["player2"] = "игроков";
$string["unban"] = "Разбан";
$string["isBan"] = "Бан";

$string["noCoins"] = "Без монет";
$string["noReason"] = "Нет причины";
$string["noActions"] = "Нет действий";
$string["noRates"] = "Нет оценок";

$string["future"] = "Будущее";

$string["spoiler"] = "Спойлер";
$string["accid"] = "с ID аккаунта";
$string["banned"] = "был успешно забанен!";
$string["unbanned"] = "был успешно разбанен!";
$string["nothingFound"] = "Такой пользователь не найден!";
$string["ban"] = "Забанить";
$string["banUserID"] = "Никнейм или ID игрока";
$string["banUserPlace"] = "Забанить пользователя";
$string["banYourself"] = "Вы не можете забанить себя!"; 
$string["banYourSelfBtn!"] = "Забанить кого-то другого";
$string["banReason"] = "Причина блокировки";
$string["action"] = "Действие";
$string["value"] = "1 значение";
$string["value2"] = "2 значение";
$string["value3"] = "3 значение";
$string["modAction1"] = "Оценил(а) уровень";
$string["modAction2"] = "Снял(а)/добавил(а) Featured уровню";
$string["modAction3"] = "Снял(а)/добавил(а) монеты уровню";
$string["modAction4"] = "Снял(а)/добавил(а) Epic уровню";
$string["modAction5"] = "Указал(а) уровень, как ежедневный";
$string["modAction6"] = "Удалил(а) уровень";
$string["modAction7"] = "Сменил(а) автора";
$string["modAction8"] = "Переименовал(а) уровень";
$string["modAction9"] = "Сменил(а) пароль уровню";
$string["modAction10"] = "Сменил(а) демон-сложность уровню";
$string["modAction11"] = "Поделился(лась) CP";
$string["modAction12"] = "Скрыл(а)/открыл(а) уровень";
$string["modAction13"] = "Сменил(а) описание уровню";
$string["modAction14"] = "Включил(а)/выключил(а) LDM уровню";
$string["modAction15"] = "Забанил(а)/разбанил(а) в лидербордах";
$string["modAction16"] = "Сменил(а) песню уровню";
$string["modAction17"] = "Создал(а) Мап-Пак";
$string["modAction18"] = "Создал(а) Гаунтлет";
$string["modAction19"] = "Изменил(а) песню";
$string["modAction20"] = "Сделал(а) модератором игрока";
$string["modAction21"] = "Изменил(а) Мап-Пак";
$string["modAction22"] = "Изменил(а) Гаунтлет";
$string["modAction23"] = "Изменил(а) квест";
$string["modAction24"] = "Переназначил(а) игрока";
$string["modAction25"] = "Создал(а) квест";
$string["modAction26"] = "Сменил(а) никнейм/пароль игроку";
$string["modAction30"] = "Оценил(а) список уровней";
$string["modAction31"] = "Отправил(а) на оценку список уровней";
$string["modAction32"] = "Снял(а)/добавил(а) Featured списку уровней";
$string["modAction33"] = "Скрыл(а)/открыл(а) список уровней";
$string["modAction34"] = "Удалил(а) список уровней";
$string["modAction35"] = "Изменил(а) автора списка уровней";
$string["modAction36"] = "Изменил(а) название списка уровней";
$string["modAction37"] = "Изменил(а) описание списка уровней";
$string["everyActions"] = "Любые действия";
$string["everyMod"] = "Все модераторы";
$string["Kish!"] = "Кыш!";
$string["noPermission"] = "У вас нет прав!";
$string["noLogin?"] = "Вы не вошли в аккаунт!";
$string["LoginBtn"] = "Войти в аккаунт";
$string["dashboard"] = "Панель сервера";
$string["userID"] = 'ID игрока';
//errors
$string["errorNoAccWithPerm"] = "Ошибка: аккаунтов с правом '%s' не было найдено";