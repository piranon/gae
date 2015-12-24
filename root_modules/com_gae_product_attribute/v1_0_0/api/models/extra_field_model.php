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

    /**
     * @param int $row_id
     * @param int $table_id
     * @param string $label_color
     * @param string $font_color
     */
    public function update_color($row_id, $table_id, $label_color, $font_color)
    {
        $flag_update = [];

        $extra_fields = $this->get_extra_fields($table_id, $row_id);

        foreach ($extra_fields as $extra_field) {
            $update = [
                'update_time' => time()
            ];
            if ($label_color && $extra_field['field_name'] == 'label_color') {
                $update['field_name'] = 'label_color';
                $update['field_value'] = $label_color;
                $this->db->where('extra_field_id', $extra_field['extra_field_id']);
                $this->db->update('extra_field', $update);
                $this->db->affected_rows();
                $flag_update[] = 'label_color';
            }
            if ($font_color && $extra_field['field_name'] == 'font_color') {
                $update['field_name'] = 'font_color';
                $update['field_value'] = $font_color;
                $this->db->where('extra_field_id', $extra_field['extra_field_id']);
                $this->db->update('extra_field', $update);
                $this->db->affected_rows();
                $flag_update[] = 'font_color';
            }
        }

        $insert = [
            'holder_object_table_id' => $table_id,
            'holder_object_id' => $row_id,
            'field_name' => '',
            'field_value' => '',
            'create_time' => time()
        ];

        if ($label_color && !in_array('label_color', $flag_update)) {
            $insert['field_name'] = 'label_color';
            $insert['field_value'] = $label_color;
            $this->db->insert('extra_field', $insert);
        }
        if ($font_color && !in_array('font_color', $flag_update)) {
            $insert['field_name'] = 'label_color';
            $insert['field_value'] = $font_color;
            $this->db->insert('extra_field', $insert);
        }
    }

    public function get_extra_fields($table_id, $row_id)
    {
        $this->db->from('extra_field');
        $this->db->where('extra_field.holder_object_table_id', $table_id);
        $this->db->where('extra_field.holder_object_id', $row_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
