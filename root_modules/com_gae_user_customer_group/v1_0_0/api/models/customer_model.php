<?php

class Customer_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
    public function get_customers()
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
            'customer.update_time'
        ]);
        $this->db->from('customer');
        $this->db->where('customer.status', Customer_model::STATUS_ACTIVE);
        $this->db->order_by('customer.create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
}
