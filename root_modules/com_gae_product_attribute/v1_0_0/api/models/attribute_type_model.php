<?php
 
class Attribute_type_model extends base_module_model
{
    public function get_attribute_type_id($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('attribute_type');
        $result = $query->row_array();

        if (!isset($result['attribute_type_id'])) {
            throw new Exception('Cannot get attribute type id');
        }

        return $result['attribute_type_id'];
    }
}
