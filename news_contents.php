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

// -- COMMENTS INFORMATION -- //
include_once("news_functions.php");


    $data_array = array();
    $data_array['$title']=$_lang['title'];

    $template = $GLOBALS["_template"]->loadTemplate("news","head", $data_array, $plugin_path);
    echo $template;

    if (isset($newsID)) {
    unset($newsID);
    }
    if (isset($_GET[ 'newsID' ])) {
    $newsID = $_GET[ 'newsID' ];
    }
    


if (isset($newsID)) {
    $result = safe_query("SELECT * FROM " . PREFIX . "plugins_news WHERE `newsID` = '" . $newsID."'");
    $ds = mysqli_fetch_array($result);

     {
        $date = getformatdate($ds[ 'date' ]);
        $time = getformattime($ds[ 'date' ]);
        $rubrikname = getnewsrubricname($ds[ 'rubric' ]);
        $rubrikname_link = getinput($rubrikname);
        $rubricpic_name = getnewsrubricpic($ds[ 'rubric' ]);
        $rubricpic = $plugin_path.'/images/news-rubrics/' . $rubricpic_name;
        
        if (!file_exists($rubricpic) || $rubricpic_name == '') {
            $rubricpic = '';
        } else {
            $rubricpic = '<img align="left" src="' . $rubricpic . '" alt="" class="img-fluid">';
            }

        $query = safe_query(
            "SELECT
                newsID
            FROM
                " . PREFIX . "plugins_news 
            WHERE
                newsID='" . $newsID."'"
        );
        
        $i = 0;
        
        $comments = '';

        if ($ds[ 'comments' ]) {
            if ($ds[ 'newsID' ]) {
                $anzcomments = getanznewscomments($ds[ 'newsID' ], 'ne');
                $replace = array('$anzcomments', '$url', '$lastposter', '$lastdate');
                $vars = array(
                    $anzcomments,
                    'index.php?site=news_contents&amp;newsID=' . $ds[ 'newsID' ],
                    html_entity_decode(getlastnewscommentposter($ds[ 'newsID' ], 'ne')),
                    getformatdatetime(getlastnewscommentdate($ds[ 'newsID' ], 'ne'))
                );

                switch ($anzcomments) {
                    case 0:
                        $comments = str_replace($replace, $vars, $_lang[ 'no_comment' ]);
                        break;
                    case 1:
                        $comments = str_replace($replace, $vars, $_lang[ 'comment' ]);
                        break;
                    default:
                        $comments = str_replace($replace, $vars, $_lang[ 'comments' ]);
                        break;
                }
            }
        } else {
            $comments = $_lang[ 'off_comments' ];
        }

        $poster = '<a href="index.php?site=profile&amp;id=' . $ds[ 'poster' ] . '">
            <strong>' . getnickname($ds[ 'poster' ]) . '</strong>
        </a>';
        
        $related = "";
        if ($ds[ 'link1' ] && $ds[ 'url1' ] != "http://" && $ds[ 'window1' ]) {
            $related .= '&#8226; <a href="' . $ds[ 'url1' ] . '" target="_blank">' . $ds[ 'link1' ] . '</a> ';
        }
        if ($ds[ 'link1' ] && $ds[ 'url1' ] != "http://" && !$ds[ 'window1' ]) {
            $related .= '&#8226; <a href="' . $ds[ 'url1' ] . '">' . $ds[ 'link1' ] . '</a> ';
        }

        if ($ds[ 'link2' ] && $ds[ 'url2' ] != "http://" && $ds[ 'window2' ]) {
            $related .= '&#8226; <a href="' . $ds[ 'url2' ] . '" target="_blank">' . $ds[ 'link2' ] . '</a> ';
        }
        if ($ds[ 'link2' ] && $ds[ 'url2' ] != "http://" && !$ds[ 'window2' ]) {
            $related .= '&#8226; <a href="' . $ds[ 'url2' ] . '">' . $ds[ 'link2' ] . '</a> ';
        }

        if (empty($related)) {
            $related = "n/a";
        }    

        $headline = $ds[ 'headline' ];
        $content = $ds[ 'content' ];

            $translate = new multiLanguage(detectCurrentLanguage());
            $translate->detectLanguages($headline);
            $headline = $translate->getTextByLanguage($headline);
            $translate->detectLanguages($content);
            $content = $translate->getTextByLanguage($content);
    

        $tags = \webspell\Tags::getTagsLinked('news', $newsID);

        $data_array = array();
        $data_array['$related'] = $related;
        $data_array['$newsID'] = $newsID;
        $data_array['$headline'] = $headline;
        $data_array['$rubrikname'] = $rubrikname;
        $data_array['$rubric_pic'] = $rubricpic;
        $data_array['$content'] = $content;
        $data_array['$poster'] = $poster;
        $data_array['$date'] = $date;
        $data_array['$comments'] = $comments;
        
        $news = $GLOBALS["_template"]->loadTemplate("news","content_area", $data_array, $plugin_path);
        echo $news;

        $comments_allowed = $ds[ 'comments' ];
        if ($ds[ 'newsID' ]) {
            $parentID = $newsID;
            $type = "ne";
        }

        $referer = "index.php?site=news_contents&amp;newsID=$newsID";

        include("news_comments.php");
    
    }
    
}
