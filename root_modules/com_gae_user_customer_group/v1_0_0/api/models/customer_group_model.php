<?php

class Customer_group_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @param array $customer_group
     * @return int
     * @throws Exception
     */
    public function insert($customer_group)
    {
        $this->db->insert('customer_group', array_filter($customer_group));
        $customer_id = $this->db->insert_id();

        if (!$customer_id) {
            throw new Exception('Cannot insert customer group data');
        }

        return $customer_id;
    }
}
