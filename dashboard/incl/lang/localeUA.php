<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Дім";
$string["welcome"] = "Ласкаво просимо до ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Увага!</b> Ви не до кінця встановили панель серверу! Нажміть на текст, щоб це зробити.</div>";
$string["levelsWeek"] = "Викладено рівнів за тиждень";
$string["levels3Months"] = "Викладено рівнів за 3 місяці";
$string["footer"] = $gdps.", ".date('Y', time());

$string["tryCron"] = "Виконати Cron";
$string["cronSuccess"] = "Готово!";
$string["cronError"] = "Помилка!";

$string["profile"] = "Профіль";
$string["empty"] = "Порожньо...";
$string["writeSomething"] = "Напишіть щось!";

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

$string["gauntletCreate"] = "Створити Гаунтлет";
$string["gauntletCreateTitle"] = "Створення Гаунтлета";
$string["gauntletCreateDesc"] = "Тут ви можете створити Гаунтлет!";
$string["gauntletCreateSuccess"] = "Ви успішно створилиГаунтлет!";
$string["gauntletCreateOneMore"] = "Ще один Гаунтлет?";
$string["chooseLevels"] = "Виберіть рівні!";
$string["checkbox"] = "Підтвердити";
$string["level1"] = "1 рівень";
$string["level2"] = "2 рівень";
$string["level3"] = "3 рівень";
$string["level4"] = "4 рівень";
$string["level5"] = "5 рівень";

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

$string["search"] = "Поиск...";
$string["searchCancel"] = "Отменить поиск";
$string["emptySearch"] = "Ничего не найдено!";


/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Завантажити";
$string["errorGeneric"] = "Відбулася помилка!";
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
$string["suggestFeatured"] = "Featured?";
$string["whoAdded"] = "Хто додав?";
//modActionsList
$string["banDesc"] = "Тут ви можете заблокувати користувача з лідерборду!";

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
$string["unban"] = "Розблокування";
$string["isBan"] = "блокування";

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
$string["modAction25"] = "Створив(ла) квест";
$string["modAction26"] = "Змінив(ла) нікнейм/пароль користувачу";
$string["Kish!"] = "Киш!";
$string["noPermission"] = "У вас немає прав!";
$string["noLogin?"] = "Ви не ввійшли в акаунт!";
$string["LoginBtn"] = "Ввійти в акаунт";
$string["dashboard"] = "Панель серверу";
//errors
$string["errorNoAccWithPerm"] = "Помилка: акаунтів з правом '%s' не було знайдено";