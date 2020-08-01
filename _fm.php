<?php require 'fm_inc/config.php'; ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="fm_inc/css/bootstrap.min.css">
        <link rel="stylesheet" href="fm_inc/css/fCss.min.css">
        <link rel="stylesheet" href="fm_inc/css/jquery.dataTables.min.css">

        <title>File Manager</title>
    </head>
    <body>
        <div class="row col-sm-12 pl-5 pt-2 text-center">
            <div class="col-sm-4 d-none d-md-block d-lg-block">
                <div class="alert alert-primary" role="alert">
                    <h1>20%</h1>
                </div>
            </div>
            <div class="col-sm-4 d-none d-md-block d-lg-block">
                <div class="alert alert-secondary" role="alert">
                    <h1>40%</h1>
                </div>
            </div>
            <div class="col-sm-4 d-none d-md-block d-lg-block">
                <div class="alert alert-success" role="alert">
                    <h1>70%</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <ul class="nav justify-content-center pt-1 pb-1">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php
                    $from_folder = false;
                    $from = '';
                    $dir = dirname('.');
                    $paths[] = '.';
                    $l = count($paths) - 1;
                    if (isset($_GET['folder']) && !empty($_GET['folder'])) {
                        $dir = $_GET['folder'];
                        $paths = explode("/", $dir);
                        $l = count($paths) - 1;
                        $loop = 0;
                        if ($dir != '.') {
                            $from_folder = true;
                        }
                        while ($loop < $l) {
                            $from .= $paths[$loop] . "/";
                            $back = '.';
                            for ($index = 1; $index <= $loop; $index++) {
                                $back .= "/" . $paths[$index];
                            }
                            ?>
                            <li class="breadcrumb-item"><a href="?folder=<?= $back ?>"><?= ($paths[$loop] == '.') ? 'root' : $paths[$loop] ?></a></li>
                            <?php
                            $loop++;
                        }
                        $from = chop($from, "/");
                    }
                    ?>
                    <li class="breadcrumb-item"><a href="#"><?= ($paths[$l] == '.') ? 'root' : $paths[$l] ?></a></li>
                </ol>
            </nav>
            <?php
            $files = scandir($dir);
            $file_count = 1;
            if ($from_folder != false) {
                ?>
                <a href="<?= "?folder=" . $from ?>" class="btn btn-sm btn-primary m-2">Back</a>
            <?php } ?>
        </div>
        <div class="col-sm-12 mt-1 mb-1">
            <table id="fileTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">File / Folder Name</th>
                        <th scope="col">Size</th>
                        <th scope="col" class="d-none d-md-block d-lg-block">Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($index = 2; $index < count($files); $index++) {
                        $filePath = $dir . "/" . $files[$index];
                        $file = new file($filePath);
                        if (!$file->avoidFile) {
                            ?>
                            <?php if ($file->isFile) { ?>
                                <tr ondblclick="changeFileName('<?= $file_count ?>')" onmouseover="showTools('<?= $file_count ?>')" onmouseout="hideTools('<?= $file_count ?>')" onfocusout="saveAll('<?= $file_count ?>')" draggable="true">
                                <?php } else { ?>
                                <tr>
                                <?php } ?>
                                <td>
                                    <input type="text" value="<?= $filePath ?>" id="<?= 'tr_n_path' . $file_count ?>" hidden readonly>
                                    <a id="<?= 'tr_n_' . $file_count ?>" class="fileNameLink" href="<?= (!$file->isFile) ? "?folder=" . $filePath : "#" ?>"><?= $files[$index] ?></a>
                                    <input type="text" value="<?= $files[$index] ?>" class="form-control col-sm-4 fileEditInput" data-id='<?= $file_count ?>' id="<?= 'tr_n_box_' . $file_count ?>" hidden>
                                </td>
                                <td>
                                    <?= $file->fileSize . " KB" ?>
                                </td>
                                <td class="d-none d-md-block d-lg-block">
                                    <table style="width: 100%;display: none" id="<?= 'tr_tools_' . $file_count ?>" class="tools">
                                        <thead>
                                            <tr>
                                                <th class="btn btn-default" onclick="modifyFile(1, '<?= $filePath ?>', '<?= $files[$index] ?>')"><a href="#" class="btn-sm btn-danger">Delete</a></th>
                                                <th class="btn btn-default" data-toggle="modal" onclick="modelChange(2, '<?= $filePath ?>', '<?= $files[$index] ?>')" data-target="#fileExplore">Move</th>
                                                <th class="btn btn-default" data-toggle="modal" onclick="modelChange(1, '<?= $filePath ?>', '<?= $files[$index] ?>')" data-target="#fileExplore">Copy</th>
                                                <th class="btn btn-default"><a class="btn-sm btn-primary" href="<?= $filePath ?>" download>Download</a></th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <span id="<?= 'tr_lmod_' . $file_count ?>"><?= $file->fileModDate ?></span>
                                </td>
                            </tr>
                            <?php
                            $file_count++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php include 'fm_inc/model.php'; ?>
        <script src="fm_inc/js/jquery.min.js"></script>
        <script src="fm_inc/js/popper.min.js"></script>
        <script src="fm_inc/js/bootstrap.min.js"></script>
        <script src="fm_inc/js/main.js"></script>
        <script src="fm_inc/js/fAwesome.min.js"></script>
        <script src="fm_inc/js/jquery.dataTables.min.js"></script>
    </body>
</html>