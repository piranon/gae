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

    public function update($customer_group, $customer_group_id)
    {
        $this->db->where('customer_group_id', $customer_group_id);
        $this->db->update('customer_group', array_filter($customer_group));

        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot update customer group data');
        }

        return $result;
    }


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

    /**
     * @param array $customer_group_ids
     * @return array
     * @throws Exception
     */
    public function batch_delete($customer_group_ids)
    {
        $this->db->where_in('customer_group_id', $customer_group_ids);
        $this->db->update('customer_group', ['status' => Customer_group_model::STATUS_INACTIVE]);
        $result = $this->db->affected_rows();

        if (!$result){
            throw new Exception('Cannot delete customer group data');
        }

        return $result;
    }

    /**
     * @param int $customer_group_id
     * @return array
     */
    public function get_group_by_id($customer_group_id)
    {
        $this->db->from('customer_group');
        $this->db->where('status', Customer_group_model::STATUS_ACTIVE);
        $this->db->where('customer_group_id', $customer_group_id);
        $query = $this->db->get();
        return $query->row_array();
    }
}
