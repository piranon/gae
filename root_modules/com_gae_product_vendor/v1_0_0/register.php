<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 12
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "Vendor",
            "image" => array(
                "normal" => $curModule->file_url . "icon/btn_dashboard_product_vendor.png",
                "hover" => $curModule->file_url . "icon/btn_dashboard_product_vendor_over.png",
                "active" => $curModule->file_url . "icon/btn_dashboard_product_vendor_active.png",
                "selected" => $curModule->file_url . "icon/btn_dashboard_product_vendor_active.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "Vendor",
            "primary_image" => $curModule->file_url . "icon/icon_dashboard_product_vendor.png",
            "detail" => array(
                "name" => "Vendor",
                "title_1" => "หน้าแสดงรายชื่อผู้จัดจำหน่าย",
                "title_2" => "เพิ่ม ลบ แก้ไขชื่อและโลโก้ของผู้จัดจำหน่ายสินค้าได้ที่เมนูนี้"
            )
        )
    )
);
