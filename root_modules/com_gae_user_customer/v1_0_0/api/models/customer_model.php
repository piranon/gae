<?php
 
class Customer_model extends base_module_model
{

    public function insert($customer)
    {
        $this->db->insert('customer', $customer);
        return $this->db->insert_id();
    }

    public function get_customer_by_id($id)
    {
        $this->db->where('customer_id', $id);
        $query = $this->db->get('customer');
        return $query->row_array();
    }
}
