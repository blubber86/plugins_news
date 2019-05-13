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
# Sprachdateien aus dem Plugin-Ordner laden
$pm = new plugin_manager(); 
$_lang = $pm->plugin_language("news", $plugin_path);

if (isset($rubricID) && $rubricID) {
    $only = "WHERE displayed='1' AND rubric='" . $rubricID . "'";
} else {
    $only = '';
}

$ergebnis = safe_query(
    "SELECT
        *
    FROM
        " . PREFIX . "plugins_news"
);
if (mysqli_num_rows($ergebnis)) {
    echo '<div class="container"><ul class="nav">';
    $n = 1;
    while ($ds = mysqli_fetch_array($ergebnis)) {
        
        $news_id = $ds[ 'newsID' ];
$headline = cleartext($ds['headline']);
        
        $message_array = array();
        $headline = clearfromtags($headline);
        
        $line = '<b class="text-primary">' . $headline . '</b>&nbsp;&nbsp;<a href="index.php?site=news_comments&amp;newsID=' . $ds[ 'newsID' ] . '" class="btn btn-primary">READMORE</a>';
        
        

$filepath = $plugin_path."images/";
        #$rubricpic = '<img style="width: 560px" src="' . $filepath . 'news-rubrics/' . getrubricpic($ds[ 'rubric' ]) . '" alt="">';
        $rubricpic = '<img src="' . $filepath . 'news-rubrics/' . getrubricpic($ds[ 'rubric' ]) . '" alt="">';

        $data_array = array();
        
        $data_array['$rubricpic'] = $rubricpic;
$data_array['$line'] = $line;

        #$sc_headlines = $GLOBALS["_template"]->replaceTemplate("sc_headlines", $data_array);
        #echo $sc_headlines;
        $css = '<link href="'.$plugin_path.'css/news.css" rel="stylesheet">';
        $template = $GLOBALS["_template"]->loadTemplate("sc_headlines","content", $data_array, $plugin_path);
        echo $css . $template;
        $n++;
    }
    echo '</ul></div>';
    unset($rubricID);
}
