<?php

class Customer_mathto_customer_group_model extends base_module_model
{
    /**
     * @param int $customer_id
     * @return array
     */
    public function get_customers($customer_id)
    {
        $this->db->select([
            'customer_group.customer_group_id',
            'customer_group.name'
        ]);
        $this->db->from('customer_mathto_customer_group');
        $this->db->join(
            'customer_group',
            'customer_group.customer_group_id = customer_mathto_customer_group.customer_group_id',
            'left'
        );
        $this->db->where('customer_mathto_customer_group.customer_id', $customer_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
