<?php
/*¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯\
| _    _  ___  ___  ___  ___  ___  __    __      ___   __  __       |
|( \/\/ )(  _)(  ,)/ __)(  ,\(  _)(  )  (  )    (  ,) (  \/  )      |
| \    /  ) _) ) ,\\__ \ ) _/ ) _) )(__  )(__    )  \  )    (       |
|  \/\/  (___)(___/(___/(_)  (___)(____)(____)  (_)\_)(_/\/\_)      |
|                       ___          ___                            |
|                      |__ \        / _ \                           |
|                         ) |      | | | |                          |
|                        / /       | | | |                          |
|                       / /_   _   | |_| |                          |
|                      |____| (_)   \___/                           |
\___________________________________________________________________/
/                                                                   \
|        Copyright 2005-2018 by webspell.org / webspell.info        |
|        Copyright 2018-2019 by webspell-rm.de                      |
|                                                                   |
|        - Script runs under the GNU GENERAL PUBLIC LICENCE         |
|        - It's NOT allowed to remove this copyright-tag            |
|        - http://www.fsf.org/licensing/licenses/gpl.html           |
|                                                                   |
|               Code based on WebSPELL Clanpackage                  |
|                 (Michael Gruber - webspell.at)                    |
\___________________________________________________________________/
/                                                                   \
|                     WEBSPELL RM Version 2.0                       |
|           For Support, Mods and the Full Script visit             |
|                       webspell-rm.de                              |
\__________________________________________________________________*/

$language_array = array(

/* do not edit above this line */

    
    'news' => 'Neuigkeiten',
    'delete' => 'löschen',
    'edit' => 'ändern',
    'date' => 'Datum',
    'save_news' => 'Neuigkeit speichern',
    'edit_news' =>'Neuigkeit editieren',
    'new_post' => 'Neue Neuigkeit schreiben',
    'really_delete' => 'Diese Neuigkeit wirklich löschen?',
    'rubric' => 'Rubrik',
    'headline' => 'Überschrift',
    'text' => 'Text',
    'no'=>'Nein',
    'yes'=>'Ja',
    'actions'=>'Aktionen',
    'link' => 'Link',
    'new_window' => 'neues Fenster',
    'settings'=>'News-Einstellungen',
    'max_news'=>'Neuigkeiten pro Seite',
    'max_archiv'=>'Neuigkeiten im Archiv pro Seite',
    'max_admin'=>'Neuigkeiten im Admincenter pro Seite',
    'max_length_news'=>'max. Länge der Neuigkeiten',
    'max_headlines'=>'Letzte Neuigkeiten aufgelistet in sc_headlines',
    'max_length_headlines'=>'max. Länge letzte Neuigkeiten',
    'max_length_topnews'=>'max. Länge Top Neuigkeiten',
    'update'=>'aktualisieren',
    'is_displayed'=>'Wird angezeigt?',
    'news_rubrics'=>'Neuigkeiten Rubriken',
    'back'=>'zurück',
    'banner'=>'Banner',
    'banner_to_big'=>'Banner ist zu groß',
    'current_banner'=>'Aktueller Banner',
    'max_88x31'=>'(max. 88x31)',
    'format_incorrect'=>'Das Format des Banner war falsch. Bitte lade nur Banner im *.gif, *.jpg oder *.png Format hoch.',
    'add_to_message'=>'Zur Nachricht hinzufügen',
    'upload'=>'Hochladen',
    'title' => 'Neuigkeiten',
    'description' => 'Beschreibung / Info',
    'info'=> '<div class="alert alert-warning" role="alert"><b>Sprachanwendung:</b><br>
In dem Text muss ein entsprechender Sprach-Tag hinterlegt werden, was wie folgt aussieht.<br>{[de]} Überschrift und Text in deutscher Sprache.<br>
{[en]} Heading and text in English.</div>',
    'privacy_policy_title' => '<h3>Installation vom Clan Rules Plugin</h3><p>Eine Aufstellung aller Einträge und verwendeten Dateien.</p><br>',
    'privacy_policy_text' => '<h4>Datenbank erstellt:</h4>
  <p>_plugins_clan_rules</p>
  <h4>Dateien:</h4>
<p><u>PHP:</u><br>
/_plugins/clan_rules/admin/admin_clan_rules.php<br>
/_plugins/clan_rules/clan_rules.php<br>
<u>Languages:</u><br>
/_plugins/clan_rules/language/de/clan_rules.php,<br>
/_plugins/clan_rules/language/en/clan_rules.php,<br>
<u>html:</u><br>
/_plugins/clan_rules/templates/clan_rules.html<br>
<br></p>',

  'tooltip_1'=>'Dies ist die URL der Seite, z.B. (deinedomain.de/pfad/webspell).<br>Ohne http:// am Anfang und nicht mit Slash enden!<br>Sollte etwas sein wie',
  'tooltip_2'=>'Das ist der Titel der Seite, wird auch als Browser Titel angezeigt',
  'tooltip_3'=>'Der Name der Organisation',
  'tooltip_4'=>'Das Kürzel der Organisation',
  'tooltip_5'=>'Dein Name',
  'tooltip_6'=>'Die E-Mail Adresse des Webmasters',
  'tooltip_7'=>'Maximale Neuigkeiten, welche komplett angezeigt werden',
  'tooltip_8'=>'Forumthemen pro Seite',
  'tooltip_9'=>'Bilder pro Seite',
  'tooltip_10'=>'Neuigkeiten im Archiv pro Seite',
  'tooltip_11'=>'Forumbeiträge pro Seite',
  'tooltip_12'=>'Größe (Breite) für Galerie Vorschaubilder',
  'tooltip_13'=>'Letzte Neuigkeiten aufgelistet in sc_headlines',
  'tooltip_14'=>'Forumthemen aufgelistet in latesttopics',
  'tooltip_15'=>'Speicherplatz für Benutzer-Galerien pro Benutzer in MByte',
  'tooltip_16'=>'Maximale Länge für die letzten Neuigkeiten in sc_headlines',
  'tooltip_17'=>'Minimale Länge von Suchbegriffen',
  'tooltip_18'=>'Möchtest du Benutzer-Galerien für jeden Benutzer erlauben?',
  'tooltip_19'=>'Möchtest du Galerie Bilder direkt auf deiner Page administrieren? (besser ausgewählt lassen)',
  'tooltip_20'=>'Artikel pro Seite',
  'tooltip_21'=>'Auszeichnungen pro Seite',
  'tooltip_22'=>'Artikel aufgelistet in sc_articles',
  'tooltip_23'=>'Demos pro Seite',
  'tooltip_24'=>'Maximale Länge der aufgelisteten Artikel in sc_articles',
  'tooltip_25'=>'Gästebucheinträge pro Seite',
  'tooltip_26'=>'Kommentare pro Seite',
  'tooltip_27'=>'Private Nachrichten pro Seite',
  'tooltip_28'=>'Clanwars pro Seite',
  'tooltip_29'=>'Registrierte Benutzer pro Seite',
  'tooltip_30'=>'Resultate aufgelistet in sc_results',
  'tooltip_31'=>'Letzte Beiträge aufgelistet im Profil',
  'tooltip_32'=>'Geplante Einträge aufgelistet in sc_upcoming',
  'tooltip_33'=>'Anmeldungsdauer [in Stunden] (0 = 20 Minuten)',
  'tooltip_34'=>'Maximale Größe (Breite) für den Inhalt (Bilder, Textfelder usw.) (0 = deaktiviert)',
  'tooltip_35'=>'Maximale Größe (Höhe) für Bilder (0 = deaktiviert)',
  'tooltip_36'=>'Sollen Feedback-Admins eine Nachricht bei einem neuen Gästebuch Eintrag bekommen?',
  'tooltip_37'=>'Shoutboxkommentare, welche in der Shoutbox angezeigt werden',
  'tooltip_38'=>'Maximal gespeicherte Kommentare in der Shoutbox',
  'tooltip_39'=>'Dauer (in Sekunden) für das Nachladen der Shoutbox',
  'tooltip_40'=>'Standardsprache für die Seite',
  'tooltip_41'=>'Sollen die Links zu den Member Profilen automatisch gesetzt werden?',
  'tooltip_42'=>'Maximale Länge für die letzten Themen in latesttopics',
  'tooltip_43'=>'Maximale Anzahl falscher Password Eingaben vor IP Ban',
  'tooltip_44'=>'Anzeigeart des Captchas',
  'tooltip_45'=>'Hintergrundfarbe des Captchas',
  'tooltip_46'=>'Schriftfarbe des Captchas',
  'tooltip_47'=>'Art des Captchas',
  'tooltip_48'=>'Anzahl der Störungen',
  'tooltip_49'=>'Anzahl der Störungslinien',
  'tooltip_50'=>'Auswahl der automatischen Inhaltsgrößenanpassung',
  'tooltip_51'=>'Maximale Länge für die Top Neuigkeiten in sc_topnews',
  'tooltip_52'=>'Sprache des Besuchers automatisch erkennen',
  'tooltip_53'=>'Beiträge mit externer Datenbank validieren',
  'tooltip_54'=>'Tragen Sie hier ihren Spam API-Schlüssel ein wenn vorhanden',
  'tooltip_55'=>'Tragen Sie hier die URL zum API Host Server ein.<br>Standard: https://api.webspell.org',
  'tooltip_56'=>'Anzahl Beiträge ab wann nicht mehr mit externer Datenbank validiert wird',
  'tooltip_57'=>'Sollen die Beiträge bei einem Fehler blockiert werden?',
  'tooltip_58'=>'Ausgabeformat des Datums',
  'tooltip_59'=>'Ausgabeformat der Zeit',
  'tooltip_60'=>'Benutzer Gästebücher auf der Seite aktivieren?',
  'tooltip_61'=>'Was soll das SC Demos Modul anzeigen?',
  'tooltip_62'=>'Was soll das SC Dateien Modul anzeigen?',
  'tooltip_63'=>'Registrierung mit gleicher IP Adresse blockieren?'
);
 

