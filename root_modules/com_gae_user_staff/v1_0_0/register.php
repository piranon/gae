<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 10
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "Staff",
            "image" => array(
                "normal" => $curModule->file_url . "icon/btn_dashboard_home_staff.png",
                "hover" => $curModule->file_url . "icon/btn_dashboard_home_staff_over.png",
                "active" => $curModule->file_url . "icon/btn_dashboard_home_staff_active.png",
                "selected" => $curModule->file_url . "icon/btn_dashboard_home_staff_active.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "Staff",
            "primary_image" => $curModule->file_url . "icon/icon_dashboard_home_staff.png",
            "detail" => array(
                "name" => "Staff",
                "title_1" => "หน้าแสดงบุคลากรของร้านทั้งหมด"
            )
        )
    )
);
