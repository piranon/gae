<?php

class Customer_group_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @return array
     */
    public function get_customer_groups()
    {
        $this->db->from('customer_group');
        $this->db->where('status', Customer_group_model::STATUS_ACTIVE);
        $this->db->order_by('create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
}
