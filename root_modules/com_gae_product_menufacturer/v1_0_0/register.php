<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 12
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "Brand",
            "image" => array(
                "normal" => $curModule->file_url . "icon/btn_dashboard_product_brands.png",
                "hover" => $curModule->file_url . "icon/btn_dashboard_product_brands_over.png",
                "active" => $curModule->file_url . "icon/btn_dashboard_product_brands_active.png",
                "selected" => $curModule->file_url . "icon/btn_dashboard_product_brands_active.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "Brands",
            "primary_image" => $curModule->file_url . "icon/icon_dashboard_product_brands.png",
            "detail" => array(
                "name" => "Brand",
                "title_1" => "หน้าแสดงยี่ห้อสินค้า",
                "title_2" => "เพิ่ม ลบ แก้ไข ใส่รูปโลโก้ยี่ห้อ หรือแบนด์สินค้าได้ที่เมนูนี้"
            )
        )
    )
);
