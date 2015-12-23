<?php
 
class Referral_type_model extends base_module_model
{
    public function get_referral_type_id($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('referral_type');
        $result = $query->row_array();

        if (!isset($result['referral_type_id'])) {
            throw new Exception('Cannot get referral type id');
        }

        return $result['referral_type_id'];
    }
}
