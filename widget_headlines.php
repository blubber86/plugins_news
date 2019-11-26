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
    $plugin_language = $pm->plugin_language("news", $plugin_path);

    // -- COMMENTS INFORMATION -- //
include_once("news_functions.php");

    $data_array = array();
    $data_array['$title']=$plugin_language['title'];
    $template = $GLOBALS["_template"]->loadTemplate("sc_headlines","head", $data_array, $plugin_path);
    echo $template;


if (isset($rubricID) && $rubricID) {
    $only = "AND rubric='" . $rubricID . "'";
} else {
    $only = '';
}

        $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $ds = mysqli_fetch_array($settings);

    
        $maxheadlines = $ds[ 'headlines' ];
        if (empty($maxheadlines)) {
        $maxheadlines = 4;
        }
 
$ergebnis = safe_query(
    "SELECT
        *
    FROM
        " . PREFIX . "plugins_news ORDER BY
        date DESC
    LIMIT 0," . $maxheadlines
);
if (mysqli_num_rows($ergebnis)) {
   # echo '<div class="container"><ul class="nav">';
    $n = 1;
    while ($ds = mysqli_fetch_array($ergebnis)) {
        $date = getformatdate($ds[ 'date' ]);
        $time = getformattime($ds[ 'date' ]);
        $news_id = $ds[ 'newsID' ];

        
        $message_array = array();
        $query =
            safe_query(
                "SELECT
                    *
                FROM
                    " . PREFIX . "plugins_news"
            );
        while ($qs = mysqli_fetch_array($query)) {
            $message_array[ ] = array(
                'headline' => $qs[ 'headline' ],
                'message' => $qs[ 'content' ],
            );
        }
        
        $headline = $ds['headline'];
        $headline = $headline;

        $line = '<b class="text-primary">' . $headline . '</b>&nbsp;&nbsp;<a href="index.php?site=news_contents&amp;newsID=' . $ds[ 'newsID' ] . '" class="btn btn-primary">READMORE</a>';
        

        $rubrikname = getnewsrubricname($ds[ 'rubric' ]);
        $rubrikname_link = getinput($rubrikname);
        $rubricpic_name = getnewsrubricpic($ds[ 'rubric' ]);
        $rubricpic = $plugin_path.'/images/news-rubrics/' . $rubricpic_name;
        
        if (!file_exists($rubricpic) || $rubricpic_name == '') {
            $rubricpic = '';
        } else {
            $rubricpic = '<img src="' . $rubricpic . '" alt=""  style="width: 660px" class="i1mg-fluid">';
            }

        $data_array = array();
        $data_array['$date'] = $date;
        $data_array['$time'] = $time;
        $data_array['$news_id'] = $news_id;
        $data_array['$line'] = $line;
        $data_array['$headline'] = $headline;
        $data_array['$rubricpic'] = $rubricpic;

        $template = $GLOBALS["_template"]->loadTemplate("sc_headlines","content", $data_array, $plugin_path);
        echo $template;

        $n++;
    }
    #echo '</ul></div>';
    unset($rubricID);
}
        $data_array = array();
        $template = $GLOBALS["_template"]->loadTemplate("sc_headlines","foot", $data_array, $plugin_path);
        echo $template;
