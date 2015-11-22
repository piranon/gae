<?php

class Customer_mathto_customer_group_model extends base_module_model
{
    /**
     * @param array $mathto_customer
     * @return int
     * @throws Exception
     */
    public function insert($mathto_customer)
    {
        $this->db->insert('customer_mathto_customer_group', $mathto_customer);
        $id = $this->db->insert_id();

        if (!$id) {
            throw new Exception('Cannot insert group data');
        }

        return $id;
    }

    /**
     * @param int $customer_group_id
     * @param int $customer_id
     * @return bool
     */
    function create_mathto_customer_group($customer_group_id, $customer_id)
    {
        if (empty($customer_group_id)) {
            return false;
        }

        $this->db->where('customer_group_id', $customer_group_id);
        $this->db->where('customer_id', $customer_id);
        $qurey = $this->db->get('customer_mathto_customer_group');

        if ($qurey->num_rows() > 0) {
            $this->db->where('customer_group_id', $customer_group_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->update('customer_mathto_customer_group',[
                'customer_group_id' => $customer_group_id,
                'customer_id' => $customer_id,
                'update_time' => time()
            ]);
        } else {
            $this->db->insert('customer_mathto_customer_group', [
                'customer_group_id' => $customer_group_id,
                'customer_id' => $customer_id,
                'create_time' => time()
            ]);
        }

        return $this->db->affected_rows();
    }

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
