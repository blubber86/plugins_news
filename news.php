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

if(isset($_GET['page'])) $page=(int)$_GET['page'];
  else $page = 1;

    $data_array = array();
    $data_array['$title']=$_lang['title'];

    $template = $GLOBALS["_template"]->loadTemplate("news","head", $data_array, $plugin_path);
    echo $template;

   $alle=safe_query("SELECT newsID FROM ".PREFIX."plugins_news");
  $gesamt = mysqli_num_rows($alle);
  $pages=1;

  #=========
  $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $dn = mysqli_fetch_array($settings);

    
        $max = $dn[ 'news' ];
        if (empty($max)) {
        $max = 10;
        }
 
        
  #=========      

  #$max='1';

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
    
   $n=1;

        #while ($db = mysqli_fetch_array($ergebnis)) { 
       #$n = 1; 
        while ($ds = mysqli_fetch_array($ergebnis)) {
        $date = getformatdate($ds[ 'date' ]);
        $time = getformattime($ds[ 'date' ]);
        $rubrikname = getrubricname($ds[ 'rubric' ]);
        $rubrikname_link = getinput($rubrikname);
        $rubricpic_name = getrubricpic($ds[ 'rubric' ]);
        

        $rubricpic = $plugin_path.'/images/news-rubrics/' . $rubricpic_name;
        if (!file_exists($rubricpic) || $rubricpic_name == '') {
            $rubricpic = '';
        } else {
            $rubricpic = '<img align="left" src="' . $rubricpic . '" alt="" class="img-responsive">';
            
        }

        /*if ($ds[ 'comments' ]) {
           $anzcomments = getanzcomments($ds[ 'newsID' ], 'ne');
                $replace = array('$anzcomments', '$url', '$lastposter', '$lastdate');
                $vars = array(
                    $anzcomments,
                    'index.php?site=news_comments&amp;newsID=' . $ds[ 'newsID' ],
                    clearfromtags(html_entity_decode(getlastcommentposter($ds[ 'newsID' ], 'ne'))),
                    getformatdatetime(getlastcommentdate($ds[ 'newsID' ], 'ne'))
                );

                switch ($anzcomments) {
                    case 0:
                        $comments = str_replace($replace, $vars, $plugin_language[ 'no_comment' ]);
                        break;
                    case 1:
                        $comments = str_replace($replace, $vars, $plugin_language[ 'comment' ]);
                        break;
                    default:
                        $comments = str_replace($replace, $vars, $plugin_language[ 'comments' ]);
                        break;
                }
           
        } else {
            $comments = '';
        }*/

        #$n = 1;
        
        $content = htmloutput($ds['content']);
        $headline = cleartext($ds['headline']);
        

        $content = htmloutput($content);
        $content = toggle($content, $ds[ 'newsID' ]);
        $headline = clearfromtags($headline);
        #$comments = '';

        $poster = '<a href="index.php?site=profile&amp;id=' . $ds[ 'poster' ] . '">
            <strong>' . getnickname($ds[ 'poster' ]) . '</strong>
        </a>';
        #$line = '<a href="index.php?site=news_comments&amp;newsID=' . $ds[ 'newsID' ] . '">
        #    <strong>' . $headline . '</strong>
        #</a>';
        $line = '<strong style="color: #fe821d">' . $headline . '</strong> ';

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

 /*       $set = safe_query("SELECT * FROM " . PREFIX . "plugins_news_rubrics WHERE (displayed = '1')");
        if (mysqli_num_rows($set)) {
    while ($da = mysqli_fetch_array($set)) {


        $data_array = array();
        $data_array['$rubric_pic'] = $rubricpic;
}}
*/
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

   

        #$content = nl2br(strip_tags(htmloutput($content)));
        $translate = new multiLanguage(detectCurrentLanguage());
        $translate->detectLanguages($content);
        $content = $translate->getTextByLanguage($content);

        if (mb_strlen($content) > $maxnewschars) {
        $content = mb_substr($content, 0, $maxnewschars);
        $content .= '<b class="text-primary">[...]</b><br><a href="index.php?site=news_comments&amp;newsID=' . $ds[ 'newsID' ] . '" class="btn btn-primary">READMORE</a>';
        }

    

        #$tags = \webspell\Tags::getTagsLinked('news', $newsID);

        $data_array = array();
        $data_array['$related'] = $related;
        $data_array['$headline'] = $headline;
        $data_array['$line'] = $line;
        $data_array['$rubrikname'] = $rubrikname;
        $data_array['$rubric_pic'] = $rubricpic;
        $data_array['$content'] = $content;
        $data_array['$poster'] = $poster;
        $data_array['$date'] = $date;
        #$data_array['$comments'] = $comments;
        
        $css = '<link href="'.$plugin_path.'css/news.css" rel="stylesheet">';
        $news = $GLOBALS["_template"]->loadTemplate("news","content_area", $data_array, $plugin_path);
        echo $css . $news;
        $n++;
        
       }
   if($pages>1) echo $page_link;

