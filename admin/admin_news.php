<script src="js/bbcode.js"></script><?php
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
$_lang = $pm->plugin_language("admin_news", $plugin_path);

$_language->readModule('admin_news', false, true);

$title = $_lang[ 'title' ]; 

if (!ispageadmin($userID) || mb_substr(basename($_SERVER[ 'REQUEST_URI' ]), 0, 15) != "admincenter.php") {
    die($_lang[ 'access_denied' ]);
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
                    `displayed` = '" . $displayed . "'
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
        echo $_lang[ 'transaction_invalid' ];
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
                    `displayed`
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
                    '" . $displayed . "'
                )"
        );

    $id = mysqli_insert_id($_database);

    $screen = new \webspell\HttpUpload('screen');

    if ($screen->hasFile()) {
        if ($screen->hasError() === false) {
            $file = $id . '_' . time() . "." .$screen->getExtension();
            $new_name = $filepath . $file;
            if ($screen->saveAs($new_name)) {
                @chmod($new_name, $new_chmod);
                $ergebnis = safe_query("SELECT screens FROM " . PREFIX . "plugins_news WHERE newsID='" . $id ."'");
                $dx = mysqli_fetch_array($ergebnis);
                $screens = explode('|', $dx[ 'screens' ]);
                $screens[ ] = $file;
                $screens_string = implode('|', $screens);

                $ergebnis = safe_query(
                    "UPDATE
                    " . PREFIX . "plugins_news
                    SET
                        screens='" . $screens_string . "'
                    
                WHERE `newsID` = '" . $id . "'"
                );
            }
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




echo '<script>
        function chkFormular() {
            if(!validbbcode(document.getElementById(\'message\').value, \'admin\')){
                return false;
            }
        }
    </script>';

  echo'<div class="panel panel-default">
  <div class="panel-heading">
                            <i class="fa fa-globe"></i> ' . $_lang['news'] . '
                        </div>
    <div class="panel-body">
  <a href="admincenter.php?site=admin_news">'.$_lang['news'].'</a> &raquo; '.$_lang['new_post'].'<br><br>';

echo'    <form class="form-horizontal" method="post" id="post" name="post" action="admincenter.php?site=admin_news" onsubmit="return chkFormular();" enctype="multipart/form-data">

  
  <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['rubric'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      '.$rubriccats.'
    </div>
  </div>

<!-- ================================ screen Anfang======================================================== -->

<div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['banner'].':</label>
    <div class="col-sm-2"><span class="text-muted small"><em>
      <input class="btn btn-default" type="file" name="screen"> <small>(max. 1000x500)</small>
        </em></span>
        
    </div><div class="col-sm-1"></div>
  </div>
';
            

    $screens = array();
    if (!empty($dg[ 'screens' ])) {
        $screens = explode("|", $dg[ 'screens' ]);
    }
    if (is_array($screens)) {
        foreach ($screens as $screen) {
            if ($screen != "") {   

echo'

<div class="form-group">
<label class="col-sm-2 control-label">'.$_lang['current_banner'].':</label>
    <div class="col-sm-1">
    <a href="../' . $filepath . $screens . '" target="_blank"><img class="img-responsive" style="width: 100px" src="../' . $filepath . $screens . '" alt="" /></a>
</div><div class="col-sm-9">' . $screens . '<br>
<input type="text" name="addpic" size="100"
                value="&lt;img src=&quot;../' . $filepath . $screens . '&quot; border=&quot;0&quot; align=&quot;left&quot; style=&quot;width:200px;padding:4px;&quot; alt=&quot;&quot; /&gt;">

                <!--<input class="btn btn-success" type="button" onclick="AddCodeFromWindow(\'[img]' . $filepath . $dg[ 'screens' ] . '[/img] \')"
                    value="' . $_lang[ 'add_to_message' ] . '">-->

                <input class="btn btn-danger" type="button" onclick="MM_confirm(\''.$_lang['really_delete'].'\', \'admincenter.php?site=admin_news&amp;action=picdelete&amp;$newsID=' . $newsID . '&amp;file=' . basename($dg[ 'screens' ]) . '&amp;captcha_hash='.$hash.'\')" value="'.$_lang['delete'].'" />


                
                </div>
    </div>


<hr>
';
            }
        }
    }

echo '
<!-- =============================  screen Ende =========================================================== -->

 <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['link'].' 1:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link1" type="text">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url1" type="text" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window1.' '.$_lang['new_window'].'
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['link'].' 2:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link2" type="text">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url2" type="text" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window2.' '.$_lang['new_window'].'
    </div>
  </div>
   
<hr>
'.$_lang['info'].'
<div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['headline'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input class="form-control" type="text" class="form-control" name="headline" size="60" required/></em></span>
    </div>
  </div>
<div class="form-group">
   <label class="col-sm-2 control-label">'.$_lang['text'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <textarea class="form-control" id="message" name="message" rows="10" cols=""></textarea></em></span>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['is_displayed'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input type="checkbox" name="displayed" value="1" checked="checked" /></em></span>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <input type="hidden" name="captcha_hash" value="'.$hash.'" />
    <button class="btn btn-success" type="submit" name="save"  />'.$_lang['save_news'].'</button>
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

  echo'<div class="panel panel-default">
  <div class="panel-heading">
                            <i class="fa fa-globe"></i> ' . $_lang['news'] . '
                        </div>
    <div class="panel-body">
  <a href="admincenter.php?site=admin_news">'.$_lang['news'].'</a> &raquo; '.$_lang['edit_news'].'<br><br>';

	echo'<form class="form-horizontal" method="post" id="post" name="post" action="admincenter.php?site=admin_news&action=edit&newsID=' . $newsID.'"" onsubmit="return chkFormular();" enctype="multipart/form-data">


  <input type="hidden" name="newsID" value="'.$ds['newsID'].'" />
  <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['rubric'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      '.$rubriccats.'
    </div>
  </div>


<!-- ================================ screen Anfang======================================================== -->


<div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['banner'].':</label>
    <div class="col-sm-2"><span class="text-muted small"><em>
      <input class="btn btn-default" type="file" name="screen"> <small>(max. 1000x500)</small>
        </em></span>
        
    </div><div class="col-sm-1"></div>
    <div class="col-sm-2"><input class="btn btn-success" type="submit" name="submit" value="' . $_lang[ 'upload' ] . '"></div>
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

<div class="form-group">
<label class="col-sm-2 control-label">'.$_lang['current_banner'].':</label>
    <div class="col-sm-1">
    <a href="../' . $filepath . $screen . '" target="_blank"><img class="img-responsive" style="width: 100px" src="../' . $filepath . $screen . '" alt="" /></a>
</div><div class="col-sm-9">' . $screen . '<br>
<input type="text" name="pic" size="100"
                value="&lt;img src=&quot;../' . $filepath . $screen . '&quot; border=&quot;0&quot; align=&quot;left&quot; style=&quot;width:200px;padding:4px;&quot; alt=&quot;&quot; /&gt;">

                <!--<input class="btn btn-success" type="button" onclick="AddCodeFromWindow(\'[img]' . $filepath . $db[ 'screens' ] . '[/img] \')"
                    value="' . $_lang[ 'add_to_message' ] . '">-->

                

                <input class="hidden-xs hidden-sm btn btn-danger" type="button" onclick="MM_confirm(
                        \'' . $_lang[ 'delete' ] . '\',
                        \'admincenter.php?site=admin_news&amp;action=picdelete&amp;newsID=' . $newsID . '&amp;file=' . basename($screen) . '\'
                    )" value="' . $_lang[ 'delete' ] . '">

                    
        </div>
    </div>


<hr>
';
            }
        }
    }

echo '


<!-- =============================  screen Ende =========================================================== -->


<div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['link'].' 1:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link1" type="text" value="'.getinput($ds['link1']).'">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url1" type="text" value="'.getinput($ds['url1']).'" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window1.' '.$_lang['new_window'].'
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['link'].' 2:</label>
    <div class="col-sm-3">
      <input class="form-control" name="link2" type="text" value="'.getinput($ds['link2']).'">
    </div>
    <div class="col-sm-3">
      <input class="form-control" name="url2" type="text" value="'.getinput($ds['url2']).'" placeholder="http://">
      </div>
      <div class="col-sm-2">
      '.$window2.' '.$_lang['new_window'].'
    </div>
  </div>
   
<hr>
 '.$_lang['info'].'
  <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['headline'].':</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" name="headline" maxlength="255" size="5" value="'.getinput($ds['headline']).'" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['text'].':</label>
    <div class="col-sm-8">
      
       <textarea class="form-control" type="text" id="message" name="message" rows="10" cols="" style="width: 100%;">' . getinput($ds[ 'content' ]) .
        '</textarea>
    </div>
  </div>

  <div class="form-group">
        <label for="bday" class="col-sm-2 control-label">Veröffentlichung Einstellung:</label>
            <div class="col-lg-2">
            <input name="date" type="date" value="'.$date.'" placeholder="yyyy-mm-dd" class="form-control">
        </div>
    </div>

   <div class="form-group">
    <label class="col-sm-2 control-label">'.$_lang['is_displayed'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
    '.$displayed.'</em></span>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="newsID" value="'.$newsID.'" />
    <button class="btn btn-success" type="submit" name="saveedit"  />'.$_lang['save_news'].'</button>

		
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

    echo'<div class="panel panel-default">
    <div class="panel-heading">
                            <i class="fa fa-newspaper-o"></i> ' . $_lang['news'] . '
                        </div>
    <div class="panel-body">';
	
    echo'<div class="col-md-10 form-group"><a href="admincenter.php?site=admin_news" class="white">' . $_lang[ 'title' ] .
    '</a> &raquo; New / Edit</div>
<div class="col-md-2 form-group">
        <!-- The modal beginning -->
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#flipFlop">' . $_lang[ 'description' ] . '</button>

<!-- The modal -->
<div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<h4 class="modal-title" id="modalLabel">' . $_lang[ 'description' ] . '</h4>
</div>
<div class="modal-body">' . $_lang[ 'privacy_policy_title' ] . '' . $_lang[ 'privacy_policy_text' ] . '';
    
      $query = safe_query("SELECT pluginID FROM `".PREFIX."plugins` WHERE `name` ='$title'");
      $data_array = mysqli_fetch_array($query);
      if($data_array) { 
        
        

        echo '<img src="../images/languages/en.gif" /> Copy the following lines and paste this into your index.php on the position you want. <br />
          <img src="../images/languages/de.gif" /> Kopiere die folgenden Zeilen und f&uuml;ge Sie in der index.php an der gew&uuml;nschten Stelle ein.<br />
          <pre>
          <right>
&lt;?php
  $plugin = new plugin_manager();
  $plugin->set_debug(DEBUG);
  echo $plugin->plugin_sc('.$data_array['pluginID'].');
?&gt;         </right>
          </pre>';
      }

echo'</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<!-- The modal end-->
</div>


<div class="col-md-10 form-group"><a href="admincenter.php?site=admin_news_categorys" class="btn btn-primary" type="button">' . $_lang[ 'news_rubrics' ] . '</a> <a href="admincenter.php?site=admin_news&amp;action=add" class="btn btn-primary" type="button">' . $_lang[ 'new_post' ] . '</a>
</div>
<div class="col-md-2 form-group"><a href="admincenter.php?site=admin_news_settings" class="btn btn-primary" type="button">' . $_lang[ 'settings' ] . '</a>

</div>
';

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

    

     echo'   <table class="table table-striped">
    <thead>
      <th><b>' . $_lang['date'] . '</b></th>
      <th><b>' . $_lang['rubric'] . '</b></th>
      <th><b>' . $_lang['headline'] . '</b></th>
      <th><b>' . $_lang['is_displayed'] . '</b></th>
      <th><b>' . $_lang['actions'] . '</b></th>
    </thead>';

$ds = safe_query("SELECT * FROM `" . PREFIX . "plugins_news` ORDER BY `date`");
    
   $n=1;

        while ($db = mysqli_fetch_array($ergebnis)) { 

            $CAPCLASS = new \webspell\Captcha;
            $CAPCLASS->createTransaction();
            $hash = $CAPCLASS->getHash();
        
        $rubrikname = getrubricname($db[ 'rubric' ]);
        $rubric = cleartext($db['rubric']);
        $date = getformatdatetime($db[ 'date' ]);

            $db[ 'displayed' ] == 1 ?
            $displayed = '<font color="green"><b>' . $_lang[ 'yes' ] . '</b></font>' :
            $displayed = '<font color="red"><b>' . $_lang[ 'no' ] . '</b></font>';
            
        $headline = $db[ 'headline' ];
        $translate = new multiLanguage(detectCurrentLanguage());    
        $translate->detectLanguages($headline);
        $headline = $translate->getTextByLanguage($headline);    
        $headline = toggle(htmloutput($headline), 1);
        $headline = toggle($headline, 1);      

        echo '<tr>
        <td>'.$date.'</td>
        <td>'.$rubrikname.'</td>
        <td>'.$db['headline'].'</td>
        <td>'.$displayed.'</td>
        
        <td><a href="admincenter.php?site=admin_news&amp;action=edit&amp;newsID='.$db['newsID'].'" class="hidden-xs hidden-sm btn btn-warning" type="button">' . $_lang[ 'edit' ] . '</a>

        <input class="hidden-xs hidden-sm btn btn-danger" type="button" onclick="MM_confirm(\''.$_lang['really_delete'].'\', \'admincenter.php?site=admin_news&amp;delete=true&amp;newsID='.$db['newsID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_lang['delete'].'" />
		
        <a href="admincenter.php?site=admin_news&amp;action=edit&amp;newsID='.$db['newsID'].'"  class="mobile visible-xs visible-sm" type="button"><i class="fa fa-pencil"></i></a>
        <a class="mobile visible-xs visible-sm" type="button" onclick="MM_confirm(\''.$_lang['really_delete'].'\', \'admincenter.php?site=admin_news&amp;delete=true&amp;newsID='.$db['newsID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_lang['delete'].'" /><i class="fa fa-times"></i></a></td>
      </tr>';
      
      
      $n++;
		} 
     
  echo '</table>';
  if($pages>1) echo $page_link;
  
  }

echo '</div></div>';
?>