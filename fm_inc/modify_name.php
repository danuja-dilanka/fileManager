<?php

if (isset($_POST['newFname']) && isset($_POST['theFile'])) {
    $url = trim($_POST['theFile']);
    $fname = trim($_POST['newFname']);

    $mod_path = $file = $path = '';
    $paths = explode('/', $url);
    $len = count($paths);
    for ($index = 1; $index < $len; $index++) {
        $mod_path .= "/" . $paths[$index];
    }
    for ($index = 1; $index < ($len - 1); $index++) {
        $path .= "/" . $paths[$index];
    }
    $l = strlen($fname);
    while ($l > 0) {
        if ($fname[$l - 1] != " ") {
            $file = $fname[$l - 1] . $file;
        }
        $l--;
    }
    rename(".." . $mod_path, $path . "/" . $file);
}