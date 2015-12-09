<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 10
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "GAEUI",
            "image" => array(
                "normal" => $curModule->file_url . "icon/logo-mask.png",
                "hover" => $curModule->file_url . "icon/logo-mask.png",
                "active" => $curModule->file_url . "icon/logo-mask.png",
                "selected" => $curModule->file_url . "icon/logo-mask.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "GAEUI",
            "primary_image" => $curModule->file_url . "icon/logo-mask.png",
            "detail" => array(
                "name" => "GAEUI",
                "title_1" => "ตัวอย่าง ui"
            )
        )
    )
);
