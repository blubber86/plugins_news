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
        $rubrikname = getrubricname($ds[ 'rubric' ]);
        $rubrikname_link = getinput($rubrikname);
        $rubricpic_name = getrubricpic($ds[ 'rubric' ]);
        $rubricpic = $plugin_path.'/images/news-rubrics/' . $rubricpic_name;
        
        if (!file_exists($rubricpic) || $rubricpic_name == '') {
            $rubricpic = '';
        } else {
            $rubricpic = '<img src="' . $rubricpic . '" alt="" class="img-fluid">';
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
        
        $content = htmloutput($ds['content']);
        $headline = cleartext($ds['headline']);
        

        $content = htmloutput($content);
        $content = toggle($content, $ds[ 'newsID' ]);
        $headline = clearfromtags($headline);
        $comments = '';

        $poster = '<a href="index.php?site=profile&amp;id=' . $ds[ 'poster' ] . '">
            <strong>' . getnickname($ds[ 'poster' ]) . '</strong>
        </a>';
        $line = '<a href="index.php?site=news_comments&amp;newsID=' . $ds[ 'newsID' ] . '">
            <strong>' . $headline . '</strong>
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

        
        $tags = \webspell\Tags::getTagsLinked('news', $newsID);

        $data_array = array();
        $data_array['$related'] = $related;
        $data_array['$newsID'] = $newsID;
        $data_array['$line'] = $line;
        $data_array['$rubrikname'] = $rubrikname;
        $data_array['$rubric_pic'] = $rubricpic;
        $data_array['$content'] = $content;
        $data_array['$poster'] = $poster;
        $data_array['$date'] = $date;
        
        $news = $GLOBALS["_template"]->loadTemplate("news","content_area", $data_array, $plugin_path);
        echo $news;

    }
}
