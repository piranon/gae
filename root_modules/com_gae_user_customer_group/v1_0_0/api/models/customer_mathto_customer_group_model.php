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
}
