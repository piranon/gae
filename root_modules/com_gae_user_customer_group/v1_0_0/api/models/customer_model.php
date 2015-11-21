<?php

class Customer_model extends base_module_model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /** @var array */
    private $customer_select_fields;

    public function __construct()
    {
        parent::__construct();
        $this->customer_select_fields = [
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
        ];
    }

    /**
     * @return array
     */
    public function get_customers()
    {
        $this->db->select(implode(', ', $this->customer_select_fields));
        $this->db->from('customer');
        $this->db->join('image_matchto_object', 'image_matchto_object.holder_object_id = customer.customer_id', 'left');
        $this->db->join('image', 'image.image_id = image_matchto_object.image_id', 'left');
        $this->db->where('customer.status', Customer_model::STATUS_ACTIVE);
        $this->db->order_by('customer.create_time', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
}
