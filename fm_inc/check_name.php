<?php

session_start();

$obj['error'] = 0;
if (isset($_POST['fname']) && !empty($_POST['fname'])) {
    $fname = trim($_POST['fname']);

    if (file_exists('..' . $_SESSION['mod_url'] . "/" . $fname)) {
        $obj['error'] = 1;
    }
}
echo json_encode($obj);
