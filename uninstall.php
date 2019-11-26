<?php
$name = "news";
// Name Tabelle | Where Klause | ID name
DeleteData("plugins","modulname",$name);
DeleteData("plugins","modulname","news_rubrics");
DeleteData("plugins","modulname","news_settings");
DeleteData("settings_moduls","modulname",$name);
DeleteData("settings_moduls","modulname","news_archive");
DeleteData("settings_moduls","modulname","news_contents");
DeleteData("navigation_dashboard_links","modulname",$name);
DeleteData("navigation_website_sub","modulname",$name);
DeleteData("navigation_website_sub","modulname","news_archive");
DeleteData("plugins_widgets","modulname",$name);
safe_query("DROP TABLE IF EXISTS " . PREFIX . "plugins_".$name."");
safe_query("DROP TABLE IF EXISTS " . PREFIX . "plugins_news_rubrics");
safe_query("DROP TABLE IF EXISTS " . PREFIX . "plugins_news_settings");
safe_query("DROP TABLE IF EXISTS " . PREFIX . "plugins_news_comments");
#safe_query("DROP TABLE IF EXISTS " . PREFIX . "plugins_comments_spam");
?>