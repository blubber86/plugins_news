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



$ds = safe_query("SELECT * FROM `" . PREFIX . "plugins_news`  ORDER BY `date` ");
    
   $n=1;

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
            $rubricpic = '<img src="' . $rubricpic . '" alt="" class="img-fluid">';
            
        }

        
        
        $content = htmloutput($ds['content']);
        $headline = cleartext($ds['headline']);
        

        $headline = clearfromtags($headline);
        
        $poster = '<a href="index.php?site=profile&amp;id=' . $ds[ 'poster' ] . '">
            <strong>' . getnickname($ds[ 'poster' ]) . '</strong>
        </a>';
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

   

        if (mb_strlen($content) > $maxnewschars) {
        $content = mb_substr($content, 0, $maxnewschars);
        $content .= '<b class="text-primary">[...]</b><br><a href="index.php?site=news_comments&amp;newsID=' . $ds[ 'newsID' ] . '" class="btn btn-primary">READMORE</a>';
        }
   
        $data_array = array();
        $data_array['$related'] = $related;
        $data_array['$headline'] = $headline;
        $data_array['$line'] = $line;
        $data_array['$rubrikname'] = $rubrikname;
        $data_array['$rubric_pic'] = $rubricpic;
        $data_array['$content'] = $content;
        $data_array['$poster'] = $poster;
        $data_array['$date'] = $date;
        
        $css = '<link href="'.$plugin_path.'css/news.css" rel="stylesheet">';
        $news = $GLOBALS["_template"]->loadTemplate("news","content_area", $data_array, $plugin_path);
        echo $css . $news;
        $n++;
        
       }
   if($pages>1) echo $page_link;

