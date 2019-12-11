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

// -- COMMENTS INFORMATION -- //
include_once('./includes/plugins/news/news_functions.php');
#print_r($_SERVER['DOCUMENT_ROOT']);

$_language->readModule('admin_news', false, true);

$ergebnis = safe_query("SELECT * FROM ".PREFIX."navigation_dashboard_links WHERE modulname='news'");
    while ($db=mysqli_fetch_array($ergebnis)) {
      $accesslevel = 'is'.$db['accesslevel'].'admin';

if (!$accesslevel($userID) || mb_substr(basename($_SERVER[ 'REQUEST_URI' ]), 0, 15) != "admincenter.php") {
    die($plugin_language[ 'access_denied' ]);
}
}

$filepath = $plugin_path."images/news-pic/";

if (isset($_GET[ 'action' ])) {
    $action = $_GET[ 'action' ];
} else {
    $action = '';
}
#================================== screen Anfang ===============================

if (isset($_POST[ 'submit' ])) {
    $_language->readModule('formvalidation', true);

    $screen = new \webspell\HttpUpload('screen');

    if ($screen->hasFile()) {
        if ($screen->hasError() === false) {
            $file = $_POST[ "newsID" ] . '_' . time() . "." .$screen->getExtension();
            $new_name = $filepath . $file;
            if ($screen->saveAs($new_name)) {
                @chmod($new_name, $new_chmod);
                $ergebnis = safe_query("SELECT screens FROM " . PREFIX . "plugins_news WHERE newsID='" . $_POST[ "newsID" ]."'");
                $dx = mysqli_fetch_array($ergebnis);
                $screens = explode('|', $dx[ 'screens' ]);
                $screens[ ] = $file;
                $screens_string = implode('|', $screens);

                $ergebnis = safe_query(
                    "UPDATE
                    " . PREFIX . "plugins_news
                    SET
                        screens='" . $screens_string . "'
                    
                WHERE `newsID` = '" . $_POST[ "newsID" ] . "'"
                );
            }
        }
    }
    header("Location: admincenter.php?site=admin_news&action=edit&newsID=" . $_POST[ "newsID" ] . "");



#================================== screen Ende ===============================



#================================== screen Anfang ===============================
} elseif (isset($_POST[ 'subadd' ])) {
    $_language->readModule('formvalidation', true);

    $screen = new \webspell\HttpUpload('screen');


    if ($screen->hasFile()) {
        if ($screen->hasError() === false) {
            $file = $_POST[ "newsID" ] . '_' . time() . "." .$screen->getExtension();
            $new_name = $filepath . $file;
            if ($screen->saveAs($new_name)) {
                @chmod($new_name, $new_chmod);
                $ergebnis = safe_query("SELECT screens FROM " . PREFIX . "plugins_news WHERE newsID='" . $_POST[ "newsID" ]."'");
                $ds = mysqli_fetch_array($ergebnis);
                $screens = explode('|', $ds[ 'screens' ]);
                $screens[ ] = $file;
                $screens_string = implode('|', $screens);
$CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {

        safe_query(
        "INSERT INTO
            " . PREFIX . "plugins_news (
                screens,
                date,
                poster
            )
            VALUES (
            '" . $screens_string . "',
                '" . time() . "',
                '" . $userID . "'
                )"
    );
    $newsID = mysqli_insert_id($_database);



            }
        }
   }
}
    header("Location: admincenter.php?site=admin_news&action=edit&newsID=" . $newsID . "");



#================================== screen Ende ===============================





} elseif (isset($_POST[ "saveedit" ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
    $headline = $_POST[ "headline" ];
    $content = $_POST[ "message" ];

    if (isset($_POST[ "displayed" ])) {
        $displayed = 1;
    } else {
        $displayed = 0;
    }
    if (!$displayed) {
        $displayed = 0;
    }

    $date = "";

    if (isset($_POST[ 'rubric' ])) {
        $rubric = $_POST[ 'rubric' ];
    } else {
        $rubric = 0;
    }

    $link1 = strip_tags($_POST[ 'link1' ]);
    $url1 = strip_tags($_POST[ 'url1' ]);
    
    if (isset($_POST[ "window1" ])) {
        $window1 = 1;
    } else {
        $window1 = 0;
    }
    if (!$window1) {
        $window1 = 0;
    }

    $link2 = strip_tags($_POST[ 'link2' ]);
    $url2 = strip_tags($_POST[ 'url2' ]);
    
    if (isset($_POST[ "window2" ])) {
        $window2 = 1;
    } else {
        $window2 = 0;
    }
    if (!$window2) {
        $window2 = 0;
    }

    $comments = $_POST[ 'comments' ];

    $date = strtotime($_POST['date']);
    


            $ergebnis = safe_query(
                "UPDATE
                    `" . PREFIX . "plugins_news`
                SET
                    `rubric` = '" . $rubric . "',
                    `headline` = '" . $headline . "',
                    `date` = '" . $date . "',
                    `poster` = '" . $userID . "',
                    `content`='" . $_POST[ 'message' ] . "',
                    `link1`='" . $link1 . "',
                    `url1`='" . $url1 . "',
                    `window1`='" . $window1 . "',
                    `link2`='" . $link2 . "',
                    `url2`='" . $url2 . "',
                    `window2`='" . $window2 . "',
                    `displayed`= '" . $displayed . "',
                    `comments`='" . $comments . "'
                WHERE `newsID` = '" . $_POST[ "newsID" ] . "'"
            );

  header("Location: admincenter.php?site=admin_news");
 
}
} elseif (isset($_GET[ 'delete' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_GET[ 'captcha_hash' ])) {
        $dg = mysqli_fetch_array(safe_query("SELECT * FROM " . PREFIX . "plugins_news WHERE newsID='" . $_GET[ 'newsID' ] . "'"));
        $screens = array();
        if (!empty($dg[ 'screens' ])) {
            $screens = explode("|", $dg[ 'screens' ]);
            foreach ($screens as $screen) {
                if ($screen != "") {   
                    if (file_exists($filepath . $screen . '')) {
                        @unlink($filepath . $screen . '');
                    }
                }
            }
        }
        safe_query("DELETE FROM " . PREFIX . "plugins_news WHERE newsID='" . $_GET[ 'newsID' ] . "'");
    } else {
        echo $plugin_language[ 'transaction_invalid' ];
    }

    

} elseif (isset($_POST[ "save" ])) {
    $headline = $_POST[ "headline" ];
    $content = $_POST[ "message" ];
    $content = str_replace('\r\n', "\n", $content);
    
    $link1 = strip_tags($_POST[ 'link1' ]);
    $url1 = strip_tags($_POST[ 'url1' ]);
    
    if (isset($_POST[ "window1" ])) {
        $window1 = 1;
    } else {
        $window1 = 0;
    }
    if (!$window1) {
        $window1 = 0;
    }

    $link2 = strip_tags($_POST[ 'link2' ]);
    $url2 = strip_tags($_POST[ 'url2' ]);
    
    if (isset($_POST[ "window2" ])) {
        $window2 = 1;
    } else {
        $window2 = 0;
    }
    if (!$window2) {
        $window2 = 0;
    }


    if (isset($_POST[ "displayed" ])) {
        $displayed = 1;
    } else {
        $displayed = 0;
    }
    if (!$displayed) {
        $displayed = 0;
    }

    if (isset($_POST[ 'rubric' ])) {
        $rubric = $_POST[ 'rubric' ];
    } else {
        $rubric = 0;
    }

    $comments = $_POST[ 'comments' ];

$CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        safe_query(
            "INSERT INTO
                    `" . PREFIX . "plugins_news` (
                    `rubric`,
                    `date`,
                    `poster`,
                    `headline`,
                    `content`,
                    `link1`,
                    `url1`,
                    `window1`,
                    `link2`,
                    `url2`,
                    `window2`,
                    `displayed`,
                    `comments`
                )
                VALUES (
                    '" . $rubric . "',
                    '" . time() . "',
                    '" . $userID . "',
                    '" . $headline . "',
                    '" . $content . "',
                    '" . $link1 . "',
                    '" . $url1 . "',
                    '" . $window1 . "',
                    '" . $link2 . "',
                    '" . $url2 . "',
                    '" . $window2 . "',
                    '" . $displayed . "',
                    '" . $comments . "'
                )"
        );

    $id = mysqli_insert_id($_database);


        $upload = new \webspell\HttpUpload('screen');
        if ($upload->hasFile()) {
            if ($upload->hasError() === false) {
                $mime_types = array('image/jpeg','image/png','image/gif');
 
                if ($upload->supportedMimeType($mime_types)) {
                    $imageInformation =  getimagesize($upload->getTempFile());
 
                    if (is_array($imageInformation)) {
                        switch ($imageInformation[ 2 ]) {
                            case 1:
                                $endung = '.gif';
                                break;
                            case 3:
                                $endung = '.png';
                                break;
                            default:
                                $endung = '.jpg';
                                break;
                        }
                        $file = $id.$endung;
 
                        if ($upload->saveAs($filepath.$file, true)) {
                            @chmod($file, $new_chmod);
                            safe_query(
                                "UPDATE " . PREFIX . "plugins_news SET screens='" . $file . "' WHERE newsID='" . $id . "'"
                            );
                        }
                    } else {
                        $errors[] = $plugin_language[ 'broken_image' ];
                    }
                } else {
                    $errors[] = $plugin_language[ 'unsupported_image_type' ];
                }
            } else {
                $errors[] = $upload->translateError();
            }
        }










    $rubrics = '';
    $newsrubrics = safe_query("SELECT rubricID, rubric FROM " . PREFIX . "plugins_news_rubrics ORDER BY rubric");
    while ($dr = mysqli_fetch_array($newsrubrics)) {
        $rubrics .= '<option value="' . $dr[ 'rubricID' ] . '">' . $dr[ 'rubric' ] . '</option>';
    }

}
}  


if ($action == "add") {
    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();


        $ergebnis = safe_query("SELECT * FROM `" . PREFIX . "plugins_news`");
        $ds = mysqli_fetch_array($ergebnis);

        $rubriccategory = safe_query("SELECT * FROM `" . PREFIX . "plugins_news_rubrics` ORDER BY `rubric`");
        $rubriccats = '<select class="form-control" name="rubric">';
        while ($dc = mysqli_fetch_array($rubriccategory)) {
            $selected = '';
            if ($dc[ 'rubricID' ] == $ds[ 'rubric' ]) {
                $selected = ' selected="selected"';
            }
            $rubriccats .= '<option value="' . $dc[ 'rubricID' ] . '"' . $selected . '>' . getinput($dc[ 'rubric' ]) .
                '</option>';
            }
            $rubriccats .= '</select>';

        if (isset($_POST[ "displayed" ])) {
            $displayed = 1;
        } else {
            $displayed = 0;
        }

    $url1 = "http://";
    $url2 = "http://";
    
    $link1 = '';
    $link2 = '';
    
    $window1 = '<input class="input" name="window1" type="checkbox" value="1">';
    $window2 = '<input class="input" name="window2" type="checkbox" value="1">';

    $comments = '<option value="0">' . $plugin_language[ 'no_comments' ] . '</option><option value="1">' .
        $plugin_language[ 'user_comments' ] . '</option><option value="2" selected="selected">' .
        $plugin_language[ 'visitor_comments' ] . '</option>';


echo '<script>
        function chkFormular() {
            if(!validbbcode(document.getElementById(\'message\').value, \'admin\')){
                return false;
            }
        }
    </script>';

  echo'<div class="card">
  <div class="card-header">
                            <i class="fas fa-newspaper"></i> ' . $plugin_language['news'] . '
                        </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news">' . $plugin_language[ 'news' ] . '</a></li>
                <li class="breadcrumb-item active" aria-current="page">'.$plugin_language['new_post'].'</li>
                </ol>
            </nav> 
    <div class="card-body">';

echo'    <form class="form-horizontal" method="post" id="post" name="post" action="admincenter.php?site=admin_news" onsubmit="return chkFormular();" enctype="multipart/form-data">

  
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['rubric'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      '.$rubriccats.'
    </div>
  </div>

<!-- ================================ screen Anfang======================================================== -->



  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['banner'].':</label>
    <div class="col-sm-3">
      <input name="screen" class="btn btn-info" type="file" id="imgInp" size="40" /> 
      <small>(max. 1000x500)</small>
    </div>
    <div class="col-sm-2">
      <img id="img-upload" src="../includes/plugins/news/images/news-pic/no-image.jpg" height="150px"/>
    </div>
  </div>
';
 

echo'<hr>';
echo '
<!-- =============================  screen Ende =========================================================== -->

 <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['link'].' 1:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link1" type="text">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url1" type="text" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window1.' '.$plugin_language['new_window'].'
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['link'].' 2:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link2" type="text">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url2" type="text" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window2.' '.$plugin_language['new_window'].'
    </div>
  </div>
   
<hr>

<div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['headline'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" class="form-control" name="headline" size="60" required/></em></span>
    </div>
  </div>
<div class="form-group row">
   <label class="col-sm-2 control-label">'.$plugin_language['text'].':</label>
    <div class="col-sm-8">
      <textarea name="message" id="ckeditor" cols="30" rows="15" class="ckeditor"></textarea>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['is_displayed'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input type="checkbox" name="displayed" value="1" checked="checked" /></em></span>
    </div>
  </div>

<div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['comments'].':</label>
    <div class="col-sm-8">
      <select name="comments">'.$comments.'</select>
      </div>
  </div>


  <div class="form-group row">
    <div class="col-sm-offset-2 col-sm-10">
    <input type="hidden" name="captcha_hash" value="'.$hash.'" />
    <button class="btn btn-success" type="submit" name="save"  />'.$plugin_language['save_news'].'</button>
    </div>
  </div>

  </form></div>
  </div>';


} elseif ($action == "edit") {
  

  $newsID = $_GET[ 'newsID' ];

$CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();

        $ergebnis = safe_query("SELECT * FROM `" . PREFIX . "plugins_news` WHERE `newsID` = '$newsID'");
        $ds = mysqli_fetch_array($ergebnis);

        $rubriccategory = safe_query("SELECT * FROM `" . PREFIX . "plugins_news_rubrics` ORDER BY `rubric`");
        $rubriccats = '<select class="form-control" name="rubric">';
        while ($dc = mysqli_fetch_array($rubriccategory)) {
            $selected = '';
            if ($dc[ 'rubricID' ] == $ds[ 'rubric' ]) {
                $selected = ' selected="selected"';
            }
            $rubriccats .= '<option value="' . $dc[ 'rubricID' ] . '"' . $selected . '>' . getinput($dc[ 'rubric' ]) .
                '</option>';
            }
            $rubriccats .= '</select>';

if ($ds[ 'displayed' ] == 1) {
        $displayed = '<input type="checkbox" name="displayed" value="1" checked="checked" />';
        } else {
        $displayed = '<input type="checkbox" name="displayed" value="1" />';
        }


    $link1 = getinput($ds[ 'link1' ]);
    $link2 = getinput($ds[ 'link2' ]);
    

    $url1 = "http://";
    $url2 = "http://";
    

    if ($ds[ 'url1' ] != "http://") {
        $url1 = $ds[ 'url1' ];
    }
    if ($ds[ 'url2' ] != "http://") {
        $url2 = $ds[ 'url2' ];
    }
    

    if ($ds[ 'window1' ]) {
        $window1 = '<input class="input" name="window1" type="checkbox" value="1" checked="checked">';
    } else {
        $window1 = '<input class="input" name="window1" type="checkbox" value="1">';
    }

    if ($ds[ 'window2' ]) {
        $window2 = '<input class="input" name="window2" type="checkbox" value="1" checked="checked">';
    } else {
        $window2 = '<input class="input" name="window2" type="checkbox" value="1">';
    }

    $comments = '<option value="0">' . $plugin_language[ 'no_comments' ] . '</option><option value="1">' .
        $plugin_language[ 'user_comments' ] . '</option><option value="2">' .
        $plugin_language[ 'visitor_comments' ] . '</option>';
    $comments =
        str_replace(
            'value="' . $ds[ 'comments' ] . '"',
            'value="' . $ds[ 'comments' ] . '" selected="selected"',
            $comments
        );


    $date = date("Y-m-d", $ds[ 'date' ]);

    $data_array = array();
    $data_array['$link1'] = $link1;
    $data_array['$url1'] = $url1;
    $data_array['$window1'] = $window1;
    $data_array['$link2'] = $link2;
    $data_array['$url2'] = $url2;
    $data_array['$window2'] = $window2;



   echo '<script>
        function chkFormular() {
            if(!validbbcode(document.getElementById(\'message\').value, \'admin\')){
                return false;
            }
        }
    </script>';

  echo'<div class="card">
  <div class="card-header">
                            <i class="fas fa-newspaper"></i> ' . $plugin_language['news'] . '
                        </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news">' . $plugin_language[ 'news' ] . '</a></li>
                <li class="breadcrumb-item active" aria-current="page">'.$plugin_language['edit_news'].'</li>
                </ol>
            </nav> 
    <div class="card-body">';

	echo'<form class="form-horizontal" method="post" id="post" name="post" action="admincenter.php?site=admin_news&action=edit&newsID=' . $newsID.'"" onsubmit="return chkFormular();" enctype="multipart/form-data">


  <input type="hidden" name="newsID" value="'.$ds['newsID'].'" />
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['rubric'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      '.$rubriccats.'
    </div>
  </div>


<!-- ================================ screen Anfang======================================================== -->


<div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['banner'].':</label>
    <div class="col-sm-2"><span class="text-muted small"><em>
      <input class="btn btn-default" type="file" id="imgInp" name="screen"> <small>(max. 1000x500)</small>
        </em></span>
        
    </div><div class="col-sm-1"></div>
        <div class="col-sm-2">
      <img id="img-upload" src="../includes/plugins/news/images/news-pic/no-image.jpg" height="150px"/>
    </div>

    <div class="col-sm-2"><input class="btn btn-success" type="submit" name="submit" value="' . $plugin_language[ 'upload' ] . '"></div>
  </div>
';
            

    $ergebnis = safe_query("SELECT screens FROM " . PREFIX . "plugins_news WHERE newsID='" . $newsID."'");
    $db = mysqli_fetch_array($ergebnis);
    $screens = array();
    if (!empty($db[ 'screens' ])) {
        $screens = explode("|", $db[ 'screens' ]);
    }
    if (is_array($screens)) {
        foreach ($screens as $screen) {
            if ($screen != "") {

echo'

<div class="form-group row">
<label class="col-sm-2 control-label">'.$plugin_language['current_banner'].':</label>
    <div class="col-sm-1">
    <a href="../' . $filepath . $screen . '" target="_blank"><img class="img-responsive" style="height="150px" src="../' . $filepath . $screen . '" alt="" /></a>
</div><div class="col-sm-9">' . $screen . '<br>
<input type="text" name="pic" size="100"
                value="../' . $filepath . $screen . '">

                <!--<input class="btn btn-success" type="button" onclick="AddCodeFromWindow(\'[img]' . $filepath . $db[ 'screens' ] . '[/img] \')"
                    value="' . $plugin_language[ 'add_to_message' ] . '">-->

                

                <input class="hidden-xs hidden-sm btn btn-danger" type="button" onclick="MM_confirm(
                        \'' . $plugin_language[ 'delete' ] . '\',
                        \'admincenter.php?site=admin_news&amp;action=picdelete&amp;newsID=' . $newsID . '&amp;file=' . basename($screen) . '\'
                    )" value="' . $plugin_language[ 'delete' ] . '">

                    
        </div>
    </div>


<hr>
';
            }
        }
    }

echo '


<!-- =============================  screen Ende =========================================================== -->


<div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['link'].' 1:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link1" type="text" value="'.getinput($ds['link1']).'">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url1" type="text" value="'.getinput($ds['url1']).'" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window1.' '.$plugin_language['new_window'].'
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['link'].' 2:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link2" type="text" value="'.getinput($ds['link2']).'">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url2" type="text" value="'.getinput($ds['url2']).'" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window2.' '.$plugin_language['new_window'].'
    </div>
  </div>
   
<hr>
 
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['headline'].':</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" name="headline" maxlength="255" size="5" value="'.getinput($ds['headline']).'" />
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['text'].':</label>
    <div class="col-sm-8">
       <textarea name="message" id="ckeditor" cols="30" rows="15" class="ckeditor">'. getinput($ds[ 'content' ]) .' </textarea>
    </div>
  </div>

  <div class="form-group row">
        <label for="bday" class="col-sm-2 control-label">'.$plugin_language['publication_setting'].':</label>
            <div class="col-lg-2">
            <input name="date" type="date" value="'.$date.'" placeholder="yyyy-mm-dd" class="form-control">
        </div>
    </div>

   <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['is_displayed'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
    '.$displayed.'</em></span>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['comments'].':</label>
    <div class="col-sm-8">
      <select name="comments">'.$comments.'</select>
      </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-offset-2 col-sm-10">
    <input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="newsID" value="'.$newsID.'" />
    <button class="btn btn-warning" type="submit" name="saveedit"  />'.$plugin_language['save_news'].'</button>

		
    </div>
  </div>
  </form>
  </div>
  </div>';


} elseif ($action == "picdelete") {

    $file = basename($_GET[ 'file' ]);
    if (file_exists($filepath . $file)) {
        @unlink($filepath . $file);
    }

    $ergebnis = safe_query("SELECT screens FROM " . PREFIX . "plugins_news WHERE newsID=" . $_GET[ "newsID" ]."");
    $db = mysqli_fetch_array($ergebnis);
    
    $screens = explode("|", $db[ 'screens' ]);
    foreach ($screens as $pic) {
        if ($pic != $file) {
            $newscreens[ ] = $pic;
        }
    }
    if (is_array($newscreens)) {
        $newscreens_string = implode("|", $newscreens);
    }

    safe_query("UPDATE " . PREFIX . "plugins_news SET screens='".$newscreens_string."' WHERE newsID=" . $_GET[ "newsID" ]."");
       
    header("Location: admincenter.php?site=admin_news&action=edit&newsID=" . $_GET[ "newsID" ]."");
    
} else {


if(isset($_GET['page'])) $page=(int)$_GET['page'];
  else $page = 1;

    echo'<div class="card">
  <div class="card-header">
                            <i class="fas fa-newspaper"></i> ' . $plugin_language['news'] . '
                        </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news">' . $plugin_language[ 'news' ] . '</a></li>
                <li class="breadcrumb-item active" aria-current="page">New / Edit</li>
                </ol>
            </nav> 
    <div class="card-body">';
	
    echo'<div class="form-group row">
    <label class="col-md-1 control-label">' . $plugin_language['options'] . ':</label>
    <div class="col-md-8">
      <a href="admincenter.php?site=admin_news_categorys" class="btn btn-primary" type="button">' . $plugin_language[ 'news_rubrics' ] . '</a>
      <a href="admincenter.php?site=admin_news&amp;action=add" class="btn btn-primary" type="button">' . $plugin_language[ 'new_post' ] . '</a>
      <a href="admincenter.php?site=admin_news_settings" class="btn btn-primary" type="button">' . $plugin_language[ 'settings' ] . '</a>
    </div>
  </div>';

        $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $dx = mysqli_fetch_array($settings);

    
        $maxadminnews = $dx[ 'news' ];
        if (empty($maxshownnews)) {
        $maxadminnews = 10;
        }

    $alle=safe_query("SELECT newsID FROM ".PREFIX."plugins_news");
  $gesamt = mysqli_num_rows($alle);
  $pages=1;

        $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $dn = mysqli_fetch_array($settings);

    
        $max = $dn[ 'admin_news' ];
        if (empty($max)) {
        $max = 10;
        }

 

  for ($n=$max; $n<=$gesamt; $n+=$max) {
    if($gesamt>$n) $pages++;
  }

  if($pages>1) $page_link = makepagelink("admincenter.php?site=admin_news", $page, $pages);
    else $page_link='';

  if ($page == "1") {
    $ergebnis = safe_query("SELECT * FROM ".PREFIX."plugins_news ORDER BY date DESC LIMIT 0,$max");
    $n=1;
  }
  else {
    $start=$page*$max-$max;
    $ergebnis = safe_query("SELECT * FROM ".PREFIX."plugins_news ORDER BY date DESC LIMIT $start,$max");
    $n = ($gesamt+1)-$page*$max+$max;
  } 

    

     echo'<table class="table table-striped">
    <thead>
      <th><b>' . $plugin_language['date'] . '</b></th>
      <th><b>' . $plugin_language['rubric'] . '</b></th>
      <th><b>' . $plugin_language['headline'] . '</b></th>
      <th><b>' . $plugin_language['is_displayed'] . '</b></th>
      <th><b>' . $plugin_language['actions'] . '</b></th>
    </thead>';

$ds = safe_query("SELECT * FROM `" . PREFIX . "plugins_news` ORDER BY `date`");
    
   $n=1;

        while ($db = mysqli_fetch_array($ergebnis)) { 

            $CAPCLASS = new \webspell\Captcha;
            $CAPCLASS->createTransaction();
            $hash = $CAPCLASS->getHash();
        
        $rubrikname = getnewsrubricname($db[ 'rubric' ]);
        $rubric = $db['rubric'];
        $date = getformatdatetime($db[ 'date' ]);

            $db[ 'displayed' ] == 1 ?
            $displayed = '<font color="green"><b>' . $plugin_language[ 'yes' ] . '</b></font>' :
            $displayed = '<font color="red"><b>' . $plugin_language[ 'no' ] . '</b></font>';
            
            

        echo '<tr>
        <td>'.$date.'</td>
        <td>'.$rubrikname.'</td>
        <td>'.$db['headline'].'</td>
        <td>'.$displayed.'</td>
        
        <td><a href="admincenter.php?site=admin_news&amp;action=edit&amp;newsID='.$db['newsID'].'" class="btn btn-warning" type="button">' . $plugin_language[ 'edit' ] . '</a>

        <input class="btn btn-danger" type="button" onclick="MM_confirm(\''.$plugin_language['really_delete'].'\', \'admincenter.php?site=admin_news&amp;delete=true&amp;newsID='.$db['newsID'].'&amp;captcha_hash='.$hash.'\')" value="'.$plugin_language['delete'].'" />

        </td>
      </tr>';
      
      
      $n++;
		} 
     
  echo '</table>';
  if($pages>1) echo $page_link;
  
  }

echo '</div></div>';
?>