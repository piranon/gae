<?php
 
class Table_model extends base_module_model
{

    public function get_table_id($code_name)
    {
        $this->db->where('code_name', $code_name);
        $query = $this->db->get('table');
        $result = $query->row_array();

        if (!isset($result['table_id'])) {
            throw new Exception('Cannot get table id');
        }

        return $result['table_id'];
    }
}
