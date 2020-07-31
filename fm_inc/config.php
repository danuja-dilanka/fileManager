<?php

//namespace fileManger;

class file {

    public $fileSize, $fileModDate;
    public $isFile = false;
    public $avoidFile = false;
    private $avoidFiles = ['fm_inc', '_fm.php'];

    function __construct($file) {
        $this->checkFile($file);
        $this->getFileSize($file);
        $this->getModDate($file);
    }

    /* --------------------- GET FILE SIZE */

    protected function getFileSize($file, $returnType = 'KB') {
        $type = strtoupper(trim($returnType));
        $bytes = filesize($file);
        if ($type == 'BYTE') {
            $this->fileSize = $bytes;
        } elseif ($type == 'KB') {
            $this->fileSize = round(($bytes / 1024), 2);
        } elseif ($type == 'MB') {
            $this->fileSize = round((($bytes / (1024 * 1024))), 2);
        } elseif ($type == 'GB') {
            $this->fileSize = round((($bytes / (1024 * 1024 * 1024))), 2);
        }
    }

    /* --------------------- GET FILE LAST MODIFIED DATE */

    protected function getModDate($file, $dateFormat = 'F d Y H:i:s') {
        $this->fileModDate = date($dateFormat, filemtime($file));
    }

    /* --------------------- IS FILE IS A FOLLDER ? */

    protected function checkFile($file) {
        $theFile = explode("/", $file);
        $path_count = count($theFile);
        while ($path_count > 0) {
            $path = $theFile[$path_count - 1];
            $len = count($this->avoidFiles);
            for ($index = 0; $index < $len; $index++) {
                if ($path == $this->avoidFiles[$index]) {
                    $this->avoidFile = true;
                    break;
                }
            }
            if ($this->avoidFile != false) {
                break;
            }
            $path_count--;
        }
        if (is_file($file) && !is_dir($file)) {
            $this->isFile = true;
        }
    }

}
