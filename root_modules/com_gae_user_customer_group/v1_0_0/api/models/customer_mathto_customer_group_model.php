<?php

class Customer_mathto_customer_group_model extends base_module_model
{
    /**
     * @param int $customer_group_id
     * @param string $group_customer_ids
     * @return array
     * @throws Exception
     */
    public function createInsertData($customer_group_id, $group_customer_ids)
    {
        $customer_ids = explode(',', $group_customer_ids);

        if (!is_array($customer_ids) || count($customer_ids) <= 0) {
            throw new Exception('Invalid customer id in the group');
        }

        $matchTo = [];
        $createTime = time();

        foreach ($customer_ids as $customer_id) {
            $matchTo[] = [
                'customer_group_id' => $customer_group_id,
                'customer_id' => $customer_id,
                'create_time' => $createTime
            ];
        }

        return $matchTo;
    }

    /**
     * @param array $mathTo
     * @return int
     * @throws Exception
     */
    public function insert_batch($mathTo)
    {
        $this->db->insert_batch('customer_mathto_customer_group', $mathTo);
        $result = $this->db->affected_rows();

        if (!$result) {
            throw new Exception('Cannot insert customer math to customer group data');
        }

        return $result;
    }

    /**
     * @param int $group_id
     * @return int
     */
    public function count_customer($group_id)
    {
        $this->db->where('customer_group_id', $group_id);
        $this->db->from('customer_mathto_customer_group');
        return $this->db->count_all_results();
    }

    /**
     * @param int $group_id
     * @return array
     */
    public function get_customers($group_id)
    {
        $this->db->select([
            'customer.customer_id',
            'customer.user_name',
            'customer.first_name',
            'customer.last_name',
            'customer.birthday',
            'customer.gender_type_id',
            'customer.email',
            'customer.phone',
            'customer.tag',
            'customer.create_time',
            'customer.update_time',
            'image.image_id',
            'image.file_name',
            'image.file_dir'
        ]);
        $this->db->from('customer_mathto_customer_group');
        $this->db->join('customer', 'customer.customer_id = customer_mathto_customer_group.customer_id', 'left');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = customer.customer_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('customer_mathto_customer_group.customer_group_id', $group_id);
        $this->db->where('customer.status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}
