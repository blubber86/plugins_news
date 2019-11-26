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
$plugin_language = $pm->plugin_language("admin_news", $plugin_path);

$_language->readModule('admin_news', false, true);

$ergebnis = safe_query("SELECT * FROM ".PREFIX."navigation_dashboard_links WHERE modulname='news_settings'");
    while ($db=mysqli_fetch_array($ergebnis)) {
      $accesslevel = 'is'.$db['accesslevel'].'admin';

if (!$accesslevel($userID) || mb_substr(basename($_SERVER[ 'REQUEST_URI' ]), 0, 15) != "admincenter.php") {
    die($plugin_language[ 'access_denied' ]);
}
}

if (isset($_POST[ 'submit' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        safe_query(
            "UPDATE
                " . PREFIX . "plugins_news_settings
            SET
                
                admin_news='" . $_POST[ 'admin_news' ] . "',
                news='" . $_POST[ 'news' ] . "',
                newsarchiv='" . $_POST[ 'newsarchiv' ] . "',
                headlines='" . $_POST[ 'headlines' ] . "',
                newschars='" . $_POST[ 'newschars' ] . "',
                headlineschars='" . $_POST[ 'headlineschars' ] . "',
                topnewschars='" . $_POST[ 'topnewschars' ] . "',
                feedback='" . $_POST[ 'feedback' ] . "' "
        );
        
        redirect("admincenter.php?site=admin_news_settings", "", 0);
    } else {
        redirect("admincenter.php?site=admin_news_settings", $plugin_language[ 'transaction_invalid' ], 3);
    }
} else {
    $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
    $ds = mysqli_fetch_array($settings);

    
  $maxshownnews = $ds[ 'news' ];
if (empty($maxshownnews)) {
    $maxshownnews = 10;
}
$maxnewsarchiv = $ds[ 'newsarchiv' ];
if (empty($maxnewsarchiv)) {
    $maxnewsarchiv = 20;
}
$maxheadlines = $ds[ 'headlines' ];
if (empty($maxheadlines)) {
    $maxheadlines = 2;
}
$maxheadlinechars = $ds[ 'headlineschars' ];
if (empty($maxheadlinechars)) {
    $maxheadlinechars = 2;
}
$maxtopnewschars = $ds[ 'topnewschars' ];
if (empty($maxtopnewschars)) {
    $maxtopnewschars = 200;
} 
$maxnewschars = $ds[ 'newschars' ];
if (empty($maxnewschars)) {
    $maxnewschars = 200;
}
$maxfeedback = $ds[ 'feedback' ];
if (empty($maxfeedback)) {
    $maxfeedback = 5;
}  
    
    
    

    

    

    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();
    ?>
    <form method="post" action="admincenter.php?site=admin_news_settings">
        <div class="card">
            <div class="card-header">
                <?php echo $plugin_language[ 'settings' ]; ?>
            </div>

            <div class="card-body">
                <div class="col-md-10 form-group"><a href="admincenter.php?site=admin_news" class="white"><?php echo $plugin_language['title']; ?></a> &raquo; <a href="admincenter.php?site=admin_news_settings" class="white"><?php echo $plugin_language['settings']; ?></a> &raquo; Edit</div>
<div class="col-md-2 form-group"></div><br><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['max_admin']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_2' ]; ?>"><input class="form-control" name="admin_news" type="text" value="<?php echo getinput($ds[ 'admin_news' ]); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['max_news']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_3' ]; ?>"><input class="form-control" type="text" name="news" value="<?php echo getinput($ds['news']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['max_archiv']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_5' ]; ?>"><input class="form-control" type="text" name="newsarchiv" value="<?php echo getinput($ds['newsarchiv']); ?>" size="35" ></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['max_headlines']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_1' ]; ?>"><input class="form-control" type="text" name="headlines" value="<?php echo getinput($ds['headlines']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        
                    </div>

                    <div class="col-md-6">
                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['max_length_news']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_4' ]; ?>"><input class="form-control" type="text" name="newschars" value="<?php echo getinput($ds['newschars']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['max_length_headlines']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_4' ]; ?>"><input class="form-control" type="text" name="headlineschars" value="<?php echo getinput($ds['headlineschars']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['max_length_topnews']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_6' ]; ?>"><input class="form-control" type="text" name="topnewschars" value="<?php echo getinput($ds['topnewschars']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $plugin_language['comments']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $plugin_language[ 'tooltip_26' ]; ?>"><input class="form-control" type="text" name="feedback" value="<?php echo $ds['feedback']; ?>" size="35"></em></span>
                            </div>
                        </div>
                    </div>
               </div>
                <br>
 <div class="form-group">
<input type="hidden" name="captcha_hash" value="<?php echo $hash; ?>"> 
<button class="btn btn-primary" type="submit" name="submit"><?php echo $plugin_language['update']; ?></button>
</div>

        

 </div>
            </div>
       
        
    </form>
<?php
}
?>

