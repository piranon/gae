<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 12
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "Category",
            "image" => array(
                "normal" => $curModule->file_url . "icon/btn_dashboard_product_category.png",
                "hover" => $curModule->file_url . "icon/btn_dashboard_product_category_over.png",
                "active" => $curModule->file_url . "icon/btn_dashboard_product_category_active.png",
                "selected" => $curModule->file_url . "icon/btn_dashboard_product_category_active.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "Category",
            "primary_image" => $curModule->file_url . "icon/icon_dashboard_product_category.png",
            "detail" => array(
                "name" => "Category",
                "title_1" => "หน้าแสดงหมวดสินค้า",
                "title_2" => "เพิ่ม ลบ แก้ไขหมวดสินค้าหลัก และหมวดสินค้าย่อยได้ที่เมนูนี้"
            )
        )
    )
);
