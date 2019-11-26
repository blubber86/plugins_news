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
$plugin_language = $pm->plugin_language("admin_news_rubrics", $plugin_path);

#$title = $plugin_language[ 'title' ]; #sc_datei Info

$_language->readModule('newsrubrics', false, true);

$ergebnis = safe_query("SELECT * FROM ".PREFIX."navigation_dashboard_links WHERE modulname='news_rubrics'");
    while ($db=mysqli_fetch_array($ergebnis)) {
      $accesslevel = 'is'.$db['accesslevel'].'admin';

if (!$accesslevel($userID) || mb_substr(basename($_SERVER[ 'REQUEST_URI' ]), 0, 15) != "admincenter.php") {
    die($plugin_language[ 'access_denied' ]);
}
}

$filepath = $plugin_path."images/news-rubrics/";

if (isset($_POST[ 'save' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        if (checkforempty(array('name'))) {
            safe_query("INSERT INTO " . PREFIX . "plugins_news_rubrics ( rubric ) values( '" . $_POST[ 'name' ] . "' ) ");
            $id = mysqli_insert_id($_database);

            

            $errors = array();

            //TODO: should be loaded from root language folder
            $_language->readModule('formvalidation', true);

            $upload = new \webspell\HttpUpload('pic');
            if ($upload->hasFile()) {
                if ($upload->hasError() === false) {
                    $mime_types = array('image/jpeg','image/png','image/gif');

                    if ($upload->supportedMimeType($mime_types)) {
                        $imageInformation = getimagesize($upload->getTempFile());

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
                            $file = $id . $endung;

                            if ($upload->saveAs($filepath . $file, true)) {
                                @chmod($filepath . $file, $new_chmod);
                                safe_query(
                                    "UPDATE " . PREFIX . "plugins_news_rubrics
                                    SET pic='" . $file . "' WHERE rubricID='" . $id . "'"
                                );
                            }
                        } else {
                            $errors[] = $plugin_language['broken_image'];
                        }
                    } else {
                        $errors[] = $plugin_language['unsupported_image_type'];
                    }
                } else {
                    $errors[] = $upload->translateError();
                }
            }
            if (count($errors)) {
                $errors = array_unique($errors);
                echo generateErrorBoxFromArray($plugin_language['errors_there'], $errors);
            }
        } else {
            echo $plugin_language[ 'information_incomplete' ];
        }
    } else {
        echo $plugin_language[ 'transaction_invalid' ];
    }
} elseif (isset($_POST[ 'saveedit' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_POST[ 'captcha_hash' ])) {
        if (checkforempty(array('name'))) {
            safe_query(
                "UPDATE
                    `" . PREFIX . "plugins_news_rubrics`
                SET
                    `rubric` = '" . $_POST[ 'name' ] . "'
                WHERE
                    `rubricID` = '" . $_POST[ 'rubricID' ] . "'"
            );

            $id = $_POST[ 'rubricID' ];
            

            $errors = array();

            //TODO: should be loaded from root language folder
            $_language->readModule('formvalidation', true);

            $upload = new \webspell\HttpUpload('pic');
            if ($upload->hasFile()) {
                if ($upload->hasError() === false) {
                    $mime_types = array('image/jpeg','image/png','image/gif');

                    if ($upload->supportedMimeType($mime_types)) {
                        $imageInformation = getimagesize($upload->getTempFile());

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
                            $file = $id . $endung;

                            if ($upload->saveAs($filepath . $file, true)) {
                                @chmod($filepath . $file, $new_chmod);
                                safe_query(
                                    "UPDATE " . PREFIX . "plugins_news_rubrics
                                    SET pic='" . $file . "' WHERE rubricID='" . $id . "'"
                                );
                            }
                        } else {
                            $errors[] = $plugin_language['broken_image'];
                        }
                    } else {
                        $errors[] = $plugin_language['unsupported_image_type'];
                    }
                } else {
                    $errors[] = $upload->translateError();
                }
            }
            if (count($errors)) {
                $errors = array_unique($errors);
                echo generateErrorBoxFromArray($plugin_language['errors_there'], $errors);
            }
        } else {
            echo $plugin_language[ 'information_incomplete' ];
        }
    } else {
        echo $plugin_language[ 'transaction_invalid' ];
    }
} elseif (isset($_GET[ 'delete' ])) {
    $CAPCLASS = new \webspell\Captcha;
    if ($CAPCLASS->checkCaptcha(0, $_GET[ 'captcha_hash' ])) {
        $rubricID = (int)$_GET[ 'rubricID' ];
        
        safe_query("DELETE FROM " . PREFIX . "plugins_news_rubrics WHERE rubricID='$rubricID'");
        if (file_exists($filepath . $rubricID . '.gif')) {
            @unlink($filepath . $rubricID . '.gif');
        }
        if (file_exists($filepath . $rubricID . '.jpg')) {
            @unlink($filepath . $rubricID . '.jpg');
        }
        if (file_exists($filepath . $rubricID . '.png')) {
            @unlink($filepath . $rubricID . '.png');
        }
    } else {
        echo $plugin_language[ 'transaction_invalid' ];
    }
}

if (isset($_GET[ 'action' ])) {
    $action = $_GET[ 'action' ];
} else {
    $action = '';
}

if ($action == "add") {
    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();
  echo'<div class="card">
  <div class="card-header">
                            <i class="fas fa-newspaper"></i> ' . $plugin_language['news_rubrics'] . '
                        </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news">' . $plugin_language[ 'title' ] . '</a></li>
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news_categorys">' . $plugin_language[ 'news_rubrics' ] . '</a></li>
                <li class="breadcrumb-item active" aria-current="page">'.$plugin_language['add_rubric'].'</li>
                </ol>
            </nav> 
    <div class="card-body">';

	echo'<form class="form-horizontal" method="post" action="admincenter.php?site=admin_news_categorys" enctype="multipart/form-data">
		<div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['rubric_name'].':</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="name"  />
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['picture_upload'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
     <p class="form-control-static"><input name="pic" type="file" size="40" /></p></em></span>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="hidden" name="captcha_hash" value="'.$hash.'" /><button class="btn btn-success" type="submit" name="save" />'.$plugin_language['add_rubric'].'</button>
    </div>
  </div>
  </form></div></div>';

} elseif ($action == "edit") {


    $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();
    echo '<div class="card">
  <div class="card-header">
                            <i class="fas fa-newspaper"></i> ' . $plugin_language['news_rubrics'] . '
                        </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news">' . $plugin_language[ 'title' ] . '</a></li>
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news_categorys">' . $plugin_language[ 'news_rubrics' ] . '</a></li>
                <li class="breadcrumb-item active" aria-current="page">'.$plugin_language['edit_rubric'].'</li>
                </ol>
            </nav> 
    <div class="card-body">';

    
    $ds = mysqli_fetch_array(
        safe_query(
            "SELECT * FROM " . PREFIX . "plugins_news_rubrics WHERE rubricID='" . intval($_GET['rubricID']) ."'"
        )
    );

    if (!empty($ds[ 'pic' ])) {
        $pic = '<img class="img-thumbnail" style="width: 100%; max-width: 600px" src="../' . $filepath . $ds[ 'pic' ] . '" alt="">';
    } else {
        $pic = '<img id="img-upload" class="img-thumbnail" style="width: 100%; max-width: 150px" src="../' . $filepath . 'no-image.jpg" alt="">';
    }

	echo'<form class="form-horizontal" method="post" action="admincenter.php?site=admin_news_categorys" enctype="multipart/form-data">
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['rubric_name'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
      <input type="text" class="form-control" name="name" value="'.getinput($ds['rubric']).'" /></em></span>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['picture'].':</label>
    <div class="col-sm-8">
      <p class="form-control-static">' . $pic . '</p>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 control-label">'.$plugin_language['picture_upload'].':</label>
    <div class="col-sm-8"><span class="text-muted small"><em>
     <p class="form-control-static"><input name="pic" type="file" size="40" /></p></em></span>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-offset-2 col-sm-10">
     <input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="rubricID" value="'.$ds['rubricID'].'" />
     <button class="btn btn-warning" type="submit" name="saveedit" />'.$plugin_language['edit_rubric'].'</button>
    </div>
  </div>
  </form></div></div>';
}

else {

  echo'<div class="card">
  <div class="card-header">
                            <i class="fas fa-newspaper"></i> ' . $plugin_language['news_rubrics'] . '
                        </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news">' . $plugin_language[ 'title' ] . '</a></li>
                <li class="breadcrumb-item"><a href="admincenter.php?site=admin_news_categorys">' . $plugin_language[ 'news_rubrics' ] . '</a></li>
                <li class="breadcrumb-item active" aria-current="page">New / Edit</li>
                </ol>
            </nav> 
    <div class="card-body">

<div class="form-group row">
    <label class="col-md-1 control-label">' . $plugin_language['options'] . ':</label>
    <div class="col-md-8">
      <a href="admincenter.php?site=admin_news_categorys&amp;action=add" class="btn btn-primary" type="button">' . $plugin_language[ 'new_rubric' ] . '</a>
    </div>
  </div>

<div class="row">
<div class="col-md-12"><br />';

	

	$ergebnis = safe_query("SELECT * FROM " . PREFIX . "plugins_news_rubrics ORDER BY rubric");
	$filepath = $plugin_path."images/news-rubrics/";
  echo'<table class="table table-striped">
    <thead>
      <tr>
      <th><b>'.$plugin_language['rubric_name'].':</b></th>
      <th><b>'.$plugin_language['picture'].':</b></th>
      <th><b>'.$plugin_language['actions'].':</b></th>
   		</tr></thead>
          <tbody>';
	 $CAPCLASS = new \webspell\Captcha;
    $CAPCLASS->createTransaction();
    $hash = $CAPCLASS->getHash();
    $i = 1;
    while ($ds = mysqli_fetch_array($ergebnis)) {
        if ($i % 2) {
            $td = 'td1';
        } else {
            $td = 'td2';
        }

        if (!empty($ds[ 'pic' ])) {
        $pic = '<img class="img-thumbnail" style="width: 100%; max-width: 600px" src="../' . $filepath . $ds[ 'pic' ] . '" alt="">';
    } else {
        $pic = '<img id="img-upload" class="img-thumbnail" style="width: 100%; max-width: 150px" src="../' . $filepath . 'no-image.jpg" alt="">';
    }
    
		echo'<tr>
      <td>'.getinput($ds['rubric']).'</td>
      <td>'.$pic.'</td>
      <td><a href="admincenter.php?site=admin_news_categorys&amp;action=edit&amp;rubricID='.$ds['rubricID'].'" class="btn btn-warning" type="button">' . $plugin_language[ 'edit' ] . '</a>

      <input class="btn btn-danger" type="button" onclick="MM_confirm(\''.$plugin_language['really_delete'].'\', \'admincenter.php?site=admin_news_categorys&amp;delete=true&amp;rubricID='.$ds['rubricID'].'&amp;captcha_hash='.$hash.'\')" value="'.$plugin_language['delete'].'" />

      </td>
    </tr>';
      
      $i++;
	}
	echo'</tbody></table>';
}
echo '</div></div></div></div>';
?>