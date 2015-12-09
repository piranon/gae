<?php

class Staff_group_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @return array
     */
    public function get_staff_groups()
    {
        $this->db->from('staff_group');
        $this->db->where('status', Staff_group_model::STATUS_ACTIVE);
        $this->db->order_by('create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
}
