<?php
echo '<link rel="stylesheet" href="', $curModule->file_url, 'css/base.css">';
// Include css
if (!empty($viewData['css'])) {
    foreach ($viewData['css'] as $value) {
        echo '<link rel="stylesheet" href="', $curModule->file_url, 'css/', $value, '">';
    }
}
// Main content
echo $viewData['content'];
// Include js
echo '<script src="' , base_ngservices_url() , 'GAEAPI.js"></script>';
echo '<script src="' , $curModule->file_url , 'js/third_party/angular-file-model-min.js"></script>';
echo '<script src="' , $curModule->file_url , 'js/third_party/dirPagination.js"></script>';
echo '<script src="' , $curModule->file_url , 'js/third_party/jquery-ui.min.js"></script>';
echo '<script src="' , $curModule->file_url , 'js/shared/common.js"></script>';
echo '<script src="' , $curModule->file_url , 'js/app.module.js"></script>';
if (!empty($viewData['js'])) {
    foreach ($viewData['js'] as $value) {
        echo '<script src="' , $curModule->file_url , 'js/' , $value , '"></script>';
    }
}
