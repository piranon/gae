<?php

class Extra_field_model extends base_module_model
{
    /**
     * @param int $row_id
     * @param int $table_id
     * @param string $label_color
     * @param string $font_color
     * @return boolean
     */
    public function insert_color($row_id, $table_id, $label_color, $font_color)
    {
        $data = array(
            array(
                'holder_object_table_id' => $table_id,
                'holder_object_id' => $row_id,
                'field_name' => 'label_color',
                'field_value' => $label_color,
                'create_time' => time()
            ),
            array(
                'holder_object_table_id' => $table_id,
                'holder_object_id' => $row_id,
                'field_name' => 'font_color',
                'field_value' => $font_color,
                'create_time' => time()
            )
        );
        return $this->db->insert_batch('extra_field', $data);
    }
}
