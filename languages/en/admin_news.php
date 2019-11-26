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

    
    'news' => 'News',
    'delete' => 'delete',
    'edit' => 'edit',
    'date' => 'Date',
    'save_news' => 'save news',
    'edit_news' =>'edit news',
    'new_post' => 'new post',
    'really_delete' => 'Really delete this news?',
    'rubric' => 'rubric',
    'headline' => 'headline',
    'text' => 'Text',
    'no'=>'no',
    'yes'=>'yes',
    'actions'=>'actions',
    'link' => 'Link',
    'new_window' => 'new window',
    'settings'=>'News settings',
    'max_news'=>'News per page',
    'max_archiv'=>'News in the archive per page',
    'max_admin'=>'News in the Admincenter per page',
    'max_length_news'=>'max length news',
    'max_headlines'=>'Latest news listed in sc_headlines',
    'max_length_headlines'=>'max length headlines',
    'max_length_topnews'=>'max length topnews',
    'update'=>'update',
    'is_displayed'=>'is displayed?',
    'news_rubrics'=>'news rubrics',
    'back'=>'back',
    'banner'=>'banner',
    'banner_to_big'=>'banner to big',
    'current_banner'=>'current banner',
    'max_88x31'=>'(max. 88x31)',
    'format_incorrect'=>'The format of the banner was wrong. Please only upload banners in * .gif, * .jpg or * .png format.',
    'add_to_message'=>'add to message',
    'upload'=>'upload',
    'title' => 'News',
    'options'=>'Options',
    'publication_setting' => 'Publication Setting',
    'info'=> '<div class="alert alert-warning" role="alert"><b>Voice Application:</b><br>
The headline and the text must have a corresponding language tag, which looks like this.<br>{[de]} Überschrift und Text in deutscher Sprache.<br>
{[en]} Heading and text in English.</div>',
  'description' => 'sc_Datei Info',
  'privacy_policy_title' => '<h4>Info for the manual integration of the sc_file. <br> <small> (Alternative: The widget control.) </ small></h4><br>',
  'privacy_policy_text' => '<p>Copy the following lines and paste them in the desired location in index.php.</p>',

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
 

