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
# Sprachdateien aus dem Plugin-Ordner laden
$pm = new plugin_manager(); 
$_lang = $pm->plugin_language("comments", $plugin_path);

function checkCommentsAllow($type, $parentID)
{
global $userID;
    $moduls = array();
    $moduls['ne'] = array("news","newsID","comments");
    $allowed = 0;
    $modul = $moduls[$type];
    $get = safe_query("SELECT ".$modul[2]." FROM ".PREFIX.$modul[0]." WHERE ".$modul[1]."='".$parentID."'");
    if(mysql_num_rows($get)){
        $data = mysql_fetch_assoc($get);
        switch($data[$modul[2]]){
            case 0: $allowed = 0; break;
            case 1: if($userID) $allowed = 1; break;
            case 2: $allowed = 1; break;
            default: $allowed=0;
        }
    }
    return $allowed;
}

 
if (isset($_POST[ 'savevisitorcomment' ])) {
    
    $name = $_POST[ 'name' ];
    $mail = $_POST[ 'mail' ];
    $url = $_POST[ 'url' ];
    $parentID = (int)$_POST[ 'parentID' ];
    $type = $_POST[ 'type' ];
    $message = $_POST[ 'message' ];
    $ip = $GLOBALS[ 'ip' ];
    $CAPCLASS = new \webspell\Captcha();
 
    $nicks = array();
 
    setcookie("visitor_info", $name . "--||--" . $mail . "--||--" . $url, time() + (3600 * 24 * 365));
    $query = safe_query("SELECT `nickname`, `username` FROM `" . PREFIX . "user` ORDER BY `nickname`");
    while ($ds = mysqli_fetch_array($query)) {
        $nicks[] = $ds[ 'nickname' ];
        $nicks[] = $ds[ 'username' ];
    }
    $_SESSION[ 'comments_message' ] = $message;
 
    $spamApi = webspell\SpamApi::getInstance();
    $validation = $spamApi->validate($message);
 
    if (in_array(trim($name), $nicks)) {
        header("Location: " . $_POST[ 'referer' ] . "&error=nickname#post");
    } elseif (!($CAPCLASS->checkCaptcha($_POST[ 'captcha' ], $_POST[ 'captcha_hash' ]))) {
        header("Location: " . $_POST[ 'referer' ] . "&error=captcha#post");
    } elseif (checkCommentsAllow($type, $parentID) === false) {
        header("Location: " . $_POST[ 'referer' ]);
    } else {
        $date = time();
        safe_query(
                "INSERT INTO `" . PREFIX . "plugins_news_comments` (
                    `parentID`,
                    `type`,
                    `nickname`,
                    `date`,
                    `comment`,
                    `url`,
                    `email`,
                    `ip`
                )
                VALUES (
                    '" . $parentID . "',
                    '" . $type . "',
                    '" . $name . "',
                    '" . $date . "',
                    '" . $message . "',
                    '" . $url . "',
                    '" . $mail . "',
                    '" . $ip . "'
                )"
            );
        
        unset($_SESSION[ 'comments_message' ]);
        header("Location: " . $_POST[ 'referer' ]);
    }
} elseif (isset($_POST[ 'saveusercomment' ])) {
    
    $_language->readModule('comments');
    if (!$userID) {
        die($_language->module[ 'access_denied' ]);
    }
 
    $parentID = $_POST[ 'parentID' ];
    $type = $_POST[ 'type' ];
    $message = $_POST[ 'message' ];
 
    
        $date = time();
        safe_query(
                "INSERT INTO
                    `" . PREFIX . "plugins_news_comments` (
                        `parentID`,
                        `type`,
                        `userID`,
                        `date`,
                        `comment`
                    )
                    VALUES (
                        '" . $parentID . "',
                        '" . $type . "',
                        '" . $userID . "',
                        '" . time() . "',
                        '" . $message . "'
                    )"
            );
   
    header("Location: " . $_POST[ 'referer' ]);
} elseif (isset($_GET[ 'delete' ])) {
    $_language->readModule('comments');
    if (!isanyadmin($userID)) {
        die($_lang[ 'access_denied' ]);
    }

    foreach ($_POST[ 'commentID' ] as $id) {
        safe_query("DELETE FROM " . PREFIX . "plugins_news_comments WHERE commentID='" . (int)$id."'");
    }
    header("Location: " . $_POST[ 'referer' ]);
} elseif (isset($_GET[ 'editcomment' ])) {
    $id = $_GET[ 'id' ];
    $referer = $_GET[ 'ref' ];
    $_language->readModule('comments');
    
    if (isfeedbackadmin($userID) || iscommentposter($userID, $id)) {
        if (!empty($id)) {
            $dt = safe_query("SELECT * FROM " . PREFIX . "plugins_news_comments WHERE commentID='" . (int)$id."'");
            if (mysqli_num_rows($dt)) {
                $ds = mysqli_fetch_array($dt);
                $poster = '<a href="index.php?site=profile&amp;id=' . $ds[ 'userID' ] . '"><b>' .
                    getnickname($ds[ 'userID' ]) . '</b></a>';
                $message = getinput($ds[ 'comment' ]);
                $message = preg_replace("#\n\[br\]\[br\]\[hr]\*\*(.+)#si", '', $message);
                $message = preg_replace("#\n\[br\]\[br\]\*\*(.+)#si", '', $message);
 
                $data_array = array();
                $data_array['$message'] = $message;
                $data_array['$authorID'] = $ds['userID'];
                $data_array['$id'] = $id;
                $data_array['$referer'] = $referer;
                $data_array['$userID'] = $userID;
               
                $data_array['$title_editcomment']=$_lang['title_editcomment'];
                $data_array['$edit_comment']=$_lang['edit_comment'];    
                
                $template = $GLOBALS["_template"]->loadTemplate("comments","edit", $data_array, $plugin_path);
                echo $template;
            } else {
                redirect($referer, $_language->module[ 'no_database_entry' ], 2);
            }
        } else {
            redirect($referer, $_language->module[ 'no_commentid' ], 2);
        }
    } else {
        redirect($referer, $_language->module[ 'access_denied' ], 2);
    }
} elseif (isset($_POST[ 'saveeditcomment' ])) {
    
    if (!isfeedbackadmin($userID) && !iscommentposter($userID, $_POST[ 'commentID' ])) {
        die('No access');
    }
 
    $message = $_POST[ 'message' ];
    $author = $_POST[ 'authorID' ];
    $referer = urldecode($_POST[ 'referer' ]);
 
    // check if any admin edited the post
    if (safe_query(
        "UPDATE
                `" . PREFIX . "plugins_news_comments`
            SET
                comment='" . $message . "'
            WHERE
                commentID='" . (int)$_POST[ 'commentID' ] . "'"
    )
    ) {
        header("Location: " . $referer);
    }
} else {
    $_language->readModule('comments');
    
    if (isset($_GET[ 'commentspage' ])) {
        $commentspage = (int)$_GET[ 'commentspage' ];
    } else {
        $commentspage = 1;
    }
    if (isset($_GET[ 'sorttype' ]) && strtoupper($_GET[ 'sorttype' ] == "ASC")) {
        $sorttype = 'ASC';
    } else {
        $sorttype = 'DESC';
    }
 
    if (!isset($parentID) && isset($_GET[ 'parentID' ])) {
        $parentID = (int)$_GET[ 'parentID' ];
    }
    if (!isset($type) && isset($_GET[ 'type' ])) {
        $type = mb_substr($_GET[ 'type' ], 0, 2);
    }
 
    $alle = safe_query(
        "SELECT
            `commentID`
        FROM
            `" . PREFIX . "plugins_news_comments`
        WHERE
            `parentID` = '" . (int)$parentID . "' AND
            `type` = '" . $type."'"
    );

    # #=========
        $settings = safe_query("SELECT * FROM " . PREFIX . "plugins_news_settings");
        $ds = mysqli_fetch_array($settings);

    
        $maxfeedback = $ds[ 'feedback' ];
        if (empty($maxfeedback)) {
        $maxfeedback = 10;
        }
 
        
  #=========        

    $gesamt = mysqli_num_rows($alle);
    $commentspages = ceil($gesamt / $maxfeedback);
 
    if ($commentspages > 1) {
        $page_link = makepagelink("$referer&amp;sorttype=$sorttype", $commentspage, $commentspages, 'comments');
    } else {
        $page_link = '';
    }
 
    if ($commentspage == "1") {
        $ergebnis = safe_query(
            "SELECT
                *
            FROM
                `" . PREFIX . "plugins_news_comments`
            WHERE
                `parentID` = '$parentID' AND
                `type` = '$type'
            ORDER BY
                `date` $sorttype
            LIMIT 0, ".(int)$maxfeedback
        );
        if ($sorttype == "DESC") {
            $n = $gesamt;
        } else {
            $n = 1;
        }
    } else {
        $start = ($commentspage - 1) * $maxfeedback;
        $ergebnis = safe_query(
            "SELECT
                *
            FROM
                `" . PREFIX . "plugins_news_comments`
            WHERE
                `parentID` = '$parentID' AND
                `type` = '$type'
            ORDER BY
                `date` $sorttype
            LIMIT $start, " . (int)$maxfeedback
        );
        if ($sorttype == "DESC") {
            $n = $gesamt - ($commentspage - 1) * $maxfeedback;
        } else {
            $n = ($commentspage - 1) * $maxfeedback + 1;
        }
    }
    if ($gesamt) {
        $data_array = array();
        $data_array['$comments']=$_lang['comments'];
        $template = $GLOBALS["_template"]->loadTemplate("comments","title", $data_array, $plugin_path);
        echo $template;
 
        if ($sorttype == "ASC") {
            $sorter = '<a href="' . $referer . '&amp;commentspage=' . $commentspage . '&amp;sorttype=DESC">' .
                $_lang[ 'sort' ] . '</a> <i class="fa fa-chevron-down" title="' .
                $_lang[ 'sort_desc' ] . '"></span>&nbsp;&nbsp;&nbsp;';
        } else {
            $sorter = '<a href="' . $referer . '&amp;commentspage=' . $commentspage . '&amp;sorttype=ASC">' .
                $_lang[ 'sort' ] . '</a> <i class="fa fa-chevron-up" title="' .
                $_lang[ 'sort_asc' ] . '"></span>&nbsp;&nbsp;&nbsp;';
        }
 
        $data_array = array();
        $data_array['$sorter'] = $sorter;
        
        $template = $GLOBALS["_template"]->loadTemplate("comments","head", $data_array, $plugin_path);
        echo $template;
 
        while ($ds = mysqli_fetch_array($ergebnis)) {
             
            $date = getformatdatetime($ds[ 'date' ]);
 
            if ($ds[ 'userID' ]) {
                $ip = '';
                $poster = '<a class="titlelink" href="index.php?site=profile&amp;id=' . $ds[ 'userID' ] . '"><b>' .
                    strip_tags(getnickname($ds[ 'userID' ])) . '</b></a>';
                if (isclanmember($ds[ 'userID' ])) {
                    $member = $_lang[ 'clanmember_icon' ];
                } else {
                    $member = '';
                }
 
                $quotemessage = addslashes(getinput($ds[ 'comment' ]));
                $quotemessage = str_replace(array("\r\n", "\r", "\n"), array('\r\n', '\r', '\n'), $quotemessage);
                $quotenickname = addslashes(getinput(getnickname($ds[ 'userID' ])));
                $quote = str_replace(
                    array('%nickname%', '%message%'),
                    array($quotenickname, $quotemessage),
                    $_lang[ 'quote_link' ]
                );
 
                #$country = '[flag]' . getcountry($ds[ 'userID' ]) . '[/flag]';
                #$country = $country;
 
                if (($email = getemail($ds[ 'userID' ])) && !getemailhide($ds[ 'userID' ])) {
                    $email = str_replace('%email%', mail_protect($email), $_lang[ 'email_link' ]);
                } else {
                    $email = '';
                }
                $gethomepage = gethomepage($ds[ 'userID' ]);
                if ($gethomepage != "" && $gethomepage != "http://" && $gethomepage != "http:///"
                    && $gethomepage != "n/a"
                ) {
                    $hp = '<a href="http://' . $gethomepage .
                        '" target="_blank"><i class="fa fa-home" title="' .
                        $_lang[ 'homepage' ] . '"></i></a>';
                } else {
                    $hp = '';
                }
 
                if (isonline($ds[ 'userID' ]) == "offline") {
                    $statuspic = '<span class="label label-danger">offline</span>';
                } else {
                    $statuspic = '<span class="label label-success">online</span>';
                }
 
                $avatar = '<img src="images/avatars/' . getavatar($ds[ 'userID' ]) .
                    '" class="text-left" alt="Avatar">';
 
                if ($loggedin && $ds[ 'userID' ] != $userID) {
                    $pm = '<a href="index.php?site=messenger&amp;action=touser&amp;touser=' . $ds[ 'userID' ] .
                        '"><i class="fas fa-envelope" title="' .
                        $_lang[ 'send_message' ] . '"></i></a>';
                    
                } else {
                    $pm = '';
                    
                }
            } else {
                $member = '';
                $avatar = '<img src="images/avatars/noavatar.gif" class="text-left" alt="Avatar">';
                #$country = '';
                $pm = '';
                $statuspic = '';
                $ds[ 'nickname' ] = strip_tags($ds[ 'nickname' ]);
                $ds[ 'nickname' ] = htmlspecialchars($ds[ 'nickname' ]);
                $poster = strip_tags($ds[ 'nickname' ]);
 
                $ds[ 'email' ] = strip_tags($ds[ 'email' ]);
                $ds[ 'email' ] = htmlspecialchars($ds[ 'email' ]);
                if ($ds[ 'email' ]) {
                    $email = str_replace('%email%', mail_protect($ds[ 'email' ]), $_lang[ 'email_link' ]);
                } else {
                    $email = '';
                }
 
                $ds[ 'url' ] = strip_tags($ds[ 'url' ]);
                $ds[ 'url' ] = htmlspecialchars($ds[ 'url' ]);
                if (!stristr($ds[ 'url' ], 'http://')) {
                    $ds[ 'url' ] = "http://" . $ds[ 'url' ];
                }
                if ($ds[ 'url' ] != "http://" && $ds[ 'url' ] != "") {
                    $hp = '<a href="' . $ds[ 'url' ] .
                        '" target="_blank"><i class="fa fa-home" title="' .
                        $_lang[ 'homepage' ] . '"></i></a>';
                } else {
                    $hp = '';
                }
                $ip = 'IP: ';
                if (isfeedbackadmin($userID)) {
                    $ip .= $ds[ 'ip' ];
                } else {
                    $ip .= 'saved';
                }
 
                $quotemessage = addslashes(getinput($ds[ 'comment' ]));
                $quotenickname = addslashes(getinput($ds[ 'nickname' ]));
                $quote = str_replace(
                    array('%nickname%', '%message%'),
                    array($quotenickname, $quotemessage),
                    $_lang[ 'quote_link' ]
                );
            }
 
            $content = $ds[ 'comment' ];
            $content = $content. $ds[ 'commentID' ];
 
            if (isfeedbackadmin($userID) || iscommentposter($userID, $ds[ 'commentID' ])) {
                $edit =
                    '<a href="index.php?site=news_comments&amp;editcomment=true&amp;id=' . $ds[ 'commentID' ] . '&amp;ref=' .
                    urlencode($referer) . '" title="' . $_lang[ 'edit_comment' ] .
                    '"><i class="fas fa-edit"></i></a>';
            } else {
                $edit = '';
            }
 
            if (isfeedbackadmin($userID)) {
                $actions =
                    '<input class="input" type="checkbox" name="commentID[]" value="' . $ds[ 'commentID' ] . '">';
            } else {
                $actions = '';
            }
 
            $spam_buttons = "";
            if (!empty($spamapikey)) {
                if (ispageadmin($userID)) {
                    $spam_buttons =
                        '<input type="button" value="Spam" onclick="eventfetch(\'ajax_spamfilter.php?commentID=' .
                        $ds[ 'commentID' ] . '&type=spam\',\'\',\'return\')">
                        <input type="button" value="Ham" onclick="eventfetch(\'ajax_spamfilter.php?commentID=' .
                        $ds[ 'commentID' ] . '&type=ham\',\'\',\'return\')">';
                }
            }
 
            $data_array = array();
            $data_array['$avatar'] = $avatar;
            $data_array['$content'] = $content;
            $data_array['$edit'] = $edit;
            $data_array['$actions'] = $actions;
            $data_array['$poster'] = $poster;
            $data_array['$date'] = $date;
            
            $template = $GLOBALS["_template"]->loadTemplate("comments","content_area", $data_array, $plugin_path);
            echo $template;
 
            unset(
                $member,
                $quote,
                #$country,
                $email,
                $hp,
                $avatar,
                $pm,
                $buddy,
                $ip,
                $edit
            );
 
            if ($sorttype == "DESC") {
                $n--;
            } else {
                $n++;
            }
        }
 
        if (isfeedbackadmin($userID)) {
            $CAPCLASS = new \webspell\Captcha;
                            $CAPCLASS->createTransaction();
                            $hash = $CAPCLASS->getHash();
            $submit = '<input type="hidden" name="referer" value="' . $referer . '">
                    <input class="input" type="checkbox" name="ALL" value="ALL" onclick="SelectAll(this.form);"> ' .
                    $_lang[ 'select_all' ] . '
                    <input type="submit" value="' . $_lang[ 'delete_selected' ] . '" class="btn btn-danger">';
        } else {
            $submit = '';
        }
 
        $data_array = array();
        $data_array['$page_link'] = $page_link;
        $data_array['$submit'] = $submit;

        $template = $GLOBALS["_template"]->loadTemplate("comments","foot", $data_array, $plugin_path);
        echo $template;
    }
 
    if ($comments_allowed) {
        if ($loggedin) {
            
            $data_array = array();
            $data_array['$userID'] = $userID;
            $data_array['$referer'] = $referer;
            $data_array['$parentID'] = $parentID;
            $data_array['$type'] = $type;
            
            $data_array['$title_comment']=$_lang['title_comment'];
            $data_array['$post_comment']=$_lang['post_comment'];
            
            $template = $GLOBALS["_template"]->loadTemplate("comments","add_user", $data_array, $plugin_path);
            echo $template;

        } elseif ($comments_allowed == 2) {
            if (isset($_COOKIE[ 'visitor_info' ])) {
                $visitor = explode("--||--", $_COOKIE[ 'visitor_info' ]);
                $name = getforminput(stripslashes($visitor[ 0 ]));
                $mail = getforminput(stripslashes($visitor[ 1 ]));
                $url = getforminput(stripslashes($visitor[ 2 ]));
            } else {
                $url = "http://";
                $name = "";
                $mail = "";
            }
 
            /*if (isset($_GET[ 'error' ])) {
                $err = $_GET[ 'error' ];
            } else {
                $err = "";
            }
            if ($err == "nickname") {
                $error = $_lang[ 'error_nickname' ];
                $name = "";
            } elseif ($err == "captcha") {
                $error = $_lang[ 'error_captcha' ];
            } else {
                $error = '';
            }
 
            if (isset($_SESSION[ 'comments_message' ])) {
                $message = getforminput($_SESSION[ 'comments_message' ]);
                unset($_SESSION[ 'comments_message' ]);
            } else {
                $message = "";
            }
 
            $CAPCLASS = new \webspell\Captcha();
            $captcha = $CAPCLASS->createCaptcha();
            $hash = $CAPCLASS->getHash();
            $CAPCLASS->clearOldCaptcha();
 
            $data_array = array();
            $data_array['$name'] = $name;
            $data_array['$mail'] = $mail;
            $data_array['$url'] = $url;
            $data_array['$message'] = $message;
            $data_array['$captcha'] = $captcha;
            $data_array['$hash'] = $hash;
            $data_array['$referer'] = $referer;
            $data_array['$parentID'] = $parentID;
            $data_array['$type'] = $type;*/

            $data_array['$no_access']=$_lang['no_access'];

            $template = $GLOBALS["_template"]->loadTemplate("comments","add_visitor", $data_array, $plugin_path);
            echo $template;
            
        } else {
            echo $_lang[ 'no_access' ];
        }
    } else {
        echo $_lang[ 'comments_disabled' ];
    }

    }
