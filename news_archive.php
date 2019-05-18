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
    $data_array['$lang_date']=$_lang['date'];
    $data_array['$lang_rubric']=$_lang['rubric'];
    $data_array['$lang_headline']=$_lang['headline'];
    $data_array['$news']=$_lang['news'];

    $template = $GLOBALS["_template"]->loadTemplate("news_archive","head", $data_array, $plugin_path);
    echo $template;

   $alle=safe_query("SELECT newsID FROM ".PREFIX."plugins_news");
  $gesamt = mysqli_num_rows($alle);
  $pages=1;

  
  $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $dn = mysqli_fetch_array($settings);

    
        $max = $dn[ 'newsarchiv' ];
        if (empty($max)) {
        $max = 10;
        }
 

  for ($n=$max; $n<=$gesamt; $n+=$max) {
    if($gesamt>$n) $pages++;
  }

  if($pages>1) $page_link = makepagelink("index.php?site=news_archive", $page, $pages);
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
        


                $headlines = '<a href="index.php?site=news_comments&amp;newsID=' . $ds[ 'newsID' ] . '">' .
                    cleartext($ds['headline']) . '</a><br>';
         
        $content = htmloutput($ds['content']);
        
        $poster = '<a href="index.php?site=profile&amp;id=' . $ds[ 'poster' ] . '">
            <strong>' . getnickname($ds[ 'poster' ]) . '</strong>
        </a>';
        

 
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

        #$headlines = $ds[ 'headlines' ];
        

        $translate = new multiLanguage(detectCurrentLanguage());
            $translate->detectLanguages($headlines);
            $headlines = $translate->getTextByLanguage($headlines);
            
    
    
            $headlines = toggle(htmloutput($headlines), 1);
            $headlines = toggle($headlines, 1);
            

        $data_array = array();
        
        $data_array['$headlines'] = $headlines;
        $data_array['$rubrikname'] = $rubrikname;
        
        $data_array['$poster'] = $poster;
        $data_array['$date'] = $date;
        

            $template = $GLOBALS["_template"]->loadTemplate("news_archive","content", $data_array, $plugin_path);
            echo $template;

        $n++;
        
       }
       $template = $GLOBALS["_template"]->loadTemplate("news_archive","foot", $data_array, $plugin_path);
            echo $template;
   if($pages>1) echo $page_link;

