<?php
$nowShowFiles = array("header.php", "footer.php",
  "search.php", "get-alerts.php", "scripts-js.php",
  "footer_unauth.php", "header_unauth.php",
  "js-templates.php", "edit.php", "delete-folders.php", "modals.php",
  "search-overlay.php"
);
$folders = array(
  "alerts", "dashboard", "reports", "mail-html", "news", "settings"
);
$sitePath = "http://" . $_SERVER["HTTP_HOST"] .  str_replace("make-html.php", "", $_SERVER["SCRIPT_NAME"]);

foreach($folders as $folder) {
  $handler = opendir($folder);
  $files = array();
  while ($file = readdir($handler))
    $files[] = $file;

  if(count($files) > 2) {
    sort($files);
    foreach($files as $file) {
      if((strpos($file, ".html") || strpos($file, ".php")) && !in_array($file, $nowShowFiles)) {
        $originalFile = $sitePath . $folder . "/" . $file;
        $destFile = $folder . "/" . str_replace("php", "html", $file);
        copy($originalFile, $destFile);
      }
    }
  }
}

copy($sitePath . 'main.php', 'main.html');
copy($sitePath . 'index.php', 'index.html');
file_put_contents('index.html', preg_replace('/\.php/', '.html', file_get_contents('index.html')));