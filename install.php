<script>
function goBack() {
    window.history.back();
}
</script>
<?php

#@info:	settings
$modulname1	 	= 	"news"; 									// name to uninstall
$plugin_table1 	= 	"news"; 									// name of the mysql table
$str1			=	"News"; 									// name of the plugin
$navi_name1		=	"{[de]}Neuigkeiten{[en]}News";				// name of the Navi
$description1	=	"Mit diesem Plugin könnt ihr eure news anzeigen lassen."; 	// description of the plugin
$admin_file1 	=	"admin_news";								// administration file
$activate1 		=	"1";										// plugin activate 1 yes | 0 no
$author1		=	"T-Seven";									// author
$website1		= 	"https://webspell-rm.de";					// authors website
$index_link1	=	"admin_news,news_archive,news,news_comments,news_contents";// index file (without extension, also no .php)
$sc_link1 		=	"widget_headlines";  							// sc_ file (visible as module/box)
$hiddenfiles1 	=	"";											// hiddenfiles (background working, no display anywhere)
$version1		=	"1.2";										// current version, visit authors website for updates, fixes, ..
$path1			=	"includes/plugins/news/";					// plugin files location
$navi_link1		=	"news";					 					// navi link file (index.php?site=...)
$dashnavi_link1	=	"admin_news"; 								// dashboard_navigation link file

#@info:	settings
$modulname2	 	= 	"news_rubrics"; 							// name to uninstall
$plugin_table2 	= 	"news_rubrics"; 							// name of the mysql table
$str2			=	"News Kategorien"; 							// name of the plugin
$navi_name2		=	"{[de]}News Archive{[en]}News  Archive";	// name of the Navi
$description2	=	"Mit diesem Plugin könnt ihr eure news Kategorien anzeigen lassen."; 	// description of the plugin
$admin_file2	=	"admin_news_categorys";						// administration file
$activate2 		=	"1";										// plugin activate 1 yes | 0 no
$author2		=	"T-Seven";									// author
$website2		= 	"https://webspell-rm.de";					// authors website
$index_link2	=	"admin_news_categorys";						// index file (without extension, also no .php)
$sc_link2 		=	"";  										// sc_ file (visible as module/box)
$hiddenfiles2 	=	"";											// hiddenfiles (background working, no display anywhere)
$version2		=	"1.2";										// current version, visit authors website for updates, fixes, ..
$path2			=	"includes/plugins/news/";					// plugin files location
$navi_link2		=	"news_archive"; 							// navi link file (index.php?site=...)
$dashnavi_link2	=	""; 										// dashboard_navigation link file

#@info:	settings
$modulname3	 	= 	"news_settings"; 							// name to uninstall
$plugin_table3 	= 	"news_settings"; 							// name of the mysql table
$str3			=	"Neuigkeiten Settings"; 					// name of the plugin
$description3	=	"Mit diesem Plugin könnt ihr eure news Settings einstellen."; 	// description of the plugin
$admin_file3	=	"admin_news_settings";						// administration file
$activate3 		=	"1";										// plugin activate 1 yes | 0 no
$author3		=	"T-Seven";									// author
$website3		= 	"https://webspell-rm.de";					// authors website
$index_link3	=	"admin_news_settings,news";					// index file (without extension, also no .php)
$sc_link3 		=	"";  										// sc_ file (visible as module/box)
$hiddenfiles3 	=	"";											// hiddenfiles (background working, no display anywhere)
$version3		=	"1.2";										// current version, visit authors website for updates, fixes, ..
$path3			=	"includes/plugins/news/";					// plugin files location
$navi_link3		=	"news_contents";					 		// navi link file (index.php?site=...)
$dashnavi_link3	=	""; 										// dashboard_navigation link file

$modulname4	 	= 	"news_archive"; 							// name to uninstall
$plugin_table4	=	"news_archive"; 							// navi link file (index.php?site=...)
$modulname5	 	= 	"news_contents"; 							// name to uninstall
$plugin_table5	=	"news_contents";					 		// navi link file (index.php?site=...)

$str6			=	"news_comments"; 							// name of the plugin


#@info: database
$installa = "CREATE TABLE `" . PREFIX . "plugins_news` (
  `newsID` int(11) NOT NULL AUTO_INCREMENT,
  `rubric` int(11) NOT NULL DEFAULT '0',
  `date` int(14) NOT NULL DEFAULT '0',
  `poster` int(11) NOT NULL DEFAULT '0',
  `headline` varchar(255) NOT NULL DEFAULT '',
  `link1` varchar(255) NOT NULL,
  `url1` varchar(255) NOT NULL DEFAULT '',
  `window1` int(11) NOT NULL DEFAULT '0',
  `link2` varchar(255) NOT NULL,
  `url2` varchar(255) NOT NULL,
  `window2` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `banner` varchar(255) NOT NULL DEFAULT '',
  `displayed` varchar(255) NOT NULL,
  `screens` text NOT NULL,
  `comments` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`newsID`)
) AUTO_INCREMENT=1
  DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci";

$installb = "CREATE TABLE `" . PREFIX . "plugins_news_rubrics` (
  `rubricID` int(11) NOT NULL AUTO_INCREMENT,
  `rubric` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `displayed` int(11) NOT NULL,
  PRIMARY KEY (`rubricID`)
) AUTO_INCREMENT=1
  DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci";

$installc = "CREATE TABLE `" . PREFIX . "plugins_news_settings` (
  `newssetID` int(11) NOT NULL AUTO_INCREMENT,
  `admin_news` int(11) NOT NULL DEFAULT '0',
  `news` int(11) NOT NULL DEFAULT '0',
  `newsarchiv` int(11) NOT NULL DEFAULT '0',
  `headlines` int(11) NOT NULL DEFAULT '0',
  `newschars` int(11) NOT NULL DEFAULT '0',
  `headlineschars` int(11) NOT NULL DEFAULT '0',
  `topnewschars` int(11) NOT NULL DEFAULT '0',
  `feedback` int(11) NOT NULL DEFAULT '0',
  `switchen` char(1) NOT NULL DEFAULT 'u',
  PRIMARY KEY (`newssetID`)
) AUTO_INCREMENT=1
  DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci";  

$installd = "INSERT INTO `".PREFIX."plugins_news_settings` (`newssetID`, `admin_news`, `news`, `newsarchiv`, `headlines`, `newschars`, `headlineschars`, `topnewschars`, `feedback`) VALUES
(1, 5, 3, 10, 4, 700, 200, 200, 5)";

$installe = "CREATE TABLE `" . PREFIX . "plugins_news_comments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `parentID` int(11) NOT NULL DEFAULT '0',
  `type` char(2) NOT NULL DEFAULT '',
  `userID` int(11) NOT NULL DEFAULT '0',
  `nickname` varchar(255) NOT NULL DEFAULT '',
  `date` int(14) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`commentID`),
  KEY `parentID` (`parentID`),
  KEY `type` (`type`),
  KEY `date` (`date`)
) AUTO_INCREMENT=1
  DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci"; 



# 	= = =		/!\ DO NOT EDIT THE LINES BELOW !!!		= = =
# 	= = =		/!\ DO NOT EDIT THE LINES BELOW !!!		= = =
# 	= = =		/!\ DO NOT EDIT THE LINES BELOW !!!		= = =

# 	= = =		/!\ Ab hier nichts mehr ändern !!!		= = =
  
$add_plugin1 = "INSERT INTO `".PREFIX."plugins` (`name`, `modulname`, `description`, `admin_file`, `activate`, `author`, `website`, `index_link`, `sc_link`, `hiddenfiles`, `version`, `path`) 
				VALUES ('$str1', '$modulname1', '$description1', '$admin_file1', '$activate1', '$author1', '$website1', '$index_link1', '$sc_link1', '$hiddenfiles1', '$version1', '$path1');";

$add_plugin2 = "INSERT INTO `".PREFIX."plugins` (`name`, `modulname`, `description`, `admin_file`, `activate`, `author`, `website`, `index_link`, `sc_link`, `hiddenfiles`, `version`, `path`) 
				VALUES ('$str2', '$modulname2', '$description2', '$admin_file2', '$activate2', '$author2', '$website2', '$index_link2', '$sc_link2', '$hiddenfiles2', '$version2', '$path2');";				

$add_plugin3 = "INSERT INTO `".PREFIX."plugins` (`name`, `modulname`, `description`, `admin_file`, `activate`, `author`, `website`, `index_link`, `sc_link`, `hiddenfiles`, `version`, `path`) 
				VALUES ('$str3', '$modulname3', '$description3', '$admin_file3', '$activate3', '$author3', '$website3', '$index_link3', '$sc_link3', '$hiddenfiles3', '$version3', '$path3');";

$add_navigation1 = "INSERT INTO `".PREFIX."navigation_website_sub` (`mnavID`, `name`, `modulname`, `url`, `sort`, `indropdown`) 
					VALUES ('1','$navi_name1', '$modulname1', 'index.php?site=$navi_link1', '1', '1');";

$add_navigation2 = "INSERT INTO `".PREFIX."navigation_website_sub` (`mnavID`, `name`, `modulname`, `url`, `sort`, `indropdown`) 
					VALUES ('1','$navi_name2', '$modulname4', 'index.php?site=$navi_link2', '1', '1');";

$add_dashboard_navigation = "INSERT INTO `".PREFIX."navigation_dashboard_links` (`catID`, `name`, `modulname`, `url`, `accesslevel`, `sort`) 
					VALUES ('7','$navi_name1', '$modulname1', 'admincenter.php?site=$dashnavi_link1', 'news', '1')";

$add_module1 = "INSERT INTO `".PREFIX."settings_moduls` (`module`, `modulname`, `activated`, `le_activated`, `re_activated`, `deactivated`, `head_activated`, `content_head_activated`, `content_foot_activated`, `sort`) VALUES ('$plugin_table1', '$modulname1', '1', '0', '0', '0', '0', '0', '0', '1');";

$add_module2 = "INSERT INTO `".PREFIX."settings_moduls` (`module`, `modulname`, `activated`, `le_activated`, `re_activated`, `deactivated`, `head_activated`, `content_head_activated`, `content_foot_activated`, `sort`) VALUES ('$plugin_table4', '$modulname4', '1', '0', '0', '0', '0', '0', '0', '1');";

$add_module3 = "INSERT INTO `".PREFIX."settings_moduls` (`module`, `modulname`, `activated`, `le_activated`, `re_activated`, `deactivated`, `head_activated`, `content_head_activated`, `content_foot_activated`, `sort`) VALUES ('$plugin_table5', '$modulname5', '1', '0', '0', '0', '0', '0', '0', '1');";


			
if(!ispageadmin($userID)) { echo ("Access denied!"); return false; }		
			
		echo "<div class='card'>
			<div class='card-header'>
				<h3>$str1 Database Installation</h3>
			</div>
			<div class='card-body'>";
	
		# if table exists
		try {
			if(mysqli_query($_database, $installa)) { 
				echo "<div class='alert alert-success'>$str1 installation successful <br />";
				echo "$str1 installation erfolgreich <br /></div>";
			} else {
					echo "<div class='alert alert-warning'>$str1 entry already exists <br />";
					echo "$str1 Eintrag schon vorhanden <br /></div>";
					echo "<hr>";
			}	
		} CATCH (EXCEPTION $x) {
				echo "<div class='alert alert-danger'>$str1 installation failed <br />";
				echo "Send the following line to the support team:<br /><br />";
				echo "<pre>".$x->message()."</pre>		
					  </div>";
		}

		# if table exists
		try {
			if(mysqli_query($_database, $installb)) { 
				echo "<div class='alert alert-success'>$str2 installation successful <br />";
				echo "$str2 installation erfolgreich <br /></div>";
			} else {
					echo "<div class='alert alert-warning'>$str2 entry already exists <br />";
					echo "$str2 Eintrag schon vorhanden <br /></div>";
					echo "<hr>";
			}	
		} CATCH (EXCEPTION $x) {
				echo "<div class='alert alert-danger'>$str2 installation failed <br />";
				echo "Send the following line to the support team:<br /><br />";
				echo "<pre>".$x->message()."</pre>		
					  </div>";
		}

		# if table exists
		try {
			if(mysqli_query($_database, $installc)) { 
				echo "<div class='alert alert-success'>$str3 installation successful <br />";
				echo "$str3 installation erfolgreich <br /></div>";
			} else {
					echo "<div class='alert alert-warning'>$str3 entry already exists <br />";
					echo "$str3 Eintrag schon vorhanden <br /></div>";
					echo "<hr>";
			}	
		} CATCH (EXCEPTION $x) {
				echo "<div class='alert alert-danger'>$str3 installation failed <br />";
				echo "Send the following line to the support team:<br /><br />";
				echo "<pre>".$x->message()."</pre>		
					  </div>";
		}

		# if table exists
		try {
			if(mysqli_query($_database, $installd)) { 
				echo "<div class='alert alert-success'>$str2 installation successful <br />";
				echo "$str2 installation erfolgreich <br /></div>";
			} else {
					echo "<div class='alert alert-warning'>$str2 entry already exists <br />";
					echo "$str2 Eintrag schon vorhanden <br /></div>";
					echo "<hr>";
			}	
		} CATCH (EXCEPTION $x) {
				echo "<div class='alert alert-danger'>$str2 installation failed <br />";
				echo "Send the following line to the support team:<br /><br />";
				echo "<pre>".$x->message()."</pre>		
					  </div>";
		}

		# if table exists
		try {
			if(mysqli_query($_database, $installe)) { 
				echo "<div class='alert alert-success'>$str6 installation successful <br />";
				echo "$str6 installation erfolgreich <br /></div>";
			} else {
					echo "<div class='alert alert-warning'>$str6 entry already exists <br />";
					echo "$str6 Eintrag schon vorhanden <br /></div>";
					echo "<hr>";
			}	
		} CATCH (EXCEPTION $x) {
				echo "<div class='alert alert-danger'>$str6 installation failed <br />";
				echo "Send the following line to the support team:<br /><br />";
				echo "<pre>".$x->message()."</pre>		
					  </div>";
		}

		# Add to Plugin-Manager
		if(mysqli_num_rows(safe_query("SELECT name FROM `".PREFIX."plugins` WHERE name ='".$str1."'"))>0) {
					echo "<div class='alert alert-warning'>$str1 Plugin Manager entry already exists <br />";
					echo "$str1 Plugin Manager Eintrag schon vorhanden <br />";
					echo "$str1 Entrée Plugin Manager existe déjà <br /></div>";
					echo "<hr>";
		} else {
			try {
				if(safe_query($add_plugin1)) { 
					echo "<div class='alert alert-success'>$str1 added to the plugin manager <br />";
					echo "$str1 wurde dem Plugin Manager hinzugef&uuml;gt <br />";
					echo "$str1 a &eacute;t&eacute; ajout&eacute; au manager de plugin <br />";
					echo "<a href = '/admin/admincenter.php?site=plugin-manager' target='_blank'><b>LINK => Plugin Manager</b></a></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to plugin manager failed <br />";
					echo "Zum Plugin Manager hinzuf&uuml;gen fehlgeschlagen <br />";
					echo "Echec d'ajout au manager de plugin <br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str1 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}

		# Add to Plugin-Manager
		if(mysqli_num_rows(safe_query("SELECT name FROM `".PREFIX."plugins` WHERE name ='".$str2."'"))>0) {
					echo "<div class='alert alert-warning'>$str2 Plugin Manager entry already exists <br />";
					echo "$str2 Plugin Manager Eintrag schon vorhanden <br />";
					echo "$str2 Entrée Plugin Manager existe déjà <br /></div>";
					echo "<hr>";
		} else {
			try {
				if(safe_query($add_plugin2)) { 
					echo "<div class='alert alert-success'>$str2 added to the plugin manager <br />";
					echo "$str2 wurde dem Plugin Manager hinzugef&uuml;gt <br />";
					echo "$str2 a &eacute;t&eacute; ajout&eacute; au manager de plugin <br />";
					echo "<a href = '/admin/admincenter.php?site=plugin-manager' target='_blank'><b>LINK => Plugin Manager</b></a></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to plugin manager failed <br />";
					echo "Zum Plugin Manager hinzuf&uuml;gen fehlgeschlagen <br />";
					echo "Echec d'ajout au manager de plugin <br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str1 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}

		# Add to Plugin-Manager
		if(mysqli_num_rows(safe_query("SELECT name FROM `".PREFIX."plugins` WHERE name ='".$str3."'"))>0) {
					echo "<div class='alert alert-warning'>$str3 Plugin Manager entry already exists <br />";
					echo "$str3 Plugin Manager Eintrag schon vorhanden <br />";
					echo "$str3 Entrée Plugin Manager existe déjà <br /></div>";
					echo "<hr>";
		} else {
			try {
				if(safe_query($add_plugin3)) { 
					echo "<div class='alert alert-success'>$str3 added to the plugin manager <br />";
					echo "$str3 wurde dem Plugin Manager hinzugef&uuml;gt <br />";
					echo "$str3 a &eacute;t&eacute; ajout&eacute; au manager de plugin <br />";
					echo "<a href = '/admin/admincenter.php?site=plugin-manager' target='_blank'><b>LINK => Plugin Manager</b></a></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to plugin manager failed <br />";
					echo "Zum Plugin Manager hinzuf&uuml;gen fehlgeschlagen <br />";
					echo "Echec d'ajout au manager de plugin <br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str3 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}

		# Add to navigation
		if(mysqli_num_rows(safe_query("SELECT * FROM `".PREFIX."navigation_website_sub` WHERE `name`='$str1' AND `url`='index.php?site=$navi_link1'"))>0) {
					echo "<div class='alert alert-warning'>$str1 Navigation entry already exists <br />";
					echo "$str1 Navigationseintrag schon vorhanden <br /></div>";
					
		} else {
			try {
				if(safe_query($add_navigation1)) { 
					echo "<div class='alert alert-success'>$str1 added to the Navigation <br />";
					echo "$str1 wurde der Navigation hinzugef&uuml;gt <br />";
					echo "<a href = '/admin/admincenter.php?site=navigation' target='_blank'><b>LINK => Navigation</b></a></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to Navigation failed <br />";
					echo "Zur Navigation hinzuf&uuml;gen fehlgeschlagen<br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str1 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}

		# Add to navigation 2
		if(mysqli_num_rows(safe_query("SELECT * FROM `".PREFIX."navigation_website_sub` WHERE `name`='$str2' AND `url`='index.php?site=$navi_link2'"))>0) {
					echo "<div class='alert alert-warning'>$str2 Navigation entry already exists <br />";
					echo "$str2 Navigationseintrag schon vorhanden <br /></div>";
					
		} else {
			try {
				if(safe_query($add_navigation2)) { 
					echo "<div class='alert alert-success'>$str2 added to the Navigation <br />";
					echo "$str2 wurde der Navigation hinzugef&uuml;gt <br />";
					echo "<a href = '/admin/admincenter.php?site=navigation' target='_blank'><b>LINK => Navigation</b></a></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to Navigation failed <br />";
					echo "Zur Navigation hinzuf&uuml;gen fehlgeschlagen<br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str2 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}


		# Add to dashboard navigation
		if(mysqli_num_rows(safe_query("SELECT * FROM `".PREFIX."navigation_dashboard_links` WHERE `name`='$str1' AND `url`='admincenter.php?site=$dashnavi_link1'"))>0) {
					echo "<div class='alert alert-warning'>$str1 Dashboard Navigation entry already exists <br />";
					echo "$str1 Dashboard Navigationseintrag schon vorhanden <br /></div>";
					
		} else {
			try {
				if(safe_query($add_dashboard_navigation)) { 
					echo "<div class='alert alert-success'>$str1 added to the Dashboard Navigation <br />";
					echo "$str1 wurde der Dashboard Navigation hinzugef&uuml;gt <br />";
					echo "<a href = '/admin/admincenter.php?site=dashnavi' target='_blank'><b>LINK => Dashboard Navigation</b></a></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to Dashboard Navigation failed <br />";
					echo "Zur Dashboard Navigation hinzuf&uuml;gen fehlgeschlagen<br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str1 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}

		# Add to module
		if(mysqli_num_rows(safe_query("SELECT * FROM `".PREFIX."settings_moduls` WHERE `module`='".$plugin_table1."'"))>0) {
					echo "<div class='alert alert-warning'>$str1 Entry already exists <br />";
					echo "$str1 Eintrag schon vorhanden <br /></div>";
					
		} else {
			try {
				if(safe_query($add_module1)) { 
					echo "<div class='alert alert-success'>$str1 added to the Module <br />";
					echo "$str1 wurde in Module hinzugef&uuml;gt <br /></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to Module failed <br />";
					echo "Zur Module hinzuf&uuml;gen fehlgeschlagen<br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str1 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}
		
		# Add to module
		if(mysqli_num_rows(safe_query("SELECT * FROM `".PREFIX."settings_moduls` WHERE `module`='".$navi_link2."'"))>0) {
					echo "<div class='alert alert-warning'>$str2 Entry already exists <br />";
					echo "$str2 Eintrag schon vorhanden <br /></div>";
					
		} else {
			try {
				if(safe_query($add_module2)) { 
					echo "<div class='alert alert-success'>$str2 added to the Module <br />";
					echo "$str2 wurde in Module hinzugef&uuml;gt <br /></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to Module failed <br />";
					echo "Zur Module hinzuf&uuml;gen fehlgeschlagen<br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str2 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}

		# Add to module
		if(mysqli_num_rows(safe_query("SELECT * FROM `".PREFIX."settings_moduls` WHERE `module`='".$navi_link3."'"))>0) {
					echo "<div class='alert alert-warning'>$str3 Entry already exists <br />";
					echo "$str3 Eintrag schon vorhanden <br /></div>";
					
		} else {
			try {
				if(safe_query($add_module3)) { 
					echo "<div class='alert alert-success'>$str3 added to the Module <br />";
					echo "$str3 wurde in Module hinzugef&uuml;gt <br /></div>";
				} else {
					echo "<div class='alert alert-danger'>Add to Module failed <br />";
					echo "Zur Module hinzuf&uuml;gen fehlgeschlagen<br /></div>";
				}	
			} CATCH (EXCEPTION $x) {
					echo "<div class='alert alert-danger'>$str3 installation failed <br />";
					echo "Send the following line to the support team:<br /><br />";
					echo "<pre>".$x->message()."</pre>		
						  </div>";
			}
		}

		echo "</div></div>";
	
	

	echo "<button class='btn btn-default btn-sm' onclick='goBack()'>Go Back</button>
	
		</div></div>";
	
 ?>