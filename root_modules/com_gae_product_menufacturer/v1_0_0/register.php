<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 12
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "Manufacturer",
            "image" => array(
                "normal" => $curModule->file_url . "icon/btn_dashboard_product_manufacturer.png",
                "hover" => $curModule->file_url . "icon/btn_dashboard_product_manufacturer_over.png",
                "active" => $curModule->file_url . "icon/btn_dashboard_product_manufacturer_active.png",
                "selected" => $curModule->file_url . "icon/btn_dashboard_product_manufacturer_active.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "Manufacturer",
            "primary_image" => $curModule->file_url . "icon/icon_dashboard_product_manufacturer.png",
            "detail" => array(
                "name" => "Manufacturer",
                "title_1" => "หน้าแสดงรายชื่อผู้ผลิตสินค้า",
                "title_2" => "เพิ่ม ลบ แก้ไขชื่อและโลโก้ของ ผู้ผลิตสินค้าได้ที่เมนูนี้ี้"
            )
        )
    )
);
