<?php
/*
	Welcome to webhooks translation file!
	You're currently at Italian (Italiano) language
	Credits: Fenix668

	If you see array instead of simple string, that means you can add as many variations of translation as you want and they will be picked randomly
*/
$webhookLang['rateSuccessTitle'] = ['Un nuovo livello è stato valutato!', 'Nuovo livello valutato!', 'Qualcuno ha valutato un livello!']; // This one is array
$webhookLang['rateSuccessTitleDM'] = ['Il tuo livello è stato valutato!', 'Qualcuno ha valutato il tuo livello!'];
$webhookLang['rateSuccessDesc'] = '%1$s ha valutato un livello!'; // And this one is string
$webhookLang['rateSuccessDescDM'] = '%1$s ha valutato il tuo livello! %2$s';
$webhookLang['rateFailTitle'] = ['Il livello è stato svalutato!', 'Qualcuno ha svalutato il livello!'];
$webhookLang['rateFailTitleDM'] = ['Il tuo livello è stato svalutato!', 'Qualcuno ha svalutato il tuo livello!'];
$webhookLang['rateFailDesc'] = '%1$s ha svalutato il livello!';
$webhookLang['rateFailDescDM'] = '%1$s ha svalutato il tuo livello! %2$s';

$webhookLang['levelTitle'] = 'Livello';
$webhookLang['levelDesc'] = '%1$s di %2$s'; // Name by Creator
$webhookLang['levelIDTitle'] = 'ID del livello';
$webhookLang['difficultyTitle'] = 'Difficoltà';
$webhookLang['difficultyDesc0'] = '%1$s, %2$s stella'; // Auto, 1 star
$webhookLang['difficultyDesc1'] = '%1$s, %2$s stelle'; // Easy, 2 stars
$webhookLang['difficultyDesc2'] = '%1$s, %2$s stelle'; // Hard, 5 stars
$webhookLang['difficultyDescMoon0'] = '%1$s, %2$s luna'; // Auto, 1 moon (Platformer)
$webhookLang['difficultyDescMoon1'] = '%1$s, %2$s lune'; // Easy, 2 moons (Platformer)
$webhookLang['difficultyDescMoon2'] = '%1$s, %2$s lune'; // Hard, 5 moons (Platformer)
$webhookLang['statsTitle'] = 'Stato';
$webhookLang['requestedTitle'] = 'Richiesta valutazione';
$webhookLang['requestedDesc0'] = '%1$s stella'; // 1 star
$webhookLang['requestedDesc1'] = '%1$s stelle'; // 2 stars
$webhookLang['requestedDesc2'] = '%1$s stelle'; // 5 stars
$webhookLang['requestedDescMoon0'] = '%1$s luna'; // 1 moon (Platformer)
$webhookLang['requestedDescMoon1'] = '%1$s lune'; // 2 moons (Platformer)
$webhookLang['requestedDescMoon2'] = '%1$s lune'; // 5 moons (Platformer)
$webhookLang['descTitle'] = 'Descrizione';
$webhookLang['descDesc'] = '*Nessuna descrizione*';
$webhookLang['footer'] = '%1$s, grazie per aver giocato!';

$webhookLang['suggestTitle'] = ['Controlla questo livello!', 'Il livello è stato suggerito!', 'Qualcuno ha suggerito un livello!'];
$webhookLang['suggestDesc'] = '%1$s ha suggerito un livello da valutare!';
$webhookLang['footerSuggest'] = '%1$s, grazie per aver moderato!';

$webhookLang['demonlistTitle'] = ['Nuovo record!', 'Qualcuno ha pubblicato un nuovo record!'];
$webhookLang['demonlistDesc'] = '%1$s ha pubblicato il completamento di %2$s! Link da approvare: ||%3$s||';
$webhookLang['recordAuthorTitle'] = 'Autore del record';
$webhookLang['recordAttemptsTitle'] = 'Tentativi';
$webhookLang['recordAttemptsDesc0'] = '%1$s tentativo'; // 1 attempt
$webhookLang['recordAttemptsDesc1'] = '%1$s tentativi'; // 2 attempts
$webhookLang['recordAttemptsDesc2'] = '%1$s tentativi'; // 5 attempts
$webhookLang['recordProofTitle'] = 'Prova';
$webhookLang['demonlistApproveTitle'] = ['Il record è stato approvato!', 'Qualcuno ha approvato un record!'];
$webhookLang['demonlistApproveTitleDM'] = ['Il tuo record è stato approvato!', 'Qualcuno ha approvato il tuo record!'];
$webhookLang['demonlistApproveDesc'] = '%1$s ha approvato il record di %2$s del livello %3$s!';
$webhookLang['demonlistApproveDescDM'] = '%1$s ha approvato il tuo record del livello %2$s!';
$webhookLang['demonlistDenyTitle'] = ['Il record è stato declinato!', 'Qualcuno ha declinato un record!'];
$webhookLang['demonlistDenyTitleDM'] = ['Il tuo record è stato declinato!', 'Qualcuno ha declinato il tuo record!'];
$webhookLang['demonlistDenyDesc'] = '%1$s ha declinato il record di %2$s del livello %3$s!';
$webhookLang['demonlistDenyDescDM'] = '%1$s ha declinato il tuo record del livello %2$s!';

$webhookLang['accountLinkTitle'] = ['Collegamento dell\'account!', 'Qualcuno vuole collegare l\'account!'];
$webhookLang['accountLinkDesc'] = 'Sembra che %1$s voglia collegare il proprio account di gioco al tuo account Discord. Pubblica **!discord accetta *codice*** nel tuo profilo di gioco per farlo. Se non sei tu, **ignora** questo messaggio!';
$webhookLang['accountCodeFirst'] = 'Primo numero';
$webhookLang['accountCodeSecond'] = 'Secondo numero';
$webhookLang['accountCodeThird'] = 'Terzo numero';
$webhookLang['accountCodeFourth'] = 'Quarto numero';
$webhookLang['accountUnlinkTitle'] = ['Scollegamento dell\'account!', 'Hai scollegato il tuo account!'];
$webhookLang['accountUnlinkDesc'] = 'Hai scollegato con successo %1$s dal tuo account Discord!';
$webhookLang['accountAcceptTitle'] = ['Collegamento dell\'account!', 'Hai collegato il tuo account!'];
$webhookLang['accountAcceptDesc'] = 'Hai collegato con successo %1$s al tuo account Discord!';

$webhookLang['playerBanTitle'] = ['Il giocatore è stato bannato!', 'Qualcuno ha bannato qualcuno!', 'Bannato!'];
$webhookLang['playerBanTitleDM'] = ['Sei stato bannato!', 'Qualcuno ti ha bannato!', 'Bannato!'];
$webhookLang['playerUnbanTitle'] = ['Il giocatore è stato sbloccato!', 'Qualcuno ha sbloccato qualcuno!', 'Sbannato!'];
$webhookLang['playerUnbanTitleDM'] = ['Sei stato sbloccato!', 'Qualcuno ti ha sbloccato!', 'Sbannato!'];
$webhookLang['playerBanTopDesc'] = '%1$s ha bannato %2$s dai migliori giocatori!';
$webhookLang['playerBanTopDescDM'] = '%1$s ti ha bannato dai migliori giocatori.';
$webhookLang['playerUnbanTopDesc'] = '%1$s ha liberato %2$s dai migliori giocatori!';
$webhookLang['playerUnbanTopDescDM'] = '%1$s ti ha sbloccato dai migliori giocatori!';
$webhookLang['playerBanCreatorDesc'] = '%1$s ha bannato %2$s dai migliori giocatori!';
$webhookLang['playerBanCreatorDescDM'] = '%1$s ti ha bannato dai migliori giocatori.';
$webhookLang['playerUnbanCreatorDesc'] = '%1$s ha liberato %2$s dai creatori in alto!';
$webhookLang['playerUnbanCreatorDescDM'] = '%1$s ti ha riattivato dalla lista dei creatori!';
$webhookLang['playerBanUploadDesc'] = '%1$s ha vietato a %2$s di caricare livelli!';
$webhookLang['playerBanUploadDescDM'] = '%1$s ti ha vietato il caricamento di livelli.';
$webhookLang['playerUnbanUploadDesc'] = '%1$s ha sbloccato %2$s dal caricamento dei livelli!';
$webhookLang['playerUnbanUploadDescDM'] = '%1$s ha sbloccato il caricamento dei tuoi livelli!';
$webhookLang['playerModTitle'] = 'Moderatore';
$webhookLang['playerReasonTitle'] = 'Motivo';
$webhookLang['playerBanReason'] = '*Nessuna ragione*';
$webhookLang['footerBan'] = '%1$s.';
$webhookLang['playerBanCommentDesc'] = '%1$s ha vietato a %2$s di commentare!';
$webhookLang['playerBanCommentDescDM'] = 'Possibilità vietata a %1$s di commentarti.';
$webhookLang['playerUnbanCommentDesc'] = '%1$s ha sbloccato la capacità di %2$s di commentare!';
$webhookLang['playerUnbanCommentDescDM'] = 'Possibilità non vietata di %1$s di commentarti!';
$webhookLang['playerBanAccountDesc'] = '%1$s ha bannato l\'account di %2$s!';
$webhookLang['playerBanAccountDescDM'] = '%1$s ha bannato il tuo account.';
$webhookLang['playerUnbanAccountDesc'] = '%1$s ha sbloccato l\'account di %2$s!';
$webhookLang['playerUnbanAccountDescDM'] = '%1$s ha sbloccato il tuo account!';
$webhookLang['playerExpiresTitle'] = 'Scade';
$webhookLang['playerTypeTitle'] = 'Tipo di persona';
$webhookLang['playerTypeName0'] = 'ID dell\'account';
$webhookLang['playerTypeName1'] = 'ID dell\'utente';
$webhookLang['playerTypeName2'] = 'Indirizzo IP';

$webhookLang['dailyTitle'] = 'Nuovo livello giornaliero!';
$webhookLang['dailyTitleDM'] = 'Il tuo livello è tra i giornalieri!';
$webhookLang['dailyDesc'] = 'Questo livello è giornaliero ora!';
$webhookLang['dailyDescDM'] = 'Il tuo livello è diventato giornaliero! %1$s';
$webhookLang['weeklyTitle'] = 'Nuovo livello settimanale!';
$webhookLang['weeklyTitleDM'] = 'Il tuo livello è settimanale!';
$webhookLang['weeklyDesc'] = 'Questo livello è settimanale ora!';
$webhookLang['weeklyDescDM'] = 'Il tuo livello è diventato settimanale! %1$s';
$webhookLang['eventTitle'] = 'Nuovo livello di eventi!';
$webhookLang['eventTitleDM'] = 'Il tuo livello è il livello dell\'evento!';
$webhookLang['eventDesc'] = 'Questo livello è ora a livello di evento!';
$webhookLang['eventDescDM'] = 'Il tuo livello è stato utilizzato nell\'evento! %1$s';
?>
