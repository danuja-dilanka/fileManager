<?php

namespace fileManger;

class fileManger {

    protected $dir, $files;

    function __construct($dir) {
        if (is_dir($dir)) {
            $this->dir = $dir;
        } else {
            $this->dir = '.';
        }
        $this->getFiles();
    }

    protected function getFiles($sort = SCANDIR_SORT_ASCENDING) {
        $this->files = scandir($this->dir, $sort);
    }

}
