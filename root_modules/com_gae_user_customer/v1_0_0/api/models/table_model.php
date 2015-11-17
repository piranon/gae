<?php
 
class Table_model extends base_module_model
{

    public function get_table_id($code_name)
    {
        $this->db->where('code_name', $code_name);
        $query = $this->db->get('table');
        $result = $query->row_array();
        return isset($result['table_id']) ? $result['table_id'] : null;
    }
}
