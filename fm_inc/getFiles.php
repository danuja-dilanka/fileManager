<?php

session_start();
require 'config.php';
if (isset($_SESSION['mod_url'])) {
    unset($_SESSION['mod_url']);
}

$obj = [];
if (isset($_POST['data']) && !empty($_POST['data'])) {
    $from_folder = false;
    $dir = $_POST['data'];
    $paths = explode("/", $dir);
    $l = count($paths) - 1;
    $loop = 0;

    $mod_path = '';
    $len = count($paths);
    for ($index = 1; $index < $len; $index++) {
        $mod_path .= '/' . $paths[$index];
    }
    $_SESSION['mod_url'] = $mod_path;

    if ($dir != '.') {
        $from_folder = true;
    }
    while ($loop < $l) {
        $back = '.';
        for ($index = 1; $index <= $loop; $index++) {
            $back .= "/" . $paths[$index];
        }
        $loop++;
    }

    $files = scandir("../" . $dir);
    $file_count = 1;
    if ($from_folder != false) {
        $obj[$back] = "...";
    }
    for ($index = 2; $index < count($files); $index++) {
        $filePath = $dir . "/" . $files[$index];
        $file = new file("../" . $filePath);
        if (!$file->avoidFile) {
            if (!$file->isFile) {
                $obj[$filePath] = $files[$index];
                $file_count++;
            }
        }
    }
}

echo json_encode($obj);
