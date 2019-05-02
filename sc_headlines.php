<?php
/*
##########################################################################
#                                                                        #
#           Version 4       /                        /   /               #
#          -----------__---/__---__------__----__---/---/-               #
#           | /| /  /___) /   ) (_ `   /   ) /___) /   /                 #
#          _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/___               #
#                       Free Content / Management System                 #
#                                   /                                    #
#                                                                        #
#                                                                        #
#   Copyright 2005-2015 by webspell.org                                  #
#                                                                        #
#   visit webSPELL.org, webspell.info to get webSPELL for free           #
#   - Script runs under the GNU GENERAL PUBLIC LICENSE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
#   Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at),   #
#   Far Development by Development Team - webspell.org                   #
#                                                                        #
#   visit webspell.org                                                   #
#                                                                        #
##########################################################################
*/
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
