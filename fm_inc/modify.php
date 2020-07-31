<?php

session_start();

$obj['error'] = 1;
if (isset($_POST['data']) && isset($_POST['type']) && !empty($_POST['data']) && !empty($_POST['type'])) {
    $url = trim($_POST['data']);
    $type = intval($_POST['type']);
    $mod_path = '';
    $paths = explode('/', $url);
    $len = count($paths);
    for ($index = 1; $index < $len; $index++) {
        $mod_path .= "/" . $paths[$index];
    }
    if (!isset($_POST['fname']) || empty($_POST['fname'])) {
        $file = $paths[$len - 1];
    } else {
        $file = '';
        $fname = trim($_POST['fname']);
        $l = strlen($fname);
        while ($l > 0) {
            if ($fname[$l - 1] != " ") {
                $file = $fname[$l - 1] . $file;
            }
            $l--;
        }
    }

    if (isset($_SESSION['mod_url'])) {
        if ($type == 1) {
            if (copy(".." . $mod_path, '..' . $_SESSION['mod_url'] . "/" . $file)) {
                $obj['error'] = 0;
            }
        } elseif ($type == 2) {
            if (copy(".." . $mod_path, '..' . $_SESSION['mod_url'] . "/" . $file)) {
                if (unlink(".." . $mod_path)) {
                    $obj['error'] = 0;
                }
            }
        }
    }
    if ($type == 3) {
        if (unlink(".." . $mod_path)) {
            $obj['error'] = 0;
        }
    }
}
echo json_encode($obj);
