<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 10
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "Staff Group",
            "image" => array(
                "normal" => $curModule->file_url . "icon/btn_dashboard_home_staffgroup.png",
                "hover" => $curModule->file_url . "icon/btn_dashboard_home_staffgroup_over.png",
                "active" => $curModule->file_url . "icon/btn_dashboard_home_staffgroup_active.png",
                "selected" => $curModule->file_url . "icon/btn_dashboard_home_staffgroup_active.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "Staff Group",
            "primary_image" => $curModule->file_url . "icon/icon_dashboard_home_staffgroup.png",
            "detail" => array(
                "name" => "Staff Group",
                "title_1" => "หน้าแสดงสิทธ์การเข้าถึงของร้านทั้งหมด"
            )
        )
    )
);
