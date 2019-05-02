<?php
$name = "news";
// Name Tabelle | Where Klause | ID name
DeleteData("plugins","modulname",$name);
DeleteData("plugins","modulname","".$name."_categories");
DeleteData("plugins","modulname","".$name."_settings");
DeleteData("plugins","modulname","".$name."_archive");
DeleteData("settings_moduls","modulname",$name);
DeleteData("settings_moduls","modulname","".$name."_categories");
DeleteData("settings_moduls","modulname","".$name."_archive");
DeleteData("navigation_dashboard_links","modulname",$name);
DeleteData("navigation_website_sub","modulname",$name);
DeleteData("navigation_website_sub","modulname","".$name."_categories");
DeleteData("plugins_widgets","modulname",$name);
safe_query("DROP TABLE IF EXISTS " . PREFIX . "plugins_".$name.", " . PREFIX . "plugins_".$name."_rubrics, " . PREFIX . "plugins_".$name."_settings");
?>