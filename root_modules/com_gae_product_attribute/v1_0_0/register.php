<?php

$config = array(
    "injection" => array(
        "sub_menu_id" => 12
    ),
    "menu_display" => array(
        "addon_menu" => array(
            "label" => "Attribute",
            "image" => array(
                "normal" => $curModule->file_url . "icon/btn_dashboard_product_attribute.png",
                "hover" => $curModule->file_url . "icon/btn_dashboard_product_attribute_over.png",
                "active" => $curModule->file_url . "icon/btn_dashboard_product_attribute_active.png",
                "selected" => $curModule->file_url . "icon/btn_dashboard_product_attribute_active.png"
            )
        ),
        "addon_card_info" => array(
            "label" => "Attribute",
            "primary_image" => $curModule->file_url . "icon/icon_dashboard_product_attribute.png",
            "detail" => array(
                "name" => "Attribute",
                "title_1" => "หน้าจัดการคุณสมบัติสินค้า",
                "title_2" => "สร้าง ลบ แก้ไข กลุ่มคุณสมบัติเพื่อแสดงผลในหน้ารายละเอียดสินค้าแต่ละตัว"
            )
        )
    )
);
