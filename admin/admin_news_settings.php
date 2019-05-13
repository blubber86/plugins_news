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
$_lang = $pm->plugin_language("admin_news", $plugin_path);

$_language->readModule('admin_news', false, true);

if (!ispageadmin($userID) || mb_substr(basename($_SERVER[ 'REQUEST_URI' ]), 0, 15) != "admincenter.php") {
    die($_lang[ 'access_denied' ]);
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
                topnewschars='" . $_POST[ 'topnewschars' ] . "' "
        );
        
        redirect("admincenter.php?site=admin_news_settings", "", 0);
    } else {
        redirect("admincenter.php?site=admin_news_settings", $_lang[ 'transaction_invalid' ], 3);
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
    $maxheadlines = 10;
}
$maxheadlinechars = $ds[ 'headlineschars' ];
if (empty($maxheadlinechars)) {
    $maxheadlinechars = 18;
}
$maxtopnewschars = $ds[ 'topnewschars' ];
if (empty($maxtopnewschars)) {
    $maxtopnewschars = 200;
} 
$maxnewschars = $ds[ 'newschars' ];
if (empty($maxnewschars)) {
    $maxnewschars = 200;
}  
    
    
    

    

    

    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();
    ?>
    <form method="post" action="admincenter.php?site=admin_news_settings">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo $_lang[ 'settings' ]; ?>
            </div>

            <div class="panel-body">
                <div class="col-md-10 form-group"><a href="admincenter.php?site=admin_news" class="white"><?php echo $_lang['title']; ?></a> &raquo; <a href="admincenter.php?site=admin_news_settings" class="white"><?php echo $_lang['settings']; ?></a> &raquo; Edit</div>
<div class="col-md-2 form-group"></div><br><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $_lang['max_admin']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $_lang[ 'tooltip_2' ]; ?>"><input class="form-control" name="admin_news" type="text" value="<?php echo getinput($ds[ 'admin_news' ]); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $_lang['max_news']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $_lang[ 'tooltip_3' ]; ?>"><input class="form-control" type="text" name="news" value="<?php echo getinput($ds['news']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $_lang['max_archiv']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $_lang[ 'tooltip_5' ]; ?>"><input class="form-control" type="text" name="newsarchiv" value="<?php echo getinput($ds['newsarchiv']); ?>" size="35" ></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $_lang['max_headlines']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $_lang[ 'tooltip_1' ]; ?>"><input class="form-control" type="text" name="headlines" value="<?php echo getinput($ds['headlines']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        
                    </div>

                    <div class="col-md-6">
                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $_lang['max_length_news']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $_lang[ 'tooltip_4' ]; ?>"><input class="form-control" type="text" name="newschars" value="<?php echo getinput($ds['newschars']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $_lang['max_length_headlines']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $_lang[ 'tooltip_4' ]; ?>"><input class="form-control" type="text" name="headlineschars" value="<?php echo getinput($ds['headlineschars']); ?>" size="35"></em></span>
                            </div>
                        </div>

                        <div class="row bt">
                            <div class="col-md-6">
                                <?php echo $_lang['max_length_topnews']; ?>:
                            </div>

                            <div class="col-md-6">
                                <span class="pull-right text-muted small"><em data-toggle="tooltip" title="<?php echo $_lang[ 'tooltip_6' ]; ?>"><input class="form-control" type="text" name="topnewschars" value="<?php echo getinput($ds['topnewschars']); ?>" size="35"></em></span>
                            </div>
                        </div>
                    </div>
               </div>
                <br>
 <div class="form-group">
<input type="hidden" name="captcha_hash" value="<?php echo $hash; ?>"> 
<button class="btn btn-primary" type="submit" name="submit"><?php echo $_lang['update']; ?></button>
</div>

        

 </div>
            </div>
       
        
    </form>
<?php
}
?>

