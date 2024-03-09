<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Дім";
$string["welcome"] = "Ласкаво просимо до ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Увага!</b> Ви не до кінця встановили панель серверу! Нажміть на текст, щоб це зробити.</div>";
$string["levelsWeek"] = "Викладено рівнів за тиждень";
$string["levels3Months"] = "Викладено рівнів за 3 місяці";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Ласкаво просимо до панелі серверу! Ми даємо вам декілька підсказок після встановлення:<br>
1. Здається, в SQL у таблиці 'roles' з'явились нові права! Вам слід це перевірити...<br>
2. Якщо ви помістите icon.png у папку 'dashboard', то зліва зверху появиться значок вашого серверу!<br>
3. Потрібно налаштувати config/dashboard.php, без цього ніяк!";
$string["wwygdt"] = "Чим ви сьогодні будете займатись?";
$string["game"] = "Гра";
$string["guest"] = "гість";
$string["account"] = "Акаунт";
$string["levelsOptDesc"] = "Подивитись список рівнів";
$string["songsOptDesc"] = "Подивитись список пісень";
$string["yourClanOptDesc"] = "Подивитись клан \"%s\"";
$string["clanOptDesc"] = "Подивитись список кланів";
$string["yourProfile"] = "Ваш профіль";
$string["profileOptDesc"] = "Подивитись ваш профіль";
$string["messengerOptDesc"] = "Зайти в месенджер";
$string["addSongOptDesc"] = "Додати пісню на сервер";
$string["loginOptDesc"] = "Війти в акаунт";
$string["createAcc"] = "Створити акаунт";
$string["registerOptDesc"] = "Зареєструватись на %s";
$string["downloadOptDesc"] = "Встановити %s";

$string["tryCron"] = "Виконати Cron";
$string["cronSuccess"] = "Готово!";
$string["cronError"] = "Помилка!";

$string["profile"] = "Профіль";
$string["empty"] = "Порожньо...";
$string["writeSomething"] = "Напишіть щось!";
$string["replies"] = "Відповіді";
$string["replyToComment"] = "Відповідь на коментар";
$string["settings"] = "Налаштування";
$string["allowMessagesFrom"] = "Дозволяти повідомлення від...";
$string["allowFriendReqsFrom"] = "Дозволяти заявки в друзі від...";
$string["showCommentHistory"] = "Показувати історію коментарів...";
$string["yourYouTube"] = "Ваш канал на YouTube";
$string["yourVK"] = "Ваша сторінка в ВКонтакте";
$string["yourTwitter"] = "Ваша сторінка в Twitter";
$string["yourTwitch"] = "Ваш канал на Twitch";
$string["saveSettings"] = "Зберегти налаштування";
$string["all"] = "Все";
$string["friends"] = "Друзі";
$string["none"] = "Ніхто";
$string["youBlocked"] = "Цей гравець вас заблокував!";
$string["cantMessage"] = "Ви не можете написати цьому гравцю!";

$string["accountManagement"] = "Управніння акаунтом";
$string["changePassword"] = "Змінити пароль";
$string["changeUsername"] = "Змінити нікнейм";
$string["unlistedLevels"] = "Ваші приховані рівні";

$string["manageSongs"] = "Управління піснями";
$string["gauntletManage"] = "Управління Гаунтлетами";
$string["suggestLevels"] = "Запропоновані рівні";

$string["modTools"] = "Інструменти модератора";
$string["leaderboardBan"] = "Заблокувати користувача";
$string["unlistedMod"] = "Приховані рівні";

$string["reuploadSection"] = "Завантаження на сервер";
$string["songAdd"] = "Додати пісню";
$string["songLink"] = "Додати пісню по посиланню";
$string["packManage"] = "Управління Мап-Паками";

$string["browse"] = "Перегляд";
$string["statsSection"] = "Статистика";
$string["dailyTable"] = "Щоденні рівні";
$string["modActionsList"] = "Дії модераторів";
$string["modActions"] = "Список модераторів";
$string["gauntletTable"] = "Гаунтлети";
$string["packTable"] = "Мап-Паки";
$string["leaderboardTime"] = "Таблиця лидерів за 24 години";

$string["download"] = "Встановити";
$string["forwindows"] = "Для Windows";
$string["forandroid"] = "Для Android";
$string["formac"] = "Для Mac";
$string["forios"] = "Для iOS";
$string["third-party"] = "Посторонні ресурси";
$string["thanks"] = "Дякую цим людям!";
$string["language"] = "Мова";

$string["loginHeader"] = "Вітаємо, %s!";
$string["logout"] = "Вийти";
$string["login"] = "Ввійти";
$string["wrongNickOrPass"] = "Невірний нікнейм або пароль!";
$string["invalidid"] = "Невірний ID!";
$string["loginBox"] = "Вхід в акаунт";
$string["loginSuccess"] = "Ви успішно ввійшли в акаунт!";
$string["loginAlready"] = "Ви вже ввійшли в акаунт!";
$string["clickHere"] = "Панель сервера";
$string["enterUsername"] = "Введіть ваш нікнейм";
$string["enterPassword"] = "Введіть ваш пароль";
$string["loginDesc"] = "Тут ви можете ввійти в ваш акаунт!";

$string["register"] = "Зареєеструватись";
$string["registerAcc"] = "Реєстрація акаунта";
$string["registerDesc"] = "Зареєструйте свій акаунт!";
$string["repeatpassword"] = "Повторіть пароль";
$string["email"] = "Пошта";
$string["repeatemail"] = "Повторіть пошту";
$string["smallNick"] = "Нікнейм занадто короткий!";
$string["smallPass"] = "Пароль занадто короткий!";
$string["passDontMatch"] = "Паролі не співпадають!";
$string["emailDontMatch"] = "Пошти не співпадають!";
$string["registered"] = "Ви успішно зареєстрували акаунт!";
$string["bigNick"] = "Нікнейм занадто длинный!";
$string["mailExists"] = "На этой почте уже зарегистрирован аккаунт!";

$string["changePassTitle"] = "Зміна пароля";
$string["changedPass"] = "Пароль успішно змінений! Вам потрібно заново ввійти в ваш акаунт.";
$string["wrongPass"] = "Неправильний пароль!";
$string["samePass"] = "Введені вами паролі однакові!";
$string["notSamePass"] = "Пароли не совпадают!";
$string["changePassDesc"] = "Тут ви можете змінити свій пароль!";
$string["oldPassword"] = "Старий пароль";
$string["newPassword"] = "Новий пароль";
$string["confirmNew"] = "Підтвердження пароля";

$string["forcePassword"] = "Примусово змінити пароль";
$string["forcePasswordDesc"] = "Тут ви можете примусово змінити пароль користувача!";
$string["forceNick"] = "Примусово змінити нікнейм";
$string["forceNickDesc"] = "Тут ви можете примусово змінити нікнейм користувача!";
$string["forceChangedPass"] = "Пароль користувача <b>%s</b> успішно змінений!";
$string["forceChangedNick"] = "Нікнейм користувача <b>%s</b> успішно змінений!";
$string["changePassOrNick"] = "Змінити нікнейм або пароль користувача";

$string["changeNickTitle"] = "Зміна нікнейма";
$string["changedNick"] = "Нікнейм успішно замінений! Вам потрібно заново ввійти в ваш акаунт.";
$string["wrongNick"] = "Невірний нікнейм!";
$string["sameNick"] = "Введені вами нікнейми однакові!";
$string["alreadyUsedNick"] = "Введений вами нікнейм вже занятий!";
$string["changeNickDesc"] = "Тут ви можете змінити свій нікнейм!";
$string["oldNick"] = "Старий нікнейм";
$string["newNick"] = "Новий нікнейм";
$string["password"] = "Пароль";

$string["packCreate"] = "Створити Мап-Пак";
$string["packCreateTitle"] = "Створювання Мап-Пака";
$string["packCreateDesc"] = "Тут ви можете створити Мап-Пак!";
$string["packCreateSuccess"] = "Ви успішно створили Мап-Пак під назвою";
$string["packCreateOneMore"] = "Ще один Мап-Пак?";
$string["packName"] = "Назва Мап-Пака";
$string["color"] = "Колір";
$string["sameLevels"] = "Ви вибрали однакові рівні!";
$string["show"] = "Показати";
$string["packChange"] = "Змінити Мап-Пак";
$string["createNewPack"] = "Створіть новий Мап-Пак!";

$string["gauntletCreate"] = "Створити Гаунтлет";
$string["gauntletCreateTitle"] = "Створення Гаунтлета";
$string["gauntletCreateDesc"] = "Тут ви можете створити Гаунтлет!";
$string["gauntletCreateSuccess"] = "Ви успішно створили Гаунтлет!";
$string["gauntletCreateOneMore"] = "Ще один Гаунтлет?";
$string["chooseLevels"] = "Виберіть рівні!";
$string["checkbox"] = "Підтвердити";
$string["level1"] = "1 рівень";
$string["level2"] = "2 рівень";
$string["level3"] = "3 рівень";
$string["level4"] = "4 рівень";
$string["level5"] = "5 рівень";
$string["gauntletChange"] = "Змінити Гаунтлет";
$string["createNewGauntlet"] = "Створіть новий Гаунтлет!";
$string["gauntletCreateSuccessNew"] = 'Ви успішно створили <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Выбрать Гаунтлет автоматически";

$string["addQuest"] = "Додати квест";
$string["addQuestDesc"] = "Тут ви можете створити квест!";
$string["questName"] = "Назва квеста";
$string["questAmount"] = "Необхідна кількість";
$string["questReward"] = "Нагорода";
$string["questCreate"] = "Створити квест";
$string["questsSuccess"] = "Ви успішно створили квест";
$string["invalidPost"] = "Неправильні дані!";
$string["fewMoreQuests"] = "Радимо вам створити ще декілька квестів.";
$string["oneMoreQuest?"] = "Ще один квест?";
$string["changeQuest"] = "Змінити квест";
$string["createNewQuest"] = "Створіть новий квест!";

$string["levelReupload"] = "Перенести рівень";
$string["levelReuploadDesc"] = "Тут ви можете перенести свій рівень з будь-якого сервера!";
$string["advanced"] = "Додаткові параметри";
$string["errorConnection"] = "Помилка підключення з сервером!";
$string["levelNotFound"] = "Такий рівень не знайдено!";
$string["robtopLol"] = "RobTop тебе не любить :с";
$string["sameServers"] = "Вибрані вами сервера однакові!";
$string["levelReuploaded"] = "Рівень перенесений! ID рівня:";
$string["oneMoreLevel?"] = "Ще один рівень?";
$string["levelAlreadyReuploaded"] = "Рівень вже перенесений!";
$string["server"] = "Сервер";
$string["levelID"] = "ID рівня";
$string["pageDisabled"] = "Ця сторінка відключена!";

$string["activateAccount"] = "Активація акаунта";
$string["activateDesc"] = "Активуйте свій акаунт!";
$string["activated"] = "Ваш акаунт успішно активований!";
$string["alreadyActivated"] = "Ваш акаунт вже активований!";
$string["maybeActivate"] = "Можливо, ви не активували свій акаунт.";
$string["activate"] = "Активувати";
$string["activateDisabled"] = "Активація акаунта не потребується!";

$string["addMod"] = "Видати модератора";
$string["addModDesc"] = "Тут ви можете зробити користувачів модераторами!";
$string["modYourself"] = "Не можна призначити себе модератором!";
$string["alreadyMod"] = "Цей користувач вже є модератором!";
$string["addedMod"] = "Ви успішно зробили користувача модератором";
$string["addModOneMore"] = "Ще один модератор?";
$string["modAboveYourRole"] = "Ви намагаєтесь видати ігроку роль вище вашої!";
$string["makeNewMod"] = "Призначте когось модератором!";
$string["reassignMod"] = "Переназначити модератора";
$string["reassign"] = "Переназначити";
$string['demotePlayer'] = "Снять игрока с поста модератора";
$string['demotedPlayer'] = "Вы успешно сняли игрока <b>%s</b> с поста модератора!";
$string['addedModNew'] = "Вы успешно сделали модератором игрока <b>%s</b>!";
$string['demoted'] = 'Снят';

$string["shareCPTitle"] = "Поділитися Креатор Поїнтами";
$string["shareCPDesc"] = "Тут ви можете поділитися Креатор Поїнтами з користувачами!";
$string["shareCP"] = "Поділитися";
$string["alreadyShared"] = "Цей рівень вже ділився Креатор Поїнтами з цим користувачем!";
$string["shareToAuthor"] = "Ви намагаєтесь поділитися Креатор Поїнтами з автором цього рівня!";
$string["userIsBanned"] = "Цей користувач заблокований!";
$string["shareCPSuccess"] = "Ви успішно поділились Креатор Поїнтами рівня";
$string["shareCPSuccess2"] = "з користувачем";
$string["updateCron"] = "Можливо, вам слід обновити Креатор Поїнти.";
$string["shareCPOneMore"] = "Ще поділитися?";
$string['shareCPSuccessNew'] = 'Ви успішно поділились Креатор Поїнтами рівня <b>%1$s</b> з користувачем <b>%2$s</b>!';

$string["messenger"] = "Месенджер";
$string["write"] = "Написати";
$string["send"] = "Відправити";
$string["noMsgs"] = "Начніть діалог!";
$string["subject"] = "Тема";
$string["msg"] = "Повідомлення";
$string["tooFast"] = "Ви надто швидко пишете!";

$string["levelToGD"] = "Перенести рівень на інший сервер";
$string["levelToGDDesc"] = "Тут ви можете перенести свій рівень на інший сервер!";
$string["usernameTarget"] = "Нікнейм для обраного серверу";
$string["passwordTarget"] = "Пароль для обраного серверу";
$string["notYourLevel"] = "Це не ваш рівень!";
$string["reuploadFailed"] = "Помилка перенесення рівня!";

$string["search"] = "Пошук...";
$string["searchCancel"] = "Відмінити пошук";
$string["emptySearch"] = "Нічого не знайдено!";

$string["demonlist"] = 'Топ демонів';
$string["demonlistRecord"] = 'Рекорд <b>%s</b>';
$string["alreadyApproved"] = 'Вже прийнятий!';
$string["alreadyDenied"] = 'Вже відхилений!';
$string["approveSuccess"] = 'Ви успішно прийняли рекорд <b>%s</b>!';
$string["denySuccess"] = 'Ви успішно відхилили рекорд <b>%s</b>!';
$string["recordParameters"] = '<b>%s</b> пройшов <b>%s</b> за <b>%d</b> спроб';
$string["approve"] = 'Прийняти';
$string["deny"] = 'Відхилити';
$string["submitRecord"] = 'Опубліковати рекорд';
$string["submitRecordForLevel"] = 'Опубліковати рекорд для <b>%s</b>';
$string["alreadySubmitted"] = 'Ви вже публікували рекорд для <b>%s</b>!';
$string["submitSuccess"] = 'Ви успішно опублікували рекорд для <b>%s</b>!';
$string["submitRecordDesc"] = 'Публікуйте свої рекорди тільки якщо ви пройшли рівень!';
$string["atts"] = 'Спроби';
$string["ytlink"] = 'ID відео на YouTube (dQw4w9WgXcQ)';
$string["submit"] = 'Опубліковати';
$string["addDemonTitle"] = 'Додати демон';
$string["addDemon"] = 'Додати демон в топ демонів';
$string["addedDemon"] = 'Ви додали <b>%s</b> на <b>%d</b> місце!';
$string["addDemonDesc"] = 'Тут ви можете добавити демон в демонліст!';
$string["place"] = 'Місце';
$string["giveablePoints"] = 'Видаваємі очки';
$string["add"] = 'Додати';
$string["recordApproved"] = 'Рекорд підтверджений!';
$string["recordDenied"] = 'Рекорд відхилений!';
$string["recordSubmitted"] = 'Рекорд опублікований!';
$string["nooneBeat"] = 'ніхто не пройшов'; //let it be lowercase
$string["oneBeat"] = 'пройшов 1 ігрок'; 
$string["lower5Beat"] = 'пройшло %d ігрока'; 
$string["above5Beat"] = 'пройшло %d ігроків'; 
$string["demonlistLevel"] = '%s <text class="dltext">від <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button></text>';
$string["noDemons"] = 'Здається, у вашому топі демонів немає ні одного демону...';
$string["addSomeDemons"] = 'Додайте декілька демонів, щоб заповнити топ!';
$string["askForDemons"] = 'Попросіть адміністратора серверу додати декілька!';
$string["recordList"] = 'Список рекордів';
$string["status"] = 'Статус';
$string["checkRecord"] = 'Провірити рекорд';
$string["record"] = 'Рекорд';
$string["recordDeleted"] = 'Рекорд був видалений!';
$string["changeDemon"] = 'Змінити демон';
$string["demonDeleted"] = 'Демон був видалений!';
$string["changedDemon"] = 'Ви переставили <b>%s</b> на <b>%d</b> місце!';
$string["changeDemonDesc"] = 'Тут ви можете змінити демон в демонлисті!<br>
Якщо ви хочете видалити демон, вкажіть 0 місце.';

$string["didntActivatedEmail"] = 'Ви не підтвердили вашу почту!';
$string["checkMail"] = 'Вам слід провірити ваш поштовий ящик...';

$string["likeSong"] = "Додати пісню в улюбленні";
$string["dislikeSong"] = "Забрати пісню з улюбленних";
$string["favouriteSongs"] = "Улюблені пісні";
$string["howMuchLiked"] = "Скільки лайкнуло?";
$string["nooneLiked"] = "Ніхто не лайкнув";

$string["clan"] = "Клан";
$string["joinedAt"] = "Вступив(ла) у клан: <b>%s</b>";
$string["createdAt"] = "Створив(ла) клан: <b>%s</b>";
$string["clanMembers"] = "Учасники клану";
$string["noMembers"] = "Учасників немає";
$string["clanOwner"] = "Творець клану";
$string["noClanDesc"] = "<i>У клану немає опису</i>";
$string["noClan"] = "Такого клану не існує!";
$string["clanName"] = "Назва клану";
$string["clanDesc"] = "Опис клану";
$string["clanColor"] = "Колір клану";
$string["dangerZone"] = "Небезпечна зона";
$string["giveClan"] = "Передати клан";
$string["deleteClan"] = "Видалити клан";
$string["goBack"] = "Повернутись назад";
$string["areYouSure"] = "Ви впевнені?";
$string["giveClanDesc"] = "Тут ви можете передати клан іншому гравцю.";
$string["notInYourClan"] = "Цей гравець не перебуває у вашому клані!";
$string["givedClan"] = "Ви успішно передали клан гравцю <b>%s</b>!";
$string["deletedClan"] = "Ви видалили клан <b>%s</b>.";
$string["deleteClanDesc"] = "Тут ви можете видалити ваш клан.";
$string["yourClan"] = "Ваш клан";
$string["members0"] = "<b>1</b> учасник"; 
$string["members1"] = "<b>%d</b> учасникa"; 
$string["members2"] = "<b>%d</b> учасників"; 
$string["noRequests"] = "Заявок немає. Відпочиваємо!";
$string["pendingRequests"] = "Заявки в клан";
$string["closedClan"] = "Зачинений клан";
$string["kickMember"] = "Вигнати учасника";
$string["leaveFromClan"] = "Вийти з клану";
$string["askToJoin"] = "Відправити заявку в клан";
$string["removeClanRequest"] = "Видалити заявку в клан";
$string["joinClan"] = "Приєднатися до клану";
$string["noClans"] = "Поки що кланів немає";
$string["clans"] = "Клани";
$string["alreadyInClan"] = "Ви вже в клані!";
$string["createClan"] = "Створити клан";
$string["createdClan"] = "Ви успішно створили клан <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Тут ви можете створити клан!";
$string["create"] = "Створити";
$string["mainSettings"] = "Основні налаштування";
$string["takenClanName"] = "Данное название клана уже занято!";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> запропонував оцінити </text><text class="levelname">%2$s</text><text class="dltext"> на <b>%4$s%3$s</b></text>';
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

$string["reuploadBTN"] = "Завантажити";
$string["errorGeneric"] = "Відбулася помилка!";
$string["smthWentWrong"] = "Щось пішло не так!";
$string["tryAgainBTN"] = "Спробуйте ще раз";
//songAdd.php
$string["songAddDesc"] = "Тут ви можете додати свою пісню!";
$string["songAddUrlFieldLabel"] = "Посилання на пісню. (Пряма, Dropbox. YouTube не працює)";
$string["songAddUrlFieldPlaceholder"] = "Посилання на пісню";
$string["songAddNameFieldPlaceholder"] = "Назва пісни";
$string["songAddAuthorFieldPlaceholder"] = "Автор пісни";
$string["songAddButton"] = "Вибрати пісню";
$string["songAddAnotherBTN"] = "Ще одну пісню?";
$string["songAdded"] = "Пісня завантажена!";
$string["songID"] = "ID вашої пісні: ";
$string["songIDw"] = "ID пісні";
$string["songAuthor"] = "Автор";
$string["deletedSong"] = "Ви успішно видалили пісню";
$string["renamedSong"] = "Ви успішно перейменували пісню в";
$string["size"] = "Розмір";
$string["delete"] = "Видалити";
$string["change"] = "Змінити";
$string["chooseFile"] = "Виберіть пісню";
$string['yourNewSong'] = "Взгляните на вашу новоиспечённую песню!";
///errors
$string["songAddError-2"] = "Невірний URL (можливо, посилання не пряма).";
$string["songAddError-3"] = "Пісня вже завантажена під ID:";
$string["songAddError-4"] = "Цю пісню не можна завантажити :с";
$string["songAddError-5"] = "Пісня важить більше ніж $songSize мегабайт!";
$string["songAddError-6"] = "Щось трапилося при завантаженні пісні! :с";
$string["songAddError-7"] = "Завантажувати можна тільки аудіофайли!";

$string[400] = "Поганий запит!";
$string["400!"] = "Перевірте драйвера вашого мережевого обладнання.";
$string[403] = "Доступ заборонений!";
$string["403!"] = "У вас немає прав на перегляд даної сторінки.";
$string[404] = "Сторінка не найдена!";
$string["404!"] = "Ви впевнені, що ви правильно написали адресу сторінки?";
$string[500] = "Внутрішня помилка серверу!";
$string["500!"] = "Кодер допустив помилку при написанні даної сторінки,</br>
повідомте йому про це тут:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Сервер перегружений!";
$string["502!"] = "Зараз навантаження на сервер над-то велика, хостинг не може справитись з нею.</br>
Спробуйте зайти сюди через декілька годин!";

$string["invalidCaptcha"] = "Неправильна відповідь від капчі!";
$string["page"] = "Сторінка";
$string["emptyPage"] = "Ця сторінка порожня!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Орби";
$string["stars"] = "Зірки";
$string["coins"] = "Монети";
$string["accounts"] = "Акаунти";
$string["levels"] = "Рівні";
$string["songs"] = "Пісні";
$string["author"] = "Автор";
$string["name"] = "Назва";
$string["date"] = "Дата";
$string["type"] = "Тип";
$string["reportCount"] = "Кількість репортів";
$string["reportMod"] = "Репорти";
$string["username"] = "Нікнейм";
$string["accountID"] = "ID акаунта";
$string["registerDate"] = "Дата реєстрації";
$string["levelAuthor"] = "Автор рівня";
$string["isAdmin"] = "Роль на сервері";
$string["isAdminYes"] = "Так";
$string["isAdminNo"] = "Ні";
$string["userCoins"] = "Користувацькі монети";
$string["time"] = "Час";
$string["deletedLevel"] = "Видаленний рівень";
$string["mod"] = "Модератор";
$string["count"] = "Кількість дій";
$string["ratedLevels"] = "Оцінені рівні";
$string["lastSeen"] = "Останній раз був онлайн";
$string["level"] = "Рівень";
$string["pageInfo"] = "Сторінка %s з %s";
$string["first"] = "Перша сторінка";
$string["previous"] = "Назад";
$string["next"] = "Вперед";
$string["never"] = "Ніколи";
$string["last"] = "Остання сторінка";
$string["go"] = "Вперед";
$string["levelid"] = "ID рівня";
$string["levelname"] = "Назва рівня";
$string["leveldesc"] = "Опис рівня";
$string["noDesc"] = "Без опису";
$string["levelpass"] = "Пароль";
$string["nopass"] = "Без пароля";
$string["unrated"] = "Не оцінений";
$string["rate"] = "Оцінка";
$string["stats"] = "Статистика";
$string["suggestFeatured"] = "Featured?";
$string["whoAdded"] = "Хто додав?";
//modActionsList
$string["banDesc"] = "Тут ви можете заблокувати користувача з лідерборду!";
$string["playerTop"] = 'Топ гравців';
$string["creatorTop"] = 'Топ строітелів';

$string["admin"] = "Адміністратор";
$string["elder"] = "Старший модератор";
$string["moder"] = "Модератор";
$string["player"] = "Ігрок";

$string["starsLevel2"] = "зірок";
$string["starsLevel1"] = "зірки";
$string["starsLevel0"] = "зірка";
$string["coins2"] = "монет";
$string["coins1"] = "монети";
$string["coins0"] = "монета";
$string["time0"] = "раз";
$string["time1"] = "раза";
$string["times"] = "раз";
$string["action0"] = "дія";
$string["action1"] = "дії";
$string["action2"] = "дій";
$string["lvl0"] = "рівень";
$string["lvl1"] = "рівня";
$string["lvl2"] = "рівней";
$string["player0"] = "гравець"; 
$string["player1"] = "гравця"; 
$string["player2"] = "гравців";
$string["unban"] = "Розблокування";
$string["isBan"] = "Блокування";

$string["noCoins"] = "Без монет";
$string["noReason"] = "Немає причини";
$string["noActions"] = "Немає дій";
$string["noRates"] = "Нема оцінок";

$string["future"] = "Майбутнє";

$string["spoiler"] = "Спойлер";
$string["accid"] = "з ID акаунта";
$string["banned"] = "був успішно заблокований!";
$string["unbanned"] = "був успішно розблокований!";
$string["nothingFound"] = "Такий користувач не знайдений!";
$string["ban"] = "Заблокувати";
$string["banUserID"] = "Нікнейм або ID користувача";
$string["banUserPlace"] = "Заблокувати користувача";
$string["banYourself"] = "Ви не можете заблокувати себе!"; 
$string["banYourSelfBtn!"] = "Заблокувати когось іншого";
$string["banReason"] = "Причина блокування";
$string["action"] = "Дія";
$string["value"] = "1 значення";
$string["value2"] = "2 значення";
$string["value3"] = "3 значення";
$string["modAction1"] = "Оцінив(ла) рівень";
$string["modAction2"] = "Зняв(ла)/додав(ла) Featured рівню";
$string["modAction3"] = "Зняв(ла)/додав(ла) монети рівню";
$string["modAction4"] = "Зняв(ла)/додав(ла) Epic рівню";
$string["modAction5"] = "Вказав(ла) рівень, як щоденний";
$string["modAction6"] = "Видалив(ла) рівень";
$string["modAction7"] = "Змінив(ла) автора";
$string["modAction8"] = "Перейменував(ла) рівень";
$string["modAction9"] = "Змінив(ла) пароль рівню";
$string["modAction10"] = "Змінив(ла) демон-складність рівню";
$string["modAction11"] = "Поділився(лась) CP";
$string["modAction12"] = "Скрив(ла)/показав(ла) рівень";
$string["modAction13"] = "Змінив(ла) опис рівню";
$string["modAction14"] = "Увімкнув(ла)/Ввимкнув(ла) LDM рівню";
$string["modAction15"] = "Заблокував(ла)/розблокував(ла) в лідербордах";
$string["modAction16"] = "Змінив(ла) пісню рівню";
$string["modAction17"] = "Створив(ла) Мап-Пак";
$string["modAction18"] = "Створив(ла) Гаунтлет";
$string["modAction19"] = "Змінив(ла) пісню";
$string["modAction20"] = "Зробив(ла) модератором користувача";
$string["modAction21"] = "Змінив(ла) Мап-Пак";
$string["modAction22"] = "Змінив(ла) Гаунтлет";
$string["modAction23"] = "Змінив(ла) квест";
$string["modAction24"] = "Переназначив(ла) ігрока";
$string["modAction25"] = "Створив(ла) квест";
$string["modAction26"] = "Змінив(ла) нікнейм/пароль користувачу";
$string["modAction30"] = "Оценил(а) список уровней";
$string["modAction31"] = "Отправил(а) на оценку список уровней";
$string["modAction32"] = "Снял(а)/добавил(а) Featured списку уровней";
$string["modAction33"] = "Скрыл(а)/открыл(а) список уровней";
$string["modAction34"] = "Удалил(а) список уровней";
$string["modAction35"] = "Изменил(а) автора списка уровней";
$string["modAction36"] = "Изменил(а) название списка уровней";
$string["modAction37"] = "Изменил(а) описание списка уровней";
$string["everyActions"] = "Будь-які дії";
$string["everyMod"] = "Всі модератори";
$string["Kish!"] = "Киш!";
$string["noPermission"] = "У вас немає прав!";
$string["noLogin?"] = "Ви не ввійшли в акаунт!";
$string["LoginBtn"] = "Ввійти в акаунт";
$string["dashboard"] = "Панель серверу";
$string["userID"] = 'ID игрока';
//errors
$string["errorNoAccWithPerm"] = "Помилка: акаунтів з правом '%s' не було знайдено";