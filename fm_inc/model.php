<!-- Modal -->
<div class="modal fade" id="fileExplore" tabindex="-1" role="dialog" aria-labelledby="fileExplore" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileExplore_title">File Explore</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center alert alert-warning" id="toPath">Select Destination Folder</p>
                <div class="row col-sm-12 mt-1 mb-1">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Folder Name</th>
                            </tr>
                        </thead>
                        <tbody id='window_getFiles'>
                            <?php
                            $files = scandir($dir);
                            $file_count = 1;
                            if ($from_folder != false) {
                                ?>
                                <tr class="bg bg-light">
                                    <td><a id="<?= $from ?>" href="#" class="dataURL">...</a></td>
                                </tr>
                                <?php
                            }
                            for ($index = 2; $index < count($files); $index++) {
                                $filePath = $dir . "/" . $files[$index];
                                $file = new file($filePath);
                                if (!$file->avoidFile) {
                                    if (!$file->isFile) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a id="<?= $filePath ?>" href="#" class="dataURL"><?= $files[$index] ?></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $file_count++;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>  
            </div>
            <div class="modal-footer">
                <input type="text" class="form-control border border-warning" placeholder="File Name" id="c_fileName" onclick="$(this).removeAttr('readonly')" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="modifyFile()" class="btn btn-primary" id="fileExplore_btn">Save</button>
            </div>
        </div>
    </div>
</div>