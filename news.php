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

if(isset($_GET['page'])) $page=(int)$_GET['page'];
  else $page = 1;

    $data_array = array();
    $data_array['$title']=$_lang['title'];

    $template = $GLOBALS["_template"]->loadTemplate("news","head", $data_array, $plugin_path);
    echo $template;

   $alle=safe_query("SELECT newsID FROM ".PREFIX."plugins_news");
  $gesamt = mysqli_num_rows($alle);
  $pages=1;

  
  $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $dn = mysqli_fetch_array($settings);

    
        $max = $dn[ 'news' ];
        if (empty($max)) {
        $max = 10;
        }
 

  for ($n=$max; $n<=$gesamt; $n+=$max) {
    if($gesamt>$n) $pages++;
  }

  if($pages>1) $page_link = makepagelink("index.php?site=news", $page, $pages);
    else $page_link='';

  if ($page == "1") {
    $ergebnis = safe_query("SELECT * FROM ".PREFIX."plugins_news WHERE displayed = '1' ORDER BY date DESC LIMIT 0,$max");
    $n=1;
  }
  else {
    $start=$page*$max-$max;
    $ergebnis = safe_query("SELECT * FROM ".PREFIX."plugins_news WHERE displayed = '1' ORDER BY date DESC LIMIT $start,$max");
    $n = ($gesamt+1)-$page*$max+$max;
  } 


$ds = safe_query("SELECT * FROM `" . PREFIX . "plugins_news`  ORDER BY `date`");
    $anzcats = mysqli_num_rows($ds);
    if ($anzcats) {


        $template = $GLOBALS["_template"]->loadTemplate("news","content_area_head", $data_array, $plugin_path);
        echo $template;
    
   $n=1;

        while ($ds = mysqli_fetch_array($ergebnis)) {
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
            $related .= '<i class="fa fa-link"></i> <a href="' . $ds[ 'url1' ] . '" target="_blank">' . $ds[ 'link1' ] . '</a> ';
        }
        if ($ds[ 'link1' ] && $ds[ 'url1' ] != "http://" && !$ds[ 'window1' ]) {
            $related .= '<i class="fa fa-link"></i> <a href="' . $ds[ 'url1' ] . '">' . $ds[ 'link1' ] . '</a> ';
        }

        if ($ds[ 'link2' ] && $ds[ 'url2' ] != "http://" && $ds[ 'window2' ]) {
            $related .= '<i class="fa fa-link"></i> <a href="' . $ds[ 'url2' ] . '" target="_blank">' . $ds[ 'link2' ] . '</a> ';
        }
        if ($ds[ 'link2' ] && $ds[ 'url2' ] != "http://" && !$ds[ 'window2' ]) {
            $related .= '<i class="fa fa-link"></i> <a href="' . $ds[ 'url2' ] . '">' . $ds[ 'link2' ] . '</a> ';
        }

        if (empty($related)) {
            $related = "n/a";
        } 

        
        $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $dx = mysqli_fetch_array($settings);

    
        $maxshownnews = $dx[ 'news' ];
        if (empty($maxshownnews)) {
        $maxshownnews = 10;
        }
 
        $maxnewschars = $dx[ 'newschars' ];
        if (empty($maxnewschars)) {
        $maxnewschars = 200;
        } 

        $headline = $ds[ 'headline' ];
        $content = $ds[ 'content' ];
        
            $translate = new multiLanguage(detectCurrentLanguage());
            $translate->detectLanguages($headline);
            $headline = $translate->getTextByLanguage($headline);
            $translate->detectLanguages($content);
            $content = $translate->getTextByLanguage($content);
    
        if (mb_strlen($content) > $maxnewschars) {
        $content = mb_substr($content, 0, $maxnewschars);
        $content .= '<b class="text-primary">[...]</b><br><a href="index.php?site=news_contents&amp;newsID=' . $ds[ 'newsID' ] . '" class="btn btn-primary">READMORE</a>';
        }

        $data_array = array();
        $data_array['$related'] = $related;
        $data_array['$headline'] = $headline;
        $data_array['$rubrikname'] = $rubrikname;
        $data_array['$rubric_pic'] = $rubricpic;
        $data_array['$content'] = $content;
        $data_array['$poster'] = $poster;
        $data_array['$date'] = $date;
        $data_array['$comments'] = $comments;

        $template = $GLOBALS["_template"]->loadTemplate("news","content_area", $data_array, $plugin_path);
        echo $template;
        $n++;
        unset($comments);
       }
       $template = $GLOBALS["_template"]->loadTemplate("news","content_area_foot", $data_array, $plugin_path);
        echo $template;
       } else {
        echo $_lang[ 'no_news' ];
    }
   if($pages>1) echo $page_link;

